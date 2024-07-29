<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form'));
    $this->load->model(array('user_model', 'page_model', 'content_model'));
    if ( $this->session->userdata('logged_in') ) {
      if ( $this->session->userdata('level') == 1 ) {
        redirect('admin/locksmith');
      } else if ( $this->session->userdata('level') == 2 ) {
        redirect('/locksmith');
      } else if ( $this->session->userdata('level') == 2 ) {
        redirect('/customer');
      }
    }
  }

  public function index()
  {
    // create the data object
    $data = new stdClass();

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'Password', '');
    $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim');
    $this->form_validation->set_rules('city', 'City', 'trim');
    $this->form_validation->set_rules('invite_code', 'Invite Code', 'trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('home');
    } else {
      $name = $this->input->post('name');
      $data->email = $this->input->post('email');
      $data->password = $this->input->post('password');
      $data->name = $name[0] . ' ' . $name[1];
      $data->contact_no = $this->input->post('contact_no');
      $data->city = $this->input->post('city');
      $data->level = 2;
      $data->status = 1;
      $data->creation_date = date("Y-m-d H:i:s", strtotime("now"));
      if ( $id = $this->user_model->create_user($data) ) {
        $user    = $this->user_model->get_user($id);

        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from('info@locksmith.com', 'LockSmith');
        $this->email->to($this->input->post('email'));
        $this->email->subject("Locksmith verify email");
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $encoded_email = urlencode(
          mcrypt_encrypt(
            MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $this->input->post('email'), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) )
          )
        );

        $message = $this->load->view('email/verify', array(
          'email' => $this->input->post('email'),
          'user' => $user,
          'param' => $encoded_email
        ), true);
        $this->email->message($message);
        $this->email->send();

        // set session user data
        $this->session->set_userdata(array(
          'user_id'           => (int) $user->id,
          'name'              => (string) $user->name,
          'image'             => (string) $user->image,
          'email'             => (string) $user->email,
          'level'             => $user->level,
          'status'            => $user->status,
          'logged_in'         => (bool) true
        ));

        redirect('/locksmith');
      }
      $this->load->view('home');
    }
  }

  public function slugpages()
  {
    // create the data object
    $data = new stdClass();

    $uri = str_replace("/", "", $_SERVER['REQUEST_URI']);
    $data->page = $page = $this->page_model->getPageBySlug($uri);
    if ( $page->section == 1 ) {
      $data->contents = $this->content_model->getPagesContentforHome($page->id);
    }

    $this->load->view("layout/pagesheader");
    $this->load->view("slugpages", $data);
    $this->load->view("layout/pagesfooter");
  }
}
