<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/template/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #1e1e2d;
    }
    .login-box {
      width: 400px;
      margin: 80px auto;
    }
    .card {
      background: #27293d;
      color: white;
      border-radius: 10px;
    }
    .btn-primary {
      background: #ffcc00;
      border-color: #ffcc00;
      color: #000;
    }
    .btn-primary:hover {
      background: #e6b800;
      border-color: #e6b800;
    }
  </style>
</head>
<body>
<div class="login-box">
  <div class="card">
    <div class="card-header text-center">
      <h2><b>Cine</b>Critic</h2>
    </div>
    <div class="card-body">
      <p class="text-center">Silakan masuk untuk mengelola ulasan film</p>

      <form action="" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" name="email" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" name="password" required>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Ingat Saya</label>
          </div>
          <a href="" class="text-warning">Lupa Password?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">Masuk</button>
      </form>
      <p class="text-center mt-3">
        <a href="register.html" class="text-warning">Daftar akun baru</a>
      </p>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
