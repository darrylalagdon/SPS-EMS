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

// get eqID value
$eqID = $_GET['eqID'];

// if eqID missing
if(!$eqID){
    header("location:equipment.php");
}

// get equipmentInfo
$result = mysql_query("SELECT * FROM tb_equipment WHERE equipmentID = ".$eqID);
$row = mysql_fetch_array($result);
$equipmentinfo = explode("?",getEquipment($row['equipmentID']));

$eqno = $equipmentinfo[1];
$eqtype = $equipmentinfo[2];
$eqbrand = $equipmentinfo[3];
$eqmodel = $equipmentinfo[4];
$eqcustodian = $equipmentinfo[8];


$eqpurdate = $equipmentinfo[5];

$eqpurcost = $equipmentinfo[6];
$warranty = $equipmentinfo[7];
$eqroom = $equipmentinfo[12];
$eqcondition = $equipmentinfo[16];
$eqstatus = $equipmentinfo[15];
$eqborrower = $equipmentinfo[14];
$eqremark = $equipmentinfo[17];

if(!$eqbrand){
    $eqbrand = "n/a";
}
if(!$eqmodel){
    $eqmodel = "n/a";
}
if(!$eqpurdate){
    $eqpurdate = "n/a";
}
else{
    $eqpurdate = getBreakDateEQ($equipmentinfo[5]);
}
if(!$eqpurcost){
    $eqpurcost = "n/a";
}
if(!$warranty){
    $warranty = "n/a";
}

// get room String
$row = mysql_fetch_array(mysql_query("SELECT * FROM tb_room WHERE roomID = ".$eqroom));
$eqroom = $row['room'];

// if equipment available
if(!$eqborrower){
    $eqstatus = "Available";
    $eqborrower = "None";
}
else{
    // find borrower
    $borrower = explode("/",getTeacher($equipmentinfo[14]));
    $eqborrower = $borrower[1];
}

// getToday
$dayInfo = explode("?",getToday());

// if borrow modal click BORROW
if(isset($_GET['submit'])){
    $eqID = $_GET['eqID'];
    $borrower = $_GET['borrower'];
    $room = $_GET['room'];
    $purpose = $_GET['purpose'];

    // save here something2x
    mysql_query("UPDATE tb_equipment SET status=".$borrower." WHERE equipmentID=".$eqID);
    mysql_query("INSERT INTO tb_borrow (equipmentID,teacherID,dateTimeBorrow,purpose,roomID) VALUES(".$eqID.",".$borrower.",'".$dayInfo[1]."','".$purpose."',".$room.")");

    header("location:equipment_view.php?eqID=".$eqID."&borrow=Success");
}

// if return modal click YES
if(isset($_GET['return']) && $_GET['return']=="Yes"){
    $rdate = explode("?", getToday());
    $rdate = $rdate[1]; 

    echo $rdate;

    mysql_query("UPDATE tb_equipment SET status=0 WHERE equipmentID=".$_GET['eqID']);
    mysql_query("UPDATE tb_borrow SET dateTimeReturn = '".$rdate."' WHERE borrowID=".$_GET['borrowID']);

    header("location:equipment_view.php?eqID=".$eqID."&return=Success");
}

// if click Yes from deleteConfirmModal
if(isset($_POST['delete']) && $_POST['delete']=="Confirm"){
    // check password is correct
    $result = mysql_query("SELECT * FROM tb_user WHERE userID=".$userinfo[0]." && password='".md5($_POST['password'])."'");
    if(mysql_num_rows($result)>0){
        mysql_query("DELETE FROM tb_equipment WHERE equipmentID=".$eqID);
        header("location:equipment.php?delete=Success");
    }
    else{
        header("location:equipment_view.php?eqID=".$eqID."&delete=Yes&password=fail");
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
    <title>SPS Ormoc EMS | Equipment Information</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[5, 10, 25], [5, 10, 25]]
        });
    });
    </script>

    <!-- advance tables end -->
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
                        <h1 class="page-header">Equipment Information</h1>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="equipment.php" type="button" class="btn btn-primary">Back</a>
                                </div>
                            </div>
                            <?php
                            // if borrow success
                            if(isset($_GET['borrow']) && $_GET['borrow']=="Success"){
                                echo '
                                <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Equipment successfully borrowed.
                                </div>
                                </div>
                                ';
                            }

                            // if return success
                            if(isset($_GET['return']) && $_GET['return']=="Success"){
                                echo '
                                <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Equipment successfully returned.
                                </div>
                                </div>
                                ';
                            }
                            ?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Equipment No.</label>
                                    <input class="form-control" value="<?php echo $eqno; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Equipment Type</label>
                                    <input class="form-control" value="<?php echo $eqtype; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Brand</label>
                                    <input class="form-control" value="<?php echo $eqbrand; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Model</label>
                                    <input class="form-control" value="<?php echo $eqmodel; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Property Custodian</label>
                                    <input class="form-control" value="<?php echo $eqcustodian; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Purchase Date</label>
                                    <input class="form-control" value="<?php echo $eqpurdate; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Purchase Cost</label>
                                    <input class="form-control" value="<?php echo $eqpurcost; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Warranty</label>
                                    <input class="form-control" value="<?php echo $warranty; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Room Assigned</label>
                                    <input class="form-control" value="<?php echo $eqroom; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Condition</label>
                                    <input class="form-control" value="<?php echo $eqcondition; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" style="max-width:100%;" disabled><?php echo $eqremark; ?></textarea>
                                </div>
                            </div>
                            <?php
                            if($userlvl!=4){
                            ?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <a href="equipment_update.php?eqID=<?php echo $eqID; ?>" class="btn btn-primary">Update Equipment</a>
                                    <?php
                                    if($userinfo[2]=="Administrator"){
                                        echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal'>Delete Equipment</button>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <input class="form-control" value="<?php echo $eqstatus; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Borrowed By</label>
                                    <input class="form-control" value="<?php echo $eqborrower; ?>" disabled>
                                </div>
                            </div>
                            <?php
                            if($userlvl!=4){
                            ?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?php
                                    if($equipmentinfo[14]==0){
                                        echo "<button class='btn btn-primary' data-toggle='modal' data-target='#borrowModal'>Borrow Equipment</button>";
                                    }
                                    else{
                                        $result = mysql_query("SELECT * FROM tb_borrow WHERE equipmentID = ".$equipmentinfo[0]." ORDER BY dateTimeBorrow DESC");
                                        $row = mysql_fetch_array($result);
                                        echo "<button class='btn btn-primary' data-toggle='modal' data-target='#returnModal'>Return Equipment</button>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            <!--
                            <div class="col-lg-12">
                                <a href="equipment_update.php?eqID=<?php echo $eqID; ?>" class="btn btn-primary">Update Equipment</a>
                            </div>
                            -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h3 class="page-header">Equipment Borrowing History</h3>
                        <div class="panel-body">
                            <!-- <div class="table-responsive"> -->
                                <!-- <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td>Date Borrowed</td>
                                            <td>Borrower</td>
                                            <td>Room</td>
                                            <td>Date Returned</td>
                                            <td>Purpose</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php                                        
                                        $result = mysql_query("SELECT * FROM tb_borrow WHERE equipmentID = ".$eqID." ORDER BY borrowID DESC");
                                        while($row=mysql_fetch_array($result)){
                                            $borrowInfo = explode("?",getBorrow($row['borrowID']));
                                            echo "
                                            <tr id='body-table-data'>
                                            <td>".getBreakDate($borrowInfo[3])."</td>
                                            <td>".$borrowInfo[7]."</td>
                                            <td>".$borrowInfo[8]."</trd>
                                            <td>";
                                            if(!empty($borrowInfo[4])){ echo getBreakDate($borrowInfo[4]); }
                                            echo "</td>
                                            <td>".$borrowInfo[5]."</td>
                                            </tr>
                                            ";
                                        }
                                        ?>
                                    </tbody>
                                </table> -->

                                <!-- advance table -->
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <td>Date Borrowed</td>
                                            <td>Borrower</td>
                                            <td>Room</td>
                                            <td>Date Returned</td>
                                            <td>Purpose</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = mysql_query("SELECT * FROM tb_borrow WHERE equipmentID = ".$eqID." ORDER BY borrowID DESC");
                                        while($row=mysql_fetch_array($result)){
                                            $borrowInfo = explode("?",getBorrow($row['borrowID']));
                                            echo "
                                            <tr class='gradeX'>
                                            <td>".getBreakDate($borrowInfo[3])."</td>
                                            <td>".$borrowInfo[7]."</td>
                                            <td>".$borrowInfo[8]."</trd>
                                            <td>";
                                            if(!empty($borrowInfo[4])){ echo getBreakDate($borrowInfo[4]); }
                                            echo "</td>
                                            <td>".$borrowInfo[5]."</td>
                                            </tr>
                                            ";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- end advance table -->

                            <!-- </div> -->
                        </div>
                        <!-- ***************************** -->

                        <!-- Borrow Modal -->
                        <div class="modal fade" id="borrowModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="equipment_view.php">
                                        <input type="hidden" name="eqID" value="<?php echo $eqID; ?>">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Borrow Equipment</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Borrower</label>
                                                <select class="form-control" name="borrower">
                                                    <?php
                                                    $result = mysql_query("SELECT * FROM tb_teacher ORDER BY teacherName ASC");
                                                    while($row = mysql_fetch_array($result)){
                                                        echo "
                                                        <option value='".$row['teacherID']."'";
                                                        if(isset($_GET['submit']) && $borrower==$row['teacherID']){
                                                            echo "selected";
                                                        }
                                                        echo ">".$row['teacherName']."</option>
                                                        ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Room</label>
                                                <select class="form-control" name="room">
                                                    <?php
                                                    $result = mysql_query("SELECT * FROM tb_room ORDER BY room ASC");
                                                    while($row = mysql_fetch_array($result)){
                                                        echo "
                                                        <option value='".$row['roomID']."'";
                                                        if(isset($_GET['submit']) && $room==$row['roomID']){
                                                            echo "selected";
                                                        }
                                                        echo ">".$row['room']."</option>
                                                        ";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Date of Borrow</label>
                                                <input class="form-control" value="<?php echo $dayInfo[0]; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Purpose</label>
                                                <textarea class="form-control" rows="2" name="purpose" style="white-space:pre-wrap;"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="submit" value="Borrow" class="btn btn-primary">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Return Modal -->
                        <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Return Equipment</h4>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure this is the right equipment. Once you click "Yes", it cannot be undo.
                                    </div>
                                    <div class="modal-footer">
                                        <?php
                                        $result = mysql_query("SELECT * FROM tb_borrow WHERE equipmentID = ".$equipmentinfo[0]." ORDER BY borrowID DESC");
                                        $row = mysql_fetch_array($result);
                                        echo '<a href="equipment_view.php?eqID='.$eqID.'&borrowID='.$row['borrowID'].'&return=Yes" class="btn btn-primary">Yes</a>';
                                        ?>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Delete Equipment</h4>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you to delete this equipment?
                                    </div>
                                    <div class="modal-footer">
                                        <?php
                                        $result = mysql_query("SELECT * FROM tb_borrow WHERE equipmentID = ".$equipmentinfo[0]." ORDER BY borrowID DESC");
                                        $row = mysql_fetch_array($result);
                                        echo '<a href="equipment_view.php?eqID='.$eqID.'&delete=Yes" class="btn btn-primary">Yes</a>';
                                        ?>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <!-- Delete Confirm Modal -->
                        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="equipment_view.php?eqID=<?php echo $eqID; ?>" method="post">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <?php
                                                if(isset($_GET["password"])){
                                                    echo "
                                                    <div class='alert alert-danger'>
                                                    Invalid Adminstrator password. Please input the correct password.
                                                    </div>
                                                    ";
                                                }
                                                else{
                                                    echo "
                                                    <div class='alert alert-info'>
                                                    Please input your Adminstrator password to confirm deletion.
                                                    </div>
                                                    ";
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group" align="center">
                                                <label>Administrator Password</label><br>
                                                <input type="password" name="password" style="text-align:center;" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="delete" value="Confirm" class="btn btn-danger">
                                            <a href="equipment_view.php?eqID=<?php echo $eqID; ?>" class="btn btn-default">Cancel</a>
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
    <?php
    // if click Yes from deleteModal
    if(isset($_GET['delete']) && $_GET['delete']=="Yes"){
        echo "
        <script>
        $('#deleteConfirmModal').modal('show');
        </script>
        ";
    }
    ?>
</body>
</html>