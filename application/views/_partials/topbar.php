<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('admin'); ?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-coffee"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Waroenk Abnormal</div>
  </a>


  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

    <?php if ($this->uri->segment(1) == '') : ?>
      <li class="nav-item dropdown no-arrow mx-1 btn-nav">
        <a class="btn btn-primary" href="<?= base_url('newTransaction'); ?>">
          <i class="fa fa-plus"></i> New Transaction
        </a>
      </li>
    <?php endif; ?>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('name'); ?></span>
        <i class="fas fa-user-circle"></i>
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="<?php echo base_url('admin/user/details/') . $this->session->userdata('id'); ?>">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profile
        </a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
      </div>
    </li>
  </ul>

</nav>