<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_model extends CI_Model {


	public function __construct() {
		parent::__construct();
	}

	public function save($data) {
		if(!$data) {
			return false;
		} else {
			$this->db->set($data);
			$this->db->insert('users');
			return $this->db->insert_id();
		}
	}


}

/* End of file Register_model.php */
/* Location: ./application/models/Register_model.php */