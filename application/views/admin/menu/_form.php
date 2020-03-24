<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view('admin/_partials/head'); ?>

</head>

<?php
$id = set_value('id');
$name = set_value('name');
$price = set_value('price');
$category = set_value('category');
$discount = set_value('menu_discount');
$final_price = set_value('final-price');
$picture = set_value('menu_image');
$status = set_value('status');

if (empty($status)) {
  $status = 1;
}
if (empty($discount)) {
  $discount = 0;
}

if (isset($menu) && count($menu) > 0) {
  $id = $menu[0]->menu_id;
  $name = $menu[0]->menu_name;
  $price = $menu[0]->menu_price;
  $category = $menu[0]->category_id;
  $discount = $menu[0]->menu_discount;
  $final_price = $menu[0]->menu_final_price;
  $picture = $menu[0]->menu_picture;
  $status = $menu[0]->status;
}

?>


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
          <h2 class="font-weight-bold text-primary card-title">Add new menu</h2>

          <div class="col col-xl-6 col-lg-12 p-0">
            <div class="card shadow mb-4">
              <div class="card-header">
                <a href="<?php echo base_url('admin/menu/') ?>"><i class="fas fa-arrow-left"></i> Back</a>
              </div>

              <div class="card-body">
                <?php echo form_open_multipart(base_url('admin/menu/') . (($this->uri->segment(3) == 'details') ? ('details/' . $id) : 'add')); ?>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

                <!-- Name form -->
                <div class="form-group">
                  <label for="name">Name <span class="mandatory">*</span></label>
                  <input class="form-control <?php echo form_error('name') ? 'is-invalid' : ''; ?>" type="text" name="name" placeholder="Insert menu name..." value="<?php echo $name; ?>">

                  <div class="invalid-feedback">
                    <?php echo form_error('name'); ?>
                  </div>
                </div>

                <!-- Price form -->
                <div class="form-group">
                  <label for="price">Price <span class="mandatory">*</span></label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp.</span>
                    </div>
                    <input class="form-control <?php echo form_error('price') ? 'is-invalid' : ''; ?>" id="price" type="text" name="price" placeholder="Insert menu price..." value="<?php echo $price; ?>">
                    <div class="invalid-feedback">
                      <?php echo form_error('price'); ?>
                    </div>
                  </div>

                </div>

                <!-- Discount form -->
                <div class="form-group">
                  <label for="discount">Discount <span class="small">(optional)</span></label>

                  <div class="input-group">
                    <input type="number" class="form-control <?php echo form_error('discount') ? 'is-invalid' : ''; ?>" placeholder="Insert menu discount" id="discount" name="discount" value="<?php echo $discount; ?>">
                    <div class="input-group-append">
                      <span class="input-group-text" id="discount">%</span>
                    </div>
                  </div>

                  <div class="invalid-feedback">
                    <?php echo form_error('discount'); ?>
                  </div>
                </div>

                <!-- Final price form -->
                <div class="form-group">
                  <label for="final-price">Discount Price <span class="small">(optional)</span></label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp.</span>
                    </div>
                    <input class="form-control <?php echo form_error('final-price') ? 'is-invalid' : ''; ?>" id="final-price" type="text" name="final-price" placeholder="Insert menu final price..." value="<?php echo $final_price; ?>">
                    <div class="invalid-feedback">
                      <?php echo form_error('final-price'); ?>
                    </div>
                  </div>
                </div>

                <!-- Category form -->
                <div class="form-group">
                  <label for="category">Category <span class="mandatory">*</span></label>
                  <select name="category" id="select2" class="form-control select2 <?php echo form_error('category') ? 'is-invalid' : '' ?>" style="width: 100%;">
                    <option value="0" selected disabled>Select category...</option>
                    <?php foreach ($categories as $cat) : ?>
                      <option <?php echo $cat->category_id == $category ? 'selected="selected"' : ''; ?> value="<?php echo $cat->category_id; ?>"><?php echo $cat->category_name; ?></option>
                    <?php endforeach; ?>
                  </select>

                  <div class="invalid-feedback">
                    <?php echo form_error('category'); ?>
                  </div>
                </div>

                <!-- Show image -->
                <?php if (!empty($picture)) { ?>
                  <div class="form-group">
                    <label for="menu_picture">Image</label>
                    <div class="col col-xl-2 col-lg-3 col-md-6">
                      <img src="<?php echo base_url('assets/img/') . $picture; ?>" width="100%">
                    </div>
                  </div>
                <?php } ?>

                <!-- Image form -->
                <div class="form-group">
                  <label for="menu_image">Image file <span class="mandatory">*</span></label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input <?php echo form_error('menu_image') ? 'is-invalid' : '' ?>" id="menu_image" name="menu_image" />
                    <label class="custom-file-label" for="menu_image">Choose file</label>

                    <div class="invalid-feedback">
                      <?php echo form_error('menu_image'); ?>
                    </div>
                  </div>
                </div>

                <!-- Status form -->
                <div class="form-group">
                  <label for="status">Status <span class="mandatory">*</span></label>
                  <select name="status" id="status" class="form-control">
                    <option value="1" <?php echo $status == 1 ? 'selected' : ''; ?>>Available</option>
                    <option value="0" <?php echo $status == 0 ? 'selected' : ''; ?>>Out of stock</option>
                  </select>
                </div>


                <!-- Cancel button -->
                <a href="<?php echo base_url('admin/menu'); ?>"><button type="button" class="btn btn-outline-danger">Cancel</button></a>

                <!-- Submit button -->
                <input class="btn btn-primary" type="submit" name="btn" value="Save" id="submit-menu" />
                <?php echo form_close(); ?>
              </div>

              <div class="card-footer small text-muted">
                * required fields
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

  <script>

  </script>

</body>

</html>