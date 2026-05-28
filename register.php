<?php
session_start();
if(isset($_SESSION['user_id'])) header('Location: dashboard.php');
require_once 'config/database.php';
require_once 'includes/functions.php';
$message = ''; $error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'username' => trim($_POST['username']),
        'password' => $_POST['password'],
        'email' => trim($_POST['email']),
        'phone' => trim($_POST['phone']),
        'full_name' => trim($_POST['full_name']),
        'teacher_id' => trim($_POST['teacher_id']),
        'department' => $_POST['department'],
        'emergency_contact' => trim($_POST['emergency_contact'])
    ];
    if(empty($data['username']) || empty($data['password']) || empty($data['email']) || empty($data['full_name']) || empty($data['teacher_id'])) {
        $error = "Please fill all required fields.";
    } else {
        $result = registerTeacher($data);
        if($result['success']) $message = $result['message'];
        else $error = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Minungwinii SS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea, #764ba2); padding: 40px 0; }
        .register-card { background: white; border-radius: 20px; padding: 30px; max-width: 600px; margin: auto; }
    </style>
</head>
<body>
<div class="container"><div class="register-card">
    <h2 class="text-center">Teacher Registration</h2>
    <?php if($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
    <?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <form method="POST">
        <div class="row"><div class="col-md-6 mb-3"><label>Full Name *</label><input type="text" name="full_name" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Teacher ID *</label><input type="text" name="teacher_id" class="form-control" required></div></div>
        <div class="row"><div class="col-md-6 mb-3"><label>Username *</label><input type="text" name="username" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Password *</label><input type="password" name="password" class="form-control" required></div></div>
        <div class="row"><div class="col-md-6 mb-3"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label>Phone Number</label><input type="text" name="phone" class="form-control"></div></div>
        <div class="row"><div class="col-md-6 mb-3"><label>Department *</label>
            <select name="department" class="form-control" required><option value="Science">Science</option><option value="Mathematics">Mathematics</option><option value="Languages">Languages</option><option value="Arts">Arts</option><option value="Technical">Technical</option></select></div>
        <div class="col-md-6 mb-3"><label>Emergency Contact</label><input type="text" name="emergency_contact" class="form-control"></div></div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
    <div class="text-center mt-3">Already have an account? <a href="login.php">Login</a></div>
</div></div>
</body>
</html>