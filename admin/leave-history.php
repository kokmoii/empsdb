<?php 
session_start();
error_reporting(0);
require_once('include/config.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive">
  
    <title>Employee Management System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
 <?php include 'include/header.php'; ?>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
     <?php include 'include/sidebar.php'; ?>
    <main class="app-content">
      
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <h2 align="center"> All Leave Requests</h2>
              <hr />
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>Sr.No</th>
                    <th>Emp ID</th>
                    <th>Leave Type</th>
                    <th>From</th>
                    <th>To</th>
                   
                    <th>Posting Date</th>
                   
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                  <tbody>
                   <?php
                  $sql="SELECT tblleave.id, userID, EmpID, tblleave.LeaveType, FromDate, Todate, Description, status, 
adminremarks, tblleave.Create_date,tblleavetype.leaveType as leavetypss FROM tblleave
join tblleavetype on tblleave.LeaveType=tblleavetype.id";
                  $query= $dbh->prepare($sql);                  $query-> execute();
                  $results = $query -> fetchAll(PDO::FETCH_OBJ);
                  $cnt=1;
                  if($query -> rowCount() > 0)
                  {
                  foreach($results as $result)
                  {
                  ?>

            
                  <tr>
                    <td><?php echo($cnt);?></td>
                    <td><?php echo htmlentities($result->EmpID);?></td>
                    <td><?php echo htmlentities($result->leavetypss);?></td>
                  <td><?php echo htmlentities($result->FromDate);?></td>
                  <td><?php echo htmlentities($result->Todate);?></td>
                 <td><?php echo htmlentities($result->Create_date);?></td>
                  
                  <td>
                  <?php 
                  $statuss=$result->status;
                   if ($statuss=="Pending"):
                     echo '<span class="btn btn-warning">Not updated yet</span>';
                   endif; ?>
                   <?php 
                   if ($statuss=="Approved"):
                     echo '<span class="btn btn-success">Approved</span>';
                   endif;

                  if ($statuss=="Reject"):
                  echo '<span class="btn btn-danger">Reject</span>';
                  endif;
                    ?>
                 </td>
                 <td><a href="details-leave.php?leaveid=<?php echo htmlentities($result->id);?>" class="waves-effect waves-light btn btn-primary m-b-xs"  > View Details</a></td>
                </tr>
                   
                 
           

                
                 <?php  $cnt=$cnt+1; } } ?>
                      </tbody>
              </table>
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
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <!-- Data table plugin-->
    <script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
   
  </body>
</html>
