<?php
	namespace Models\Common;

	//Core
	use Core\Database;

	//Libs
	use PDO as PDO;

	
	class Invoice extends Database
	{
		public function getAll(){
			// The query below will get results from the table invoices ordered by the date of the invoice creation.
			$invoices = parent::q("
				SELECT *, DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date, DATE_FORMAT(created_at, '%d-%m-%Y %H:%i:%s') AS created_at, FORMAT(vat_rate, 0) AS vat_rate
				FROM invoices 
				ORDER BY UNIX_TIMESTAMP(created_at) DESC
			")->fetchAll(parent::FETCH_ASSOC);

			return $invoices;
		}

		
		public static function getAllWithOffsetAndLimit($offset, $limit){
			/* 
				* The query below will get results from the table invoices with a limit and an offset ordered by the date of the invoice creation.
				* Note that there is a mysql functionality in the query called SQL_CALC_FOUND_ROWS, when used i can the get all the rows from the table without having
				* to execute a more heavy query such as SELECT COUNT(*) FROM invoices, instead mysql has another functionality called FOUND_ROWS(), which can be used
				* after using SQL_CALC_FOUND_ROWS to get all the rows from the table.
				* Getting all the rows from the table is usefull for creating a pagination
			*/

			$invoices = parent::q("
				SELECT SQL_CALC_FOUND_ROWS *, DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date, DATE_FORMAT(created_at, '%d-%m-%Y %H:%i:%s') AS created_at, FORMAT(vat_rate, 0) AS vat_rate
				FROM invoices 
				ORDER BY UNIX_TIMESTAMP(created_at) DESC 
				LIMIT $offset, $limit
			")->fetchAll(parent::FETCH_ASSOC);


			// Returnig the invoices (results of the query), and the total number of rows in the table (Explanation it's on the previous comment)
			return [
				"invoices" => $invoices,
				"number_of_rows" => parent::$db->query('SELECT FOUND_ROWS()')->fetchColumn()
			];
		}

		public static function changeStatus($id, $status){
			// Updating the the invoice with a prepared statement to avoic SQL injection
			parent::q("UPDATE invoices SET invoice_status = :status WHERE id = :id", [
				"status" => [$status, parent::PARAM_STR],
				"id" => [$id, parent::PARAM_INT]
			]);
		}

		public function getCustomerReportData(){
			/*
				* The query below will get results from the table invoices ordered by the date of the invoice creation.
				* Note that in this query there are 2 values, total_amount_paid and total_outstanding_amount.
				* To obtain the total amount paid, first I check if the invoice has been paid, if not it will be 0, otherwise, it will sum all the amounts of the items
				* in the table invoice_items associated to the invoice.
				* To obtain the total outstanding amount the calculation is the invoice_amount minus the total_amount_paid
			*/

			$invoices = parent::q("
				SELECT id, client, invoice_amount AS total_invoiced_amount,
				(
					IF(
						invoice_status = 'paid',
						(SELECT SUM(amount) FROM invoice_items WHERE invoice_id = invoices.id),
						0
					)
				) AS total_amount_paid,
				(
					invoice_amount - 
					IF(
						invoice_status = 'paid',
						(SELECT SUM(amount) FROM invoice_items WHERE invoice_id = invoices.id),
						0
					)
				) AS total_outstanding_amount
				FROM invoices
				ORDER BY UNIX_TIMESTAMP(created_at) DESC
			")->fetchAll(parent::FETCH_ASSOC);

			return $invoices;
		}
	}
?>