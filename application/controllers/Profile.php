<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('form_validation');
		$this->load->library('parser');
		$this->load->model('wallet_model');
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url('login'));
		}
	}

	public function index() {
		$wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));
    $user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id']);
    // var_dump($user);
		$options = array(
			'base_url' 		=> base_url(),
      'title'			  => 'تنظیمات حساب کاربری',
			'wallet' 		  => $wallet,
		);
		$data = array(
			'base_url' 			=> base_url(),
			'header'			  => $this->parser->parse('dashboard/header',   $options, TRUE),
			'footer'			  => $this->parser->parse('dashboard/footer',   $options, TRUE),
			'sidebar'			  => $this->parser->parse('dashboard/sidebar',  $options, TRUE),
      'user'          => $user,
		);
		$this->parser->parse('dashboard/profile', $data);
	}


  public function validate() {
    $data = array();
    $name         = $this->input->post('name');
    $phone        = $this->input->post('phone');
    $bankaddress  = $this->input->post('bankaddress');
    if(!empty($name))         { $data['name'] = $name; }
    if(!empty($bankaddress))  { $data['bankaddress'] = $bankaddress; }
    if(!empty($phone))        {
      $data['phone'] = $phone;
      if(strlen($data['phone']) <= 11) {
          // Pass [Success]
      } else {
          // Error
          $this->session->set_flashdata('danger', 'bad');
          $this->index();
      }
    }
    if(!empty($data)) {
        // Success
        $user_id = $this->session->userdata('user')['user_id'];
        $this->user_model->update($data,$user_id);
        $this->session->set_flashdata('success', 'ok');
        redirect(base_url('dashboard/profile'));
    } else {
        // Error
        $this->session->set_flashdata('danger', 'bad');
        $this->index();
    }

  }






  public function change_password() {
    $wallet = $this->wallet_model->wallet($this->session->userdata('user_id'));
    $user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id']);
    // var_dump($user);
		$options = array(
			'base_url' 		=> base_url(),
      'title'			  => 'تغییر رمز عبور',
			'wallet' 		  => $wallet,
		);
		$data = array(
			'base_url' 			=> base_url(),
			'header'			  => $this->parser->parse('dashboard/header',   $options, TRUE),
			'footer'			  => $this->parser->parse('dashboard/footer',   $options, TRUE),
			'sidebar'			  => $this->parser->parse('dashboard/sidebar',  $options, TRUE),
      'user'          => $user,
		);
		$this->parser->parse('dashboard/change_password', $data);
  }


  public function validate_password() {
    $this->load->library('encryption');
    $user = $this->user_model->find_by('id', $this->session->userdata('user')['user_id'])[0];
    $this->form_validation->set_rules('current_password', 'رمز عبور فعلی', 'required|min_length[8]|max_length[32]');
    $this->form_validation->set_rules('password', 'رمز عبور جدید', 'required|min_length[8]|max_length[32]');
    $this->form_validation->set_rules('password_repeat', 'تکرار رمز عبور جدید', 'required|min_length[8]|max_length[32]|matches[password]');
    if($this->form_validation->run() == FALSE) {
      // Error
      $this->change_password();
    } else {
      // Success
      $decrypted_password = $this->encryption->decrypt($user['password']);
      $current_password = $this->input->post('current_password');
      if($current_password == $decrypted_password) {
        // Success
        $new_password = $this->input->post('password');
        $user_data = array(
          'password' => $this->encryption->encrypt($new_password),
        );
        $this->user_model->update($user_data, $user['id']);
        $this->session->set_flashdata('success', 'ok');
        redirect(base_url('dashboard/profile/change_password'));
      } else {
        // Error
        $this->session->set_flashdata('danger', 'bad');
        redirect(base_url('dashboard/profile/change_password'));
      }

    }

  }






}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */
