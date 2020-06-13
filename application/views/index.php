<!DOCTYPE html>
<html lang="en">

<head>

	<?php $this->load->view('_partials/head'); ?>
	<link rel="stylesheet" href="<?= base_url('assets/css/invoice.css'); ?>">

</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">


		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<?php $this->load->view('_partials/topbar'); ?>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">
					<?php $this->load->view('_partials/alerts'); ?>
					<div id="alert"></div>

					<?php if (!empty($unfinished_transactions)) : ?>
						<div class="card shadow mb-4">
							<div class="card-header">
								<div class="row">
									<div class="col col-12">
										<h3 class="text-danger card-title mb-0"><strong>Unfinished Transactions</strong></h3>
									</div>
								</div>
							</div>

							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped menuDataTable" width="100%" cellspacing="0">
										<thead>
											<th>ID</th>
											<th>Name</th>
											<th>Phone / Email</th>
											<th>Total</th>
											<th>Action</th>
										</thead>

										<tbody>
											<?php foreach ($unfinished_transactions as $transaction) : ?>
												<tr>
													<td><?= $transaction->transaction_id; ?></td>
													<td><?= $transaction->customer_name; ?></td>
													<td><?= $transaction->customer_phone != null ? $transaction->customer_phone : $transaction->customer_email; ?></td>
													<td><?= number_format($transaction->transaction_total); ?></td>
													<td>
														<a href="<?= base_url('order/') . $transaction->transaction_id; ?>" class="btn btn-primary">Finish</a>
														<a href="<?= base_url('delete/') . $transaction->transaction_id; ?>" class="btn btn-danger">Delete</a>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<div class="card shadow mb-4">
						<div class="card-header">
							<div class="row">
								<div class="col col-12">
									<h3 class="text-primary card-title" style="margin-top:auto; margin-bottom:auto;"><strong>Transactions</strong></h3>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped menuDataTable" width="100%" cellspacing="0">
									<thead>
										<th>ID</th>
										<th>Name</th>
										<th>Phone / Email</th>
										<th>Total</th>
										<th>Receipt</th>
									</thead>

									<tbody>
										<?php foreach ($transactions as $transaction) : ?>
											<tr>
												<td><?= $transaction->transaction_id; ?></td>
												<td><?= $transaction->customer_name; ?></td>
												<td><?= $transaction->customer_phone != null ? $transaction->customer_phone : $transaction->customer_email; ?></td>
												<td><?= number_format($transaction->transaction_total); ?></td>
												<td align="center"><button class="btn btn-circle btn-primary" onclick="showInvoice(<?= $transaction->transaction_id; ?>)"><i class="fas fa-paperclip"></i></button></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>


				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<?php $this->load->view('_partials/footer') ?>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<?php $this->load->view('admin/_partials/modal'); ?>

	<?php $this->load->view('admin/_partials/js'); ?>
	<script src="<?php echo base_url(); ?>assets/js/invoice.js"></script>


</body>

</html>
