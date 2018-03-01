<?php
function getEquipmentType($equipmentTypeID){
	$result = mysql_query("SELECT * FROM tb_equipmenttype WHERE equipmentTypeID = ".$equipmentTypeID);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['equipmentTypeID'] 				
	// 1 - $row['equipmentType'] 				
	
	return $row['equipmentTypeID']."?".$row['equipmentType'];
}

function getCategory($catID){
	$result = mysql_query("SELECT * FROM tb_category WHERE category_id = ".$catID);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['category_id']
	// 1 - $row['category_name']

	return $row['category_id']."?".$row['category_name'];
}

function getUnit($unitID){
	$result = mysql_query("SELECT * FROM tb_unit WHERE unit_id = ".$unitID);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['unit_id']
	// 1 - $row['unit_name']

	return $row['unit_id']."?".$row['unit_name'];
}
?>