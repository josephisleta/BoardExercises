<h1>User Registration</h1>

<?php if ($user->hasError()): ?>
	<div class="alert alert-block">
		<h4 class="alert-heading">Validation error!</h4>

		<?php if ($user->validation_errors['username']['length']): ?>
			<div>
				<em>Username</em> must be between
				<?php encode($user->validation['username']['length'][1]) ?> and
				<?php encode($user->validation['username']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>
		
		<?php if ($user->validation_errors['password']['length']): ?>
			<div>
				<em>Password</em> must be between
				<?php encode($user->validation['password']['length'][1]) ?> and
				<?php encode($user->validation['password']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>

		<?php if ($user->validation_errors['confirm_password']['match']): ?>
			<div>
				<em>Passwords</em> do not match.
			</div>
		<?php endif ?>

		<?php if ($user->validation_errors['name']['format']): ?>
			<div>
				<em>Name</em> must contain letters only.
			</div>
		<?php endif ?>

		<?php if ($user->validation_errors['email']['format']): ?>
			<div>
				Invalid <em>email address</em>.
			</div>
		<?php endif ?>
	</div>
<?php endif ?>

<form class="well" method="post" action="<?php encode(url('user/register')) ?>">
	<label>Username</label>
	<input type="text" class="span2" name="username" value="<?php encode(Param::get('username')) ?>" required>
	
	<label>Password</label>
	<input type="password" class="span2" name="password" required>
	
	<label>Confirm Password</label>
	<input type="password" class="span2" name="confirm_password" required>
	
	<label>Name</label>
	<input type="text" class="span2" name="name" value="<?php encode(Param::get('name')) ?>" required>
	
	<label>Email</label>
	<input type="text" class="span2" name="email" value="<?php encode(Param::get('email')) ?>" required>
	<br />
	
	<input type="hidden" name="page_next" value="register_end">
	<button type="submit" class="btn btn-primary">Register</button>
</form>

<div>
	<em>Already have an account?</em>
	<a class="btn btn-danger" href="<?php encode(url('user/login')) ?>">Login</a>
</div>