<table style="width: 100%;">
<tr>
    <td>
        <a href="<?php encode(url('thread/view', array('thread_id' => $thread->id)))?> ">&larr; Back to thread</a>
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

<h1>Your Comment:</h1>
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
    <textarea name="body" style="width: 890px; height: 150px;" required><?php encode(Param::get('body')) ?></textarea><br>
    <button type="submit" name="edit" class="btn btn-primary" >Edit</button>
    <a href="<?php encode(url('thread/view', array('thread_id' => $thread->id)))?> ">Done</a>
</form>
