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
$name = null;
$username = null;
$usrlvl = null;

// if click save
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $usrlvl = $_POST['usrlvl'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    // check if has same username w/. different userID
    $result = mysql_query('SELECT * FROM tb_user WHERE username = "'.$username.'"');
    if(mysql_num_rows($result)>0){
        $errormsg = "Username already used.<br>";
    }

    // check same password1 and password2
    if($password1!=$password2){
        $errormsg = $errormsg."Password mistmatch.<br>";   
    }

    if(!$errormsg){
        if($usrlvl==1){
            $query="INSERT INTO tb_user (username, password, name, userlvlID, changable) VALUES ('".$username."', '".md5($password1)."', '".$name."', ".$usrlvl.", 1)";
        }
        else{
            $query="INSERT INTO tb_user (username, password, name, userlvlID) VALUES ('".$username."', '".md5($password1)."', '".$name."', ".$usrlvl.")";
        }
        mysql_query($query);
        header("location:user_add.php?save=success");
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
    <title>SPS Ormoc EMS | Add New User</title>
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
                        <h1 class="page-header">Add New User</h1>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <a href="user.php" type="button" class="btn btn-primary">Back</a>
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
                                New user successfully added. <a href="user.php" class="alert-link">Click here to return to Users</a>.
                                </div>
                                </div>
                                ';
                            }
                            ?>
                            <form method="post">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" placeholder="Name" name="name" value="<?php echo $name; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control" placeholder="Username" name="username" value="<?php echo $username; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Privilege</label>
                                        <select class="form-control" name="usrlvl">
                                            <?php
                                            $result = mysql_query("SELECT * FROM tb_userlvl");
                                            while($row = mysql_fetch_array($result)){
                                                $lvlInfo = explode("?",getUserLvl($row['userlvlID']));
                                                echo "
                                                <option value='".$lvlInfo[0]."'";
                                                if($usrlvl==$lvlInfo[0]){
                                                    echo "selected";
                                                }
                                                echo ">
                                                ".$lvlInfo[1]."
                                                </option>
                                                ";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password1" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Re-type Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm Password" name="password2" required>
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
