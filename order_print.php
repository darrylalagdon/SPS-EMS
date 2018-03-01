<?php
include_once("include/connect.php");
include_once("function/user.php");
include_once("function/sale.php");
require("add-on/fpdf/fpdf.php");

// get invoice value
$invoice = $_GET['invoice'];
$iteminvoice = explode("?",getInfoByInvoice($invoice));

$customer = $iteminvoice[2];
$date = $iteminvoice[4];
$invoice = $iteminvoice[1];
$total = $iteminvoice[3];

// get user
$userinfo = explode("-", getUser($iteminvoice[5]));
$user = $userinfo[1];

// create PDF
$pdf= new FPDF('P','mm',array(120, 215));

// Create Page
$pdf->AddPage();

// Insert a logo in the top-left corner at 300 dpi
$pdf->Image('image/sps-logo-sm.jpg',51.5,10,18,0,'JPG');

// break
$pdf->Cell(0,20,"",0,1);

$pdf->SetFont('Arial','',10);
$pdf->Cell(0,4,"Saint Paul's School of Ormoc Foundation Inc.",0,1,"C");
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,3,"Apitong St., Ormoc City",0,1,"C");

// break
$pdf->Cell(0,5,"",0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,3,"PUCHASE RECEIPT",0,1,"C");

// break
$pdf->Cell(0,5,"",0,1);

$pdf->SetFont('Arial','I',8);
$pdf->Cell(0,3,"Date Issued: ".$date,0,1,"R");

// break
$pdf->Cell(0,5,"",0,1);

$pdf->SetFont('Arial','',8);
$pdf->Cell(14,5,"Invoice #: ",0,0,"L");
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,$invoice,0,1,"L");
$pdf->SetFont('Arial','',8);
$pdf->Cell(25,5,"Customer's Name: ",0,0,"L");
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,$customer,0,1,"L");

// break
$pdf->Cell(0,5,"",0,1);

$pdf->SetFont('Arial','',8);
$pdf->Cell(0,5,"PURCHASE ITEMS",1,1,"C");

// break
$pdf->Cell(0,1,"",0,1);

$pdf->SetFont('Arial','',8);
$pdf->Cell(10,5,"",0,0,"C");
$pdf->Cell(40,5,"Item Code & Name",0,0,"L");
$pdf->Cell(40,5,"Sub-Total",0,0,"R");
$pdf->Cell(10,5,"",0,1,"C");

$pdf->SetFont('Arial','',10);

$result = mysql_query("SELECT * FROM tb_sales WHERE invoice = ".$invoice);
$total = 0;
while($row = mysql_fetch_array($result)){
	$itemID = $row['item_id'];
	$quantity = $row['quantity'];
	$itemInfo = explode("?",getItem($itemID));

	$pdf->Cell(10,4,"",0,0,"C");
	$pdf->Cell(0,4,$itemInfo[1]." - ".$itemInfo[2],0,1,"L");
	$pdf->Cell(90,4,$quantity." x ".$itemInfo[3]." = ".($quantity*$itemInfo[3]),0,1,"R");
	$total = $total + ($quantity*$itemInfo[3]);
}

$pdf->Cell(0,1,"",0,1);
$pdf->Cell(0,0,"",1,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(90,6,"Total Amount: ".$total,0,1,"R");
// break
$pdf->Cell(0,1,"",0,1);

// break
$pdf->Cell(0,5,"",0,1);


$pdf->SetFont('Arial','',8);
$pdf->Cell(0,4,"Process by",0,1,"R");
$pdf->Cell(0,6,"",0,1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,4,$user,0,1,"R");


// break
$pdf->Cell(0,5,"",0,1);

$pdf->SetFont('Arial','',8);
$pdf->Cell(0,4,"This reciept is only valid with the signature of the person in-charge.",0,1,"C");
$pdf->SetFont('Arial','I',8);
$pdf->Cell(0,4,'"THIS IS RECIEPT IS ISSUED BY THE SAINT PAUL\'S OF ORMOC"',0,1,"C");
$pdf->Cell(0,4,'"FOUNDATION INC."',0,1,"C");

// view Output
$pdf->Output();

?>