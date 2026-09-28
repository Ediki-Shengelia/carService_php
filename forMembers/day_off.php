<?php
require_once __DIR__ . '/partials/header.php';

$Member = Staff::find_staff_by_user_id($session->getUserId());
$bk_obj = BookingService::getAllTasksForMembers($Member->id);


// 1) Find busy dates + the latest task date
$busyDates = [];
$lastTs = strtotime('today');   // never start before today

foreach ($bk_obj as $bk) {
    if ($bk->status === 'cancelled') {
        continue;
    }
    $busyDates[$bk->booking_date] = true;

    // use booking_date, or completed_at if it's later
    $ts = strtotime($bk->booking_date);
    if (!empty($bk->completed_at)) {
        $ts = max($ts, strtotime(date('Y-m-d', strtotime($bk->completed_at))));
    }
    $lastTs = max($lastTs, $ts);
}

// 2) Free days: the 60 days after the last task
$freeDays = [];
for ($i = 1; $i <= 60; $i++) {
    $d = date('Y-m-d', strtotime("+$i day", $lastTs));
    if (!isset($busyDates[$d])) {
        $freeDays[] = $d;
    }
}

$error = '';

if (isset($_POST['submit'])) {
    $date = $_POST['date'] ?? '';

    // 3) Server-side check: never trust the form
    if (isset($busyDates[$date])) {
        $error = 'You have tasks on that day.';
    } elseif ($date < date('Y-m-d')) {
        $error = 'Date cannot be in the past.';
    } else {
        $day_off_obj = new DayOff();
        $day_off_obj->staff_id = $Member->id;
        $day_off_obj->date     = $date;
        $day_off_obj->reason   = $_POST['reason'];
        
        if ($day_off_obj->create()) {
            Redirect("index.php");
        }
    }
}
?>

<h1>Day Off For <?= User::find_by_id($Member->user_id)->name; ?></h1>

<?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="" method="post">
    <select name="date" required>
        <option value="">-- choose a free day --</option>
        <?php foreach ($freeDays as $d): ?>
            <option value="<?= $d ?>"><?= date('D, M j Y', strtotime($d)) ?></option>
        <?php endforeach; ?>
    </select>
    <textarea name="reason" placeholder="reason ..."></textarea>
    <input type="submit" value="submit" name="submit">
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>