<html>
<head>
</head>
<body>

<form action="" method="post">
	<label for="ID">ID</label>
		<input type="number" name="rider_id" id="rider_id">
		<br/>
	<label for="search">Get rider info</label>
		<input type="submit" name="search" id="search">
		<br/>
</form>

<form action="" method="post">
	<label for="ID">Driver ID</label>
		<input type="number" name="driver_id" id="driver_id">
		<br/>
	<label for="search2">Get drivers category</label>
		<input type="submit" name="search2" id="search2">
		<br/>
</form>

<form action="" method="post">
	<label for="ID">Rider ID</label>
		<input type="number" name="rider_id" id="rider_id">
		<br/>
	<label for="search3">Get riders favorite destination</label>
		<input type="submit" name="search3" id="search3">
		<br/>
</form>

<form action="" method="post">
	<label for="ID">Driver ID</label>
		<input type="number" name="driver_id" id="driver_id">
		<br/>
	<label for="search4">Get all transactions for the driver</label>
		<input type="submit" name="search4" id="search4">
		<br/>
</form>

<form action="" method="post">
	<label for="ID">Rider ID</label>
		<input type="number" name="rider_id" id="rider_id">
		<br/>
	<label for="search5">Get all scheduled rides for the rider</label>
		<input type="submit" name="search5" id="search5">
		<br/>
</form>

</body>
</html> 
<?php
$rider_id="";
$driver_id="";
if($_SERVER["REQUEST_METHOD"]== "POST") {
	$conn = new mysqli('localhost', 'root', '', 'project 1');
	if ($conn->connect_error) {
		echo "connection failed";
		die("Connection failed: " . $conn->connect_error);
	}

	if(!empty($_POST['search'])) {
		$rider_id=$_POST['rider_id'];//the 'name'
		$resultSet = $conn->query("select * from rider where rider_id='$rider_id'");
		if ($resultSet->num_rows != 0) {
			echo"
			<table border='1'>
				<tr>
					<th>ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Rating</th>
				</tr>";
			while ($rows = $resultSet->fetch_assoc()) {
				$rider_id = $rows['RIDER_ID'];
				$first_name= $rows['FIRST_NAME'];
				$last_name = $rows['LAST_NAME'];
				$rating = $rows['RATING'];
				echo "
				<tr>
					<td>$rider_id</td>
					<td>$first_name</td>
					<td>$last_name</td>
					<td>$rating</td>
				</tr>";
			}
			echo "</table>";
		}else{
			echo "Rider not found";
		}
	}
	
	
	if(!empty($_POST['search2'])) {
		$driver_id = $_POST['driver_id'];
		$resultSet = $conn->query("SELECT first_name, last_name, driver_category.category, price_rate FROM driver, driver_category, categories WHERE driver.driver_ID = driver_category.driver_ID AND driver_category.CATEGORY = categories.CATEGORY AND driver.driver_id = '$driver_id'");
		if ($resultSet->num_rows != 0) {
			echo"
			<table border='1'>
				<tr>
					<th>ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Category</th>
					<th>Price Rate</th>
				</tr>";
			while ($rows = $resultSet->fetch_assoc()) {

				$first_name= $rows['first_name'];
				$last_name = $rows['last_name'];
				$category = $rows['category'];
				$price_rate = $rows['price_rate'];
				echo "
				<tr>
					<td>$driver_id</td>
					<td>$first_name</td>
					<td>$last_name</td>
					<td>$category</td>
					<td>$price_rate</td>
				</tr>";
			}
			echo "</table>";
		}else{
			echo "Driver not found.";
		}
	}
	
	if(!empty($_POST['search3'])) {
		$rider_id = $_POST['rider_id'];
		$resultSet = $conn->query("SELECT rider.rider_ID, rider.first_name, rider.last_name, end_location FROM rider, rider_fav_destination, favorite_destination WHERE rider.rider_ID = rider_fav_destination.rider_ID AND rider_fav_destination.destination_ID = favorite_destination.destination_ID AND rider.rider_id='$rider_id'");
		if ($resultSet->num_rows != 0) {
			echo"
			<table border='1'>
				<tr>
					<th>ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Favorite Location</th>
				</tr>";
			while ($rows = $resultSet->fetch_assoc()) {

				$first_name= $rows['first_name'];
				$last_name = $rows['last_name'];
				$end_location = $rows['end_location'];
				echo "
				<tr>
					<td>$rider_id</td>
					<td>$first_name</td>
					<td>$last_name</td>
					<td>$end_location</td>
				</tr>";
			}
			echo "</table>";
		}else{
			echo "No favorite destinations for this rider, or the rider was not found";
		}
	}
	
	if(!empty($_POST['search4'])) {
		$driver_id = $_POST['driver_id'];
		$resultSet = $conn->query("SELECT driver.first_name, driver.last_name, ride_transaction.t_date, ride_transaction.t_time, ride_transaction.start_location, ride_transaction.end_location, ride_transaction.amount_paid FROM driver INNER JOIN ride_transaction ON driver.driver_ID = ride_transaction.driver_ID AND driver.driver_id='$driver_id'");
		if ($resultSet->num_rows != 0) {
			echo"
			<table border='1'>
				<tr>
					<th>ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Date</th>
					<th>Time</th>
					<th>Start Location</th>
					<th>End Location</th>
				</tr>";
			while ($rows = $resultSet->fetch_assoc()) {

				$first_name= $rows['first_name'];
				$last_name = $rows['last_name'];
				$date = $rows['t_date'];
				$time = $rows['t_time'];
				$end_location = $rows['end_location'];
				$start_location = $rows['start_location'];
				echo "
				<tr>
					<td>$driver_id</td>
					<td>$first_name</td>
					<td>$last_name</td>
					<td>$date</td>
					<td>$time</td>
					<td>$start_location</td>
					<td>$end_location</td>
				</tr>";
			}
			echo "</table>";
		}else{
			echo "No transactions for this driver, or the driver was not found";
		}
	}
	
	if(!empty($_POST['search5'])) {
		$rider_id = $_POST['rider_id'];
		$resultSet = $conn->query("SELECT rider.rider_ID, rider.first_name AS 'Rider Name', driver.driver_ID, driver.first_name AS 'Driver Name', s_date, s_time, schedule_ride.start_location FROM rider, schedule_ride, driver WHERE rider.rider_ID = schedule_ride.rider_ID AND driver.driver_ID = schedule_ride.driver_ID AND rider.rider_id='$rider_id'");
		if ($resultSet->num_rows != 0) {
			echo"
			<table border='1'>
				<tr>
					<th>ID</th>
					<th>Rider's Name</th>
					<th>Driver's Name</th>
					<th>Date</th>
					<th>Time</th>
					<th>Start Location</th>
				</tr>";
			while ($rows = $resultSet->fetch_assoc()) {

				$rider_name= $rows['Rider Name'];
				$driver_name = $rows['Driver Name'];
				$date = $rows['s_date'];
				$time = $rows['s_time'];
				$start_location = $rows['start_location'];
				echo "
				<tr>
					<td>$rider_id</td>
					<td>$rider_name</td>
					<td>$driver_name</td>
					<td>$date</td>
					<td>$time</td>
					<td>$start_location</td>
				</tr>";
			}
			echo "</table>";
		}else{
			echo "No scheduled rides for this rider, or the rider was not found";
		}
	}
}
else{

	echo "search didnt get hit";
}

?>