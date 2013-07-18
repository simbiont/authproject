<?php 
class Projects extends CI_Controller {

	public function __construct() {

		parent::__construct();

	}

	public function index () {
		// TODO: main user's projects page

		$this->browse( 0 );		
	}

	public function ajax_json_provider_projects( $page = 0 ) {
		
		$page = $this->input->get('page');
		$limit = $this->input->get('rows');
		$sidx = $this->input->get('sidx');
		$sord = $this->input->get('sord');

		$this->load->model('projects_model');

		echo json_encode($this->projects_model->getProjects());

	}

	public function browse( $page = 0 ) {
		// TODO: display projects list

		if ($this->authentication->is_signed_in()) {
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		}
		else 
		{
			redirect("/");
		}

		$data['page'] = $page;

		$this->load->view( 'projects.php', $data );
	}

	public function add () {
		// TODO: add new project

	}

	public function edit( $id = null ) {

		try {
			if( !$id) {
				throw new Exception("Error: project id not specified.");				
			}
		} catch (Exception $e) {

			die( $e->getMessage() );

		}

	}


} ?>