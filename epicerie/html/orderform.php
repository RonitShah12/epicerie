<html>
	<body>
		Hi, 
		<?php
			session_start();

			echo $SESSION["username"];
		?>

		<form name="myform" method="Post" action="placeorder.php">
			<label>EMAIL:</label>
			<input type="text" name="target_email" required>			
			<label>ADDRESS:</label>
			<textarea name="target_address" form="myform" required>			
			</textarea>
            <label>PHONE NUMBER:</label>
			<input type="text" name="target_phone_number" required>
			<label>NAME:</label>
			<input type="text" name="target_username" required>
			<input type="hidden" value="<?php echo $SESSION["username"]; ?>" name="self_username">
			<button type="submit" value="Place Order" >
        </form>
        You have to pay:<?php  echo $SESSION["grandtotal"]; ?> credits
        Available credits:<?php  echo $SESSION["credit_avail"]; ?> credits
        Credit Limit:<?php  echo $SESSION["credit_limit"]; ?> credits


</body>
</html>