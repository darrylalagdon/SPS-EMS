<?php
include_once("include/connect.php");
include_once("function/user.php");
include_once("function/settings.php");

// if not login
if(!isset($_SESSION['userspsv2.2'])){
    header("location:login.php");
}
else{
    $userinfo = explode("-", getUser($_SESSION['userspsv2.2']));
}

$errormsg = null;
$itemcode = null;
$itemname = null;
$itemprice = null;
$category = null;
$unit = null;
$reorder = null;

// if click save
if(isset($_GET['submit'])){
    $itemcode = $_GET['itemcode'];
    $itemname = $_GET['itemname'];
    $itemprice = $_GET['itemprice'];
    $category = $_GET['category'];
    $unit = $_GET['unit'];
    $reorder = $_GET['reorder'];

    // check if has same ItemCode w/. different itemID
    $result = mysql_query("SELECT * FROM tb_item WHERE item_code = '".$itemcode."'");
    if(mysql_fetch_array($result)>0){
        $errormsg = "Item Code already existed.<br>";
    }

    if(!$errormsg){
        mysql_query("INSERT INTO tb_item (item_code, item_name, sale_price, category_id, available_stock, unit_id, reorder_lvl) VALUES('".$itemcode."','".$itemname."',".$itemprice.",".$category.",0,".$unit.",".$reorder.")");
        header("location:item_add.php?save=success");
    }
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
    <title>SPS Ormoc EMS | Add New Item</title>
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
                        <h1 class="page-header">Add New Item</h1>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="item.php" type="button" class="btn btn-primary">Back</a>
                                </div>
                            </div>
                            <?php
                            // if error in save
                            if(isset($errormsg)){
                                echo '
                                <div class="col-lg-12">
                                <div class="alert alert-danger">
                                '.$errormsg.'
                                </div>
                                </div>
                                ';
                            }
                            // if success in save
                            if(isset($_GET['save'])){
                                echo '
                                <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                New item successfully added. <a href="item.php" class="alert-link">Click here to return to Item List</a>.
                                </div>
                                </div>
                                ';
                            }
                            ?>
                            <form>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Item Code</label>
                                        <input class="form-control" placeholder="Item Code" name="itemcode" value="<?php echo $itemcode; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Item Name</label>
                                        <input class="form-control" placeholder="Item Name" name="itemname" value="<?php echo $itemname; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Sale Price</label>
                                        <input class="form-control" placeholder="Sale Price" name="itemprice" value="<?php echo $itemprice; ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category">
                                            <?php
                                            $result = mysql_query("SELECT * FROM tb_category ORDER BY category_name ASC");
                                            while($row = mysql_fetch_array($result)){
                                                $catInfo = explode("?",getCategory($row['category_id']));
                                                echo "<option value='".$catInfo[0]."'";
                                                if(!empty($category) && $category == $catInfo[0]){
                                                    echo " selected";
                                                }
                                                echo ">".$catInfo[1]."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select class="form-control" name="unit">
                                            <?php
                                            $result = mysql_query("SELECT * FROM tb_unit ORDER BY unit_name ASC");
                                            while($row = mysql_fetch_array($result)){
                                                $unitInfo = explode("?",getUnit($row['unit_id']));
                                                echo "<option value='".$unitInfo[0]."'";
                                                if(!empty($unit) && $unit == $unitInfo[0]){
                                                    echo " selected";
                                                }
                                                echo ">".$unitInfo[1]."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Re-Ordering Level</label>
                                        <input class="form-control" placeholder="Re-Ordering Level" name="reorder" value="<?php echo $reorder; ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="text-align:right;">
                                    <input type="submit" type="button" class="btn btn-primary" name="submit" value="Save">
                                </div>
                            </form>
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
