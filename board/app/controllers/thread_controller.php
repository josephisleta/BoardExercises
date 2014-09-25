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

        foreach ($threads as $v) {
            $thread = Thread::get($v->id);
            $count_comment[] = Comment::countThreadComments($thread->id);
            $last_post[] = Thread::getLastPost($v->id);
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
        $limit = Comment::countThreadComments($thread->id);
        $pagination = Pagination::getControls($limit);
        $thread->viewAdd();

        $comments = $thread->getComments($pagination['maximum']);

        $count_post = array();
        foreach ($comments as $v) {
            $count_post[] = User::countPost($v->user_id);
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
        $thread = Thread::get(Param::get('thread_id'));
        $limit = Comment::countThreadComments($thread->id);
        $pagination = Pagination::getControls($limit);

        $comments = $thread->getComments($pagination['maximum']);

        $count = array();
        foreach ($comments as $v) {
            $count[] = User::countPost($v->user_id);
        }

        if (isset($_POST['delete'])) {
            $thread->delete();
            $this->render('thread/delete_end');
        }

        $this->set(get_defined_vars());
    }

    /*
    *Rename thread
    */
    public function rename()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $limit = Comment::countThreadComments($thread->id);
        $pagination = Pagination::getControls($limit);

        $comments = $thread->getComments($pagination['maximum']);

        $count = array();
        foreach ($comments as $v) {
            $count[] = User::countPost($v->user_id);
        }

        if (isset($_POST['rename'])) {
            $thread->id = Param::get('thread_id');
            $thread->title = trim(Param::get('title'));
            $thread->rename();

            $this->set(get_defined_vars());
            $this->render('thread/rename_end');
        }

        $this->set(get_defined_vars());
    }

    /*
    *Edit comment
    */
    public function edit_comment()
    {
        $comment = Comment::get(Param::get('comment_id'));
        $thread = Thread::get(Param::get('thread_id'));

        if (isset($_POST['edit'])) {   
            $comment->body = Param::get('body');
            $comment->edit();
        }

        $this->set(get_defined_vars());
    }

    /*
    *Delete comment
    */
    public function delete_comment()
    {
        $comment = Comment::get(Param::get('comment_id'));
        $thread = Thread::get(Param::get('thread_id'));

        $limit = Comment::countThreadComments($thread->id);
        $pagination = Pagination::getControls($limit);

        $comments = $thread->getComments($pagination['maximum']);

        $count = array();
        foreach ($comments as $v) {
            $count[] = User::countPost($v->user_id);
        }
        
        if (isset($_POST['delete'])) {
            $comment->delete();
            $thread_id = $comment->thread_id;
            
            $this->set(get_defined_vars()); 
            $this->render('thread/delete_comment_end');
        }

        $this->set(get_defined_vars());
    }
}
