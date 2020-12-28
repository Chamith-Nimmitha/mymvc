<script src="<?php echo BASE_URL.'public/assets/js/chartJs.js'; ?>"></script>
<script src="<?php echo BASE_URL.'public/assets/js/jquery.js'; ?>"></script>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($msg)){
			echo "<p class='d-flex justify-content-center bg-lightgreen fb-green col-8 p-3'>";
			echo $msg;
			echo "</p>";
		}  
	?>

	<div id="school-statistics" class="col-12  justify-content-center ">
		<h2 class="text-center p-5">School Statistics</h2>
		<div class="statistics-flex justify-content-center">	
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1 text-center">Total Students</h3>
				<span class="pt-1"><?php if(isset($count['student'])){echo $count['student']; } ?></span>
			</div> 
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1 text-center">Total Teachers</h3>
				<span class="pt-1"><?php if(isset($count['teacher'])){echo $count['teacher']; } ?></span>
			</div> 
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1  text-center">Total Subjects</h3>
				<span class="pt-1"><?php if(isset($count['subject'])){echo $count['subject']; } ?></span>
			</div> 
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1  text-center">Total Classrooms</h3>
				<span class="pt-1"><?php if(isset($count['classroom'])){echo $count['classroom']; } ?></span>
			</div>
			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
				<h3 class="bb pb-1  text-center">Total Parents</h3>
				<span class="pt-1"><?php if(isset($count['parent'])){echo $count['parent']; } ?></span>
			</div>
			
		</div>
	</div> <!-- #school-statistics -->

		<hr class="w-100">
	<div id="school-attendance" class="col-12 d-flex flex-col align-items-center">
		<h2 class="text-center p-5">School Attendance</h2>
		<div class="col-12 d-flex justify-content-center">
			<form action="">
				<div class="d-flex align-items-center">
					<label for="date">Date</label>
					<input type="date" name="date" id="date" class="ml-3 p-2">
				</div>
			</form>
		</div>
		<div class="col-12 d-flex align-items-center mt-5 justify-content-around">
			<div class="bg-white p-5" style="width: 45%;">
				<canvas id="dashboard_student_attendance_pie" width="100" height="100"></canvas>
			</div>
			<div class="bg-white p-5" style="width: 45%;">
				<canvas id="dashboard_teacher_attendance_pie" width="100" height="100"></canvas>
			</div>
		</div>
	</div> <!-- #school-attendance -->

	<div class="col-12 justify-content-around">
		<!-- classroom student attendance -->
		<div class="mt-5" style="width: 45%;">
			<div class="bg-white p-5 w-100">
				<canvas id="dashboard_classroom_student_attendance_bar" width="100" height="100"></canvas>
			</div>
		</div>

		<!-- school teacher attendance -->
		<div class="mt-5" style="width: 45%;">
			<div class="bg-white p-5 w-100">
				<canvas id="dashboard_teacher_attendance_bar" width="100" height="100"></canvas>
			</div>
		</div>
	</div>
	<div class="col-12 justify-content-around">
		<!-- subject grades pie -->
		<div class="mt-5" style="width: 45%;">
			<div class="bg-white p-5 w-100">
				<canvas id="subject_grades_pie" width="100" height="100"></canvas>
			</div>
		</div>

		<!-- classroom student attendance -->
		<div class="mt-5" style="width: 45%;">
			<div class="bg-white p-5 w-100">
				<canvas id="student_result_overview" width="100" height="100"></canvas>
			</div>
		</div>
	</div>

</div> <!-- #content -->