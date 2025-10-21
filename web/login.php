<?php
include 'config.php';
session_start();

// Jika sudah login, redirect ke admin
if (isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

// Proses login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Ganti dengan username dan password admin yang diinginkan
    if ($username === 'riziq' && $password === 'maja') {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kasir Makanan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-box {
            background: white;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .login-image {
            width: 100%;
            height: 150px;
            margin-bottom: 30px;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ddd;
        }

        .login-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            color: #999;
            font-size: 14px;
            text-align: center;
        }

        .login-title {
            text-align: center;
            color: #333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .login-subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #4ecdc4;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #4ecdc4;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #45b7af;
        }

        .alert-error {
            padding: 12px;
            margin-bottom: 20px;
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
            border-radius: 6px;
            text-align: center;
            font-size: 14px;
        }

        .login-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #4ecdc4;
        }

        .info-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .credential-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 13px;
        }

        .credential-label {
            color: #666;
        }

        .credential-value {
            color: #333;
            font-weight: 600;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .back-link a {
            color: #4ecdc4;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <!-- Gambar dari Local -->
            <div class="login-image">
                <?php
                // Cek apakah file gambar ada
                $image_path = 'logo.jpg';
                if (file_exists($image_path)) {
                    echo '<img src="' . $image_path . '" alt="Kasir Makanan">';
                } else {
                    echo '<div class="no-image">';
                    echo 'Tambahkan gambar "login-image.jpg" di folder ini';
                    echo '</div>';
                }
                ?>
            </div>

            <!-- Judul -->
            <h1 class="login-title">Login Admin</h1>
            <p class="login-subtitle">Kasir Makanan</p>

            <!-- Error Message -->
            <?php if (isset($error)): ?>
                <div class="alert-error">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-input" required value="">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required value="">
                </div>
                
                <button type="submit" name="login" class="btn-login">
                    Login
                </button>
            </form>

            <!-- Back Link -->
            <div class="back-link">
                <a href="index.php">← Kembali ke Kasir</a>
            </div>
        </div>
    </div>
</body>
</html>