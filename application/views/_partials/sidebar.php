<div class="bg-gradient-primary sidebar sidebar-dark sidebar-kasir" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('admin'); ?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-coffee"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Waroenk Abnormal</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <div class="container">
    <div class="row">
      <div class="col col-12">
        <span style="color: white; font-weight: bold;">Customer</span>
        <form action="#" method="post">
          <div class="form-group">
            <input type="text" name="name" id="name" class="form-control" placeholder="Nama...">
          </div>
          <div class="form-group">
            <input type="text" name="telp" id="telp" class="form-control" placeholder="No Telp...">
          </div>

          <input type="submit" value="Save" class="btn btn-success btn-block">
        </form>
      </div>
    </div>
  </div>

  <!-- Divider -->
  <hr class="sidebar-divider mt-3">

  <div class="container">
    <!-- <table style="color: white">
      <tr>
        <td class="p-2">
          <i class="fa fa-trash" style="color: white; height: 100%;"></i>
        </td>
        <td class="p-1">
          <p style="font-weight: bold; margin-top: auto; margin-bottom: auto;">Krabby Patty<br>
            @ 25,000
          </p>
        </td>
        <td class="p-1">
          <input type="number" class="form-control input-group-sm" id="quantity" min="1" max="10" value="2">
        </td>
        <td class="p-1">
          <p class="margin-top: auto; margin-bottom: auto;">50,000</p>
        </td>
      </tr>

      <tr>
        <td class="p-2">
          <i class="fa fa-trash" style="color: white; height: 100%;"></i>
        </td>
        <td class="p-1">
          <p style="font-weight: bold; margin-top: auto; margin-bottom: auto;">Chum Stick<br>
            @ 15,000
          </p>
        </td>
        <td class="p-1">
          <input type="number" class="form-control input-group-sm" id="quantity" min="1" max="10" value="1">
        </td>
        <td class="p-1">
          <p class="margin-top: auto; margin-bottom: auto;">15,000</p>
        </td>
      </tr>
    </table> -->

    <div class="row my-3" style="color: white;">
      <div class="col col-1">
        <i class="fa fa-trash" style="color: white; height: 100%;"></i>
      </div>
      <div class="col col-5">
        <p style="font-weight: bold; margin-top: auto; margin-bottom: auto;">Chum Stick<br>
          @ 15,000
        </p>
      </div>
      <div class="col col-3">
        <input type="number" class="form-control form-control-sm" id="quantity" min="1" max="10" value="1">
      </div>
      <div class="col col-3">
        <p class="margin-top: auto; margin-bottom: auto;">15,000</p>
      </div>
    </div>

    <div class="row" style="color: white;">
      <div class="col col-1">
        <i class="fa fa-trash" style="color: white; height: 100%; vertical-align: middle;"></i>
      </div>
      <div class="col col-5">
        <span style="font-weight: bold; margin-top: auto; margin-bottom: auto;">Krabby Patty</span>
        <span>@ 25,000</span>
      </div>
      <div class="col col-3">
        <input type="number" class="form-control form-control-sm" id="quantity" min="1" max="10" value="2">
      </div>
      <div class="col col-3">
        <p class="margin-top: auto; margin-bottom: auto;">50,000</p>
      </div>
    </div>
  </div>





  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</div>