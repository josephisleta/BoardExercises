<h1>Welcome <?php encode($_SESSION['name'])?>!</h1>
<p class="alert alert-success">
	You have successfully logged in to your account <b><?php encode($_SESSION['username']) ?></b>.
</p>
<a class="btn btn-primary" href="<?php encode(url('thread/index')) ?>">View threads</a>