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
			$this->data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
            if( !$user_id ) {
                $user_id = $this->session->userdata('account_id');
            } else {
                // TODO: check if not an admin prevent projects displaying
            }
		} else {
			redirect("/");
		}

		$this->data['page'] = $page;

        $this->data['test_data'] = 'Test text';

		$this->master_view( 'projects' );
	}

	public function add ( $user_id = null ) {

        if ( !$this->authentication->is_signed_in() ) {
            redirect("/");
        } else {
            $this->data['account'] = $this->account_model->get_by_id( $this->session->userdata('account_id') );
        }

		// TODO: add new project

	}

	public function ajax_json_edit_projects( $page = 0 ) {
		$post = $this->input->post();
		$user_id = $this->session->userdata('account_id');
		$this->load->model('projects_model');
		$this->projects_model->editProjects($post, $user_id);
	}

    public function ajax_json_provider_projects( $page = 0 ) {

        $page = $this->input->get('page');
        $limit = $this->input->get('rows');
        $sidx = $this->input->get('sidx');
        $sord = $this->input->get('sord');

        $this->load->model('projects_model');

        echo json_encode($this->projects_model->getProjects($page, $limit, $sidx, $sord));

    }


} ?>