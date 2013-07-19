<?php 

	class Projects_model extends CI_Model {

		public function __construct() {

		}

		public function getProjects($page = 0, $perPage = 0, $sortingRow = null, $sortOrder = 'asc') {

			$projectsList = (object) array();
			
			$projectsList->rows = array();
			if( $sortingRow != "" )
				$this->db->order_by( $sortingRow, $sortOrder );			
			$projects = $this->db->get('projects', $perPage, $perPage*($page-1));

			foreach ($projects->result() as $project) {
				$projectsList->rows[] = $project;
			}

			$projectsList->page = $page;

			$projectsList->records = $this->db->count_all('projects');

			$projectsList->total = ceil($projectsList->records/$perPage);

			return $projectsList;

		}

		public function editProjects( $post = null, $user_id = 0 ) {
			$projectsList = (object) array();
			
			$projectsList->row = array();

            foreach ($post as $key => $value) {
            	if($key != "oper")
					$projectsList->row[$key] = $value;
			}

			if ($post['oper'] == 'edit') {

				$this->db->update('projects', $projectsList->row, array('id' => $projectsList->row['id']) ); 

			} elseif ($post['oper'] == 'add') {
				
				$projectsList->row['a3m_user_id'] = $user_id;
				$this->db->insert('projects', $projectsList->row);

			} elseif ($post['oper'] == 'del') {

				$this->db->delete('projects', array('id' => $projectsList->row['id'])); 

			}
			

		}

	}
?>