<?php

require_once __DIR__ . '/partials/header.php';


$Member = Staff::find_staff_by_user_id($session->getUserId());




$allTasksForMember = BookingService::getAllTasksForMembers($Member->id);

$current_date = date("Y-m-d H:i:s");


$MemberDayOff = DayOff::getDayOffForMember($Member->id);
if ($current_date <= $MemberDayOff->date) {

    $user = User::find_by_id($session->getUserId());
    $user->status = "inactive";
    $user->update();
}


?>

<h1>For Member <?= User::find_by_id($Member->user_id)->email; ?></h1>

<?php if (empty($allTasksForMember)): ?>
    <p style="font-family: sans-serif; color: #555; font-size: 16px;">You Don't have Any Tasks</p>
<?php else: ?>
    <?php foreach ($allTasksForMember as $tasks): ?>
        <?php $service = Service::find_by_id($tasks->service_id);

        // var_dump($service);
        ?>
        <div style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); font-family: sans-serif;">
            <h2 style="margin: 0 0 10px 0; font-size: 20px; color: #333; display: flex; align-items: center;">
                <?= $service->service; ?>
                <span style="color: #27ae60; font-size: 18px;margin-left: 10px;">$<span><?= $service->price; ?></span></span>
            </h2>
            <h3 style="margin: 0 0 8px 0; font-size: 15px; color: #666; font-weight: normal;">Time Duration - <?= $service->duration_value . " " . $service->duration_unit; ?></h3>
            <h3 style="margin: 0 0 8px 0; font-size: 15px; color: #666; font-weight: normal;">
                Booked At <?= formatDate($tasks->booking_date); ?>
                <span style="font-weight: bold; color: #444;">For <?= $tasks->start_time; ?></span>
            </h3>
            <?php if ($current_date <= $tasks->completed_at): ?>
                <h4 style="margin: 0 0 12px 0; font-size: 14px; color: #e67e22; font-weight: normal;">
                    This Task Must be finished For
                    <span style="font-weight: bold;"><?= $tasks->completed_at; ?></span>
                </h4>
            <?php else: ?>
                <h4>
                    Task is completed
                    <span><?= diffForHumans($tasks->completed_at); ?></span>
                </h4>
            <?php endif; ?>
            <h1 style="margin: 0; font-size: 16px; color: #2c3e50; border-top: 1px solid #eee; padding-top: 10px;">And User is <?= User::find_by_id($tasks->user_id)->name; ?></h1>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php

require_once __DIR__ . '/partials/footer.php';
