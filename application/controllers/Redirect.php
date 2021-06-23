<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redirect extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->model('link_model');
		$this->load->model('text_model');
		$this->load->model('captcha_model');
		$this->load->model('short_model');
		$this->load->helper('captcha');
	}

	public function index($short) {
		$text = $this->text_model->find_by('short',$short);
		$link = $this->link_model->find_by('short',$short);
		$type = NULL;
		$info = array();
		if(!empty($text)) { // Text
			$type = 'text';
			array_push($info,
				array(
					'type' 				=> 'text',
					'user_id' 			=> $text[0]['user_id'],
					'title' 			=> $text[0]['title'],
					'text' 				=> $text[0]['text'],
					'text_mode' 		=> $text[0]['text_mode'],
					'short' 			=> $text[0]['short'],
					'qrcode' 			=> $text[0]['qrcode'],
					'status' 			=> $text[0]['status'],
					'private_status' 	=> $text[0]['private_status'],
					'private_password' 	=> $text[0]['private_password'],
					'button' 			=> $text[0]['button'],
					'created_at' 		=> $text[0]['created_at'],
				));
		} elseif(!empty($link)) { // Link
			$type = 'link';
			array_push($info,
				array(
					'type' 				=> 'link',
					'user_id' 			=> $link[0]['user_id'],
					'address' 			=> $link[0]['address'],
					'short' 			=> $link[0]['short'],
					'qrcode' 			=> $link[0]['qrcode'],
					'status' 			=> $link[0]['status'],
					'private_status' 	=> $link[0]['private_status'],
					'private_password' 	=> $link[0]['private_password'],
					'button' 			=> $link[0]['button'],
					'created_at' 		=> $link[0]['created_at'],
				));
			$siteURL = parse_url(preg_replace( "/\r|\n/", "", $info[0]['address'] ));
			$url_scheme = $siteURL['scheme'];
			$url_host 	= $siteURL['host'];
			// Google
			// $googlePagespeedData = file_get_contents("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$url_scheme://$url_host&screenshot=true");
			// $googlePagespeedData = json_decode($googlePagespeedData, true);
			// $screenshot = $googlePagespeedData['screenshot']['data'];
			// $screenshot = str_replace(array('_','-'),array('/','+'),$screenshot); 
			// echo "<img src=\"data:image/jpeg;base64,".$screenshot."\" />";
			// $info['googlePagespeedData'] = $googlePagespeedData;
			$content = base64_encode(@file_get_contents("https://api.microlink.io/?url=".$url_scheme.'://'.$url_host."&screenshot=true&meta=false&embed=screenshot.url&waitFor=1000"));
			if($content === FALSE or $content == '') {
				$info['screenshot'] = base_url('src/images/404.png');
			} else {
				$info['screenshot'] = "data:image/png;base64,$content";
			}

		}

		$formatter = new IntlDateFormatter(
                "fa_IR@calendar=persian", 
                IntlDateFormatter::FULL, 
                    IntlDateFormatter::FULL, 
                'Asia/Tehran', 
                IntlDateFormatter::TRADITIONAL, 
                "yyyy-MM-dd");


		// $wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));

		$options = array(
			'title'			=> 'داشبورد',
			'base_url' 		=> base_url(),
		// 	// 'wallet' 		=> $wallet,
		);
		// $link = $this->link_model->find_by('short', $short);

		$data = array(
			'base_url' 			=> base_url(),
			'header'			=> $this->parser->parse('home/header', $options, TRUE),
			'footer'			=> $this->parser->parse('home/footer', $options, TRUE),
			'info' 				=> $info,
			'title' 			=> 'عنوان ریدایرکت',
		);
		if(!empty($info[0]['type'])) {
			switch ($info[0]['type']) {
				case 'text':
					if($text[0]['type'] == 'direct') {
						$this->load->model('click_model');
						$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
						$now  = $date->format('Y-m-d H:i:s');
						$text_data = array(
							'ip' 			=> $this->input->ip_address(),
							'link_id' 		=> $text[0]['id'],
							'user_id'	 	=> $text[0]['user_id'],
							'type' 			=> $text[0]['type'],
							'mode' 			=> 'text',
							'created_at' 	=> $now,
						);
						$record = $this->click_model->create($text_data);
						$data['text'] = $text;
						if($text[0]['private_status'] == 1) {
							$this->session->set_flashdata('password_confirmed', FALSE);
						} else {
							$this->session->set_flashdata('password_confirmed', TRUE);
						}
					} else {
						$captcha_values = array(
							'word'          => rand(1,999999),
							'img_path'      => './src/images/captcha/',
							'img_url'       => base_url('./src/images/captcha/'),
							'font_path'     => base_url().'./src/fonts/Roboto/Roboto-Black.ttf',
							'img_width'     => '100',
							'img_height'    => 31,
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
						$data['captcha'] = $captcha['image'];
						$data['text'] = $text;
						if($text[0]['private_status'] == 1) {
							$this->session->set_flashdata('password_confirmed', FALSE);
						} else {
							$this->session->set_flashdata('password_confirmed', TRUE);
						}
					}
					$this->parser->parse('home/show_text', $data);
					break;


				case 'link':
					if($link[0]['type'] == 'direct') {
						$this->load->model('click_model');
						$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
						$now  = $date->format('Y-m-d H:i:s');
						$data = array(
							'ip' 			=> $this->input->ip_address(),
							'link_id' 		=> $link[0]['id'],
							'user_id'	 	=> $link[0]['user_id'],
							'type' 			=> 'direct',
							'created_at' 	=> $now,
						);
						$record = $this->click_model->create($data);
						if($record > 0) {
							// Success
							redirect($link[0]['address']);
						} else {
							// Error
							$this->session->set_flashdata('warning','مشکلی پی آمد');
							redirect(base_url());
						}
					} else {
						$captcha_values = array(
							'word'          => rand(1,999999),
							'img_path'      => './src/images/captcha/',
							'img_url'       => base_url('./src/images/captcha/'),
							'font_path'     => base_url().'./src/fonts/Roboto/Roboto-Black.ttf',
							'img_width'     => '100',
							'img_height'    => 31,
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
						$data['captcha'] = $captcha['image'];
						$this->parser->parse('home/show_link', $data);
					}
					break;


				default:
					$this->parser->parse('home/404', $data);
					break;
			}

		} else {
			$this->parser->parse('home/404', $data);
		}
	}

	public function validate($short) {
		$this->load->model('click_model');
		$this->load->model('link_model');
		$text = $this->text_model->find_by('short',$short);
		$link = $this->link_model->find_by('short',$short);
		$type = NULL;
		if(!empty($text)) {
			$type = 'text';
		} else {
			$type = 'link';
		}
		$this->form_validation->set_rules('captcha', 'کد امنیتی', 'required|max_length[10]|trim');
		if($this->form_validation->run() === FALSE) { // Error
			$this->index($short);
		} else { // Success
			$captcha = $this->session->flashdata('captcha');
			$word = $this->input->post('captcha');
			if($this->captcha_model->captcha_exists($captcha, $word)) {
				$settings = $this->settings_model->select(1)[0];
				$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
				$now  = $date->format('Y-m-d H:i:s');
				$data = [];
				switch ($type) {
					case 'text':
						if($text[0]['private_status'] == 1) {
							$data = array(
								'ip' 			=> $this->input->ip_address(),
								'link_id' 		=> $text[0]['id'],
								'user_id'	 	=> $text[0]['user_id'],
								'type' 			=> $text[0]['type'],
								'mode' 			=> 'text',
								'amount' 		=> 0,
								'created_at' 	=> $now,
							);
						} else {
							$data = array(
								'ip' 			=> $this->input->ip_address(),
								'link_id' 		=> $text[0]['id'],
								'user_id'	 	=> $text[0]['user_id'],
								'type' 			=> $text[0]['type'],
								'mode' 			=> 'text',
								'amount' 		=> $settings['site_ptc_text_amount'],
								'created_at' 	=> $now,
							);
						}
						$record = $this->click_model->create($data);
						if($record > 0) {
							// Success
							$this->session->set_flashdata('pay_status', 1);
							redirect(base_url($short));
						} else {
							// Error
							$this->session->set_flashdata('warning','مشکلی پی آمد');
							redirect(base_url($short));
						}
						break;
					case 'link':
						$data = array(
							'ip' 			=> $this->input->ip_address(),
							'link_id' 		=> $link[0]['id'],
							'user_id'	 	=> $link[0]['user_id'],
							'type' 			=> $link[0]['type'],
							'mode' 			=> 'link',
							'amount' 		=> $settings['site_ptc_link_amount'],
							'created_at' 	=> $now,
						);
						$record = $this->click_model->create($data);
						if($record > 0) {
							// Success
							redirect($link[0]['address']);
						} else {
							// Error
							$this->session->set_flashdata('warning','مشکلی پی آمد');
							redirect(base_url($short));
						}
						break;
					default:
						redirect(base_url());
						break;
				}
			}else {
				$this->session->set_flashdata('warning','کد امنیتی نا معتبر');
				redirect(base_url($short));
			}
		}
	}
	public function validate_password($short) {
		$text = $this->text_model->find_by('short',$short);
		$this->form_validation->set_rules('password', 'رمز عبور', 'required');
		if($this->form_validation->run() === FALSE) { // Error
			$this->index($short);
		} else { // Success
			$password = $this->input->post('password');
			if($password == $text[0]['private_password']) {
				$this->session->set_flashdata('password_confirmed_true', TRUE);
				redirect(base_url($short));
			} else {
				$this->session->set_flashdata('warning','رمز عبور نا معتبر');
				redirect(base_url($short));
			}
		}
	}

}

/* End of file Redirect.php */
/* Location: ./application/controllers/Redirect.php */