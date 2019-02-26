<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		.prompt{
			height: 15vh;
			width: 15vw;
		}

		.item{
			display: flex;
			flex-direction: row;			

			margin-top: 10px;
		}

		.item_desc{
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;

			margin-left: 5px;
			padding: 5px;
		}

		.name{
			font-weight: bolder;
		}

		.price{
			color: green;			
		}

		#search{
			padding: 3px 5px 5px 5px;
		}

		#search:hover{
			border:1px solid #777777;			
		}

		.add_button{
			color: green;
			font-size: 4vh;
			font-family: sans-serif;
			font-weight: bold;

			position: absolute;
			right: 0%;
		}

		.add_button:hover{
			cursor: pointer;
		}
	</style>
</head>
<body>
	<select onchange="fetchData()">
	
	<?php
		$conn = mysqli_connect("localhost:3306", "root", "", "epicerie");

		$res = $conn->query("select category from catalog group by category");

		if(!$res){
			die(mysqli_error($conn));
		}

		while($row = $res->fetch_assoc()){
			$item = $row["category"];
			
			echo "<option value='$item'>$item</option>";
		}

		echo "<option value='all'>All</option>";
	?>
	
	</select>

	<input type="text" name="query">
	<span id="search" onclick = "fetchDataWithKeyword()">&#x1F50D;</span>

	<div id ="container">
		
	</div>

	<script>
		function fetchDataWithKeyword(){

			var selectedCuisine = document.getElementsByTagName("select")[0].value
			var keywords = document.querySelector("input[name='query']").value
			keywords = keywords.replace(" ", "+")					

			if(keywords == ""){
				fetchData()

				return;
			}

			document.querySelector("#container").innerHTML = ""

			fetch("catalog.php?cuisine="+selectedCuisine+"&keywords="+keywords).then(function(data){
				data.text().then(function(markup){
					document.querySelector("#container").innerHTML = markup
				})
			})		
		}

		function fetchData(){
			var selectedCuisine = document.getElementsByTagName("select")[0].value			

			document.querySelector("#container").innerHTML = ""

			fetch("catalog.php?cuisine="+selectedCuisine).then(function(data){
				data.text().then(function(markup){
					document.querySelector("#container").innerHTML = markup
				})
			})
		}

		function addToShoppingCart(e){
			console.log(e.srcElement.getAttribute("data-item"))
		}
	</script>
</body>
</html>

