<?php 
class Users extends MY_Controller {

	public function __construct() {

		parent::__construct();

	}

	public function index () {
		// TODO: main user's users page
		$this->browse();
	}

	public function browse( $page = 0, $user_id = null ) {

		if ($this->authentication->is_signed_in() && $this->is_super()) {
			if( !$user_id ) {
				$user_id = $this->session->userdata('account_id');
			   
			} else {
				// TODO: check if not an admin prevent users displaying

			}
		} else {
			return $this->access_denied();
		}

		$this->data['page'] = $page;

		$this->master_view( 'user_list' );
	}

	public function add ( $user_id = null ) {

		if ( !$this->authentication->is_signed_in() || !$this->is_super() ) {
			return $this->access_denied();
		} else {
			// $this->data['account'] = $this->account_model->get_by_id( $this->session->userdata('account_id') );
		}

		// TODO: add new user

	}

	public function ajax_json_provider_users( $page = 0 ) {
		$this->load->model('users_model');
		$row_page = $this->input->get('page');
		$limit = $this->input->get('rows');
		$sidx = $this->input->get('sidx');
		$sord = $this->input->get('sord');
		$user_id = $this->session->userdata('account_id');
		echo json_encode( $this->users_model->getUsersList( $row_page, $limit, $sidx, $sord, $user_id ) );
	}

	public function ajax_json_edit_users( $page = 0 ) {
		$this->load->model('users_model');
		$this->load->model('account/account_model');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$id = $this->input->post('id');
		$olduser = $this->account_model->get_by_username($username);
		$oldemail = $this->account_model->get_by_email($email);

		$oper = $this->input->post('oper');
		if ($oper == "add") {
			if( !empty($olduser) ) {
				echo "This username allready exist!";
				return false;
			}
			if( !empty($oldemail) ) {
				echo "This email allready exist!";
				return false;
			}

			$newUserId = $this->users_model->addNewUser( $username, $email, $password );
			$this->account_model->set_role($newUserId, $role_id = 2);
		} elseif($oper == "edit") {
			$this->users_model->editUser( $username, $email, $id );
		} elseif ($oper == "delete") {
			# code...
		}
	}

	public function view( $page = 0, $user_id = null ) {
		

		if ($this->authentication->is_signed_in()) {
			if( !$user_id ) {
				$user_id = $this->session->userdata('account_id');
			   
			} else {
				// TODO: check if not an admin prevent users displaying

			}
		} else {
			return $this->access_denied();
		}
		$this->data['page'] = $page;
		$this->master_view( 'users' );

	}

	public function ajax_delete_users() {
		$this->load->model('users_list_model');
		$userIds = $this->input->post('users_ids');
		$array = explode(",", $userIds);
		foreach ($array as $key => $value) {
			$this->users_list_model->deleteuser($value);
		}

		echo json_encode($userIds);
	}

} ?>