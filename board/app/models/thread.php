<?php
class Thread extends AppModel
{
    const MIN_THREAD_LENGTH = 6;
    const MAX_THREAD_LENGTH = 30;
    
    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', self::MIN_THREAD_LENGTH, self::MAX_THREAD_LENGTH
            )
        )
    );

    /*
    *Get fields from a single thread
    *@param $thread_id
    */
    public static function get($thread_id)
    {
        $user = "(SELECT username from user where user.id = thread.user_id)";
        $query = "SELECT id, title, created, view , $user AS username FROM thread WHERE id = ?";

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

        $user = "(SELECT username from user where user.id = thread.user_id)";
        $query = "SELECT id, title, created, view , $user AS username FROM thread 
                  ORDER BY updated DESC LIMIT {$limit}";

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

        $user_name = "(SELECT username from user where user.id = comment.user_id)";
        $user_type = "(SELECT type from user where user.id = comment.user_id)";
        $user_registered = "(SELECT registered from user where user.id = comment.user_id)";
        $query = "SELECT id, thread_id, body, created, user_id, updated, 
                  $user_name AS username, $user_type AS type, $user_registered AS registered 
                  FROM comment WHERE thread_id = ?
                  ORDER BY created ASC LIMIT {$limit}";

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
    public function delete()
    {
        $db = DB::conn();
        $db->query(
            'DELETE FROM thread WHERE id = ?', 
            array($this->id)
        );
    }

    /*
    *Rename thread
    */
    public function rename()
    {
        $this->validate();

        if ($this->hasError()) {
            throw new ValidationException('invalid thread name');
        }

        $db = DB::conn();
        $db->update('thread', array('title' => $this->title), array('id' => $this->id));
    }

    /*
    *Search threads
    *@params $keyword, $filter, $limit
    */
    public static function search($keyword, $filter, $limit)
    {
        $threads = array();
        $like = "%$keyword%";
        $params = array($like);

        switch ($filter) {
            case "title":
                $where = "WHERE title LIKE ?";
                break;
            case "created":
                $where = "WHERE created LIKE ?";
                break;
            default:
                $where = "WHERE title LIKE ? OR created LIKE ?";
                $params = array($like, $like);
                break;
        }

        $user = "(SELECT username from user where user.id = thread.user_id)";
        $query = "SELECT id, title, created, updated, view, $user AS username
                  FROM thread {$where} ORDER BY updated DESC LIMIT {$limit}";

        $db = DB::conn();
        $rows = $db->rows($query, $params);
        
        foreach ($rows as $row) {
            $threads[] = new self($row);
        }
        return $threads;
    }

    public static function count()
    {
        $db = DB::conn();
        return $db->value("SELECT count(id) FROM thread");
    }

    /*
    *Get the last post from a thread
    *@param $thread_id
    */
    public static function getLastPost($thread_id)
    {
        $user = "(SELECT username from user where user.id = comment.user_id)";
        $query = "SELECT created, $user AS username
                  FROM comment WHERE thread_id = ?
                  ORDER BY created DESC";

        $db = DB::conn();
        $row = $db->row($query, array($thread_id));

        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }
        return new self($row);
    }

    /*
    *Add View Count
    */
    public function viewAdd()
    {
        $db = DB::conn();
        $view_inc = $this->view + 1;
        $db->update('thread', array('view' => $view_inc), array('id' => $this->id));
    }
}