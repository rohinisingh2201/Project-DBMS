<?php require_once 'header.php'; ?>
<head>
<link rel="shortcut icon" href="/assets/favicon.ico">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="app.css">
</head>
<?php

session_start();
$prod_id = $_GET["prod_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "basic_billing_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SET FOREIGN_KEY_CHECKS=0;";
mysqli_query($conn, $sql);

if (isset($_POST['submit'])) {

	$cust_id = $_SESSION["cust_id"];
	$rate = $_POST['rate'];
	$qty = $_POST['qty'];
	$amount = $rate * $qty;
	$tax = $amount * 0.09;
	$total_amount = $amount + $tax;


	$sql = "INSERT INTO `basic_billing_system`.`invoice` (`cust_id`,`amount`,`tax`,`total_amount`) VALUES ('$cust_id','$amount','$tax','$total_amount');";

	if ($conn->query($sql) === TRUE) {
		$inv_id = $conn->insert_id;
		$sql = "SELECT Inv_id FROM `invoice` ORDER BY Inv_id DESC LIMIT 1;";
		$result = mysqli_query($conn, $sql);
		$last_inv_id = $result->fetch_array()[0];
		$sql_address = "INSERT INTO `basic_billing_system`.`invoice_details` (`prod_id`,`qty`,`rate`,`amount`,`tax`,`total_amount`,`Inv_id`) VALUES ('$prod_id','$qty','$rate','$amount','$tax','$total_amount','$last_inv_id');";
		if ($conn->query($sql_address) === TRUE) {
			echo '<script language="javascript">';
			echo 'alert("Shopping successfull!")';
			echo '</script>';
		} else {
			echo "Error: " . $sql_address . "<br>" . $conn->error;
		}
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

?>

<style>
	.prod-details h1 {
		font-size: 25px;
		text-transform: uppercase;
		font-weight: 700;
		color: #2B83EA;
		margin-top: 30px;
	}

	.prod-content {
		padding: 20px 40px;
		background-color: #2B83EA22;
		margin-top: 20px;
		border-radius: 5px;
		display: flex;
		justify-content: space-between;
	}

	.prod-content img {
		height: 400px;
		width: 40%;
		border-radius: 5px;
	}

	.prod-content-right {
		width: 55%;
	}

	.prod-buy {
		border-radius: 5px;
		padding: 7px 20px;
		border: 2px solid #2B83EA;
	}

	.prod-button {
		padding: 7px 20px;
		text-decoration: none;
		background-color: transparent;
		border: 2px solid #2B83EA;
		color: #000;
		margin-top: 5px;
		border-radius: 5px;
		display: inline-block;
		transition: all .3s;
	}

	.prod-button:hover {
		background-color: #2B83EA;
		border: 2px solid #2B83EA;
		color: #fff;
	}
</style>

<form class="prod-details" name=shop action="<?php $_SERVER["PHP_SELF"]; ?>" method=post>
	
	<div class="container">
		<div class="row">
			<h1>product Details</h1>

			<!-- <div class="prod-content">
				<img src="" alt="">
				<div class="prod-content-right">
					
				</div>
			</div> -->

			<?php


			$sql = "SELECT * FROM basic_billing_system.products where prod_id=" . $prod_id;
			$result = $conn->query($sql);

			$cnt = 0;

			if ($result->num_rows > 0) {
				// output data of each row
				while ($row = $result->fetch_assoc()) {
					//if ($cnt % 3 == 0)
					//{
					echo "";
					//}

					echo "<div class=prod-content> <img src=" . $row["prod_image"] . " > <div class=prod-content-right><h1>" . $row["prod_name"] . "</h1><p>Range: " . $row["prod_range"] . "</p><p>Model Number: " . $row["prod_model_no"] . "</p><p>Rating: " .  $row["prod_rating"] . "</p>₹" . $row["prod_rate"] . "<p></p><input class=prod-buy type=text id=qty name=qty value=1 ><input type=hidden id=rate name=rate value=" . $row["prod_rate"] . " > <input class=prod-button type=submit value=Buy name=submit ></div>";
					
					$cnt = $cnt + 1;
				}
			} else {
				echo "0 results";
			}
			$conn->close();


			?>
			</div>
		</div>
		
</form>
<br><br><br>
<?php require_once 'footer.php';?>
