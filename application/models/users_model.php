<?php 

	class Users_model extends CI_Model {

		public function __construct() {

		}

		public function addNewUser( $username = null, $email = null, $password = null ) {
			
			$newuser = array();
			if ($password !== NULL) {
				$this->load->helper('account/phpass');
				$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
				$hashed_password = $hasher->HashPassword($password);
			}

			$this->load->helper('date');
			$this->db->insert('a3m_account', array('username' => $username, 'email' => $email, 'password' => isset($hashed_password) ? $hashed_password : NULL, 'createdon' => mdate('%Y-%m-%d %H:%i:%s', now())));

			return $this->db->insert_id();

		}

		public function editUser( $username = null, $email = null, $id = 0 ) {

			$this->db->update('a3m_account', array('username' => $username, 'email' => $email), array('id' => $id));

		}

		public function deleteUser( $id = 0 ) {

			$this->db->delete('a3m_account', array('id' => $id));
			$this->db->delete('a3m_rel_account_role', array('account_id' => $id));			

		}

		public function getUsersList( $row_page = 0, $perPage = 0, $sortingRow = null, $sortOrder = 'asc', $user_id = 0 ) {

			$usersList = (object) array();
			
			$usersList->rows = array();
			if( $sortingRow != "" )
				$this->db->order_by( $sortingRow, $sortOrder );
			$users = $this->db->get_where('a3m_account', array( "id !=" => $user_id ));

			foreach ($users->result() as $user) {
				$usersList->rows[] = $user;
			}

			$usersList->page = $row_page;


			$usersList->records = $this->db->count_all_results('a3m_account') - 1;
			$usersList->total = ceil($usersList->records/$perPage);

			return $usersList;

		}
	}
?>