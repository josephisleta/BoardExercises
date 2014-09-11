<?php
class Comment extends AppModel
{   
    const MIN_COMMENT_LENGTH = 1;
    const MAX_COMMENT_LENGTH = 200;

    public $validation = array(
        'body' => array(
            'length' => array('validate_between', self::MIN_COMMENT_LENGTH, self::MAX_COMMENT_LENGTH),
        ),      
    );

    /*
    *Inserts new comment on a thread
    *@param $thread
    */
    public function createComment($thread)
    {
        $params = array(
            "thread_id" => $thread->id,
            "username" => $this->username,
            "body" => $this->body
        );
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $db->insert('comment', $params);
    }

    public static function countThreadComments($thread_id)
    {
        $db = DB::conn();
        return $db->value("SELECT count(id) FROM comment WHERE thread_id = ?", array($thread_id));
    }
}
