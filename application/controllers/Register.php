<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->library('encryption');
		$this->load->helper('captcha');
		$this->load->model('captcha_model');
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
			'title'			=> 'ثبت نام',
			'base_url' 		=> base_url(),
		);
		$data = array(
			'base_url' 			=> base_url(),
			'header'			=> $this->parser->parse('home/header', $options, TRUE),
			'footer'			=> $this->parser->parse('home/footer', $options, TRUE),
			'captcha'			=> $captcha['image']
		);
		$this->parser->parse('home/register', $data);
	}


	public function validate() {
		$this->load->model('register_model');
		$this->form_validation->set_rules(
			'username',
			'نام کاربری',
			'trim|required|is_unique[users.username]|min_length[5]|max_length[20]'
		);
		$this->form_validation->set_rules(
			'email',
			'ایمیل',
			'trim|valid_email|is_unique[users.email]|required'
		);
		$this->form_validation->set_rules(
			'password',
			'رمز عبور',
			'required|min_length[8]'
		);
		$this->form_validation->set_rules(
			'password_repeat',
			'تکرار رمز عبور',
			'required|matches[password]'
		);
		$this->form_validation->set_rules(
			'captcha',
			'کد امنیتی',
			'required'
		);
		if($this->form_validation->run() == FALSE) {
			// Error
			$this->index();
			// echo validation_errors();
		} else {
			$this->input->post('toscheck');
			// Check TOS
			if ($this->input->post('toscheck') != 'on') {
				$this->session->set_flashdata('warning','لطفا تیک "شرایط سرویس را خوانده‌ام و موافق هستم." را قبول کنید.');
				
				$this->index();
			} else {
				// Success
				$captcha = $this->session->flashdata('captcha');
				$word = $this->input->post('captcha');
				if($this->captcha_model->captcha_exists($captcha, $word)) {
					$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
					$now  = $date->format('Y-m-d H:i:s');
					$data = array(
						'username' 		=> $this->input->post('username'),
						'email' 		=> $this->input->post('email'),
						'password' 		=> $this->encryption->encrypt($this->input->post('password')),
						'created_at' 	=> $now,
					);
					$record = $this->register_model->save($data);
					if($record > 0) {
						// Success
						$this->session->set_flashdata('success','ok');
						redirect(base_url().'login');
					} else {
						// Error
						$this->session->set_flashdata('warning','مشکلی در ثبت نام بوجود آمد');
						redirect(base_url().'register');
					}
				}
			}
		}

	}

}

/* End of file Register.php */
/* Location: ./application/controllers/Register.php */