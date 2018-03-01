<?php
function getSale($sale_id){
	$query = "
		SELECT
			tb_sales.sale_id as 'saleID',
			tb_sales.invoice as 'invoice',
			tb_sales.item_id as 'itemID',
			tb_sales.quantity as 'quantity',
			tb_sales.date as 'date',
			tb_sales.user_id as 'userID',
			tb_item.item_code as 'itemcode',
			tb_item.item_name as 'itemname',
			tb_item.sale_price as 'price',
			tb_unit.unit_name as 'unit'
		FROM
			tb_sales
		INNER JOIN tb_item ON tb_sales.item_id = tb_item.item_id
		INNER JOIN tb_unit ON tb_item.unit_id = tb_unit.unit_id
	";
	$result = mysql_query($query." WHERE sale_id = ".$sale_id);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['saleID'];
	// 1 - $row['invoice'];
	// 2 - $row['itemID'];
	// 3 - $row['quantity'];
	// 4 - $row['date'];
	// 5 - $row['userID'];
	// 6 - $row['itemcode'];
	// 7 - $row['itemname'];
	// 8 - $row['price'];
	// 9  - $row['unit'];

	return $row['saleID']."?".$row['invoice']."?".$row['itemID']."?".$row['quantity']."?".$row['date']."?".$row['userID']."?".$row['itemcode']."?".$row['itemname']."?".$row['price']."?".$row['unit'];
}
function getItem($itemID){
	$query = "
		SELECT
			tb_item.item_id as 'itemID',
			tb_item.item_code as 'itemCode',
			tb_item.item_name as 'itemName',
			tb_item.sale_price as 'salePrice',
			tb_item.category_id as 'categoryID',
			tb_item.available_stock as 'availableStock',
			tb_item.unit_id as 'unitID',
			tb_item.reorder_lvl as 'reorderLvl',
			tb_category.category_name as 'categoryName',
			tb_unit.unit_name as 'unitName'
		FROM tb_item
		INNER JOIN tb_category ON tb_item.category_id = tb_category.category_id
		INNER JOIN tb_unit ON tb_item.unit_id = tb_unit.unit_id
	";
	$result = mysql_query($query." WHERE item_id = ".$itemID);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['itemID'];
	// 1 - $row['itemCode'];
	// 2 - $row['itemName'];
	// 3 - $row['salePrice'];
	// 4 - $row['categoryID'];
	// 5 - $row['availableStock'];
	// 6 - $row['unitID'];
	// 7 - $row['reorderLvl'];
	// 8 - $row['categoryName'];
	// 9 - $row['unitName'];

	return $row['itemID']."?".$row['itemCode']."?".$row['itemName']."?".$row['salePrice']."?".$row['categoryID']."?".$row['availableStock']."?".$row['unitID']."?".$row['reorderLvl']."?".$row['categoryName']."?".$row['unitName'];

}
function getCustomer($customerid){
	$result = mysql_query("SELECT * FROM tb_customer WHERE customer_id = ".$customerid);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['customer_id']
	// 1 - $row['customer_name']
	// 2 - $row['customer_contact']

	return $row['customer_id']."?".$row['customer_name']."?".$row['customer_contact'];
}

function getSupplier($supplierid){
	$result = mysql_query("SELECT * FROM tb_supplier WHERE supplier_id = ".$supplierid);
	$row = mysql_fetch_array($result);

	// array order
	// 0 - $row['supplier_id']
	// 1 - $row['supplier_name']
	// 2 - $row['supplier_contact']
	// 3 - $row['company_name']

	return $row['supplier_id']."?".$row['supplier_name']."?".$row['supplier_contact']."?".$row['company_name'];
}
function getInfoByInvoice($invoice){
	$result = mysql_query("SELECT * FROM tb_payment WHERE invoice = ".$invoice);
	$row = mysql_fetch_array($result);

	// 0 - $row['payment_id']
	// 1 - $row['invoice']
	// 2 - $row['customer']
	// 3 - $row['total_amount']
	// 4 - $row['date']
	// 5 - $row['user_id']

	return $row['payment_id']."?".$row['invoice']."?".$row['customer']."?".$row['total_amount']."?".$row['date']."?".$row['user_id'];
}
?>