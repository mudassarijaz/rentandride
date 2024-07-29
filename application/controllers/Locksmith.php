<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locksmith extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form'));
    $this->load->model(array('user_model', 'price_model', 'type_model', 'order_model', 'review_model', 'payment_model'));

    if ( !$this->session->userdata('logged_in') ) {
      if ( $_SERVER['REQUEST_URI'] != '/locksmith/signup' ) {
        redirect('/');
      }
    }
    if ( $this->session->userdata('level') == 1 ) {
      redirect('admin/locksmith');
    } else if ( $this->session->userdata('level') == 3 ) {
      redirect('customer');
    }
  }

  public function index()
  {
    $user_id = $this->session->userdata('user_id');
    $newcustomers = $this->user_model->getNewCustomersofLocksmith($user_id);
    $newreviews = $this->review_model->getReviewsofLocksmith($user_id);
    $neworders = $this->order_model->getNewOrderofLocksmith($user_id);
    $lastorders = $this->order_model->getLast4CustomerOrdersofLocksmith($user_id);
    $monthsOrder = $this->order_model->getLockMonthsOrders($user_id);
    $paymentCustomer = $this->order_model->getLockPayments($user_id);
    $paymentLocksmith = $this->payment_model->getLockCompletedPayments($user_id);

    $array = array();$array2 = array();

    foreach ( $monthsOrder['completed'] as $monhlycomplete ) {
      $array[$monhlycomplete['month'].$monhlycomplete['year']]['period'] = $monhlycomplete['year']."-".$monhlycomplete['month'];
      $array[$monhlycomplete['month'].$monhlycomplete['year']]['completed'] = $monhlycomplete['total'];
    }
    foreach ( $monthsOrder['accepted'] as $monhlyaccepted ) {
      $array[$monhlyaccepted['month'].$monhlyaccepted['year']]['period'] = $monhlyaccepted['year']."-".$monhlyaccepted['month'];
      $array[$monhlyaccepted['month'].$monhlyaccepted['year']]['accepted'] = $monhlyaccepted['total'];
    }
    foreach ( $monthsOrder['pending'] as $monhlypending ) {
      $array[$monhlypending['month'].$monhlypending['year']]['period'] = $monhlypending['year']."-".$monhlypending['month'];
      $array[$monhlypending['month'].$monhlypending['year']]['rejected'] = $monhlypending['total'];
    }
    ksort($array);
    foreach ( $array as $arr ) {
      $array2[] = $arr;
    }

    if ( !$paymentLocksmith->amount ) {
      $paymentLocksmith->amount = 0;
    }
    if ( !$paymentCustomer->price ) {
      $paymentCustomer->price = 0;
    }
    $total = (int) $paymentCustomer->price - (int) $paymentLocksmith->amount;

    $data = new stdClass();
    $data->review = count($newreviews);
    $data->customer = count($newcustomers);
    $data->order = count($neworders);
    $data->lastorders = $lastorders;
    $data->newreviews = $newreviews;
    $data->monthorders = $array2;
    $data->payments = array(
      'total' => $total,
      'cust' => $paymentCustomer->price,
      'lock' => $paymentLocksmith->amount
    );

    $this->load->view('header');
    $this->load->view('locksmith/index', $data);
    $this->load->view('footer');
  }

  public function profile()
  {
    $user_id = $this->session->userdata('user_id');
    $user = $this->user_model->get_user($user_id);
    $this->load->view('header');
    $this->load->view('locksmith/profile', $user);
    $this->load->view('footer');
  }

  public function price()
  {
    $this->load->view('header');
    $this->load->view('locksmith/price');
    $this->load->view('footer');
  }

  public function getprices()
  {
    $id = $this->session->userdata('user_id');
    $allprices = $this->price_model->get_allprices($id);
    $all = $this->price_model->count_lock_all($id);
    $customer_count = count($allprices);

    $data = array();
    $no = $_POST['start'];
    foreach ($allprices as $price) {
        $no++;
        $row = array();
        $row[] = $price['price_id'];
        $row[] = $price['name'];
        $row[] = $price['price'];
        if ( $price['eve_method'] == 'plus' ) {
          $row[] = $price['price'] + $price['eve_price'];
        } else if ( $price['eve_method'] == 'percent' ) {
          $row[] = $price['price'] + ($price['price']*$price['eve_price']/100);
        } else {
          $row[] = 0;
        }
        if ( $price['week_method'] == 'plus' ) { 
          $row[] = $price['price'] + $price['week_price'];
        } else if ( $price['week_method'] == 'percent' ) {
          $row[] = $price['price'] + ($price['price']*$price['week_price']/100);
        } else {
          $row[] = 0;
        }

        $row[] = '<a href="'.base_url().'locksmith/editprice/'.$price['price_id'].'">Edit</a> | <a href="javascript:void(0);" onclick="deleteLocksmithPrice('.$price['price_id'].');">Delete</a>';

        $data[] = $row;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $all,
        "recordsFiltered" => $all,
        "data" => $data,
    );

    echo json_encode($output);
  }

  public function addprice()
  {
    // create the data object
    $data = new stdClass();
    $id = $this->session->userdata('user_id');
    $data->types = $type = $this->type_model->getAllTypes();

    // set validation rules
    $this->form_validation->set_rules('price', 'Price', 'required|numeric');
    $this->form_validation->set_rules('type_id', 'Type', '');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('locksmith/addprice', $data);
      $this->load->view('footer');
    } else {
      $data->user_id = $id;
      $data->price = $this->input->post('price');
      $data->type_id = $this->input->post('type_id');
      $data->eve_method = $this->input->post('eve_method');
      $data->eve_price = $this->input->post('eve_price');
      $data->week_method = $this->input->post('week_method');
      $data->week_price = $this->input->post('week_price');
      if ($id = $this->price_model->addprice($data)) {
        $data->success = "Price added successfully.";
        $this->load->view('header');
        $this->load->view('locksmith/addprice', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('locksmith/addprice', $data);
        $this->load->view('footer');
      }
    }
  }

  public function editprice()
  {
    // create the data object
    $data = new stdClass();
    $id = $this->uri->segment(3);
    $data->prices = $price = $this->price_model->get_price($id);
    $data->types = $type = $this->type_model->getAllTypes();

    // set validation rules
    $this->form_validation->set_rules('price', 'Price', 'required|numeric');
    $this->form_validation->set_rules('type_id', 'Type', '');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('locksmith/editprice', $data);
      $this->load->view('footer');
    } else {
      $data->id = $id;
      $data->price = $this->input->post('price');
      $data->type_id = $this->input->post('type_id');
      $data->eve_method = $this->input->post('eve_method');
      $data->eve_price = $this->input->post('eve_price');
      $data->week_method = $this->input->post('week_method');
      $data->week_price = $this->input->post('week_price');
      if ($id = $this->price_model->updateprice($data)) {
        $data->success = "Price updated successfully.";
        $this->load->view('header');
        $this->load->view('locksmith/editprice', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('locksmith/editprice', $data);
        $this->load->view('footer');
      }
    }
  }

  public function deleteprice()
  {
    $id = $this->uri->segment(3);
    $this->price_model->deleteprice($id);
    exit;
  }

  public function customer()
  {
    $this->load->view('header');
    $this->load->view('locksmith/customer');
    $this->load->view('footer');
  }

  public function getcustomers()
  {
    $id = $this->session->userdata('user_id');
    $allcustomers = $this->order_model->getCustomersfromOrder($id);
    $all = $this->order_model->count_lock_all($id);
    $customer_count = count($allcustomers);

    $data = array();
    $no = $_POST['start'];
    foreach ($allcustomers as $customer) {
        $no++;
        $row = array();
        $row[] = $customer['id'];
        $row[] = $customer['customer_name'];
        $row[] = $customer['customer_email'];
        $row[] = $customer['customer_contact'];
        $row[] = $customer['customer_city'];
        $row[] = $customer['customer_address'];

        $data[] = $row;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $all,
        "recordsFiltered" => $all,
        "data" => $data,
    );

    echo json_encode($output);
  }

  public function addcustomer()
  {
    // create the data object
    $data = new stdClass();

    $this->load->helper('form');
    $this->load->library('form_validation');

    // set validation rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', '');
    $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim');
    $this->form_validation->set_rules('address', 'Address', 'trim');
    $user_id = $this->session->userdata('user_id');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('locksmith/addcustomer');
      $this->load->view('footer');
    } else {
      $data->email = $this->input->post('email');
      if ( !empty( $this->input->post('password') ) ) {
        $data->password = $this->input->post('password');
      }
      $data->name = $this->input->post('name');
      $data->contact_no = $this->input->post('contact_no');
      $data->address = $this->input->post('address');
      $data->creation_date = date("Y-m-d H:i:s", strtotime("now"));
      $data->loc_id = $user_id;
      $data->level = 3;
      $data->status = 1;
      if ( $this->user_model->create_user($data) ) {
        $data->success = "Customer added successfully.";
        $this->load->view('header');
        $this->load->view('locksmith/addcustomer', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('locksmith/addcustomer', $data);
        $this->load->view('footer');
      }
    }
  }

  public function editcustomer()
  {
    // create the data object
    $data = new stdClass();
    $id = $this->uri->segment(3);
    $customer = $this->user_model->get_user($id);

    $this->load->helper('form');
    $this->load->library('form_validation');

    // set validation rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', '');
    $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim');
    $this->form_validation->set_rules('address', 'Address', 'trim');
    $user_id = $this->session->userdata('user_id');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('locksmith/editcustomer', $customer);
      $this->load->view('footer');
    } else {
      $data->id = $id;
      $data->email = $this->input->post('email');
      if ( !empty( $this->input->post('password') ) ) {
        $data->password = $this->input->post('password');
      }
      $data->name = $this->input->post('name');
      $data->contact_no = $this->input->post('contact_no');
      $data->address = $this->input->post('address');
      $data->loc_id = $user_id;
      if ($id = $this->user_model->update_user($data)) {
        $data->success = "Customer edited successfully.";
        $this->load->view('header');
        $this->load->view('locksmith/editcustomer', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('locksmith/editcustomer', $data);
        $this->load->view('footer');
      }
    }
  }

  public function deletecustomer()
  {
    $id = $this->uri->segment(3);
    $this->user_model->deleteuser($id);
    exit;
  }

  public function orders()
  {
    $this->load->view('header');
    $this->load->view('locksmith/orders');
    $this->load->view('footer');
  }

  public function getorders()
  {
    $id = $this->session->userdata('user_id');
    $allorders = $this->order_model->getLocksmithOrders($id);
    $all = $this->order_model->count_lock_all($id);
    $order_count = count($allorders);

    $data = array();
    $no = $_POST['start'];
    foreach ($allorders as $order) {
        $no++;
        $row = array();
        $row[] = $order['id'];
        $row[] = $order['customer_name'];
        $row[] = $order['type_name'];
        $row[] = $order['price'];
        $row[] = $order['evening'];
        $row[] = $order['weekend'];
        if ( $order['status'] == '0' ) {
          $status = 'Pending';
        } else if ( $order['status'] == '1' ) {
          $status = 'Accepted';
        } else if ( $order['status'] == '2' ) {
          $status = 'Rejected';
        } else if ( $order['status'] == '3' ) {
          $status = 'Completed';
        }
        
        if ( $order['end_date'] == '0000-00-00 00:00:00' ) {
          $endDate = 'Continue';
        } else {
          $endDate = date("m-d-Y", strtotime($order['end_date']));
        }
        $row[] = $status;
        $row[] = date("m-d-Y", strtotime($order['start_date']));
        $row[] = '<a href="'.base_url().'locksmith/editorder/'.$order['id'].'">Edit</a> | <a href="javascript:void(0);" onclick="deleteLocksmithOrder('.$order['id'].');">Delete</a>';

        $data[] = $row;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $all,
        "recordsFiltered" => $all,
        "data" => $data,
    );

    echo json_encode($output);
  }

  public function editorder()
  {
    // create the data object
    $data = new stdClass();
    $id = $this->uri->segment(3);
    $data->orders = $price = $this->order_model->get_order($id);
    $data->types = $type = $this->type_model->getAllTypes();

    // set validation rules
    $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
    $this->form_validation->set_rules('quantity', 'Quantity', 'numeric');
    $this->form_validation->set_rules('type_id', 'Type', '');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('locksmith/editorder', $data);
      $this->load->view('footer');
    } else {
      $data->id = $id;
      $data->amount = $this->input->post('amount');
      $data->type_id = $this->input->post('type_id');
      $data->quantity = $this->input->post('quantity');
      if ($id = $this->order_model->updateorder($data)) {
        $data->success = "Order updated successfully.";
        $this->load->view('header');
        $this->load->view('locksmith/editorder', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('locksmith/editorder', $data);
        $this->load->view('footer');
      }
    }
  }

  public function deleteorder()
  {
    $id = $this->uri->segment(3);
    $this->order_model->deleteorder($id);
    exit;
  }

  public function reviews()
  {
    $this->load->view('header');
    $this->load->view('locksmith/reviews');
    $this->load->view('footer');
  }

  public function getreviews()
  {
    $id = $this->session->userdata('user_id');
    $allreviews = $this->review_model->getLocksmithReviews($id);
    $all = $this->review_model->count_all($id);
    $review_count = count($allreviews);

    $data = array();
    $no = $_POST['start'];
    foreach ($allreviews as $review) {
        $no++;
        $row = array();
        $row[] = $review['id'];
        $row[] = $review['order_id'];
        $row[] = $review['customer_name'];
        $row[] = $review['review'];
        $row[] = $review['rating'];
        $row[] = date("m-d-Y", strtotime($review['creation_date']));
        $row[] = '<a href="'.base_url().'locksmith/editreview/'.$review['id'].'">Edit</a> | <a href="javascript:void(0);" onclick="deleteLocksmithReview('.$review['id'].');">Delete</a>';

        $data[] = $row;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $all,
        "recordsFiltered" => $all,
        "data" => $data,
    );

    echo json_encode($output);
  }

  public function editreview()
  {
    // create the data object
    $data = new stdClass();
    $id = $this->uri->segment(3);
    $data->reviews = $price = $this->review_model->get_review($id);
    $data->types = $type = $this->type_model->getAllTypes();

    // set validation rules
    $this->form_validation->set_rules('review', 'Review', 'required|trim');
    $this->form_validation->set_rules('rating', 'Rating', 'numeric');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('locksmith/editreview', $data);
      $this->load->view('footer');
    } else {
      $data->id = $id;
      $data->review = $this->input->post('review');
      $data->rating = $this->input->post('rating');
      if ($id = $this->review_model->updatereview($data)) {
        $data->success = "Review updated successfully.";
        $this->load->view('header');
        $this->load->view('locksmith/editreview', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('locksmith/editreview', $data);
        $this->load->view('footer');
      }
    }
  }

  public function deletereview()
  {
    $id = $this->uri->segment(3);
    $this->review_model->deletereview($id);
    exit;
  }

  public function transactions()
  {
    $this->load->view('header');
    $this->load->view('locksmith/transactions');
    $this->load->view('footer');
  }

  public function gettransactions()
  {
    $user_id = $this->session->userdata('user_id');
    $id = $this->uri->segment(3);
    if ( $id == '1' ) {
      $payments = $this->payment_model->detailPayments($user_id);
      $all = $this->payment_model->count_all($user_id);

      $data = array();
      $no = $_POST['start'];
      foreach ($payments as $payment) {
        $no++;
        $row = array();
        $row[] = $payment['id'];
        $row[] = $payment['amount'];
        $row[] = "Completed";
        $row[] = date("F", strtotime($payment['creation_date']));
        $row[] = date("m-d-Y", strtotime($payment['creation_date']));

        $data[] = $row;
      }
    } else if ( $id == '2' ) {
      $payments = $this->order_model->getCompletedOrders($user_id);
      $all = $this->order_model->count_all_completed($user_id);

      $data = array();
      $no = $_POST['start'];
      foreach ($payments as $payment) {
        $no++;
        $row = array();
        $row[] = $payment['id'];
        $row[] = $payment['customer_name'];
        $row[] = $payment['type_name'];
        $row[] = $payment['price'];
        $row[] = "Completed";
        $row[] = date("m-d-Y", strtotime($payment['completed_date']));

        $data[] = $row;
      }
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $all,
        "recordsFiltered" => $all,
        "data" => $data,
    );

    echo json_encode($output);
  }

  public function signup()
  {
    // create the data object
    $data = new stdClass();

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim');
    $this->form_validation->set_rules('city', 'City', 'trim');
    $this->form_validation->set_rules('invite_code', 'Invite Code', 'trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('header');
      $this->load->view('locksmith/signup');
      $this->load->view('footer');
    } else {
      $dt = new stdClass();
      $dt->level = 2;
      $dt->email = $this->input->post('email');
      if ( $this->user_model->checkUserEmailLevel($dt) ) {
        $data->usererror = 'Locksmith exist with this email';
        $this->load->view('header');
        $this->load->view('locksmith/signup', $data);
        $this->load->view('footer');
        return;
      }

      $name = $this->input->post('name');
      $data->email = $this->input->post('email');
      $data->password = $this->input->post('password');
      $data->name = $name[0] . ' ' . $name[1];
      $data->contact_no = $this->input->post('contact_no');
      $data->city = $this->input->post('city');
      $data->level = 2;
      $data->status = 1;
      $data->creation_date = date("Y-m-d H:i:s", strtotime("now"));
      if ( $this->input->post('experience') ) {
        $data->experience = $this->input->post('experience');
      }
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
      $this->load->view('header');
      $this->load->view('locksmith/password');
      $this->load->view('footer');
    } else {
      $data2 = new stdClass();
      $data2->password = $this->input->post("new_pass");
      $data2->id = $user_id;
      $this->user_model->update_user($data2);

      $this->load->library('email');
      $this->email->set_mailtype("html");
      $this->email->from('info@locksmith.com', 'LockSmith');
      $this->email->to($user->email);
      $this->email->subject("Your Locksmith account information has been updated");

      $message = $this->load->view('email/passwordresetsuccess', array(), true);
      $this->email->message($message);
      $this->email->send();

      $data->success = 'Your password has been changed.';
      $this->load->view('header');
      $this->load->view('locksmith/password', $data);
      $this->load->view('footer');
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
      $this->load->view('header');
      $this->load->view('locksmith/edit', $data);
      $this->load->view('footer');
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
        redirect('/locksmith');
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
      redirect('/locksmith');
    }
  }
}
