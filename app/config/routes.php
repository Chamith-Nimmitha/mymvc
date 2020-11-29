<?php 
	
	/**
	  * define routes here
	  * This roures are check top to bottom. So most specific routes must be in top.
	  */ 

	// homepage routes
	$routes[''] = "home/index";
	$routes['homepage'] = "home/index";
	$routes['school/contact'] = "home/contact";
	$routes['school/about'] = "home/about";
	$routes['settings/school'] = "home/settings_school";
	$routes['settings/notice'] = "home/settings_notice";

	// login routes
	$routes['login'] = "user/login";
	$routes['forget_password'] = "user/forget_password";
	$routes['verification_code'] = "user/verification_code";
	$routes['change_password'] = "user/change_password";
	$routes['login/$1'] = "user/login/$1";
	$routes['logout'] = "user/logout";

	// common routes
	$routes['dashboard'] = "user/dashboard";
	$routes['dashboard/$1'] = "user/dashboard/$1";
	$routes['profile'] = "user/profile";

	// admission routes
	$routes['student/registration'] = "admission/new_admission";

	// teacher routes
	$routes['teacher/list'] = "teacher/teacher_list_view";
	$routes['teacher/registration'] = "teacher/teacher_registration_form";
	$routes['teacher/update'] = "teacher/teacher_list_update";

	//classroom routes
		// write here

	// subject routes
	$routes['subject/list'] = "subject/subjectnew_view";
	$routes['subject/registration'] = "subject/subjectnew_add";
	$routes['subject/update'] = "subject/subjectnew_update";

	// student route
	$routes['student/list'] = "student/list";
	$routes['student/timetable/view/$1'] = "student/timetable_view/$1";
	$routes['profile/$1/$2'] = "user/profile/$1/$2";
	$routes['student/exam/$1'] = "student/exam/$1";
	$routes['student/delete/$1'] = "admin/student_delete/$1";

	// parent routes
		//write here

	// interview routes
		// write here

	// define as a global variable. Don't delete this
	$GLOBALS['routes'] = $routes;