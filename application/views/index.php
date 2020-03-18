<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view('_partials/head'); ?>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php $this->load->view('_partials/sidebar'); ?>
    <!-- End of Sidebar -->

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

          <?php $this->load->view('_partials/breadcrumbs'); ?>

          <!-- Page Heading -->

          <?php foreach ($category as $category) :
            $id = $category->category_id; ?>
            <div class="row">
              <h1 class="h3 mt-3 text-gray-800"><?php echo $category->category_name; ?></h1>
            </div>

            <div class="row">
              <?php foreach ($menu[$id] as $foods) : ?>
                <div class="col col-lg-3 col-md-4 col-sm-6 col-12">
                  <div class="card card-product-grid">
                    <a href="<?php echo base_url('order/add/' . $foods->menu_id); ?>" class="img-wrap" style="background-image: url(./assets/img/<?php echo $foods->menu_picture; ?>);"></a>

                    <div class="card-body" align="center">
                      <a href="<?php echo base_url('order/add/' . $foods->menu_id); ?>" class="text-menu"><?php echo $foods->menu_name; ?></a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <hr>
          <?php endforeach; ?>


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
  <?php $this->load->view('_partials/modal'); ?>

  <?php $this->load->view('_partials/js'); ?>

</body>

</html>