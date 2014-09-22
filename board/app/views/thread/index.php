<table style="width: 100%;">
	<tr>
		<td>
			<a class="btn btn-medium" href="<?php encode(url('thread/create')) ?>">Create new thread</a>
		</td>
		<td style="float: right;">
			<form class="form-search" method="GET">
				<input type="text" name="keyword" class="input-medium">
				<select name="filter" class="input-medium">
					<option value="" selected disabled>Search by</option>
					<option value="all">All</option>
					<option value="title">Title</option>
					<option value="author">Author</option>
					<option value="created">Date Created</option>
				</select>
				<button type="submit" class="btn">Search</button>
			</form>
		</td>
	</tr>
</table>

<div style="float:right;">
	<?php encode($result) ?> Topics ~
	Page <?php encode($pagination['pagenum']) ?> of <?php encode($pagination['last_page']) ?>
</div>

<hr>

<div style="height:450px; background-color:#E0FFFF;">
	<table class="table">
		<th style="width:600px;">Topic</th>
		<th style="width:150px;">Replies</th>
		<th style="width:150px;">Views</th>
		<th style="width:150px;">Created by</th>
		<th style="width:150px;">Date Created</th>
		<th style="width:150px;">Last Post</th>
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
