<?
	
	$timestamp = "2021-11-17 03:07:24";
	
	 
	
	
	echo date("d-m-Y", strtotime($timestamp));
	
	
	echo "<BR>";
	$month = intval(date("m", strtotime($timestamp)));
	$yearQuarter = ceil($month / 6);
	
	echo $month ;