<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recover extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->helper('captcha');
		$this->load->model('captcha_model');
		$this->load->model('user_model');
		$this->load->model('recover_model');
		if($this->session->userdata('logged_in')) {
			redirect(base_url('dashboard'));
		}
	}

	public function index() {
		$captcha_values = array(
			'word'          => rand(1,999999),
			'img_path'      => './src/images/captcha/',
			'img_url'       => base_url('./src/images/captcha/'),
			'font_path'     => base_url().'./src/fonts/Roboto/Roboto-Black.ttf',
			'img_width'     => '100',
			'img_height'    => 32,
			'word_length'   => 8,
			'colors'        => array(
				'background'     => array(255, 255, 255),
				'border'         => array(255, 255, 255),
				'text'           => array(0, 0, 0),
				'grid'           => array(255, 75, 100)
			)
		);
		$captcha = create_captcha($captcha_values);
		$captcha_data = array(
		    'captcha_time'  => round($captcha['time']),
		    'ip_address'    => $this->input->ip_address(),
		    'word'          => $captcha['word']
        );
		$this->captcha_model->save_captcha($captcha_data);
		$this->session->set_flashdata('captcha', $captcha_data);
		$options = array(
			'title'			=> 'ورود',
			'base_url' 		=> base_url(),
		);
		$data = array(
			'base_url' 			=> base_url(),
			'header'			=> $this->parser->parse('home/header', $options, TRUE),
			'footer'			=> $this->parser->parse('home/footer', $options, TRUE),
			'captcha'			=> $captcha['image']
		);

		$this->parser->parse('home/recover', $data);
	}

	public function validate() {
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.googlemail.com';
		$config['smtp_user'] = 'evoke.lektrique@gmail.com';
		$config['smtp_pass'] = '1.Programmer@3412!1';
		$config['smtp_port'] = 465; 
		$config['smtp_timeout'] = 5;
		$config['wordwrap'] = TRUE;
		$config['wrapchars'] = 76;
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['validate'] = FALSE;
		$config['priority'] = 3;
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['bcc_batch_mode'] = FALSE;
		$config['bcc_batch_size'] = 200;
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->load->model('login_model');
		$this->form_validation->set_rules(
			'email',
			'ایمیل',
			'trim|required|valid_email'
		);		
		$this->form_validation->set_rules(
			'captcha',
			'کد امنیتی',
			'required'
		);
		if($this->form_validation->run() == FALSE) {
			// Error
			$this->index();
		} else {
			$captcha = $this->session->flashdata('captcha');
			// if($this->captcha_model->captcha_exists($captcha)) {
			$input_data = array(
				"email" => $this->input->post('email'),
			);
			$user = $this->user_model->find_by('email', $input_data['email'])[0];
			if(!empty($user)) {
				// Success
				$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
				$now  = $date->format('Y-m-d H:i:s');
				$token = $this->gen_uuid();
				$data = array(
					'title'			=> 'اپلینک',
					'base_url' 		=> base_url(),
					'token'			=> $token,
				);
				$create_data = array(
					'user_id'		=> $user['id'],
					'email' 		=> $input_data['email'],
					'token'			=> $token,
					'created_at'	=> $now,
				);
				var_dump($user);
				$this->recover_model->create($create_data, $user['id']);
				$this->email->from('evoke.lektrique@gmail.com', 'evoke.lektrique@gmail.com');
				$this->email->to('pacof79638@tmailpro.net');
				$this->email->subject('بازیابی رمز عبور');
				$this->email->message($this->parser->parse('home/email', $data, TRUE));
				$this->email->send();

				$this->session->set_flashdata('success','ok');
				redirect(base_url().'recover');
			} else {
				// Error
				$this->session->set_flashdata('warning','bad');
				redirect(base_url().'recover');
			}
		}
	}

	public function token($token) {
		$record = $this->recover_model->find_by('token', $token)[0];
		if(!empty($record)) { // Success
			if($record['status'] == 0) { // Success
				$options = array(
					'title'			=> 'بازیابی رمز - رمز جدید',
					'base_url' 		=> base_url(),
				);
				$data = array(
					'base_url' 			=> base_url(),
					'header'			=> $this->parser->parse('home/header', $options, TRUE),
					'footer'			=> $this->parser->parse('home/footer', $options, TRUE),
					'token' 			=> $token,
				);
				$this->parser->parse('home/reset_password', $data);		

			} else { // Error

				redirect(base_url());
			}
		} else { // Error
				
			redirect(base_url());
		}
	}

	public function validate_token($token) {
		$this->load->library('encryption');
		$this->form_validation->set_rules('password', 'رمز عبور جدید', 'required|max_length[32]');
		if($this->form_validation->run() == FALSE) { // Error
			$this->token($token);
		} else { // Success
			$data = array('status' => '1');
			$record = $this->recover_model->find_by('token', $token)[0];
			$this->recover_model->update($data, $record['id']);
			$user = $this->user_model->find_by('email', $record['email'])[0];
			$user_data = array(
				'password' => $this->encryption->encrypt($this->input->post('password')),
			);
			$user_record = $this->user_model->update($user_data, $user['id']);
			$this->session->set_flashdata('success', 'recover');
			redirect(base_url("login"));
		}
	}


	private function gen_uuid() {
	    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

	        // 16 bits for "time_mid"
	        mt_rand( 0, 0xffff ),

	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand( 0, 0x0fff ) | 0x4000,

	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand( 0, 0x3fff ) | 0x8000,

	        // 48 bits for "node"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	} 

}



/* End of file Recover.php */
/* Location: ./application/controllers/Recover.php */