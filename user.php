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

$ch_error=0;

// if click Change from change password modal
if(isset($_POST['changePassword'])){
    // check password1 and password2 if match
    if($_POST['pass1']==$_POST['pass2']){
        header("location:user.php?userID=".$_GET['userID']."&psw=".md5($_POST['pass1']));
    }
    else{
        $ch_error=1;
    }
}

// if click Change from change password modal
if(isset($_POST['confirm'])){
    // check password1 and password2 if match
    $result = mysql_query("SELECT * FROM tb_user WHERE userID = ".$userinfo[0]." AND password = '".md5($_POST['password'])."'");
    if(mysql_num_rows($result)){
        // header("location:user.php?userID=".$_GET['userID']."&psw=".md5($_POST['pass1'])."&confirm=Yes");
        mysql_query("UPDATE tb_user SET password = '".$_GET['psw']."' WHERE userID = ".$_GET['userID']);
        header("location:user.php?change=Success");
    }
    else{
        $ch_error=1;
    }
}

$delete_action=0;

// if click confirm in Confirm Delete Modal
if(isset($_POST['delete']) && $_POST['delete']=="Confirm"){
    // check if admin password is correct
    $result = mysql_query("SELECT * FROM tb_user WHERE userID = ".$userinfo[0]." AND password = '".md5($_POST['password'])."'");
    if(mysql_num_rows($result)){
        $delete_action = 1;
        mysql_query("DELETE FROM tb_user WHERE userID = ".$_GET['userID']);
        header("location:user.php?delete=Success");
    }
    else{
        $ch_error=1;
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
    <title>SPS Ormoc EMS | Users</title>
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
                        <h1 class="page-header">Users</h1>
                        <div class="col-lg-12">
                            <?php
                            if(isset($_GET['delete']) && $_GET['delete']=="Success"){
                                echo '
                                <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                User successfully deleted.
                                </div>
                                ';
                            }

                            if(isset($_GET['change'])){
                                echo '
                                <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                User password successfully changed.
                                </div>
                                ';
                            }
                            ?>
                        </div>
                        <div class="panel-body">
                            <a href="user_add.php" type="button" class="btn btn-primary">Add New Users</a>
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Username</td>
                                        <td>Userlevel</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysql_query("SELECT * FROM tb_user");
                                    while($row = mysql_fetch_array($result)){
                                        $userinfo = explode("?", getUserM($row['userID']));
                                        echo "
                                        <tr class='gradeX'>
                                        <td>".$userinfo[3]."</td>
                                        <td>".$userinfo[1]."</td>
                                        <td>".$userinfo[5]."</td>
                                        <td width='290px'>
                                        <a class='btn btn-primary' href='user_update.php?userID=".$userinfo[0]."'>Update</a>
                                        ";
                                        // disable change password button if own account
                                        if($_SESSION['userspsv2.2']==$userinfo[0] || $userinfo[6]==1){
                                            echo " <a class='btn btn-success' disabled>Change Password</a>";   
                                        }
                                        else{
                                            echo "<a class='btn btn-success' href='user.php?userID=".$userinfo[0]."'>Change Password</a>";
                                        }
                                        // disable delete button if administrator
                                        if(1!=$userinfo[4]){
                                            echo " <a class='btn btn-danger' data-toggle='modal' data-target='#deleteUserModal".$userinfo[0]."' style='cursor:pointer;'>Delete</a>";
                                        }
                                        else{
                                            echo " <a class='btn btn-danger' disabled>Delete</a>";   
                                        }
                                        echo "
                                        </td>
                                        </tr>
                                        ";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- ***************************************************************** -->
                        <!-- Delete User Modal -->
                        <?php
                        $result = mysql_query("SELECT * FROM tb_user");
                        while($row = mysql_fetch_array($result)){
                            $userinfo = explode("?", getUserM($row['userID']));
                            echo '
                            <div class="modal fade" id="deleteUserModal'.$userinfo[0].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Delete User</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Do you wish to delete this user? Once, click "Yes" it cannot be undo.</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="user.php?userID='.$userinfo[0].'&delete=Yes" class="btn btn-danger">Yes</a>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                        ?>

                        <!-- Change Password User Modal -->
                        <?php
                        // if click change password button
                        if(isset($_GET['userID']) && !isset($_GET['psw']) && !isset($_GET['delete'])){
                            $userInfo = explode("?",getUserM($_GET['userID']));
                            $ch_userID = $userInfo[0];
                            $ch_username = $userInfo[1];
                            $ch_name = $userInfo[3];
                            $ch_userlvl = $userInfo[5];

                            $result = mysql_query("SELECT * FROM tb_user");
                            while($row = mysql_fetch_array($result)){
                                $userinfo = explode("?", getUserM($row['userID']));
                                echo '
                                <div class="modal fade" id="changePassUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="user.php?userID='.$ch_userID.'">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        ';
                                                        if($ch_error==1){
                                                            echo "
                                                            <div class='alert alert-danger'>
                                                            Password mismatch.
                                                            </div>
                                                            ";
                                                        }
                                echo
                                                        '
                                                        <label>Name: '.$ch_name.'</label><br>
                                                        <label>Username: '.$ch_username.'</label><br>
                                                        <label>Userlevel: '.$ch_userlvl.'</label>
                                                        <hr>
                                                        <label>Input new password</label><br>
                                                        <label>Password</label><br>
                                                        <label><input type="password" name="pass1" required></label><br>
                                                        <label>Re-type Password</label><br>
                                                        <label><input type="password" name="pass2" required></label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-success" name="changePassword" value="Change">
                                                    <a href="user.php" class="btn btn-default">Cancel</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                        }
                        ?>

                        <!-- Confirm Change Password Modal -->
                        <div class="modal fade" id="confirmChangePassUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="user.php?<?php echo "userID=".$_GET['userID']."&psw=".$_GET['psw']; ?>" method="post">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Confirm Change Password</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <?php
                                                if($ch_error==1){
                                                    echo "
                                                    <div class='alert alert-danger'>
                                                    Invalid Adminstrator password. Please input the correct password.
                                                    </div>
                                                    ";
                                                }
                                                else{
                                                    echo "
                                                    <div class='alert alert-info'>
                                                    Please input your Adminstrator password to apply the new password.
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
                                            <input type="submit" name="confirm" value="Confirm" class="btn btn-danger">
                                            <a href="user.php" class="btn btn-default">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Delete User Modal -->
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="user.php?<?php echo "userID=".$_GET['userID']."&delete=Yes"; ?>" method="post">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <?php
                                                if($ch_error==1){
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
                                            <a href="user.php" class="btn btn-default">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- ***************************************************************** -->
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

    <!-- advance tables start -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
    <!-- advance tables end -->
    <?php
    // if click Change Password button
    if(isset($_GET['userID'])){
        echo "
        <script>
        $('#changePassUserModal').modal('show');
        </script>
        ";
    }

    // if click password match
    if(isset($_GET['psw'])){
        echo "
        <script>
        $('#confirmChangePassUserModal').modal('show');
        </script>
        ";
    }

    // if click Yes from Delete User Modal
    if(isset($_GET['delete']) && $_GET['delete']=="Yes" && $delete_action==0){
        echo "
        <script>
        $('#confirmDeleteModal').modal('show');
        </script>
        ";
    }
    ?>
</body>
</html>
