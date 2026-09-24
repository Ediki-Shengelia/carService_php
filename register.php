<?php


require_once __DIR__ . '/partials/header.php';
$error = [];
$name = $_POST['name'] ?? "";
$email = $_POST['email'] ?? "";
if (isPostRequest()) {
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    if ($password != $confirm) {
        $error[] = "Password DO not Match";
    } else {
        $user = new User();
        $user->name = trim($_POST['name']);
        $user->email = trim($_POST['email']);
        $user->password = trim($_POST['confirm']);
        $user->role = "user";
        $user->status = null;
        if (!$user->set_file($_FILES['image'])) {
            $error = $user->errors;
        } elseif (!$user->save_with_photo()) {
            $error = $user->errors;
        } elseif ($user->save()) {
            $session->login($user);
            Redirect("admin/index.php");
        } else {
            $error[] = "User is nOT register";
        }
    }
}
?>

<h1>Register</h1>

<?php if (!empty($error)): ?>
    <?php foreach ($error as $er): ?>
        <p style="color: red;"><?= htmlspecialchars($er); ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<div>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($name); ?>">
        <br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email); ?>">
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="confirm">confirm Passowrd</label>
        <input type="password" name="confirm" id="confirm" required>
        <br>
        <input type="file" name="image">
        <br>
        <input type="submit" value="Register">
    </form>
</div>
<?php

require_once __DIR__ . '/partials/footer.php';
