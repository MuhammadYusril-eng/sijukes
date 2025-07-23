<?php
define('BASE_URL', 
    (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . 
    "://" . $_SERVER['HTTP_HOST']
);
session_unset();
session_write_close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Informasi SMK Negeri 5 Tikep</title>
  <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="./assets/css/login.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

  <style>
    /* [Previous CSS styles remain exactly the same] */
    
    /* Add this for toastr positioning */
    .toast-top-center {
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
    }
    
    /* Ensure toastr appears above other elements */
    #toast-container {
      z-index: 999999;
    }
     .login-info {
      background-color: rgba(67, 97, 238, 0.1);
      border-radius: 10px;
      padding: 15px;
      margin-top: 20px;
      border-left: 4px solid var(--primary);
    }
    
    .login-info h4 {
      color: var(--primary);
      font-size: 1rem;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }
    
    .login-info h4 i {
      margin-right: 8px;
    }
    
    .login-info ul {
      padding-left: 20px;
      color: #495057;
      font-size: 0.85rem;
    }
    
    .login-info li {
      margin-bottom: 5px;
    }
      /* Responsive */
    @media (max-width: 576px) {
      .login-container {
        width: 100%;
      }
      
      .login-header h1 {
        font-size: 1.3rem;
      }
      
      .login-info {
        padding: 10px;
      }
    }
        @media (min-width: 769px) {
      #particles-js {
        display: block; /* Tampilkan particles hanya di desktop */
      }
    }
    
  </style>
</head>
<body>

    <!-- Animated Background Particles -->
  <div id="particles-js"></div>
  
  <!-- Login Container -->
  <div class="login-container animate__animated animate__fadeInUp">
    <div class="login-header">
      <img src="assets/images/logo.png" alt="SMK Negeri 5 Tikep" class="school-logo animate__animated animate__bounceIn">
      <h1>SISTEM INFORMASI SEKOLAH</h1>
      <p>SMK Negeri 5 Tikep</p>
    </div>
   
    
    <div class="login-body">
      <form id="loginForm" action="/sijukes/login/proses-login.php"  autocomplete="off">
        <!-- CSRF Token Protection -->
        <input type="hidden" name="csrf_token" value="<?php echo bin2hex(random_bytes(32)); ?>" class="csrf-token">
        
        <div class="input-group">
          <i class="fas fa-user"></i>
          <input type="text" class="form-control" name="username" id="username" placeholder="Username" required 
                 minlength="3" maxlength="30" pattern="[a-zA-Z0-9]+" title="Hanya huruf dan angka diperbolehkan">
        </div>
        
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required
                  maxlength="20">
          <i class="fas fa-eye-slash toggle-password" style="right: 15px; left: auto; cursor: pointer;"></i>
        </div>
        
        <button type="submit" class="btn-login" id="loginBtn">
          <i class="fas fa-sign-in-alt"></i> <span class="btn-text">MASUK</span>
        </button>
      </form>
       <div class="login-info">
  <h4><i class="fas fa-info-circle"></i> Petunjuk Login</h4>
  <ul>
    <li><strong>Siswa:</strong> Username: nama depan | Password: nama depan + NIS (contoh: <code>yusril_12345</code>)</li>
    <li><strong>Guru:</strong> Username: nama depan | Password: nama depan + NIP (contoh: <code>budi_198304122006041</code>)</li>
  </ul>
</div>
      <p class="footer-text">© <?php echo date('Y'); ?> SMK Negeri 5 Tikep</p>
    </div>
  </div>

  <!-- JavaScript Libraries -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
  <script>

 // Animated Background Particles
    particlesJS("particles-js", {
      "particles": {
        "number": {
          "value": 90,
          "density": {
            "enable": true,
            "value_area": 800
          }
        },
        "color": {
          "value": "#ffffff"
        },
        "shape": {
          "type": "circle",
          "stroke": {
            "width": 0,
            "color": "#000000"
          }
        },
        "opacity": {
          "value": 0.3,
          "random": true,
          "anim": {
            "enable": true,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
          }
        },
        "size": {
          "value": 3,
          "random": true
        },
        "line_linked": {
          "enable": true,
          "distance": 150,
          "color": "#ffffff",
          "opacity": 0.2,
          "width": 1
        },
        "move": {
          "enable": true,
          "speed": 2,
          "direction": "none",
          "random": true,
          "straight": false,
          "out_mode": "out",
          "bounce": false
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": {
            "enable": true,
            "mode": "grab"
          },
          "onclick": {
            "enable": true,
            "mode": "push"
          },
          "resize": true
        }
      }
    });

    // Initialize toastr with proper configuration
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-center",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

    // [Particles.js configuration remains the same]

    // Toggle Password Visibility
    $(document).on('click', '.toggle-password', function() {
      const passwordField = $(this).siblings('input');
      const icon = $(this);
      
      if (passwordField.attr('type') === 'password') {
        passwordField.attr('type', 'text');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
      } else {
        passwordField.attr('type', 'password');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
      }
    });
    
    // Form submission handler
    $('#loginForm').on('submit', function(e) {
      e.preventDefault();
      
      const form = $(this);
      const submitBtn = $('#loginBtn');
      const btnText = submitBtn.find('.btn-text');
      
      // Disable button to prevent multiple submissions
      submitBtn.prop('disabled', true);
      btnText.text('Memproses...');
      submitBtn.find('i').removeClass('fa-sign-in-alt').addClass('fa-spinner fa-spin');
      
      // Client-side validation
      if (!this.checkValidity()) {
        toastr.error('Harap isi form dengan benar', 'Validasi Gagal');
        submitBtn.prop('disabled', false);
        btnText.text('MASUK');
        submitBtn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-sign-in-alt');
        return;
      }
      
      // Submit form via AJAX
      $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
          console.log('Response:', response); // For debugging
          
          if (response.success) {
            toastr.success(response.message, 'Berhasil Login');
            setTimeout(function() {
              window.location.href = response.redirect;
            }, 1500);
          } else {
            toastr.error(response.message, 'Gagal Login');
          }
          
          // Reset button state
          submitBtn.prop('disabled', false);
          btnText.text('MASUK');
          submitBtn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-sign-in-alt');
        },
        error: function(xhr) {
          console.error('Error:', xhr.responseText); // For debugging
          let errorMsg = 'Terjadi kesalahan sistem';
          
          try {
            const res = JSON.parse(xhr.responseText);
            if (res.message) errorMsg = res.message;
          } catch (e) {}
          
          toastr.error(errorMsg, 'Error');
          
          // Reset button state
          submitBtn.prop('disabled', false);
          btnText.text('MASUK');
          submitBtn.find('i').removeClass('fa-spinner fa-spin').addClass('fa-sign-in-alt');
        }
      });
    });
    
    // [Rate limiting code remains the same]

    <?php if(isset($_GET['error'])): ?>
    // Show error message from URL parameter
    $(document).ready(function() {
      toastr.error('<?php echo addslashes($_GET['error']); ?>', 'Gagal Login');
    });
    <?php endif; ?>
  </script>
</body>
</html>