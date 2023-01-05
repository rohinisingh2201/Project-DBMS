<head>
<link rel="shortcut icon" href="/assets/favicon.ico">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="app.css">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<?php require_once 'header.php';?>
<?php

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
?>


<style>
	form {
		font-family: 'Montserrat', sans-serif;
		overflow-x: hidden;
	}

	.prod-search-form {
		margin-top: 40px;
	}

	.prod-form-label {
		font-size: 16px;
		font-weight: 700;
	}

	.prod-form-search {
		padding: 8px 20px;
		border-radius: 50px;
		border: 2px solid #2B83EA;
		margin: 0 20px 0 10px;
		font-size: 16px;
	}

	.prod-form-search:active,
	.prod-form-search:focus {
		outline: none;
	}

	.prod-form-submit {
		border: none;
		padding: 12px 40px;
		font-size: 16px;
		border-radius: 50px;
		background-color: #2B83EA;
		color: #fff;
		font-weight: 500;
		transition: all .3s;
	}

	.prod-form-submit:hover {
		transform: translateY(-3px);
		box-shadow: 0 10px 20px #2B83EA25;
	}

	.products-section {
		width: 100%;
		border: none;
	}

	.products-section h1 {
		font-size: 25px;
		color: #2B83EA;
		font-weight: 700;
		margin-top: 40px;
	}

	.products-group {
		display: grid;
		grid-template-columns: 1fr 1fr 1fr;
		grid-gap: 30px;
	}

	.prod {
		background: #2B83EA22;
		border-radius: 10px;
		padding: 30px 0;
		transition: all .3s;
	}

	.prod:hover {
		transform: translateY(-2px);
		box-shadow: 0 10px 20px #2B83EA25;
	}

	.prod img {
		width: 75%;
		height: 250px;
		border-radius: 5px;
	}

	.prod h3 {
		font-size: 20px;
		color: #2B83EA;
		font-weight: 600;
		text-transform: capitalize;
	}

	.prod-details {
		width: 75%;
		margin: 0 auto;
		text-align: left;
		margin-top: 20px;
	}

	.prod-detail {
		display: flex;
		justify-content: space-between;
	}

	.prod-button {
		padding: 10px 20px;
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
<form class="prod-search-form" name=customer action="<?php $_SERVER["PHP_SELF"]; ?>" method=post  >
<center> 
<label for="prod_name" class="prod-form-label">Search Product: </label> <input type=text id=prod_name name=prod_name class="prod-form-search" > <input type=submit value=Search name=submit class="prod-form-submit">
</form>
<BR>
<BR>
<?php

if (!isset($_POST['submit'])) {

	
?>

<?php
}
else 
{
	
?>
<section  class="products-section">
	<h1>Product List</h1>
	<div class=container>
		<div class=row>
			<div class=products-group>
			<?php
				$sql = "SELECT * FROM basic_billing_system.products where prod_name like '" .$_POST['prod_name'] . "%'";
				$result = $conn->query($sql);

				$cnt=0;

				if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					if ($cnt % 2 == 0)
					{
						echo "</tr><tr>";
					}
					
					// echo "<td class=product-image> <img src=" . $row["prod_image"]. " width=300 height=250 > </td><td> <b> <a href=shop.php?prod_id=". $row["prod_id"] ." > " . $row["prod_name"]. " (". $row["prod_range"]. ") </a></b><br><br>" . $row["prod_model_no"]. " <br>"  . $row["prod_rating"]. "     </td><td> " . $row["prod_rate"]. " </td>";
					
					echo "<div class=prod><img src=" . $row["prod_image"]. " class=prod-image ><div class=prod-details><div class=prod-detail><h3>" . $row["prod_name"]. "</h3> <p class=prod-rating>Rating: "  . $row["prod_rating"]. "</p></div><div class=prod-detail><p>Range: ". $row["prod_range"]. "</p> <p class=prod-rating>₹" . $row["prod_rate"]. "</p></div><a class=prod-button href=shop.php?prod_id=". $row["prod_id"] .">View Details</a></div></div>";

					$cnt = $cnt + 1;
				}
				} else {
				echo "0 results";
				}
				$conn->close();

			}
			?>
			</div>
		</div>
	</div>
</section>


<script>
	document.getElementById("testimonials").hidden = true;
	document.getElementById("categories").hidden = true;
	document.getElementById("new-arrivals").hidden = true;
</script>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php require_once 'footer.php';?>