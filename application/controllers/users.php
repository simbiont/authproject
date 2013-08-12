<?php 
class Users extends MY_Controller {

	public function __construct() {

		parent::__construct();

	}

	public function index () {

		$this->browse();
	}

	public function browse( $page = 0, $user_id = null ) {

		if ($this->authentication->is_signed_in() && $this->is_super()) {
			if( !$user_id ) {
				$user_id = $this->session->userdata('account_id');
			   
			}
		} else {
			return $this->access_denied();
		}

		$this->data['page'] = $page;

		$this->master_view( 'user_list' );
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
		// Add new user
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
		} 
		// Edit exist user
		elseif ($oper == "edit") {
			$this->users_model->editUser( $username, $email, $id );
		} 
		// Delete user
		elseif ($oper == "del") {
			$this->users_model->deleteUser($id);
		}
	}


} ?>