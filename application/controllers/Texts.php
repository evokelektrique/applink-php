<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Texts extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->model('text_model');
		$this->load->model('click_model');
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
		$raw_texts = $this->text_model->find_by('user_id',$this->session->userdata('user')['user_id']);
		$raw_texts_rows = count($raw_texts);
		$texts = array();
		if($raw_texts_rows > 0) {
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
						'type' => $raw_texts[$i]['type'],
						'created_at' => $formatter->format($time),
						'modified_at' => $raw_texts[$i]['modified_at'],
					)
				);
			}
		}

		$data = array(
			'base_url' 			=> base_url(),
			'header'			=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'			=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar' 			=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'texts' 			=> $texts,
		);
		$this->parser->parse('dashboard/list_texts', $data);
	}

	public function qrcode($filename) {
		$url = base_url("./src/images/qrcodes/$filename.png");
		echo "<img src='$url' />";
	}

	public function delete($id) {
		$text = $this->text_model->select($id)[0];
		if($text['user_id'] !== $this->session->userdata('user')['user_id']) {
			redirect(base_url('dashboard/texts'));
		}
		if(empty($text)) {
			redirect(base_url('dashboard/texts'));
		}

		$qrfilename = $text['qrcode'];
		unlink(APPPATH."../src/images/qrcodes/$qrfilename.png");
		$this->text_model->delete($id);
		$this->session->set_flashdata('success','delete');
		redirect(base_url('texts'));
	}


	public function edit($id) {
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
		if($raw_text['user_id'] !== $this->session->userdata('user')['user_id']) {
			redirect(base_url('dashboard/texts'));
		}
		if(empty($raw_text)) {
			redirect(base_url('dashboard/texts'));
		}
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
				'text_mode' 		=> $raw_text['text_mode'],
				'button' 			=> $raw_text['button'],
				'type' 				=> $raw_text['type'],
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

	public function validate_edit($id) {
		$text = $this->text_model->select($id)[0];
		if($text['user_id'] !== $this->session->userdata('user')['user_id']) {
			redirect(base_url('dashboard/texts'));
		}
		if(empty($text)) {
			redirect(base_url('dashboard/texts'));
		}

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



			// if($this->generate_qrcode($data['address'], $text['qrcode'])) {
			$this->text_model->update($data, $id);
			$this->session->set_flashdata('success', 'ok');
			redirect(base_url("dashboard/texts/edit/$id"));
				// $this->session->set_flashdata('danger', 'bad');
				// redirect(base_url("dashboard/texts/edit/$id"));

		}
	}

	private function generate_qrcode($url,$name) {
		$qrimage = file_get_contents("https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$url&choe=UTF-8");
		if ( ! write_file("./src/images/qrcodes/$name.png", $qrimage)) {
		        return FALSE;
		} else {
		        return TRUE;
		}
	}
}

/* End of file Texts.php */
/* Location: ./application/controllers/Texts.php */