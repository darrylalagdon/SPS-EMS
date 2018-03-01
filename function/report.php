<?php
function getStockIn($stockID){
	$query = "
		SELECT
			tb_stockin.stockIn_id as 'stockID',
			tb_stockin.item_id as 'itemID',
			tb_stockin.supplier_id as supplierID,
			tb_stockin.quantity as 'quantity',
			tb_stockin.purchase_date as 'purdate',
			tb_stockin.purchase_cost as 'purcost',
			tb_stockin.user_id as 'userID',
			tb_item.item_code as 'itemcode',
			tb_item.item_name as 'itemname',
			tb_supplier.supplier_name as 'suppliername'
		FROM tb_stockin
		INNER JOIN tb_item
		ON tb_stockin.item_id = tb_item.item_id
		INNER JOIN tb_supplier
		ON tb_stockin.supplier_id = tb_supplier.supplier_id
	";
	$result = mysql_query($query." WHERE stockIn_id=".$stockID);
	$row = mysql_fetch_array($result);

	// array values
	// 0 - $row['stockID']			stockIn_id
	// 1 - $row['itemID']			item_id
	// 2 - $row['supplierID']		supplier_id
	// 3 - $row['quantity']			quantity
	// 4 - $row['purdate']			purchase_date
	// 5 - $row['purcost']			purchase_cost
	// 6 - $row['userID']			user_id
	// 7 - $row['itemcode']			itemcode
	// 8 - $row['itemname']			itemname
	// 9 - $row['suppliername']		supplier_name

	return $row['stockID']."?".$row['itemID']."?".$row['supplierID']."?".$row['quantity']."?".$row['purdate']."?".$row['purcost']."?".$row['userID']."?".$row['itemcode']."?".$row['itemname']."?".$row['suppliername'];
}

function getSale($sale_ID){
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
			tb_unit.unit_name as 'unit',
			tb_payment.customer as 'customer'
		FROM tb_sales
		INNER JOIN tb_item
		ON tb_sales.item_id = tb_item.item_id
		INNER JOIN tb_unit
		ON tb_item.unit_id = tb_unit.unit_id
		INNER JOIN tb_payment
		ON tb_sales.invoice = tb_payment.invoice
	";
	$result = mysql_query($query." WHERE sale_id=".$sale_ID);
	$row = mysql_fetch_array($result);

	// array values
	// 0 - $row['saleID']		sale_id
	// 1 - $row['invoice']		invoice
	// 2 - $row['itemID']		item_id
	// 3 - $row['quantity']		quantity
	// 4 - $row['date']			date
	// 5 - $row['userID']		user_id
	// 6 - $row['itemcode']		item_code
	// 7 - $row['itemname']		item_name
	// 8 - $row['price']		sale_price
	// 9 - $row['unit']			unit_name
	// 10 - $row['customer']	customer

	return $row['saleID']."?".$row['invoice']."?".$row['itemID']."?".$row['quantity']."?".$row['date']."?".$row['userID']."?".$row['itemcode']."?".$row['itemname']."?".$row['price']."?".$row['unit']."?".$row['customer'];
}
?>