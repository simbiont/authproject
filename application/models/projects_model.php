<?php 

	class Projects_model extends CI_Model {

		public function __construct() {

		}

		public function getTitle( $id = 0 ) {
			return $list = $this->db->get_where('project_list', array('id' => $id))->row()->project_name;
		}

		public function getProjects( $is_super = FALSE, $page = 0, $row_page = 0, $perPage = 0, $sortingRow = null, $sortOrder = 'asc' ) {

			$projectsList = (object) array();
			
			$projectsList->rows = array();
			if( $sortingRow != "" )
				$this->db->order_by( $sortingRow, $sortOrder );

			$projects = $this->db->get_where('projects', array( 'project_id' => "$page" ), $perPage, $perPage*($row_page-1));
			foreach ($projects->result() as $project) {
				$projectsList->rows[] = $project;
			}

			$projectsList->page = $row_page;
			$this->db->like(array( 'project_id' => "$page" ));
			$this->db->from('projects');

			$projectsList->records = $this->db->count_all_results();

			$projectsList->total = ceil($projectsList->records/$perPage);

			return $projectsList;

		}

		public function editProjects( $post = null, $user_id = 0, $page = 0 ) {
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
				$projectsList->row['project_id'] = $page;
				$this->db->insert('projects', $projectsList->row);

			} elseif ($post['oper'] == 'del') {

				$this->db->delete('projects', array('id' => $projectsList->row['id'])); 

			}
			

		}
		public function addNewProject( $name = null, $user_id = 0, $date = null, $file_id = '' ) {
			$newProject = array();
			$newProject['project_name'] = $name;
			$newProject['user_id'] = $user_id;
			$newProject['date'] = $date;
			$newProject['file_id'] = $file_id;
			$this->db->insert('project_list', $newProject);
			return $this->db->insert_id();
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
		public function getAllUsersList( $id = 0 ) {

			$UsersList = (object) array();
			
			$UsersList->rows = array();
			$users = $this->db->get_where('a3m_account', array( 'id !=' => $id ));

			foreach ($users->result() as $user) {
				$UsersList->rows[] = $user;
			}

			return $UsersList;

		}
		public function deleteProject( $id = 0 ) {
			$this->db->delete('project_list', array('id' => $id));
			$this->db->delete('projects', array('project_id' => $id));
			return true;
		}

		public function getDropdown() {
			return $list = $this->db->get_where('admin_settings', array('id' => '1'))->row()->dropdown_list;
		}

	}
?>