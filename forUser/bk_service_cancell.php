<?php

require_once __DIR__ . '/../includes/init.php';
if (!$session->is_signed_in()) {
    Redirect("../login.php");
}

$bk_serivice_id = (int)$_GET['bk_service_id'];
if (empty($bk_serivice_id)) {
    Redirect("index.php");
}

$bk_service = BookingService::find_by_id($bk_serivice_id);

if ($bk_service) {
    $staff = Staff::find_by_id($bk_service->staff_id);
    $staff->progress = "cancelled";

    $staff->update();
    $bk_service->status = "cancelled";
    $bk_service->update();
}

Redirect("index.php");
