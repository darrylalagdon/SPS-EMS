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

if(!isset($_GET['userID']) || empty($_GET['userID'])){
    // get supplierinfo
    $unitinfo = explode("?", getUserM($_SESSION['userspsv2.2']));
    $userID = null;
    $name = $unitinfo[3];
    $username = $unitinfo[1];
    $usrlvl = $unitinfo[5];
    $password = $unitinfo[2];
    $changable = $unitinfo[6];

    // if click save
    if(isset($_POST['submit'])){
        $userID = null;
        $name = $_POST['name'];
        $username = $_POST['username'];
        // $usrlvl = $_POST['usrlvl'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $password3 = $_POST['password3'];

        // check if has same username w/. different userID
        $result = mysql_query('SELECT * FROM tb_user WHERE username = "'.$username.'" AND userID !='.$_SESSION['userspsv2.2']);
        if(mysql_num_rows($result)>0){
            $errormsg = "Username already used.<br>";
        }

        // if wrong password
        if($unitinfo[2]!=md5($password1)){
            $errormsg = $errormsg."Invalid password.<br>";
        }

        if(isset($_POST['change'])){
            if(empty($password2)){
                $errormsg = $errormsg."New Password is empty.<br>";
            }
            if(empty($password3)){
                $errormsg = $errormsg."Re-type Password is empty.<br>";
            }
            if(!empty($password2) && !empty($password3) && $password2!=$password3){
                $errormsg = $errormsg."Password Mismatch.<br>";
            }
            else{
                $password1 = $password2;
            }
        }

        if(!$errormsg){

            echo "userID: ".$_SESSION['userspsv2.2']."<br>";
            echo "name: ".$name."<br>";
            echo "username: ".$username."<br>";
            echo "password1: ".$password1."<br>";

            mysql_query("UPDATE tb_user SET username = '".$username."', password = '".md5($password1)."', name = '".$name."' WHERE userID = ".$_SESSION['userspsv2.2']);
            header("location:user_update.php?save=success");
        }
    }
}
else{
    // if userID doesn't exist anymaore
    $result = mysql_query("SELECT * FROM tb_user WHERE userID = ".$_GET['userID']);
    if(!mysql_num_rows($result)){
        header("location:user.php");
    }

    // get supplierinfo
    $unitinfo = explode("?", getUserM($_GET['userID']));
    $userID = $unitinfo[0];
    $name = $unitinfo[3];
    $username = $unitinfo[1];
    $usrlvl = $unitinfo[5];
    $password = $unitinfo[2];
    $changable = $unitinfo[6];

    // if click save
    if(isset($_POST['submit'])){
        $userID = $_POST['userID'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $usrlvl = $_POST['usrlvl'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $password3 = $_POST['password3'];

        // check if has same username w/. different userID
        $result = mysql_query('SELECT * FROM tb_user WHERE username = "'.$username.'" AND userID !='.$userID);
        if(mysql_num_rows($result)>0){
            $errormsg = "Username already used.<br>";
        }

        // if wrong password
        if($unitinfo[2]!=md5($password1)){
            $errormsg = $errormsg."Invalid password.<br>";
        }

        if(isset($_POST['change'])){
            if(empty($password2)){
                $errormsg = $errormsg."New Password is empty.<br>";
            }
            if(empty($password3)){
                $errormsg = $errormsg."Re-type Password is empty.<br>";
            }
            if(!empty($password2) && !empty($password3) && $password2!=$password3){
                $errormsg = $errormsg."Password Mismatch.<br>";
            }
            else{
                $password1 = $password2;
            }
        }

        // check if changable password
        if(!isset($_POST['changable'])){
            $changable=0;
        }
        else{
            $changable=1;
        }

        if(!$errormsg){
            mysql_query("UPDATE tb_user SET username = '".$username."', password = '".md5($password1)."', name = '".$name."', userlvlID = ".$usrlvl.", changable = ".$changable." WHERE userID = ".$userID);
            header("location:user_update.php?userID=".$userID."&save=success");
        }
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
    <title>SPS Ormoc EMS | Update User</title>
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
                        <h1 class="page-header">Update User</h1>
                        <div class="panel-body">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <?php
                                    if(isset($userID)){
                                        echo '<a href="user.php" type="button" class="btn btn-primary">Back</a>';
                                    }
                                    else{
                                        echo '<a href="user_view.php" type="button" class="btn btn-primary">Back</a>';   
                                    }
                                    ?>
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
                                if(isset($userID)){
                                    $link = 'User Account successfully updated. <a href="user.php" class="alert-link">Click here to return to Users</a>.';
                                }
                                else{
                                    $link = 'User Account successfully updated. <a href="user_view.php" class="alert-link">Click here to return to User Account</a>.';
                                }
                                echo '
                                <div class="col-lg-12">
                                <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                '.$link.'
                                </div>
                                </div>
                                ';
                            }
                            ?>
                            <form method="post">
                                <input type="hidden" name="userID" value="<?php echo $userID; ?>">
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
                                        <select class="form-control" name="usrlvl" <?php if(!$userID){ echo "disabled"; } ?>>
                                            <?php
                                            $result = mysql_query("SELECT * FROM tb_userlvl");
                                            while($row = mysql_fetch_array($result)){
                                                $lvlInfo = explode("?",getUserLvl($row['userlvlID']));
                                                echo "
                                                <option value='".$lvlInfo[0]."'";
                                                if($usrlvl==$lvlInfo[1]){
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
                                    <?php
                                        echo "
                                        <div class='form-group'>
                                        <label class='checkbox-inline'>
                                        <input type='checkbox' name='changable' value='1' ";
                                        if($changable==1){ echo 'checked'; }
                                        if(!$userID){ echo ' disabled'; }
                                        echo "
                                        >Super User
                                        </label>
                                        </div>
                                        ";
                                    ?>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password1" required>
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm Password" name="password2">
                                    </div>
                                    <div class="form-group">
                                        <label>Re-type Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm Password" name="password3">
                                    </div>
                                    <div class="form-group">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="change" value="1" <?php if(isset($_POST['change'])){ echo "checked"; } ?>>Yes, I want to change my password.
                                        </label>
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
