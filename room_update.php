<?php
include_once("include/connect.php");
include_once("function/user.php");
include_once("function/maintenance.php");

// if not login
if(!isset($_SESSION['userspsv2.2'])){
    header("location:login.php");
}
else{
    $userinfo = explode("-", getUser($_SESSION['userspsv2.2']));
}

$errormsg = null;

// get supplierinfo
$roominfo = explode("/", getRoom($_GET['roomID']));
$roomID = $roominfo[0];
$room = $roominfo[1];

// if click save
if(isset($_GET['submit'])){
    $roomID = $_GET['roomID'];
    $room = $_GET['room'];

    // check if has same supplier name and company name w/. different EqID
    $result = mysql_query('SELECT * FROM tb_room WHERE room = "'.$room.'" AND roomID != '.$roomID);
    if(mysql_num_rows($result)>0){
        $errormsg = "Room already existed.<br>";
    }

    if(!$errormsg){
        mysql_query("UPDATE tb_room SET room = '".$room."' WHERE roomID = ".$roomID);
        header("location:room_update.php?roomID=".$roomID."&save=success");
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
    <title>SPS Ormoc EMS | Update Room</title>
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
                        <h1 class="page-header">Update Room</h1>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="room.php" type="button" class="btn btn-primary">Back</a>
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
                                Room successfully updated. <a href="room.php" class="alert-link">Click here to return to Rooms</a>.
                                </div>
                                </div>
                                ';
                            }
                            ?>
                            <form>
                                <input type="hidden" name="roomID" value="<?php echo $roomID; ?>">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Room</label>
                                        <input class="form-control" placeholder="Room" name="room" value="<?php echo $room; ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
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
