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
				//document.getElementById("ano").max = new Date().getFullYear();
				var period = document.getElementById("date").value;
				
				console.log(period);
			});

			function sleep(ms) {
				return new Promise(
					resolve => setTimeout(resolve, ms)
				);
			}

			async function generateCompanyGroups() {
				var area_id = document.getElementById("area_id").value;

				$.post('<?php echo base_url(); ?>DK/getCompanyGroups/' + area_id, function (data) {
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
			<div class="col-md-12">
				<div id="filters">
					<label for="date" class="form-label" style="text-align: center;">
						<b>Period</b>
					</label>
					<input type="month" class="form-control" id="date" name="date" min="2018-03" value="2022-02">

					<label for="area_id" class="form-label" style="text-align: center;">
						<b>Area ID</b>
					</label>
					<input type="number" class="form-control" id="area_id" name="area_id">
					<button class="btn btn-primary" onclick="generateCompanyGroups()">
						Gerar DK CompanyGroups
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
