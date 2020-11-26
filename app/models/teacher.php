<?php 
	
	class TeacherModel extends Model{
		// for keep track number of students logged at this time
		public static $num_of_students =0;
		private $id;
		private $name_with_initials;
		private $email;
		private $first_name;
		private $middle_name;
		private $last_name;
		private $nic;
		private $grade;
		private $class;
		private $gender;
		private $dob;
		private $address;
		private $contact_number;
		private $profile_photo;
		private $is_deleted;
		private $classroom_id;
		private $interview_panel_id;
		private $table;
		public function __construct() {
			$this->table = "teacher";
			parent::__construct();
		}

		// set data using teacehr id
		public function set_by_id($id){
			$data = $this->con->select($this->table, array("id"=>$id));
			if($data && $data->rowCount() == 1){
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$c = $this->get_classroom_object();
				if($c){
					$this->grade = $c->get_grade();
					$this->class = $c->get_class();
				}
				unset($c);
				return TRUE;
			}else{
				return FALSE;
			}
		}
		// set data using teacher email
		public function set_by_email($email){
			$data = $this->con->select($this->table, array("email"=>$email));
			if( $data && $data->rowCount() == 1){
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$c = $this->get_classroom_object();
				if( $c->get_grade() !== NULL){
					$this->grade = $c->get_grade();
				}
				$this->class = $c->get_class();
				unset($c);
				return TRUE;
			}else{
				return FLASE;
			}
		}

		public function get_id(){return $this->id;}
		public function get_name(){return $this->name_with_initials;}
		public function get_first_name(){return $this->first_name;}
		public function get_middle_name(){return $this->middle_name;}
		public function get_last_name(){return $this->last_name;}
		public function get_email(){return $this->email;}
		public function get_nic(){return $this->nic;}
		public function get_contact_number(){return $this->contact_number;}
		public function get_username(){return $this->username;}
		public function get_grade(){return $this->grade;}
		public function get_class(){return $this->class;}
		public function get_gender(){return $this->gender;}
		public function get_address(){return $this->address;}
		public function get_dob(){return $this->dob;}
		public function get_profile_photo(){return $this->profile_photo;}
		public function get_parent_id(){return $this->parent_id;}
		public function get_classroom_id(){return $this->classroom_id;}
		public function get_interview_panel_id(){return $this->interview_panel_id;}
		public function get_state(){return $this->state;}

		//get classroom object which contains classroom details
		public function get_classroom_object(){
			$this->con->get(['id']);
			$result = $this->con->select("classroom",['class_teacher_id'=>$this->id]);
			if($result && $result->rowCount() === 1){
				$this->classroom_id = $result->fetch()['id'];
				require_once(MODELS."classroom.php");
				$classroom = new ClassroomModel();
				$classroom->set_by_id($this->classroom_id);
				return $classroom;
			}else{
				return FALSE;
			}
		}

		public function get_data(){
			$data['id'] = $this->id;
			$data['name_with_initials'] = $this->name_with_initials;
			$data['email'] = $this->email;
			$data['first_name'] = $this->first_name;
			$data['middle_name'] = $this->middle_name;
			$data['last_name'] = $this->last_name;
			$data['grade'] = $this->grade;
			$data['class'] = $this->class;
			$data['gender'] = $this->gender;
			$data['dob'] = $this->dob;
			$data['address'] = $this->address;
			$data['contact_number'] = $this->contact_number;
			$data['profile_photo'] = $this->profile_photo;
			$data['classroom_id'] = $this->classroom_id;
			$data['interview_panel_id'] = $this->interview_panel_id;
			$data['is_deleted'] = $this->is_deleted;
			return $data;
		}
	}