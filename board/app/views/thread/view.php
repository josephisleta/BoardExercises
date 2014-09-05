<div style="float:right;">
	<p><em>You are logged in as :</em>
		<?php eh($_SESSION['username'])?>
		<a class="btn btn-mini btn-danger" href="<?php eh(url('user/logout')) ?>">Logout</a>
	</p>
</div>

<a href="<?php eh(url('thread/index')) ?>">
	&larr; Back to home
</a>

<h1><?php eh($thread->title) ?></h1>
<table class="table">
	<?php foreach ($comments as $k => $v): ?>
	<div class="comment">
		<tr>
			<td><div class="meta" style="text-align:left; font-size:21px;"><?php eh($v->username) ?></td>
			<td style="text-align:right; font-size:12px"><?php eh($v->created) ?></div></td>
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

<hr>

<form class="well" method="POST" action="<?php eh(url('thread/write')) ?>">
	<input type="hidden" class="span2" name="username" value="<?php eh($_SESSION['username']) ?>">
	
	<label>Comment</label>
	<textarea name="body"><?php eh(Param::get('body')) ?></textarea>
	<br />
	
	<input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
	<input type="hidden" name="page_next" value="write_end">
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
