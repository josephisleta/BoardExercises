<?php
class Comment extends AppModel
{   
    const MIN_COMMENT_LENGTH = 1;
    const MAX_COMMENT_LENGTH = 200;

    public $validation = array(
        'body' => array(
            'length' => array(
                'validate_between', self::MIN_COMMENT_LENGTH, self::MAX_COMMENT_LENGTH
            )
        )
    );

    /*
    *Inserts new comment on a thread
    *@param $thread
    */
    public function write($thread)
    {
        $params = array(
            "thread_id" => $thread->id,
            "user_id" => $this->user_id,
            "body" => $this->body
        );
        $db = DB::conn();

        try {
            $db->begin();

            if (!$this->validate()) {
                throw new ValidationException('invalid comment');
            }

            $db->insert('comment', $params);
            $db->update('thread', array('updated' => date('Y-m-d H:i:s')), array('id' => $thread->id));

            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }

    /*
    *Edit a comment
    */
    public function edit()
    {   
        $this->validate();

        if ($this->hasError()) {
            throw new ValidationException('invalid comment');
        }

        $params = array(
            'body' => $this->body,
            'updated' => date('Y-m-d H:i:s')
        );

        $where_params = array(
            'id' => $this->id,
            'thread_id' => $this->thread_id,
            'user_id' => $this->user_id
        );

        $db = DB::conn();
        $db->update('comment', $params, $where_params);
    }

    /*
    *Delete a comment
    */
    public function delete()
    {
        $db = DB::conn();
        $db->query("DELETE FROM comment WHERE id = ?", array($this->id));
    }

    /*
    *Get fields of a single comment
    *@param $id
    */
    public static function get($id)
    {
        $query = "SELECT comment.id, comment.user_id, comment.thread_id, user.username, comment.body, comment.created 
                  FROM comment INNER JOIN user ON comment.user_id = user.id WHERE comment.id = ?";

        $db = DB::conn();
        $row = $db->row($query, array($id));
        
        return ($row) ? new self($row) : null;
    }

    /*
    *Count the number of comments on a thread
    *@param $thread_id
    */
    public static function count($thread_id)
    {
        $db = DB::conn();
        return $db->value("SELECT count(id) FROM comment WHERE thread_id = ?", array($thread_id));
    }
}
