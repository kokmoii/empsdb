<?php session_start();
//error_reporting(0);
include  'include/config.php';
if(strlen($_SESSION["Empid"])==0)
    {   
header('location:index.php');
}
else{


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
            <h3 align="center"> Salary Details</h3>
            <hr />
            <div class="tile-body">
               <?php
                  $sid=$_GET['id'];
                $sql="SELECT salary,allowancesalary,total,tbladdsalary.create_date,
tbldepartment.DepartmentName,tblemployee.EmpID,fname,lname,email,mobile,country,state,city,address,photo,dob,date_of_joining FROM tbladdsalary
left join tblemployee on tbladdsalary.empid=tblemployee.EmpId
left join tbldepartment on tblemployee.department_name=tbldepartment.id
where tbladdsalary.id=:sid";
                $query= $dbh->prepare($sql);
                $query->bindParam(':sid',$sid, PDO::PARAM_STR);
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
<th>Mobile</th> <td><?php echo $result->mobile;?></td>

</tr>


<tr>
  <th colspan="4" style="font-size:20px; color:blue;">Salary Related Info</th>
</tr>


<tr>
  <th>Salary</th>
  <td><?php echo $result->salary;?></td>
  <th>Allowance</th>
  <td><?php echo $result->allowancesalary;?></td>
</tr>
<tr>
<th>Total</th>
<td><?php echo $result->total;?></td>
<th>Creation Date</th>
<td><?php echo $result->create_date;?></td>
</tr>

</tbody>
</table>
<?php } } ?>


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
<?php } ?>