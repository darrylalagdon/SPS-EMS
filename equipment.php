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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SPS Ormoc EMS | Equipment List</title>
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
                        <h1 class="page-header">Equipment List</h1>
                        <?php
                        // if delete success
                        if(isset($_GET['delete'])){
                            echo '
                            <div class="col-lg-12">
                            <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            Equipment successfully deleted.
                            </div>
                            </div>
                            ';
                        }

                        if($userlvl!=4){
                        ?>
                        <div class="panel-body">
                            <a href="equipment_add.php" type="button" class="btn btn-primary">Add New Equipment</a>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Eq#</th>
                                        <th>Equipment Type</th>
                                        <th>Brand/Model</th>
                                        <th>Status</th>
                                        <th>Condition</th>
                                        <th>Action</th>
                                        <th>Property Custodian</th>
                                        <th>Room</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysql_query("SELECT * FROM tb_equipment");
                                    while($row = mysql_fetch_array($result)){
                                        $equipmentinfo = explode("?",getEquipment($row['equipmentID']));
                                        echo "
                                        <tr class='gradeX'>
                                        <td>".$equipmentinfo[1]."</td>
                                        <td>".$equipmentinfo[2]."</td>
                                        <td>".$equipmentinfo[3]." ".$equipmentinfo[4]."</td>
                                        <td>".$equipmentinfo[15]."</td>
                                        <td>".$equipmentinfo[16]."</td>
                                        <td><a href='equipment_view.php?eqID=".$equipmentinfo[0]."'>View</a></td>
                                        <td>".$equipmentinfo[8]."</td>
                                        <td>".$equipmentinfo[9]."</td>
                                        </tr>
                                        ";
                                    }
                                    ?>
                                </tbody>
                            </table>
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

    <!-- advance tables start -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            "columnDefs": [
            {
                "targets": [ 6 ],
                "visible": false
            },
            {
                "targets": [ 7 ],
                "visible": false
            }
        ]
        });
    });
    </script>
    <!-- advance tables end -->

</body>
</html>
