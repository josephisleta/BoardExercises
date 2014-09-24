<a href="<?php encode(url('thread/view', array('thread_id' => $thread->id)))?> ">&larr; Back to thread</a>

<h1>Comment:</h1>
<h2 class="well text-error"><?php encode($comment->body) ?></h2>

<?php if ($comment->hasError()): ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Validation Error!</h4>
        
        <?php if (!empty($comment->validation_errors['body']['length'])): ?>
            <div><em>Comment</em> must be between
                <?php encode($comment->validation['body']['length'][1]) ?> and
                <?php encode($comment->validation['body']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
    </div>
<?php endif ?>

<form class="well" method="POST" >
    <label>Edit Comment:</label>
    <textarea name="body" style="width: 890px; height: 150px;" maxlength="200" required><?php encode(Param::get('body')) ?></textarea><br>
    <button type="submit" name="edit" class="btn btn-primary" >Edit</button>
    <a href="<?php encode(url('thread/view', array('thread_id' => $thread->id)))?> ">Done</a>
</form>
