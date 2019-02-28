<?php
	session_start();
	if(isset($_GET["item"]))
	{
		if(isset($_SESSION["cart"])){			
			$isnew = true;

			foreach($_SESSION["cart"] as $element)  {
				if($element->item == $_GET["item"])
				{
					$isnew = false;
					$element->num+=(int)$_GET["num"]; 
					break;
				}
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
		$obj = $obj.( "\"".($element->item)."\"" .":". ($element->num) .",");
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
