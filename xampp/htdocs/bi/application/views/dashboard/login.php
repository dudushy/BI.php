<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.css') ?>"/>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		<script src="<?php echo base_url('public/js/bootstrap.js')?>"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

		<script>
			$(document).ready(function () {
				console.log("hello world");
			});

			function sleep(ms) {
				return new Promise(
					resolve => setTimeout(resolve, ms)
				);
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
			<form method="POST" action="<?php echo base_url('home/auth'); ?>">
				<div class="mb-3">
					<label for="username" class="form-label">
						<b>Username</b>
					</label>
					<input type="email" class="form-control" id="username" autocomplete="off" name="username">
				</div>

				<div class="mb-3">
					<label for="password" class="form-label">
						<b>Password</b>
					</label>
					<input type="password" class="form-control" id="password" autocomplete="off" name="password">
				</div>

				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
		<footer style="text-align: center;">
			<hr style="border-top: 10px solid;">
			&copy; 2022 | All Rights Reserved
		</footer>
	</body>
</html>
