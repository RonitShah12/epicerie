<?php
	$cuisine = $_GET['cuisine'];

	$conn = mysqli_connect("localhost:3306", "root", "", "epicerie");

	$res = $conn->query("select * from catalog where item='$cuisine' or '$cuisine'='all'");	

	while($row = $res->fetch_assoc()){
		$item_flag = true;
		$price_flag = true;
		$description_flag = true;

		if(isset($_GET["keywords"])){		
			$recipe_flag = preg_match("#.*".$_GET["keywords"].".*#", $row["item"]);
			$price_flag = preg_match("#.*".$_GET["keywords"].".*#", $row["price"]);
			$description_flag = preg_match("#.*".$_GET["keywords"].".*#", $row["description"]);
		}

		if($recipe_flag or $price_flag or $description_flag){
			echo "<div class ='item'>";

				echo "<img class='prompt' src='".$row['image']."'/>";			

				echo "<div class='item_desc'>";
					echo "<span class = 'name'>".$row['item']."</span>";
					echo "<span class = 'price'>".$row['price']."</span>";
				echo "</div>";

				echo "<div class='item_desc'>";
					echo "'<span class = 'description'>".$row['description']."</span>";
				echo "</div>";

			echo "</div>";
		}			
	}	
?>
