<?php 
class Projects extends MY_Controller {

	public function __construct() {

		parent::__construct();

	}

	public function index () {
		// TODO: main user's projects page
		$this->browse();
	}

	public function browse( $page = 0, $user_id = null ) {

		if ($this->authentication->is_signed_in()) {
			if( !$user_id ) {
				$user_id = $this->session->userdata('account_id');
			   
			} else {
				// TODO: check if not an admin prevent projects displaying
			}
		} else {
			return $this->access_denied();
		}
		$this->load->model('projects_list_model');
		$projects_list = $this->projects_list_model->getProjectsList( $user_id );

		$this->data['list'] = $projects_list;

		$this->load->helper('form');
		$this->data['form_attr'] = array('id' => 'project_form');
		$this->data['placeholder'] = 'placeholder="Project Name" id="project_name"';
		$this->data['submit_attr'] = array( 'name' => 'create_project', 'class' => 'btn btn-success', 'value' => 'Create' );
		$this->master_view( 'project_list' );

	}

	public function add ( $user_id = null ) {

		if ( !$this->authentication->is_signed_in() ) {
			return $this->access_denied();
		} else {
			// $this->data['account'] = $this->account_model->get_by_id( $this->session->userdata('account_id') );
		}

		// TODO: add new project
		$this->load->model('projects_list_model');
		$projectName = $this->input->post('project_name');
		$user_id = $this->session->userdata('account_id');
		$date =  date('Y-m-d H:i:s');
		$this->projects_list_model->addNewProject($projectName, $user_id, $date);
		redirect('projects');

	}

	public function ajax_json_edit_projects( $page = 0 ) {
		$this->load->model('projects_model');

		$post = $this->input->post();
		$user_id = $this->session->userdata('account_id');
		
		$this->projects_model->editProjects($post, $user_id, $page);
	}

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
		$this->data['page'] = $page;
		$this->master_view( 'projects' );

	}

} ?>