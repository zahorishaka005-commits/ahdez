<?php
session_start();
if(isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit(); }
require_once 'config/database.php';
$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = ? AND status = 'active'");
    $stmt->execute([$username, $role]);
    $user = $stmt->fetch();
    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid username, password or role.";
    }

}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Minungwinii SS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: white; border-radius: 20px; padding: 40px; width: 100%; max-width: 450px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: fadeInUp 0.5s ease; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header h2 { color: #333; }
        .form-control { border-radius: 10px; padding: 12px; }
        .btn-login { background: linear-gradient(135deg, #667eea, #764ba2); border: none; padding: 12px; font-weight: bold; border-radius: 10px; width: 100%; }
        .divider { text-align: center; margin: 20px 0; position: relative; }
        .divider::before, .divider::after { content: ''; position: absolute; top: 50%; width: 45%; height: 1px; background: #ddd; }
        .divider::before { left: 0; }
        .divider::after { right: 0; }
        .social-btn { background: #f0f2f5; border: none; padding: 10px; border-radius: 10px; width: 100%; margin-bottom: 10px; }
        .signup-link { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-header">
        <i class="fas fa-chalkboard-user fa-3x" style="color: #667eea;"></i>
        <h2>Welcome Back</h2>
        <p>Sign in to your account to continue</p>
    </div>
    <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3"><input type="text" name="username" class="form-control" placeholder="Username or Email" required></div>
        <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
        <div class="mb-3">
            <select name="role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="teacher">Teacher</option>
                <option value="admin">Administrator</option>
                <option value="hod">Head of Department</option>
            </select>
        </div>
        <div class="mb-3 form-check"><input type="checkbox" class="form-check-input" id="remember"><label class="form-check-label" for="remember">Remember me</label><a href="#" class="float-end">Forgot password?</a></div>
        <button type="submit" class="btn btn-primary btn-login">Sign In</button>
    </form>
    <div class="divider">or</div>
    <button class="social-btn"><i class="fab fa-google"></i> Continue with Google</button>
    <button class="social-btn"><i class="fab fa-facebook"></i> Continue with Facebook</button>
    <div class="signup-link">Don't have an account? <a href="register.php">Sign up</a></div>
</div>
</body>
</html>