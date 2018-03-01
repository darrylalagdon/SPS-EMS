<?php
include_once("include/connect.php");
include_once("function/user.php");

// if not login
if(!isset($_SESSION['userspsv2.2'])){
    header("location:login.php");
}
else{
    $userinfo = explode("-", getUser($_SESSION['userspsv2.2']));
}

function cformat($date){
    $date=explode("/",$date);
    return $date[2]."/".$date[0]."/".$date[1];
}

// initail
$error="";

if(isset($_GET['submit'])){
    $date1=$_GET['date1'];
    $date2=$_GET['date2'];
    $date1=cformat($date1);
    $date2=cformat($date2);
    $todate=explode("?",getToday());
    $todate=$todate[1];

    if($date1>$date2){
        $error = "Starting date cannot be the greater than to the end date.<br>";
    }

    if($date1>$todate || $date2>$todate){
        $error = "Invalid date selection.";
    }

    if(empty($error)){
        header("location:report-sale_view.php?date1=".$date1."&date2=".$date2);
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
    <title>SPS Ormoc EMS | Sale Inventory Report</title>
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
                        <h1 class="page-header">Sale Inventory Report</h1>
                        <div class="panel-body">
                            <form>
                                <div class="col-lg-12">
                                    <?php
                                    if(!isset($_GET['submit'])){
                                        echo '
                                        <div class="alert alert-info alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        Select a range of date.
                                        </div>
                                        ';
                                    }
                                    if($error){
                                        echo '
                                        <div class="alert alert-danger alert-dismissable">
                                        '.$error.'
                                        </div>
                                        ';
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input class="form-control" placeholder="Start Date" type="text" id="datepicker" name="date1" required>
                                    </div>
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input class="form-control" placeholder="End Date" type="text" id="datepicker2" name="date2" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" name="submit" value="View Report">
                                    </div>
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
