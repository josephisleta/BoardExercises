<table style="width: 100%;">
<tr>
	<td>
		<a class="btn btn-large" href="<?php encode(url('thread/create')) ?>"><em>Create new thread?</em></a>
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

<hr>

<div style="height:450px; background-color:#E0FFFF;">
	

	<table class="table">
		<th style="width:600px;">Topic</th>
		<th style="width:150px;">Replies</th>
		<th style="width:150px;">Views</th>
		<th style="width:150px;">Created by</th>
		<th style="width:150px;">Date Created</th>
		<th style="width:150px;">Date Updated</th>
		<?php for($i=0 ; $i<count($count) ; $i++): ?>
			<?php $count[$i] ?>
		<?php endfor ?>
		
		<?php for($i=0 ; $i<count($threads) ; $i++): ?>
			<tr>
				<td><a href="<?php encode(url('thread/view',array('thread_id' => $threads[$i]->id)))?>"><?php encode($threads[$i]->title) ?></a></td>
				<td><?php encode($count[$i]) ?></td>
				<td><?php encode($threads[$i]->view) ?></td>
				<td><?php encode($threads[$i]->username) ?></td>
				<td><?php encode(date('M d, Y h:mA', strtotime($threads[$i]->created))) ?></td>
				<td><?php encode(date('M d, Y h:mA', strtotime($threads[$i]->updated))) ?></td>
			</tr>
		<?php endfor ?>
	</table>
</div>

<div style="float:right;">
	<?php echo $pagination['control'];?>
</div>
