<?php 
class jqgrid_model  extends CI_Model  {
    function __construct()
    {
        parent::__construct();
    }
    public function get_grid_data($request_data){
        try{
            $page = $request_data['page']; // get the requested page
            $limit = $request_data['rows']; // get how many rows we want to have into the grid
            $totalrows = isset($request_data['totalrows']) ? $request_data['totalrows']: false;
            if($totalrows) {
                $limit = $totalrows;
            }

            $this->db->select("*",false);
            $this->db->from('projects');
            $total_rows = $this->db->get()->result();

            $count = count($total_rows);
            $response = new stdClass();
            if( $count >0 ) {
                $total_pages = ceil($count/$limit);
            } else {
                $total_pages = 0;
            }
            if ($page > $total_pages){
                $page = $total_pages;
            }
            if ($limit <= 0){
                $limit = 0;
            }
            $start = $limit * $page - $limit;
            if ($start<=0){
                $start = 0;
            }
            $response->page = $page;
            $response->total = $total_pages;
            $response->records = $count;
            $response->start = $start;
            $response->limit = $limit;

            $eligible_rows = array_slice($total_rows, $start, $limit);

            $i = 0;
            foreach($eligible_rows as $row) {
                $response->rows[$i]['id'] = $row->id;
                $response->rows[$i++]['cell'] = array($row->id, $row->name, $row->note, $row->amount);
            }
            return $response;
        }catch (Exception $e){
            $this->handle_exception($e);
        }
    }
}
?>