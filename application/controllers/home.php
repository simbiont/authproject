<?php

class Home extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
	}

	function index()
	{
		maintain_ssl();
		
		$this->load->view('home', isset($this->data) ? $this->data : NULL);
	}

}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */