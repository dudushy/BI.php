<!DOCTYPE html>
<html>
	<head>
		<title>BI.php</title>
		<link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.css') ?>"/>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
		<script src="<?php echo base_url('public/js/bootstrap.js')?>"></script>
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
				<?php
				$this->load->view($content);
				?>
			</div>
			<footer>
				<hr style="border-top: 10px solid">
				<center>
					&copy; 2022 | All Rights Reserved
				</center>
			</footer>
		</div>
	</body>
</html>
