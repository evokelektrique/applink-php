<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Click_model extends CI_Model {

	public $table;

	public function __construct() {
		parent::__construct();
		$this->table = 'clicks';
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


	public function text_clicks($text_id) {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where("link_id", intval($text_id));
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_chartdata($link_id) {
		$from = date("Y-m-d",strtotime('1 weeks ago'));
		$to = date("Y-m-d",strtotime('+1 day'));
		// SELECT * FROM tokens WHERE 
		$where = "created_at >= '".$from."' AND created_at <= '".$to."'";
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->where('link_id', $link_id);
		$this->db->order_by('id', 'acs');
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_link_clicks_from($user_id,$from_str, $to_str='now') {
		$from = date("Y-m-d",strtotime($from_str));
		$to = date("Y-m-d",strtotime($to_str));
		// SELECT * FROM tokens WHERE 
		// timestamp >= CURDATE()
		// AND timestamp < CURDATE() + INTERVAL 1 DAY
		$where = "created_at >= '".$from."' AND created_at < '".$to."' + INTERVAL 1 DAY";
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->where('user_id', $user_id);
		$this->db->where('mode', 'link');
		$this->db->order_by('created_at', 'acs');
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_text_clicks_from($user_id,$from_str, $to_str='now') {
		$from = date("Y-m-d",strtotime($from_str));
		$to = date("Y-m-d",strtotime($to_str));
		// SELECT * FROM tokens WHERE 
		// timestamp >= CURDATE()
		// AND timestamp < CURDATE() + INTERVAL 1 DAY
		$where = "created_at >= '".$from."' AND created_at < '".$to."' + INTERVAL 1 DAY";
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->where('user_id', $user_id);
		$this->db->where('mode', 'text');
		$this->db->order_by('created_at', 'acs');
		$query = $this->db->get();
		return $query->result_array();
	}




	function get_clicks_from_by_mode($mode,$from_str, $to_str='now') {
		$from = date("Y-m-d",strtotime($from_str));
		$to = date("Y-m-d",strtotime($to_str));
		// SELECT * FROM tokens WHERE 
		// timestamp >= CURDATE()
		// AND timestamp < CURDATE() + INTERVAL 1 DAY
		$where = "created_at >= '".$from."' AND created_at < '".$to."' + INTERVAL 1 DAY";
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where($where);
		$this->db->where('mode', $mode);
		$this->db->order_by('created_at', 'acs');
		$query = $this->db->get();
		return $query->result_array();
	}	

}

/* End of file Click_model.php */
/* Location: ./application/models/Click_model.php */