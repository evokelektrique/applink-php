<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('form_validation');
		$this->load->model('link_model');
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
		$raw_links = $this->link_model->find_by('user_id',$this->session->userdata('user')['user_id']);
		$raw_links_rows = count($raw_links);
		$links = array();
		if($raw_links_rows > 0) {
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
						'type' => $raw_links[$i]['type'],
						'short' => base_url($raw_links[$i]['short']),
						'qrcode' => $raw_links[$i]['qrcode'],
						'clicks' => $clicks,
						'chartdata' => $chartdata,
						'created_at' => $formatter->format($time),
						'modified_at' => $raw_links[$i]['modified_at'],
					)
				);
			}
		}
		$data = array(
			'base_url' 			=> base_url(),
			'header'			=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'			=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar' 			=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
			'links' 			=> $links,
		);
		$this->parser->parse('dashboard/list_links', $data);
	}

	public function qrcode($filename) {
		$url = base_url("./src/images/qrcodes/$filename.png");
		echo "<img src='$url' />";
	}

	public function delete($id) {
		$link = $this->link_model->select($id)[0];
		if($link['user_id'] !== $this->session->userdata('user')['user_id']) {
			redirect(base_url('dashboard/links'));
		}
		if(empty($link)) {
			redirect(base_url('dashboard/links'));
		}
		$qrfilename = $link['qrcode'];
		unlink(APPPATH."../src/images/qrcodes/$qrfilename.png");
		$this->link_model->delete($id);
		$this->session->set_flashdata('success','delete');
		redirect(base_url('dashboard/links'));
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
		$raw_link = $this->link_model->select($id)[0];
		// $raw_links_rows = $this->link_model->count();
		if($raw_link['user_id'] !== $this->session->userdata('user')['user_id']) {
			redirect(base_url('dashboard/links'));
		}
		if(empty($raw_link)) {
			redirect(base_url('dashboard/links'));
		}

		$time = new DateTime($raw_link['created_at']);
		$link = array(
			array(
				'id' => $raw_link['id'],
				'user_id' => $raw_link['user_id'],
				'user_ip' => $raw_link['user_ip'],
				'address' => $raw_link['address'],
				'short' => $raw_link['short'],
				'shortaddress' => base_url($raw_link['short']),
				'type' => $raw_link['type'],
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

	public function validate_edit($id) {
		$link = $this->link_model->select($id)[0];
		if($link['user_id'] !== $this->session->userdata('user')['user_id']) {
			redirect(base_url('dashboard/links'));
		}
		if(empty($link)) {
			redirect(base_url('dashboard/links'));
		}

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
			redirect(base_url("dashboard/links/edit/$id"));
				// $this->session->set_flashdata('danger', 'bad');
				// redirect(base_url("dashboard/links/edit/$id"));

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

/* End of file Links.php */
/* Location: ./application/controllers/Links.php */