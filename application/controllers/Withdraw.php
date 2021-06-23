<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Withdraw extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->model('transaction_model');
		$this->load->model('user_model');
		$this->load->model('wallet_model');
		$this->load->helper('file');
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
	}

	public function index() {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian",
                IntlDateFormatter::FULL,
                    IntlDateFormatter::FULL,
                'Asia/Tehran',
                IntlDateFormatter::TRADITIONAL,
                "yyyy-MM-dd");
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);

		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		// $raw_texts = $this->text_model->all();
		// $raw_texts_rows = $this->text_model->count();
		// $texts = array();

		// for ($i=0; $i < $raw_texts_rows; $i++) {
		// 	$time = new DateTime($raw_texts[$i]['created_at']);
		// 	array_push($texts,
		// 		array(
		// 			'raw_id' => $raw_texts[$i]['id'],
		// 			'id' => $i,
		// 			'user_id' => $raw_texts[$i]['user_id'],
		// 			'user_ip' => $raw_texts[$i]['user_ip'],
		// 			// 'address' => $raw_texts[$i]['address'],
		// 			'text' => substr($raw_texts[$i]['text'], 0,18),
		// 			'short' => base_url($raw_texts[$i]['short']),
		// 			'qrcode' => $raw_texts[$i]['qrcode'],
		// 			'created_at' => $formatter->format($time),
		// 			'modified_at' => $raw_texts[$i]['modified_at'],
		// 		)
		// 	);
		// }

		$user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id'])[0];
		$data = array(
			'base_url' 						=> base_url(),
			'header'						=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'						=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar' 						=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'user'							=> $user,
			'wallet'						=> $wallet
		);
		if(empty($user['bankaddress']) || empty($user['name']) || empty($user['phone']) || $user['status'] == 0) {
			$data['information_status'] = TRUE;
		} else {
			$data['information_status'] = FALSE;
		}
		$this->parser->parse('dashboard/withdraw', $data);
	}

	public function validate() {
		$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
		$now  = $date->format('Y-m-d H:i:s');
		$minimum_wallet_amount = 100000;
		$user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id'])[0];

		$this->form_validation->set_rules('wallet_amount', 'مقدار کیف پول', 'required');
		if($this->form_validation->run() == FALSE) { // Error
			$this->session->set_flashdata('danger', 'bad');
			$this->session->set_flashdata('danger_message', 'خطا در درخواست واریز');
			$this->index();
			// redirect(base_url('dashboard/withdraw'));
		} else { // Success
			if(empty($user['bankaddress']) || empty($user['name']) || empty($user['phone']) || $user['status'] == 0) {
				$this->session->set_flashdata('danger', 'bad');
				$this->session->set_flashdata('danger_message', 'خطا در درخواست واریز');
				redirect(base_url('dashboard/withdraw'));
			} else {
				$data = array('wallet_amount' => $this->input->post('wallet_amount'));
				if($data['wallet_amount'] >= $minimum_wallet_amount) { // Success
					$transaction_data = array(
						'user_id' 		=> $user['id'],
						'user_ip' 		=> $this->input->ip_address(),
						'amount' 		=> $data['wallet_amount'],
						'created_at' 	=> $now,
					);
					$current_amount = intval($this->wallet_model->wallet($user['id'])[0]['amount']);
					$new_amount = $current_amount - $data['wallet_amount'];
					$transaction_record = $this->transaction_model->create($transaction_data);
					if($transaction_record > 0) { // Success
						$this->session->set_flashdata('success', 'ok');
						$this->session->set_flashdata('success_message', 'درخواست با موفقیت انجام شد');
						$wallet_data = array(
							'amount' 		=> $new_amount,
							'modified_at' 	=> $now
						);
						$this->wallet_model->update($wallet_data, $this->wallet_model->wallet($user['id'])[0]['id']);
						redirect(base_url('dashboard/withdraw'));
					} else { // Error
						$this->session->set_flashdata('danger', 'bad');
						$this->session->set_flashdata('danger_message', 'خطا در درخواست واریز');
						redirect(base_url('dashboard/withdraw'));
					}
				} else { // Error
					$this->session->set_flashdata('danger', 'bad');
					$this->session->set_flashdata('danger_message', 'موجودی شما به حد نصاب نرسیده است.');
					redirect(base_url('dashboard/withdraw'));
				}
			}

		}
	}


	public function list() {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian",
                IntlDateFormatter::FULL,
                    IntlDateFormatter::FULL,
                'Asia/Tehran',
                IntlDateFormatter::TRADITIONAL,
                "yyyy-MM-dd");
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		$user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id'])[0];

		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$raw_trasnactions = $this->transaction_model->find_by('user_id',$user['id']);
		$raw_trasnactions_rows = $this->transaction_model->count();
		$trasnactions = array();

		for ($i=0; $i < $raw_trasnactions_rows; $i++) {
			$time = new DateTime($raw_trasnactions[$i]['created_at']);
			if($raw_trasnactions[$i]['pay_status'] == 0) {
				$payed_status = 'پرداخت نشده';
			} else {
				$payed_status = 'پرداخت شده';
			}
			array_push($trasnactions,
				array(
					'raw_id' 		      => $raw_trasnactions[$i]['id'],
					'id' 			        => $i,
					'user_id' 		    => $raw_trasnactions[$i]['user_id'],
					'user_ip'		      => $raw_trasnactions[$i]['user_ip'],
					'amount'		      => $raw_trasnactions[$i]['amount'],
					'payed_status'	  => $payed_status,
					'created_at' 	    => $formatter->format($time),
					'modified_at' 	  => $raw_trasnactions[$i]['modified_at'],
				)
			);
		}

		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	   => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'user'           => $user,
			'wallet'         => $wallet,
			'trasnactions' 	 => $trasnactions
		);
		$this->parser->parse('dashboard/transactions_list', $data);
	}

}

/* End of file Withdraw.php */
/* Location: ./application/controllers/Withdraw.php */
