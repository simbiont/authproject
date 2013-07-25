<?php 

	class Settings_model extends CI_Model {

		public function __construct() {

		}

		public function getAdminMail() {
			return $this->db->get_where('admin_settings', array('id' => '1'))->row()->admin_email;
		}

		public function setAdminMail( $email = null ) {
			$this->db->where('id','1');
			return $this->db->update('admin_settings', array('admin_email' => $email));
		}

		public function getList() {
			return $this->db->get_where('admin_settings', array('id' => '1'))->row()->dropdown_list;
		}
		public function addItem( $item = null ) {
			$list = $this->db->get_where('admin_settings', array('id' => '1'))->row()->dropdown_list;
			$array = json_decode($list);
			$array->$item = $item;

			$this->db->where('id','1');			
			return $this->db->update('admin_settings', array('dropdown_list' =>json_encode($array)));

		}
		public function deleteItem( $item = null ) {
			$list = $this->db->get_where('admin_settings', array('id' => '1'))->row()->dropdown_list;
			$array = json_decode($list);
			unset($array->$item);
			$this->db->where('id','1');			
			return $this->db->update('admin_settings', array('dropdown_list' =>json_encode($array)));
		}
		public function setFieldsNum ( $num = 0 ) {
			if( is_numeric($num) ) {
				$this->db->where('id','1');
				return $this->db->update('admin_settings', array('row_num' => $num));
			} else {
				echo "Wrong number format";
			}
			
		}

		public function getFieldsNum() {
			return $this->db->get_where('admin_settings', array('id' => '1'))->row()->row_num;
		}
	}
?>