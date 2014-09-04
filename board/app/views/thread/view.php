<a class="btn btn-large btn-primary" href="<?php eh(url('thread/index')) ?>">Home</a>

<h1><?php eh($thread->title) ?></h1>

<?php foreach ($comments as $k => $v): ?>
<div class="comment">
	<div class="meta">
		<?php eh($k + 1) ?>: <?php eh($v->username) ?> <?php eh($v->created) ?>
	</div>
	
	<div>
		<?php echo readable_text($v->body) ?>
	</div>
</div>
<?php endforeach ?>

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
