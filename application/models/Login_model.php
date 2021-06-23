<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public $variable;

	public function __construct() {
		parent::__construct();
		$this->load->library('encryption');
	}

	public function auth($data) {
		$condition = array('username' => $data['username']);
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$decrypted_password = $this->encryption->decrypt($row->password);
				if($data['password'] == $decrypted_password) {
					$user = array(
						'user_id' 		=> $row->id,
						'username' 		=> $row->username,
						'email' 		=> $row->email,
						'name' 			=> $row->name,
					);
					$this->session->set_userdata($user);
					if($row->role == 1) {
						$this->session->set_userdata('admin', true);
					}
					$this->session->set_userdata('logged_in', true);
					$this->session->set_userdata('user', $user);
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */