<?php

require_once __DIR__ . '/partials/header.php';

$currentUser = User::find_by_id($session->getUserId());
if (!$currentUser || $currentUser->role != "admin") {
    Redirect("../forUser/index.php");
}


$available_services = [
    [
        'service' => 'Oil and Filter Change',
        'price' => 120,
        'duration_value' => 1,
        'duration_unit' => 'hour',
    ],
    [
        'service' => 'Full Engine Diagnostics',
        'price' => 250,
        'duration_value' => 2,
        'duration_unit' => 'hour',
    ],
    [
        'service' => 'Brake Pad Replacement',
        'price' => 300,
        'duration_value' => 3,
        'duration_unit' => 'hour',
    ],
    [
        'service' => 'Tire Rotation and Balancing',
        'price' => 80,
        'duration_value' => 45, // Note: since your unit is 'minute', you could use 45, or 1 hour
        'duration_unit' => 'minute',
    ],
    [
        'service' => 'Wheel Alignment',
        'price' => 150,
        'duration_value' => 1,
        'duration_unit' => 'hour',
    ],
    [
        'service' => 'AC System Recharge and Service',
        'price' => 200,
        'duration_value' => 2,
        'duration_unit' => 'hour',
    ],
    [
        'service' => 'Transmission Fluid Flush',
        'price' => 350,
        'duration_value' => 3,
        'duration_unit' => 'hour',
    ],
    [
        'service' => 'Spark Plug Replacement',
        'price' => 180,
        'duration_value' => 1,
        'duration_unit' => 'hour',
    ],
    [
        'service' => 'Full Body Detailing and Polishing',
        'price' => 600,
        'duration_value' => 1,
        'duration_unit' => 'day',
    ],
    [
        'service' => 'Engine Overhaul & Repair',
        'price' => 2500,
        'duration_value' => 1,
        'duration_unit' => 'week',
    ],
];

if (isPostRequest()) {
    $service = new Service();
   
    $service->service = $_POST['service'];
    $service->price = (int)$_POST['price'];
    $service->duration_value = $_POST['duration_value'];
    $service->duration_unit = $_POST['duration_unit'];
    if ($service->create()) {
        Redirect("index.php");
    }
}

?>

<h1>Add services</h1>
<form action="" method="post">
    <label for="service">Serivice</label>
    <input type="text" name="service" id="service" required>
    <br>
    <label for="price">Price</label>
    <input type="number" name="price" id="price" required>
    <br>
    <div>
        <p>Duration time</p>
        <input type="number" name="duration_value" required>
        <select name="duration_unit" id="" required>
            <option value="">Duration Time</option>
            <option value="minute">Minute</option>
            <option value="hour">Hour</option>
            <option value="day">Day</option>
            <option value="week">Week</option>
        </select>
    </div>
    <input type="submit" value="Add Serive">
</form>
<?php
require_once __DIR__ . '/partials/footer.php';
?>