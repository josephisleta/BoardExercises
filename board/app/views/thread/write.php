<table style="width: 100%;">
<tr>
	<td>
		<a href="<?php encode(url('thread/view',array('thread_id' => $thread->id))) ?>">&larr; Back to thread</a>
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

<h2><?php encode($thread->title) ?></h2>

<?php if ($comment->hasError()): ?>
	<div class="alert alert-block">
	<h4 class="alert-heading">Validation error!</h4>
	<?php if (!empty($comment->validation_errors['username']['length'])): ?>
		<div><em>Your name</em> must be between
			<?php encode($comment->validation['username']['length'][1]) ?> and
			<?php encode($comment->validation['username']['length'][2]) ?> characters in length.
		</div>
	<?php endif ?>

	 <?php if (!empty($comment->validation_errors['body']['length'])): ?>
		<div><em>Comment</em> must be between
			<?php encode($comment->validation['body']['length'][1]) ?> and
			<?php encode($comment->validation['body']['length'][2]) ?> characters in length.
		</div>
	<?php endif ?>
	</div>
<?php endif ?>

<form class="well" method="POST" action="<?php encode(url('thread/write')) ?>">
	<label>Comment</label>
	<textarea name="body" style="width: 890px; height: 150px;" required><?php encode(Param::get('body')) ?></textarea><br />
	<br />
	<input type="hidden" name="username" value="<?php encode($_SESSION['username']) ?>">
	<input type="hidden" name="thread_id" value="<?php encode($thread->id) ?>">
	<input type="hidden" name="page_next" value="write_end">
	<button type="submit" class="btn btn-primary">Submit</button>                
</form> 
