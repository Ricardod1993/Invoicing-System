<?php
	namespace Controllers\Site;

	//Libs
	use Libs\Common\View as View;
	use Libs\Common\Pagination as Pagination;

	//Models
	use Models\Common\Invoice as Invoice;


	class Utilities
	{
		public function change_invoice_status(){
			// Checks if the necessary variables are set
			if(isset($_POST['invoice_id'], $_POST['status'])){
				// See file /app/models/Common/Invoice, function changeStatus
				$invoice = Invoice::changeStatus($_POST['invoice_id'], $_POST['status']);

				// Returning proceed = true, this is just to check if the request as worked fine in the javascript file
				echo json_encode(["proceed" => true]);
			}else{
				/*
					* Returning proceed = false, if false, then, an alert is presented to the user, just for us to know if an error as ocurred. 
					* The alert is coded in the js file.
				*/
				echo json_encode([
					"proceed" => false,
					"message" => "An error as ocurred."
				]);
			}

			exit();
		}

		public function change_invoices_list_page(){
			// Checks if the necessary variables are set
			if(isset($_POST['page'], $_POST['limit'])){
				$page = $_POST['page'];
				$limit = $_POST['limit'];

				$pagination = new Pagination($page, $limit); // See file /app/libs/Common/Pagination.php
				
				// See file /app/models/Common/Invoice.php, function getAllWithOffsetAndLimit()
				$invoices_and_number_of_rows = Invoice::getAllWithOffsetAndLimit($pagination->offset, $pagination->limit);

				$pagination->setPages($invoices_and_number_of_rows['number_of_rows']); // See file /app/libs/Common/Pagination.php, function setPages()

				// Checking if the function Invoice::getAllWithOffsetAndLimit returned something,
				if($invoices_and_number_of_rows){
					echo json_encode([
						"proceed" => true,
						"invoices" => $invoices_and_number_of_rows['invoices'],
						"total_pages" => $pagination->pages,
						"current_page" => $page
					]);
				}else{
					echo json_encode([
						"proceed" => false,
						"message" => "There is no more invoices."
					]);
				}
			}else{
				echo json_encode([
					"proceed" => false,
					"message" => "An error as ocurred."
				]);
			}

			exit();
		}
	}
?>