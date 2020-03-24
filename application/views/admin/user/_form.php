<!DOCTYPE html>
<html lang="en">

<head>

  <?php $this->load->view('admin/_partials/head'); ?>

</head>

<?php
$id = set_value('id');
$name = set_value('name');
$email = set_value('email');
$role = set_value('role');

$url3 = $this->uri->segment(3);

if (isset($user) && count($user) > 0) {
  $id = $user[0]->user_id;
  $name = $user[0]->user_name;
  $email = $user[0]->user_email;
  $role = $user[0]->role_id;
}

if (empty($role)) {
  $role = 2;
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
          <h1 class="h3 mb-4 text-gray-800">User</h1>

          <div class="col col-xl-6 col-lg-12 p-0">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <a href="<?php echo base_url('admin/user/') ?>"><i class="fas fa-arrow-left"></i> Back</a>
              </div>

              <div class="card-body">
                <form action="<?php echo base_url('admin/user/') . ($url3 == 'details' ? 'details/' . $id : 'add'); ?>" method="POST">
                  <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />

                  <!-- Name form -->
                  <div class="form-group">
                    <label for="name">Name <span class="mandatory">*</span></label>
                    <input class="form-control <?php echo form_error('name') ? 'is-invalid' : ''; ?>" type="text" name="name" placeholder="Insert user name..." value="<?php echo $name; ?>">

                    <div class="invalid-feedback">
                      <?php echo form_error('name'); ?>
                    </div>
                  </div>

                  <!-- Email form -->
                  <div class="form-group">
                    <label for="email">Email <span class="mandatory">*</span></label>
                    <input class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>" type="text" name="email" placeholder="Insert user email..." value="<?php echo $email; ?>">

                    <div class="invalid-feedback">
                      <?php echo form_error('email'); ?>
                    </div>
                  </div>

                  <!-- Password form -->
                  <div class="row">
                    <div class="col col-lg-6 col-12">
                      <div class="form-group">
                        <label for="password1">Password <span class="mandatory"><?php echo $url3 == 'add' ? '*' : '' ?></span><small><?php echo $url3 == 'details' ? '(optional)' : ''; ?></small></label>
                        <input class="form-control <?php echo form_error('password1') ? 'is-invalid' : ''; ?>" type="password" name="password1" placeholder="Insert user password...">

                        <div class="invalid-feedback">
                          <?php echo form_error('password1'); ?>
                        </div>
                      </div>
                    </div>

                    <div class="col col-lg-6 col-12">
                      <div class="form-group">
                        <label for="password2">Verify password <span class="mandatory"><?php echo $url3 == 'add' ? '*' : '' ?></span><small><?php echo $url3 == 'details' ? '(optional)' : ''; ?></small></label>
                        <input class="form-control <?php echo form_error('password2') ? 'is-invalid' : ''; ?>" type="password" name="password2" placeholder="Verify password...">

                        <div class="invalid-feedback">
                          <?php echo form_error('password2'); ?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Role form -->
                  <div class="form-group">
                    <label for="role">Role <span class="mandatory">*</span></label>
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="admin" value="1" name="role" <?php echo $role == 1 ? 'checked' : ''; ?>>
                      <label class="custom-control-label" for="admin">Admin / Boss</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" id="kasir" value="2" name="role" <?php echo $role == 2 ? 'checked' : ''; ?>>
                      <label class="custom-control-label" for="kasir">Kasir</label>
                    </div>
                    <div class="invalid-feedback">
                      <?php echo form_error('role'); ?>
                    </div>
                  </div>

                  <!-- Cancel button -->
                  <a href="<?php echo base_url('admin/user'); ?>"><button type="button" class="btn btn-outline-danger">Cancel</button></a>

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