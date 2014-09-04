<div>
	<em>You are logged in as <?php eh($_SESSION['username'])?></em>
	<a class="btn btn-danger" href="<?php eh(url('user/logout')) ?>">Logout</a><br /><br />
</div>



<div>
	<a class="btn btn-large" href="<?php eh(url('thread/create')) ?>"><em>Create new thread?</em></a>
</div>

<div>
<table class="table table-condensed table-striped table-hover">
	<th>Title</th>
	<th>Created by</th>
	<th>Date Created</th>
	<?php foreach ($threads as $v): ?>
	<tr>
		<td><a href="<?php eh(url('thread/view',array('thread_id' => $v->id)))?>"><?php eh($v->title) ?></a></td>
		<td><?php eh($v->username) ?></td>
		<td><?php eh($v->created) ?></td>
	</tr>
	<?php endforeach ?>
</table>
</div>

