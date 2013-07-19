<?php
class Upload extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->master_view('upload-form');
    }

    public function processing( $project_id = null ) {

        if( !$project_id ) {
            return false;
        }

        $file_upload_path = 'upload/projects/' . $project_id;

        if( !file_exists( $file_upload_path ) ) {
            mkdir( $file_upload_path, 0777, true );
        }

        move_uploaded_file( $_FILES['file']['tmp_name'], $file_upload_path . '/' . $_FILES['file']['name'] );

    }
}