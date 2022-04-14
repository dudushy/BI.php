<div>
	<form method="POST" action="<?php echo base_url('graph/auth'); ?>">
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
	<hr>
	<form method="POST" action="<?php echo base_url('graph/chart'); ?>">
		<div class="mb-2">
			<label for="date" class="form-label">
				<b>Choose the date</b>
			</label>
			<input type="month" class="form-control" id="date" name="date" min="2018-03" value="2018-05">
		</div>
		<div class="mb-2">
			<label for="company" class="form-label">
				<b>Choose the company</b>
			</label>
			<input type="text" class="form-control" id="company" name="company" disabled>
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>
