<a href="<?php encode(url('thread/index')) ?>">&larr; Back to home</a>

<h1>Admin Control Panel</h1>

<form method="POST" class="alert">
	<?php if ($action === 'admin'): ?>
		<h4 class="alert-heading">Are you sure you want to promote this user?</h4>
		<input type="submit" class="btn btn-danger" value="Yes" name='yes'></input>
		<a class="btn btn-default" href="<?php encode(url('user/admin')) ?>">No</a>
	<?php elseif ($action === 'banned'): ?>
		<h4 class="alert-heading">Are you sure you want to ban this user?</h4>
		<input type="submit" class="btn btn-danger" value="Yes" name='yes'></input>
		<a class="btn btn-default" href="<?php encode(url('user/admin')) ?>">No</a>
	<?php elseif ($action === 'user'): ?>
		<h4 class="alert-heading">Are you sure you want to this account to be a regular user?</h4>
		<input type="submit" class="btn btn-danger" value="Yes" name='yes'></input>
		<a class="btn btn-default" href="<?php encode(url('user/admin')) ?>">No</a>
	<?php endif ?>
</form>

<div style="height:550px; background-color:#E0FFFF;">
	<table class="table">
		<th style="width:100px;">User ID</th>
		<th style="width:150px;">Username</th>
		<th style="width:200px;">Name</th>
		<th style="width:300px;">Email</th>
		<th style="width:100px;">Type</th>
		<th style="width:200px;">Registered</th>
		<th style="width:100px;">Action</th>
		
		<?php foreach ($users as $k): ?>
			<tr>
				<td><?php encode($k->id) ?></td>
				<td><?php encode($k->username) ?></td>
				<td><?php encode($k->name) ?></td>
				<td><?php encode($k->email) ?></td>
				<td><?php encode($k->type) ?></td>
				<td><?php encode(date('M d, Y h:ia', strtotime($k->registered))) ?></td>
				<td>
					<?php if (($k->type === 'admin') && !($k->id === $_SESSION['id'])): ?>
						<a class="btn btn-mini" href="<?php encode(url('user/admin', array('id' => $k->id, 'action' => 'user'))) ?>" >Demote</a>
					<?php elseif ($k->type === 'banned'): ?>
						<a class="btn btn-mini" href="<?php encode(url('user/admin', array('id' => $k->id, 'action' => 'user'))) ?>" >Unban</a>
					<?php elseif ($k->type === 'user'): ?>
						<a class="btn btn-mini" href="<?php encode(url('user/admin', array('id' => $k->id, 'action' => 'admin'))) ?>" >Promote</a>
						<a class="btn btn-mini" href="<?php encode(url('user/admin', array('id' => $k->id, 'action' => 'banned'))) ?>" >Ban</a>
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</div>