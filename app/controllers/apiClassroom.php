<?php 

	class apiClassroom extends Controller{
		public function __construct() {
			parent::__construct();
		}

		public function get_grades($category){
			$data['category'] = $category;
			$this->load->view("../../public/assets/api/classrooms",$data);
		}

		public function search(){
			$post = json_decode(file_get_contents("php://input"));

			$id = $post->id;
			if(empty($id) && strlen($id) ===0){
				$id = NULL;
			}
			$grade = $post->grade;
			if($grade === NULL || $grade === "all"){
				$grade = NULL;
			}
			$classroom = $post->classroom;
			if($classroom === NULL || $classroom === "all"){
				$classroom = NULL;
			}

			$start = 0;
			if(isset($post->per_page)){
				$per_page = $post->per_page;
			}else{
				$per_page = PER_PAGE;
			}
			if(isset($post->page)){
				$page = $post->page;
				$start = ($page-1) * $per_page;
			}else{
				$page = 1;
			}
			$this->load->model("classrooms");
			$result_set = $this->load->classrooms->get_classroom_list($start,$per_page,$id,$grade,$classroom);
			$data['count'] = $this->load->classrooms->get_count()->fetch()['count'];

			if($result_set && !empty($result_set)){
				$body = "";
				$grade = 0;
				foreach ($result_set as $result) {
					if($grade !== 0 && $grade != $result['grade']){
	        			$body .= "<tr><td colspan=8 class='text-center bg-gray'></td></tr>";
	        		}
					$body .="<tr>";
					$body .= "<td>".$result['id']."</td>";
					$body .= "<td>".$result['grade']."</td>";
					$body .= "<td>".$result['class']."</td>";
					$body .= "<td>".$result['class_teacher_id']."</td>";
					$body .= "<td>
								<div class='login_buttons col-12 col-md-12 d-flex justify-content-center align-items-center'>
	                				<a class='btn btn-blue p-1' href='".set_url('classroom/student/list/'.$result['id'])."'>List</a>";
	                				if($_SESSION['role']==='admin'){
	                					$body .= "<a class='btn btn-blue p-1 ml-3' href='".set_url('classroom/student/add/'.$result['id'])."'>Add</a>";
	                				}

	    				$body .="</div>
							</td>";
					$body .= "<td class='text-center'>";
						if($_SESSION['role']==='admin'){
                			$body .= "<a class='btn btn-blue p-1' href='". set_url('classroom/timetable/'.$result['id'])."'>View</a>";
            			}else{
                			$body .= "<a class='btn btn-blue p-1' href='".set_url('classroom/timetable/view/'.$result['id'])."'>View</a>";
            			}
					$body .= "</td>";
                    if($_SESSION['role']==='admin'){							
						$body .= "<td>
									<div class='login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center'>
		                				<a class='btn btn-blue p-1' href='".set_url('classroom/update/'.$result['id'])."'>Update</a>
				    				</div>
								</td>";
						$body .= "<td>
									<div class='login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center'>
		                				<a class='btn btn-blue p-1' href='".set_url('classroom/subjects/'.$result['id'])."'>Subjects</a>
				    				</div>
								</td>";
						$body .= "<td>
									<div class='login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center'>
										<a class='btn p-1' title='Delete' href='".set_url('classroom/delete/'.$result['id']) ."' onclick=\"show_dialog(this,'Delete message','Are you sure to delete?')\"><i class='fas fa-trash delete-button'></i></a>
				    				</div>
								</td>";
					}
					$body .= "</tr>";
					$grade = $result['grade'];
				}
				$data['body'] = $body;
				echo json_encode($data);
			}else{
				$body =  "<tr><td colspan=8 class='text-center bg-red'>Classrooms not found...</td></tr>";
				$data['body'] = $body;
				$data['count'] = 0;
				echo json_encode($data);
			}
		}
	}

 ?>