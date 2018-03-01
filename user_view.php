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

$userID = $_SESSION['userspsv2.2'];
$userinfoM = explode("?", getUserM($userID));
$name = $userinfoM[3];
$username = $userinfoM[1];
$privilege = $userinfoM[5];

// if click Yes from deleteConfirmModal
if(isset($_POST['delete']) && $_POST['delete']=="Confirm"){
    // check password is correct
    $result = mysql_query("SELECT * FROM tb_user WHERE userID=".$userinfo[0]." && password='".md5($_POST['password'])."'");
    if(mysql_num_rows($result)>0){
        mysql_query("DELETE FROM tb_user WHERE userID=".$userID);
        header("location:login.php?logout=Logout&deactivate=Yes");
    }
    else{
        header("location:user_view.php?deactivate=Yes&password=fail");
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
    <title>SPS Ormoc EMS | User Account</title>
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
                        <h1 class="page-header">User Account</h1>
                        <div class="panel-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input class="form-control" value="<?php echo $name; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control" value="<?php echo $username; ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Privilege</label>
                                    <input class="form-control" value="<?php echo $privilege; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <a class="btn btn-primary" href="user_update.php">Update</a>
                                <?php
                                if($userinfoM[4]==1){
                                    echo "<button class='btn btn-danger' data-toggle='modal' data-target='#deactivateModal'>Deactive Account</button>";
                                }
                                ?>
                            </div>
                        </div>
                        <!-- ***************************** -->

                        <!-- Deactivate Modal -->
                        <div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Deactivate Account</h4>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you to deactivate this account?
                                    </div>
                                    <div class="modal-footer">
                                        <a href="user_view.php?deactivate=Yes" class="btn btn-primary">Yes</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <!-- Deactivate Confirm Modal -->
                        <div class="modal fade" id="deactivateConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Deactivate Account</h4>
                                    </div>
                                    <?php
                                    if($userinfoM[6]){
                                        echo '
                                        <div class="modal-body">
                                        Unable to deacticate Super User account. You must first disable the Super User settings.
                                        </div>
                                        <div class="modal-footer">
                                        <a href="user_view.php" class="btn btn-primary">Ok</a>
                                        </div>
                                        ';
                                    }
                                    else{
                                        echo '
                                        <form action="user_view.php" method="post">
                                        <div class="modal-body">
                                        <div class="form-group">
                                        ';
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
                                            Please input your Adminstrator password to confirm deactivation.
                                            </div>
                                            ";
                                        }
                                        echo '
                                            <div class="form-group" align="center">
                                                <label>Administrator Password</label><br>
                                                <input type="password" name="password" style="text-align:center;" required>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="delete" value="Confirm" class="btn btn-danger">
                                            <a href="user_view.php" class="btn btn-default">Cancel</a>
                                        </div>
                                        </form>
                                        ';
                                    }
                                    ?>
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
    <?php
    // if click Yes from deleteModal
    if(isset($_GET['deactivate']) && $_GET['deactivate']=="Yes"){
        echo "
        <script>
        $('#deactivateConfirmModal').modal('show');
        </script>
        ";
    }
    ?>
</body>
</html>
