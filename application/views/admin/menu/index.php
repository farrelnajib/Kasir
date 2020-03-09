<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view('admin/_partials/head'); ?>

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

          <?php $this->load->view('admin/_partials/breadcrumbs'); ?>

          <?php $this->load->view('admin/_partials/alerts') ?>

          <!-- Page Heading -->
          <div class="card shadow">
            <div class="card-header">
              <div class="row">
                <div class="col col-6">
                  <h3 class="font-weight-bold text-primary card-title" style="margin-top:auto; margin-bottom:auto;">Menu list</h3>
                </div>
                <div class="col col-6" align="right">
                  <a class="btn btn-primary" href="<?php echo base_url('admin/menu/add') ?>"><i class="fas fa-plus"></i> Add new</a>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <th>Category</th>
                    <th>Menu</th>
                    <th>Price</th>
                    <th>Image file</th>
                    <th>Status</th>
                    <th class="action">Action</th>
                  </thead>

                  <tbody>
                    <?php foreach ($menu as $menu) : ?>
                      <tr>
                        <td><?php echo $menu->category_name; ?></td>
                        <td><?php echo $menu->menu_name; ?></td>
                        <td>Rp. <?php echo number_format($menu->menu_price, 0); ?></td>
                        <td><img src="<?php echo base_url('assets/img/') . $menu->menu_picture; ?>" style="max-width: 100px;"></td>
                        <td><?php echo $menu->status == 1 ? 'Available' : 'Out of stock'; ?></td>
                        <td align="center">
                          <a href="<?php echo base_url('admin/menu/details/') . $menu->menu_id ?>">
                            <i class="far fa-edit"></i>
                          </a>
                          <a href="<?php echo base_url('admin/menu/delete/') . $menu->menu_id ?>">
                            <i class="far fa-trash-alt" style="color: red;"></i>
                          </a>
                        </td>
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

</body>

</html>