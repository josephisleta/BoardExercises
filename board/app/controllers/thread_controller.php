<?php
class ThreadController extends AppController
{
	public function index()
	{
		if (is_logged_in() === false) {
			redirect($url = 'not_logged_in');
		}

		$total_thread = Thread::countRowThread();
		$page = new Pagination();
		$pagination = $page::setControls($total_thread);
		$threads = Thread::getAll($pagination['maximum']);
		
		$this->set(get_defined_vars());
	}
	
	/*
	*Creates a new thread
	*/
	public function create()
	{
		if (is_logged_in() === false) {
			redirect($url = 'not_logged_in');
		}
		
		$thread = new Thread;
		$comment = new Comment;
		$page = Param::get('page_next','create');
		
		switch ($page) {
			case 'create':
				break;
			case 'create_end':
				$thread->title = Param::get('title');
				$comment->username = Param::get('username');
				$comment->body = Param::get('body');
				try {
					$thread->create($comment);
				} catch (ValidationException $e) {
					$page = 'create';
				}
				break;
			default:
				throw new NotFoundException("{$page} is not found");
				break;
		}

		$this->set(get_defined_vars());
		$this->render($page);
	}
	
	/*
	*Displays comments on each thread
	*/
	public function view()
	{
		if (is_logged_in() === false) {
			redirect($url = 'not_logged_in');
		}

		$thread = Thread::get(Param::get('thread_id'));
		$total_comment = Thread::countRowComment(Param::get('thread_id'));
		$page = new Pagination();
		$pagination = $page::setControls($total_comment);
		$threads = Thread::getAll($pagination['maximum']);
		
		$comments = $thread->getComments();
		$this->set(get_defined_vars());
	}

	/*
	*Writes comments on a thread
	*/
	public function write()
	{
		if (is_logged_in() === false) {
			redirect($url = 'not_logged_in');
		}
		
		$thread = Thread::get(Param::get('thread_id'));
		$comment = new Comment;
		$page = Param::get('page_next','write');
		
		switch ($page) {
			case 'write':
				break;
			case 'write_end':
				$comment->username = Param::get('username');
				$comment->body = Param::get('body');
				try {
					$thread->write($comment);
				} catch (ValidationException $e) {
					$page = 'write';
				}
				break;
			default:
				throw new NotFoundException("{$page} is not found");
				break;
		}

		$this->set(get_defined_vars());
		$this->render($page);
	}
}
