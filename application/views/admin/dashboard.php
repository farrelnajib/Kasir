<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view('admin/_partials/head'); ?>
  <link rel="stylesheet" href="<?= base_url('assets/css/invoice.css'); ?>">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php $this->load->view('admin/_partials/sidebar'); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php $this->load->view('admin/_partials/topbar'); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <?php $this->load->view('admin/_partials/alerts'); ?>
          <div id="alert"></div>

          <?php $this->load->view('admin/_partials/breadcrumbs'); ?>

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Daily)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($todayEarnings); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($thisMonthEarnings); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">MENU</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalMenu; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">TRANSACTIONS (MONTHLY)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalTransactions; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col col-xl-6 col-md-12 mb-4">
              <div class="card shadow">
                <div class="card-header">
                  <h4 class="text-primary card-title m-0">
                    <strong>Top Sellings</strong>
                  </h4>
                </div>
                <div class="card-body">
                  <canvas id="topSales"></canvas>
                </div>
              </div>
            </div>
            <div class="col col-xl-6 col-md-12 mb-4">
              <div class="card shadow">
                <div class="card-header">
                  <h4 class="text-primary card-title m-0">
                    <strong>Monthly Earnings</strong>
                  </h4>
                </div>
                <div class="card-body">
                  <canvas id="monthlyEarnings"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col col-12">
              <div class="card shadow mb-4">
                <div class="card-header">
                  <div class="row">
                    <div class="col col-12">
                      <h4 class="text-primary card-title m-0"><strong>Transactions</strong></h4>
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
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php $this->load->view('admin/_partials/footer') ?>
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
  <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/invoice.js"></script>

</body>

</html>