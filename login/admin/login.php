<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=0.8, user-scalable=0.8, minimum-scale=0.8, maximum-scale=0.8">
  <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
  <title>Dashboard - Follow Up Your Progress</title>

  <!-- ========== All CSS files linkup ========= -->
  <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  

  <link rel="stylesheet" href="../assets/css/LineIcons.css">
  <link rel="stylesheet" href="../assets/css/quill/bubble.css">
  <link rel="stylesheet" href="../assets/css/quill/snow.css">
  <link rel="stylesheet" href="../assets/css/fullcalendar.css">
  <link rel="stylesheet" href="../assets/css/morris.css">
  <link rel="stylesheet" href="../assets/css/datatable.css">
  <link rel="stylesheet" href="../assets/css/main.css">
  

</head><body class="darkTheme">
            <div id="loading-area"></div>

      <!-- ======== sidebar-nav start =========== -->
      <div class="overlay"></div>
      <!-- ======== sidebar-nav end =========== -->

      <!-- ======== main-wrapper start =========== -->
      <main class="main">
          <section class="signin-section">
              <div class="container-fluid h-100">
      
                <div class="row g-0 auth-row justify-content-center align-self-center h-100">
                  <div class="col-lg-8 d-none d-lg-block">
                    <div class="auth-cover-wrapper bg-primary-100">
                      <div class="auth-cover">
                        <div class="cover-image mb-30">
                          <img src="../.././assets/images/logo/logo_expo_light.png" alt="">
                        </div>
                        <div class="title text-center mt-10">
<!--                           <h1 class="text-primary mb-10">Welcome Back</h1>
 -->                          <p class="text-medium">
                            Sign in to your Existing account to continue
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end col -->
                  <div class="col-lg-4">
              <div class="signin-wrapper h-100">
                <div class="form-wrapper">
                  <div class="cover-image d-block d-lg-none mb-50">
                    <img src="../.././assets/images/logo/logo_expo_light.png" alt="">
                  </div>
                  <h6 class="mb-15">Sign In Form</h6>
                  <p class="text-sm mb-25">
                    Start creating the best possible user experience for you
                    customers.
                  </p>
                  <form action="../proses-login.php" method="post">
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Username</label>
                          <input type="username" name="username" required placeholder="Masukan Email">
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Password</label>
                          <input type="password" name="password" required placeholder="Password">
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-xxl-6 col-lg-12 col-md-6">
                        <div class="
                            text-start text-md-end text-lg-start text-xxl-end
                            mb-30
                          ">
                          <a href="#0" class="hover-underline">Forgot Password?</a>
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="
                            button-group
                            d-flex
                            justify-content-center
                            flex-wrap
                          ">
                          <input type="submit" name="submit" class="main-btn primary-btn btn-hover w-100 text-center" value="Sign In">
                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                  <div class="singin-option pt-40">
                    <p class="text-sm text-medium text-dark text-center">
                      Don’t have any account yet?
                      <a data-bs-toggle="modal" data-bs-target="#signup">Create an account</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
                  <!-- end col -->
                </div>
                <!-- end row -->
              </div>
            </section>

            

      </main>
      <!-- ======== main-wrapper end =========== -->



      <div class="modal fade form-modal" id="signup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content card-style">
            <div class="modal-header px-0 border-0">
              <h5 class="text-bold">Sign Up Form</h5>
            </div>
            <div class="modal-body px-0">
              <div class="signup-wrapper p-0">
                <div class="form-wrapper">
                  <p class="text-sm mb-25">
                    Start creating the best possible user experience for you
                    customers.
                  </p>
                  <form action="proses-signup.php" method="post">
                    <div class="row">
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Nama Lengkap</label>
                          <input type="text" required placeholder="Name" name="nama">
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>NIM</label>
                          <input type="number" required placeholder="NIM" name="nim">
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Email</label>
                          <input type="email" required placeholder="Email" name="email">
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="input-style-1">
                          <label>Password</label>
                          <input type="password" required placeholder="Password" name="password">
                        </div>
                      </div>
                      <!-- end col -->
                      <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                      <button class="btn " onclick="ValidateEmail(document.form1.text1)">Log in
                      </button>

                        </div>
                      </div>
                    </div>
                    <!-- end row -->
                  </form>
                  <div class="singup-option pt-40">
                    <p class="text-sm text-medium text-dark text-center">
                      Already have an account? <a href="./login.php">Sign In</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
 <!-- CHANGE THEME -->
<?php include './template/theme-option.php' ?>

          
          <div class="promo-box">
              <h3>Buy me a Coffee</h3>
              <p>If you like my work, please support me.</p>
              <a href="#" target="_blank" rel="nofollow" class="main-btn primary-btn btn-hover">
                  Donate Us
              </a>
          </div>
      </div>
      <!-- ============ Theme Option End ============= -->

      <!-- ========= All Javascript files linkup ======== -->
      <!-- <script src="assets/js/bootstrap.bundle.min.js"></script> -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
      <script src="../assets/js/login.js"></script>
      

      
      
