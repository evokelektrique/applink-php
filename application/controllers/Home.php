<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
	}

	public function index() {
		$options = array(
			'title'			=> 'خانه',
			'base_url' 		=> base_url(),
		);
		$data = array(
			'header'			=> $this->parser->parse('home/header', $options, TRUE),
			'footer'			=> $this->parser->parse('home/footer', $options, TRUE),
		);
		$this->parser->parse('home/index', $data);
	}

	public function error_404() {
		$options = array(
			'base_url' 		=> base_url(),
		);
		$data = array(
			'base_url' 		=> base_url(),
			'title'			=> '404 - صفحه پیدا نشد',
			'footer'			=> $this->parser->parse('home/footer', $options, TRUE),
		);
		$this->parser->parse('home/404', $data);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */