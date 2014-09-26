<?php
class ThreadController extends AppController
{
    public function index()
    {
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }

        $result = Thread::count();
        $pagination = Pagination::getControls($result);
        $threads = Thread::getAll($pagination['maximum']);
        
        $keyword = Param::get('keyword');
        $filter = Param::get('filter');

        if ($keyword) {
            $threads = Thread::search($keyword, $filter, $pagination['maximum']);
            $result = count($threads);
        }
        
        $count_comment = array();
        $last_post = array();

        foreach ($threads as $thread) {
            $count_comment[] = Comment::count($thread->id);
            $last_post[] = Thread::getLastPost($thread->id);
        }

        $this->set(get_defined_vars());
    }
    
    /*
    *Creates a new thread
    */
    public function create()
    {
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }
        
        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next','create');
        
        switch ($page) {
            case 'create':
                break;
            case 'create_end':
                $thread->title = trim(Param::get('title'));
                $comment->user_id = $_SESSION['id'];
                $comment->body = Param::get('body');
                try {
                    $thread->create($comment);
                } catch (ValidationException $e) {
                    $page = 'create';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }
    
    /*
    *Displays comments on each thread
    */
    public function view()
    {
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }

        $thread = Thread::get(Param::get('thread_id'));
        $limit = Comment::count($thread->id);
        $pagination = Pagination::getControls($limit);
        $thread->viewAdd();

        $comments = $thread->getComments($pagination['maximum']);

        $count_post = array();
        foreach ($comments as $comment) {
            $count_post[] = User::countPost($comment->user_id);
        }

        $this->set(get_defined_vars());
    }

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
    *Delete thread
    */
    public function delete()
    {
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }

        $thread = Thread::get(Param::get('thread_id'));
        $limit = Comment::count($thread->id);
        $pagination = Pagination::getControls($limit);

        $comments = $thread->getComments($pagination['maximum']);

        $count_post = array();
        foreach ($comments as $comment) {
            $count_post[] = User::countPost($comment->user_id);
        }

        if (isset($_POST['delete'])) {
            $thread->delete();
            $this->render('delete_end');
        }

        $this->set(get_defined_vars());
    }

    /*
    *Rename thread
    */
    public function rename()
    {   
        if (!is_logged_in()) {
            redirect(url('user/login'));
        }

        $thread = Thread::get(Param::get('thread_id'));
        $limit = Comment::count($thread->id);
        $pagination = Pagination::getControls($limit);

        $comments = $thread->getComments($pagination['maximum']);

        $count_post = array();
        foreach ($comments as $comment) {
            $count_post[] = User::countPost($comment->user_id);
        }

        $this->set(get_defined_vars());

        if (isset($_POST['rename'])) {
            $thread->title = trim(Param::get('title'));
            try {
                $thread->rename();
                $this->render('rename_end');
            } catch (ValidationException $e) {
                $this->render('rename');
            }
        }
    }

    /*
    *Edit comment
    */
    public function edit_comment()
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

        if (isset($_POST['edit'])) {   
            $comment->body = Param::get('body');
            try {
                $comment->edit();
                $this->render('write_end');
            } catch (ValidationException $e) {
                $this->render('edit_comment');
            }
        }
    }

    /*
    *Delete comment
    */
    public function delete_comment()
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

        if (isset($_POST['delete'])) {
            $comment->delete();
            $this->render('delete_comment_end');
        }
    }
}
