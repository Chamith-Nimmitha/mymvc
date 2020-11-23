<?php include_once("session.php"); ?>
<?php require_once('../php/database.php')?>

<?php 
	$next_id = $con->get_next_auto_increment("interview_panel");
	$next_id = $next_id->fetch()['AUTO_INCREMENT'];

	if(isset($_POST['create'])){
		$data['name'] = $_POST['panel-name'];
		$data['grade'] = $_POST['grade'];
		$result = $con->insert("interview_panel",$data);

		if($result){
			foreach ($_POST as $key => $value) {
				if(strpos($key,"teacher") === 0 && $value !== ""){
					$result = $con->update("teacher",array("interview_panel_id"=>$next_id),array("id"=>$value));
				}
			}
			if($result){
				header("Location:interview_timetable.php?user_id=".$next_id);
			}
		}
	}else if(isset($_POST['update'])){
		$data['name'] = $_POST['panel-name'];
		$data['grade'] = $_POST['grade'];
		$result = $con->update("interview_panel",$data,array('id'=>$_GET['interview-panel-id']));

		if($result){
			foreach ($_POST as $key => $value) {
				if(strpos($key,"teacher") === 0){
					$result = $con->update("teacher",array("interview_panel_id"=>$next_id),array("id"=>$value));
				}
			}
			header("Location:interview_timetable.php?user_id=".$_GET['interview-panel-id']);
		}
	}

	if(isset($_GET['interview-panel-id'])){
		$con->where(array('id'=>$_GET['interview-panel-id']));
		$result_set = $con->select('interview_panel');
		if($result_set){
			$interview_panel = $result_set->fetch();
			$con->where(array('interview_panel_id'=>$_GET['interview-panel-id']));
			$interview_teachers = $con->select('teacher');
			$interview_teachers = $interview_teachers->fetchAll();
		}
	}
 ?>

<?php require_once('../templates/header.php')?>
<?php require_once('../templates/aside.php') ?>



<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<div>
		<h2>Create New Interview Panel</h2>
	</div>
	<form action="<?php echo set_url('pages/interview_panel_create.php'); if(isset($_GET['interview-panel-id'])){echo '?interview-panel-id='.$_GET['interview-panel-id'];} ?>" class="col-12" method="POST">
		<div class="col-12 col-lg-6 p-3">
			<fieldset>
				<legend>Basic Info</legend>
				<div class="form-group">
					<label for="panel-id">Panel ID</label>
					<input type="text" name="panel-id" id="panel-id" value="<?php if(isset($interview_panel['id'])){echo $interview_panel['id'];}else{ echo $next_id;} ?>" disabled="disabled">
				</div>

				<div class="form-group">
					<label for="panel-grade">Grade (<code title="required"> * </code>)</label>
					<select name="grade" id="grade" onchange="interview_panel_grade(this.value,'panel-name',<?php echo $next_id; ?>)">
						<option value="0" <?php if(!isset($interview_panel['grade'])){echo "selected='selected'";} ?>>Select ...</option>
						<option value="1" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "1"){echo "selected='selected'";} ?>>grade 1</option>
						<option value="2" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "2"){echo "selected='selected'";} ?>>grade 2</option>
						<option value="3" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "3"){echo "selected='selected'";} ?>>grade 3</option>
						<option value="4" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "4"){echo "selected='selected'";} ?>>grade 4</option>
						<option value="5" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "5"){echo "selected='selected'";} ?>>grade 5</option>
						<option value="6" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "6"){echo "selected='selected'";} ?>>grade 6</option>
						<option value="7" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "7"){echo "selected='selected'";} ?>>grade 7</option>
						<option value="8" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "8"){echo "selected='selected'";} ?>>grade 8</option>
						<option value="9" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "9"){echo "selected='selected'";} ?>>grade 9</option>
						<option value="10" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "10"){echo "selected='selected'";} ?>>grade 10</option>
						<option value="11" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "11"){echo "selected='selected'";} ?>>grade 11</option>
						<option value="12" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "12"){echo "selected='selected'";} ?>>grade 12</option>
						<option value="13" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "13"){echo "selected='selected'";} ?>>grade 13</option>
					</select>
				</div>
				<div class="form-group">
					<label for="panel-name">Panel Name</label>
					<input type="text" name="panel-name" id="panel-name" value="<?php if(isset($interview_panel['name'])){echo $interview_panel['name'];} ?>">
				</div>

			</fieldset>
		</div>
		<div class="col-12 col-lg-6 p-3">
			<fieldset class="col-12 flex-col">
				<legend>Teachers Info</legend>
				<div id="interview-teachers">
					<?php 

						if(isset($interview_teachers )){
							$i =1;
							foreach ($interview_teachers as $id) {
								$row = '<div id="teacherid-'.$i.'" class="form-group interview-teacher-id">';
								$row .= "<label for='teacher-".$i."'> Teacher ID (<code title=\"required\"> * </code>)</label>";
								$row .= '<input type="text" name="teacher-'.$i.'" id="teacher-'.$i.'" required="required" value="';
								$row .= $id['id'].'">';
								$row .= '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
								$row .= '<input type="hidden" name="hidden-teacher-'.$i.'" id="hidden-teacher-'.$i.'"  value="';
								$row .= $id['id'].'"';
								$row .= ' oninput="validate_user_input(this,7,7,0)"></div>';
								echo $row;
								$i+=1;
							}
						}else{
							echo '<div id="teacherid-1" class="form-group interview-teacher-id">
									<label for="teacher-1">Teacher ID (<code title="required"> * </code>)</label>
									<input type="text" name="teacher-1" id="teacher-1"  oninput="validate_user_input(this,7,7,0)">
									<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
								</div>
								<div id="teacherid-2" class="form-group  interview-teacher-id">
									<label for="teacherid-2">Teacher ID (<code title="required"> * </code>)</label>
									<input type="text" name="teacher-2" id="teacher-2"  oninput="validate_user_input(this,7,7,0)">
									<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
								</div>
								<div id="teacherid-3" class="form-group  interview-teacher-id">
									<label for="teacherid-3">Teacher ID (<code title="required"> * </code>)</label>
									<input type="text" name="teacher-3" id="teacher-3"  oninput="validate_user_input(this,7,7,0)">
									<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
								</div>';
						}
					 ?>
				</div>

				<div class=" form-group d-flex justify-content-end">
					<button type="button" class="btn btn-blue" id="add-teacher"  onclick="interview_add_teacher(this,'interview-teachers',4)">+add a teacher</button>
				</div>
				<hr>
				<div class="d-flex justify-content-end">
					<?php 
						if(isset($interview_panel['id'])){
							echo '<button type="submit" class="btn btn-blue" name="update" id="update">update</button>';
						}else{
							echo '<button type="submit" class="btn btn-blue" name="create" id="create">Create</button>';
						}
					 ?>
				</div>
			</fieldset>
		</div>
	</form>
</div>

<?php require_once("../templates/footer.php") ?>