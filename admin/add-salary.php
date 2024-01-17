<?php 
error_reporting(0);
include  'include/config.php';
if(isset($_POST['Submit'])){

$Department = $_POST['Department'];
$name = $_POST['name'];
$salary = $_POST['salary'];
$AllowanceSalary = $_POST['AllowanceSalary'];
$totalsalary = $_POST['totalsalary'];

$sql="INSERT INTO tbladdsalary (Department, empid, salary, allowancesalary, total) 
Values(:Department,:name,:salary,:AllowanceSalary,:totalsalary)";
$query = $dbh -> prepare($sql);

$query->bindParam(':Department',$Department,PDO::PARAM_STR);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':salary',$salary,PDO::PARAM_STR);
$query->bindParam(':AllowanceSalary',$AllowanceSalary,PDO::PARAM_STR);
$query->bindParam(':totalsalary',$totalsalary,PDO::PARAM_STR);
$query -> execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId>0)
{
$msg= "Salary Add Successfully";
 }
else {

$errormsg= "Data not insert successfully";
 }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a">
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
              <h2 align="center"> Add Salary</h2>
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

                <div class="form-group col-md-6">
                  <label class="control-label">Department</label>
                 <select name="Department" id="Department" class="form-control" onChange="getdistrict(this.value);">
                  <option value="NA">--select--</option>
                  <?php 
                  $stmt = $dbh->prepare("SELECT * FROM tbldepartment ORDER BY DepartmentName");
                  $stmt->execute();
                  $departList = $stmt->fetchAll();
                  foreach($departList as $departname){
                  echo "<option value='".$departname['id']."'>".$departname['DepartmentName']."</option>";
                  }
                  ?>
                  </select>
                <span style="color:red;"><?php echo $deperrormsg;?></span>
                </div>
                
                   <div class="form-group col-md-6">
                  <label class="control-label">Name</label>
                  <select name="name" id="name" class="form-control">
                    <option value="">--Select--</option>
                  </select>
                   
                </div>

                 

                <div class="form-group col-md-6">
                  <label class="control-label">salary</label>
                  <input type="number" name="salary" id="salary" placeholder="Enter your salery" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Allowance Salary</label>
                 <input type="number"  name="AllowanceSalary" id="AllowanceSalary" placeholder="Enter your Allowance Salary" class="form-control">
                    
                </div>

                 <div class="form-group col-md-6">
                  <label class="control-label">Total</label>
                 <input type="text"  name="totalsalary" id="totalsalary" placeholder="Enter your Total salary" class="form-control" readonly>
                    
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

<!-- Script -->
 <script>
function getdistrict(val) {
$.ajax({
type: "POST",
url: "ajaxfile.php",
data:'Department='+val,
success: function(data){
$("#name").html(data);
}
});
}
</script>
<script>
$(function(){
            $('#salary, #AllowanceSalary').keyup(function(){
               var value1 = parseFloat($('#salary').val()) || 0;
               var value2 = parseFloat($('#AllowanceSalary').val()) || 0;
               $('#totalsalary').val(value1 + value2);
            });
         });

</script>