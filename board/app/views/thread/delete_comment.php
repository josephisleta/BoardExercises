<table style="width: 100%;">
<tr>
	<td>
		<a href="<?php encode(url('thread/view', array('thread_id' => $thread->id)))?> ">&larr; Back to thread</a>
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
			<td style="text-align:left; font-size:36px; padding:10px; font-weight: bold;"><?php encode($thread->title) ?></td>
			<td style="text-align:right;">
				<?php if($_SESSION['username'] === $thread->username): ?>
				    <a class="btn" href="<?php encode(url('thread/rename', array('thread_id' => $thread->id))) ?>">
					<i class="icon-pencil"></i></a>

				    <a class="btn btn-danger" href="<?php encode(url('thread/delete', array('thread_id' => $thread->id))) ?>">
					<i class="icon-trash"></i></a>
				<?php endif?>
			</td>
		</tr>

		<?php foreach ($comments as $k => $v): ?>
			<div class="comment">
				<tr style="background-color: #D3D3D3;">
					<td>
						<div class="meta" style="text-align:left; font-size:21px; font-weight: bold;"><?php encode($v->username) ?></div>
						<div style="text-align:left; font-size:12px"><?php encode($v->created) ?></div>
					</td>
					<td style="text-align:right;">
						<?php if($_SESSION['username'] === $v->username): ?>
							    <a class="btn btn-mini" href="<?php encode(url('thread/edit_comment', array('thread_id'=>$thread->id, 'comment_id'=>$v->id))) ?>">
								<i class="icon-pencil"></i></a>

							    <a class="btn btn-mini btn-danger" href="<?php encode(url('thread/delete_comment', array('thread_id'=>$thread->id, 'comment_id'=>$v->id))) ?>">
								<i class="icon-trash"></i></a>
						<?php endif?>
					</td>
				</tr>
				<tr>
					<td colspan=2 style="height:100px;"><?php echo readable_text($v->body) ?></td>
				</tr>
			</div>
		<?php endforeach ?>
	</table>
	<div style="float:right;">
		<?php echo $pagination['control'];?>
	</div>
</div>