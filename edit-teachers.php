<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{

$Tid=intval($_GET['Tid']);

if(isset($_POST['submit']))
{
$TeacherRef=$_POST['TeacherRef'];
$TeacherName=$_POST['TeacherName'];
$TeacherNum=$_POST['TeacherNum']; 
$TeacherEmail=$_POST['TeacherEmail']; 
$Gender=$_POST['Gender']; 
$TeacherClassId=$_POST['TeacherClassId']; 
$DOB=$_POST['DOB']; 
$Status=$_POST['Status'];
$sql="update tblteachers set TeacherRef=:TeacherRef,TeacherName=:TeacherName,TeacherNum=:TeacherNum,TeacherEmail=:TeacherEmail,Gender=:Gender,TeacherDOB=:DOB,Status=:Status where id=:Tid ";
$query = $dbh->prepare($sql);
$query->bindParam(':TeacherRef',$TeacherRef,PDO::PARAM_STR);
$query->bindParam(':TeacherName',$TeacherName,PDO::PARAM_STR);
$query->bindParam(':TeacherNum',$TeacherNum,PDO::PARAM_STR);
$query->bindParam(':TeacherEmail',$TeacherEmail,PDO::PARAM_STR);
$query->bindParam(':Gender',$Gender,PDO::PARAM_STR);
$query->bindParam(':DOB',$DOB,PDO::PARAM_STR);
$query->bindParam(':Status',$Status,PDO::PARAM_STR);
$query->bindParam(':Tid',$Tid,PDO::PARAM_STR);
$query->execute();

$msg="Teacher info updated successfully";
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin| Edit Student < </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Teachers Registration</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                
                                        <li class="active">Teachers Registration</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Fill the Teacher info</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="form-horizontal" method="post">
<?php 

$sql = "SELECT tblteachers.TeacherRef, tblteachers.TeacherName,tblteachers.TeacherNum,tblteachers.RegDate,tblteachers.Status,tblteachers.TeacherEmail,tblteachers.Gender,tblteachers.TeacherDOB,tblclasses.ClassName,tblclasses.Section from tblteachers join tblclasses on tblclasses.id=tblteachers.TeacherClassId where tblteachers.id=:Tid";
$query = $dbh->prepare($sql);
$query->bindParam(':Tid',$Tid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>


<div class="form-group">
<label for="default" class="col-sm-2 control-label">Teacher Ref</label>
<div class="col-sm-10">
<input type="text" name="TeacherRef" class="form-control" id="TeacherRef" value="<?php echo htmlentities($result->TeacherRef)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Teacher Name</label>
<div class="col-sm-10">
<input type="text" name="TeacherName" class="form-control" id="TeacherName" value="<?php echo htmlentities($result->TeacherName)?>" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Email</label>
<div class="col-sm-10">
<input type="email" name="TeacherEmail" class="form-control" id="TeacherEmail" value="<?php echo htmlentities($result->TeacherEmail)?>" required="required" autocomplete="off">
</div>
</div>



<div class="form-group">
<label for="default" class="col-sm-2 control-label">Gender</label>
<div class="col-sm-10">
<?php  $gndr=$result->Gender;
if($gndr=="Male")
{
?>
<input type="radio" name="Gender" value="Male" required="required" checked>Male <input type="radio" name="Gender" value="Female" required="required">Female <input type="radio" name="Gender" value="Other" required="required">Other
<?php }?>
<?php  
if($gndr=="Female")
{
?>
<input type="radio" name="Gender" value="Male" required="required" >Male <input type="radio" name="Gender" value="Female" required="required" checked>Female <input type="radio" name="Gender" value="Other" required="required">Other
<?php }?>
<?php  
if($gndr=="Other")
{
?>
<input type="radio" name="Gender" value="Male" required="required" >Male <input type="radio" name="Gender" value="Female" required="required">Female <input type="radio" name="Gender" value="Other" required="required" checked>Other
<?php }?>


</div>
</div>

<div class="form-group">
                                                        <label for="default" class="col-sm-2 control-label">Class</label>
                                                        <div class="col-sm-10">
<input type="text" name="classname" class="form-control" id="classname" value="<?php echo htmlentities($result->ClassName)?>(<?php echo htmlentities($result->Section)?>)" readonly>
                                                        </div>
                                                    </div>

<div class="form-group">
                                                        <label for="date" class="col-sm-2 control-label">DOB</label>
                                                        <div class="col-sm-10">
                <input type="date"  name="DOB" class="form-control" value="<?php echo htmlentities($result->TeacherDOB)?>" id="date">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
<label for="default" class="col-sm-2 control-label">Reg Date: </label>
<div class="col-sm-10">
<?php echo htmlentities($result->RegDate)?>
</div>
</div>


<div class="form-group">
<label for="default" class="col-sm-2 control-label">Status</label>
<div class="col-sm-10">
<?php  $stats=$result->Status;
if($stats=="1")
{
?>
<input type="radio" name="Status" value="1" required="required" checked>Active <input type="radio" name="Status" value="0" required="required">Block 
<?php }?>
<?php  
if($stats=="0")
{
?>
<input type="radio" name="Status" value="1" required="required" >Active <input type="radio" name="Status" value="0" required="required" checked>Block 
<?php }?>



</div>
</div>

<?php }} ?>                                                    

                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    </body>
</html>
<?PHP } ?>
