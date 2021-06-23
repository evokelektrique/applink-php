<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet_model extends CI_Model {

	public $table;

	public function __construct() {
		parent::__construct();
		$this->table = 'wallet';
	}

	public function wallet($user_id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	public function create($user_id) {
		$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
		$now  = $date->format('Y-m-d H:i:s');
		$data = array(
			'user_id' 		=> $user_id,
			'amount' 		=> "0",
			'created_at' 	=> $now,
		);
		$this->db->set($data);
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}
	public function update($data, $id) {
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update($this->table);
	}

	public function all() {
		$this->db->select('*');
		$this->db->from($this->table);
		// $this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function find_by($key, $value) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where($key, $value);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count() {
		return $this->db->from($this->table)->count_all_results();
	}

	public function last() {
		return $last_row=$this->db->select('*')->order_by('id',"desc")->limit(1)->get($this->table)->row();
	}
}

/* End of file Wallet_model.php */
/* Location: ./application/models/Wallet_model.php */