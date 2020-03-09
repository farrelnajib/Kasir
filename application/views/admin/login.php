<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view('admin/_partials/head'); ?>
</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-4">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="mb-1"><?php $this->load->view('admin/_partials/alerts') ?></div>
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form action="<?php base_url('admin/login'); ?>" class="user" method="POST">
                    <div class="form-group">
                      <input type="email" autofocus class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." value="<?php echo set_value('email'); ?>">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <input class="btn btn-primary btn-user btn-block" name="submit" type="submit" value="Login" />
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <?php $this->load->view('admin/_partials/js'); ?>

</body>

</html>