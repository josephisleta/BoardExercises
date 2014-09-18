<?php
class Thread extends AppModel
{
    const MIN_THREAD_LENGTH = 6;
    const MAX_THREAD_LENGTH = 30;
    
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
        $query = "SELECT thread.id, thread.title, thread.created, thread.view, user.username FROM thread
                  INNER JOIN user ON thread.user_id = user.id WHERE thread.id = ?";

        $db = DB::conn();
        $row = $db->row($query, array($thread_id));

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

        $query = "SELECT thread.id, thread.title, user.username, thread.created, thread.updated, thread.view FROM thread 
                  INNER JOIN user ON thread.user_id = user.id ORDER BY thread.updated DESC LIMIT {$limit}";
        
        $db = DB::conn();
        $rows = $db->rows($query);

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

        $query = "SELECT comment.id, comment.thread_id, user.username, comment.body, comment.created, comment.user_id
                  FROM comment INNER JOIN user ON comment.user_id = user.id
                  WHERE thread_id = ? ORDER BY created ASC LIMIT {$limit}";

        $db = DB::conn();
        $rows = $db->rows($query, array($this->id));

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
    public function create($comment)
    {
        $params = array(
            "user_id" => $comment->user_id,
            "title" => $this->title,
            "updated" => date('Y-m-d H:i:s')
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
            $comment->write($this);

            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }

    /*
    *Delete thread
    */
    public static function deleteThread($thread_id)
    {
        $db = DB::conn();
        $db->query('DELETE FROM thread WHERE id = ?', array($thread_id));
    }

    /*
    *Rename thread
    */
    public static function renameThread($id, $title)
    {
        $db = DB::conn();
        $db->update('thread', array('title' => $title), array('id' => $id));
    }

    public static function countThread()
    {
        $db = DB::conn();
        return $db->value("SELECT count(id) FROM thread");
    }

    public static function viewAdd($thread)
    {
        $db = DB::conn();
        $view = $thread->view;
        $db->update('thread', array('view' => ($view + 1)), array('id' => $thread->id));
    }
}