<a href="<?php encode(url('thread/view',array('thread_id' => $thread->id))) ?>">&larr; Back to thread</a>

<h2><?php encode($thread->title) ?></h2>

<?php if ($comment->hasError()): ?>
	<div class="alert alert-block">
		<h4 class="alert-heading">Validation error!</h4>
		 <?php if ($comment->validation_errors['body']['length']): ?>
			<div>
				<em>Comment</em> must be between
				<?php encode($comment->validation['body']['length'][1]) ?> and
				<?php encode($comment->validation['body']['length'][2]) ?> characters in length.
			</div>
		<?php endif ?>
	</div>
<?php endif ?>

<form class="well" method="POST" action="<?php encode(url('thread/write')) ?>">
	<label>Comment</label>
	<textarea name="body" style="width: 890px; height: 150px;" required><?php encode(Param::get('body')) ?></textarea><br />
	<br>
	<input type="hidden" name="thread_id" value="<?php encode($thread->id) ?>">
	<input type="hidden" name="page_next" value="write_end">
	<button type="submit" class="btn btn-primary">Submit</button>                
</form> 
