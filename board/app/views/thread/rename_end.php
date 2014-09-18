<table style="width: 100%;">
<tr>
	<td>
		<a href="<?php encode(url('thread/view',array('thread_id' => $id))) ?>">&larr; Back to thread</a>
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

<h2><?php encode($title) ?></h2>

<p class="alert alert-success">
	You successfully renamed this thread.
</p>