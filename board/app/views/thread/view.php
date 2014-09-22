<a href="<?php encode(url('thread/index')) ?>">&larr; Back to home</a>

<div style="background-color:#E0FFFF;">
	<table class="table" style="width: 100%;">
		<tr >
			<td colspan=2 style="text-align:left; font-size:36px; padding:10px; font-weight: bold;"><?php encode($thread->title) ?></td>
			
			<td style="text-align:right;">
				<?php if($_SESSION['username'] === $thread->username): ?>
				    <a class="btn" href="<?php encode(url('thread/rename', array('thread_id' => $thread->id))) ?>">
					<i class="icon-pencil"></i></a>

				    <a class="btn btn-danger" href="<?php encode(url('thread/delete', array('thread_id' => $thread->id))) ?>">
					<i class="icon-trash"></i></a>
				<?php endif?>
			</td>
		</tr>
		
		<?php for($i=0 ; $i<count($comments) ; $i++): ?>
			<div class="comment">
				<tr style="background-color: #D3D3D3;">
					<td rowspan=1 style="text-align:left; font-size:12px; width:120px;">
						<div class="meta" style="text-align:left; font-size:21px; font-weight: bold;"><?php encode($comments[$i]->username) ?></div>
					</td>
					<td><div style="text-align:left; font-size:10px"><?php encode($comments[$i]->created) ?></div></td>
					<td colspan=2 style="text-align:right;">
						<?php if($_SESSION['username'] === $comments[$i]->username): ?>
							    <a class="btn btn-mini" href="<?php encode(url('thread/edit_comment', array('thread_id'=>$thread->id, 'comment_id'=>$comments[$i]->id))) ?>">
								<i class="icon-pencil"></i></a>

							    <a class="btn btn-mini btn-danger" href="<?php encode(url('thread/delete_comment', array('thread_id'=>$thread->id, 'comment_id'=>$comments[$i]->id))) ?>">
								<i class="icon-trash"></i></a>
						<?php endif?>
					</td>
				</tr>
				<tr>
					<td><div style="text-align:left; font-size:12px;">Posts: <?php encode($count[$i]) ?></div></td>
					<td colspan=2 style="height:100px;"><?php echo readable_text($comments[$i]->body) ?></td>
				</tr>
			</div>
		<?php endfor ?>
	</table>
	<div style="float:right;">
		<?php echo $pagination['control'];?>
	</div>
	
	<hr>
	
	<form class="well" method="POST" action="<?php encode(url('thread/write')) ?>">
		<label>Comment</label>
		<textarea name="body" style="width: 890px; height: 150px;" required><?php encode(Param::get('body')) ?></textarea>
		<br />
		<input type="hidden" name="username" value="<?php encode($_SESSION['username']) ?>">
		<input type="hidden" name="thread_id" value="<?php encode($thread->id) ?>">
		<input type="hidden" name="page_next" value="write_end">
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>