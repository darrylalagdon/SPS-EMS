<?php
include_once("include/connect.php");
include_once("function/user.php");
include_once("function/report.php");
require("add-on/fpdf/fpdf.php");

function cformat($date){
	$date=explode("/",$date);
	return $date[2]."/".$date[0]."/".$date[1];
}

// GET values
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];

// create PDF
$pdf = new FPDF('P','mm','Letter');

// create page
$pdf->Addpage();

// *************************************************
// PDF Header start

// Insert a logo in the top-left corner at 300 dpi
$pdf->SetFont('Times','b',11);
$pdf->Image('image/spslogo_blk.png',97,15,25,0,'PNG');

// break
$pdf->Cell(195,33,"",0,1);

$pdf->SetFont('Times','b',11);
$pdf->Cell(195,5,'SAINT PAUL\'S SCHOOL OF ORMOC FOUNDATION INC.',0,1,"C");
$pdf->SetFont('Times','',11);
$pdf->Cell(195,5,'Ormoc City, Philippines',0,1,"C");

// break
$pdf->Cell(190,5,"",0,1);

$pdf->SetFont('Times','i',11);
$pdf->Cell(195,5,'PURCHASE INVENTORY REPORT',0,1,"C");
$pdf->SetFont('Times','',11);
$pdf->Cell(195,5,'From '.getBreakDate($_GET['date1']).' To '.getBreakDate($_GET['date2']),0,1,"C");

// PDF Header end
// *************************************************

// *************************************************
// Table start

// break
$pdf->Cell(190,5,"",0,1);

// for table header
$pdf->SetFont('Times','b',11);
$pdf->Cell(37,6,'Date',1,0,"C");
$pdf->Cell(20,6,'Item Code',1,0,"C");
$pdf->Cell(38,6,'Item Name',1,0,"C");
$pdf->Cell(25,6,'Quantity',1,0,"C");
$pdf->Cell(30,6,'Purchase Cost',1,0,"C");
$pdf->Cell(45,6,'Supplier',1,1,"C");

// ******************************

$query = "
SELECT
	`tb_stockin`.`stockIn_id`,
	`tb_item`.`item_name`,
	`tb_item`.`item_code`,
	`tb_supplier`.`supplier_name`
FROM
	`tb_stockin`
INNER JOIN
	`tb_item`
ON
	`tb_stockIn`.`item_id` = `tb_item`.`item_id`
INNER JOIN
	`tb_supplier`
ON
	`tb_stockIn`.`supplier_id` = `tb_supplier`.`supplier_id`
WHERE
	purchase_date BETWEEN '".$date1."' AND '".$date2."'
";

$result = mysql_query($query." ORDER BY stockIn_id ASC");
$count = mysql_num_rows($result);
$amount = 0;
while($row = mysql_fetch_array($result)){
	$stockInfo = explode("?", getStockIn($row['stockIn_id']));
	$pdf->SetFont('Times','',11);
	$pdf->Cell(37,6,getBreakDate($stockInfo[4]),1,0,"C");
	$pdf->Cell(20,6,$stockInfo[7],1,0,"C");
	$pdf->Cell(38,6,$stockInfo[8],1,0,"C");
	$pdf->Cell(25,6,$stockInfo[3],1,0,"C");
	$pdf->Cell(30,6,$stockInfo[5],1,0,"C");
	$pdf->Cell(45,6,$stockInfo[9],1,1,"C");
	$amount = $amount+$stockInfo[5];
}

// break
$pdf->Cell(190,5,"",0,1);

$pdf->SetFont('Times','',11);
$pdf->Cell(50,6,'Number of Purchase: '.$count,0,0,"L");
$pdf->Cell(50,6,'Total Amount: '.$amount,0,0,"L");

// break
$pdf->Cell(190,5,"",0,1);
$pdf->Cell(190,5,"",0,1);

$userinfo = explode("-", getUser($_SESSION['userspsv2.2']));

$pdf->Cell(195,5,'Prepared By',0,1,"R");
$pdf->Cell(190,8,"",0,1);
$pdf->SetFont('Times','b',11);
$pdf->Cell(195,5,$userinfo[1],0,1,"R");

// view Output
$pdf->Output();

?>
