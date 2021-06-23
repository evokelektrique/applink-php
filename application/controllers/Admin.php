<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->model('link_model');
		$this->load->model('wallet_model');
		$this->load->model('click_model');
		$this->load->model('news_model');
		$this->load->model('message_model');
		$this->load->model('notification_model');
		$this->load->model('user_model');
		$this->load->model('text_model');
		$this->load->model('transaction_model');
		$this->load->model('settings_model');
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
		if(!$this->session->userdata('admin')) {
			redirect(base_url('dashboard'));
		}
	}

	public function index() { }


	public function stats() {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");
		$raw_links = $this->link_model->all();
		$raw_links_rows = $this->link_model->count();
		$links = array();

		for ($i=0; $i < $raw_links_rows; $i++) { 
			$time 		= new DateTime($raw_links[$i]['created_at']);
			$clicks 	= $this->click_model->find_by('link_id', $raw_links[$i]['id']);
			$chartdata 	= $this->click_model->get_chartdata($raw_links[$i]['id']);
			if(empty($clicks)) {
				$clicks = 0;
			}
			array_push($links, 
				array(
					'raw_id' => $raw_links[$i]['id'],
					'id' => $i,
					'user_id' => $raw_links[$i]['user_id'],
					'user_ip' => $raw_links[$i]['user_ip'],
					'address' => $raw_links[$i]['address'],
					'short' => base_url($raw_links[$i]['short']),
					'qrcode' => $raw_links[$i]['qrcode'],
					'clicks' => $clicks,
					'chartdata' => $chartdata,
					'created_at' => $formatter->format($time),
					'modified_at' => $raw_links[$i]['modified_at'],
				)
			);
		}


		$raw_texts = $this->text_model->all();
		$raw_texts_rows = $this->text_model->count();
		$texts = array();

		for ($i=0; $i < $raw_texts_rows; $i++) { 
			$time = new DateTime($raw_texts[$i]['created_at']);
			array_push($texts, 
				array(
					'raw_id' => $raw_texts[$i]['id'],
					'id' => $i,
					'user_id' => $raw_texts[$i]['user_id'],
					'user_ip' => $raw_texts[$i]['user_ip'],
					// 'address' => $raw_texts[$i]['address'],
					'text' => substr($raw_texts[$i]['text'], 0,18),
					'short' => base_url($raw_texts[$i]['short']),
					'qrcode' => $raw_texts[$i]['qrcode'],
					'created_at' => $formatter->format($time),
					'modified_at' => $raw_texts[$i]['modified_at'],
				)
			);
		}
		$wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));

		$month_link_clicks 	= $this->click_model->get_clicks_from_by_mode('link', '30 days ago', 'now');
		$month_text_clicks 	= $this->click_model->get_clicks_from_by_mode('text', '30 days ago', 'now');
		$count_user 		= count($this->user_model->all());
		$count_link 		= count($this->link_model->all());
		$count_text 		= count($this->text_model->all());
		$count_transaction 	= count($this->transaction_model->all());
		$count_click 		= count($this->click_model->all());


		$clicks_today 				= $this->click_model->get_clicks_from_by_mode('link',"now");
		$clicks_yesterday   		= $this->click_model->get_clicks_from_by_mode('link',"1 days ago", '1 days ago');
		$clicks_last_month  		= count($this->click_model->get_clicks_from_by_mode('link',"30 days ago", 'now'));
		$text_clicks_today  		= $this->click_model->get_clicks_from_by_mode('text',"now");
		$text_clicks_yesterday  	= $this->click_model->get_clicks_from_by_mode('text',"1 days ago", '1 days ago');
		$text_clicks_last_month  	= count($this->click_model->get_clicks_from_by_mode('text',"30 days ago", 'now'));
		$total_clicks_yesterday 	= count($clicks_yesterday) + count($text_clicks_yesterday);
		$total_clicks_today 		= count($clicks_today) + count($text_clicks_today);
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

			'month_text_clicks'			=> $month_text_clicks,
			'month_link_clicks'			=> $month_link_clicks,

			'count_user' 				=> $count_user,
			'count_link' 				=> $count_link,
			'count_text' 				=> $count_text,
			'count_transaction' 		=> $count_transaction,
			'count_click' 				=> $count_click,

			'total_clicks_today' 		=> $total_clicks_today,
			'total_clicks_yesterday' 	=> $total_clicks_yesterday,
			'clicks_last_month' 		=> $clicks_last_month,
			'text_clicks_last_month' 	=> $text_clicks_last_month,
			'from_yesterday_percentage' => round($from_yesterday_percentage),
			'links' 					=> $links,
			'texts' 					=> $texts,
		);

		$this->parser->parse('dashboard/admin_stats', $data);
	}


	public function links() {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");
		$raw_links = $this->link_model->all();
		$raw_links_rows = $this->link_model->count();
		$links = array();

		for ($i=0; $i < $raw_links_rows; $i++) { 
			$time 		= new DateTime($raw_links[$i]['created_at']);
			$clicks 	= $this->click_model->find_by('link_id', $raw_links[$i]['id']);
			$chartdata 	= $this->click_model->get_chartdata($raw_links[$i]['id']);
			if(empty($clicks)) {
				$clicks = 0;
			}
			array_push($links, 
				array(
					'raw_id' => $raw_links[$i]['id'],
					'id' => $i,
					'user_id' => $raw_links[$i]['user_id'],
					'user_ip' => $raw_links[$i]['user_ip'],
					'address' => $raw_links[$i]['address'],
					'short' => base_url($raw_links[$i]['short']),
					'type' => $raw_links[$i]['type'],
					'qrcode' => $raw_links[$i]['qrcode'],
					'clicks' => $clicks,
					'chartdata' => $chartdata,
					'created_at' => $formatter->format($time),
					'modified_at' => $raw_links[$i]['modified_at'],
				)
			);
		}
		$wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));

		$month_link_clicks 	= $this->click_model->get_clicks_from_by_mode('link', '30 days ago', 'now');
		$month_text_clicks 	= $this->click_model->get_clicks_from_by_mode('text', '30 days ago', 'now');
		$count_user 		= count($this->user_model->all());
		$count_link 		= count($this->link_model->all());
		$count_text 		= count($this->text_model->all());
		$count_transaction 	= count($this->transaction_model->all());
		$count_click 		= count($this->click_model->all());


		$clicks_today 				= $this->click_model->get_clicks_from_by_mode('link',"now");
		$clicks_yesterday   		= $this->click_model->get_clicks_from_by_mode('link',"1 days ago", '1 days ago');
		$clicks_last_month  		= count($this->click_model->get_clicks_from_by_mode('link',"30 days ago", 'now'));
		$text_clicks_today  		= $this->click_model->get_clicks_from_by_mode('text',"now");
		$text_clicks_yesterday  	= $this->click_model->get_clicks_from_by_mode('text',"1 days ago", '1 days ago');
		$text_clicks_last_month  	= count($this->click_model->get_clicks_from_by_mode('text',"30 days ago", 'now'));
		$total_clicks_yesterday 	= count($clicks_yesterday) + count($text_clicks_yesterday);
		$total_clicks_today 		= count($clicks_today) + count($text_clicks_today);
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

			'month_text_clicks'			=> $month_text_clicks,
			'month_link_clicks'			=> $month_link_clicks,

			'count_user' 				=> $count_user,
			'count_link' 				=> $count_link,
			'count_text' 				=> $count_text,
			'count_transaction' 		=> $count_transaction,
			'count_click' 				=> $count_click,

			'total_clicks_today' 		=> $total_clicks_today,
			'total_clicks_yesterday' 	=> $total_clicks_yesterday,
			'clicks_last_month' 		=> $clicks_last_month,
			'text_clicks_last_month' 	=> $text_clicks_last_month,
			'from_yesterday_percentage' => round($from_yesterday_percentage),
			'links' 					=> $links,
		);

		$this->parser->parse('dashboard/admin_links', $data);
	}

	public function admin_link_delete($id) {
		$link = $this->link_model->select($id)[0];
		$qrfilename = $link['qrcode'];
		unlink(APPPATH."../src/images/qrcodes/$qrfilename.png");
		$this->link_model->delete($id);
		$this->session->set_flashdata('success','delete');
		redirect(base_url('dashboard/links'));
	}

	public function admin_link_edit($id) {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");

		$wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));

		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$raw_link = $this->link_model->select($id)[0];
		// $raw_links_rows = $this->link_model->count();

		$time = new DateTime($raw_link['created_at']);
		$link = array(
			array(
				'id' => $raw_link['id'],
				'user_id' => $raw_link['user_id'],
				'user_ip' => $raw_link['user_ip'],
				'address' => $raw_link['address'],
				'short' => $raw_link['short'],
				'type' => $raw_link['type'],
				'shortaddress' => base_url($raw_link['short']),
				'qrcode' => $raw_link['qrcode'],
				'button' => $raw_link['button'],
				'private_status' => $raw_link['private_status'],
				'private_password' => $raw_link['private_password'],
				'created_at' => $formatter->format($time),
				'modified_at' => $raw_link['modified_at'],
			)
		);

		$data = array(
			'base_url' 			=> base_url(),
			'header'			=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'			=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar' 			=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'link' 			=> $link,
		);
		$this->parser->parse('dashboard/edit_link', $data);
	}

	public function admin_link_validate_edit($id) {
		$link = $this->link_model->select($id)[0];
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");
		$this->form_validation->set_rules(
			'address',
			'آدرس اصلی',
			'required'
		);		
		$this->form_validation->set_rules(
			'button_name',
			'دکمه ادامه',
			'required'
		);
		if($this->form_validation->run() == FALSE) {
			// Error
			$this->session->set_flashdata('danger', 'bad');
			$this->edit($id);
		} else {
			// Success
			$type = $this->input->post('type');
			switch ($type) {
				case 'direct':
					$type = 'direct';
					break;
				case 'ptc':
					$type = 'ptc';
					break;
				default:
					$type = 'direct';
					break;
			}
			$time = new DateTime();
			$data = array(
				'button' 		=> $this->input->post('button_name'),
				'address' 		=> $this->input->post('address'),
				'type'			=> $type,
				'modified_at' 	=> $formatter->format($time),
			);
			if($this->input->post('private_status') == 'on') {
				$data['private_status'] = 1;
				$data['private_password'] = $this->input->post('private_password');
				if(empty($data['private_password'])) {
					$this->session->set_flashdata('danger', 'bad');
					redirect(base_url("dashboard/links/edit/$id"));
				}
			} else {
				$data['private_status'] = 0;
				$data['private_password'] = NULL;	
			}



			// if($this->generate_qrcode($data['address'], $link['qrcode'])) {
			$this->link_model->update($data, $id);
			$this->session->set_flashdata('success', 'ok');
			redirect(base_url("dashboard/admin/links/edit/$id"));
				// $this->session->set_flashdata('danger', 'bad');
				// redirect(base_url("dashboard/links/edit/$id"));

		}
	}

	public function texts() {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");

		$raw_texts = $this->text_model->all();
		$raw_texts_rows = $this->text_model->count();
		$texts = array();

		for ($i=0; $i < $raw_texts_rows; $i++) { 
			$time = new DateTime($raw_texts[$i]['created_at']);
			array_push($texts, 
				array(
					'raw_id' => $raw_texts[$i]['id'],
					'id' => $i,
					'user_id' => $raw_texts[$i]['user_id'],
					'user_ip' => $raw_texts[$i]['user_ip'],
					// 'address' => $raw_texts[$i]['address'],
					'text' => substr($raw_texts[$i]['text'], 0,18),
					'short' => base_url($raw_texts[$i]['short']),
					'type' => base_url($raw_texts[$i]['type']),
					'qrcode' => $raw_texts[$i]['qrcode'],
					'created_at' => $formatter->format($time),
					'modified_at' => $raw_texts[$i]['modified_at'],
				)
			);
		}
		$wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));

		$month_link_clicks 	= $this->click_model->get_clicks_from_by_mode('link', '30 days ago', 'now');
		$month_text_clicks 	= $this->click_model->get_clicks_from_by_mode('text', '30 days ago', 'now');
		$count_user 		= count($this->user_model->all());
		$count_link 		= count($this->link_model->all());
		$count_text 		= count($this->text_model->all());
		$count_transaction 	= count($this->transaction_model->all());
		$count_click 		= count($this->click_model->all());


		$clicks_today 				= $this->click_model->get_clicks_from_by_mode('link',"now");
		$clicks_yesterday   		= $this->click_model->get_clicks_from_by_mode('link',"1 days ago", '1 days ago');
		$clicks_last_month  		= count($this->click_model->get_clicks_from_by_mode('link',"30 days ago", 'now'));
		$text_clicks_today  		= $this->click_model->get_clicks_from_by_mode('text',"now");
		$text_clicks_yesterday  	= $this->click_model->get_clicks_from_by_mode('text',"1 days ago", '1 days ago');
		$text_clicks_last_month  	= count($this->click_model->get_clicks_from_by_mode('text',"30 days ago", 'now'));
		$total_clicks_yesterday 	= count($clicks_yesterday) + count($text_clicks_yesterday);
		$total_clicks_today 		= count($clicks_today) + count($text_clicks_today);
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

			'month_text_clicks'			=> $month_text_clicks,
			'month_link_clicks'			=> $month_link_clicks,

			'count_user' 				=> $count_user,
			'count_link' 				=> $count_link,
			'count_text' 				=> $count_text,
			'count_transaction' 		=> $count_transaction,
			'count_click' 				=> $count_click,

			'total_clicks_today' 		=> $total_clicks_today,
			'total_clicks_yesterday' 	=> $total_clicks_yesterday,
			'clicks_last_month' 		=> $clicks_last_month,
			'text_clicks_last_month' 	=> $text_clicks_last_month,
			'from_yesterday_percentage' => round($from_yesterday_percentage),
			'texts' 					=> $texts,
		);

		$this->parser->parse('dashboard/admin_texts', $data);
	}

	public function admin_text_delete($id) {
		$link = $this->text_model->select($id)[0];
		$qrfilename = $link['qrcode'];
		unlink(APPPATH."../src/images/qrcodes/$qrfilename.png");
		$this->text_model->delete($id);
		$this->session->set_flashdata('success','delete');
		redirect(base_url('texts'));
	}

	public function admin_text_edit($id) {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");

		$wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));

		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$raw_text = $this->text_model->select($id)[0];
		// $raw_texts_rows = $this->text_model->count();

		$time = new DateTime($raw_text['created_at']);
		$text = array(
			array(
				'id' 				=> $raw_text['id'],
				'user_id' 			=> $raw_text['user_id'],
				'user_ip' 			=> $raw_text['user_ip'],
				'short' 			=> $raw_text['short'],
				'shortaddress' 		=> base_url($raw_text['short']),
				'title' 			=> $raw_text['title'],
				'text' 				=> $raw_text['text'],
				'qrcode' 			=> $raw_text['qrcode'],
				'type' 				=> $raw_text['type'],
				'text_mode' 		=> $raw_text['text_mode'],
				'button' 			=> $raw_text['button'],
				'private_status' 	=> $raw_text['private_status'],
				'private_password' 	=> $raw_text['private_password'],
				'created_at' 		=> $formatter->format($time),
				'modified_at' 		=> $raw_text['modified_at'],
			)
		);

		$data = array(
			'base_url' 			=> base_url(),
			'header'			=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'			=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar' 			=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'text' 				=> $text,
		);
		$this->parser->parse('dashboard/edit_text', $data);
	}

	public function admin_text_validate_edit($id) {
		$link = $this->text_model->select($id)[0];
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");
		$this->form_validation->set_rules(
			'title',
			'عنوان',
			'required'
		);		
		$this->form_validation->set_rules(
			'text',
			'متن',
			'required'
		);		
		$this->form_validation->set_rules(
			'button_name',
			'دکمه ادامه',
			'required'
		);
		$this->form_validation->set_rules(
			'text_mode',
			'حالت نمایش',
			'required'
		);
		$this->form_validation->set_rules(
			'type',
			'حالت لینک',
			'required'
		);
		if($this->form_validation->run() == FALSE) {
			// Error
			$this->session->set_flashdata('danger', 'bad');
			$this->edit($id);
		} else {
			// Success
			$type = $this->input->post('type');
			switch ($type) {
				case 'direct':
					$type = 'direct';
					break;
				case 'ptc':
					$type = 'ptc';
					break;
				default:
					$type = 'direct';
					break;
			}
			$time = new DateTime();
			$data = array(
				'button' 		=> $this->input->post('button_name'),
				'title' 		=> $this->input->post('title'),
				'text' 			=> $this->input->post('text'),
				'type'			=> $type,
				'text_mode' 	=> $this->input->post('text_mode'),
				'modified_at' 	=> $formatter->format($time),
			);
			if($this->input->post('private_status') == 'on') {
				$data['private_status'] = 1;
				$data['private_password'] = $this->input->post('private_password');
				if(empty($data['private_password'])) {
					$this->session->set_flashdata('danger', 'bad');
					redirect(base_url("dashboard/texts/edit/$id"));
				}
			} else {
				$data['private_status'] = 0;
				$data['private_password'] = NULL;	
			}



			// if($this->generate_qrcode($data['address'], $link['qrcode'])) {
			$this->text_model->update($data, $id);
			$this->session->set_flashdata('success', 'ok');
			redirect(base_url("dashboard/texts/edit/$id"));
				// $this->session->set_flashdata('danger', 'bad');
				// redirect(base_url("dashboard/texts/edit/$id"));

		}
	}


	public function admin_transactions_validate_edit($id) {
		$link = $this->transaction_model->select($id)[0];
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");
		$this->form_validation->set_rules(
			'pay_status',
			'وضعیت پرداخت',
			'required'
		);
		if($this->form_validation->run() == FALSE) {
			// Error
			$this->session->set_flashdata('danger', 'bad');
			$this->admin_transactions_edit($id);
		} else {
			// Success
			if ($this->input->post('pay_status') == "پرداخت شده") {
				$payed_status = 1;
			} else {
				$payed_status = 0;
			}
			$time = new DateTime();
			$data = array(
				'pay_status' 		=> $payed_status,
				'modified_at' 	=> $formatter->format($time),
			);

			// if($this->generate_qrcode($data['address'], $link['qrcode'])) {
			$this->transaction_model->update($data, $id);
			$this->session->set_flashdata('success', 'ok');
			redirect(base_url("dashboard/admin/transactions/edit/$id"));
				// $this->session->set_flashdata('danger', 'bad');
				// redirect(base_url("dashboard/texts/edit/$id"));

		}
	}
	public function admin_transactions_edit($id) {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian",
                IntlDateFormatter::FULL,
                    IntlDateFormatter::FULL,
                'Asia/Tehran',
                IntlDateFormatter::TRADITIONAL,
                "yyyy-MM-dd");
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		$raw_transactions = $this->transaction_model->find_by('id',$id);
		$user = $this->user_model->find_by('id', $raw_transactions[0]['user_id']);
		// $not_payed_transactions = count($this->transaction_model->find_by('pay_status', 0));
		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$raw_transactions_rows = count($raw_transactions);
		$transaction = array();

		for ($i=0; $i < $raw_transactions_rows; $i++) {
			$time = new DateTime($raw_transactions[$i]['created_at']);
			if($raw_transactions[$i]['pay_status'] == 0) {
				$payed_status = 'پرداخت نشده';
			} else {
				$payed_status = 'پرداخت شده';
			}
			array_push($transaction,
				array(
					'raw_id' 		      => $raw_transactions[$i]['id'],
					'id' 			        => $i,
					'user_id' 		    => $raw_transactions[$i]['user_id'],
					'user_ip'		      => $raw_transactions[$i]['user_ip'],
					'amount'		      => $raw_transactions[$i]['amount'],
					'payed_status'	  => $payed_status,
					'created_at' 	    => $formatter->format($time),
					'modified_at' 	  => $raw_transactions[$i]['modified_at'],
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
			// 'not_payed_transactions' => $not_payed_transactions,
			'transaction' 	 => $transaction
		);
		$this->parser->parse('dashboard/admin_transactions_edit', $data);

	}

	public function admin_transactions_list() {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian",
                IntlDateFormatter::FULL,
                    IntlDateFormatter::FULL,
                'Asia/Tehran',
                IntlDateFormatter::TRADITIONAL,
                "yyyy-MM-dd");
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		$user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id'])[0];
		$not_payed_transactions = count($this->transaction_model->find_by('pay_status', 0));
		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$raw_transactions = $this->transaction_model->find_by('user_id',$user['id']);
		$raw_transactions_rows = $this->transaction_model->count();
		$transactions = array();

		for ($i=0; $i < $raw_transactions_rows; $i++) {
			$time = new DateTime($raw_transactions[$i]['created_at']);
			if($raw_transactions[$i]['pay_status'] == 0) {
				$payed_status = 'پرداخت نشده';
				$color_status = 0;
			} else {
				$payed_status = 'پرداخت شده';
				$color_status = 1;
			}
			array_push($transactions,
				array(
					'raw_id' 		      => $raw_transactions[$i]['id'],
					'id' 			        => $i,
					'user_id' 		    => $raw_transactions[$i]['user_id'],
					'user_ip'		      => $raw_transactions[$i]['user_ip'],
					'amount'		      => $raw_transactions[$i]['amount'],
					'payed_status'	  => $payed_status,
					'color_status'	  => $color_status,
					'created_at' 	    => $formatter->format($time),
					'modified_at' 	  => $raw_transactions[$i]['modified_at'],
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
			'not_payed_transactions' => $not_payed_transactions,
			'transactions' 	 => $transactions
		);
		$this->parser->parse('dashboard/admin_transactions_list', $data);
	}

	public function admin_users_list(){
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian",
                IntlDateFormatter::FULL,
                    IntlDateFormatter::FULL,
                'Asia/Tehran',
                IntlDateFormatter::TRADITIONAL,
                "yyyy-MM-dd");
		// $user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id'])[0];
		$options = array(
			'title'			=> 'لیست کاربران',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$raw_users = $this->user_model->all();
		$raw_users_rows = $this->user_model->count();
		$users = array();

		for ($i=0; $i < $raw_users_rows; $i++) {
			$time = new DateTime($raw_users[$i]['created_at']);
			if($raw_users[$i]['status'] == 1) {
				$status = "فعال";
			} else {
				$status = "غیر فعال";
			}
			if($raw_users[$i]['role'] == 1) {
				$role = "مدیر";
			} else {
				$role = "کاربر";
			}
			array_push($users,
				array(
					'raw_id'         => $raw_users[$i]['id'],
					'id' 			 => $i,
					'username' 	     => $raw_users[$i]['username'],
					'email' 	     => $raw_users[$i]['email'],
					'name' 	 		 => $raw_users[$i]['name'],
					'status' 	  	 => $status,
					'role' 	 		 => $role,
					'created_at' 	 => $formatter->format($time),
					'modified_at' 	 => $raw_users[$i]['modified_at'],
				)
			);
		}
		$users_today 		= count($this->user_model->get_list('1 days ago'));
		$users_yesterday 	= count($this->user_model->get_list("1 days ago", '1 days ago'));
		$users_month 		= count($this->user_model->get_list("30 days ago", 'now'));


		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'users_today'				=> $users_today,
			'users_yesterday'			=> $users_yesterday,
			'users_month'				=> $users_month,
			'users' 		 => $users
		);
		$this->parser->parse('dashboard/admin_users_list', $data);
	}

	public function admin_users_edit($user_id) {
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		$user = $this->user_model->find_by('id', $user_id);
		$options = array(
			'base_url' 		=> base_url(),
			'title'			  => 'تنظیمات حساب کاربری',
			'wallet' 		  => $wallet,
		);
		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'wallet'         => $wallet,
			'user' 			 => $user
		);
		$this->parser->parse('dashboard/profile', $data);
	}

	public function admin_users_validate_edit($user_id) {
		$data = array();
		$user_status 	= $this->input->post('status');
		$user_role 		= $this->input->post('role');
		$name         	= $this->input->post('name');
		$website        = $this->input->post('website');
		$phone        	= $this->input->post('phone');
		$avatar        	= $this->input->post('avatar_input');
		if(!empty($name))         { $data['name'] = $name; }
		if(!empty($website))      { $data['website'] = $website; }
		$data['status'] = $user_status;
		$data['role'] 	= $user_role;
		if(!empty($data)) {
			// Success
			$this->user_model->update($data,$user_id);
			$this->session->set_flashdata('success', 'ok');
			redirect(base_url("dashboard/admin/users/edit/$user_id"));
		} else {
			// Error
			$this->session->set_flashdata('danger', 'bad');
			redirect(base_url("dashboard/admin/users/edit/$user_id"));
		}

	}







	/*
	Settings
	 */
	public function settings() {
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		$user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id'])[0];
		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$settings = $this->settings_model->select(1);
		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'user'           => $user,
			'wallet'         => $wallet,
			'settings' 	 	 => $settings
		);
		$this->parser->parse('dashboard/settings', $data);
	}
	public function settings_validate_edit() {
		$site_name = $this->input->post('site_name');
		$site_description = $this->input->post('site_description');
		$site_tags = $this->input->post('site_tags');
		$logo = $this->input->post('logo');
		$site_social = $this->input->post('site_social');
		$site_location = $this->input->post('site_location');
		$site_phone_number = $this->input->post('site_phone_number');
		$site_ptc_mode = intval($this->input->post('site_ptc_mode'));
		// var_dump($site_ptc_mode);
		// if($site_ptc_mode == "on") {
		// 	$site_ptc_mode = 1;
		// } else {
		// 	$site_ptc_mode = 0;
		// }
		$site_ptc_link_amount = $this->input->post('site_ptc_link_amount');
		$site_ptc_text_amount = $this->input->post('site_ptc_text_amount');

		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");
		$this->form_validation->set_rules(
			'site_name',
			'عنوان سایت',
			'required'
		);		
		$this->form_validation->set_rules(
			'site_description',
			'توضیحات سایت',
			'required'
		);		
		$this->form_validation->set_rules(
			'site_tags',
			'برچسب های سایت',
			'required'
		);	
		if($site_ptc_mode > 0) {
			$this->form_validation->set_rules(
				'site_ptc_link_amount',
				'قیمت هر کلیک لینک',
				'required|trim'
			);	
			$this->form_validation->set_rules(
				'site_ptc_text_amount',
				'قیمت هر کلیک متن',
				'required|trim'
			);
		}
		if($this->form_validation->run() == FALSE) {
			// Error
			$this->session->set_flashdata('danger', 'bad');
			$this->settings();
		} else {
			// Success
			$data = [];
			$data['site_ptc_mode'] = $site_ptc_mode;
			$settings = $this->settings_model->select(1)[0];
			if($site_name !== $settings['site_name'] && !empty($site_name)) {
				$data['site_name'] = $site_name;
			}
			if($site_description !== $settings['site_description'] && !empty($site_description)) {
				$data['site_description'] = $site_description;
			}
			if($site_tags !== $settings['site_tags'] && !empty($site_tags)) {
				$data['site_tags'] = $site_tags;
			}
			if($site_social !== $settings['site_social'] && !empty($site_social)) {
				$data['site_social'] = $site_social;
			}
			if($site_location !== $settings['site_location'] && !empty($site_location)) {
				$data['site_location'] = $site_location;
			}
			if($site_phone_number !== $settings['site_phone_number'] && !empty($site_phone_number)) {
				$data['site_phone_number'] = $site_phone_number;
			}
			if($site_ptc_mode > 0) {
				if($site_ptc_link_amount !== $settings['site_ptc_link_amount'] && !empty($site_ptc_link_amount)) {
					$data['site_ptc_link_amount'] = $site_ptc_link_amount;
				}
				if($site_ptc_text_amount !== $settings['site_ptc_text_amount'] && !empty($site_ptc_text_amount)) {
					$data['site_ptc_text_amount'] = $site_ptc_text_amount;
				}
			}
			if(!empty($_FILES['logo']['size'] > 0)){
				// Pass [Success]
		        $upload_config['upload_path']= 'src/images/logo/';
		        $upload_config['allowed_types']='jpg|png';
		        $upload_config['encrypt_name'] = TRUE;
		        $this->load->library('upload',$upload_config);
	            if (!$this->upload->do_upload('logo')) {
	                $error_message = $this->upload->display_errors();
	                $this->settings();
	            } else {
	                $image_data = array('upload_data' => $this->upload->data());
	                $image = $image_data['upload_data']['file_name'];
	                $data['site_logo_address'] = $image;
	            }
			}
			if(!empty($data)) {
				$update_record = $this->settings_model->update($data, 1);
				$this->session->set_flashdata('success','ok');
				redirect(base_url('dashboard/admin/settings'));
			} else {
				$this->session->set_flashdata('danger','empty');
				redirect(base_url('dashboard/admin/settings'));
			}
		}
	}





	//////////////
	// Messages //
	//////////////
	public function message() {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian",
                IntlDateFormatter::FULL,
                    IntlDateFormatter::FULL,
                'Asia/Tehran',
                IntlDateFormatter::TRADITIONAL,
                "yyyy-MM-dd");
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		// $user = $this->menu_model->find_by('id', $this->session->userdata('user')['user_id'])[0];
		$options = array(
			'title'			=> 'پیام ها',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$raw_message = $this->message_model->all();
		$raw_message_rows = $this->message_model->count(NULL);
		$messages = array();

		for ($i=0; $i < $raw_message_rows; $i++) {
			$time = new DateTime($raw_message[$i]['created_at']);
			if(!empty($this->user_model->find_by('id', $raw_message[$i]['id']))) {
				array_push($messages,
					array(
						'raw_id'         => $raw_message[$i]['id'],
						'id' 			 => $i,
						'user'			=> NULL,
						'title' 	     => $raw_message[$i]['title'],
						'text' 	     => $raw_message[$i]['text'],
						'created_at' 	 => $formatter->format($time),
					)
				);
			} else {
				array_push($messages,
					array(
						'raw_id'         => $raw_message[$i]['id'],
						'id' 			 => $i,
						'user'			=> $this->user_model->find_by('id', $raw_message[$i]['user_id'])[0],
						'title' 	     => $raw_message[$i]['title'],
						'text' 	     => $raw_message[$i]['text'],
						'created_at' 	 => $formatter->format($time),
					)
				);
			}
		}
		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'wallet'         => $wallet,
			'messages' 		 => $messages
		);
		$this->parser->parse('dashboard/list_message', $data);
	}

	public function create_message() {
		// $this->load->model('menu_model');
		// $this->load->model('group_model');
		$user 	= $this->user_model->find_by('id', $this->session->userdata('user_id'));
		// $groups = $this->group_model->all();
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		// $menus 	= $this->menu_model->all();
		$options = array(
			'base_url' 		=> base_url(),
			'title'			=> 'ساخت پیام',
			'wallet' 		=> $wallet,
		);
		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			// 'wallet'         => $wallet,
			'user' 			 => $user,
			'settings'		 => $this->settings_model->select(1),
			// 'groups' 		 => $groups,
			// 'parent_links'   => $this->menu_model->get_parent_links(),
		);
		$this->parser->parse('dashboard/create_message', $data);
	}


	public function message_validate() {
		$data = array();
		$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
		$now  = $date->format('Y-m-d H:i:s');
		$text = $this->input->post('text');
		$title = $this->input->post('title');
		$data = array(
			'author_id'		=> $this->session->userdata('user_id'),
			'text' 			=> $text,
			'title' 		=> $title,
			'created_at' 	=> $now,
		);
		$mode = intval($this->input->post('mode'));
		if($mode == 1) {
			$users = array();
			$temp_users = $this->user_model->all();
			foreach($temp_users as $user) {
				$users[] = $user['username'];
			}
		} elseif($mode == 0) {
			$users = array();
			$temp_users = $this->input->post('users');
			$temp_users = explode(',',$temp_users);
			foreach($temp_users as $user) {
				if($user !== '' || !empty($user) ) {
					$users[] = str_replace(' ', '', $user);
				}
			}
		}


		foreach($users as $user) {
			if(!empty($user)) {
				if($mode == 2) {
					$temp_user = $this->user_model->find_by('id', $user);
				} else {
					$temp_user = $this->user_model->find_by('username', $user);
				}
				if(!empty($temp_user)) {
					$data['user_id'] = $temp_user[0]['id'];
					$message_id = $this->message_model->create($data);
					if($message_id > 0) {
		        		$notification_data = array(
							'message_id'	=> $message_id,
							'status'		=> 0,
							'user_id'		=> $temp_user[0]['id'],
		        			'created_at' 	=> $now,
		        		);
		        		$this->notification_model->create($notification_data);
					}
				}
			}
		}
		$this->session->set_flashdata('success', 'ok');
		redirect(base_url('dashboard/admin/message'));

	}

	public function message_edit($id) {
		$this->load->model('message_model');
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		$user 	= $this->user_model->find_by('id', $this->session->userdata('user_id'));
		$message 	= $this->message_model->find_by('id',$id)[0];
		$options = array(
			'base_url' 		=> base_url(),
			'title'			=> 'ویرایش پیام',
			'wallet' 		=> $wallet,
		);
		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'wallet'         => $wallet,
			'user' 			 => $user,
			'settings'		 => $this->settings_model->select(1),
			'message'			 => $message,
		);
		$this->parser->parse('dashboard/edit_message', $data);
	}

	public function message_validate_edit($id) {

		$this->load->model('message_model');
        $data = array();

        if(!empty($this->input->post('title'))) { $data['title'] = $this->input->post('title'); }
        if(!empty($this->input->post('text'))) { $data['text'] = $this->input->post('text'); }

        $message_id = $this->message_model->update($data, $id);

    	$this->session->set_flashdata('success', 'ok');
    	redirect(base_url('dashboard/admin/message/edit/'.$id));

	}

	public function message_delete($id) {
		$this->load->model('message_model');
		$this->load->model('notification_model');
		$notification = $this->notification_model->find_by('message_id', $id)[0];
		$this->notification_model->delete($notification['id']);
		$this->message_model->delete($id);
    	$this->session->set_flashdata('success', 'ok_delete');
    	redirect(base_url('dashboard/admin/message/'));
	}



	//////////////
	// News //
	//////////////
	public function news() {
		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian",
                IntlDateFormatter::FULL,
                    IntlDateFormatter::FULL,
                'Asia/Tehran',
                IntlDateFormatter::TRADITIONAL,
                "yyyy-MM-dd");
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		// $user = $this->menu_model->find_by('id', $this->session->userdata('user')['user_id'])[0];
		$options = array(
			'title'			=> 'پیام ها',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$raw_news = $this->news_model->all();
		$raw_news_rows = $this->news_model->count(NULL);
		$news = array();

		for ($i=0; $i < $raw_news_rows; $i++) {
			$time = new DateTime($raw_news[$i]['created_at']);
			if(!empty($this->user_model->find_by('id', $raw_news[$i]['id']))) {
				array_push($news,
					array(
						'raw_id'         => $raw_news[$i]['id'],
						'id' 			 => $i,
						'user'			=> NULL,
						'title' 	     => $raw_news[$i]['title'],
						'text' 	     => $raw_news[$i]['text'],
						'created_at' 	 => $formatter->format($time),
					)
				);
			} else {
				array_push($news,
					array(
						'raw_id'         => $raw_news[$i]['id'],
						'id' 			 => $i,
						'user'			=> $this->user_model->find_by('id', $raw_news[$i]['user_id'])[0],
						'title' 	     => $raw_news[$i]['title'],
						'text' 	     => $raw_news[$i]['text'],
						'created_at' 	 => $formatter->format($time),
					)
				);
			}
		}
		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'wallet'         => $wallet,
			'news' 		 => $news
		);
		$this->parser->parse('dashboard/list_news', $data);
	}

	public function create_news() {
		// $this->load->model('menu_model');
		// $this->load->model('group_model');
		$user 	= $this->user_model->find_by('id', $this->session->userdata('user_id'));
		// $groups = $this->group_model->all();
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		// $menus 	= $this->menu_model->all();
		$options = array(
			'base_url' 		=> base_url(),
			'title'			=> 'ساخت پیام',
			'wallet' 		=> $wallet,
		);
		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			// 'wallet'         => $wallet,
			'user' 			 => $user,
			'settings'		 => $this->settings_model->select(1),
			// 'groups' 		 => $groups,
			// 'parent_links'   => $this->menu_model->get_parent_links(),
		);
		$this->parser->parse('dashboard/create_news', $data);
	}


	public function news_validate() {
		$data = array();
		$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
		$now  = $date->format('Y-m-d H:i:s');
		$text = $this->input->post('text');
		$title = $this->input->post('title');
		$data = array(
			'user_id'		=> $this->session->userdata('user_id'),
			'title' 		=> $title,
			'text' 			=> $text,
			'created_at' 	=> $now,
		);
		$news_id = $this->news_model->create($data);
		if($news_id > 0) {
			$this->session->set_flashdata('success', 'ok');
			redirect(base_url('dashboard/admin/news'));
		} else {
			$this->session->set_flashdata('danger', 'bad');
			redirect(base_url('dashboard/admin/news'));
		}

	}

	public function news_edit($id) {
		$this->load->model('news_model');
		$wallet = $this->wallet_model->wallet($this->session->userdata('user')['user_id']);
		$user 	= $this->user_model->find_by('id', $this->session->userdata('user_id'));
		$news 	= $this->news_model->find_by('id',$id)[0];
		$options = array(
			'base_url' 		=> base_url(),
			'title'			=> 'ویرایش پیام',
			'wallet' 		=> $wallet,
		);
		$data = array(
			'base_url'       => base_url(),
			'header'         => $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'         => $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'    	 => $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'wallet'         => $wallet,
			'user' 			 => $user,
			'settings'		 => $this->settings_model->select(1),
			'news'			 => $news,
		);
		$this->parser->parse('dashboard/edit_news', $data);
	}

	public function news_validate_edit($id) {

		$this->load->model('news_model');
        $data = array();

        if(!empty($this->input->post('title'))) { $data['title'] = $this->input->post('title'); }
        if(!empty($this->input->post('text'))) { $data['text'] = $this->input->post('text'); }

        $news_id = $this->news_model->update($data, $id);

    	$this->session->set_flashdata('success', 'ok');
    	redirect(base_url('dashboard/admin/news/edit/'.$id));

	}

	public function news_delete($id) {
		$this->load->model('news_model');
		$this->news_model->delete($id);
    	$this->session->set_flashdata('success', 'ok_delete');
    	redirect(base_url('dashboard/admin/news/'));
	}





}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
