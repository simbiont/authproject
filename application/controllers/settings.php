<?php 
class Settings extends MY_Controller {

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
		$this->load->model('settings_model');
		$this->data['admin_email'] = $this->settings_model->getAdminMail();
		$list = array( 'Test', 'Some Service', 'Site');

		$this->data['drop_list'] = json_decode( $this->settings_model->getList() );

		$this->data['form_attr'] = array('id' => 'admin_email_form');
		$this->data['placeholder'] = "placeholder='Admin Email' id='admin_email' required";
		$this->data['submit_attr'] = array( 'name' => 'change_email', 'class' => 'btn btn-success', 'value' => 'Save' );

		$this->data['fields_num'] = $this->settings_model->getFieldsNum();

		$this->master_view( 'settings' );
	}

	public function addItem() {
		$this->load->model('settings_model');
		$newItem = $this->input->post('new_item');
		$this->settings_model->addItem( $newItem );
		return;
	}

	public function editItem() {
		$this->load->model('settings_model');
		$item = $this->input->post('item');
		$this->settings_model->deleteItem( $item );
		return;
	}	

	public function deleteItem() {
		$this->load->model('settings_model');
		$item = $this->input->post('item');
		$this->settings_model->deleteItem( $item );
		return;
	}	

	public function setAdminMail () {
		$this->load->model('settings_model');
		$email = $this->input->post('admin_email');
		$this->settings_model->setAdminMail($email);
		redirect('settings');
	}

	public function setFieldsNum () {
		$this->load->model('settings_model');
		$num = $this->input->post('fields_num');
		$this->settings_model->setFieldsNum( $num );
		return;
	}

} ?>