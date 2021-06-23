<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->model('wallet_model');
		$this->load->model('message_model');
		$this->load->model('notification_model');
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
	}

	public function index($message_id) {
		$wallet 			= $this->wallet_model->wallet($this->session->userdata('user_id'));	
		$messages_raw 		= $this->message_model->find_by('id',$message_id);
		if(empty($messages_raw)) {redirect(base_url('dashboard'));}
		if($messages_raw[0]['user_id'] !== $this->session->userdata('user_id')) {redirect(base_url('dashboard')); }
		$messages 			= array();
		$formatter 			= new IntlDateFormatter(
				                "fa_IR@calendar=persian", 
				                IntlDateFormatter::FULL, 
				                    IntlDateFormatter::FULL, 
				                'Asia/Tehran', 
				                IntlDateFormatter::TRADITIONAL, 
				                "yyyy-MM-dd");
		$time = new DateTime($messages_raw[0]['created_at']);
		array_push($messages, 
			array(
				'id' 		 => $messages_raw[0]['id'],
				'user_id' 	 => $messages_raw[0]['user_id'],
				'title' 	 => $messages_raw[0]['title'],
				'title' 	 => $messages_raw[0]['title'],
				'text' 		 => $messages_raw[0]['text'],
				'created_at' => $formatter->format($time),
				)
			);
		$notification_id = $this->notification_model->find_by('message_id', $message_id)[0];
		$notification_data = array('status' => 1);
		if($notification_id['status'] == 1) {
			$notification_status = 'خوانده شده';
		} else {
			$notification_status = 'خوانده نشده';
		}
		$this->notification_model->update($notification_data, $notification_id['id']);
		$options = array(
			'title'		=> 'داشبورد',
			'base_url' 	=> base_url(),
			'wallet' 	=> $wallet,
		);
		$data = array(
			'base_url' 				=> base_url(),
			'header'				=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'				=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar' 				=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'wallet' 				=> $wallet,
			'message' 				=> $messages,
			'notification_status' 	=> $notification_status,
		);

		$this->parser->parse('dashboard/message', $data);
	}

}

/* End of file Messages.php */
/* Location: ./application/controllers/Messages.php */
