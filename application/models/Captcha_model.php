<?php


class Captcha_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function save_captcha($data) {
		$this->db->insert('captcha', $data);
		return $this->db->insert_id();
	}

	public function captcha_exists($data, $word) {
		if(!empty($data)) {
			$expiration = time() - 7200; // Two hour limit
			$this->db->where('captcha_time < ', $expiration)
			        ->delete('captcha');

			$this->db->select('*');
			$this->db->from('captcha');
			$this->db->where('word', $word);
			$this->db->where('ip_address', $data['ip_address']);
			$this->db->where('captcha_time', $data['captcha_time']);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

}