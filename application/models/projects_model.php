<?php 

	class Projects_model extends CI_Model {

		public function __construct() {

		}

		public function getProjects($page = 0, $perPage = 0, $sortingRow = null, $sortOrder = 'asc') {

			$projectsList = (object) array();
			
			$projectsList->rows = array();

			$projects = $this->db
				->select('*')
				->from('projects')->get();

			foreach ($projects->result() as $project) {
				$projectsList->rows[] = $project;
			}

			$projectsList->page = $page;		
			$projectsList->records = $projects->num_rows();					
			$projectsList->total = 15;

			return $projectsList;

			//echo '<pre>' . print_r($projectsList , true ) . '</pre>';



		}

	}
?>