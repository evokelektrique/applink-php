<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->model('wallet_model');
		$this->load->model('click_model');
		$this->load->model('news_model');
		$this->load->model('message_model');
		$this->load->model('notification_model');
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
	}

	public function index() {


		$wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));
		$clicks_today 		= $this->click_model->get_link_clicks_from($this->session->userdata('user')['user_id'],"now");
		$clicks_yesterday   = $this->click_model->get_link_clicks_from($this->session->userdata('user')['user_id'],"1 days ago", '1 days ago');
		$clicks_last_month  = $this->click_model->get_link_clicks_from($this->session->userdata('user')['user_id'],"30 days ago", 'now');
		$text_clicks_last_month  = $this->click_model->get_text_clicks_from($this->session->userdata('user')['user_id'],"30 days ago", 'now');
		$text_clicks_today  = $this->click_model->get_text_clicks_from($this->session->userdata('user')['user_id'],"now");
		$text_clicks_yesterday  = $this->click_model->get_text_clicks_from($this->session->userdata('user')['user_id'],"1 days ago", '1 days ago');
		$total_clicks_yesterday = count($clicks_yesterday) + count($text_clicks_yesterday);
		$total_clicks_today = count($clicks_today) + count($text_clicks_today);
		if($total_clicks_yesterday == 0 or 
			$total_clicks_yesterday == NULL or 
			$total_clicks_today == 0 or 
			$total_clicks_today == NULL) {
			// Null
			$from_yesterday_percentage = 0;
		} else {
			// Dividing
			$from_yesterday_percentage = (1 - $total_clicks_yesterday / $total_clicks_today ) * 100;
		}
	
		$news_raw 		= $this->news_model->limited_all(4);
		$news_raw_rows 	= $this->news_model->count();
		$news 			= array();
		$formatter 		= new IntlDateFormatter(
				                "fa_IR@calendar=persian", 
				                IntlDateFormatter::FULL, 
				                    IntlDateFormatter::FULL, 
				                'Asia/Tehran', 
				                IntlDateFormatter::TRADITIONAL, 
				                "yyyy-MM-dd");
		for ($i=0; $i < $news_raw_rows; $i++) { 
			$time = new DateTime($news_raw[$i]['created_at']);
			array_push($news, 
				array(
					'id' => $news_raw[$i]['id'],
					'user_id' => $news_raw[$i]['user_id'],
					'title' => $news_raw[$i]['title'],
					'text' => $news_raw[$i]['text'],
					'created_at' => $formatter->format($time),
					)
				);
		}	
		$messages_raw 		= $this->message_model->get_user_messages($this->session->userdata('user')['user_id'],4);
		$messages_raw_rows 	= $this->message_model->count($this->session->userdata('user')['user_id']);
		$messages 			= array();
		$formatter 			= new IntlDateFormatter(
				                "fa_IR@calendar=persian", 
				                IntlDateFormatter::FULL, 
				                    IntlDateFormatter::FULL, 
				                'Asia/Tehran', 
				                IntlDateFormatter::TRADITIONAL, 
				                "yyyy-MM-dd");
		for ($i=0; $i < $messages_raw_rows; $i++) { 
			$time = new DateTime($messages_raw[$i]['created_at']);
			array_push($messages, 
				array(
					'id' => $messages_raw[$i]['id'],
					'user_id' => $messages_raw[$i]['user_id'],
					'title' => $messages_raw[$i]['title'],
					'text' => $messages_raw[$i]['text'],
					'created_at' => $formatter->format($time),
					)
				);
		}
		$notifications = count($this->notification_model->get_user_notifications($this->session->userdata('user')['user_id']));
		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$data = array(
			'base_url' 					=> base_url(),
			'header'					=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'					=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar' 					=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'wallet' 					=> $wallet,
			'total_clicks_today' 		=> $total_clicks_today,
			'total_clicks_yesterday' 	=> $total_clicks_yesterday,
			'clicks_last_month' 		=> $clicks_last_month,
			'text_clicks_last_month' 	=> $text_clicks_last_month,
			'from_yesterday_percentage' => $from_yesterday_percentage,
			'news' 						=> $news,
			'notifications' 			=> $notifications,
			'messages' 					=> $messages,
		);

		$this->parser->parse('dashboard/index', $data);
	}



	public function logout() {
		$data = $this->session->all_userdata();
		foreach ($data as $row => $value) {
			$this->session->unset_userdata($row);
		}
		delete_cookie('remember_me');		
		redirect(base_url());
	}


	public function create_wallet($user_id=1) {
		$this->wallet_model->create($user_id);
	}


}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
