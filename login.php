<?php
session_start();
include 'includes/db.php';

$errors = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validasi sederhana
    if(empty($email) || empty($password)){
        $errors = "Email dan password wajib diisi.";
    } else {
        $sql = "SELECT * FROM users WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        
        if($user && password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: index.php');
            exit;
        } else {
            $errors = "Email atau password salah.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2 class="mb-4">Login Ciraku</h2>

<?php if($errors): ?>
    <div class="alert alert-danger"><?= $errors ?></div>
<?php endif; ?>

<form method="post" action="login.php" class="bg-dark p-4 rounded">
    <div class="mb-3">
        <label for="email" class="form-label text-warning">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label text-warning">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
    </div>
    <button type="submit" class="btn btn-ciraku">Login</button>
</form>

<?php include 'includes/footer.php'; ?>
