<a href="<?php encode(url('thread/index')) ?>">&larr; Back to home</a>

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
	<input type="text" class="span2" name="username" value="<?php encode($user_info->username) ?>" pattern=.{6,20} required>
	
	<label>Name</label>
	<input type="text" class="span2" name="name" value="<?php encode($user_info->name) ?>" required>
	
	<label>Email</label>
	<input type="text" class="span2" name="email" value="<?php encode($user_info->email) ?>" required>
	<br />
	<input type="hidden" name="page_next" value="profile_end">
	<button type="submit" class="btn btn-primary">Save</button>
	<a href="<?php encode(url('user/change_password'))?> ">Change Password</a>
</form>