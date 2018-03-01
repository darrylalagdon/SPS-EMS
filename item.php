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

// if click Yes from Confirm StockIn Modal
if(isset($_GET['stockin']) && $_GET['stockin']=="Yes"){
    $itemID = $_GET['itemID'];
    $purdate = $_GET['purdate'];
    $purcost = $_GET['purcost'];
    $quantity = $_GET['quantity'];
    $nquantity = $_GET['nquantity'];
    $supplier = $_GET['supplier'];

    // insert into tb_item
    mysql_query("INSERT INTO tb_stockin (item_id, supplier_id, quantity, purchase_date, purchase_cost, user_id) VALUES(".$itemID.", ".$supplier.", ".$quantity.", '".$purdate."', ".$purcost.", ".$userinfo[0].")");
    // update the quantity
    mysql_query("UPDATE tb_item SET available_stock = ".$nquantity." WHERE item_id = ".$itemID);

    header("location:item.php?stockin=Success");
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
    <title>SPS Ormoc EMS | Item List</title>
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
                        <h1 class="page-header">Item List</h1>
                        <?php
                        // if stockin success
                        if(isset($_GET['stockin']) && $_GET['stockin']=="Success"){
                            echo '
                            <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            New stock successfully added.
                            </div>
                            ';
                        }
                        ?>
                        <?php
                        if($userlvl!=4){
                        ?>
                        <div class="panel-body">
                            <a href="item_add.php" type="button" class="btn btn-primary">Add New Item</a>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <!-- <td style='width:10px;'></td> -->
                                        <td>Item Code</td>
                                        <td>Item Name</td>
                                        <td>Sale Price</td>
                                        <td>Category</td>
                                        <td>Stock</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysql_query("SELECT * FROM tb_item");
                                    while($row = mysql_fetch_array($result)){
                                        $iteminfo = explode("?",getItem($row['item_id']));

                                        // check tb_sale for additional items
                                        $Cresult = mysql_query("SELECT * FROM tb_sales WHERE invoice = 0 AND item_id = ".$iteminfo[0]);
                                        $Crow = mysql_num_rows($Cresult);
                                        if($Crow>0){
                                            $Crow = mysql_fetch_array($Cresult);
                                            $stock = $iteminfo[5]+$Crow["quantity"];
                                        }
                                        else{
                                            $stock = $iteminfo[5];  
                                        }

                                        echo "
                                        <tr class='gradeX'>
                                        <td style='width:10px;' align='center'>
                                        ";
                                        if($stock==0){
                                            echo "<div style='width:10px;height:10px;border-radius:50%;margin-top:45%;background:#d9534f;'></div>";
                                        }
                                        elseif($iteminfo[7]>=$stock){
                                            echo "<div style='width:10px;height:10px;border-radius:50%;margin-top:45%;background:#f0ad4e;'></div>";
                                        }
                                        echo "
                                        <td>".$iteminfo[1]."</td>
                                        <td>".$iteminfo[2]."</td>
                                        <td>".$iteminfo[3]."</td>
                                        <td>".$iteminfo[8]."</td>
                                        <td>".$stock." ".$iteminfo[9]."(s)</td>
                                        <td style='width:12%;'>
                                        <a href='item_view.php?itemID=".$iteminfo[0]."' style='cursor:pointer;'>View</a>";

                                        if($userlvl!=4){
                                            echo "
                                            |
                                            <a data-toggle='modal' data-target='#stockinModal".$iteminfo[0]."' style='cursor:pointer;'>Stock In</a>
                                            </td>
                                            </tr>
                                            ";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ***************************** -->

                        <?php
                        $result = mysql_query("SELECT * FROM tb_item");
                        while($row = mysql_fetch_array($result)){
                            $iteminfo = explode("?",getItem($row['item_id']));

                            // get Date here
                            $dateInfo = explode("?",getToday());

                            // check tb_sale for additional items
                            $Cresult = mysql_query("SELECT * FROM tb_sales WHERE invoice = 0 AND item_id = ".$iteminfo[0]);
                            $Crow = mysql_num_rows($Cresult);
                            if($Crow>0){
                                $Crow = mysql_fetch_array($Cresult);
                                $stock = $iteminfo[5]+$Crow["quantity"];
                            }
                            else{
                                $stock = $iteminfo[5];  
                            }

                            echo '
                            <!-- StockIn Modal -->
                            <div class="modal fade" id="stockinModal'.$iteminfo[0].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form>
                                            <input type="hidden" name="itemID" value="'.$iteminfo[0].'">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Stock In</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Item Code</label>
                                                    <input class="form-control" value="'.$iteminfo[1].'" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Item Name</label>
                                                    <input class="form-control" value="'.$iteminfo[2].'" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Current Quantity</label>
                                                    <input class="form-control" value="'.$stock." ".$iteminfo[9].'(s)" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Purchase Date</label>
                                                    <input class="form-control" value="'.$dateInfo[0].'" readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label>Purchase Cost</label>
                                                    <input class="form-control" value="" name="purcost" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity</label>
                                                    <input class="form-control" value="" name="aquantity" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Supplier</label>
                                                    <select class="form-control" name="supplier">
                                ';
                                // *****************************************************************
                                $supresult = mysql_query("SELECT * FROM tb_supplier oRDER BY company_name ASC");
                                while($suprow = mysql_fetch_array($supresult)){
                                    $supinfo = explode("?",getSupplier($suprow['supplier_id']));
                                    echo "<option value='".$supinfo[0]."'>".$supinfo[3]." - ".$supinfo[1]."</option>";
                                }
                                // *****************************************************************
                                echo '
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Stock In">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                        ?>
                        <!-- ************************************** -->
                        <!-- StockIn Confirm Modal -->
                        <?php
                        // GET values from stockinModal
                        if(isset($_GET['submit'])){
                            $itemID = $_GET['itemID'];
                            $purcost = $_GET['purcost'];
                            $aquantity = $_GET['aquantity'];
                            $supplier = $_GET['supplier'];

                            // get ItemInfo
                            $itemInfo = explode("?", getItem($_GET['itemID']));
                            $itemID = $itemInfo[0];
                            $itemCode = $itemInfo[1];
                            $itemName = $itemInfo[2];
                            $itemQuantity = $itemInfo[5];
                            $itemUnit = $itemInfo[9];

                            // get Date here
                            $dateInfo = explode("?",getToday());

                            // get supplier name
                            $supplierInfo = explode("?",getSupplier($supplier));

                            $link = "?itemID=".$itemID."&purdate=".$dateInfo[1]."&purcost=".$purcost."&quantity=".$aquantity."&nquantity=".($itemQuantity+$aquantity)."&supplier=".$supplier."&stockin=Yes";
                        }
                        ?>
                        <div class="modal fade" id="stockinSuccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Confirm Stock In</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="alert alert-info">
                                                Please confirm the following informations. Click "Yes" to stock in, click "No" to cancel.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Item Code: <?php echo $itemCode; ?></label><br>
                                            <label>Item Name: <?php echo $itemName; ?></label><br>
                                            <label>Current Quantity: <?php echo $itemQuantity." ".$itemUnit."(s)"; ?></label><br>
                                            <hr>
                                            <label>Purchase Date: <?php echo $dateInfo[0]; ?></label><br>
                                            <label>Purchase Cost: <?php echo $purcost; ?></label><br>
                                            <label>Quantity Order: <?php echo $aquantity; ?></label><br>
                                            <label>Supplier: <?php echo $supplierInfo[1]." - ".$supplierInfo[3]; ?></label><br>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="item.php<?php echo $link; ?>" class="btn btn-primary">Yes</a>
                                        <a href="item.php" class="btn btn-default">No</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ***************************** -->
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

    <?php
    // if click Stock In from stockinModal
    if(isset($_GET['submit'])){
        echo "
        <script>
        $('#stockinSuccessModal').modal('show');
        </script>
        ";
    }
    ?>
</body>
</html>
