<?php

require_once __DIR__ . '/partials/header.php';
$email = $_POST['email'] ?? "";
if (isPostRequest()) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_found = User::verify_user($email, $password);
    if ($user_found) {
        $session->login($user_found);
        Redirect("admin/index.php");
    } else {
        $error = "User NOT Found";
    }
}

?>

<h1>Login</h1>

<div>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email); ?>">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
</div>
<?php

require_once __DIR__ . '/partials/footer.php';
