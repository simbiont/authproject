<?php 
class Projects extends MY_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->helper(array('form', 'url'));

	}

	public function index () {
		// TODO: main user's projects page
		$this->browse();
	}

	public function browse( $page = 0, $user_id = null ) {

		if ($this->authentication->is_signed_in()) {
			if( !$user_id ) {
				$user_id = $this->session->userdata('account_id');
			} 
			if ($this->is_super()) {
				$this->load->model('projects_model');



				$users_list = $this->projects_model->getAllUsersList($user_id);

				$this->data['list'] = $users_list;

				$this->load->helper('form');
				$this->data['form_attr'] = array('id' => 'project_form');
				$this->data['placeholder'] = 'placeholder="Project Name" id="project_name"';
				$this->data['submit_attr'] = array( 'name' => 'create_project', 'class' => 'btn btn-success', 'value' => 'Create' );

				$this->master_view( 'all_projects_list' );
			} else {
				$this->load->model('projects_model');
				
				$projects_list = $this->projects_model->getProjectsList( $user_id );
				$this->data['super'] = $this->is_super();
				$this->data['list'] = $projects_list;

				$this->load->helper('form');
				$this->data['form_attr'] = array('id' => 'project_form');
				$this->data['placeholder'] = 'placeholder="Project Name" id="project_name"';
				$this->data['submit_attr'] = array( 'name' => 'create_project', 'class' => 'btn btn-success', 'value' => 'Create' );
				$this->master_view( 'project_list' );
			}
		} else {
			return $this->access_denied();
		}


	}

	// Add new project
	public function add ( $user_id = null ) {

		if ( !$this->authentication->is_signed_in() ) {
			return $this->access_denied();
		} else {
			// TODO: add new project
			$this->load->model('projects_model');
			$projectName = $this->input->post('project_name');
			$project_user_id = $this->input->post('project_user_id');
			if( $project_user_id ) {
				$user_id = $this->input->post('project_user_id');
			} else {
				$user_id = $this->session->userdata('account_id');
			}
			$date =  date('Y-m-d H:i:s');
			$project_id = $this->projects_model->addNewProject($projectName, $user_id, $date);
			redirect('projects/view/'.$project_id);
		}

	}

	// Delete projects
	public function ajax_delete_projects() {
		$this->load->model('projects_model');
		$projectIds = $this->input->post('projects_ids');
		$array = explode(",", $projectIds);
		foreach ($array as $key => $value) {
			$this->projects_model->deleteProject($value);
		}

		echo json_encode($projectIds);
	}

	// Add/edit project field
	public function ajax_json_edit_projects( $page = 0 ) {
		$this->load->model('projects_model');

		$post = $this->input->post();
		$user_id = $this->session->userdata('account_id');
		
		$this->projects_model->editProjects($post, $user_id, $page);
	}

	// Get project fields
	public function ajax_json_provider_projects( $page = 0 ) {
		$this->load->model('projects_model');
		$row_page = $this->input->get('page');
		$limit = $this->input->get('rows');
		$sidx = $this->input->get('sidx');
		$sord = $this->input->get('sord');
		$is_super = $this->is_super();

		echo json_encode( $this->projects_model->getProjects( $is_super, $page, $row_page, $limit, $sidx, $sord ) );

	}

	// View single project
	public function view( $page = 0, $user_id = null ) {
		

		if ($this->authentication->is_signed_in()) {
			if( !$user_id ) {
				$user_id = $this->session->userdata('account_id');
			   
			}
			$permissions = $this->check_permission($user_id, $page);

	        if( !$page ) {
	            return $this->access_denied();
	        }

	        if ( !$this->is_super() && !$permissions) {
	            return $this->access_denied();
	        }
		} else {
			return $this->access_denied();
		}
		$this->load->model('projects_model');
		$this->load->model('settings_model');
		$this->data['title'] = $this->projects_model->getTitle($page);
		$this->data['page'] = $page;
		$dropdown_array = json_decode($this->projects_model->getDropdown(), true);
		$dropdown = "";
		foreach ($dropdown_array as $key => $value) {
			$dropdown .= $key.":".$value.";";
		}
		$this->data['dropdown'] = substr_replace($dropdown ,"",-1);
		$this->data['fields_num'] = $this->settings_model->getFieldsNum();
		$this->master_view( 'projects' );

	}

	// Get user projects
	public function ajax_user_projects() {
		$this->load->model('projects_model');

		$id = $this->input->post('user_id');
		echo json_encode($this->projects_model->getProjectsList($id));
	}

	// Check User Role
	public function check_permission( $user_id = null, $project_id = null ) {
        $query = $this->db->get_where('project_list', array('id' => $project_id, 'user_id' => $user_id));
        $result = $query->result();

        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

} ?>