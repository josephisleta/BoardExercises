<?php
class CommentController extends AppController
{
    /*
    *Writes comments on a thread
    */
    public function write()
    {
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }
        
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next','write');
        
        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->user_id = $_SESSION['id'];
                $comment->body = Param::get('body');
                try {
                    $comment->write($thread);
                } catch (ValidationException $e) {
                    $page = 'write';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    /*
    *Edit comment
    */
    public function edit()
    {
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }

        $comment = Comment::get(Param::get('comment_id'));
        $thread = Thread::get(Param::get('thread_id'));
        
        $limit = Comment::count($thread->id);
        $pagination = Pagination::getControls($limit);

        $comments = $thread->getComments($pagination['maximum']);

        $count_post = array();
        foreach ($comments as $v) {
            $count_post[] = User::countPost($v->user_id);
        }

        $this->set(get_defined_vars());

        if (Param::get('edit')) {
            $comment->body = Param::get('body');
            try {
                $comment->edit();
                $this->render('write_end');
            } catch (ValidationException $e) {
                $this->render('edit');
            }
        }
    }

    /*
    *Delete comment
    */
    public function delete()
    {
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }

        $comment = Comment::get(Param::get('comment_id'));
        $thread = Thread::get(Param::get('thread_id'));

        $limit = Comment::count($thread->id);
        $pagination = Pagination::getControls($limit);

        $comments = $thread->getComments($pagination['maximum']);

        $count_post = array();
        foreach ($comments as $v) {
            $count_post[] = User::countPost($v->user_id);
        }

        $this->set(get_defined_vars());

        if (Param::get('delete')) {
            $comment->delete();
            $this->render('delete_end');
        }
    }
}