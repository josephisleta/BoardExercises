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
<h1>Create a thread</h1>

<?php if ($thread->hasError() || $comment->hasError()): ?>
	<div class="alert alert-block">

	<h4 class="alert-heading">Validation error!</h4>
	
	<?php if (!empty($thread->validation_errors['title']['length'])): ?>
		<div><em>Title</em> must be between
			<?php encode($thread->validation['title']['length'][1]) ?> and
			<?php encode($thread->validation['title']['length'][2]) ?> characters in length.
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
            
<form class="well" method="POST" action="<?php encode(url('')) ?>">
	<label>Title</label>
	<input type="text" class="span2" name="title" value="<?php encode(Param::get('title')) ?>" required>
	<label>Comment</label>
	<textarea name="body" required><?php encode(Param::get('body')) ?></textarea>
	<br />

	<input type="hidden" name="page_next" value="create_end">
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
