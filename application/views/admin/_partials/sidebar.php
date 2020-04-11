<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('admin'); ?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-coffee"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Waroenk Abnormal</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item <?php echo $this->uri->segment(2) == '' ? 'active' : ''; ?>">
    <a class="nav-link" href="<?php echo base_url('admin'); ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Main Menu
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item <?php echo ($this->uri->segment(2) == 'categories') ? 'active' : ''; ?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#masterCollapse" aria-expanded="true" aria-controls="masterCollapse">
      <i class="<?php echo ($this->uri->segment(2) == 'categories') ? 'fas' : 'far'; ?> fa-fw fa-circle"></i>
      <span>Master</span>
    </a>
    <div id="masterCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Master:</h6>
        <a class="collapse-item" href="<?php echo base_url(); ?>admin/categories">Categories</a>
        <a class="collapse-item" href="<?php echo base_url(); ?>admin/methods">Payment methods</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Food Menu -->
  <li class="nav-item <?php echo ($this->uri->segment(2) == 'menu') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?php echo base_url(); ?>admin/menu">
      <i class="fas fa-fw fa-utensils"></i>
      <span>Menu</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Settings
  </div>


  <!-- Nav Item - Users -->
  <li class="nav-item <?php echo ($this->uri->segment(2) == 'user') ? 'active' : ''; ?>">
    <a class="nav-link" href="<?php echo base_url(); ?>admin/user">
      <i class="<?php echo ($this->uri->segment(2) == 'user') ? 'fas' : 'far'; ?> fa-fw fa-user"></i>
      <span>User</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>