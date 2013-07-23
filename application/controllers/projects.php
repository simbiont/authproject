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

				$users_list = $this->projects_model->getAllUsersList();

				$this->data['super'] = $this->is_super();
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
			// $user_id = $this->session->userdata('account_id');
			$date =  date('Y-m-d H:i:s');
			$this->projects_model->addNewProject($projectName, $user_id, $date);
			redirect('projects');
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
		$user_id = $this->session->userdata('account_id');
		$row_page = $this->input->get('page');
		$limit = $this->input->get('rows');
		$sidx = $this->input->get('sidx');
		$sord = $this->input->get('sord');
		$is_super = $this->is_super();

		echo json_encode( $this->projects_model->getProjects( $is_super, $page, $user_id, $row_page, $limit, $sidx, $sord ) );

	}

	// View single project
	public function view( $page = 0, $user_id = null ) {
		

		if ($this->authentication->is_signed_in()) {
			if( !$user_id ) {
				$user_id = $this->session->userdata('account_id');
			   
			} else {
				// TODO: check if not an admin prevent projects displaying

			}
		} else {
			return $this->access_denied();
		}
		$this->data['super'] = $this->is_super();
		$this->data['page'] = $page;
		$this->master_view( 'projects' );

	}

	// Get user projects
	public function ajax_user_projects() {
		$this->load->model('projects_model');

		$id = $this->input->post('user_id');
		echo json_encode($this->projects_model->getProjectsList($id));
	}


	public function csvUpload($page = 0){
		$this->load->model('projects_model');		
		$this->load->library('Csv_parse');

		$config['upload_path'] = './resource/upload/';
		$config['allowed_types'] = '*';
		// $config['file_name'] = 'csv_upload_'. date("m-d-y").'.csv';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('csvUpload')) {
			$this->session->set_flashdata('uploadError', $this->upload->display_errors());
			redirect('projects');
		} else {
			$data = $this->upload->data();			
			$csv = new Csv_parse;
			$csv->load($data['full_path']);
			$headers = $csv->getHeaders();
			$count   = $csv->countRows(); // total rows
			$user_id = $this->session->userdata('account_id');
			for ($i=0; $i < $count; $i++) {
				$row = $csv->getRow($i);
				$data = array(
					'service' => $row[0],
					'date' => $row[1],
					'initials' => $row[2],
					'description' => $row[3],
					'hours' => $row[4],
					'rate' => $row[5],
					'amount' => $row[6],
					'oper' => 'add'
				);
				$this->projects_model->editProjects($data, $user_id, $page);			
			}
			redirect('projects/view/'.$page);
		}

	}

} ?>