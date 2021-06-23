<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public $table;

	public function __construct() {
		parent::__construct();
		$this->table = 'users';
	}

	public function create($data) {
		$this->db->set($data);
		$this->db->insert($this->table);
		return $this->db->insert_id();
	}

	public function update($data, $id) {
		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->update($this->table);
	}

	public function select($id) {
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function delete($id) {
		$this->db->delete($this->table, array('id' => $id));
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
	function get_list($from_str, $to_str='now') {
		$from = date("Y-m-d",strtotime($from_str));
		$to = date("Y-m-d",strtotime($to_str));
		$where = "created_at >= '".$from."' AND created_at < '".$to."' + INTERVAL 1 DAY";
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->order_by('created_at', 'acs');
		$query = $this->db->get();
		return $query->result_array();
	}


}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */