<div style="float:right;">
	<p><em>You are logged in as :</em>
		<?php encode($_SESSION['username'])?>
		<a class="btn btn-mini btn-danger" href="<?php encode(url('user/logout')) ?>">Logout</a>
	</p>
</div>
<h2><?php encode($thread->title) ?></h2>
<p class="alert alert-success">
	You successfully created.
</p>
<a href="<?php encode(url('thread/view', array('thread_id' => $thread->id))) ?>">&larr; Go to thread</a>
