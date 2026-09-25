<?php

require_once __DIR__ . '/partials/header.php';

$staffs = Staff::find_all();
$services = Service::find_all();
$workingHours = WorkingHours::find_all();
if (isPostRequest()) {
    $user_id = $session->getUserId();
    $staff_id = (int)$_POST['staff_id'];
    $service_id = (int) $_POST['service_id'];
    $description = $_POST['description'];
    $time = $_POST['start_time'];
    $bookingService = new BookingService();
    $bookingService->user_id = $user_id;
    $bookingService->staff_id = $staff_id;

    $bookingService->service_id = $service_id;
    $bookingService->description = $description;
    $bookingService->booking_date = date("Y-m-d H:i:s");


    // ! check Status
    $staff_status = Staff::find_by_id($staff_id);
    if ($staff_status->progress != "in_progress") {
        $bookingService->start_time = $time;
        $staff_status->progress = "in_progress";
        $staff_status->update();
        // !FOr service time 
        $service_time = Service::find_by_id($service_id);
        $bookingService->end_time = date("H:i:s", strtotime("+{$service_time->duration_value} {$service_time->duration_unit}"));
        $bookingService->status = "confirmed";
        $bookingService->completed_at =  date("Y-m-d H:i:s", strtotime("+{$service_time->duration_value} {$service_time->duration_unit}"));;
        if ($bookingService->create()) {
            $message = "Service Booked";
        }
    } else {
        $message = "The Staff is Busy";
    }
}
?>
<h1>Service For <?= htmlspecialchars(User::find_by_id($session->getUserId())->name); ?></h1>
<?php if (!empty($message)): ?>
    <p style="color:red"><?= $message; ?></p>
<?php endif; ?>
<div>
    <form action="" method="post">
        <select name="staff_id" required id="">
            <option value="">Select Staff member</option>
            <?php foreach ($staffs as $st): ?>
                <?php $user = User::find_by_id($st->user_id); ?>
                <?php if ($user->role == "employee"): ?>
                    <option value="<?= $st->id; ?>"><?= $user->name; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <br>
        <select name="service_id" id="" required>
            <option value="">Select Service</option>
            <?php foreach ($services as $sr): ?>
                <option value="<?= $sr->id; ?>"><?= $sr->service; ?>
                    <span>
                        -$<?= $sr->price; ?>
                    </span>
                </option>
            <?php endforeach; ?>
        </select>
        <div>
            <select name="day_of_week" id="" required>
                <option value="">Select Day of week</option>
                <?php foreach ($workingHours as $wk): ?>
                    <option value="<?= $wk->id; ?>"><?= $wk->day_of_week; ?></option>
                <?php endforeach; ?>
            </select>
            <input
                type="time"
                name="start_time"
                required
                min="09:00"
                max="18:00"
                id="start_time">
        </div>
        <div>
            <label for="desc">Descripon</label>
            <textarea name="description" id="desc"></textarea>
        </div>
        <input type="submit" value="Book">
    </form>
</div>
<?php
require_once __DIR__ . '/partials/footer.php';
