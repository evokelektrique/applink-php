<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('parser');
		$this->load->helper('captcha');
		$this->load->helper('cookie');
		$this->load->model('user_model');
		$this->load->model('captcha_model');
		$this->load->model('auth_token_model');
		if(empty($this->session->userdata('user')) && !empty(get_cookie('remember_me')) ) {
			list($selector, $authenticator) = explode(':', get_cookie('remember_me'));
			$row = $this->auth_token_model->find_by('selector', $selector);
			if(hash_equals($row[0]['token'], hash('sha256', base64_decode($authenticator)))) {
				$user_id = $row[0]['user_id'];
				$user_row = $this->user_model->select($user_id)[0];
				$user = array(
					'user_id' 		=> $user_row['id'],
					'username' 		=> $user_row['username'],
					'email' 		=> $user_row['email'],
					'name' 			=> $user_row['name'],
				);
				$this->session->set_userdata('user_id', $user_id);
				$this->session->set_userdata('user', $user);
				if($user_row['role'] == 1) {
					$this->session->set_userdata('admin', true);
				}
				$this->session->set_userdata('logged_in', true);
			}
		}
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
		$this->session->set_userdata('captcha', $captcha_data);
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

		$this->parser->parse('home/login', $data);
	}

	public function validate() {
		$this->load->model('login_model');
		$this->form_validation->set_rules(
			'username',
			'نام کاربری',
			'trim|required'
		);
		$this->form_validation->set_rules(
			'password',
			'رمز عبور',
			'required'
		);
		$this->form_validation->set_rules(
			'captcha',
			'کد امنیتی',
			'required'
		);
		$remember_me = $this->input->post('remember_me');
		if($this->form_validation->run() == FALSE) {
			// Error
			$this->index();
			// echo validation_errors();
		} else {
			$captcha = $this->session->userdata('captcha');
			$word = $this->input->post('captcha');
			if($this->captcha_model->captcha_exists($captcha, $word)) {
				// echo "Ok";
				$data = array(
					"username" => $this->input->post('username'),
					"password" => $this->input->post('password'),
				);
					// var_dump($data);
				$record = $this->login_model->auth($data);
				if($record) {
					// Success
					if($remember_me == 'on') {
						$selector = base64_encode(random_bytes(9));
						$authenticator = random_bytes(33);
						$name = 'remember_me';
						$value = $selector.':'.base64_encode($authenticator);
						$expire = time() + 864000;
						$cookie = array(
							'name'   => $name,
							'value'  => $value,
							'expire' => $expire,
						);
						$this->input->set_cookie($cookie);
						$this->auth_token_model->create(array(
							'selector' 	=> $selector,
							'token' 	=> hash('sha256', $authenticator),
							'user_id' 	=> $this->session->userdata('user')['user_id'],
							'expires' 	=> date('Y-m-d\TH:i:s', time() + 864000),
						));	
					}
					// var_dump($remember_me);
					// var_dump(get_cookie('remember_me'));
					redirect(base_url().'dashboard');
				} else {
					// Error
					$this->session->set_flashdata('warning','bad');
					redirect(base_url().'login');
				}
			} else {
				// echo "No";
				$this->session->set_flashdata('warning','captcha');
				redirect(base_url().'login');
			}
		}
	}


}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
