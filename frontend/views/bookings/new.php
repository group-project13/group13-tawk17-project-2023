<?php
require_once __DIR__ . "/../../Template.php";

Template::header("New Booking");
?>

<h1>New Booking</h1>

<form action="<?= $this->home ?>/bookings" method="post">

    <input type="text" name="booking_name" placeholder="Booking name"> <br>
    <input type="text" name="restaurant_name" placeholder="Restaurant name"> <br>
    <input type="number" name="date_time" placeholder="Date & time"> <br>


    <?php if ($this->user->user_role === "admin") : ?>
        <input type="number" name="user_id" placeholder="User ID"> <br>
    <?php endif; ?>

    <input type="submit" value="Save" class="btn">
</form>

<?php Template::footer(); ?>