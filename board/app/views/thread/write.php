<div style="float:right;">
	<p><em>You are logged in as :</em>
		<?php eh($_SESSION['username'])?>
		<a class="btn btn-mini btn-danger" href="<?php eh(url('user/logout')) ?>">Logout</a>
	</p>
</div>
<a href="<?php eh(url('thread/view',array('thread_id' => $thread->id))) ?>">
	&larr; Back to thread
</a>
<h2><?php eh($thread->title) ?></h2>

<?php if ($comment->hasError()): ?>
	<div class="alert alert-block">
	<h4 class="alert-heading">Validation error!</h4>
	<?php if (!empty($comment->validation_errors['username']['length'])): ?>
		<div><em>Your name</em> must be between
			<?php eh($comment->validation['username']['length'][1]) ?> and
			<?php eh($comment->validation['username']['length'][2]) ?> characters in length.
		</div>
	<?php endif ?>

	 <?php if (!empty($comment->validation_errors['body']['length'])): ?>
		<div><em>Comment</em> must be between
			<?php eh($comment->validation['body']['length'][1]) ?> and
			<?php eh($comment->validation['body']['length'][2]) ?> characters in length.
		</div>
	<?php endif ?>
	</div>
<?php endif ?>
            
<form class="well" method="POST" action="<?php eh(url('thread/write')) ?>">
	<input type="hidden" class="span2" name="username" value="<?php eh($_SESSION['username']) ?>">
	
	<label>Comment</label>
	<textarea name="body" style="width: 890px; height: 150px;"><?php eh(Param::get('body')) ?></textarea><br />
	<br />

	<input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
	<input type="hidden" name="page_next" value="write_end">
	<button type="submit" class="btn btn-primary">Submit</button>                
</form> 
