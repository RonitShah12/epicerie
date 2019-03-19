<?php
	$file = fopen("priceStore.txt", "r");

	if($file == false){
		echo "not created";
	}else{
	fclose($file);

	echo filemtime("priceStore.txt");
		
	}

?>