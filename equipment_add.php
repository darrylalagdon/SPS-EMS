<?php
include_once("include/connect.php");
include_once("function/user.php");
include_once("function/equipment.php");

// if not login
if(!isset($_SESSION['userspsv2.2'])){
    header("location:login.php");
}
else{
    $userinfo = explode("-", getUser($_SESSION['userspsv2.2']));
}

$errormsg = null;
$eqno = null;
$eqtype = null;
$eqbrand = null;
$eqmodel = null;
$eqcustodian = null;
$eqpurdate = null;
$eqpurcost = null;
$warranty = null;
$eqroom = null;
$eqcondition = null;

// if click save
if(isset($_GET['submit'])){
    $eqno = $_GET['eqno'];
    $eqtype = $_GET['eqtype'];
    $eqbrand = $_GET['eqbrand'];
    $eqmodel = $_GET['eqmodel'];
    $eqcustodian = $_GET['eqcustodian'];
    $eqpurdate = $_GET['eqpurdate'];
    $eqpurcost = $_GET['eqpurcost'];
    $warranty = $_GET['warranty'];
    $eqroom = $_GET['eqroom'];
    $eqcondition = $_GET['eqcondition'];
    $remark = $_GET['remark'];

    // check if has same EqNo w/. different EqID
    $result = mysql_query("SELECT * FROM tb_equipment WHERE equipmentNo = '".$eqno."'");
    if(mysql_fetch_array($result)>0){
        $errormsg = "Equipment No. already existed.<br>";
    }

    if(!$errormsg){
        mysql_query("INSERT INTO tb_equipment (equipmentNo, equipmentTypeID, brand, model, purchaseDate, purchaseCost, warranty, teacherID, roomID, conditionID, remark)
            VALUES('".$eqno."', ".$eqtype.", '".$eqbrand."', '".$eqmodel."', '".$eqpurdate."', '".$eqpurcost."', '".$warranty."', ".$eqcustodian.", ".$eqroom.", ".$eqcondition.", '".$remark."')");
        header("location:equipment_add.php?save=success");
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
    <title>SPS Ormoc EMS | Add New Equipment</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- date picker -->
    <link rel="stylesheet" href="add-on/datepicker/jquery/date-picker/date-picker.css">
    <script src="add-on/datepicker/jquery/date-picker/jquery-1.10.2.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="add-on/datepicker/jquery/date-picker/jquery-ui.js"></script>
    <script>
    $(function() {
        $( "#datepicker" ).datepicker();
    });
    </script>
    <script>
    $(function() {
        $( "#datepicker2" ).datepicker();
    });
    </script>
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
                        <h1 class="page-header">Add New Equipment</h1>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="equipment.php" type="button" class="btn btn-primary">Back</a>
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
                                New equipment successfully added. <a href="equipment.php" class="alert-link">Click here to return to Equipment List</a>.
                                </div>
                                </div>
                                ';
                            }
                            ?>
                            <form>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Equipment No.</label>
                                        <input class="form-control" placeholder="Equipment No." name="eqno" value="<?php echo $eqno; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Equipment Type</label>
                                        <select class="form-control" name="eqtype">
                                            <?php
                                            $result = mysql_query("SELECT * FROM tb_equipmenttype ORDER BY equipmentType ASC");
                                            while($row = mysql_fetch_array($result)){
                                                $eqtypeinfo = explode("/", getEqType($row['equipmentTypeID']));
                                                echo "<option value='".$eqtypeinfo[0]."'";
                                                if(isset($_POST['submit']) && ($eqtypeinfo[0]==$eqType)){
                                                    echo "selected";
                                                }
                                                echo ">".$eqtypeinfo[1]."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Brand</label>
                                        <input class="form-control" placeholder="Brand" name="eqbrand" value="<?php echo $eqbrand; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Model</label>
                                        <input class="form-control" placeholder="Model" name="eqmodel" value="<?php echo $eqmodel; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Property Custodian</label>
                                        <select class="form-control" name="eqcustodian">
                                            <?php
                                            $result = mysql_query("SELECT * FROM tb_teacher ORDER BY teacherName ASC");
                                            while($row = mysql_fetch_array($result)){
                                                $teacherinfo = explode("/", getTeacher($row['teacherID']));
                                                echo "<option value='".$teacherinfo[0]."'";
                                                if(isset($_POST['submit']) && ($teacherinfo[0]==$custodian)){
                                                    echo "selected";
                                                }
                                                echo ">".$teacherinfo[1]."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Purchase Date</label>
                                        <input class="form-control" placeholder="Purchase Date" name="eqpurdate" id="datepicker"value="<?php echo $eqpurdate; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Purchase Cost</label>
                                        <input class="form-control" placeholder="Purchase Cost" name="eqpurcost" value="<?php echo $eqpurcost; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Warranty</label>
                                        <input class="form-control" placeholder="Warranty" name="warranty" value="<?php echo $warranty; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Room Assigned</label>
                                        <select class="form-control" name="eqroom">
                                            <?php
                                            $result = mysql_query("SELECT * FROM tb_room ORDER BY room ASC");
                                            while($row = mysql_fetch_array($result)){
                                                $roominfo = explode("/", getRoom($row['roomID']));
                                                echo "<option value='".$roominfo[0]."'";
                                                if(isset($_POST['submit']) && ($roominfo[0]==$room)){
                                                    echo "selected";
                                                }
                                                echo ">".$roominfo[1]."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Condition</label>
                                        <select class="form-control" name="eqcondition">
                                            <option value="1">Working</option>
                                            <option value="2">Damage</option>
                                            <option value="2">Dispose</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <textarea class="form-control" name="remark" style="max-width:100%;"></textarea>
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
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/metisMenu/metisMenu.min.js"></script>
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script>
    <script src="dist/js/sb-admin-2.js"></script>
</body>
</html>
