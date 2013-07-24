<?php
    class MY_Controller extends CI_Controller {

        public $data = array();

        public function __construct () {
            parent::__construct();

            if ( $this->authentication->is_signed_in() ) {
                $this->data['account'] = $this->account_model->get_by_id( $this->session->userdata( 'account_id' ) );
                $this->data['account']->is_super = $this->is_super();                
            }
        }

        public function access_denied () {
            redirect( "/" );
        }

        public function is_super () {

            if( $this->authentication->is_signed_in() &&
                $this->account_model->get_role_id( $this->data['account']->id ) ==
                $this->config->item("superuser_role_id") ) {
                return true;
            } else {
                return false;
            }

        }

        public function subview( $view = null, $data = array(), $to_string = false ) {            
            return $this->load->view( $view, array_merge_recursive( $this->data, $data ), $to_string );
        }

        public function master_view( $view = null, $data = array() ) {

            $master_view = 'master';

            $this->data['subview'] = $this->subview( $view, $data, true );
            $this->subview( $master_view, $this->data );

        }

    }