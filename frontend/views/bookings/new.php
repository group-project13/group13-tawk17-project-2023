<?php
require_once __DIR__ . "/../../Template.php";

Template::header("New Booking");
?>

<div class="booking-page">
    <h1>Book your table here</h1>
    <form action="<?= $this->home ?>/bookings" method="post">

  <div class="elem-group">
    <label for="name">Your Name</label>
    <input type="text" id="booking_name" name="booking_name" placeholder="Rickard Persson" required>
  </div>
  
  <div class="elem-group">
    <label for="restaurant-selection">Select Which City</label>
    <select id="restaurant" name="restaurant_name" required>
        <option value="">Choose a City from the List</option>
        <option>Jönköping</option>
        <option>Göteborg</option>
        <option>Stockholm</option>
    </select>
  </div>

  <label for="checkin-date">Check-in Date</label>
  <input type="datetime-local" id="date_time" name="date_time" required>

  <button class="booking-button"type="submit">Book Table</button>
</form>
</div>

<?php Template::footer(); ?>