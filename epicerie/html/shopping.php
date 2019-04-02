<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		*{
			margin: 0;	
			padding: 0;
		}

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
			font-weight: bold;
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

		#trolley{
			height: 5vh;
			width: 5vh;

			position: absolute;
			right: 1%;
			top: 1%;
		}

		#wallet{
			height: 3.5vh;
			width: 3.5vh;

			position: absolute;
			right: 5%;
			top: 1.5%;
		}

		#overlay{
			height: 100vh;
			width: 100vw;
			background-color: rgba(125, 125, 125, 0.5);
			position: fixed;
			top: 0%;
			left: 0%;

			display: none;
		}

		#checkout{
			background-color: white;
			height: auto;
			width: 30vw;

			padding: 10px;

			display: none;

			position: fixed;
			top: 10%;
			left: 35%;
		}

		#wallet_display{
			background-color: white;
			height: auto;
			width: 30vw;

			padding: 10px;

			display: none;

			position: fixed;
			top: 10%;
			left: 35%;
		}

		#checkout_list{
			display: flex;
			flex-direction: column;
		}

		.record_container{
			display: flex;			
			flex: 1;
		}

		.item_name{
			flex: 0.4;
		}
		.quantity{
			display: flex;
			justify-content: center;		
			flex: 0.2;
		}
		.pip{
			display: flex;
			justify-content: center;
			flex: 0.2;
		}
		.sub_total{
			display: flex;
			justify-content: center;
			flex: 0.2;
		}

		.record_container:first-child{
			font-weight: bold;
			font-family: sans-serif;
			font-size: 1.8vh;
		}

		#grand_total_wrapper{
			display: flex;			
		}

		#grand_total_label{
			flex: 0.8;
		}

		#grand_total_container{
			flex: 0.2;			
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

	<img id="wallet" src="../res/wallet.png" />
	<img id="trolley" src="../res/shopping_trolley.png" />

	<div id = "cart_container">
		
	</div>

	<div id ="container">
		
	</div>

	<div id = "overlay">
	</div>


	<div id = "checkout">
			<b> <center>Bill</center> </b>
			<hr>
			<div id = "checkout_list">
				<div class = "record_container">
					<span class="item_name">Item Name</span>
					<span class="quantity">Quantity</span>
					<span class="pip">Per Item Price</span>
					<span class="sub_total">SubTotal</span>
				</div>
			</div>
			<hr>
			<div id = "grand_total_wrapper">
				<span id = "grand_total_label"><b>GRAND TOTAL</b></span>
				<span id = "grand_total_container">
						<span>&#8377;</span>
						<span id = "real_grand_total">***</span>
				</span>
			</div>
	</div>

	<div id = "wallet_display">
			<b> <center>Wallet</center> </b>
			<hr>
			<div class = "wallet_container">
					<span class="Current Balance">Current Balance</span>
			</div>


	</div>

	<script>
		addToShoppingCart()

		var cart_sym = document.getElementById("trolley")

		cart_sym.addEventListener("click", function(e){
			document.getElementById("overlay").style.display = "block"
			document.getElementById("checkout").style.display = "block"

			document.getElementById("overlay").addEventListener("click", remover)

			function remover(){
				document.getElementById("overlay").style.display = "none"
				document.getElementById("checkout").style.display = "none"

				document.getElementById("overlay").removeEventListener("click", remover)
			}
		})

		var wallet_sym = document.getElementById("wallet")

		wallet_sym.addEventListener("click", function(e){
			document.getElementById("overlay").style.display = "block"
			document.getElementById("wallet_display").style.display = "block"

			document.getElementById("overlay").addEventListener("click", remover)

			function remover(){
				document.getElementById("overlay").style.display = "none"
				document.getElementById("wallet_display").style.display = "none"

				document.getElementById("overlay").removeEventListener("click", remover)
			}
		})

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
			var link = "cart.php"
			if(e)
				link += "?item="+e.srcElement.getAttribute("data-item")+"&num="+1			

			fetch(link).then(function(data){
				data.text().then(function(status){
					var cart = JSON.parse(status)

					var items = Object.keys(cart)
					var bill = document.getElementById("checkout_list")

					while(bill.lastChild != bill.firstElementChild){
						bill.removeChild(bill.lastChild)
					}


					var GRAND_TOTAL = 0

					for(let item_name of items){
						var record_container = document.createElement("div")
						record_container.className = "record_container"

						var key = document.createElement("span")
						var value = document.createElement("span")
						var pip = document.createElement("span")
						var subTotal = document.createElement("span")

						key.className = "item_name"
						value.className = "quantity"
						pip.className = "pip"
						subTotal.className = "sub_total"

						record_container.appendChild(key)
						record_container.appendChild(value)
						record_container.appendChild(pip)
						record_container.appendChild(subTotal)

						key.textContent = item_name
						value.textContent = cart[item_name].quantity	
						pip.textContent = cart[item_name].price
						subTotal.textContent = cart[item_name].quantity	* cart[item_name].price

						GRAND_TOTAL += cart[item_name].quantity	* cart[item_name].price

						bill.appendChild(record_container)
					}


					document.getElementById("real_grand_total").innerText = GRAND_TOTAL
				})
			})
		}
	</script>
</body>
</html>

