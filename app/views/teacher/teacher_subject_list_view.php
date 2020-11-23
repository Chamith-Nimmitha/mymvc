<?php require_once("./session.php"); ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php 
	$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
	if(isset($_POST['submit'])){
		$teacher_id = $_POST['id'];
		$name_with_initials = $_POST['name'];
		$result = $con->select("teacher",array("id"=>$teacher_id));
		if($result && $result->rowCount() == 1){
			if(!empty($teacher_id) && !empty($name_with_initials)){
				try{
					$con->db->beginTransaction();
					foreach ($_POST as $key => $value) {
						if( strpos($key, "subject") === 0 && strpos($key, "id") !== False){
							if(!empty($value)){
								$result = $con->select("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$_POST["old-".$key]));
								if($result && $result->rowCount() >0){
									$result = $con->update("teacher_subject",array("subject_id"=>$value),array("teacher_id"=>$teacher_id, "subject_id"=>$_POST["old-".$key]));
									if(!$result){
										throw new PDOException("Subject update error.".$value	,1);
									}
								}else if($result){
									$result = $con->insert("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$value));
									if(!$result || $result->rowCount() ==0){
										throw new PDOException("Subject insertion error.",1);
									}
									$result = $con->select("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$value));
									if(!$result || $result->rowCount() !==1){
										throw new PDOException("Subject insertion error.",1);
									}
									$result = $result->fetch();
									$user_id = $result['id'];
									$result = $con->insert("normal_timetable",array("type"=>"subject", "user_id"=>$user_id));
									if(!$result || $result->rowcount() !== 1){
										throw new PDOException("Timetable creation error.fff",1);
									}
									$result = $con->select("normal_timetable",array("type"=>"subject", "user_id"=>$user_id));
									if(!$result || $result->rowcount() !== 1 ){
										throw new PDOException("Timetable creation error.qqqqq",1);
									}
									$timetable_id = $result->fetch()['id'];
									for ($i=1; $i <= 5; $i++) { 
										for ($j=1; $j <= 8; $j++) { 
											$result = $con->insert("normal_day",array("timetable_id"=>$timetable_id, "day"=>$day_map[$i], "period"=>$j));
											if(!$result || $result->rowCount() !== 1){
												throw new PDOException("Timetable creation error.",1);
											}
										}
									}

								}
							}else{
								throw new PDOException("Subject Id is empty.",1);
							}
						}
					}
					$info = "Successfully Update.";
					$con->db->commit();
				}catch (Exception $e){
					$con->db->rollback();
					$error = $e->getMessage();
				}
			}else{
				$error = "Please fill teacher ID or Name.";
			}
		}else{
			$error = "Invalid teacher ID";
		}
	}
	if(isset($_GET['teacher_id']) || $_SESSION['role'] === "teacher"){
		if(isset($_GET['teacher_id'])){
			$teacher_id = $_GET['teacher_id'];
		}else{
			$teacher_id = $_SESSION['user_id'];
		}
		$con->get(array('id','name_with_initials'));
		$teacher_info = $con->select("teacher",array("id"=>$teacher_id));
		if($teacher_info && $teacher_info->rowCount() == 1){
			$teacher_info = $teacher_info->fetch();
		}
		$result = $con->select("teacher_subject",array("teacher_id"=>$teacher_id));
		$subject_info = array();
		if($result && $result->rowCount() > 0){
			$result = $result->fetchAll();			
			try{
				foreach ($result as $sub) {
					$result = $con->select("subject",array("id"=>$sub['subject_id']));
					if($result && $result->rowCount() == 1){
						array_push($subject_info, $result->fetch());
					}else{
						throw new PDOException("Data getting failed.",1);
					}
				}
			}catch (Exception $e){
				$con->db->rollback();
				$error = $e->getMessage();
			}
		}
	}
 ?>
<?php 
	if(isset($_GET['teacher_id'])){
		$id = $_GET['teacher_id'];
	}else{
		$id = $_SESSION['user_id'];
	}
	$subjects = array();
	$result_set = $con->select("teacher_subject",array("teacher_id"=>$id));
	if($result_set && $result_set->rowCount()){
		$teacher_subject = $result_set->fetchAll();
		try{
			$con->db->beginTransaction();
			foreach ($teacher_subject as $result) {
				$result = $con->select("subject",array("id"=>$result['subject_id']));
				if($result && $result->rowCount() == 1){
					array_push($subjects, $result->fetch());
				}else{
					throw new PDOException("Subject id error...",1);
				}
			}
			$con->db->commit();
		}catch(Exception $e){
			$error = $e->getMessage();
			$con->db->rollback();
		}
	}
 ?>
<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>


<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($error)){
			echo "<p class='bg-red fg-white w-75 text-center p-2'>";
			echo $error."<br/>";
			echo "</p>";
		}
		if(isset($info)){
			echo "<p class='bg-green fg-white w-75 text-center p-2'>";
			echo $info."<br/>";
			echo "</p>";
		}
	 ?>
	
	<div class="col-8">
		<form method="post" class="col-12">
			<div class="col-12">
				<fieldset class="col-12">
					<legend>Teacher Info</legend>
					<div class="form-group">
						<label for="id">ID</label>
						<input type="text" name="id" placeholder="Teacher ID" value="<?php if(isset($teacher_info['id'])){echo $teacher_info['id'];} ?>" disabled="disabled">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" placeholder="Teacher Name" value="<?php if(isset($teacher_info['name_with_initials'])){echo $teacher_info['name_with_initials'];} ?>"  disabled="disabled">
					</div>
				</fieldset>
			</div>
		</form>
	</div>

	<hr class="w-100 mt-5">
	<div class="col-10">
		<?php if(isset($_GET['teacher_id'])){?>
			<div class="pt-5">
				<h2 style="color: darkblue;">Teacher Subject List</h2>
			</div>
		<?php }else{ ?>
			<div class="pt-5">
				<h2 style="color: darkblue;">My Subject List</h2>
			</div>
		<?php } ?>

		<hr class="w-100">
		<div class="p-5 col-12 col-md-12 text-center">
			<div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
				<?php 
					$table = "<table class='table-strip-dark'>";
					$table .= "<thead>
									<tr>
										<th>Subject ID</th>
										<th>Name</th>
										<th>Code</th>
										<th>Grade</th>
										<th>Student List</th>
										<th>Timetable</th>
									</tr>
								</thead>
								<tbody>";
					echo $table;
					if($subjects){
						for($i=0; $i < count($subjects);$i++) {
							$row ="<tr>";
							$row .= "<td>".$subjects[$i]['id']."</td>";
							$row .= "<td>".$subjects[$i]['name']."</td>";
							$row .= "<td>".$subjects[$i]['code']."</td>";
							$row .= "<td class='text-center'>".$subjects[$i]['grade']."</td>";
							$row .= "<td class='text-center'><a href='teacher_subject_student_list_view.php?id=".$teacher_subject[$i]['id']."' class='btn btn-blue t-d-none p-1'>List</a></td>";
							$row .= "<td class='text-center'><a href='teacher_subject_timetable.php?id=".$teacher_subject[$i]['id']."' class='btn btn-blue t-d-none p-1'>timetable</a></td>";
							$row .="</tr>";
							echo $row;
						}
						$_SESSION['back'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					}else{
						echo "<tr><td colspan=9 class='text-center bg-red'>Students not found...</td></tr>";
					}
					echo "</tbody>";
					echo "</table>";
				 ?>
			</div>
		</div>
	</div>

	<hr class="w-100 mt-5">

</div>
<?php require_once("../templates/footer.php"); ?>