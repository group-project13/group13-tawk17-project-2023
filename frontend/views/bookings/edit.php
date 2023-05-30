<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Edit " . $this->model->booking_id);
?>

<h1>Edit <?= $this->model->booking_id ?></h1>

<form action="<?= $this->home ?>/bookings/<?= $this->model->booking_id ?>/edit" method="post">
    <input type="text" name="booking_name" value="<?= $this->model->booking_name ?>" placeholder="Booking name"> <br>
    <input type="text" name="restaurant_name" value="<?= $this->model->restaurant_name ?>" placeholder="Restaurant name"> <br>
    <input type="number" name="date_time" value="<?= $this->model->date_time ?>" placeholder="Date & time"> <br>

    <input type="number" name="user_id" value="<?= $this->model->user_id ?>" placeholder="User ID"> <br>

    <input type="submit" value="Save" class="btn">
</form>

<form action="<?= $this->home ?>/bookings/<?= $this->model->booking_id ?>/delete" method="post">
    <input type="submit" value="Delete" class="btn delete-btn">
</form>

<?php Template::footer(); ?>