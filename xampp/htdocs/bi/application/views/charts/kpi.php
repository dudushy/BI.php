<!DOCTYPE html>
<html>
	<head>
		<title>BI.php</title>
		<link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.css') ?>"/>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		<script src="<?php echo base_url('public/js/bootstrap.js')?>"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

		<!-- Styles -->
		<style>
			/* #filters {
				float: left;
			} */

			/* #charts {
				float: right;
			} */

			#kpi {
				width: 50%;
				height: 400px;
			}
		</style>

		<!-- Resources -->
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

		<!-- Chart code -->
		<script>
			$(document).ready(function () {
				//test()
			});

			function sleep(ms) {
				return new Promise(
					resolve => setTimeout(resolve, ms)
				);
			}

			async function generateKpi() {
				var inputs = {
					"ano": document.getElementById("date").value.split("-")[0],
					"mes": document.getElementById("date").value.split("-")[1]
				};
				
				console.log(inputs);
				
				$.post('<?php echo base_url(); ?>KPI/getKpi/' + inputs['ano'] + '/' + inputs['mes'], function (data) {
					//console.log(data);
					var obj = JSON.parse(data);
					console.log(obj);
					console.log(obj['data']);

					am5.ready(function() {
						// Create root element
						// https://www.amcharts.com/docs/v5/getting-started/#Root_element
						var root = am5.Root.new("iso_groups");

						// Set themes
						// https://www.amcharts.com/docs/v5/concepts/themes/
						root.setThemes([am5themes_Animated.new(root)]);

						// Create chart
						// https://www.amcharts.com/docs/v5/charts/xy-chart/
						var chart = root.container.children.push(
							am5xy.XYChart.new(root, {
								panX: false,
								panY: false,
								wheelX: "none",
								wheelY: "none"
							})
						);


						// Create axes
						// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
						var yRenderer = am5xy.AxisRendererY.new(root, { minGridDistance: 30 });

						var yAxis = chart.yAxes.push(
							am5xy.CategoryAxis.new(root, {
								maxDeviation: 0,
								categoryField: "nome_grupo",
								renderer: yRenderer
							})
						);

						var xAxis = chart.xAxes.push(
							am5xy.ValueAxis.new(root, {
								maxDeviation: 0,
								min: 0,
								renderer: am5xy.AxisRendererX.new(root, {})
							})
						);


						// Create series
						// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
						var series = chart.series.push(
							am5xy.ColumnSeries.new(root, {
								name: "Series 1",
								xAxis: xAxis,
								yAxis: yAxis,
								valueXField: "valor",
								sequencedInterpolation: true,
								categoryYField: "nome_grupo"
							})
						);

						var columnTemplate = series.columns.template;

						columnTemplate.setAll({
							draggable: true,
							cursorOverStyle: "pointer",
							tooltipText: "drag to rearrange",
							cornerRadiusBR: 10,
							cornerRadiusTR: 10
						});
						columnTemplate.adapters.add("fill", (fill, target) => {
							return chart.get("colors").getIndex(series.columns.indexOf(target));
						});

						columnTemplate.adapters.add("stroke", (stroke, target) => {
							return chart.get("colors").getIndex(series.columns.indexOf(target));
						});

						columnTemplate.events.on("dragstop", () => {
							sortCategoryAxis();
						});

						// Get series item by category
						function getSeriesItem(category) {
							for (var i = 0; i < series.dataItems.length; i++) {
								var dataItem = series.dataItems[i];
								if (dataItem.get("categoryY") == category) {
									return dataItem;
								}
							}
						}


						// Axis sorting
						function sortCategoryAxis() {
							// Sort by value
							series.dataItems.sort(function (x, y) {
								return y.get("graphics").y() - x.get("graphics").y();
							});

							var easing = am5.ease.out(am5.ease.cubic);

							// Go through each axis item
							am5.array.each(yAxis.dataItems, function (dataItem) {
								// get corresponding series item
								var seriesDataItem = getSeriesItem(dataItem.get("category"));

								if (seriesDataItem) {
									// get index of series data item
									var index = series.dataItems.indexOf(seriesDataItem);

									var column = seriesDataItem.get("graphics");

									// position after sorting
									var fy = yRenderer.positionToCoordinate(yAxis.indexToPosition(index)) - column.height() / 2;

									// set index to be the same as series data item index
									if (index != dataItem.get("index")) {
										dataItem.set("index", index);

										// current position
										var x = column.x();
										var y = column.y();

										column.set("dy", - (fy - y));
										column.set("dx", x);

										column.animate({ key: "dy", to: 0, duration: 600, easing: easing });
										column.animate({ key: "dx", to: 0, duration: 600, easing: easing });
									} else {
										column.animate({ key: "y", to: fy, duration: 600, easing: easing });
										column.animate({ key: "x", to: 0, duration: 600, easing: easing });
									}
								}
							});

							// Sort axis items by index.
							// This changes the order instantly, but as dx and dy is set and animated,
							// they keep in the same places and then animate to true positions.
							yAxis.dataItems.sort(function (x, y) {
								return x.get("index") - y.get("index");
							});
						}

						yAxis.data.setAll(obj['data']);
						series.data.setAll(obj['data']);

						// Make stuff animate on load
						// https://www.amcharts.com/docs/v5/concepts/animations/
						series.appear(1000);
						chart.appear(1000, 100);

					}); // end am5.ready()
				});
			}
		</script>
	</head>
	<body>
		<div id="container">
			<header>
				<nav class="navbar navbar-expand-lg navbar-light bg-light">
					<div class="container-fluid">
						<a class="navbar-brand" href="<?php echo base_url(''); ?>">
							BI.php
						</a>

						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>

						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">
								<li class="nav-item">
									<a class="nav-link" href="https://github.com/dudushy/BI.php" target="_blank">
										GitHub
									</a>
								</li>
							</ul>

							<form class="d-flex">
								<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
								
								<button class="btn btn-outline-success" type="submit">
									Search
								</button>
							</form>
						</div>
					</div>
				</nav>
			</header>

			<div class="col-md-12">
				<div id="filters">
					<label for="date" class="form-label">
						<center>
							<b>Data</b>
						</center>
					</label>
					<input type="month" class="form-control" id="date" name="date" min="2018-03" value="2022-02">
					<select id="select-company" class="form-select">
						<?php foreach ($this->Model_KPI->readCompaniesByName($ano) as $company){ ?>
							<option value="<?php echo $company->com_id ?>"><?php echo $company->com_name ?></option>
						<?php } ?>
					</select>
					<button class="btn btn-primary" onclick="generateKpi()">
						Gerar KPI
					</button>
					<br><br>
				</div>

				<br>
				
				<div id="charts" class="container-fluid">
					<div id="kpi"></div>
				</div>
			</div>
		</div>
		<div>
			<hr style="border-top: 10px solid">
			&copy; 2022 | All Rights Reserved
		</div>
	</body>
</html>
