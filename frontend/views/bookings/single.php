<?php
require_once __DIR__ . "/../../Template.php";

Template::header($this->model["booking"]->booking_id);
?>

<h1><?= $this->model["booking"]->booking_id ?></h1>

<p>
    <b>Id: </b>
    <?= $this->model["booking"]->booking_id ?>
</p>

<p>
    <b>Booking name: </b>
    <?= $this->model["booking"]->booking_name ?>
</p>

<p>
    <b>Restaurant name: </b>
    <?= $this->model["booking"]->restaurant_name ?>
</p>

<p>
    <b>Date & time: </b>
    <?= $this->model["booking"]->date_time ?>
</p>

<?php if ($this->user->user_role === "admin") : ?>

    <p>
        <b>User ID: </b>
        <?= $this->model["booking"]->user_id ?>
    </p>

<?php endif; ?>

<?php Template::footer(); ?>