<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form', 'captcha', 'form'));
    $this->load->model(array('user_model', 'price_model', 'type_model', 'order_model'));

    if ( !$this->session->userdata('logged_in') ) {
      if ( $_SERVER['REQUEST_URI'] != '/customer/signup' && $_SERVER['REQUEST_URI'] != '/customer/login' ) {
        redirect('/');
      }
    }
  }

  public function index()
  {
    // create the data object
    if ( $this->session->userdata('logged_in') ) {
      if ( $this->session->userdata('level') == 1 ) {
        redirect('admin/locksmith');
      } else if ( $this->session->userdata('level') == 2 ) {
        redirect('/locksmith');
      }
    } else {
      redirect('/');
    }

    $id = $this->session->userdata('user_id');
    $customer = $this->user_model->get_user($id);

    $this->load->view('layout/header');
    $this->load->view('customer/index', $customer);
    $this->load->view('layout/footer');
  }

  public function login()
  {
    // Check Session
    if ( $this->session->userdata('logged_in') ) {
      if ( $this->session->userdata('level') == 1 ) {
        redirect('admin/locksmith');
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
      $this->load->view('customer/login', $data);
    } else {
      // set variables from the form
      $data->email = $email = $this->input->post('email');
      $data->password = $password = $this->input->post('password');
      $data->level = $level = 3;

      if ($this->user_model->resolve_user_login($data)) {
        $user_id = $this->user_model->get_user_id_from_email($data);
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
          redirect('/admin/locksmith');
        } else if ( $user->level == 2 ) {
          redirect('/locksmith/index');
        } else if ( $user->level == 3 ) {
          redirect('/customer');
        }
      } else {
        // login failed
        $data->usererror = 'Wrong email or password.';

        // send error to the view
        $this->load->view('customer/login', $data);
      }
    }
  }

  public function orders()
  {
    $data = new stdClass();
    $data->orders = $this->order_model->getCustomerOrders($this->session->userdata('user_id'));

    $this->load->view('layout/header');
    $this->load->view('customer/orders', $data);
    $this->load->view('layout/footer');
  }

  public function orderdetail()
  {
    $id = $this->uri->segment(3);
    $order = $this->order_model->get_order($id);

    $this->load->view('layout/header');
    $this->load->view('customer/orderdetail', $order);
    $this->load->view('layout/footer');
  }

  public function signup()
  {
    if ( $this->session->userdata('logged_in') ) {
      redirect('/customer');
    }
    // create the data object
    $data = new stdClass();

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', '');
    $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim');
    $this->form_validation->set_rules('city', 'City', 'trim');
    $this->form_validation->set_rules('address', 'Address', 'trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('customer/signup');
    } else {
      $dt = new stdClass();
      $dt->level = 3;
      $dt->email = $this->input->post('email');
      if ( $this->user_model->checkUserEmailLevel($dt) ) {
        $data->usererror = 'Customer exist with this email';
        $this->load->view('header');
        $this->load->view('customer/signup', $data);
        $this->load->view('footer');
        return;
      }

      $name = $this->input->post('name');
      $data->email = $this->input->post('email');
      $data->password = $this->input->post('password');
      $data->name = $name[0] . ' ' . $name[1];
      $data->contact_no = $this->input->post('contact_no');
      $data->city = $this->input->post('city');
      $data->address = $this->input->post('address');
      $data->level = 3;
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

        redirect('/customer');
      }
      $this->load->view('home');
    }
  }

  public function password()
  {
    $user_id = $this->session->userdata('user_id');
    $user = $this->user_model->get_user($user_id);

    // create the data object
    $data = new stdClass();

    $this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required');
    $this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|min_length[6]');
    $this->form_validation->set_rules('con_new_pass', 'Confirm New Password', 'trim|required|min_length[6]|matches[new_pass]');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/header');
      $this->load->view('customer/password');
      $this->load->view('layout/footer');
    } else {
      $data2 = new stdClass();
      $data2->password = $this->input->post("new_pass");
      $data2->id = $user_id;
      $this->user_model->update_user($data2);

      $this->load->library('email');
      $this->email->set_mailtype("html");
      $this->email->from('info@locksmith.com', 'LockSmith');
      $this->email->to($user->email);
      $this->email->subject("Your Customer account information has been updated");

      $message = $this->load->view('email/passwordresetsuccess', array(), true);
      $this->email->message($message);
      $this->email->send();

      $data->success = 'Your password has been changed.';
      $this->load->view('layout/header');
      $this->load->view('customer/password', $data);
      $this->load->view('layout/footer');
    }
  }

  public function edit()
  {
    $user_id = $this->session->userdata('user_id');
    $user = $this->user_model->get_user($user_id);

    // create the data object
    $data = new stdClass();
    $data->user = $user;

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim');
    $this->form_validation->set_rules('city', 'City', 'trim');
    $this->form_validation->set_rules('address', 'Address', 'trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('layout/header');
      $this->load->view('customer/edit', $data);
      $this->load->view('layout/footer');
    } else {
      $name = $this->input->post('name');
      $data->id = $user_id;
      $data->email = $this->input->post('email');
      $data->name = $name[0] . ' ' . $name[1];
      $data->contact_no = $this->input->post('contact_no');
      $data->city = $this->input->post('city');
      $data->address = $this->input->post('address');
      $this->user_model->update_user($data);
      if ( isset( $_FILES['image'] ) && !empty( $_FILES['image'] ) ) {
        $this->upload();
      } else {
        redirect('/customer');
      }
    }
  }

  public function upload()
  {
    $user_id = $this->session->userdata('user_id');

    $max = 400;
    list($width, $height, $type, $attr) = getimagesize( $_FILES['image']['tmp_name'] );
    if ( $width > $max || $height > $max ) {
      $target_filename = $_FILES['image']['tmp_name'];
      $fn = $_FILES['image']['tmp_name'];
      $size = getimagesize( $fn );
      $ratio = $size[0]/$size[1];
      if( $ratio > 1) {
        $width = $max;
        $height = $max/$ratio;
      } else {
        $width = $max*$ratio;
        $height = $max;
      }
      $src = imagecreatefromstring(file_get_contents($fn));
      $dst = imagecreatetruecolor( $width, $height );
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1] );

      imagejpeg($dst, $target_filename);
    }

    $new_name = time().$_FILES["image"]["name"];
    $uploaddir = "./uploads/user/" . $user_id . "/";
    $uploadfile = $uploaddir . basename($new_name);

    if ( !file_exists( $uploaddir ) ) {
      mkdir($uploaddir, 0777, true);
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
      $data = new stdClass();
      $data->id = $user_id;
      $data->image = $new_name;
      $this->user_model->update_user($data);
      $this->session->set_userdata(array(
        'image' => (string) $new_name,
      ));
      redirect('/customer');
    }
  }
}
