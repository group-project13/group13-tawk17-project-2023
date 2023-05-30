<?php
require_once __DIR__ . "/../../Template.php";


Template::header("Bookings");
?>

<h1>Bookings</h1>

<a href="<?= $this->home ?>/bookings/new">Create new</a>

<div class="item-grid">

    <?php foreach ($this->model as $booking) : ?>

        <article class="item">
            <div>
                <b><?= $booking->booking_name ?></b> <br>
                <span>Restaurant name: <?= $booking->restaurant_name ?></span> <br>
                <span>Date & Time: <?= $booking->date_time ?></span> <br>
            </div>


            <?php if ($this->user->user_role === "admin") : ?>

                <p>
                    <b>User ID: </b>
                    <?= $booking->user_id ?>
                </p>
            <a href="<?= $this->home ?>/bookings/<?= $booking->booking_id ?>/edit">Edit</a>

            <?php endif; ?>

            <a href="<?= $this->home ?>/bookings/<?= $booking->booking_id ?>">Show</a>
        </article>

    <?php endforeach; ?>

</div>

<?php Template::footer(); ?>