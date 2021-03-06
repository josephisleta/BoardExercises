<a href="<?php encode(url('thread/index')) ?>">&larr; Back to home</a>

<form method="POST" class="alert alert-danger">
    <h4 class="alert-heading">Are you sure you want to delete this thread?</h4>
    <input type="submit" class="btn btn-danger" value="Yes" name='delete'></input>
    <a class="btn btn-default" href="<?php encode(url('thread/view', array('thread_id' => $thread->id))) ?>">No</a>
</form>

<div>
	<table class="table" style="width: 100%;">
		<tr>
			<td colspan=3 style="text-align:left; font-size:36px; padding:10px; font-weight: bold;"><?php encode($thread->title) ?></td>
		</tr>
		
		<?php for($i=0 ; $i<count($comments) ; $i++): ?>
			<div class="comment">
				<tr style="background-color: #D3D3D3;">
					<td rowspan=1 style="text-align:left; font-size:12px; width:150px;">
						<div class="meta" style="text-align:left; font-size:21px; font-weight: bold;"><?php encode($comments[$i]->username) ?></div>
					</td>
					<td style="text-align:left; font-size:10px">
							<?php encode(date('M d, Y h:ia', strtotime($comments[$i]->created))) ?>
					</td>
					<td style="text-align:right; font-size:10px">
						<?php if(!($comments[$i]->updated === "0000-00-00 00:00:00")): ?>
							Edited on <?php encode(date('M d, Y h:ia', strtotime($comments[$i]->updated))) ?>
						<?php endif ?>
					</td>
					<td colspan=2 style="text-align:right;">
						<?php if(($_SESSION['username'] === $comments[$i]->username) || is_admin()): ?>
							    <a class="btn btn-mini" href="<?php encode(url('comment/edit', array('thread_id'=>$thread->id, 'comment_id'=>$comments[$i]->id))) ?>">
								<i class="icon-pencil"></i></a>
							    <a class="btn btn-mini btn-danger" href="<?php encode(url('comment/delete', array('thread_id'=>$thread->id, 'comment_id'=>$comments[$i]->id))) ?>">
								<i class="icon-trash"></i></a>
						<?php endif?>
					</td>
				</tr>
				<tr style="background-color:#E0FFFF;">
					<td>
						<?php if($comments[$i]->type === 'admin'): ?>
							<div style="color: #D00000;">
								Admin
							</div>
						<?php elseif($comments[$i]->type === 'banned'): ?>
							<div style="color: #787878 ;">
								Banned
							</div>
						<?php endif ?>
						<div style="text-align:left; font-size:12px;">
							Posts: <?php encode($count_post[$i]) ?><br>
							Registered: <?php encode(date('Y-m-d', strtotime($comments[$i]->registered))) ?>
						</div>
					</td>
					<td colspan=3 style="height:100px;">
						<?php echo readable_text($comments[$i]->body) ?>
					</td>
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
		<br>
		<input type="hidden" name="thread_id" value="<?php encode($thread->id) ?>">
		<input type="hidden" name="page_next" value="write_end">
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>