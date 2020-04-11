<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view('admin/_partials/head'); ?>

</head>

<?php
$id = set_value('id');
$name = set_value('name');
$status = set_value('status');

if (isset($method) && count($method) > 0) {
  $id = $method[0]->method_id;
  $name = $method[0]->method_name;
  $status = $method[0]->status;
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
          <h1 class="h3 mb-4 text-gray-800">Payment methods</h1>

          <div class="col col-xl-6 col-lg-12 p-0">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <a href="<?php echo base_url('admin/methods/') ?>"><i class="fas fa-arrow-left"></i> Back</a>
              </div>

              <div class="card-body">
                <form action="<?php echo base_url('admin/methods/') . ($this->uri->segment(3) == 'details') ? $id : 'add'; ?>" method="POST">
                  <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

                  <!-- Name form -->
                  <div class="form-group">
                    <label for="name">Name <span class="mandatory">*</span></label>
                    <input class="form-control <?php echo form_error('name') ? 'is-invalid' : ''; ?>" type="text" name="name" placeholder="Insert method name..." value="<?php echo $name; ?>">

                    <div class="invalid-feedback">
                      <?php echo form_error('name'); ?>
                    </div>
                  </div>

                  <!-- Status form -->
                  <div class="form-group">
                    <label for="status">Status <span class="mandatory">*</span></label>
                    <select name="status" id="status" class="form-control">
                      <option value="1" <?php echo $status == 1 ? 'selected' : ''; ?>>Available</option>
                      <option value="0" <?php echo $status == 0 ? 'selected' : ''; ?>>Maintenance</option>
                    </select>
                  </div>

                  <!-- Cancel button -->
                  <a href="<?php echo base_url('admin/methods'); ?>"><button type="button" class="btn btn-outline-primary">Cancel</button></a>

                  <!-- Submit button -->
                  <input class="btn btn-primary" type="submit" name="btn" value="Save" />

                </form>
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

</body>

</html>