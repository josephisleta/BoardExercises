<table style="width: 100%;">
<tr>
	<td>
		<a href="<?php encode(url('thread/index')) ?>">&larr; Back to home</a>
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
    <h4 class="alert-heading">Are you sure you want to delete this thread?</h4>
    <input type="submit" class="btn btn-danger" value="Yes" name='delete'></input>
    <a class="btn btn-default" href="<?php encode(url('thread/view', array('thread_id' => $thread->id))) ?>">No</a>
  </div>
</form>

<div style="background-color:#E0FFFF;">
	<h1><?php encode($thread->title) ?></h1>
	
	<table class="table">
		<?php foreach ($comments as $k => $v): ?>
		<div class="comment">
			<tr style="background-color: #D3D3D3;">
				<td><div class="meta" style="text-align:left; font-size:21px; "><?php encode($v->username) ?></td>
				<td style="text-align:right; font-size:12px"><?php encode($v->created) ?></div></td>
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