<?php 
session_start();
error_reporting(0);
require_once('include/config.php');
if(strlen( $_SESSION["Empid"])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['Submit'])){

$userID=$_SESSION['id'];
$Empid=$_SESSION['Empid'];
$LeaveType=$_POST['LeaveType'];
$FromDate=$_POST['FromDate'];
$Todate=$_POST['Todate'];
$Description=$_POST['Description'];
$status='Pending';


$sql="INSERT INTO tblleave(userID,EmpID,LeaveType,FromDate,Todate,Description,status) 
Values(:userID,:Empid,:LeaveType,:FromDate,:Todate,:Description,:status)";
$query = $dbh -> prepare($sql);

$query->bindParam(':userID',$userID,PDO::PARAM_STR);
$query->bindParam(':Empid',$Empid,PDO::PARAM_STR);
$query->bindParam(':LeaveType',$LeaveType,PDO::PARAM_STR);
$query->bindParam(':FromDate',$FromDate,PDO::PARAM_STR);
$query->bindParam(':Todate',$Todate,PDO::PARAM_STR);
$query->bindParam(':Description',$Description,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query -> execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId>0)
{
echo "<script>alert('Leave Applied Successfully');</script>";
echo "<script>window.location.href='leave-history.php'</script>";
 }
else {

echo "<script>alert('Something went wrong please try again.');</script>";
 }

}
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
              <h2 align="center">Apply for Leave</h2>
              <hr />
             <!---Success Message--->  
          <?php if($msg){ ?>
          <div class="alert alert-success" role="alert">
          <strong>Well done!</strong> <?php echo htmlentities($msg);?>
          </div>
          <?php } ?>

          <!---Error Message--->
          <?php if($errormsg){ ?>
          <div class="alert alert-danger" role="alert">
          <strong>Oh snap!</strong> <?php echo htmlentities($errormsg);?></div>
          <?php } ?>
  
            <div class="tile-body">
              <form class="row" method="post">

                 

                <div class="form-group col-md-12">
                  <label class="control-label">Leave Type</label>
                 <select name="LeaveType" id="LeaveType" class="form-control" onChange="getdistrict(this.value);">
                  <option value="NA">--select--</option>
                  <?php 
                  $stmt = $dbh->prepare("SELECT * FROM tblleavetype ORDER BY leaveType");
                  $stmt->execute();
                  $departList = $stmt->fetchAll();
                  foreach($departList as $leaveType){
                  echo "<option value='".$leaveType['id']."'>".$leaveType['leaveType']."</option>";
                  }
                  ?>
                  </select>
                <span style="color:red;"><?php echo $deperrormsg;?></span>
                </div>
                

               

                 <div class="form-group col-md-6">
                  <label class="control-label">From Date</label>
                  <input class="form-control" type="date" name="FromDate" id="FromDate" placeholder="Enter your From Date" autocomplete="off">
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">To date</label>
                  <input type="date" name="Todate" id="Todate" class="form-control" placeholder="Enter your To date" autocomplete="off">
                </div>

                

             
                    <div class="form-group col-md-12">
                  <label class="control-label">Description</label>
                  <textarea name="Description" id="Description" placeholder="Enter your Description" class="form-control" autocomplete="offs"></textarea> 
                   </div>


               

                <div class="form-group col-md-4 align-self-end">
                  <input type="Submit" name="Submit" id="Submit" class="btn btn-primary" value="Submit">
                </div>
              </form>
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
  </body>
</html>
<?php } ?>
<!-- Script -->
 <script>
function getdistrict(val) {
$.ajax({
type: "POST",
url: "ajaxfile.php",
data:'category='+val,
success: function(data){
$("#package").html(data);
}
});
}
</script>