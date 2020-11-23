<?php include_once("session.php"); ?>
<?php require_once("../php/database.php"); ?>
<?php require_once("../php/pagination.php"); ?>
<?php
    $con = mysqli_connect("localhost", "root", "", "sms-final");
    $start = 0;
	$per_page = 1;
	if(isset($_GET['per_page'])){
		$per_page=$_GET['per_page'];
	}
	if(isset($_GET['page'])){
		$start = (($_GET['page'] -1) * $per_page );
	}else{
		$_GET['page'] =1;
	}
	$limit = "$start, $per_page";

    $result_set = mysqli_query($con, "SELECT * FROM teacher LIMIT $limit");
    $con = new Database();
    $count = $con->pure_query("SELECT COUNT(*) AS count FROM teacher");
?>

<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('pages/teacher-all.php'); ?>" method="get" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="teacher-id">teacher ID/Name</label>
						<input type="text" name="teacher-id" id="teacher-id" placeholder="ID, Name" value="<?php if(isset($_GET['teacher-id'])){echo $_GET['teacher-id'];} ?>" >
					</div>
					<div class="ml-5">
						<label for="subject-id">Subject ID/Name</label>
						<input type="text" name="subject-id" id="subject-id" placeholder="ID, Name" value="<?php if(isset($_GET['subject-id'])){echo $_GET['subject-id'];} ?>">
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
				</div>
			</form>
		</div>

		<div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
		    <table class="table-strip-dark">
			    <caption class="p-5"><b>TEACHERS' LIST</b></caption>
			    <thead>
				    <tr>
						<th>ID</th>
						<th>NAME</th>
						<th>EMAIL</th>
						<th>CONTACT NUMBER</th>
					    <th>NIC</th>
					    <th>Subjects</th>
				    </tr>
			    </thead>
                <tbody>
				<?php 
				foreach ($result_set as $result) {
                ?>
					<tr>
						<td class="text-center"><?php echo $result['id']; ?></td>
						<td><?php echo $result['name_with_initials']; ?></td>
						<td><?php echo $result['email']; ?></td>
						<td class="text-center"><?php echo $result['contact_number']; ?></td>
						<td><?php echo $result['nic']; ?></td>
						<td class="text-center">
							<div>
                				<a class="btn btn-blue" href="teacher_subject_list_view.php?teacher_id=<?php echo $result['id']; ?> ">List</a>
		    				</div>
						</td>
					</tr>
				<?php
				}
                ?>
                </tbody>
        
			</table>
		</div>  
		<div class="d-flex justify-content-start col-12">	
				<?php if($count){
					$count = $count->fetch()['count'];
				 ?>
				<p class="mt-3 pl-5"><code><?php 	echo $count; ?> results found.</code> </p>	
			<?php } ?>
		</div>
                 <?php display_pagination($count,$_GET['page'],$per_page); ?>
             <?php if($_SESSION['role'] === "admin"){ ?>
	            <div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
	                <a class="btn btn-blue" href="<?php echo set_url('pages\teacher_registration_form.php'); ?> ">Register Teacher</a>
			    </div>
		   <?php } ?>
</div>
<?php require_once("../templates/footer.php") ;?>