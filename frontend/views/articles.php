<?php
require_once __DIR__ . "/../Template.php";

Template::header("Book Table"); 

?>
<div class="booking-page">
    <h1>Book your table here</h1>
    <form action="reservation.php" method="post">

  <div class="elem-group">
    <label for="name">Your Name</label>
    <input type="text" class="name" name="visitor_name" placeholder="Rickard Persson" required>
  </div>
  
  <div class="elem-group">
    <label for="restaurant-selection">Select Which City</label>
    <select id="restaurant-selection" name="restaurant_preference" required>
        <option value="">Choose a City from the List</option>
        <option value="connecting">Jönköping</option>
        <option value="adjoining">Göteborg</option>
        <option value="adjacent">Stockholm</option>
    </select>
  </div>

  <label for="checkin-date">Check-in Date</label>
  <input type="datetime-local" id="booking-date" name="booking" required>

  <button class="booking-button"type="submit">Book Table</button>
</form>
</div>


<?php Template::footer(); ?>