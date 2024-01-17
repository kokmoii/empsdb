<?php 
//error_reporting(0);
include  'include/config.php';
$levid=$_GET['leaveid'];
if(isset($_POST['submit'])){
 $leaveID=$_POST['leaveID']; 
$leavestatus = $_POST['leavestatus'];
$remarks = $_POST['remarks'];

$sql="update tblleave set status=:leavestatus,adminremarks=:remarks where id=:leaveID";
$query = $dbh -> prepare($sql);
$query->bindParam(':leaveID',$leaveID,PDO::PARAM_STR);
$query->bindParam(':leavestatus',$leavestatus,PDO::PARAM_STR);
$query->bindParam(':remarks',$remarks,PDO::PARAM_STR);
$query -> execute();
echo "<script>alert('Leave status updated Successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a">
   <title>Employee management System</title>
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
               <?php
                  
                $sql="SELECT tblleave.id,tblleave.EmpID,tblleavetype.leaveType,FromDate,Todate,Description,tblleave.status,adminremarks,
fname,lname,tbldepartment.DepartmentName,fname,lname,email,mobile,country,state,city,address,photo,dob,date_of_joining FROM tblleave
left join tblemployee on tblleave.EmpID=tblemployee.EmpId
left join tblleavetype on tblleave.LeaveType=tblleavetype.id
left join tbldepartment on tblemployee.department_name=tbldepartment.id
where tblleave.id=:levid";
                $query= $dbh->prepare($sql);
                $query->bindParam(':levid',$levid, PDO::PARAM_STR);
                $query-> execute();
                $results = $query -> fetchAll(PDO::FETCH_OBJ);
                $cnt=1;
                if($query -> rowCount() > 0)
                {
                foreach($results as $result)
                {
                ?>
              <table class="table table-hover table-bordered">
                <tbody>
<tr>
  <th colspan="4" style="font-size:20px; color:blue;">Personal Info Info</th>
</tr>


<tr>
<th>EmpId</th> <td><?php echo $result->EmpID;?></td>
<th>Photo</th> <td><img src="<?php echo $result->photo;?>"width=150px; height="130px;"></td>
</tr>

<tr>
<th>First Name</th> <td><?php echo $result->fname;?></td>
<th>Last Name</th> <td><?php echo $result->lname;?></td>
</tr>
<tr>
<th>Department</th><td><?php echo $result->DepartmentName;?></td>
<th>Email</th><td><?php echo $result->email;?></td>
</tr>

<tr>
<th>Dob</th>
<td><?php echo $result->dob;?></td>
<th>Date Of Joining</th>
<td><?php echo $result->date_of_joining;?></td>
</tr>


<tr>
<th>Address</th>
<td><?php echo $result->address;?></td>
  <th>City</th>
<td><?php echo $result->city;?></td>
</tr>
<tr>

<th>State</th>
<td><?php echo $result->state;?></td>
<th>country</th>
<td><?php echo $result->country;?></td>
</tr>


<tr>
<th>Mobile</th> <td><?php echo $result->mobile;?></td>

</tr>


<tr>
  <th colspan="4" style="font-size:20px; color:blue;">Leave Related Info</th>
</tr>


<tr>
  <th>leaveType</th>
  <td><?php echo $result->leaveType;?></td>
  <th>Status</th>
  <td><?php echo $result->status;?></td>
</tr>
<tr>
<th>Leave From Date</th>
<td><?php echo $result->FromDate;?></td>
<th>Leave To Date</th>
<td><?php echo $result->Todate;?></td>
</tr>

<tr>
  <th>Leave Description</th>
<td colspan="3"><?php echo $result->Description;?></td>
</tr>
<tr>
  <th>Admin Remark</th>
<td colspan="3"><?php echo $result->adminremarks;?></td>
</tr>
</tbody>
</table>
<?php 
$statuss=$result->status;
if ($statuss=='Pending'):?>
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Take Action</button>
<?php endif;?>

            </div>

             <!--   here i am creating a modal popup code......... -->

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                            
                    </div>
                    <div class="modal-body">
                     <div class="row">
        
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Admin Remark</h3>
                         
            <div class="tile-body">
              <form class="row" method="post">
                <input type="hidden" name="leaveID" value="<?php echo $result->id;?>">
                <div class="form-group col-md-12">
                  <label class="control-label">Leave Status</label>
                  <select name="leavestatus" name="leavestatus" class="form-control">
                    <option value="">--select--</option>
                    <option value="Approved">Approved</option>
                    <option value="Reject">Reject</option>
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label class="control-label">Description</label>
               <textarea name="remarks" id="remarks" class="form-control"></textarea>
                </div>
                
                 
                <div class="form-group col-md-4 align-self-end">
                  <input type="Submit" name="submit" id="submit" class="btn btn-primary" value="Submit">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><?php  $cnt=$cnt+1; } } ?>
                </div>
            </div>
        </div>

     <!--    // end modal popup code........ -->
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
  
  </body>
</html>