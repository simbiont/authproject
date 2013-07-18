<?php 
	public function jqgrid_show(){
	    try{
	        $response = $this->model_name->get_grid_data($_REQUEST);
	        header('Content-type: application/json');
	        echo json_encode($response);
	    }catch (Exception $e){
	        $this->handle_controller_exception($e);
	    }
	}
?>