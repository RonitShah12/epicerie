<html>
 	<body>
 		<?php
 			session_start();
 			$uname=$_GET["self_username"];
 			
 			$conn = new mysqli("localhost:3306", "root", "", "epicerie");
 			$sql = "SELECT * FROM login WHERE BINARY username='$uname'";
 			$result = $conn->query($sql);    
			if(!$result ){
   				echo mysqli_error($conn);
   			}
   			
   			$row = $result->fetch_assoc();
   			if( $SESSION["credit_avail"] + $SESSION["credit_limit"] - $SESSION["grandtotal"] > 0){
   				$final_credit_avail = $SESSION["credit_avail"] - $SESSION["grandtotal"];
   				$final_credit_limit = $SESSION["credit_limit"];

   				if($final_credit_avail < 0){
   					$final_credit_limit -= $final_credit_avail;
   				}

   				if($final_credit_limit < 0){
   					die("Not enough credits");
   				}

   				$SESSION["credit_avail"] = $final_credit_avail;
				$SESSION["credit_limit"] = $final_credit_limit;

				$conn->query("UPDATE login 
								SET credit=$final_credit_avail, credit_limit=$final_credit_limit
								WHERE username='$uname'");
   			}


 		?>
 	</body>
 </html>
