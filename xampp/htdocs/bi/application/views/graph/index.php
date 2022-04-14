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
		<button type="submit" class="btn btn-primary">Charts</button>
	</form>
</div>
