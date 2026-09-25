<?php

require_once __DIR__ . '/partials/header.php';
?>
<h1>Hello User <?= htmlspecialchars(User::find_by_id($session->getUserId())->name); ?></h1>
<a href="booking_service.php">Service book</a>
<?php
require_once __DIR__ . '/partials/footer.php';
