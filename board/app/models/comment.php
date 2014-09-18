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

    public static function countThreadComments($thread_id)
    {
        $db = DB::conn();
        return $db->value("SELECT count(id) FROM comment WHERE thread_id = ?", array($thread_id));
    }
}
