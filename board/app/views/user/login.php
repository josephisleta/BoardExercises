<h1>Log in</h1><br />

<?php if ($user->isFailedLogin()): ?>
	<div class="alert alert-block">
		<div>Invalid <em>username or password</em>!</div>
	</div>
<?php endif ?>

<form class="well" method="POST" action="<?php eh(url('user/login'))?>">
	<label>Username:</label>
	<input type="text" class="span2" name="username" required>
	<label>Password:</label>
	<input type="password" class="span2" name="pword" required>
	<input type="hidden" name="page_next" value="home">
	<br />
	<button type="submit" class="btn btn-primary">Submit</button>
</form>

<div>
	<em>No account yet?</em>
	<a class="btn btn-danger" href="<?php eh(url('user/register')) ?>">Register</a>
</div>