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
				document.getElementById("ano").max = new Date().getFullYear();
			});

			function sleep(ms) {
				return new Promise(
					resolve => setTimeout(resolve, ms)
				);
			}

			async function generateKpi() {
				var ano = document.getElementById("ano").value;
				var com_id = document.getElementById("select-company").value
				var chart_data = [];
				
				console.log("com_id: "+ com_id + "| ano: " + ano);

				$.post('<?php echo base_url(); ?>KPI/get/' + com_id + '/' + ano, function (data) {
					console.log(JSON.parse(data));

					var obj = JSON.parse(data)['data']['years'][ano];
					console.log(obj);

					Object.keys(obj).forEach(function(item) {
						console.log(obj[item]);

						chart_data.push({
							month: item,
							tus: obj[item]['tus'],
							m3_water: obj[item]['m3_water'],
							m3_well: obj[item]['m3_well'],
							m3_cistern: obj[item]['m3_cistern'],
							m3_water_total: obj[item]['m3_water_total'],
							m3_water_tus: obj[item]['m3_water_tus'],
							m3_well_tus: obj[item]['m3_well_tus'],
							m3_cistern_tus: obj[item]['m3_cistern_tus'],
							m3_water_total_tus: obj[item]['m3_water_total_tus'],
							value_water: obj[item]['value_water'],
							kwh_energy: obj[item]['kwh_energy'],
							kwh_energy_tus: obj[item]['kwh_energy_tus'],
							value_energy: obj[item]['value_energy'],
							total_recyclable: obj[item]['total_recyclable'],
							total_contaminated: obj[item]['total_contaminated'],
							total_recyclable_tus: obj[item]['total_recyclable_tus'],
							total_contaminated_tus: obj[item]['total_contaminated_tus'],
							badgoal_m3_water_total: obj[item]['badgoal_m3_water_total'],
							badgoal_m3_water_total_tus: obj[item]['badgoal_m3_water_total_tus'],
							badgoal_kwh_energy: obj[item]['badgoal_kwh_energy'],
							badgoal_kwh_energy_tus: obj[item]['badgoal_kwh_energy_tus'],
							badgoal_recyclable_tus: obj[item]['badgoal_recyclable_tus'],
							badgoal_total_contaminated_tus: obj[item]['badgoal_total_contaminated_tus'],
							delayed_tus: obj[item]['delayed_tus'],
							delayed_m3_water: obj[item]['delayed_m3_water'],
							delayed_m3_well: obj[item]['delayed_m3_well'],
							delayed_m3_cistern: obj[item]['delayed_m3_cistern'],
							delayed_value_water: obj[item]['delayed_value_water'],
							delayed_kwh_energy: obj[item]['delayed_kwh_energy'],
							delayed_value_energy: obj[item]['delayed_value_energy'],
							delayed_total_recyclable: obj[item]['delayed_total_recyclable'],
							delayed_total_contaminated: obj[item]['delayed_total_contaminated'],
							unlocked: obj[item]['unlocked'],
							obs: obj[item]['obs'],
							iso14001: obj[item]['iso14001'],
							iso14001_validate_date: obj[item]['iso14001_validate_date'],
							iso14001_file: obj[item]['iso14001_file'],
							iso14001_file_path: obj[item]['iso14001_file_path'],
							inserted: obj[item]['inserted'],
							water_file: obj[item]['water_file'],
							water_file_path: obj[item]['water_file_path'],
							energy_file: obj[item]['energy_file'],
							energy_file_path: obj[item]['energy_file_path'],
							me_goal_water: obj[item]['me_goal_water'],
							me_goal_energy: obj[item]['me_goal_energy'],
							current: obj[item]['current'],
							permission: obj[item]['permission']
						});

						console.log(chart_data);
					});

					var div = document.querySelector('#charts');
					var kpi = document.createElement('div');
					kpi.id = "kpi";
					kpi.style.width = "100%";
					kpi.style.height = "1000px";
					div.appendChild(kpi);

					am5.ready(function() {
						// Create root element
						// https://www.amcharts.com/docs/v5/getting-started/#Root_element
						var root = am5.Root.new("kpi");

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
							categoryField: "month",
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
								categoryYField: "month",
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

						createSeries("tus", "tus");
						createSeries("m3_water", "m3_water");
						createSeries("m3_well", "m3_well");
						createSeries("m3_cistern", "m3_cistern");
						createSeries("m3_water_total", "m3_water_total");
						createSeries("m3_water_tus", "m3_water_tus");
						createSeries("m3_well_tus", "m3_well_tus");
						createSeries("m3_cistern_tus", "m3_cistern_tus");
						createSeries("m3_water_total_tus", "m3_water_total_tus");
						createSeries("value_water", "value_water");
						createSeries("kwh_energy", "kwh_energy");
						createSeries("kwh_energy_tus", "kwh_energy_tus");
						createSeries("value_energy", "value_energy");
						createSeries("total_recyclable", "total_recyclable");
						createSeries("total_contaminated", "total_contaminated");
						createSeries("total_recyclable_tus", "total_recyclable_tus");
						createSeries("total_contaminated_tus", "total_contaminated_tus");
						// createSeries("badgoal_m3_water_total", "badgoal_m3_water_total");
						// createSeries("badgoal_m3_water_total_tus", "badgoal_m3_water_total_tus");
						// createSeries("badgoal_kwh_energy", "badgoal_kwh_energy");
						// createSeries("badgoal_kwh_energy_tus", "badgoal_kwh_energy_tus");
						// createSeries("badgoal_recyclable_tus", "badgoal_recyclable_tus");
						// createSeries("badgoal_total_contaminated_tus", "badgoal_total_contaminated_tus");
						// createSeries("delayed_tus", "delayed_tus");
						// createSeries("delayed_m3_water", "delayed_m3_water");
						// createSeries("delayed_m3_well", "delayed_m3_well");
						// createSeries("delayed_m3_cistern", "delayed_m3_cistern");
						// createSeries("delayed_value_water", "delayed_value_water");
						// createSeries("delayed_kwh_energy", "delayed_kwh_energy");
						// createSeries("delayed_value_energy", "delayed_value_energy");
						// createSeries("delayed_total_recyclable", "delayed_total_recyclable");
						// createSeries("delayed_total_contaminated", "delayed_total_contaminated");
						// createSeries("unlocked", "unlocked");
						// createSeries("obs", "obs");
						createSeries("iso14001", "iso14001");
						// createSeries("iso14001_validate_date", "iso14001_validate_date");
						// createSeries("iso14001_file", "iso14001_file");
						// createSeries("iso14001_file_path", "iso14001_file_path");
						// createSeries("inserted", "inserted");
						// createSeries("water_file", "water_file");
						// createSeries("water_file_path", "water_file_path");
						// createSeries("energy_file", "energy_file");
						// createSeries("energy_file_path", "energy_file_path");
						// createSeries("me_goal_water", "me_goal_water");
						// createSeries("me_goal_energy", "me_goal_energy");
						// createSeries("current", "current");
						// createSeries("permission", "permission");

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
			<h2>KPI</h2>
			<br>

			<div class="col-md-12">
				<div id="filters">
					<label for="date" class="form-label" style="text-align: center;">
						<b>Data</b>
					</label>
					<input type="number" class="form-control" id="ano" name="ano" min="2018" value="2022">

					<select id="select-company" class="form-select">
						<?php foreach ($this->Model_KPI->readCompaniesByName() as $company){ ?>
							<option value="<?php echo $company->com_id ?>"><?php echo $company->com_name ?></option>
						<?php } ?>
					</select>

					<button class="btn btn-primary" onclick="generateKpi()">
						Gerar KPI
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
