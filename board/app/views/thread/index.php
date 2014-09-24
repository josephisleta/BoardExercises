<table style="width: 100%;">
	<tr>
		<td>
			<a class="btn btn-medium btn-primary" href="<?php encode(url('thread/create')) ?>">Create new thread</a>
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

<div style="height:610px; background-color:#E0FFFF;">
	<table class="table">
		<th style="width:500px;">Topics</th>
		<th style="width:100px;">Replies</th>
		<th style="width:100px;">Views</th>
		<th style="width:200px;">Last Post</th>
		
		<?php for($i=0 ; $i<count($threads) ; $i++): ?>
			<tr>
				<td>
					<div style="font-size:18px;"><a href="<?php encode(url('thread/view',array('thread_id' => $threads[$i]->id)))?>"><?php encode($threads[$i]->title) ?></a></div>
					by <?php encode($threads[$i]->username) ?> on <?php encode(date('M d, Y h:ia', strtotime($threads[$i]->created))) ?>
				</td>
				<td>
					<?php encode($count[$i]) ?>
				</td>
				<td>
					<?php encode($threads[$i]->view) ?>
				</td>
				<td>
					by <?php encode($last_post[$i]->username) ?><br>
					on <?php encode(date('M d, Y h:ia', strtotime($last_post[$i]->created))) ?>
				</td>
			</tr>
		<?php endfor?>
	</table>
</div>

<div style="float:right;">
	<?php echo $pagination['control'];?>
</div>
