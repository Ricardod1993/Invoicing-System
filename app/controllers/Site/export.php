<?php
	namespace Controllers\Site;

	//Models
	use Models\Common\Invoice as Invoice;

	class Export
	{
		public function transactions(){
			header('Content-Type: application/excel'); // Must be of type application/excel, when the file is downloaded the output will be of this type
			header('Content-Disposition: attachment; filename="transactions.csv"'); // Basicaly defining the name of the file

			$fp = fopen('php://output', 'w'); // Open a file only for writing

			$list[] = ["Invoice ID", "Company Name", "Invoice Amount"]; // Setting the titles of the columns
		
			//Looping through the title		
			for ($i=0; $i < count($list); $i++) { 
				fputcsv($fp, $list[$i]); // Adding a title column into the first row of the csv file
			}

			$invoices = Invoice::getAll(); // See file /app/models/Common/Invoice, function getAll()
			// Checking if has invoices
			if($invoices){
				//Looping through the invoices
				for ($i=0; $i < count($invoices); $i++) { 
					// Adding a row into the csv file and the values into their respective columns
					fputcsv($fp, [$invoices[$i]['id'], $invoices[$i]['client'], $invoices[$i]['invoice_amount']]);
				}
			}

			fclose($fp); // Closing the file and then the file will be downloaded
 
			exit();
		}

		public function customer_report(){
			header('Content-Type: application/excel'); // Must be of type application/excel, when the file is downloaded the output will be of this type
			header('Content-Disposition: attachment; filename="customer_report.csv"'); // Basicaly defining the name of the file


			$fp = fopen('php://output', 'w'); // Open a file only for writing

	
			$list[] = ["Company Name", "Total Invoiced Amount", "Total Amount Paid", "Total Amount Outstanding"]; // Setting the titles of the columns

			//Looping through the title	
			for ($i=0; $i < count($list); $i++) { 
				fputcsv($fp, $list[$i]); // Adding a title column into the first row of the csv file
			}

			$invoices = Invoice::getCustomerReportData(); // See file /app/models/Common/Invoice, function getCustomerReportData()
			// Checking if has invoices
			if($invoices){
				for ($i=0; $i < count($invoices); $i++) { 
					// Adding a row into the csv file and the values into their respective columns
					fputcsv($fp, [$invoices[$i]['client'], $invoices[$i]['total_invoiced_amount'], $invoices[$i]['total_amount_paid'], $invoices[$i]['total_outstanding_amount']]);
				}
			}

			fclose($fp); // Closing the file and then the file will be downloaded

			exit();
		}
	}
?>