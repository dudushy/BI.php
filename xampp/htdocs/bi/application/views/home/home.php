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

			#iso_groups {
				width: 50%;
				height: 400px;
			}

			#iso_companies {
				width: 25%;
				height: 400px;
			}

			#iso_process {
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
				// document.getElementById("date").max = (new Date().getFullYear()) + "-" + (new Date().getMonth());
			});

			function sleep(ms) {
				return new Promise(
					resolve => setTimeout(resolve, ms)
				);
			}

			async function generateAll(){
				generateIso();
				generateKpi();
				generateDk();
			}

			async function generateKpi() {
				var div = document.querySelector('#charts');
				var kpi = document.createElement('div');
				kpi.id = "kpi";
				kpi.style.width = "100%";
				kpi.style.height = "1000px";
				div.appendChild(kpi);
				
				var ano = document.getElementById("date").value.split("-")[0];
				var com_id = document.getElementById("select-companies").value;
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

			async function generateDk() {
				generateDkCompanyGroups();
				generateDkCompany();
				generateDkChapter();
			}

			async function generateIso() {
				generateIsoGroups();
				generateIsoCompanies();
				generateIsoProcess();
			}

			async function generateIsoGroups() {
				var div = document.querySelector('#charts');
				var iso = document.createElement('div');
				iso.id = "iso_groups";
				iso.style.width = "100%";
				iso.style.height = "1000px";
				div.appendChild(iso);

				var inputs = {
					"ano": document.getElementById("date").value.split("-")[0],
					"mes": document.getElementById("date").value.split("-")[1]
				};
				
				console.log(inputs);
				
				$.post('<?php echo base_url(); ?>ISO/getGroups/' + inputs['ano'] + '/' + inputs['mes'], function (data) {
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

			async function generateIsoCompanies() {
				var div = document.querySelector('#charts');
				var iso = document.createElement('div');
				iso.id = "iso_companies";
				iso.style.width = "100%";
				iso.style.height = "1000px";
				div.appendChild(iso);

				var inputs = {
					"ano": document.getElementById("date").value.split("-")[0],
					"mes": document.getElementById("date").value.split("-")[1],
					"grupo_id": document.getElementById("select-groups").value
				};
				
				console.log(inputs);

				$.post('<?php echo base_url(); ?>ISO/getCompanies/' + inputs['ano'] + '/' + inputs['mes'] + '/' + inputs['grupo_id'], function (data) {
					var obj = JSON.parse(data);
					console.log(obj);
					console.log(obj['data']);

					am5.ready(function() {
						// Create root element
						// https://www.amcharts.com/docs/v5/getting-started/#Root_element
						var root = am5.Root.new("iso_companies");

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
								categoryField: "razao_social",
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
								categoryYField: "razao_social"
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

			async function generateIsoProcess() {
				var div = document.querySelector('#charts');
				var iso = document.createElement('div');
				iso.id = "iso_process";
				iso.style.width = "100%";
				iso.style.height = "1000px";
				div.appendChild(iso);

				var inputs = {
					"ano": document.getElementById("date").value.split("-")[0],
					"mes": document.getElementById("date").value.split("-")[1],
					"grupo_id": document.getElementById("select-groups").value,
					"empresa_id": document.getElementById("select-companies").value
				};
				
				console.log(inputs);

				$.post('<?php echo base_url(); ?>ISO/getProcess/' + inputs['ano'] + '/' + inputs['mes'] + '/' + inputs['grupo_id'] + '/' + inputs['empresa_id'], function (data) {
					var obj = JSON.parse(data);
					console.log(obj);

					console.log(obj['data']);

					am5.ready(function() {
						// Create root element
						// https://www.amcharts.com/docs/v5/getting-started/#Root_element
						var root = am5.Root.new("iso_process");

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
								categoryField: "nome",
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
								categoryYField: "nome"
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

			async function generateDkCompanyGroups() {
				var div = document.querySelector('#charts');
				var dk = document.createElement('div');
				dk.id = "dk_companyGroups";
				dk.style.width = "100%";
				dk.style.height = "1000px";
				div.appendChild(dk);

				var area_id = document.getElementById("select-groups").value;
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

			async function generateDkCompany() {
				var div = document.querySelector('#charts');
				var dk = document.createElement('div');
				dk.id = "dk_company";
				dk.style.width = "100%";
				dk.style.height = "500px";
				div.appendChild(dk);

				var period = document.getElementById("date").value;
				var parent_item_id = document.getElementById("select-companies").value;
				var area_id = document.getElementById("select-groups").value;
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

			async function generateDkChapter() {
				var period = document.getElementById("date").value;
				var parent_item_id = document.getElementById("select-companies").value;
				var area_id = document.getElementById("select-groups").value;

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
			<h2>Home</h2>
			<br>
			
			<div class="col-md-12">
				<div id="filters">
					<label for="date" class="form-label" style="text-align: center;">
						<b>Data</b>
					</label>
					<input type="month" class="form-control" id="date" name="date" min="2018-03" value="2022-02">

					<label for="select-groups" class="form-label" style="text-align: center;">
						<b>Grupo</b>
					</label>
					<select id="select-groups" class="form-select">
						<?php foreach ($groups as $group){ ?>
							<option value="<?php echo $group->grp_id ?>"><?php echo $group->grp_name ?></option>
						<?php } ?>
					</select>

					<label for="select-companies" class="form-label" style="text-align: center;">
						<b>Empresa</b>
					</label>
					<select id="select-companies" class="form-select">
						<?php foreach ($companies as $company){ ?>
							<option value="<?php echo $company->com_id ?>"><?php echo $company->com_name ?></option>
						<?php } ?>
					</select>
					
					<button id="btnGenerate" class="btn btn-primary" onclick="generateAll()">
						Gerar
					</button>
					<br><br>
				</div>

				<br>
				
				<div id="charts" class="container-fluid">
					<div id="iso"></div>
					<div id="kpi"></div>
					<div id="dk"></div>
				</div>
			</div>
		</div>
		<footer style="text-align: center;">
			<hr style="border-top: 10px solid;">
			&copy; 2022 | All Rights Reserved
		</footer>
	</body>
</html>
