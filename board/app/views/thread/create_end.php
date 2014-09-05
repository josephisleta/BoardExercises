<div style="float:right;">
	<p><em>You are logged in as :</em>
		<?php eh($_SESSION['username'])?>
		<a class="btn btn-mini btn-danger" href="<?php eh(url('user/logout')) ?>">Logout</a>
	</p>
</div>
<h2><?php eh($thread->title) ?></h2>
<p class="alert alert-success">
	You successfully created.
</p>
<a href="<?php eh(url('thread/view', array('thread_id' => $thread->id))) ?>">&larr; Go to thread</a>
