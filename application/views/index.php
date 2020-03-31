<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view('_partials/head'); ?>

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

          <div class="row">

            <!-- List barang -->
            <div class="col col-lg-7 col-md-12 col-12">
              <?php foreach ($category as $category) :
                $id = $category->category_id;
                if (!empty($menu[$id])) : ?>
                  <h1 class="h3 mt-3 text-gray-800"><?php echo $category->category_name; ?></h1>

                  <div class="row">
                    <?php foreach ($menu[$id] as $foods) :
                      if ($foods->status == 1) : ?>
                        <div class="col col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 mb-4">
                          <a href="<?php echo base_url('order/add/' . $foods->menu_id); ?>">
                            <div class="card card-product-grid h-100 mb-0">
                              <div class="img-wrap" style="background-image: url('./assets/img/<?php echo $foods->menu_picture; ?>')"></div>

                              <div class="card-body">
                                <div class="text-menu">
                                  <?php echo $foods->menu_name; ?>
                                </div>

                                <?php if ($foods->menu_discount > 0) : ?>
                                  <div class="text-price"><strike>Rp. <?php echo number_format($foods->menu_price); ?></strike>
                                    <span class="badge badge-danger"><?php echo $foods->menu_discount; ?>%</span>
                                  </div>

                                <?php endif; ?>
                                <div class="text-price">Rp. <?php echo number_format($foods->menu_final_price); ?></div>
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

            <!-- Cart nya -->
            <div class="col col-lg-5 col-md-12 col-12">
              <h1 class="h3 mt-3 text-gray-800">Order Detail</h1>
              <div class="card mb-3">
                <div class="card-body">
                  <p style="font-weight: bold;">Customer</p>
                  <form action="#" method="post">
                    <div class="form-group">
                      <input type="text" name="name" id="name" class="form-control" placeholder="Nama...">
                    </div>
                    <div class="form-group">
                      <input type="text" name="telp" id="telp" class="form-control" placeholder="No Telp...">
                    </div>

                    <input type="submit" value="Save" class="btn btn-primary btn-block">
                  </form>

                  <hr class="sidebar-divider mt-3">

                  <p style="font-weight: bold;">Order Items</p>

                  <div class="row my-3">
                    <div class="col col-5">
                      <p><strong>Chum Stick</strong><br>
                        @ 15,000
                      </p>
                    </div>
                    <div class="col col-4">
                      <button class="btn btn-sm btn-circle btn-danger kurang"> - </button>
                      <span class="mx-2">1</span>
                      <button class="btn btn-sm btn-circle btn-primary tambah"> + </button>
                    </div>
                    <div class="col col-3">
                      <p style="text-align: right;">15,000</p>
                    </div>
                  </div>

                  <div class="row my-3">
                    <div class="col col-5">
                      <p><strong>Kelp Nougat Crunch</strong><br>
                        @ 10,000
                      </p>
                    </div>
                    <div class="col col-4">
                      <button class="btn btn-sm btn-circle btn-danger kurang"> - </button>
                      <span class="mx-2">1</span>
                      <button class="btn btn-sm btn-circle btn-primary tambah"> + </button>
                    </div>
                    <div class="col col-3">
                      <p style="text-align: right;">20,000</p>
                    </div>
                  </div>

                  <hr class="sidebar-divider mt-3">

                  <table style="width: 100%;">
                    <tr>
                      <td>
                        <p style="font-weight: bold;">Subtotal</p>
                      </td>
                      <td align="right">
                        <p>30,000</p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-weight: bold;">Tax</p>
                      </td>
                      <td align="right">
                        <p>3,000</p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-weight: bold;">Total</p>
                      </td>
                      <td align="right">
                        <p>33,000</p>
                      </td>
                    </tr>
                  </table>

                  <input class="btn btn-block btn-primary" type="submit" name="order" id="order" value="Place order">
                </div>
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
  <?php $this->load->view('_partials/modal'); ?>

  <?php $this->load->view('admin/_partials/js'); ?>

  <script>
    $('.btn').click(function() {
      this.blur()
    });
  </script>


</body>

</html>