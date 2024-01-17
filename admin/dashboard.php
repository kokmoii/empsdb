<?php 
session_start();
error_reporting(0);
require_once('include/config.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <title>Employee Management System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
      <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <?php include 'include/sidebar.php'; ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
  <?php
$query=$dbh->prepare("SELECT id FROM tblemployee");
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$regemp=$query -> rowCount();
?>

        <div class="col-md-6 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info"><a href="manage-employee.php">
              <h4>Registered Employees</h4>
              <p><b><?php echo $regemp;?></b></p></a>
            </div>
          </div>
        </div>



<?php
$ret=$dbh->prepare("SELECT id FROM tbldepartment");
$ret-> execute();
$resultss = $ret -> fetchAll(PDO::FETCH_OBJ);
$listeddept=$ret -> rowCount();
?>
        <div class="col-md-6 col-lg-4">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
            <div class="info">
              <a href="manage-department.php">
              <h4>Listed Departments</h4>
              <p><b><?php echo $listeddept;?></b></p>
            </a>
            </div>
          </div>
        </div>


<?php
$sql=$dbh->prepare("SELECT id FROM tblleavetype");
$sql-> execute();
$result = $sql -> fetchAll(PDO::FETCH_OBJ);
$listedleavetype=$sql -> rowCount();
?>
        <div class="col-md-6 col-lg-4">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
            <div class="info">  <a href="manage-leave.php">
              <h4>Listed Leave Type</h4>
              <p><b><?php echo $listedleavetype;?></b></p>
            </a>
            </div>
          </div>
        </div>
      </div>
<!-------------------------------->
<hr />
<h3 align="center">Leaves Details </h3>
<hr />
      <div class="row">
  <?php
$query=$dbh->prepare("SELECT id FROM tblleave");
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$totalleaves=$query -> rowCount();
?>
        <div class="col-md-6 col-lg-6">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
            <div class="info"><a href="leave-history.php">
              <h4>Leaves Applied</h4>
              <p><b><?php echo $totalleaves;?></b></p>
            </a>
            </div>
          </div>
        </div>



<?php
$ret=$dbh->prepare("SELECT id FROM tblleave where status='pending'");
$ret-> execute();
$resultss = $ret -> fetchAll(PDO::FETCH_OBJ);
$newleaves=$ret -> rowCount();
?>
        <div class="col-md-6 col-lg-6">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-file fa-3x"></i>
            <div class="info"> <a href="new-leave-request.php">
              <h4>New Leave Requests</h4>
              <p><b><?php echo $newleaves;?></b></p>
            </a>
            </div>
          </div>
        </div>


<?php
$sql=$dbh->prepare("SELECT id FROM tblleave where status='Reject'");
$sql-> execute();
$result = $sql -> fetchAll(PDO::FETCH_OBJ);
$rejectedleaves=$sql -> rowCount();
?>
        <div class="col-md-6 col-lg-6">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-file fa-3x"></i>
            <div class="info"><a href="reject-leave-request.php">
              <h4>Rejected Leave Requests</h4>
              <p><b><?php echo $rejectedleaves;?></b></p>
            </a>
            </div>
          </div>
        </div>

 <?php
$sql=$dbh->prepare("SELECT id FROM tblleave where status='Approved'");
$sql-> execute();
$result = $sql -> fetchAll(PDO::FETCH_OBJ);
$approvedleaves=$sql -> rowCount();
?>       
      <div class="col-md-6 col-lg-6">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-file fa-3x"></i>
            <div class="info"><a href="approved-leave-request.php">
              <h4>Approved Leave Requests</h4>
              <p><b><?php echo $approvedleaves;?></b></p>
            </a>
            </div>
          </div>
        </div>


      </div>



    </main>
    <!-- Essential javascripts for application to work-->
     <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <script type="text/javascript" src="../js/plugins/chart.js"></script>

  </body>
</html>