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
                          <a href="javascript:void(0);" class="product-link <?php echo in_array($foods->menu_id, $purchasedArray) ? 'disabled' : ''; ?>">
                            <form action="<?= base_url('order/add/'); ?>" method="POST">
                              <input type="hidden" value="<?php echo $foods->menu_id; ?>" name="menu_id">
                              <input type="hidden" value="<?= $transaction_id; ?>" name="transaction_id">
                              <input type="hidden" value="1" name="quantity">
                              <input type="hidden" value="<?= $foods->menu_name; ?>" name="name">
                              <input type="hidden" value="<?= $foods->menu_final_price; ?>" name="price">
                            </form>

                            <div class="card card-product-grid h-100 mb-0 <?php echo in_array($foods->menu_id, $purchasedArray) ? 'disabled' : ''; ?>">
                              <div class="img-wrap" style="background-image: url('../assets/img/<?php echo $foods->menu_picture; ?>')"></div>

                              <div class="card-body">
                                <div class="text-menu">
                                  <?php echo $foods->menu_name; ?>
                                </div>

                                <?php if ($foods->menu_discount > 0) : ?>
                                  <div class="text-price text-discount"><strike>Rp. <?php echo number_format($foods->menu_price); ?></strike>
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
              <div class="card mb-3 order-detail">
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

                  <p id="order-items"><strong>Order items</strong></p>

                  <div class="orders">
                    <?php if (!empty($orders)) :
                      foreach ($orders as $order) : ?>
                        <div class="row my-3 items">
                          <form method="POST">
                            <input type="hidden" value="<?= $order->transaction_id; ?>" name="transaction_id">
                            <input type="hidden" value="<?= $order->order_id; ?>" name="order_id">
                            <input type="hidden" value="<?= $order->menu_id; ?>" name="menu_id">
                            <input type="hidden" value="<?= $order->order_quantity; ?>" name="amount">
                            <input type="hidden" value="<?= $order->menu_final_price; ?>" name="price">
                          </form>
                          <div class="col col-5">
                            <p class="cart-product-name"><strong><?= $order->menu_name; ?></strong><br>
                              @ <span class="price"><?= $order->menu_final_price; ?></span>
                            </p>
                          </div>
                          <div class="col col-4">
                            <button class="btn btn-sm btn-circle btn-danger kurang"> - </button>
                            <span class="mx-1"><?= $order->order_quantity; ?></span>
                            <button class="btn btn-sm btn-circle btn-primary tambah"> + </button>
                          </div>
                          <div class="col col-3">
                            <p style="text-align: right;" class="subtotal-product"><?= $order->order_subtotal; ?></p>
                          </div>
                        </div>
                    <?php endforeach;
                    endif; ?>
                  </div>

                  <hr class="sidebar-divider mt-3">

                  <div class="row">
                    <div class="col col-12">
                      <table style="width: 100%;">
                        <tr>
                          <td>
                            <p style="font-weight: bold;">Subtotal</p>
                          </td>
                          <td align="right">
                            <p id="subtotal"><?= $subtotal->order_subtotal; ?></p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p style="font-weight: bold;">Tax</p>
                          </td>
                          <td align="right">
                            <p id="tax"><?php $tax = $subtotal->order_subtotal * 0.1;
                                        echo $tax; ?></p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p style="font-weight: bold;">Total</p>
                          </td>
                          <td align="right">
                            <p id="total"><?php $total = $subtotal->order_subtotal + $tax;
                                          echo $total; ?></p>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>

                  <hr class="sidebar-divider mt-0">

                  <p><strong>Payment</strong></p>
                  <div class="row mb-3">
                    <div class="col col-5">
                      <select name="method" id="method" class="form-control">
                        <option value="0" disabled selected>Method...</option>
                        <option value="1">Cash</option>
                        <option value="2">Go Pay</option>
                      </select>
                    </div>
                    <div class="col col-5">
                      <input type="number" class="form-control" name="amount" placeholder="Amount...">
                    </div>
                    <div class="col col-2">
                      <button class="btn btn-primary float-right addPayment btn-circle">+</button>
                    </div>
                  </div>

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
    $(document).on('click', '.btn', function() {
      this.blur()
    });

    $('.card').on('click', '.addPayment', function() {
      let parent = $(this).parent().parent();
      parent.after(`
        <div class="row mb-3">
          <div class="col col-5">
            <select name="method" id="method" class="form-control">
              <option value="0" disabled selected>Method...</option>
              <option value="1">Cash</option>
              <option value="2">Go Pay</option>
            </select>
          </div>
          <div class="col col-5">
            <input type="number" class="form-control" name="amount" placeholder="Amount...">
          </div>
          <div class="col col-2">
            <button class="btn btn-primary float-right addPayment btn-circle">+</button>
          </div>
        </div>
      `);

      $(this).removeClass('btn-primary');
      $(this).removeClass('addPayment');

      $(this).html('-');
      $(this).addClass('btn-danger');
      $(this).addClass('removePayment');
    });

    $('.card').on('click', '.removePayment', function() {
      let parent = $(this).parent().parent();
      parent.remove();
    });


    $('.order-detail').on('click', '.btn', function() {
      let parent = $(this).parent();
      let sibling = parent.siblings();
      let amountSpan = parent.children('span');
      let amount = Number(parent.siblings("form").children("input[name='amount']").val());
      let order_id = Number(parent.siblings("form").children("input[name='order_id']").val());
      let menu_id = Number(parent.siblings("form").children("input[name='menu_id']").val());
      let price = Number(parent.siblings("form").children("input[name='price']").val());

      if ($(this).hasClass("tambah")) {
        amount += 1;
        parent.siblings("form").children("input[name='amount']").val(amount);
      } else {
        amount -= 1;
        parent.siblings("form").children("input[name='amount']").val(amount);
      }

      let action = "<?= base_url('order/'); ?>";

      if (amount == 0) {
        action += "delete/";
      } else {
        action += "edit/";
      }

      $.ajax({
        url: action,
        type: "POST",
        data: parent.siblings("form").serialize(),
        success: function(data) {
          var json = JSON.parse(data);

          if (amount == 0) {
            let link = $('.product-link').children("form").children("input[name='menu_id'][value='" + menu_id + "']");
            link.parents('a').removeClass("disabled");
            link.parents('a').prop("href", "javascript:void(0);");

            let productDiv = link.parent().siblings('.card-product-grid');
            productDiv.removeClass("disabled");
            parent.parent().remove();
          } else {
            price *= amount;
            amountSpan.html(amount);
            let subtotalDiv = sibling.find('.subtotal-product');
            subtotalDiv.html(price);
          }

          $('#subtotal').html(json["subtotal"]);
          $('#tax').html(json["tax"]);
          $('#total').html(json["total"]);
        }
      });
    });

    $('.product-link').click(function() {
      let transaction_id = $(this).children('form').children("input[name='transaction_id']").val();
      let menu_id = $(this).children('form').children("input[name='menu_id']").val();
      let name = $(this).children('form').children("input[name='name']").val();
      let price = $(this).children('form').children("input[name='price']").val();
      let quantity = 1;
      let subtotal = price * quantity;

      $(this).addClass("disabled");
      $(this).removeAttr("href");
      $(this).children(".card").addClass("disabled");

      $.ajax({
        url: $(this).children('form').attr('action'),
        type: "POST",
        data: $(this).children('form').serialize(),
        success: function(data) {
          var json = JSON.parse(data);
          console.log(json);
          if (json["status"] == true) {
            let order_id = Number(json["order_id"]);

            $('#subtotal').html(json["subtotal"]);
            $('#tax').html(json["tax"]);
            $('#total').html(json["total"]);

            $('.orders').append(
              `<div class="row my-3 items">
                <form method="POST">
                  <input type="hidden" value="` + transaction_id + `" name="transaction_id">
                  <input type="hidden" value="` + order_id + `" name="order_id">
                  <input type="hidden" value="` + menu_id + `" name="menu_id">
                  <input type="hidden" value="1" name="amount">
                  <input type="hidden" value="` + price + `" name="price">
                </form>
                <div class="col col-5">
                  <p class="cart-product-name"><strong>` + name + `</strong><br>
                    @ <span class="price">` + price + `</span>
                  </p>
                </div>
                <div class="col col-4">
                  <button class="btn btn-sm btn-circle btn-danger kurang"> - </button>
                  <span class="mx-1">` + quantity + `</span>
                  <button class="btn btn-sm btn-circle btn-primary tambah"> + </button>
                </div>
                <div class="col col-3">
                  <p style="text-align: right;" class="subtotal-product">` + subtotal + `</p>
                </div>
              </div>`
            );
          }
        }
      });
    });
  </script>


</body>

</html>