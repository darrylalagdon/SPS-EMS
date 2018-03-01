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

$search = null;

// if click add to cart
if(isset($_GET['addcart'])){
    $itemid = $_GET['itemID'];
    $stock = $_GET['stock'];
    $quantity = $_GET['quantity'];
    $newstock = $stock - $quantity;

    // if zero ang stock
    if($stock==0){
        $msg = "The available stock is equal to zero.";
        header("location:order.php?error=".$msg);
    }
        // lapas na sa stock ang quantity order
    elseif($quantity > $stock){
        $msg = "The quantity ordered is greater than the available stock.";
        header("location:order.php?error=".$msg);
    }
    else{
        // pag deduct sa quantity sa item
        mysql_query("UPDATE tb_item SET available_stock = ".$newstock." WHERE item_id = ".$itemid);

        // pag add sa cart
        $result = mysql_query("SELECT * FROM tb_sales WHERE item_id = ".$itemid." AND invoice = 0");
        $row = mysql_num_rows($result);
        echo $row."<br>";
        // check if item is already added
        if($row > 0){
            $row = mysql_fetch_array($result);
            $quantity = $quantity + $row['quantity'];
            mysql_query("UPDATE tb_sales SET quantity = ".$quantity." WHERE sale_id = ".$row['sale_id']);
        }
        // if item is not yet added
        else{
            mysql_query("INSERT INTO tb_sales (item_id, quantity) VALUES(".$itemid.", ".$quantity.")");
        }   

        header("location:order.php");
    }
}

// if click remove
if(isset($_GET['remove'])){
    $saleID = $_GET['saleID'];
    $itemID = $_GET['itemID'];
    $quantity = $_GET['quantity'];

    // remove from tb_sales
    mysql_query("DELETE FROM tb_sales WHERE sale_id = ".$saleID);

    // add quantity to tb_item
    $itemInfo = explode("?", getItem($itemID));
    $quantity = $itemInfo['5']+$quantity;
    mysql_query("UPDATE tb_item SET available_stock = ".$quantity." WHERE item_id = ".$itemID);

    header("location:order.php");   
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
    <title>SPS Ormoc EMS | Order</title>
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
                        <h1 class="page-header">Order</h1><?php
                        // if stockin success
                        if(isset($_GET['error'])){
                            echo '
                            <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            '.$_GET['error'].'
                            </div>
                            ';
                        }
                        ?>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <form>
                                        <label>Enter Item Code/Name: </label>
                                        <input placeholder="Item Code/Name" name="search" value="<?php echo $search; ?>" required>
                                        <input type="submit" class="btn btn-primary btn-sm" name="submit" value="Search" required>
                                        <a href="order.php" class="btn btn-primary btn-sm">Clear</a>
                                    </form>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Item Code</th>
                                                    <th style="text-align:center;">Item Name</th>
                                                    <th style="text-align:center;">Price</th>
                                                    <th style="text-align:center;">Stock</th>
                                                    <th width='125px' style="text-align:center;">Quantity Order</th>
                                                    <th width='110px'></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(!isset($_GET['submit'])){
                                                    echo "
                                                    <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td align='right'></td>
                                                    <td align='center'></td>
                                                    <td align='center'><input type='text' style='width:100px;' readonly></td>
                                                    <td align='center'><button class='btn btn-success btn-sm' style='width:100%;'>Add to cart</button></td>
                                                    </tr>
                                                    ";
                                                }
                                                else{
                                                    $search = $_GET['search'];
                                                    $result = mysql_query("SELECT * FROM tb_item WHERE item_code LIKE '%".$search."%' OR item_name LIKE '%".$search."%'");
                                                    $i = mysql_num_rows($result);
                                                    if($i > 0){
                                                        while($row = mysql_fetch_array($result)){
                                                            $iteminfo = explode("?",getItem($row['item_id']));
                                                            echo "
                                                            <form>
                                                            <input type='hidden' name='itemID' value='".$iteminfo[0]."'>
                                                            <input type='hidden' name='stock' value='".$iteminfo[5]."'>
                                                            <tr>
                                                            <td>".$iteminfo[1]."</td>
                                                            <td>".$iteminfo[2]."</td>
                                                            <td align='right'>".$iteminfo[3]."</td>
                                                            <td align='center'>".$iteminfo[5]." ".$iteminfo[9]."(s)</td>
                                                            <td align='center'><input type='text' name='quantity' style='width:100px; text-align:right;' required></td>
                                                            <td><input type='submit' class='btn btn-success btn-sm' style='width:100%;' name='addcart' value='Add to cart'></td>
                                                            </tr>
                                                            </form>
                                                            ";
                                                        }
                                                    }
                                                    else{
                                                        echo "
                                                        <tr>
                                                        <td colspan='6' align='center'>No Item Found</td>
                                                        </tr>
                                                        ";
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label>Cart </label>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;">Item Code</th>
                                                    <th style="text-align:center;">Item Name</th>
                                                    <th style="text-align:center;">Price</th>
                                                    <th style="text-align:center;">Quantity Order</th>
                                                    <th width='125px' style="text-align:center;">Sub Total</th>
                                                    <th width='110px'></th>
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
                                                        <td>
                                                        <a class='btn btn-danger btn-sm' style='width:100%;' href='?saleID=".$salesInfo[0]."&itemID=".$salesInfo[2]."&quantity=".$salesInfo[3]."&remove=Remove'>Remove</a>
                                                        </tr>
                                                        ";
                                                        $total = $total + ($salesInfo[8] * $salesInfo[3]);
                                                    }
                                                    echo "
                                                    <tr id='body-table-data'>
                                                    <td style='border:none;' align='right' colspan='4'><b>Total Amount</b></td>
                                                    <td style='border:none;' align='center'>".$total."</td>
                                                    <td style='border:none;'>
                                                    <button data-toggle='modal' data-target='#checkoutModal' class='btn btn-primary btn-sm' style='width:100%;'>Check Out</button>
                                                    </td>
                                                    </tr>
                                                    ";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- <a href="item_add.php" class="btn btn-primary">Add New Item</a> -->
                        </div>

                        <!-- ************************************** -->
                        <!-- Customer Modal -->
                        <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="order_confirm.php">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Order</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Customer Name</label>
                                                <input class="form-control" placeholder="Customer Name" value="" name="customer" autofocus required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                            <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </form>
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
</body>
</html>
