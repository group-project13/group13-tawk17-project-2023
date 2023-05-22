<!DOCTYPE html>
<html>
<head>
	<title>Table Booking Application</title>
	<link rel="stylesheet" type="text/css" href="/css/home.css">
</head>
<body>
	<header>
		<div class="logo">
			<img src="logo.png" alt="Logo">
			<h1>Table Booking Application</h1>
		</div>
	</header>
	
	<main>
		<section class="booking">
			<h2>Book a Table</h2>
			<form method="post" action="booking.php">
				<p>Name:</p>
				<input type="text" name="name" placeholder="Enter your name">
				<p>Date:</p>
				<input type="date" name="date">
				<p>Time Slot:</p>
				<select name="timeslot">
					<option value="09:00">09:00</option>
					<option value="12:00">12:00</option>
					<option value="15:00">15:00</option>
				</select>
				<input type="submit" name="submit" value="Book">
			</form>
		</section>
		
		<section class="bookings">
			<h2>Your Bookings</h2>
			<ul>
				<li>
					<span class="booking-info">Name: John Doe</span>
					<span class="booking-info">Date: 2023-05-23</span>
					<span class="booking-info">Time Slot: 09:00</span>
					<button class="edit-button">Edit</button>
					<button class="delete-button">Delete</button>
				</li>
				<li>
					<span class="booking-info">Name: Jane Smith</span>
					<span class="booking-info">Date: 2023-05-24</span>
					<span class="booking-info">Time Slot: 12:00</span>
					<button class="edit-button">Edit</button>
					<button class="delete-button">Delete</button>
				</li>
			</ul>
		</section>
	</main>
</body>
</html>
