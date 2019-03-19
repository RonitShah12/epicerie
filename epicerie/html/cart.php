<?php
	session_set_cookie_params(3600*24*30,"/");
	session_start();

	$write_into_file = true;

	//item price updation 
	if(file_exists("priceStore.txt")){
		$conn = mysqli_connect("localhost:3306", "root", "", "epicerie");
		$res = $conn->query("select UNIX_TIMESTAMP(catalog_table_last_change) from catalog_table_updates");

		$row = $res->fetch_assoc();

		if(filemtime("priceStore.txt") > $row["UNIX_TIMESTAMP(catalog_table_last_change)"]){
			$write_into_file = false;
		}

		$conn->close();
	}

	if($write_into_file)
	{
		$file = fopen("priceStore.txt", "w");

		$conn = mysqli_connect("localhost:3306", "root", "", "epicerie");
		$res = $conn->query("select item, price from catalog");

		while($row = $res->fetch_assoc()){
			fwrite($file, $row["item"].":".$row["price"]."\r\n");
		}

		fclose($file);
		$conn->close();
	}
	// till here


	//read priceStore contents and make an associative array
	$file = fopen("priceStore.txt", "r");
	$filesize = filesize( "priceStore.txt" );
	$filetext = fread( $file, $filesize );
	fclose( $file );

	//parse the filetext and make an associative array
	$itemPriceMap = array(); 

	$startIndex = 0;
	while($startIndex !== strlen($filetext)){	    
		$colonIndex = strpos($filetext,":", $startIndex);
		$recordEndIndex = strpos($filetext,"\r", $startIndex);

		$key = substr($filetext, $startIndex, $colonIndex-$startIndex);
		$value = substr($filetext, $colonIndex+1, $recordEndIndex-$colonIndex-1 );

		$itemPriceMap[$key] = $value;
        $startIndex = strpos($filetext, "\n", $startIndex)+1;
	}

	//till here
	
	if(isset($_GET["item"]))
	{
		if(isset($_SESSION["cart"])){
			$isnew = true;

			$index = 0;
			foreach($_SESSION["cart"] as $element)  {
				if($element->item == $_GET["item"])
				{
					$isnew = false;
					$element->num += (int)$_GET["num"];

					if($element->num <= 0){
						array_splice($_SESSION["cart"], $index, 1);
					}
					break;
				}

				$index++;
			}

			if($isnew){
				array_push( $_SESSION["cart"], cart_element($_GET["item"], $_GET["num"]));
			}

		}else{
			$_SESSION["cart"] = array(cart_element($_GET["item"], $_GET["num"]));
		}
	}


	$obj = "{";

	foreach($_SESSION["cart"] as $element)  {
		$obj = $obj.( "\"".($element->item)."\"" .":"."{".
															"\"quantity\":".($element->num) .",".
															"\"price\":".( $itemPriceMap[$element->item] ).
														"}".",");		
	}
	$obj = substr($obj, 0, strlen($obj) - 1);
	$obj = $obj."}";

	echo $obj;

	function cart_element($item, $num){
		$obj = new stdClass();

		$obj->item = $item;
		$obj->num = $num;

		return $obj;
	}
?>
