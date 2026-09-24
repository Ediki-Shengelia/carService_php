<?php

require_once __DIR__ . '/partials/header.php';
?>
<h1>Service For <?= htmlspecialchars(User::find_by_id($session->getUserId())->name); ?></h1>
<div>
    <form action="" method="post">
        
    </form>
</div>
<?php
require_once __DIR__ . '/partials/footer.php';
