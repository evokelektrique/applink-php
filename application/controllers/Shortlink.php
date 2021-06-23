<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shortlink extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('link_model');
		$this->load->model('short_model');
		$this->load->library('math');
		$this->load->library('form_validation');
		$this->load->library('parser');
		$this->load->helper('file');
		$this->load->model('wallet_model');
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
	}

	public function index() {
		$wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));

		$options = array(
			'title'			=> 'ثبت نام',
			'base_url' 		=> base_url(),
			'wallet' 		=> $wallet,
		);
		$data = array(
			'base_url' 			=> base_url(),
			'header'			=> $this->parser->parse('dashboard/header', $options, TRUE),
			'footer'			=> $this->parser->parse('dashboard/footer', $options, TRUE),
			'sidebar'			=> $this->parser->parse('dashboard/sidebar', $options, TRUE),
		);
		$this->parser->parse('dashboard/shortlink', $data);
	}

	public function gen_uuid() {
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

	public function single() {
		$this->form_validation->set_rules('url', 'لینک', 'required');

		if($this->form_validation->run() == FALSE) {
			$this->index();
			// redirect(base_url('dashboard'));
		} else {
			$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
			$now  = $date->format('Y-m-d H:i:s');
			$link_data = array(
				'address' 		=> $this->input->post('url'),
				'created_at' 	=> $now,
				'user_ip'		=> $this->input->ip_address(),
				'type'			=> 'direct',
				'user_id' 		=> $this->session->userdata('user_id'),
			);
			$short_data = array(
				'linked_id' 	=> NULL,
				'user_id' 		=> $this->session->userdata('user_id'),
				'type' 			=> 'link',
				'created_at' 	=> $now,
			);


			$qrfilename = $this->gen_uuid();
			$record_id = $this->link_model->create($link_data);
			$short_data['linked_id'] = $record_id;
			$short_id = $this->short_model->create($short_data);
			$short_url = $this->math->to_base($short_id, 62);
			$address = base_url($short_url);
			$data2 = array(
				'short' => $short_url,
				'qrcode' => $qrfilename,
			);
			$this->link_model->update($data2, $record_id);
			if($this->qrcode($address, $qrfilename)) {
				$this->session->set_flashdata('success', 'ok');
				$this->session->set_flashdata('address', $address);
				redirect(base_url('dashboard/links'));
			} else {
				// Error
			}

		}
	}

	public function group() {
		$this->form_validation->set_rules(
			'links',
			'لینک ها',
			'required'
		);		
		$this->form_validation->set_rules(
			'type',
			'حالت لینک',
			'required'
		);
		if($this->form_validation->run() == FALSE) {
			// Error
			$this->index();
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
			$raw_links = explode("\n", $this->input->post('links'));
			$links = array(); 
			foreach ($raw_links as $link) {
				if($this->valid_url($link)) {
					$date = new DateTime("now", new DateTimeZone('Asia/Tehran') );
					$now  = $date->format('Y-m-d H:i:s');
					array_push($links, array(
						'address' 		=> $link,
						'created_at' 	=> $now,
						'user_ip'		=> $this->input->ip_address(),
						'type'			=> $type,
						'user_id' 		=> $this->session->userdata('user_id'),
						)
					);
				} else {
					$this->session->set_flashdata('danger', 'badgroup');
					redirect(base_url('dashboard/shortlink'));
				}
		
			}
			foreach($links as $link) {
				$short_data = array(
					'linked_id' 	=> NULL,
					'user_id' 		=> $this->session->userdata('user_id'),
					'type' 			=> 'link',
					'created_at' 	=> $now,
				);
				$qrfilename = $this->gen_uuid();
				$record_id = $this->link_model->create($link);
				$short_data['linked_id'] = $record_id;
				$short_id = $this->short_model->create($short_data);
				$short_url = $this->math->to_base($short_id, 62);
				$address = base_url($short_url);
				$data = array(
					'short' => $short_url,
					'qrcode' => $qrfilename,
				);
				$this->link_model->update($data, $record_id);
				$qrcode = $this->qrcode($address, $qrfilename);
			}
			$this->session->set_flashdata('success', 'okgroup');
			redirect(base_url('dashboard/links'));
		}
	}

	private function qrcode($url,$name) {
		$qrimage = file_get_contents("https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$url&choe=UTF-8");
		if ( ! write_file("./src/images/qrcodes/$name.png", $qrimage)) {
		        return FALSE;
		} else {
		        return TRUE;
		}
	}

	private function valid_url($url) {
	    if (filter_var($url, FILTER_VALIDATE_URL) || array_key_exists('scheme', parse_url($url))) {
		    return TRUE;
	    } else {
	        return FALSE;
	    }
	}
}

/* End of file Shortlink.php */
/* Location: ./application/controllers/Shortlink.php */