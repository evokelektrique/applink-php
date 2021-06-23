<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->model('wallet_model');
		$this->load->model('news_model');
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
	}

	public function index($news_id) {
		$wallet 		= $this->wallet_model->wallet($this->session->userdata('user_id'));	
		$news_raw 		= $this->news_model->select($news_id);
		if(empty($news_raw)) {redirect(base_url('dashboard'));}
		$news 			= array();
		$formatter 		= new IntlDateFormatter(
				                "fa_IR@calendar=persian", 
				                IntlDateFormatter::FULL, 
				                    IntlDateFormatter::FULL, 
				                'Asia/Tehran', 
				                IntlDateFormatter::TRADITIONAL, 
				                "yyyy-MM-dd");
		$time = new DateTime($news_raw[0]['created_at']);
		array_push($news, 
			array(
				'id' => $news_raw[0]['id'],
				'user_id' => $news_raw[0]['user_id'],
				'title' => $news_raw[0]['title'],
				'text' => $news_raw[0]['text'],
				'created_at' => $formatter->format($time),
				)
			);
		$options = array(
			'title'		=> 'داشبورد',
			'base_url' 	=> base_url(),
			'wallet' 	=> $wallet,
		);
		$data = array(
			'base_url' 	=> base_url(),
			'header'	=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'	=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar' 	=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'wallet' 	=> $wallet,
			'news' 		=> $news,
		);

		$this->parser->parse('dashboard/news', $data);
	}

}

/* End of file News.php */
/* Location: ./application/controllers/News.php */
