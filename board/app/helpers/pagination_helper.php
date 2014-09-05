<?php
class Pagination
{
	public static $pagenum = 1;
	public static $last;
	public static $limit;
	public static $pagination = array();
	const MAX_PER_PAGE = 10;

	//	Get the current page
	public static function setCurrPage($row_length)
	{
		$last_page = self::setLastPage($row_length);
		if(isset($_GET['pn'])) {
			self::$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
		}
		if (self::$pagenum > $last_page) {
			self::$pagenum = $last_page;
		}
		return self::$pagenum;
	}

	//	Get the last page
	public static function setLastPage($row_length)
	{
		self::$last = ceil($row_length/self::MAX_PER_PAGE);
		if(self::$last < 1) {
			self::$last = 1;
		}
		return self::$last;
	}

	//	Get the limit of items to be displayed per page
	public static function setLimit($row_length)
	{
		$currpage = self::setCurrPage($row_length);
		self::$limit = 'LIMIT '.($currpage - 1) * self::MAX_PER_PAGE .',' .self::MAX_PER_PAGE;
		return self::$limit;
	}

	//	Displays the links
	public static function setControls($row_length)
	{
		$pagenum = self::setCurrPage($row_length);
		$last = self::setLastPage($row_length);
		$limit = self::setLimit($row_length);
		$page_url =& $url['pn'];
		$pageCtrls = '';
		if($last != 1) {
			if ($pagenum > 1) {
				$page_url = $pagenum - 1;
				$pageCtrls .= '<a href="'. url('', $url) .'">Previous</a> &nbsp; &nbsp; ';
				for($i = $pagenum-4; $i < $pagenum; $i++) {
					if($i > 0) {
						$pageCtrls .= '<a href="'. url('', $url) .'">'.$i.'</a> &nbsp; ';
					}
				}
			}
			$pageCtrls .= ''.$pagenum.' &nbsp; ';
			for($i = $pagenum+1; $i <= $last; $i++) {
				$page_url = $i;
				$pageCtrls .= '<a href="'.url('', $url).'">'.$i.'</a> &nbsp; ';
				if($i >= $pagenum+4) {
					break;
				}
			}
			if ($pagenum != $last) {
				$page_url = $pagenum + 1;
				$pageCtrls .= '&nbsp; &nbsp; <a href="'.url('', $url).'">Next</a>';
			}
		}
		self::$pagination['pagenum'] = $pagenum;
		self::$pagination['last_page'] = $last;
		self::$pagination['maximum'] = $limit;
		self::$pagination['control'] = $pageCtrls;

		return self::$pagination;
	}
}
