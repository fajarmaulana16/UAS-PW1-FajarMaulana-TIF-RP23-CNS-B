<?php
require 'config/config.php';

if (isset($_POST["register"])) {
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Cek username atau email sudah ada
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (mysqli_num_rows($result) > 0) {
        $error = "Username atau email sudah terdaftar!";
    } else {
        $sql = "INSERT INTO users (username, email, password, created_at) VALUES ('$username', '$email', '$password', NOW())";;
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Registrasi gagal: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sneaker Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 30px;
            border: none;
        }
        .card-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 2rem;
        }
        .card-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .card-body {
            padding: 40px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-custom {
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .text-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .text-link:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5" data-aos="fade-up">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-person-plus-fill fs-1 mb-3"></i>
                    <h2>Register</h2>
                    <p>Bergabunglah dengan Sneaker Hub</p>
                </div>
                <div class="card-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger" data-aos="fade-in">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="bi bi-person-fill me-2"></i>Username
                            </label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-fill me-2"></i>Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock-fill me-2"></i>Password
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-custom w-100 mb-3">Register</button>
                    </form>
                    <div class="text-center">
                        <a href="login.php" class="text-link">Sudah punya akun? Login</a><br>
                        <a href="home.php" class="text-link mt-2 d-inline-block">
                            <i class="bi bi-house-door-fill me-1"></i>Kembali ke Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    once: true
});
</script>
</body>
</html>