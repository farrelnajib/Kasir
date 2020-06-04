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


          <!-- Page Heading -->
          <div class="row">

            <!-- List barang -->
            <div class="col col-lg-7 col-md-12 col-12">
              <h1 class="h3 text-gray-800">Menu</h1>
              <form class="form-inline">
                <div class="input-group" style="width: 100%;">
                  <input type="text" id="search-bar" class="form-control border-0 small" placeholder="Search for..." autofocus="true">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </form>
              <?php foreach ($category as $category) :
                $id = $category->category_id;
                if (!empty($menu[$id])) : ?>
                  <h2 class="h4 mt-3 text-gray-800"><?php echo $category->category_name; ?></h2>

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
              <h1 class="h3 text-gray-800">Order Detail</h1>
              <div class="card mb-3 order-detail">
                <div class="card-body">

                  <!-- Customer details -->
                  <p style="font-weight: bold;">Customer</p>
                  <form method="POST">

                    <?php
                    $name = false;
                    $number = false;

                    if (empty($transaction[0]->customer_name)) : ?>
                      <div class="form-group">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nama...">
                      </div>
                    <?php else :
                      $name = true; ?>
                      <p class="text-cust-name">Name: <strong><?php echo $transaction[0]->customer_name; ?></strong> <a href="javascript:void(0);" id="NameButton"><i class="fa fa-edit"></i></a></p>
                    <?php endif; ?>

                    <?php if (!empty($transaction[0]->customer_phone)) :
                      $number = true; ?>
                      <p class="text-cust-phone">Phone: <strong><?= $transaction[0]->customer_phone; ?></strong> <a href="javascript:void(0);" id="PhoneButton"><i class="fa fa-edit"></i></a></p>
                    <?php elseif (!empty($transaction[0]->customer_email)) :
                      $number = true; ?>
                      <p class="text-cust-phone">Email: <strong><?= $transaction[0]->customer_email; ?></strong> <a href="javascript:void(0);" id="PhoneButton"><i class="fa fa-edit"></i></a></p>
                    <?php else : ?>
                      <div class="form-group">
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone or email...">
                      </div>
                    <?php endif; ?>

                  </form>

                  <hr class="sidebar-divider mt-3">

                  <!-- Order details -->
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
                            <button class="btn order-amount-btn btn-sm btn-circle btn-danger kurang"> - </button>
                            <span class="mx-1"><?= $order->order_quantity; ?></span>
                            <button class="btn order-amount-btn btn-sm btn-circle btn-primary tambah"> + </button>
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
                            <p id="subtotal"><?= $totals['subtotal']; ?></p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p style="font-weight: bold;">Tax</p>
                          </td>
                          <td align="right">
                            <p id="tax"><?= $totals['tax']; ?></p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p style="font-weight: bold;">Total</p>
                          </td>
                          <td align="right">
                            <p id="total"><?= $totals['total']; ?></p>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>

                  <hr class="sidebar-divider mt-0">

                  <p><strong>Payment</strong></p>
                  <?php $iterator = 1;
                  foreach ($payments as $payment) : ?>
                    <div class="row mb-3">
                      <input type="hidden" value="<?= $transaction_id; ?>" name="transaction_id">
                      <input type="hidden" value="<?= $payment->payment_id; ?>" name="payment_id">
                      <div class="col col-5">
                        <select name="method" id="method" class="form-control">
                          <?php foreach ($methods as $method) : ?>
                            <option value="<?= $method->method_id ?>" <?= $method->method_id == $payment->method_id ? 'selected' : ''; ?>><?= $method->method_name ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col col-5">
                        <input type="number" class="form-control" name="amount" placeholder="Amount..." value="<?= $payment->payment_amount; ?>">
                      </div>
                      <div class="col col-2">
                        <?php if ($iterator == count($payments)) : ?>
                          <button class="btn btn-primary float-right addPayment btn-circle">+</button>
                        <?php else : ?>
                          <button class="btn btn-danger float-right removePayment btn-circle">-</button>
                        <?php endif; ?>
                      </div>
                    </div>
                  <?php $iterator++;
                  endforeach; ?>

                  <hr class="sidebar-divider mt-0">

                  <div class="row">
                    <div class="col col-12">
                      <table style="width: 100%;">
                        <tr>
                          <td>
                            <p><strong>Total payments</strong></p>
                          </td>
                          <td align="right">
                            <p id="total-payment"><?= $totalPayments->total; ?></p>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p><strong>Changes</strong></p>
                          </td>
                          <td align="right">
                            <p id="changes"><?= $totalPayments->total - $totals['total']; ?></p>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>

                  <?php
                  $unset = false;
                  if ($totals["total"] == 0 || empty($transaction[0]->customer_name) || (empty($transaction[0]->customer_phone) && empty($transaction[0]->customer_email)) || $totalPayments->total == 0) {
                    $unset = true;
                  } ?>
                  <a href="<?= base_url('finishTransaction/') . $transaction_id; ?>" class="btn btn-block btn-primary <?= $unset ? 'disabled' : ''; ?>" id="closeBill">Close bill</a>
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
    let tid = <?= $transaction_id; ?>;

    let subtotal = <?= $totals['subtotal']; ?>;
    let tax = <?= $totals['tax']; ?>;
    let total = <?= $totals['total']; ?>;

    let paymentsJSON = <?php echo json_encode($payments); ?>;
    let payments = {};
    paymentsJSON.forEach(element => {
      payments['' + element.payment_id + ''] = Number(element.payment_amount);
    });
    let totalPayment = <?= $totalPayments->total; ?>;
    let changes = -(total);

    let isOrdering = <?= $totals["total"] > 0 ? 'true' : 'false'; ?>;
    let isNameFilled = <?= !empty($transaction[0]->customer_name) ? 'true' : 'false'; ?>;
    let isNumberFilled = <?= (!empty($transaction[0]->customer_phone || !empty($transaction[0]->customer_email))) ? 'true' : 'false'; ?>;
    let isPaymentFilled = <?= $totalPayments->total > 0 ? 'true' : 'false'; ?>;

    function checkButton() {
      if (isOrdering && isNameFilled && isNumberFilled && isPaymentFilled) {
        if ($("#closeBill").hasClass("disabled")) {
          $("#closeBill").removeClass('disabled');
        }
      } else {
        $('#closeBill').addClass('disabled');
      }
    }

    $(document).on('click', '.btn', function() {
      this.blur()
    });

    $('.card').on('click', '.addPayment', function() {
      let action = "<?= base_url('order/addPayment'); ?>";
      let thisElement = $(this);
      let parent = $(this).parent().parent();
      $.ajax({
        url: action,
        type: "POST",
        data: {
          'transaction_id': parent.find('input[name="transaction_id"]').val(),
          'method': parent.find('select').val()
        },
        success: function(data) {
          let json = JSON.parse(data);
          if (json["status"] == true) {
            parent.after( /*html*/ `
              <div class="row mb-3">
                <input type="hidden" value="<?= $transaction_id; ?>" name="transaction_id">
                <input type="hidden" value="` + json["payment_id"] + `" name="payment_id">
                <div class="col col-5">
                  <select name="method" id="method" class="form-control">
                    <?php foreach ($methods as $method) : ?>
                      <option value="<?= $method->method_id ?>"><?= $method->method_name ?></option>
                    <?php endforeach; ?>
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

            thisElement.removeClass('btn-primary');
            thisElement.removeClass('addPayment');

            thisElement.html('-');
            thisElement.addClass('btn-danger');
            thisElement.addClass('removePayment');
          } else {
            alert("Failed to save");
          }
        }
      });
    });

    $('.card').on('click', '.removePayment', function() {
      let parent = $(this).parent().parent();
      let paymentID = parent.children('input[name="payment_id"]').val();
      let action = "<?= base_url('order/removePayment'); ?>";

      $.ajax({
        url: action,
        method: "POST",
        data: {
          "payment_id": paymentID
        },
        success: function(data) {
          let json = JSON.parse(data);

          if (json["status"]) {
            totalPayment -= payments[paymentID];
            changes = totalPayment - total;
            if (totalPayment < total) {
              isPaymentFilled = false;
              checkButton();
            }

            $('#total-payment').html(totalPayment);
            $('#changes').html(changes);
            parent.remove();
          } else {
            alert("Failed to remove");
          }
        }
      });
    });

    $('.card').on('keyup', 'input[name="amount"]', function() {
      let parent = $(this).parent().parent();
      let paymentId = parent.children('input[name="payment_id"]').val();
      let totalElement = $('p#total');
      let totalPaymentElement = $('p#total-payment');
      let changesElement = $('p#changes');
      let payment = Number($(this).val());

      let previousPayment = payments[paymentId];
      if (previousPayment != null) {
        totalPayment -= previousPayment;
      }
      totalPayment += payment;
      changes = totalPayment - total;
      payments[paymentId] = payment;

      totalPaymentElement.html(totalPayment);
      changesElement.html(changes);
    }).on('blur', 'input[name="amount"]', function() {
      let parent = $(this).parent().parent();
      let paymentId = parent.children('input[name="payment_id"]').val();
      let action = "<?= base_url('order/changePaymentAmount'); ?>"

      $.ajax({
        url: action,
        method: "POST",
        data: {
          "transaction_id": tid,
          "payment_id": paymentId,
          "payment": payments[paymentId],
          "total_payment": totalPayment,
          "changes": changes
        },
        success: function(data) {
          let json = JSON.parse(data);

          if (json["status"]) {
            if (totalPayment >= total) {
              isPaymentFilled = true;
            } else {
              isPaymentFilled = false;
            }
            checkButton();
          } else {
            alert('Failed to save payment')
          }
        }
      });
    });

    $('.card').on('change', 'select', function() {
      let parent = $(this).parent().parent();
      let method = $(this).val();
      let paymentID = parent.children('input[name="payment_id"]').val();
      let action = "<?= base_url('order/changePaymentMethod'); ?>";

      $.ajax({
        url: action,
        method: "POST",
        data: {
          "payment_id": paymentID,
          "method": method
        }
      });
    });


    $('.order-detail').on('click', '.order-amount-btn', function() {
      let parent = $(this).parent();
      let sibling = parent.siblings();
      let amountSpan = parent.children('span');
      let amount = Number(parent.siblings("form").children("input[name='amount']").val());
      let order_id = Number(parent.siblings("form").children("input[name='order_id']").val());
      let menu_id = Number(parent.siblings("form").children("input[name='menu_id']").val());
      let price = Number(parent.siblings("form").children("input[name='price']").val());
      let tambah = true;

      if ($(this).hasClass("tambah")) {
        amount += 1;
        parent.siblings("form").children("input[name='amount']").val(amount);
      } else {
        amount -= 1;
        tambah = false;
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
          subtotal = tambah ? subtotal + price : subtotal - price;
          tax = subtotal * 0.1;
          total = subtotal + tax;
          changes = totalPayment - total;

          if (amount == 0) {
            let link = $('.product-link').children("form").children("input[name='menu_id'][value='" + menu_id + "']");
            link.parents('a').removeClass("disabled");
            link.parents('a').prop("href", "javascript:void(0);");
            if (total == 0) {
              isOrdering = false;
            }

            let productDiv = link.parent().siblings('.card-product-grid');
            productDiv.removeClass("disabled");
            parent.parent().remove();
          } else {
            price *= amount;
            amountSpan.html(amount);
            let subtotalDiv = sibling.find('.subtotal-product');
            subtotalDiv.html(price);
          }

          if (totalPayment < total) {
            isPaymentFilled = false;
          } else {
            isPaymentFilled = true;
          }
          checkButton();

          $('#subtotal').html(subtotal);
          $('#tax').html(tax);
          $('#total').html(total);
          $('#changes').html(changes);
        }
      });
    });

    $('.product-link').click(function() {
      if (!$(this).hasClass("disabled")) {
        let transaction_id = $(this).children('form').children("input[name='transaction_id']").val();
        let menu_id = $(this).children('form').children("input[name='menu_id']").val();
        let name = $(this).children('form').children("input[name='name']").val();
        let price = Number($(this).children('form').children("input[name='price']").val());
        let quantity = 1;

        $(this).addClass("disabled");
        $(this).removeAttr("href");
        $(this).children(".card").addClass("disabled");

        $.ajax({
          url: $(this).children('form').attr('action'),
          type: "POST",
          data: $(this).children('form').serialize(),
          success: function(data) {
            var json = JSON.parse(data);
            if (json["status"] == true) {
              let order_id = Number(json["order_id"]);
              subtotal += price;
              tax = subtotal * 0.1;
              total = subtotal + tax;
              changes = totalPayment - total;
              isOrdering = true;

              if (totalPayment < total) {
                isPaymentFilled = false;
                checkButton();
              }

              $('#subtotal').html(subtotal);
              $('#tax').html(tax);
              $('#total').html(total);
              $('#changes').html(changes);

              $('.orders').append(
                /*html*/
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
                    <button class="btn btn-sm btn-circle btn-danger kurang order-amount-btn"> - </button>
                    <span class="mx-1">` + quantity + `</span>
                    <button class="btn btn-sm btn-circle btn-primary tambah order-amount-btn"> + </button>
                  </div>
                  <div class="col col-3">
                    <p style="text-align: right;" class="subtotal-product">` + price + `</p>
                  </div>
                </div>`
              );
            }
          }
        });
      }
    });

    function isEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }

    function insert_customer(serializedData, insertedData, whichForm, whichColumn) {
      serializedData += '&transaction_id=' + tid;
      let phoneOrEmail = whichColumn;
      let phone = true;
      let email = true;
      let action = "<?= base_url('order/'); ?>";

      if (whichColumn == 'Phone') {
        if (!isEmail(insertedData)) {
          email = false;
          phoneOrEmail = 'Phone'
        }
        if (!$.isNumeric(insertedData)) {
          phone = false;
          phoneOrEmail = 'Email'
        }

        action += 'savePhone/';
      } else {
        action += 'saveName/';
      }

      if (!phone && !email) {
        if (!whichForm.hasClass("is-invalid")) {
          whichForm.addClass('is-invalid');
          whichForm.after(`
          <div class="invalid-feedback">
            Invalid email or phone number
          </div>
        `);
        }
      } else {
        $.ajax({
          url: action,
          type: "POST",
          data: serializedData,
          success: function(data) {
            var json = JSON.parse(data);
            if (json["status"]) {
              if (whichColumn == "Phone") {
                isNumberFilled = true;
                if (insertedData == '') {
                  isNumberFilled = false;
                } else {
                  isNumberFilled = true;
                }
              } else {
                if (insertedData == '') {
                  isNameFilled = false;
                } else {
                  isNameFilled = true;
                }
              }

              checkButton();

              whichForm.parent().after(`
              <p>` + phoneOrEmail + `: <strong>` + insertedData + `</strong> <a href="javascript:void(0);" id="` + whichColumn + `Button"><i class="fa fa-edit"></i></a></p>
            `);
              whichForm.parent().remove();
            }
          }
        });
      }
    }

    $('.order-detail').on('focus', 'input', function() {
      $(this).removeClass("is-invalid");
      $(this).siblings('.invalid-feedback').remove();
    });

    $('.order-detail').focus().on('blur', 'input[name="name"]', function() {
      let name = $(this).val();

      if (name != '') {
        dataToInsert = "name=" + name;
        insert_customer(dataToInsert, name, $(this), "Name");
      }
    });

    $('.order-detail').on('keypress', 'input[name="name"]', function(e) {
      let key = e.which;
      if (key == 13) {
        let name = $(this).val();

        if (name != '') {
          dataToInsert = "name=" + name;
          insert_customer(dataToInsert, name, $(this), "Name");
        }
      }
    });

    $('.order-detail').focus().on('blur', 'input[name="phone"]', function() {
      let phone = $(this).val();

      if (phone != '') {
        dataToInsert = "phone=" + phone;
        insert_customer(dataToInsert, phone, $(this), "Phone");
      }
    });

    $('.order-detail').on('keypress', 'input[name="phone"]', function(e) {
      let key = e.which;
      if (key == 13) {
        let phone = $(this).val();

        if (phone != '') {
          dataToInsert = "phone=" + phone;
          insert_customer(dataToInsert, phone, $(this), "Phone");
        }
      }
    });

    $('.order-detail').on('click', 'a#NameButton', function() {
      nama = $(this).siblings('strong').html();
      $(this).parent().after(`
        <div class="form-group">
          <input type="text" name="name" id="NameButton" class="form-control" placeholder="Nama..." value="` + nama + `">
        </div>
      `);
      $(this).parent().remove();
    });

    $('.order-detail').on('click', 'a#PhoneButton', function() {
      phone = $(this).siblings('strong').html();
      $(this).parent().after(`
        <div class="form-group">
          <input type="text" name="phone" id="PhoneButton" class="form-control" placeholder="Phone or email..." value="` + phone + `">
        </div>
      `);
      $(this).parent().remove();
    });
  </script>


</body>

</html>
