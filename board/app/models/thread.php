<?php
class Thread extends AppModel
{
    const THREAD_MIN_LENGTH = 1;
    const THREAD_MAX_LENGTH = 30;
    
    public $id;
    public $title;

    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', self::THREAD_MIN_LENGTH, self::THREAD_MAX_LENGTH,
            ),
        ),
    );

    /*
    *Get fields from a single thread
    *@param $id
    */
    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }
        return new self($row);
    }

    /*
    *Get all threads from the database
    *@param $limit_query
    */
    public static function getAll($limit_query)
    {
        $threads = array();

        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM thread ORDER BY created DESC $limit_query");

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }
        return $threads;
    }

    /*
    *Get all comments from a specific thread
    *@param $limit_query
    */
    public function getComments($limit_query)
    {
        $comments = array();

        $db = DB::conn();
        $rows = $db->rows("SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC $limit_query",array($this->id));

        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }
        return $comments;
    }

    public static function count()
    {
        $db = DB::conn();
        return $db->value("SELECT count(id) FROM thread");
    }
}