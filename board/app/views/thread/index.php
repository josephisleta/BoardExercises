<div style="float:right;">
	<p><em>You are logged in as :</em>
		<?php eh($_SESSION['username'])?>
		<a class="btn btn-mini btn-danger" href="<?php eh(url('user/logout')) ?>">Logout</a>
	</p>
</div>

<div>
	<a class="btn btn-large" href="<?php eh(url('thread/create')) ?>"><em>Create new thread?</em></a>
</div>
<hr>

<div style="height:450px;">
	<table class="table">
		<th style="width:600px;">Title</th>
		<th style="width:150px;">Created by</th>
		<th style="width:150px;">Date Created</th>
		<?php foreach ($threads as $v): ?>
			<tr>
				<td><a href="<?php eh(url('thread/view',array('thread_id' => $v->id)))?>"><?php eh($v->title) ?></a></td>
				<td><?php eh($v->username) ?></td>
				<td><?php eh($v->created) ?></td>
			</tr>
		<?php endforeach ?>
	</table>
</div>

<div style="float:right;">
	<?php echo $pagination['control'];?>
</div>
