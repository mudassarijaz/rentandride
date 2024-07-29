<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->library('session');
    if ( !$this->session->userdata('logged_in') ) {
      redirect('/user/login');
    }
    if ( $this->session->userdata('logged_in') ) {
      if ( $this->session->userdata('level') == 1 ) {
        redirect('admin/locksmith');
      } else if ( $this->session->userdata('level') == 2 ) {
        redirect('locksmith/index');
      } else if ( $this->session->userdata('level') == 3 ) {
        redirect('customer/index');
      }
    }
  }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
}
