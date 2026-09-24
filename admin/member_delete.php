<?php
require_once __DIR__ . '/../includes/init.php';

if (!$session->is_signed_in()) {
    Redirect("../login.php");
}
$staff_id = (int)$_GET['staff_id'];

if (empty($staff_id)) {
    readdir("index.php");
}

$staff = Staff::find_by_id($staff_id);
if ($staff) {
    $staff->delete();
}
Redirect("index.php");
