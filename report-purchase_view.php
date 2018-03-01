<?php
include_once("include/connect.php");
include_once("function/user.php");
include_once("function/report.php");

// if not login
if(!isset($_SESSION['userspsv2.2'])){
    header("location:login.php");
}
else{
    $userinfo = explode("-", getUser($_SESSION['userspsv2.2']));
}

// GET date1 & date2
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$strdate1 = getBreakDate($date1);
$strdate2 = getBreakDate($date2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SPS Ormoc EMS | Purchase Inventory Report</title>
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
                        <h1 class="page-header">Purchase Inventory Report</h1>
                        <div class="panel-body">
                            <a href="report-purchase.php" type="button" class="btn btn-primary">Back</a>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo "From ".$strdate1." To ".$strdate2; ?></label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" align="right">
                                <a href="report-purchase_pdf.php<?php echo "?date1=".$date1."&date2=".$date2."&user=".$userinfo[0]; ?>" target="_blank" class="btn btn-success"><i class="fa fa-file-pdf-o fa-fw"></i> Print PDF</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <td>Date</td>
                                        <td>Item Code</td>
                                        <td>Item Name</td>
                                        <td>Quantity</td>
                                        <td>Purchase Cost</td>
                                        <td>Supplier</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
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


                                    $result = mysql_query($query);
                                    while($row = mysql_fetch_array($result)){
                                        $stockInfo = explode("?",getStockIn($row['stockIn_id']));
                                        echo "
                                        <tr class='gradeX'>
                                        <td>".getBreakDate($stockInfo[4])."</td>
                                        <td>".$stockInfo[7]."</td>
                                        <td>".$stockInfo[8]."</td>
                                        <td>".$stockInfo[3]."</td>
                                        <td>".$stockInfo[5]."</td>
                                        <td>".$stockInfo[9]."</td>
                                        </tr>
                                        ";
                                    }
                                    ?>
                                </tbody>
                            </table>
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

    <!-- advance tables start -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
    <!-- advance tables end -->
</body>
</html>
