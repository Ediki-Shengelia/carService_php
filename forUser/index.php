<?php

require_once __DIR__ . '/partials/header.php';
?>
<h1>Hello User <?= htmlspecialchars(User::find_by_id($session->getUserId())->name); ?></h1>

<?php
require_once __DIR__ . '/partials/footer.php';
