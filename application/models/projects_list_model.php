<?php 

	class Projects_list_model extends CI_Model {

		public function __construct() {

		}

		public function addNewProject( $name = null, $user_id = 0, $date = null, $file_id = '' ) {
			$newProject = array();
			$newProject['project_name'] = $name;
			$newProject['user_id'] = $user_id;
			$newProject['date'] = $date;
			$newProject['file_id'] = $file_id;
			$this->db->insert('project_list', $newProject);
		}

		public function getProjectsList( $user_id = 0 ) {

			$projectsList = (object) array();
			
			$projectsList->rows = array();
			if( $user_id != 0 )
				$projects = $this->db->get_where('project_list', array('user_id' => $user_id));

			foreach ($projects->result() as $project) {
				$projectsList->rows[] = $project;
			}


			$projectsList->total = $this->db->count_all('project_list');

			return $projectsList;

		}
	}
?>