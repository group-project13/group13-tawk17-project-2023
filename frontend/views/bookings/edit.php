<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Edit " . $this->model->booking_id);
?>

<h1>Edit <?= $this->model->booking_id ?></h1>

<form action="<?= $this->home ?>/bookings/<?= $this->model->booking_id ?>/edit" method="post">

    <label for="name">Your Name</label>
    <input type="text" name="booking_name" value="<?= $this->model->booking_name ?>" placeholder="Booking name"> <br>

    <label for="restaurant-selection">Select Which City</label>
    <select id="restaurant_name" name="restaurant_name" value="<?= $this->model->restaurant_name ?>" required>

        <option <?php if ($this->model->restaurant_name == "Jönköping") {echo "selected";} ?>>Jönköping</option>
        <option <?php if ($this->model->restaurant_name == "Göteborg") {echo "selected";} ?>>Göteborg</option>
        <option <?php if ($this->model->restaurant_name == "Stockholm") {echo "selected";} ?>>Stockholm</option>

    </select>

    <label for="checkin-date">Check-in Date</label>
    <input type="datetime-local" id="date_time" name="date_time" value="<?= $this->model->date_time ?>" required>


    <label>User Id</label>
    <input type="number" name="user_id" value="<?= $this->model->user_id ?>" > <br>

    <input type="submit" value="Save" class="btn">
</form>

<form action="<?= $this->home ?>/bookings/<?= $this->model->booking_id ?>/delete" method="post">
    <input type="submit" value="Delete" class="btn delete-btn">
</form>

<?php Template::footer(); ?>