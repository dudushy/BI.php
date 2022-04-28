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

			#dk {
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
				//document.getElementById("ano").max = new Date().getFullYear();
				var period = document.getElementById("period").value;
				
				console.log(period);
			});

			function sleep(ms) {
				return new Promise(
					resolve => setTimeout(resolve, ms)
				);
			}

			async function generateCompanyGroups() {
				var area_id = document.getElementById("area_id").value;
				var chart_data = [];

				$.post('<?php echo base_url(); ?>DK/getCompanyGroups/' + area_id, function (data) {
					console.log(JSON.parse(data));

					var obj = JSON.parse(data)['data']['chart']['chart']['data'];
					console.log(obj);

					Object.keys(obj).forEach(function(item) {
						console.log(obj[item]);

						var random_number = Math.floor(Math.random() * 51);
						var original_number = obj[item]['rate'];

						console.log("original: " + original_number + " | random: " + random_number);

						chart_data.push({
							// id: obj[item]['id'],
							description: obj[item]['description'],
							rate: Math.floor(Math.random() * 51), //! obj[item]['rate']
							total_companies: obj[item]['total_companies']
						});

						console.log(chart_data);
					});

					var div = document.querySelector('#charts');
					var dk = document.createElement('div');
					dk.id = "dk_companyGroups";
					dk.style.width = "100%";
					dk.style.height = "1000px";
					div.appendChild(dk);

					am5.ready(function() {
						// Create root element
						// https://www.amcharts.com/docs/v5/getting-started/#Root_element
						var root = am5.Root.new("dk_companyGroups");

						// Set themes
						// https://www.amcharts.com/docs/v5/concepts/themes/
						root.setThemes([
							am5themes_Animated.new(root)
						]);

						// Create chart
						// https://www.amcharts.com/docs/v5/charts/xy-chart/
						var chart = root.container.children.push(am5xy.XYChart.new(root, {
							panX: false,
							panY: false,
							wheelX: "panX",
							wheelY: "zoomX",
							layout: root.verticalLayout
						}));

						// Add legend
						// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
						var legend = chart.children.push(am5.Legend.new(root, {
							centerX: am5.p50,
							x: am5.p50
						}))

						// Create axes
						// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
						var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
							categoryField: "description",
							renderer: am5xy.AxisRendererY.new(root, {
								inversed: true,
								cellStartLocation: 0.1,
								cellEndLocation: 0.9
							})
						}));

						yAxis.data.setAll(chart_data);

						var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
							renderer: am5xy.AxisRendererX.new(root, {}),
							min: 0
						}));

						// Add series
						// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
						function createSeries(field, name) {
							var series = chart.series.push(am5xy.ColumnSeries.new(root, {
								name: name,
								xAxis: xAxis,
								yAxis: yAxis,
								valueXField: field,
								categoryYField: "description",
								sequencedInterpolation: true,
								tooltip: am5.Tooltip.new(root, {
									pointerOrientation: "horizontal",
									labelText: "[bold]{name}[/]\n{categoryY}: {valueX}"
								})
							}));

							series.columns.template.setAll({
								height: am5.p100
							});

							series.bullets.push(function() {
								return am5.Bullet.new(root, {
									locationX: 1,
									locationY: 0.5,
									sprite: am5.Label.new(root, {
										centerY: am5.p50,
										text: "{valueX}",
										populateText: true
									})
								});
							});

							series.bullets.push(function() {
								return am5.Bullet.new(root, {
									locationX: 1,
									locationY: 0.5,
									sprite: am5.Label.new(root, {
										centerX: am5.p100,
										centerY: am5.p50,
										text: "{name}",
										fill: am5.color(0xffffff),
										populateText: true
									})
								});
							});

							series.data.setAll(chart_data);
							series.appear();

							return series;
						}

						// createSeries("description", "description");
						createSeries("rate", "rate");
						createSeries("total_companies", "total_companies");

						// Add legend
						// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
						var legend = chart.children.push(am5.Legend.new(root, {
							centerX: am5.p50,
							x: am5.p50
						}));

						legend.data.setAll(chart.series.values);

						// Add cursor
						// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
						var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
							behavior: "zoomY"
						}));
						cursor.lineY.set("forceHidden", true);
						cursor.lineX.set("forceHidden", true);

						// Make stuff animate on load
						// https://www.amcharts.com/docs/v5/concepts/animations/
						chart.appear(1000, 100);
					});
				})
			}

			async function generateCompany() {
				var period = document.getElementById("period").value;
				var parent_item_id = document.getElementById("parent_item_id").value;
				var area_id = document.getElementById("area_id").value;
				var chart_data = [];

				$.post('<?php echo base_url(); ?>DK/getCompany/' + period + "/" + parent_item_id + "/" + area_id, function (data) {
					console.log(JSON.parse(data));

					var obj = JSON.parse(data)['data']['chart']['chart']['data'];
					console.log(obj);

					Object.keys(obj).forEach(function(item) {
						console.log(obj[item]);

						var random_number = Math.floor(Math.random() * 51);
						var original_number = obj[item]['rate'];

						console.log("original: " + original_number + " | random: " + random_number);

						chart_data.push({
							// id: obj[item]['id'],
							description: obj[item]['description'],
							rate: random_number //! obj[item]['rate']
						});

						console.log(chart_data);
					});

					var div = document.querySelector('#charts');
					var dk = document.createElement('div');
					dk.id = "dk_company";
					dk.style.width = "100%";
					dk.style.height = "500px";
					div.appendChild(dk);

					am5.ready(function() {
						// Create root element
						// https://www.amcharts.com/docs/v5/getting-started/#Root_element
						var root = am5.Root.new("dk_company");

						// Set themes
						// https://www.amcharts.com/docs/v5/concepts/themes/
						root.setThemes([
							am5themes_Animated.new(root)
						]);

						// Create chart
						// https://www.amcharts.com/docs/v5/charts/xy-chart/
						var chart = root.container.children.push(am5xy.XYChart.new(root, {
							panX: false,
							panY: false,
							wheelX: "panX",
							wheelY: "zoomX",
							layout: root.verticalLayout
						}));

						// Add legend
						// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
						var legend = chart.children.push(am5.Legend.new(root, {
							centerX: am5.p50,
							x: am5.p50
						}))

						// Create axes
						// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
						var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
							categoryField: "description",
							renderer: am5xy.AxisRendererY.new(root, {
								inversed: true,
								cellStartLocation: 0.1,
								cellEndLocation: 0.9
							})
						}));

						yAxis.data.setAll(chart_data);

						var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
							renderer: am5xy.AxisRendererX.new(root, {}),
							min: 0
						}));

						// Add series
						// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
						function createSeries(field, name) {
							var series = chart.series.push(am5xy.ColumnSeries.new(root, {
								name: name,
								xAxis: xAxis,
								yAxis: yAxis,
								valueXField: field,
								categoryYField: "description",
								sequencedInterpolation: true,
								tooltip: am5.Tooltip.new(root, {
									pointerOrientation: "horizontal",
									labelText: "[bold]{name}[/]\n{categoryY}: {valueX}"
								})
							}));

							series.columns.template.setAll({
								height: am5.p100
							});

							series.bullets.push(function() {
								return am5.Bullet.new(root, {
									locationX: 1,
									locationY: 0.5,
									sprite: am5.Label.new(root, {
										centerY: am5.p50,
										text: "{valueX}",
										populateText: true
									})
								});
							});

							series.bullets.push(function() {
								return am5.Bullet.new(root, {
									locationX: 1,
									locationY: 0.5,
									sprite: am5.Label.new(root, {
										centerX: am5.p100,
										centerY: am5.p50,
										text: "{name}",
										fill: am5.color(0xffffff),
										populateText: true
									})
								});
							});

							series.data.setAll(chart_data);
							series.appear();

							return series;
						}

						// createSeries("description", "description");
						createSeries("rate", "rate");

						// Add legend
						// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
						var legend = chart.children.push(am5.Legend.new(root, {
							centerX: am5.p50,
							x: am5.p50
						}));

						legend.data.setAll(chart.series.values);

						// Add cursor
						// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
						var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
							behavior: "zoomY"
						}));
						cursor.lineY.set("forceHidden", true);
						cursor.lineX.set("forceHidden", true);

						// Make stuff animate on load
						// https://www.amcharts.com/docs/v5/concepts/animations/
						chart.appear(1000, 100);
					});
				})
			}

			async function generateChapter() {
				var period = document.getElementById("period").value;
				var parent_item_id = document.getElementById("parent_item_id").value;
				var area_id = document.getElementById("area_id").value;

				$.post('<?php echo base_url(); ?>DK/getChapter/' + period + "/" + parent_item_id + "/" + area_id, function (data) {
					console.log(JSON.parse(data));

					var obj = JSON.parse(data);
				})
			}
		</script>
	</head>
	<body>
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
		<div id="container">
			<h2>DK</h2>
			<br>

			<div class="col-md-12">
				<div id="filters">
					<label for="period" class="form-label" style="text-align: center;">
						<b>Período</b>
					</label>
					<input type="month" class="form-control" id="period" name="period" min="2018-03" value="2022-02">

					<label for="parent_item_id" class="form-label" style="text-align: center;">
						<b>Item Pai ID</b>
					</label>
					<input type="number" class="form-control" id="parent_item_id" name="parent_item_id" value="2">

					<label for="area_id" class="form-label" style="text-align: center;">
						<b>Area ID</b>
					</label>
					<input type="number" class="form-control" id="area_id" name="area_id" value="127">

					<button class="btn btn-primary" onclick="generateCompanyGroups()">
						Gerar DK CompanyGroups
					</button>
					<br><br>

					<button class="btn btn-primary" onclick="generateCompany()">
						Gerar DK Company
					</button>
					<br><br>

					<button class="btn btn-primary" onclick="generateChapter()">
						Gerar DK Chapter
					</button>
					<br><br>
				</div>

				<br>
				
				<div id="charts" class="container-fluid"></div>
			</div>
		</div>
		<footer style="text-align: center;">
			<hr style="border-top: 10px solid;">
			&copy; 2022 | All Rights Reserved
		</footer>
	</body>
</html>
