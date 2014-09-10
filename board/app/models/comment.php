<?php
class Comment extends AppModel
{   
    const MIN_COMMENT_LENGTH = 1;
    const MAX_COMMENT_LENGTH = 200;

    public $validation = array(
        'body' => array(
            'length' => array('validate_between', self::MIN_COMMENT_LENGTH, self::MAX_COMMENT_LENGTH,),
        ),      
    );

    /*
    *Creates new thread
    *Inserts first comment
    *@param $thread
    */
    public function create($thread)
    {
        $params = array(
            "username" => $this->username,
            "title" => $thread->title,
            "created" => date('Y-m-d H:i:s')
        );
        $db = DB::conn();
        try {
            $db->begin();

            $thread->validate();
            $this->validate();

            if ($thread->hasError() || $this->hasError()) {
                throw new ValidationException('invalid thread or comment');
            }
            $db->insert('thread', $params);
            $thread->id = $db->lastInsertId();
            $this->write($thread);

            $db->commit();
        } catch (ValidationException $e) {
            $db->rollback();
            throw $e;
        }
    }

    /*
    *Inserts new comment on a thread
    *@param $thread
    */
    public function write($thread)
    {
        $params = array(
            "thread_id" => $thread->id,
            "username" => $this->username,
            "body" => $this->body,
        );
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $db->insert('comment', $params);
    }

    public static function countThreadComments($id)
    {
        $db = DB::conn();
        return $db->value("SELECT count(id) FROM comment WHERE thread_id = ?",array($id));
    }
}
