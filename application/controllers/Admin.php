<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library(array('session', 'form_validation'));
    $this->load->helper(array('url', 'form', 'captcha', 'form'));
    $this->load->model(array('user_model', 'bike_model', 'price_model', 'order_model', 'review_model'));
    if ( !$this->session->userdata('logged_in') ) {
      redirect('/');
    }
    if ( $this->session->userdata('level') == 2 ) {
      redirect('locksmith');
    } else if ( $this->session->userdata('level') == 3 ) {
      redirect('customer');
    }
  }

  public function index()
  {
   // $newcustomers = $this->user_model->getNewCustomers();
   // $newlocksmiths = $this->user_model->getNewLocksmiths();
   // $newreviews = $this->review_model->getNewReviews();
   // $neworders = $this->order_model->getNew();
  //  $lastorders = $this->order_model->getLast4CustomerOrders();
   //$monthsOrder = $this->order_model->getMonthsOrders();
   // $paymentCustomer = $this->order_model->getAllPayments();
    //$paymentLocksmith = $this->payment_model->getCompletedPayments();
    
    $array = array();$array2 = array();

    // foreach ( $monthsOrder['completed'] as $monhlycomplete ) {
    //   $array[$monhlycomplete['month'].$monhlycomplete['year']]['period'] = $monhlycomplete['year']."-".$monhlycomplete['month'];
    //   $array[$monhlycomplete['month'].$monhlycomplete['year']]['completed'] = $monhlycomplete['total'];
    // }
    // foreach ( $monthsOrder['accepted'] as $monhlyaccepted ) {
    //   $array[$monhlyaccepted['month'].$monhlyaccepted['year']]['period'] = $monhlyaccepted['year']."-".$monhlyaccepted['month'];
    //   $array[$monhlyaccepted['month'].$monhlyaccepted['year']]['accepted'] = $monhlyaccepted['total'];
    // }
    // foreach ( $monthsOrder['pending'] as $monhlypending ) {
    //   $array[$monhlypending['month'].$monhlypending['year']]['period'] = $monhlypending['year']."-".$monhlypending['month'];
    //   $array[$monhlypending['month'].$monhlypending['year']]['pending'] = $monhlypending['total'];
    // }
    // ksort($array);
    // foreach ( $array as $arr ) {
    //   $array2[] = $arr;
    // }

    // if ( !$paymentLocksmith->amount ) {
    //   $paymentLocksmith->amount = 0;
    // }
    // if ( !$paymentCustomer->price ) {
    //   $paymentCustomer->price = 0;
    // }
    $total = 0;

    $data = new stdClass();
    $data->locksmith = 0;//count($newlocksmiths);
    $data->customer = 0;// count($newcustomers);
    $data->order = 0;//count($neworders);
    $data->review = 0;//count($newreviews);
    $data->lastorders = 0;//$lastorders;
    $data->newreviews = 0;//$newreviews;
    $data->monthorders = 0;//$array2;
    $data->payments = array(
      'total' => $total,
      'cust' => 0,
      'lock' => 0
    );
    $this->load->view('header');
    $this->load->view('admin/index', $data);
    $this->load->view('footer');
  }

  public function profile()
  {
    $user_id = $this->session->userdata('user_id');
    $user = $this->user_model->get_user($user_id);
    $this->load->view('header');
    $this->load->view('admin/profile', $user);
    $this->load->view('footer');
  }

 
  public function customer()
  {
    $this->load->view('header');
    $this->load->view('admin/customer');
    $this->load->view('footer');
  }

  public function getcustomer()
  {
    $customers = $this->user_model->getAllCustomers();
    $all = $this->user_model->count_all_cust();

    $data = array();
    $no = $_POST['start'];
    foreach ($customers as $customer) {
        $no++;
        $row = array();
        $row[] = $customer['id'];
        $row[] = $customer['name'];
        $row[] = $customer['email'];
        $row[] = $customer['contact_no'];
        $row[] = $customer['address'];

        $row[] = '<a href="'.base_url().'admin/editcustomer/'.$customer['id'].'" class="btn btn-primary">Edit</a> | <a href="javascript:void(0);" onclick="deleteCustomer('.$customer['id'].');" class="btn btn-danger">Delete</a>';

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

    // set validation rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', '');
    $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim');
    $this->form_validation->set_rules('address', 'Address', 'trim');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('admin/addcustomer');
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
      $data->level = 3;
      $data->status = 1;
      if ( $this->user_model->create_user($data) ) {
        $data->success = "Customer added successfully.";
        $this->load->view('header');
        $this->load->view('admin/addcustomer', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('admin/addcustomer', $data);
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

    // set validation rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', '');
    $this->form_validation->set_rules('contact_no', 'Contact Number', 'trim');
    $this->form_validation->set_rules('address', 'Address', 'trim');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('admin/editcustomer', $customer);
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
      if ($id = $this->user_model->update_user($data)) {
        $data->success = "Customer edited successfully.";
        $this->load->view('header');
        $this->load->view('admin/editcustomer', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('admin/editcustomer', $data);
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

  public function bike()
  {
    $this->load->view('header');
    $this->load->view('admin/bikes');
    $this->load->view('footer');
  }

  public function getbike()
  {
    $bikes = $this->bike_model->getAllBike();
    $all = $this->bike_model->count_all();

    $data = array();
    $no = $_POST['start'];
    foreach ($bikes as $bike) {
        $no++;
        $row = array();

        $row[] = $bike['id'];
        $row[] = $bike['model'];
        $row[] = $bike['mac_address'];
        $row[] = $bike['type'];
        $row[] = $bike['creation_date'];
        $row[] = $bike['modified_date'];
        $row[] = ' <a href="javascript:void(0);" onclick="deleteBike('.$bike['id'].');" class="btn btn-danger">Delete</a>';
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

  public function addbike()
  {
    // create the data object
    $data = new stdClass();

    // set validation rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('price', 'Customer Price', 'required');
    $this->form_validation->set_rules('locksmithprice', 'Locksmith Price', 'required');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('admin/addtype');
      $this->load->view('footer');
    } else {
      $data->name = $this->input->post('name');
      $data->price = $this->input->post('price');
      $data->locksmithprice = $this->input->post('locksmithprice');
      $data->creation_date = date("Y-m-d H:i:s", strtotime("now"));
      if ( $this->type_model->addtype($data) ) {
        $data->success = "Type added successfully.";
        $this->load->view('header');
        $this->load->view('admin/addtype', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('admin/addtype', $data);
        $this->load->view('footer');
      }
    }
  }

  public function editbike()
  {
    $data = new stdClass();
    $id = $this->uri->segment(3);
    $type = $this->bike_model->get_type($id);

    // set validation rules
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('price', 'Customer Price', 'required');
    $this->form_validation->set_rules('locksmithprice', 'Locksmith Price', 'required');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('admin/edittype', $type);
      $this->load->view('footer');
    } else {
      $data->id = $id;
      $data->name = $this->input->post('name');
      $data->price = $this->input->post('price');
      $data->locksmithprice = $this->input->post('locksmithprice');
      if ($id = $this->type_model->updatetype($data)) {
        $data->success = "Your profile has been edited successfully.";
        $this->load->view('header');
        $this->load->view('admin/edittype', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('admin/edittype', $data);
        $this->load->view('footer');
      }
    }
  }

  public function deletebike()
  {
    $id = $this->uri->segment(3);
    $this->type_model->deletetype($id);
    exit;
  }

  public function rides()
  {
    $this->load->view('header');
    $this->load->view('admin/orders');
    $this->load->view('footer');
  }

  public function getorders()
  {
    $allorders = $this->order_model->getAllOrders();
    $all = $this->order_model->count_all();
    $order_count = count($allorders);

    $data = array();
    $no = $_POST['start'];
    foreach ($allorders as $order) {
      // echo '<pre>'; print_r($order); exit;
        $no++;
        $row = array();
        $status = "";
        $row[] = $order['id'];
       
        $row[] = $order['customer_name'];
       
        $row[] = $order['price'];
        $row[] = $order['address'];

        if ( $order['status'] == '0' ) {
          $status = 'Pending';
        } else if ( $order['status'] == '1' ) {
          $status = 'Accpeted';
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


$id = $order['id'];
$price = $order['price'];
$status = $status;
$start_date = $order['start_date'];
$end_date = $order['end_date'];
$start_address = $order['start_address'];
$end_address = $order['end_address']; 
$customer_name = $order['customer_name'];

$distance = $order['distance'];
$calories = $order['calories']; 
$carbon_kg = $order['carbon_kg'];
$totaltime = $order['total_ride_time'];

     
        
        $row[] = '<a class="btn btn-success" href="javascript:void(0);" id="dt'.$id.'" onclick="detailAdminOrder('.$id.');" data-cust="'.$customer_name.'" data-price="'.$price.'" data-status="'.$status.'" data-startdate="'.$start_date.'" data-startaddress="'.$start_address.'" data-endaddress="'.$end_address.'" " data-enddate="'.$end_date.'" " data-distance="'.$distance.'" " data-calories="'.$calories.'" " data-carbonkg="'.$carbon_kg.'" " data-totaltime="'.$totaltime.'" "  />Detail</a>  | <a href="javascript:void(0);" onclick="deleteAdminOrder('.$order['id'].');" class="btn btn-danger">Delete</a>  ';

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
    $data->locksmiths = $type = $this->user_model->getAllLocksmith();
    $data->customers = $type = $this->user_model->getAllCustomers();

    // set validation rules
    $this->form_validation->set_rules('amount', 'Amount', 'required|numeric');
    //$this->form_validation->set_rules('address', 'Address', 'required');
    $this->form_validation->set_rules('quantity', 'Quantity', 'numeric');
    $this->form_validation->set_rules('type_id', 'Type', '');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('admin/editorder', $data);
      $this->load->view('footer');
    } else {
      $data->id = $id;
      $data->amount = $this->input->post('amount');
      $data->type_id = $this->input->post('type_id');
      $data->quantity = $this->input->post('quantity');
      $data->address = $this->input->post('address');
      $data->customer_id = $this->input->post('customer');
      $data->locksmith_id = $this->input->post('locksmith');
      if ($id = $this->order_model->updateorder($data)) {
        $data->success = "Order updated successfully.";
        $this->load->view('header');
        $this->load->view('admin/editorder', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('admin/editorder', $data);
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
   public function detailadminorder($id)
  {
   
    $this->order_model->detailadminorder($id);

 



  }

  public function reviews()
  {
    $this->load->view('header');
    $this->load->view('admin/reviews');
    $this->load->view('footer');
  }

  public function getreviews()
  {
   $allreviews = $this->review_model->getAllReviews();
    $all = $this->review_model->count_for_all();
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
        $row[] = '<a href="javascript:void(0);" onclick="deleteAdminReview('.$review['id'].');" class="btn btn-danger">Delete</a>';

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
    //$data->types = $type = $this->type_model->getAllTypes();

    // set validation rules
    $this->form_validation->set_rules('review', 'Review', 'required|trim');
    $this->form_validation->set_rules('rating', 'Rating', 'numeric');

    if ($this->form_validation->run() == false) {
      // validation not ok, send validation errors to the view
      $this->load->view('header');
      $this->load->view('admin/editreview', $data);
      $this->load->view('footer');
    } else {
      $data->id = $id;
      $data->review = $this->input->post('review');
      $data->rating = $this->input->post('rating');
      if ($id = $this->review_model->updatereview($data)) {
        $data->success = "Review updated successfully.";
        $this->load->view('header');
        $this->load->view('admin/editreview', $data);
        $this->load->view('footer');
      } else {
        $data->error = "Something wrong here.";
        $this->load->view('header');
        $this->load->view('admin/editreview', $data);
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
      $this->load->view('admin/password');
      $this->load->view('footer');
    } else {
      $data2 = new stdClass();
      $data2->password = $this->input->post("new_pass");
      $data2->id = $user_id;
      $this->user_model->update_user($data2);

//      $this->load->library('email');
//      $this->email->set_mailtype("html");
//      $this->email->from('info@locksmith.com', 'LockSmith');
//      $this->email->to($user->email);
//      $this->email->subject("Your Locksmith account information has been updated");
//
//      $message = $this->load->view('email/passwordresetsuccess', array(), true);
//      $this->email->message($message);
//      $this->email->send();

      $data->success = 'Your password has been changed.';
      $this->load->view('header');
      $this->load->view('admin/password', $data);
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
      $this->load->view('admin/edit', $data);
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
        redirect('/admin');
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
      redirect('/admin');
    }
  }
}
