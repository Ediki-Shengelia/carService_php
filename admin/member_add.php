<?php

require_once __DIR__ . '/partials/header.php';

if (User::find_by_id($session->getUserId())->role != "admin") {
    Redirect("../forUser/index.php");
}

$users = User::find_all();
$message = null;
if (isPostRequest()) {

    $new_member_id = (int)$_POST['user_id'];


    $user = User::find_by_id($new_member_id);


    if (!$user) {
        $message = "User NOT found";
    } elseif (Staff::find_staff_by_user_id($new_member_id)) {
        $message = "Staff Already is Your Team member";
    } else {
        $staff = new Staff();
        $staff->user_id = $new_member_id;
        $staff->phone = trim($_POST['phone']);
        $staff->specialization = trim($_POST['specialization']);
        $staff->role = trim($_POST['role']);
        $staff->salary = (int)$_POST['salary'];
        $staff->hire_date = date("Y-m-d H:i:s");
        if ($staff->create()) {
            $user->status = "active";
            $user->role = "employee";
            $user->update();
            $message = User::find_by_id($new_member_id)->name . " is Now Our Team Member";
        } else {
            $message = "We can't add This user To our team";
        }
    }
}

?>
<h1>Add Team member Admin
    <span style="color: red;">
        <?= htmlspecialchars(User::find_by_id($session->getUserId())->email); ?>
    </span>
</h1>
<?php if (!empty($message)): ?>
    <p style="color: red;"><?= $message; ?></p>
<?php endif; ?>
<div>
    <form action="" method="post">
        <div>
            <select name="user_id" id="">
                <?php foreach ($users as $user): ?>
                    <?php if ($user->role == "user"): ?>
                        <option value="<?= htmlspecialchars($user->id); ?>"><?= $user->name; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <label for="phone">Phone</label>
        <input type="tel" name="phone" id="phone" required>
        <br>
        <label for="specialization">specialization</label>
        <input type="text" name="specialization" id="specialization" required>
        <br>
        <label for="role">role</label>
        <input type="text" name="role" id="role" required>
        <br>
        <label for="salary">salary</label>
        <input type="number" name="salary" id="salary" min="500" max="10000" required>
        <br>
        <input type="submit" value="Add">

    </form>
</div>
<?php
require_once __DIR__ . '/partials/footer.php';
