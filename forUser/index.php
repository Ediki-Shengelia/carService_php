<?php

require_once __DIR__ . '/partials/header.php';
$bookedServices = BookingService::getUserBookedServices($session->getUserId());

$date_now = date("Y-m-d H:i:s");


?>
<h1 style="font-family: Arial, sans-serif; color: #333; font-size: 24px; margin-bottom: 15px;">
    Hello User <?= htmlspecialchars(User::find_by_id($session->getUserId())->name); ?>
</h1>
<a href="booking_service.php" style="display: inline-block; padding: 10px 15px; background-color: #007bff; color: #white; text-decoration: none; border-radius: 4px; font-family: Arial, sans-serif; margin-bottom: 20px;">
    Service book
</a>

<div style="font-family: Arial, sans-serif; display: flex; flex-direction: column; gap: 15px;">
    <?php if (empty($bookedServices)): ?>
        <p style="color: #666; font-style: italic;">You don't have any Booked Service with us</p>
    <?php else: ?>
        <?php foreach ($bookedServices as $bk): ?>

            <?php
            $staff = Staff::find_by_id($bk->staff_id);
            $service = Service::find_by_id($bk->service_id);
            if ($bk->completed_at <= $date_now) {
                $bk->status = "completed";
                $bk->update();
            }
            ?>
            <div style="border: 1px solid #ddd; padding: 15px; border-radius: 6px; background-color: #f9f9f9; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <h2 style="margin-top: 0; font-size: 20px; color: #222;">
                    <?= $service->service; ?>
                    <span style="color: green; font-weight: bold;"> $<?= $service->price; ?></span>
                </h2>
                <p style="color: #555; line-height: 1.4;"><?= $bk->description; ?></p>
                <p style="color: #444; font-size: 14px;">Service Booked: <?= formatDate($bk->booking_date); ?>
                    <span style="color: #d4ac0d; font-weight: bold; background-color: #fcf3cf; padding: 2px 6px; border-radius: 3px;"><?= $bk->start_time; ?></span>
                </p>
                <h3 style="font-size: 16px; color: #333; margin-bottom: 0;">
                    Service Will be Finished <?= $bk->completed_at; ?>

                </h3>
                <p>
                    Works Our team member
                    <span style="color:rebeccapurple"><?= User::find_by_id($staff->user_id)->name; ?></span>
                </p>

                <?php if ($bk->status == 'cancelled'): ?>
                    <p>
                        <b>
                            Service is cancelled
                        </b>
                    </p>
                <?php elseif ($bk->status == "completed"): ?>
                    <p>
                        <b>
                            Service is comleted
                        </b>
                    </p>
                <?php else: ?>
                    <a href="bk_service_cancell.php?bk_service_id=<?= $bk->id; ?>">
                        <button>Cancell</button>
                    </a>
                <?php endif; ?>

            </div>

        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php
require_once __DIR__ . '/partials/footer.php';
