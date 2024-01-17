<?php 
error_reporting(0);
include  'include/config.php';
if(isset($_POST['Submit'])){

$empid=$_POST['empcode'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$Department=$_POST['Department'];
$email=$_POST['email'];
$mobNumber=$_POST['mobNumber'];
$country=$_POST['country'];
$state=$_POST['state'];
$city=$_POST['city'];
$dob=$_POST['dob'];
$dateofjoining=$_POST['dateofjoining'];
$Photo=$_POST['Photo'];
$address=$_POST['address'];
$password=md5($_POST['password']);
$status=1;
if (empty($fname)) {
   $ferrormsg="Please Enter First Name";
}
elseif (empty($lname)) {
   $lerrormsg="Please Enter Last Name";
 }

 elseif ($Department=='NA') {
   $deperrormsg="Please select Department";
 }  


else{

$fileboard_resolution=time()."-".$_FILES["photograph"]["name"];
$tmp_namefileboard_resolution=$_FILES["photograph"]["tmp_name"];
$path="../uploads/".$fileboard_resolution;
$fileboard_resolution1=explode(".",$fileboard_resolution);
$ext=$fileboard_resolution1[1];
$allowed=array("jpg","png","JPEG","jpeg","JPG","PNG");
if(in_array($ext,$allowed))
{
move_uploaded_file($tmp_namefileboard_resolution,$path);


$sql="INSERT INTO tblemployee (EmpId,fname, lname, department_name, email, mobile, country, state, city, address, photo, dob, date_of_joining,password) 
Values(:empid,:fname,:lname,:Department,:email,:mobNumber,:country,:state,:city,:address,:Photo,:dob,:dateofjoining,:password)";
$query = $dbh -> prepare($sql);

$query->bindParam(':empid',$empid,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lname',$lname,PDO::PARAM_STR);
$query->bindParam(':Department',$Department,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobNumber',$mobNumber,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':state',$state,PDO::PARAM_STR);

$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':Photo',$path,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':dateofjoining',$dateofjoining,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);

$query -> execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId>0)
{
$msg= "Information Add Successfully";
 }
else {

$errormsg= "Data not insert successfully";
 }
}
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
                  <h2 align="center"> Add Employee</h2>
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
              <form class="row" method="post" enctype="multipart/form-data">

                 <div class="form-group col-md-12">
                  <label class="control-label">Emp ID</label>
                  <input  name="empcode" id="empcode" onBlur="checkAvailabilityEmpid()" class="form-control" type="text" autocomplete="off" required placeholder="Enter your EmpId">
                  <span id="empid-availability" style="font-size:12px;"></span> 
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">First Name</label>
                  <input class="form-control" name="fname" id="fname" type="text" placeholder="Enter your First Name" autocomplete="off">
                  <span style="color: red;"><?php echo $ferrormsg;?></span>
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Last Name</label>
                  <input class="form-control" name="lname" id="lname" type="text" placeholder="Enter your Last Name" autocomplete="off">
                  <span style="color: red;"><?php echo $lerrormsg;?></span>
                </div>

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
                  <label class="control-label">Email ID</label>
                 <input  name="email" type="email" id="email" class="form-control" placeholder="Enter your Email ID" onBlur="checkAvailabilityEmailid()" autocomplete="off" required>
                  <span id="emailid-availability" style="font-size:12px;"></span> 
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Mobile No</label>
                  <input type="text" name="mobNumber" id="mobNumber" class="form-control" placeholder="Enter your Mobile No" maxlength="10" autocomplete="off">
                </div>

                 <div class="form-group col-md-6">
                  <label class="control-label">Country</label>
                  <input type="text" name="country" placeholder="Enter your Country" id="country" class="form-control">
                   
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">State</label>
                  <input type="text" name="state" id="state" placeholder="Enter your State" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">City</label>
                 <input type="text"  name="city" id="city" placeholder="Enter your City" class="form-control">
                    
                </div>

                <div class="form-group col-md-6">
                  <label class="control-label">DOB</label>
                  <input type="date"  name="dob" id="dob" placeholder="Enter your Date Of Birth" class="form-control" autocomplete="off">
                   </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Date of Joining</label>
                  <input type="date"  name="dateofjoining" id="dateofjoining" placeholder="Enter your Date of Joining" class="form-control" autocomplete="off">
                   </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Photo</label>
                  <input type="file"  name="photograph" id="photograph" class="form-control">
                   </div>

                    <div class="form-group col-md-6">
                  <label class="control-label">Address</label>
                  <textarea name="address" id="address" placeholder="Enter your Address" class="form-control" autocomplete="offs"></textarea> 
                   </div>


                <div class="form-group col-md-6">
                  <label class="control-label">Password</label>
                  <input type="Password"  name="password" id="Password" placeholder="Enter your Password" class="form-control" autocomplete="off">
                   </div>

                <div class="form-group col-md-6">
                  <label class="control-label">Confirm Password</label>
                  <input type="password"  name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm Password">
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
data:'category='+val,
success: function(data){
$("#package").html(data);
}
});
}
</script>


 <script type="text/javascript">
function valid()
{
if(document.addemp.password.value!= document.addemp.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.addemp.confirmpassword.focus();
return false;
}
return true;
}
</script>

<script>
function checkAvailabilityEmpid() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'empcode='+$("#empcode").val(),
type: "POST",
success:function(data){
$("#empid-availability").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

<script>
function checkAvailabilityEmailid() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#emailid-availability").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
