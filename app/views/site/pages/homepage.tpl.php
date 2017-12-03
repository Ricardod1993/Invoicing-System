<div class="row" id="page-top-buttons-wrapper">
	<div class="col-12 text-right">
		<a href="/export/transactions" class="btn btn-primary">Export Transactions</a>
		<a href="/export/customer_report" class="btn btn-primary">Export Customer Report</a>
	</div>
</div>

<div class="row">		
	<div class="col-12">
		<div class="card">
			<div class="card-header">Invoices List</div>
			<div class="card-block">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="text-center">ID</th>
								<th width="200">Client</th>
								<th width="130">Amount</th>
								<th width="200">Amount plus VAT</th>
								<th class="text-center">VAT Rate</th>
								<th>Status</th>
								<th>Date</th>
								<th>Created At</th>
							</tr>
						</thead>

						<tbody id="invoices-list">
							<?php
								// Variable content it's where all the values passed in the controller to the view are stored 
								$pagination = $content->pagination;

								$invoices = $content->invoices;

								if($invoices){
									foreach($invoices as $invoice) {
							?>
										<tr>
											<td align="center" width="10"><?= $invoice['id'] ?></td>
											<td><?= $invoice['client'] ?></td>
											<td><?= $invoice['invoice_amount'] ?>€</td>
											<td><?= $invoice['invoice_amount_plus_vat']; ?>€</td>
											<td align="center"><?= $invoice['vat_rate']; ?>%</td>
											<td>
												<select class="form-control invoice-status-changer" data-invoiceid="<?= $invoice['id']; ?>">
													<option value="paid" <?= $invoice['invoice_status'] == "paid" ? "selected" : ""; ?>>Paid</option>
													<option value="unpaid" <?= $invoice['invoice_status'] == "unpaid" ? "selected" : ""; ?>>Not paid</option>
												</select>
											</td>
											<td><?= $invoice['invoice_date']; ?></td>
											<td><?= $invoice['created_at']; ?></td>
										</tr>
							<?php
								    }
							    }
							?>
						</tbody>
					</table>
				</div>

				<?php
					$number_of_pages = $pagination->pages;

					if($number_of_pages > 1){
				?>
						<ul class="pagination" id="invoice-list-pagination" data-limit="<?= $content->limit ?>">
							<li class="page-item <?= $conten->page == 1 ? 'disabled' : ''; ?>">
								<a class="page-link backward" href="javascript:"><</a>
							</li>

							<?php
								for ($i=1; $i <= $number_of_pages; $i++) { 
							?> 
									<li class="page-item <?= $i == $content->page ? 'active' : ''; ?>">
										<a class="page-link" href="javascript:" data-page="<?= $i ?>"><?= $i ?></a>
									</li>
							<?php
								}
							?>

							<li class="page-item <?= $content->page == $number_of_pages ? 'disabled' : ''; ?>">
								<a class="page-link forward" href="javascript:">></a>
							</li>
						</ul>
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>