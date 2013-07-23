<?php

class Home extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
	}

	function index()
	{
		maintain_ssl();

		if ($this->authentication->is_signed_in()) {
			$this->data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			$this->data['super'] = $this->is_super();
		}

		$this->load->view('home', isset($this->data) ? $this->data : NULL);
	}

}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */