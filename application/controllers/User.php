<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form', 'captcha'));
    $this->load->model('user_model');
  }

  public function login()
  {
    // Check Session
    if ( $this->session->userdata('logged_in') ) {
      if ( $this->session->userdata('level') == 1 ) {
        redirect('admin');
      } else if ( $this->session->userdata('level') == 2 ) {
        redirect('/locksmith');
      } else if ( $this->session->userdata('level') == 3 ) {
        redirect('/customer');
      }
    }

    // create the data object
    $data = new stdClass();
    $this->load->helper('form');
    $this->load->library('form_validation');

    // set validation rules
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('user/login', $data);
      $this->load->view('footer');
    } else {
      // set variables from the form
      $data->email = $email = $this->input->post('email');
      $data->password = $password = $this->input->post('password');
     // $data->level = $level = 2;

      if ($this->user_model->resolve_admin_lock_login($data)) {
        $user_id = $this->user_model->get_user_id_from_email_admin_lock($data);
        $user    = $this->user_model->get_user($user_id);

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

        // user login ok now send it for shaffaf password
        if ( $user->level == 1 ) {
          redirect('/admin');
        } else if ( $user->level == 2 ) {
          redirect('/locksmith');
        } else if ( $user->level == 3 ) {
          redirect('/customer');
        }
      } else {
        // login failed
        $data->usererror = 'Wrong email or password.';

        // send error to the view
        $this->load->view('header');
        $this->load->view('user/login', $data);
        $this->load->view('footer');
      }
    }
  }

  /**
   * signup function.
   * 
   * @access public
   * @return void
   */
  public function signup()
  {
    // create the data object
    $data = new stdClass();

    // Check Session
    if ( $this->session->userdata('logged_in') ) {
      if ( $this->session->userdata('level') == 1 ) {
        redirect('admin');
      } else if ( $this->session->userdata('level') == 2 ) {
        redirect('/locksmith');
      } else if ( $this->session->userdata('level') == 3 ) {
        redirect('/customer');
      }
    }

    // load form helper and validation library
    $this->load->helper('form');
    $this->load->library('form_validation');

    // set validation rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
    $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

    if ($this->form_validation->run() === false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('user/signup', $data);
      $this->load->view('footer');
    } else {
      // set variables from the form
      $data->email = $this->input->post('email');
      $data->password = $this->input->post('password');
      $data->name = $this->input->post('name');
      $data->creation_date = date("Y-m-d H:i:s", strtotime("now"));
      $data->level = 2;
      $data->status = 1;

      if ($id = $this->user_model->create_user($data)) {
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
          'user_id'           => (int) $id,
          'name'              => (string) $user->name,
          'image'             => (string) $user->image,
          'email'             => (string) $this->input->post('email'),
          'logged_in'         => (bool) true,
          'level_id'          => (bool) 2,
          'status'            => (bool) 1
        ));

        redirect('locksmith');
      } else {
        // user creation failed, this should never happen
        $data->error = 'There was a problem creating your new account. Please try again.';

        // send error to the view
        $this->load->view('header');
        $this->load->view('user/signup', $data);
        $this->load->view('footer');
      }
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect('/');
  }

  public function forgotpassword()
  {
    if ( $this->session->userdata('logged_in') ) {
      redirect('/');
    }

    // create the data object
    $data = new stdClass();

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

    if ($this->form_validation->run() == false) {
      $this->load->view('user/forgotpassword');
    } else {
      if ( $id = $this->user_model->get_user_id_from_email( $this->input->post('email') ) ) {
        $user = $this->user_model->get_user($id);
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from('info@locksmith.com', 'LockSmith');
        $this->email->to($this->input->post('email'));
        $this->email->subject("Locksmith password reset link");

        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $encoded_email = urlencode(
          mcrypt_encrypt(
            MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $this->input->post('email'), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) )
          )
        );

        $message = $this->load->view('email/forgotpassword', array(
          'email' => $this->input->post('email'),
          'user' => $user,
          'param' => $encoded_email,
          'message_body' => 'Please click the link below to change your password.'
        ), true);
        $this->email->message($message);
        $this->email->send();

        $data->success = 'We have sent a link to reset your password to '.$this->input->post('email').'. After resetting your password, please click <a href="">here</a> to continue.';
        $this->load->view('user/forgotpassword', $data);
      } else {
        $data->error = 'Email does not exist.';
        $this->load->view('user/forgotpassword', $data);
      }
    }
  }

  public function resetpassword()
  {
    if ( empty($this->uri->segment(3)) == true ) {
      redirect('/');
    }
    
    $segment = $this->uri->segment(3);
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $decoded_email = rtrim(
      mcrypt_decrypt(
        MCRYPT_RIJNDAEL_256, md5( $cryptKey ), urldecode( $segment ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) )
      ),
    "\0");

    $user_id = $this->user_model->get_user_id_from_email($decoded_email);
    $user = $this->user_model->get_user($user_id);

    // create the data object
    $data = new stdClass();
    $data->user = $user;
    $data->uri = $segment;

    if ( $this->session->userdata('logged_in') ) {
      $this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required');
    }
    $this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|min_length[6]');
    $this->form_validation->set_rules('con_new_pass', 'Confirm New Password', 'trim|required|min_length[6]|matches[new_pass]');

    if ($this->form_validation->run() == false) {
      $this->load->view('user/resetpassword', $data);
    } else {
      $data2 = new stdClass();
      $data2->password = $this->input->post("new_pass");
      $data2->id = $user_id;
      $this->user_model->update_user($data2);

      $this->load->library('email');
      $this->email->set_mailtype("html");
      $this->email->from('info@locksmith.com', 'LockSmith');
      $this->email->to($decoded_email);
      $this->email->subject("Your Locksmith account information has been updated");

      $message = $this->load->view('email/passwordresetsuccess', array(), true);
      $this->email->message($message);
      $this->email->send();

      if ( !$this->session->userdata('logged_in') ) {
        redirect('user/passwordresetsuccess');
      }
    }
  }

  public function passwordresetsuccess()
  {
    $this->load->view('user/passwordresetsuccess');
  }

  public function verify()
  {
    if ( empty($this->uri->segment(3)) == true ) {
      redirect('/');
    }
    
    $segment = $this->uri->segment(3);
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $decoded_email = rtrim(
      mcrypt_decrypt(
        MCRYPT_RIJNDAEL_256, md5( $cryptKey ), urldecode( $segment ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) )
      ),
    "\0");

	//echo "UID: ".$decoded_email." - ";
	$data = new stdClass();
	$data->email = $decoded_email;
    $user_id = $this->user_model->get_user_id_from_email($data);
	//echo "UID: ".$user_id." - ";
    $user = $this->user_model->get_user($user_id);
	//print_r($user);
    // create the data object
    $data = new stdClass();
    if ( count($user) > 0 ) {
      $data2 = new stdClass();
      $data2->id = $user_id;
      $data2->verified = 1;
      $this->user_model->update_user($data2);
      $data->message = 'Congraulation! You are verified.';
      $data->status = 1;
    } else {
      $data->message = 'No user found.';
      $data->status = 0;
    }

    $this->load->view('user/verify', $data);
  }

}
