<?php
	namespace Controllers\Site;

	//Libs
	use Libs\Common\View as View;
	use Libs\Common\Pagination as Pagination;

	//Models
	use Models\Common\Invoice as Invoice;

	class Homepage
	{
		public function index(){
			$limit = 5; //The limit of rows per page
			$page = isset($_GET['page']) ? $_GET['page'] : 1; //Get the parameter page, if it doesn't exist the value will be 1

			$pagination = new Pagination($page, $limit); //Instatiating a pagination, see class in file: /app/libs/Common/Pagination.php

			//To see what this function does, go to /app/models/Common/Invoice and search for the function getAllWithOffsetAndLimit()
			$invoices_and_number_of_rows = Invoice::getAllWithOffsetAndLimit($pagination->offset, $pagination->limit);
			$invoices = $invoices_and_number_of_rows['invoices'];
			$number_of_rows = $invoices_and_number_of_rows['number_of_rows'];

			$pagination->setPages($number_of_rows); // explanation in file /app/libs/Common/Pagination.php, function setPages()


			// Setting the view and the values to pass to it, see file /app/libs/Common/View.php, function set()
			View::set("site/pages/homepage", [
				"invoices" => $invoices, 
				"pagination" => $pagination, 
				"limit" => $limit, 
				"page" => $page
			]);
		}
	}
?>