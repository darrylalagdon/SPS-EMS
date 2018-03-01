<?php
include_once("include/connect.php");
include_once("function/user.php");
include_once("function/sale.php");

// if not login
if(!isset($_SESSION['userspsv2.2'])){
    header("location:login.php");
}
else{
    $userinfo = explode("-", getUser($_SESSION['userspsv2.2']));
}

// get invoice value
$invoice = $_GET['invoice'];
$iteminvoice = explode("?",getInfoByInvoice($invoice));

$customer = $iteminvoice[2];
$date = $iteminvoice[4];
$invoice = $iteminvoice[1];
$total = $iteminvoice[3];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SPS Ormoc EMS | Order Complete</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php
            include_once("include/header.html");
            include_once("include/navigation.html");
            ?>
        </nav>
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Order Complete</h1>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="alert alert-info alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Successfully processed.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Customer Name: <?php echo $customer; ?></label><br>
                                    <label>Purchase Date: <?php echo $date; ?></label><br>
                                    <label>Invoice No.: <?php echo $invoice; ?></label><br>
                                    <label>Item Ordered:</label><br>
                                    <table border="0" style="padding-left:15px; font-size:11pt;">
                                        <?php
                                        $result = mysql_query("SELECT * FROM tb_sales WHERE invoice = ".$_GET['invoice']);
                                        while($row = mysql_fetch_array($result)){
                                            $itemID = $row['item_id'];
                                            $quantity = $row['quantity'];
                                            $itemInfo = explode("?",getItem($itemID));
                                            echo "
                                            <tr><td>".$itemInfo[1]." - ".$itemInfo[2]."</td></tr>
                                            <tr><td align='right'>".$quantity."x".$itemInfo[3]." = ".($quantity*$itemInfo[3])."</td></tr>
                                            ";
                                        }
                                        ?>
                                    </table>
                                    <label>Total Amount: <?php echo $total; ?></label><br>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="order_print.php?invoice=<?php echo $invoice; ?>" target="_blank" type="button" class="btn btn-success">Print Reciept</a>
                                    <a href="order.php" type="button" class="btn btn-primary">Done</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/metisMenu/metisMenu.min.js"></script>
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script>
    <script src="dist/js/sb-admin-2.js"></script>
</body>
</html>
