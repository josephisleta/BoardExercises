<?php

class Thread extends AppModel
{
	public $id;
	public $title;

	public $validation = array(
					'title' => array(
						'length'=>array(
							'validate_between',1,30,),
							),
				);	

	public static function get($id)
	{
		$db = DB::conn();
		$row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));
		
		if(!$row){
			throw new RecordNotFoundException('no record found');
		}
		return new self($row);
	}

	public static function getAll()
	{
		$threads=array();
		
		$db = DB::conn();
		$rows = $db->rows('SELECT * FROM thread ORDER BY created DESC');

		foreach ($rows as $row){
			$threads[] = new Thread($row);
		}
		return $threads;
	}
	
	public function getComments()
	{
		$comments = array();
		
		$db = DB::conn();
		$rows = $db->rows(
					'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC',
					array($this->id)
		);
		
		foreach ($rows as $row){
			$comments[] = new Comment($row);
		}
		return $comments;
	}

	public function create(Comment $comment)
	{
		$params = array(
			"username" => $comment->username,
			"title" => $this->title,
			"created" => date('Y-m-d H:i:s')
		);
		$db = DB::conn();
		try{
			$db->begin();

			$this->validate();
			$comment->validate();

			if ($this->hasError() || $comment->hasError()) {
				throw new ValidationException('invalid thread or comment');
			}
			$db->insert('thread', $params);
			$this->id = $db->lastInsertId();
			$this->write($comment);

			$db->commit();
		}catch(ValidationException $e) {
			$db->rollback();
			throw $e;
		}
	}

	public function write(Comment $comment)
	{
		$params = array(
			"thread_id" => $this->id,
			"username" => $comment->username,
			"body" => $comment->body,
			
		);

		if (!$comment->validate()) {
			throw new ValidationException('invalid comment');
		}
		$db = DB::conn();
		$db->insert('comment', $params);
	}
}
