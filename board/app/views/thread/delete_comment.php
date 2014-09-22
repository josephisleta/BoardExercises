<a href="<?php encode(url('thread/view', array('thread_id' => $thread->id)))?> ">&larr; Back to thread</a>

<form method="POST">
<div class="alert alert-danger">
    <h4 class="alert-heading">Are you sure you want to delete this comment?</h4>
    <input type="submit" class="btn btn-danger" value="Yes" name='delete'></input>
    <a class="btn btn-default" href="<?php encode(url('thread/view', array('thread_id' => $thread->id))) ?>">No</a>
  </div>
</form>

<h4 class="well muted">
	<table>
	<?php echo $comment->username ?><br>
	<?php echo $comment->created ?><br>
	<?php echo $comment->body ?>
	</table>
</h4>
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
</div>