<?php
class Thread extends AppModel
{
    const MIN_THREAD_LENGTH = 1;
    const MAX_THREAD_LENGTH = 30;
    
    public $id;
    public $title;

    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', self::MIN_THREAD_LENGTH, self::MAX_THREAD_LENGTH
            ),
        ),
    );

    /*
    *Get fields from a single thread
    *@param $thread_id
    */
    public static function get($thread_id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($thread_id));

        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }
        return new self($row);
    }

    /*
    *Get all threads from the database
    *@param $limit
    */
    public static function getAll($limit)
    {
        $threads = array();

        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread ORDER BY created DESC LIMIT $limit");

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }
        return $threads;
    }

    /*
    *Get all comments from a specific thread
    *@param $limit
    */
    public function getComments($limit)
    {
        $comments = array();

        $db = DB::conn();
        $rows = $db->search('comment', 'thread_id = ?', array($this->id), 'created ASC', $limit);

        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }
        return $comments;
    }
    
    /*
    *Creates new thread
    *Inserts first comment
    *@param $comment
    */
    public function createThread($comment)
    {
        $params = array(
            "username" => $comment->username,
            "title" => $this->title
        );
        $db = DB::conn();
        try {
            $db->begin();

            $this->validate();
            $comment->validate();

            if ($this->hasError() || $comment->hasError()) {
                throw new ValidationException('invalid thread or comment');
            }
            $db->insert('thread', $params);
            $this->id = $db->lastInsertId();
            $comment->createComment($this);

            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }

    public static function countThread()
    {
        $db = DB::conn();
        return $db->value("SELECT count(id) FROM thread");
    }
}