<?php
class Pagination
{
    public static $pagenum = 1;
    public static $last_page;
    public static $limit;
    public static $pagination = array();
    
    const MAX_PER_PAGE = 10;
    const MAX_PAGE_LINKS = 4;
    
    //  Get the current page
    public static function getCurrentPage($row_length)
    {
        $last_page = self::getLastPage($row_length);
        if (isset($_GET['pn'])) {
            self::$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
        }
        if (self::$pagenum > $last_page) {
            self::$pagenum = $last_page;
        }
        return self::$pagenum;
    }
    
    //  Get the last page
    public static function getLastPage($row_length)
    {
        self::$last_page = ceil($row_length/self::MAX_PER_PAGE);
        if (self::$last_page < 1) {
            self::$last_page = 1;
        }
        return self::$last_page;
    }
    
    //  Get the number of items to be displayed per page
    public static function getLimit($row_length)
    {
        $currpage = self::getCurrentPage($row_length);
        self::$limit = ($currpage - 1) * self::MAX_PER_PAGE .',' .self::MAX_PER_PAGE;
        return self::$limit;
    }
    
    //  Display the links
    public static function getControls($row_length)
    {
        $pagenum = self::getCurrentPage($row_length);
        $last_page = self::getLastPage($row_length);
        $limit = self::getLimit($row_length);
        $page_url =& $url['pn'];
        $pageControls = '';

        if ($last_page != 1) {
            if ($pagenum > 1) {
                $page_url = $pagenum - 1;
                $pageControls .= '<a href="'. url('', $url) .'">Previous</a> &nbsp; &nbsp; ';
                for ($i = $pagenum - self::MAX_PAGE_LINKS ; $i < $pagenum ; $i++) {
                    if ($i > 0) {
                        $pageControls .= '<a href="'. url('', $url) .'">'.$i.'</a> &nbsp; ';
                    }
                }
            }
            $pageControls .= ''.$pagenum.' &nbsp; ';
            for ($i = $pagenum + 1 ; $i <= $last_page ; $i++) {
                $page_url = $i;
                $pageControls .= '<a href="'.url('', $url).'">'.$i.'</a> &nbsp; ';
                if ($i >= $pagenum + self::MAX_PAGE_LINKS) {
                    break;
                }
            }
            if ($pagenum != $last_page) {
                $page_url = $pagenum + 1;
                $pageControls .= '&nbsp; &nbsp; <a href="'.url('', $url).'">Next</a>';
            }
        }

        self::$pagination = array(
            'pagenum' => $pagenum,
            'last_page' => $last_page,
            'maximum' => $limit,
            'control' => $pageControls,
        );

        return self::$pagination;
    }
}
