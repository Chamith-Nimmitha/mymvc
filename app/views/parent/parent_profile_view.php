<?php include_once("session.php"); ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php
	if(isset($_SESSION['role']) && $_SESSION['role'] == "parent"){
		$id = $_SESSION['user_id'];
		$profile_photo = $_SESSION['profile_photo'];
	}else{
		if(isset($_GET['parent_id'])){
			$result = $con->select("parent",array("id"=>$_GET['parent_id']));
			if($result->rowCount() == 1){
				$result = $result->fetch();
				$id = $result['id'];
				$profile_photo = $result['profile_photo'];
			}else{
				echo "You dont have permissions.";
			exit();	
			}
		}else{
			echo "You dont have permissions.";
			exit();
		}
	}

	$result = $con->select("parent",array("id"=>$id));
	if($result->rowCount() == 1){
		$result = $result->fetch();
	}
 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>


<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($all_errors) && (!empty($all_errors[0]) || !empty($all_errors[1]) || count($all_errors) > 2)){
			echo "<p class='bg-red col-8 p-3'>";
			foreach ($all_errors[0] as $error) {
				echo $error." is required.<br>";
			}
			if(isset($all_errors[1]) && !empty($all_errors[1])){
				foreach ($all_errors[1] as $error) {
					echo $error." length must less than ".$required_fields[$error].".<br/>";
				}
			}
			if(isset($all_errors[2])){
				echo $all_errors[2]."<br/>";
			}
			if(isset($errors) && !empty($errors[1])){
				foreach ($errors[1] as $error) {
					echo $error. "<br/>";
				}
			}
			echo "</p>";
		}
		if(isset($info)){
			echo "<p class='bg-green col-8 p-3'>";
			echo $info;
			echo "</p>";
		}
	 ?>
	<div class="mt-5">
		<h2>Student Profile</h2>
	</div>

	<div class="col-12">
			<form action="parent_profile.php" method="post" class="col-12" enctype="multipart/form-data">
				<div class="col-4 bg-red flex-col d-none d-md-flex align-items-center"  style=" padding-top: 100px;background: #ccf;">
					<div  class="col-8">
						<div  style="position: relative;">
							<img src="<?php echo set_url('img/parent_profile_photo/'.$profile_photo); ?>" alt="profile photo"  onclick="upload_profile_photo('profile-photo')" class="col-12">
							<label for="profile-photo" class="" style="position: absolute; bottom: 0px; right: 0px;">
								<img src="<?php echo set_url("img/camera.png"); ?>" alt="upload photo" style="width: 50px; height: 50px; cursor: pointer;">
							</label>
						</div>
						<input type="file" name="profile-photo" id="profile-photo" accept="image/jpg,image/jpeg,image/png" onchange="check_input_image(this)" class="d-none">
						<p class="bg-red fg-white p-2 d-none"></p>
					</div>
					<p id="profile-photo-error" class="d-none"></p>
					<div class=" pt-5">
						<p><code class="fs-18">ID : <?php echo $result["id"]; ?></code></p>
						<p><code class="fs-18">Name : <?php echo $result["name"]; ?></code></p>
					</div>

				</div>
				<div style="background: #88f;" class="col-12 col-md-8 d-flex flex-col align-items-center">
						<div class="form-group ">
							<label for="name-with-initials">Name With Initials</label>
							<input type="text"  placeholder="Name With Initials" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['name']));} ?>" disabled="disabled">
						</div>
						<div class="form-group ">
							<label for="address">Occupation</label>
							<input type="text" name="occupation" id="occupation" placeholder="Occupation" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['occupation']));} ?>" disabled="disabled">
						</div>
						<div class="form-group ">
							<label for="address">Address</label>
							<input type="text" name="address" id="address" placeholder="Address" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['address']));} ?>" disabled="disabled">
						</div>
						<div class="form-group ">
							<label for="email">Email</label>
							<input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($result)){echo  htmlspecialchars(stripslashes($result['email']));} ?>" disabled="disabled">
						</div>
						<div class="form-group ">
							<label for="contact-number">Contact Number</label>
							<input type="text" name="contact-number" id="contact-number" placeholder="Contact Number" value="<?php if(isset($result)){echo $result['contact_number'];} ?>"  disabled="disabled">
						</div>
				</div>
			</form>
	</div>
</div>


<?php require_once("../templates/footer.php"); ?>