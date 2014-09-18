<div style="float:right;">
	<p><em>You are logged in as :</em>
		<?php encode($_SESSION['username'])?>
		<a class="btn btn-mini" href="<?php encode(url('user/profile')) ?>">Profile</a>
		<a class="btn btn-mini btn-danger" href="<?php encode(url('user/logout')) ?>">Logout</a>
	</p>
</div>

<a href="<?php encode(url('thread/index')) ?>">
	&larr; Back to home
</a>
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