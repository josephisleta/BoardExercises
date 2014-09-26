<a href="<?php encode(url('thread/index')) ?>">&larr; Back to home</a>

<h1>Change Password</h1>

<?php if ($user->hasError()): ?>
	<div class="alert alert-block">
		<h4 class="alert-heading">Validation error!</h4>

		<?php if ($user->validation_errors['password']['length']): ?>
			<div><em>Password</em> must be between
				<?php encode($user->validation['password']['length'][1]) ?> and
				<?php encode($user->validation['password']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>

		<?php if ($user->validation_errors['password']['format']): ?>
			<div><em>Password</em> must contain alphanumeric characters only.
			</div>
		<?php endif ?>

		<?php if ($user->validation_errors['confirm_password']['match']): ?>
			<div><em>Passwords</em> do not match.</div>
		<?php endif ?>
	</div>
<?php endif ?>

<form class="well" method="post" action="<?php encode(url('user/change_password')) ?>">
	<label>New Password</label>
	<input type="password" class="span2" name="password" pattern=.{6,20} required>
	
	<label>Confirm Password</label>
	<input type="password" class="span2" name="confirm_password" required>
	<br>
	<input type="hidden" name="page_next" value="profile_end">
	<button type="submit" class="btn btn-primary">Save</button>
	<a href="<?php encode(url('user/profile'))?> ">Profile</a>
</form>