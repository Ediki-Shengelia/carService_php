<?php

require_once __DIR__ . '/partials/header.php';

$currentUser = User::find_by_id($session->getUserId());
if (!$currentUser || $currentUser->role != "admin") {
    Redirect("../forUser/index.php");
}
$service = new Service();
$service->create_service();
$staffs = Staff::find_all();
?>

<div style="max-width: 900px; margin: 40px auto; font-family: Arial, sans-serif; color: #333;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 24px;">Hello Admin <?= htmlspecialchars($currentUser->email); ?></h1>
        <a href="member_add.php" style="background-color: #007bff; color: white; padding: 10px 16px; text-decoration: none; border-radius: 4px; font-weight: bold;">Add member</a>
    </div>

    <h2 style="border-bottom: 2px solid #eee; padding-bottom: 8px; margin-top: 30px; font-size: 20px;">Employees</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 20px;">
        <?php foreach ($staffs as $st): ?>
            <?php $userInfo = User::find_by_id($st->user_id); ?>
            <?php if (!$userInfo) continue; ?>

            <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; flex-direction: column; align-items: center; text-align: center;">
                <img style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 2px solid #eee;" src="../users/<?= htmlspecialchars($userInfo->image); ?>" alt="<?= htmlspecialchars($userInfo->name); ?>">

                <h3 style="margin: 0 0 5px 0; font-size: 18px;"><?= htmlspecialchars($userInfo->name); ?></h3>
                <span style="color: #28a745; font-size: 14px; margin-bottom: 15px; display: inline-block;"><?= htmlspecialchars($userInfo->email); ?></span>

                <div style="width: 100%; border-top: 1px solid #eee; padding-top: 12px; text-align: left; font-size: 14px; color: #555;">
                    <p style="margin: 6px 0;"><strong>Specialization:</strong> <?= htmlspecialchars($st->specialization); ?></p>
                    <p style="margin: 6px 0;"><strong>Role:</strong> <?= htmlspecialchars($st->role); ?></p>
                    <p style="margin: 6px 0;"><strong>phone:</strong> <?= htmlspecialchars($st->phone); ?></p>
                    <p style="margin: 6px 0;"><strong>Hire Date:</strong> <?= htmlspecialchars(formatDate($st->hire_date)); ?></p>
                    <div style="margin-top: 15px; width: 100%;">
                        <a href="member_delete.php?staff_id=<?= $st->id; ?>"
                            onclick="return confirm('ნამდვილად გსურთ ამ თანამშრომლის წაშლა?');"
                            style="display: block; width: 100%; background-color: #dc3545; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; text-align: center; box-sizing: border-box; font-weight: bold;">
                            Delete From Staff
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once __DIR__ . '/partials/footer.php';
?>