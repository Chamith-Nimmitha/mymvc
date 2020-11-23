<?php include_once("session.php"); ?>
<?php
    $con = mysqli_connect("localhost", "root", "", "sms-final");

    $result_set = mysqli_query($con, "SELECT * FROM subject");

?>

<?php require_once("../templates/header.php") ;?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('pages/student_list.php'); ?>" method="get" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="subject-id">Subject ID/Name/Code</label>
						<input type="text" name="subject-id" id="subject-id" placeholder="subject ID/Name/Code" value="<?php if(isset($_GET['subject-id'])){echo $_GET['subject-id'];} ?>" >
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="grade" class="mr-3 d-normal">Grade : </label>
						<select name="grade" id="grade" style="width: 100px">
							<option value="all" <?php if(isset($_GET['grade'])){if($_GET['grade'] == "all"){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
							<option value="1" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "1")){echo 'selected="selected"';} ?> >1</option>
							<option value="2" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "2")){echo 'selected="selected"';} ?> >2</option>
							<option value="3" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "3")){echo 'selected="selected"';} ?> >3</option>
							<option value="4" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "4")){echo 'selected="selected"';} ?> >4</option>
							<option value="5" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "5")){echo 'selected="selected"';} ?> >5</option>
							<option value="6" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "6")){echo 'selected="selected"';} ?> >6</option>
							<option value="7" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "7")){echo 'selected="selected"';} ?> >7</option>
							<option value="8" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "8")){echo 'selected="selected"';} ?> >8</option>
							<option value="9" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "9")){echo 'selected="selected"';} ?> >9</option>
							<option value="10" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "10")){echo 'selected="selected"';} ?> >10</option>
							<option value="11" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "11")){echo 'selected="selected"';} ?> >11</option>
							<option value="12" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "12")){echo 'selected="selected"';} ?> >12</option>
							<option value="13" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "13")){echo 'selected="selected"';} ?> >13</option>
						</select>
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="medium" class="mr-3 d-normal">Medium:</label>
						<select name="medium" id="medium">
							<option value="all" <?php if(isset($_GET['medium']) && ($_GET['medium'] == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="sinhala" <?php if(isset($_GET['medium']) && ($_GET['medium'] == "sinhala")){echo 'selected="selected"';} ?> >Sinhala</option>
							<option value="english" <?php if(isset($_GET['medium']) && ($_GET['medium'] == "english")){echo 'selected="selected"';} ?> >English</option>
							<option value="tamil" <?php if(isset($_GET['medium']) && ($_GET['medium'] == "tamil")){echo 'selected="selected"';} ?> >Tamil</option>
						</select>				
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
				</div>
			</form>
		</div>

		<div class="col-11 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
		    <table class="table-strip-dark">
			    <caption class="p-5"><b>ALL SUBJECTS</b></caption>
			    <thead>
				    <tr>
						<th>SUBJECT ID</th>
						<th>GRADE</th>
						<th>MEDIUM</th>
						<th>SUBJECT NAME</th>
					    <th>SUBJECT CODE</th>
					    <th>UPDATE</th>
					    <th>DELETE</th>
				    </tr>
			    </thead>
			    
                <tbody>

				<?php 
				foreach ($result_set as $result) {
                ?>
					<tr>
						<td class="text-center"><?php echo $result['id']; ?></td>
						<td class="text-center"><?php echo $result['grade']; ?></td>
						<td class="text-center"><?php echo $result['medium']; ?></td>
						<td class="text-center"><?php echo $result['name']; ?></td>
						<td class="text-center"><?php echo $result['code']; ?></td>
						
						
						<td class="text-center">
							<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
                				<a class="btn btn-blue" href="subjectnew-update.php?id=<?php echo $result['id']; ?> ">Update</a>
		    				</div>
						</td>

						<td class="text-center">
							<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
								<a class="btn btn-lightred" href="subjectnew-delete.php?id=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
		    				</div>
						</td>
					</tr>
				<?php
				}
                ?>
                 
                </tbody>
			</table>
		</div>  
            <div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
                <a class="btn btn-blue" href="<?php echo set_url('pages\subjectnew-add.php'); ?> ">Add Subject</a>
		    </div>

</div>

<?php require_once("../templates/footer.php") ;?>


<?php