<div style="float:right;">
	<p><em>You are logged in as :</em>
		<?php encode($_SESSION['username'])?>
		<a class="btn btn-mini btn-danger" href="<?php encode(url('user/logout')) ?>">Logout</a>
	</p>
</div>

<div>
	<a class="btn btn-large" href="<?php encode(url('thread/create')) ?>"><em>Create new thread?</em></a>
</div>
<hr>

<div style="height:450px; background-color:#E0FFFF;">
	<table class="table">
		<th style="width:600px;">Title</th>
		<th style="width:150px;">Created by</th>
		<th style="width:150px;">Date Created</th>
		<?php foreach ($threads as $v): ?>
			<tr>
				<td><a href="<?php encode(url('thread/view',array('thread_id' => $v->id)))?>"><?php encode($v->title) ?></a></td>
				<td><?php encode($v->username) ?></td>
				<td><?php encode($v->created) ?></td>
			</tr>
		<?php endforeach ?>
	</table>
</div>

<div style="float:right;">
	<?php echo $pagination['control'];?>
</div>
