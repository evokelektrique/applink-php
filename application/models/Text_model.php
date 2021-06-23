<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Text_model extends CI_Model {

	public $table;

	public function __construct() {
		parent::__construct();
		$this->table = 'texts';
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
}

/* End of file Shortlink_model.php */
/* Location: ./application/models/Shortlink_model.php */