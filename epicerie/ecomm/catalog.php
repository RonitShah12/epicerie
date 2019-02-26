<?php
	$cuisine = $_GET['cuisine'];

	$conn = mysqli_connect("localhost:3306", "root", "", "exp5");

	$res = $conn->query("select * from cuisines where cuisine='$cuisine' or '$cuisine'='all'");	

	while($row = $res->fetch_assoc()){
		$recipe_flag = true;
		$price_flag = true;
		$description_flag = true;

		if(isset($_GET["keywords"])){		
			$recipe_flag = preg_match("#.*".$_GET["keywords"].".*#", $row["recipe"]);
			$price_flag = preg_match("#.*".$_GET["keywords"].".*#", $row["price"]);
			$description_flag = preg_match("#.*".$_GET["keywords"].".*#", $row["description"]);
		}

		if($recipe_flag or $price_flag or $description_flag){
			echo "<div class ='item'>";

				echo "<img class='prompt' src='/epicerie/res/".$row['img']."'/>";			

				echo "<div class='item_desc'>";
					echo "<span class = 'name'>".$row['recipe']."</span>";
					echo "<span class = 'price'>".$row['price']."</span>";
				echo "</div>";

				echo "<div class='item_desc'>";
					echo "'<span class = 'description'>".$row['description']."</span>";
				echo "</div>";

			echo "</div>";
		}			
	}	
?>
