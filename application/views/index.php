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

          <!-- Search bar -->
          <form class="form-inline">
            <div class="input-group shadow" style="float: right;">
              <input type="text" id="search-bar" class="form-control border-0 small" placeholder="Search for...">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Page Heading -->

          <?php foreach ($category as $category) :
            $id = $category->category_id;
            if (!empty($menu[$id])) : ?>
              <h1 class="h3 mt-3 text-gray-800"><?php echo $category->category_name; ?></h1>

              <div class="row">
                <?php foreach ($menu[$id] as $foods) :
                  if ($foods->status == 1) : ?>
                    <div class="col col-lg-3 col-md-6 col-sm-6 col-12">
                      <a href="<?php echo base_url('order/add/' . $foods->menu_id); ?>">
                        <div class="card card-product-grid">
                          <a href="<?php echo base_url('order/add/' . $foods->menu_id); ?>"><img src="./assets/img/<?php echo $foods->menu_picture; ?>" alt="..." class="card-img-top"></a>

                          <div class="card-body">
                            <a href="<?php echo base_url('order/add/' . $foods->menu_id); ?>" class="text-menu">
                              <?php echo $foods->menu_name; ?>
                            </a>

                            <?php if ($foods->menu_discount > 0) : ?>
                              <p class="text-danger mb-0"><strike>Rp. <?php echo number_format($foods->menu_price); ?></strike>
                                <span class="badge badge-danger"><?php echo $foods->menu_discount; ?>%</span>
                              </p>

                            <?php endif; ?>
                            <p class="text-price">Rp. <?php echo number_format($foods->menu_final_price); ?></p>
                          </div>
                        </div>
                      </a>
                    </div>
                <?php endif;
                endforeach; ?>
              </div>
              <hr>

          <?php endif;
          endforeach; ?>


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

  <?php $this->load->view('admin/_partials/js'); ?>


</body>

</html>