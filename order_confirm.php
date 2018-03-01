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

// if click confirm
if(isset($_GET['confirm'])){
    // get invoice
    $row = mysql_fetch_array(mysql_query("SELECT * FROM tb_invoice"));
    $invoice = $row['invoice'];
    // get today
    $date = explode("?",getToday());
    $date0 = $date[0];
    $date = $date[1];
    // get userID
    $userID = $_SESSION['userspsv2.2'];
    // get customer name
    $customer = $_GET['customer'];
    // get total amount
    $total = $_GET['total'];

    // save to database
    // update the tb_sales: put the invoice #, customerID, date & userID  
    mysql_query("UPDATE tb_sales SET invoice = ".$invoice.", date = '".$date."', user_id =".$userID." WHERE invoice = 0");

    // insert to tb_payment: invoice #, customerID, total amount, date & userID
    mysql_query("INSERT INTO tb_payment (`invoice`, `customer`, `total_amount`, `date`, `user_id`) VALUES(".$invoice.",'".$customer."',".$total.",'".$date."',".$userID.")");

    // update the tb_invoice: increment the invoice value
    $invoice++;
    mysql_query("UPDATE tb_invoice SET invoice = ".$invoice);
    $invoice--;

    // header("location:order_complete.php?customer=".$customer."&total=".$total."&date=".$date0."&userID=".$userID."&invoice=".$invoice);
    header("location:order_complete.php?invoice=".$invoice);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SPS Ormoc EMS | Confirm Order</title>
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
                        <h1 class="page-header">Confirm Order</h1>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="alert alert-info alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Please confirm first the following informations.
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="order.php" type="button" class="btn btn-primary">Back</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input class="form-control" value="<?php echo $_GET['customer']; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label>List of Item(s)</label>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">Item Code</th>
                                                <th style="text-align:center;">Item Name</th>
                                                <th style="text-align:center;">Price</th>
                                                <th style="text-align:center;">Quantity Order</th>
                                                <th width='125px' style="text-align:center;">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = mysql_query("SELECT * FROM tb_sales WHERE invoice = 0");
                                            $row = mysql_num_rows($result);
                                            if($row > 0){
                                                $total = 0;
                                                while($row = mysql_fetch_array($result)){
                                                    $salesInfo = explode("?", getSale($row['sale_id']));
                                                    echo "
                                                    <tr id='body-table-data'>
                                                    <td>".$salesInfo[6]."</td>
                                                    <td>".$salesInfo[7]."</td>
                                                    <td align='right'>".$salesInfo[8]."</td>
                                                    <td align='center'>".$salesInfo[3]." ".$salesInfo[9]."(s)</td>
                                                    <td align='center'>".($salesInfo[8]*$salesInfo[3])."</td>
                                                    ";
                                                    $total = $total + ($salesInfo[8] * $salesInfo[3]);
                                                }
                                                echo "
                                                <tr id='body-table-data'>
                                                <td style='border:none;' align='right' colspan='4'><b>Total Amount</b></td>
                                                <td style='border:none;' align='center'>".$total."</td>
                                                </tr>
                                                ";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group" style="text-align:right;">
                                    <a href="<?php echo "?customer=".$_GET['customer']."&total=".$total."&confirm=Yes"; ?>" type="button" class="btn btn-primary">Confirm</a>
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
