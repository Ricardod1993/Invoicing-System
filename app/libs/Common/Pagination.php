<?php
	namespace Libs\Common;

	class Pagination{
		public $page, $limit, $offset, $pages;
		
		public function __construct($page, $limit){
			$this->page = $page;
			$this->limit = $limit;

			// Setting the offset, if the page is 1 then the offset would be 0, if 2 then the offset would be 5
			$this->offset = ($this->page > 1) ? ($this->page * $limit) - $limit : 0;
		}

		public function setPages($total){
			// total of rows / limit, in this case we have a total of 10 and a limit of 5, then 10 / 5 = 2, so 2 pages
			$this->pages = ceil($total / $this->limit); 
		}

	}
?>	