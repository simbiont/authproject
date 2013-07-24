<?php
class Upload extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->master_view('upload-form');
    }

    public function processing( $project_id = null ) {
        $user_id = $this->data['account']->id;
        $permissions = $this->check_permission($user_id, $project_id);
        if( !$project_id ) {
            return false;
        }

        if ( !$this->is_super() && !$permissions) {
            return false;
        }

        if($_FILES['file']['error'] != 0) {
            echo $_FILES['file']['error'];
            return false;
        } 
        if ( ! in_array($_FILES['file']['type'], array('application/zip', "image/jpeg", "image/png", "application/pdf", "text/csv"))) {
            print_r( $_FILES['file']['type'] );
            echo "Wrong file type";
            return false;
        }

        
        $file_upload_path = 'upload/projects/' . $project_id;

        if( !file_exists( $file_upload_path ) ) {
            mkdir( $file_upload_path, 0777, true );
        }

        $date = date( 'Y-m-d H:i:s' );

        $data = array(
           'project_id' => $project_id,
           'a3m_user_id' => $user_id,
           'file_name' => $_FILES['file']['name'],
           'file_type' => $_FILES['file']["type"],
           'date' => $date
        );

        $this->db->insert('uploads', $data);
        
        move_uploaded_file( $_FILES['file']['tmp_name'], $file_upload_path . '/' . $_FILES['file']['name'] );

        if( $_FILES['file']['type'] ==  "text/csv" ) {
            $this->load->model('projects_model');       
            $this->load->library('Csv_parse');
            $csv = new Csv_parse;
            $csv->load($file_upload_path . '/' . $_FILES['file']['name']);
            $headers = $csv->getHeaders();
            $count   = $csv->countRows(); // total rows
            $user_id = $this->session->userdata('account_id');
            for ($i=0; $i < $count; $i++) {
                $row = $csv->getRow($i);
                $data = array(
                    'service' => $row[0],
                    'date' => $row[1],
                    'initials' => $row[2],
                    'description' => $row[3],
                    'hours' => $row[4],
                    'rate' => $row[5],
                    'amount' => $row[6],
                    'oper' => 'add'
                );
                $this->projects_model->editProjects($data, $user_id, $project_id);            
            }
        } 
        else {
            $from = $this->data['account']->email;
            $username = $this->data['account']->username;
            $to = "";
            $attach = $file_upload_path . '/' . $_FILES['file']['name'];
            $this->db->select('project_name');
            $project_name_query = $this->db->get_where('project_list', array( 'id' => $project_id ));
            $project_name = $project_name_query->result();
            $this->mailToAdmin( $username, $from, $to, $project_id, $attach, $project_name );
        }
    }

    public function check_permission( $user_id = null, $project_id = null ) {
        $query = $this->db->get_where('projects', array('project_id' => $project_id, 'a3m_user_id' => $user_id));
        $result = $query->result();

        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    public function mailToAdmin($username = 0, $from = 0, $to = 0, $project_id = 0, $attach = 0, $project_name = 0) {
        $this->load->library('email');

        $this->email->from($from, $username);
        $this->email->to($from); 

        $this->email->subject('New file to project '.$project_name);
        $this->email->message('User '.$username);  
        $this->email->attach($attach);
        $this->email->send();

        // echo $this->email->print_debugger();
    }
}