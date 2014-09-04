<p class="alert alert-success">
	You have logged out.
</p>
<?php session_unset() ?>
<a class="btn btn-large btn-primary" href="<?php eh(url('user/login')) ?>">Log In Again?</a>
OR
<a class="btn btn-mini " href="<?php eh(url('user/register')) ?>">Create New Account?</a>
