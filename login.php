<?php
include_once("include/connect.php");

$username = "";
$row = 0;

// if click login
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $result = mysql_query("SELECT * FROM tb_user WHERE username = '".$username."' AND password = '".$password."'");
    $row = mysql_num_rows($result);

    if($row>0){
        $row = mysql_fetch_array($result);
        $_SESSION['userspsv2.2'] = $row['userID'];
        echo $_SESSION['userspsv2.2'];
        header("location:index.php");
    }
    else{
        $row = 2;
    }
}

// logout
if(isset($_GET["logout"])){
    $_SESSION['userspsv2.2'] = null;

    if(isset($_GET['deactivate'])){
        header("location:login.php?deactivate=Success");
    }
    else{
        header("location:index.php");   
    }
}

// if the user is already loggin
if(isset($_SESSION['userspsv2.2'])){
    header("location:index.php");   
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
    <title>Login</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body style="background:#158ff7;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <center style="margin-top:10%;">
                    <img src="image/spslogo.png" style="width:60%;">
                </center>
                <div class="login-panel panel panel-default" style="margin-top:5%;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="username" value="<?php echo $username; ?>" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                </div>
                                <?php
                                if($row==2){
                                    echo '
                                    <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Invalid username or password
                                    </div>
                                    ';
                                }
                                ?>
                                <input name="submit" type="submit" class="btn btn-lg btn-primary btn-block">
                            </fieldset>
                        </form>
                        <!-- Modal -->
                        <!-- ********************************* -->

                        <!-- Deactivate Success Modal -->
                        <div class="modal fade" id="deactivateSuccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Deactivation Complete</h4>
                                    </div>
                                    <div class="modal-body">
                                        Account has successfully deactivated.
                                    </div>
                                    <div class="modal-footer">
                                        <a href="index.php" class="btn btn-primary">Ok</a>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <!-- ********************************* -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/metisMenu/metisMenu.min.js"></script>
    <script src="dist/js/sb-admin-2.js"></script>
    <?php
    // if click Yes from deactivateSuccessModal
    if(isset($_GET['deactivate']) && $_GET['deactivate']=="Success"){
        echo "
        <script>
        $('#deactivateSuccessModal').modal('show');
        </script>
        ";
    }
    ?>
</body>
</html>
