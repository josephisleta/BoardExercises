<table style="width: 100%;">
<tr>
	<td>
		<a href="<?php encode(url('thread/index')) ?>">&larr; Back to home</a>
	</td>
	<td style="text-align:right;">
		<p><em>You are logged in as :</em>
			<?php encode($_SESSION['username'])?>
			<a class="btn btn-mini" href="<?php encode(url('user/profile')) ?>">Profile</a>
			<a class="btn btn-mini btn-danger" href="<?php encode(url('user/logout')) ?>">Logout</a>
		</p>
	</td>
</tr>
</table>

<h1>User Profile</h1>



<?php if ($user->hasError()): ?>
	<div class="alert alert-block">
		<h4 class="alert-heading">Validation error!</h4>

		<?php if ($user->validation_errors['username']['length']): ?>
			<div><em>Username</em> must be between
				<?php encode($user->validation['username']['length'][1]) ?> and
				<?php encode($user->validation['username']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>
		
		<?php if ($user->validation_errors['password']['length']): ?>
			<div><em>Password</em> must be between
				<?php encode($user->validation['password']['length'][1]) ?> and
				<?php encode($user->validation['password']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>

		<?php if ($user->validation_errors['confirm_password']['match']): ?>
			<div><em>Passwords</em> do not match.</div>
		<?php endif ?>

		<?php if ($user->validation_errors['name']['format']): ?>
			<div><em>Name</em> must contain letters only.</div>
		<?php endif ?>

		<?php if ($user->validation_errors['email']['format']): ?>
			<div>Invalid <em>email address</em>.</div>
		<?php endif ?>

	</div>
<?php endif ?>

<form class="well" method="post" action="<?php encode(url('user/profile')) ?>">
	<label>Username</label>
	<input type="text" class="span2" name="username" value="<?php encode($user_info->username) ?>" required>
	
	<label>New Password</label>
	<input type="password" class="span2" name="password" required>
	
	<label>Confirm Password</label>
	<input type="password" class="span2" name="confirm_password" required>
	
	<label>Name</label>
	<input type="text" class="span2" name="name" value="<?php encode($user_info->name) ?>" required>
	
	<label>Email</label>
	<input type="text" class="span2" name="email" value="<?php encode($user_info->email) ?>" required>
	<br />
	
	<input type="hidden" name="page_next" value="profile_end">
	<button type="submit" class="btn btn-primary">Save</button>
</form>