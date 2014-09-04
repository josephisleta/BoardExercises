<h1>User Registration</h1>

<?php if ($user->hasError()): ?>
	<div class="alert alert-block">
		<h4 class="alert-heading">Validation error!</h4>

		<?php if (!empty($user->validation_errors['username']['length'])): ?>
			<div><em>Username</em> must be between
				<?php eh($user->validation['username']['length'][1]) ?> and
				<?php eh($user->validation['username']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>
		
		<?php if (!empty($user->validation_errors['pword']['length'])): ?>
			<div><em>Password</em> must be between
				<?php eh($user->validation['pword']['length'][1]) ?> and
				<?php eh($user->validation['pword']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>

		<?php if (!empty($user->validation_errors['confirm_pword']['match'])): ?>
			<div><em>Passwords</em> do not match.</div>
		<?php endif ?>

		<?php if (!empty($user->validation_errors['name']['format'])): ?>
			<div><em>Name</em> must contain letters only.</div>
		<?php endif ?>

		<?php if (!empty($user->validation_errors['email']['format'])): ?>
			<div>Invalid <em>email address</em>.</div>
		<?php endif ?>

	</div>
<?php endif ?>

<form class="well" method="post" action="<?php eh(url('user/register')) ?>">
	<label>Username</label>
	<input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
	
	<label>Password</label>
	<input type="password" class="span2" name="pword">
	
	<label>Confirm Password</label>
	<input type="password" class="span2" name="confirm_pword">
	
	<label>Name</label>
	<input type="text" class="span2" name="name" value="<?php eh(Param::get('name')) ?>">
	
	<label>Email</label>
	<input type="text" class="span2" name="email" value="<?php eh(Param::get('email')) ?>">
	<br />
	
	<input type="hidden" name="page_next" value="register_end">
	<button type="submit" class="btn btn-primary">Register</button>
</form>

<div>
	<em>Already have an account?</em>
	<a class="btn btn-danger" href="<?php eh(url('user/login')) ?>">Login</a>
</div>