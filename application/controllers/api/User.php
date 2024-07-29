<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/JWT.php';

use Restserver\Libraries\REST_Controller;
use \Firebase\JWT\JWT;

class User extends REST_Controller
{
  function __construct()
  {
    // Construct the parent class
    parent::__construct();

    // Configure limits on our controller methods
    // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
    $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
    $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
    $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    $this->load->model(array('user_model', 'type_model', 'order_model', 'price_model', 'coupon_model', 'review_model', 'creditcard_model', 'service_model', 'locksmithservice_model', 'subscription_model', 'rejectorder_model'));
    $this->load->helper(array('url'));
    $this->config->load('paypal');
    $config = array(
      'Sandbox' => $this->config->item('Sandbox'),
      'APIUsername' => $this->config->item('APIUsername'),
      'APIPassword' => $this->config->item('APIPassword'),
      'APISignature' => $this->config->item('APISignature'),
      'APISubject' => '',
      'APIVersion' => $this->config->item('APIVersion')
    );

    // Show Errors
    if( $config['Sandbox'] ) {
      error_reporting(E_ALL);
      ini_set('display_errors', '1');
    }

    $this->load->library('paypal/Paypal_pro', $config);
  }

  public function login_post()
  {
    $data = new stdClass();
    $data->email = $email = $this->post('email');
    $data->password = $password = $this->post('password');
    $data->level = $level = $this->post('level');
    
    if(!$email){
      $invalidLogin = ['invalid' => 'Please enter email. It\'s required.'];
      $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
    }
    if (!$password) {
      $invalidLogin = ['invalid' => 'Please enter password. It\'s required.'];
      $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
    }
    if ($this->user_model->resolve_user_login($data)) {
      $user_id = $this->user_model->get_user_id_from_email($data);
      $user = $this->user_model->get_user($user_id);
      if ( $user->level != $level ) {
        $output['message'] = "User not found.";
        $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
      } else {
        $token['id'] = $user_id;
        $token['email'] = $email;
        $token['name'] = $user->name;
        $token['image'] = $user->image;
        $token['contact_no'] = $user->contact_no;
        $date = new DateTime();
        $token['iat'] = $date->getTimestamp();
        $token['exp'] = $date->getTimestamp() + 60*60*24;
        $output['id_token'] = JWT::encode($token, "user_auth");
        $this->set_response($output, REST_Controller::HTTP_CREATED);
      }
    } else {
      $invalidLogin = ['invalid' => 'Hmm, that\'s not the right password. Please try again.'];
      $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function signup_post()
  {
    $dt = new stdClass();
    $dt->level = $this->post('level');
    $dt->email = $this->post('email');
    if ( $this->user_model->checkUserEmailLevel($dt) ) {
      if ( $dt->level == '2' ) {
        $output['message'] = 'Locksmith exist with this email.';
      } else if ( $dt->level == '3' ) {
        $output['message'] = 'Customer exist with this email.';
      }
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    } else {
      $name = $this->post('name');
      $data = new stdClass();
      $data->email = $this->post('email');
      $data->password = $this->post('password');
      $data->name = $name[0] . ' ' . $name[1];
      $data->contact_no = $this->post('contact_no');
      $data->city = $this->post('city');
      $data->address = $this->post('address');
      $data->level = $this->post('level');
      $data->status = 1;
      $data->creation_date = date("Y-m-d H:i:s", strtotime("now"));
      if ( $this->post('experience') ) {
        $data->experience = $this->post('experience');
      }
      if ( $id = $this->user_model->create_user($data) ) {
        $user = $this->user_model->get_user($id);

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

        $token['id'] = $id;
        $token['email'] = $user->email;
        $token['name'] = $user->name;
        $token['image'] = $user->image;
        $token['contact_no'] = $user->contact_no;
        $date = new DateTime();
        $token['iat'] = $date->getTimestamp();
        $token['exp'] = $date->getTimestamp() + 60*60*24;
        $output['id_token'] = JWT::encode($token, "user_auth");
        $this->set_response($output, REST_Controller::HTTP_CREATED);
      }
    }
  }

  public function locksmith_get()
  {
    $id = $this->get('id');
    $locksmithData = $this->user_model->locksmithData($id);
    if ( count( $locksmithData ) > 0 ) {
      $this->set_response($locksmithData, REST_Controller::HTTP_OK);
    } else {
      $output['message'] = "Locksmith data not found.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function cancelorderforprice_post()
  {
    $id = $this->post("id");
    $order = $this->order_model->get_order($id);
    $data = new stdClass();
    $data->order_id = $id;
    $data->customer_id = $order->customer_id;
    $data->locksmith_id = $order->locksmith_id;
    $this->rejectorder_model->addRejectorder($data);
    $data2 = new stdClass();
    $data2->id = $id;
    $data2->price = 0;
    $data2->locksmith_id = 0;
    $data2->status = 0;

    if ( $this->order_model->updateorder($data2) ) {
      $output['message'] = "You have cancel the order.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      $output['message'] = "No result found.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function forgotpassword_post()
  {
    $data = new stdClass();
    $data->email = $email = $this->post("email");
    $data->level = $level = $this->post("level");
    $checkUser = $this->user_model->checkUserEmailLevel($data);
    if ( count( $checkUser ) > 0 ) {
      $this->load->library('email');
      $this->email->set_mailtype("html");
      $this->email->from('info@locksmith.com', 'LockSmith');
      $this->email->to($this->input->post('email'));
      $this->email->subject("Locksmith password reset link");

      $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
      $encoded_email = urlencode(
        mcrypt_encrypt(
          MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $email, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) )
        )
      );

      $message = $this->load->view('email/forgotpassword', array(
        'email' => $this->input->post('email'),
        'user' => $checkUser,
        'param' => $encoded_email,
        'message_body' => 'Please click the link below to change your password.'
      ), true);
      $this->email->message($message);
      $this->email->send();
      $output['message'] = "We have sent a link to reset your password to ".$email.".";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      $output['message'] = "No user found with this email.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function updateuser_post()
  {
    $name = $this->post('name');
    $data = new stdClass();
    $data->id = $this->post('id');
    $data->email = $this->post('email');
    $data->name = $name[0] . ' ' . $name[1];
    $data->contact_no = $this->post('contact_no');
    if ( $this->user_model->update_user($data) ) {
      $output['message'] = "Your account is updated.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      $output['message'] = "Something went wrong.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function addselectedservices_post()
  {
    $data = new stdClass();
    $data2 = new stdClass();
    $data->user_id = $this->post('locksmith_id');
    $data2->user_id = $this->post('locksmith_id');
    if ( count( $this->post('type') ) > 0 ) {
      foreach ( $this->post('type') as $type ) {
        $data->service_id = $type;
        $this->locksmithservice_model->addLocksmithService($data);
      }
    }
    $data2->price = $this->post('price');
    $data2->creation_date = date("y-m-d H:i:s", strtotime("now"));
    if ( $this->subscription_model->addSubscription($data2) ) {
      $output['message'] = "Your account is updated.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      $output['message'] = "Something went wrong.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function payfororder_post()
  {
    $order = $this->order_model->get_order($this->post('order_id'));
    $card = $this->creditcard_model->getUserCard($this->post('customer_id'));
    if ( count( $card ) <= 0 ) {
      $output['message'] = "Credit Card not found.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
    if ( count( $order ) <= 0 ) {
      $output['message'] = "No order found.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
    if ( $order->paid == 1 ) {
      $output['message'] = "Order is already paid.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
    
    $customername = explode(' ', $order->customer_name);
    //echo $this->post('order_id') . '<br />' . $this->post('customer_id') . '<br />' . $this->post('locksmith_id'); exit;
    $DPFields = array(
      'paymentaction' => 'Sale',
      'ipaddress' => $_SERVER['REMOTE_ADDR'],
      'returnfmfdetails' => '1'
    );

    $CCDetails = array(
      //'creditcardtype' => 'MasterCard',
      //'acct' => '5424180818927383',
      'acct' => $card->cardnumber,
      'expdate' => $card->expirymonth.$card->expiryyear,
      'cvv2' => $card->cvc,
      //'startdate' => '',
      //'issuenumber' => ''
    );

    $PayerInfo = array(
      //'email' => 'muneebtariq1991@gmail.com', 
      //'payerid' => '',
      //'payerstatus' => '',
      //'business' => 'Testers, LLC'
    );

    $PayerName = array(
      //'salutation' => 'Mr.',
      'firstname' => $customername[0], 
      //'middlename' => '',
      'lastname' => $customername[1],
      //'suffix' => ''
    );

    $BillingAddress = array(
      'street' => '123 Test Ave.',
      //'street2' => '',
      'city' => 'Kansas City',
      'state' => 'MO',
      'countrycode' => 'US',
      'zip' => '64111',
      //'phonenum' => '555-555-5555'
    );

    $ShippingAddress = array(
      //'shiptoname' => 'Tester Testerson',
      //'shiptostreet' => '123 Test Ave.',
      //'shiptostreet2' => '',
      //'shiptocity' => 'Kansas City',
      //'shiptostate' => 'MO',
      //'shiptozip' => '64111',
      //'shiptocountry' => 'US',
      //'shiptophonenum' => '555-555-5555'
    );

    $PaymentDetails = array(
      'amt' => $order->price,  
      //'currencycode' => 'USD',
      //'itemamt' => '95.00',
      //'shippingamt' => '5.00',
      //'shipdiscamt' => '', 
      //'handlingamt' => '',
      //'taxamt' => '', 	 
      //'desc' => 'Web Order',
      //'custom' => '',
      //'invnum' => '',
      //'notifyurl' => ''
    );	

    $OrderItems = array();
    $Item	 = array(
      //'l_name' => 'Test Widget 123',
      //'l_desc' => 'The best test widget on the planet!',
      //'l_amt' => '95.00',
      //'l_number' => '123',
      //'l_qty' => '1',
      //'l_taxamt' => '',
      //'l_ebayitemnumber' => '',
      //'l_ebayitemauctiontxnid' => '',
      //'l_ebayitemorderid' => ''
    );
    array_push($OrderItems, $Item);

    $Secure3D = array(
      //'authstatus3d' => '', 
      //'mpivendor3ds' => '', 
      //'cavv' => '', 
      //'eci3ds' => '', 
      //'xid' => ''
    );

    $PayPalRequestData = array(
      'DPFields' => $DPFields, 
      'CCDetails' => $CCDetails, 
      'PayerInfo' => $PayerInfo, 
      'PayerName' => $PayerName, 
      'BillingAddress' => $BillingAddress, 
      'ShippingAddress' => $ShippingAddress, 
      'PaymentDetails' => $PaymentDetails, 
      'OrderItems' => $OrderItems, 
      'Secure3D' => $Secure3D
    );

    $PayPalResult = $this->paypal_pro->DoDirectPayment($PayPalRequestData);

    if ( $this->paypal_pro->APICallSuccessful($PayPalResult['ACK']) ) {
      $output['message'] = $PayPalResult;
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      // Successful call.  Load view or whatever you need to do here.
      $errors = $PayPalResult['ERRORS'];
      $output['message'] = "(".$errors[0]['L_ERRORCODE'].")\n".$errors[0]['L_SHORTMESSAGE'].".\n".$errors[0]['L_LONGMESSAGE'];
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
      //$data = array('PayPalResult'=>$PayPalResult);
      //$this->load->view('paypal/samples/do_direct_payment',$data);
    }
    //if ( $this->user_model->update_user($data) ) {
    //  $output['message'] = "Your account is updated.";
    //  $this->set_response($output, REST_Controller::HTTP_CREATED);
    //} else {
    //  $output['message'] = "Something went wrong.";
    //  $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    //}
  }

  public function paylocksmith_post()
  {
    $card = $this->creditcard_model->getUserCard($this->post('locksmith_id'));
    $user = $this->user_model->get_user($this->post('locksmith_id'));
    $types = $this->type_model->getLocksmithTypes($this->post('locksmith_id'));
    if ( count( $card ) <= 0 ) {
      $output['message'] = "Credit Card not found.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
    
    $customername = explode(' ', $user->name);
    //echo $this->post('order_id') . '<br />' . $this->post('customer_id') . '<br />' . $this->post('locksmith_id'); exit;
    $DPFields = array(
      'paymentaction' => 'Sale',
      'ipaddress' => $_SERVER['REMOTE_ADDR'],
      'returnfmfdetails' => '1'
    );

    $CCDetails = array(
      //'creditcardtype' => 'MasterCard',
      //'acct' => '5424180818927383',
      'acct' => $card->cardnumber,
      'expdate' => $card->expirymonth.$card->expiryyear,
      'cvv2' => $card->cvc,
      //'startdate' => '',
      //'issuenumber' => ''
    );

    $PayerInfo = array(
      //'email' => 'muneebtariq1991@gmail.com', 
      //'payerid' => '',
      //'payerstatus' => '',
      //'business' => 'Testers, LLC'
    );

    $PayerName = array(
      //'salutation' => 'Mr.',
      'firstname' => $customername[0], 
      //'middlename' => '',
      'lastname' => $customername[1],
      //'suffix' => ''
    );

    $BillingAddress = array(
      'street' => '123 Test Ave.',
      //'street2' => '',
      'city' => 'Kansas City',
      'state' => 'MO',
      'countrycode' => 'US',
      'zip' => '64111',
      //'phonenum' => '555-555-5555'
    );

    $ShippingAddress = array(
      //'shiptoname' => 'Tester Testerson',
      //'shiptostreet' => '123 Test Ave.',
      //'shiptostreet2' => '',
      //'shiptocity' => 'Kansas City',
      //'shiptostate' => 'MO',
      //'shiptozip' => '64111',
      //'shiptocountry' => 'US',
      //'shiptophonenum' => '555-555-5555'
    );

    $PaymentDetails = array(
      'amt' => '100',  
      //'currencycode' => 'USD',
      //'itemamt' => '95.00',
      //'shippingamt' => '5.00',
      //'shipdiscamt' => '', 
      //'handlingamt' => '',
      //'taxamt' => '', 	 
      //'desc' => 'Web Order',
      //'custom' => '',
      //'invnum' => '',
      //'notifyurl' => ''
    );	

    $OrderItems = array();
    $Item	 = array(
      //'l_name' => 'Test Widget 123',
      //'l_desc' => 'The best test widget on the planet!',
      //'l_amt' => '95.00',
      //'l_number' => '123',
      //'l_qty' => '1',
      //'l_taxamt' => '',
      //'l_ebayitemnumber' => '',
      //'l_ebayitemauctiontxnid' => '',
      //'l_ebayitemorderid' => ''
    );
    array_push($OrderItems, $Item);

    $Secure3D = array(
      //'authstatus3d' => '', 
      //'mpivendor3ds' => '', 
      //'cavv' => '', 
      //'eci3ds' => '', 
      //'xid' => ''
    );

    $PayPalRequestData = array(
      'DPFields' => $DPFields, 
      'CCDetails' => $CCDetails, 
      'PayerInfo' => $PayerInfo, 
      'PayerName' => $PayerName, 
      'BillingAddress' => $BillingAddress, 
      'ShippingAddress' => $ShippingAddress, 
      'PaymentDetails' => $PaymentDetails, 
      'OrderItems' => $OrderItems, 
      'Secure3D' => $Secure3D
    );

    $PayPalResult = $this->paypal_pro->DoDirectPayment($PayPalRequestData);

    if ( $this->paypal_pro->APICallSuccessful($PayPalResult['ACK']) ) {
      $output['message'] = $PayPalResult;
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      // Successful call.  Load view or whatever you need to do here.
      $errors = $PayPalResult['ERRORS'];
      $output['message'] = "(".$errors[0]['L_ERRORCODE'].")\n".$errors[0]['L_SHORTMESSAGE'].".\n".$errors[0]['L_LONGMESSAGE'];
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
      //$data = array('PayPalResult'=>$PayPalResult);
      //$this->load->view('paypal/samples/do_direct_payment',$data);
    }
    //if ( $this->user_model->update_user($data) ) {
    //  $output['message'] = "Your account is updated.";
    //  $this->set_response($output, REST_Controller::HTTP_CREATED);
    //} else {
    //  $output['message'] = "Something went wrong.";
    //  $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    //}
  }

  public function completeorder_post()
  {
    $data = new stdClass();
    $data->id = $this->post('id');
    $data->status = 3;
    $data->completed_date = date("Y-m-d H:i:s", strtotime("now"));
    if ( $this->order_model->updateorder($data) ) {
      $output['message'] = "Your order is completed.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      $output['message'] = "Something went wrong.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function getservices_get()
  {
    $services = $this->type_model->getAllTypesforlock();
    $this->response($services, REST_Controller::HTTP_OK);
  }

  public function locktypes_get()
  {
    $types = $this->type_model->getAllTypes();
    $this->response($types, REST_Controller::HTTP_OK);
  }

  public function orders_get()
  {
    $id = $this->get("id");
    $orders = $this->order_model->getCustomerOrders($id);
    $this->response($orders, REST_Controller::HTTP_OK);
  }
  
  public function customeracceptorder_post()
  {
    $id = $this->post("id");
    $data = new stdClass();
    $data->id = $id;
    $data->c_accepted = 1;
    $locksmith = $this->order_model->get_order($id);
    if ( count( $locksmith ) > 0 ) {
        $output['locksmith_id'] = $locksmith->locksmith_id;
    }

    if ( $this->order_model->updateorder($data) ) {
      $output['message'] = "You accepted the order.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      $output['message'] = "No result found.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function lockorders_get()
  {
    $id = $this->get("id");
    $subscription = $this->subscription_model->getSubscriptionByUser($id);
    if ( count( $subscription ) > 0 ) {
      if ( $subscription->trial == 1 || ( $subscription->status != 0 && $subscription->status != 2 && $subscription->status != 3 ) ) {
        $orders = $this->order_model->getLocksmithOrders($id);
        $this->response($orders, REST_Controller::HTTP_OK);
      } else {
        $orders["message"] = "not found";
        $this->response($orders, REST_Controller::HTTP_OK);
      }
    } else {
      $orders["message"] = "not found";
      $this->response($orders, REST_Controller::HTTP_OK);
    }
  }

  public function getlocksmithtypes_get()
  {
    $id = $this->get("id");
    $prices = $this->price_model->get_allprices($id);
    $this->response($prices, REST_Controller::HTTP_OK);
  }

  public function allpendingorders_get()
  {
    $ids = array();
    $locksmith_id = $this->get("locksmith");
    $subscription = $this->subscription_model->getSubscriptionByUser($locksmith_id);
    $rejectedOrder = $this->rejectorder_model->getRejectorderbyLocksmith($locksmith_id);
    if ( count( $subscription ) > 0 ) {
      if ( $subscription->trial == 1 || ( $subscription->status != 0 && $subscription->status != 2 && $subscription->status != 3 ) ) {
        if ( count( $rejectedOrder ) > 0 ) {
          foreach ( $rejectedOrder as $reject ) {
            $ids[$reject["order_id"]] = $reject["order_id"];
          }
          if ( count($ids) > 0 ) {
            $orders = $this->order_model->getPendingOrders($ids);
            $this->response($orders, REST_Controller::HTTP_OK);
          } else {
            $orders["message"] = "not found";
            $this->response($orders, REST_Controller::HTTP_OK);
          }
        } else {
          $orders["message"] = "not found";
          $this->response($orders, REST_Controller::HTTP_OK);
        }
      } else {
        $orders["message"] = "not found";
        $this->response($orders, REST_Controller::HTTP_OK);
      }
    } else {
      $orders["message"] = "not found";
      $this->response($orders, REST_Controller::HTTP_OK);
    }
  }

  public function getcreditcard_get()
  {
    $id = $this->get("id");
    $card = $this->creditcard_model->getUserCard($id);
    if ( count( $card ) > 0 ) {
      $this->response($card, REST_Controller::HTTP_OK);
    } else {
      $output["message"] = "Not found.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    }
  }

  public function checkordercomplete_get()
  {
    $customer_id = $this->get("customer_id");
//    $order_id = $this->get("order_id");
    $lastorder = $this->order_model->checkOrderComplete($customer_id);
    if ( count( $lastorder ) > 0 ) {
      $data = new stdClass();
      $data->id = $lastorder->id;
      $data->viewed = 1;
      $this->order_model->updateorder($data);
      $this->response($lastorder, REST_Controller::HTTP_OK);
    } else {
      $output["message"] = "Not found.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    }
  }

  public function checklastorder_get()
  {
    $customer_id = $this->get("customer_id");
    $order_id = $this->get("order_id");
    $lastorder = $this->order_model->checkLastOrder($customer_id, $order_id);
    if ( count( $lastorder ) > 0 ) {
      $this->response($lastorder, REST_Controller::HTTP_OK);
    } else {
      $output["message"] = "Not found.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    }
  }

  public function getlockservicsubscription_get()
  {
    $user_id = $this->get("id");
    $getService = $this->locksmithservice_model->getAllLocksmithServices($user_id);
    $getSubscription = $this->subscription_model->getSubscriptionByUser($user_id);
    $data = new stdClass();
    $data->subscription = $getSubscription;
    $data->services = $getService;
    
    if ( count( $data ) > 0 ) {
      $this->response($data, REST_Controller::HTTP_OK);
    } else {
      $output["message"] = "Not found.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    }
  }

  public function neworders_post()
  {
    $locksmith_id = $this->get("locksmith");
    $ids = $this->post('ids');
    $subscription = $this->subscription_model->getSubscriptionByUser($locksmith_id);
    $rejectedOrder = $this->rejectorder_model->getRejectorderbyLocksmith($locksmith_id);
    if ( count( $subscription ) > 0 ) {
      if ( $subscription->trial == 1 || ( $subscription->status != 0 && $subscription->status != 2 && $subscription->status != 3 ) ) {
        if ( count( $rejectedOrder ) > 0 ) {
          foreach ( $rejectedOrder as $reject ) {
            $ids[$reject->order_id] = $reject->order_id;
          }
        }
        $orders = $this->order_model->getNewOrders($ids);
        $this->response($orders, REST_Controller::HTTP_OK);
      } else {
        $orders["message"] = "not found";
        $this->response($orders, REST_Controller::HTTP_OK);
      }
    } else {
      $orders["message"] = "not found";
      $this->response($orders, REST_Controller::HTTP_OK);
    }
  }

  public function addprice_post()
  {
    $data = new stdClass();
    $data->user_id = $this->post('locksmith_id');
    $data->type_id = $this->post('type');
    $data->price = $this->post('price');
    if ( $this->post('id') ) {
      $data->id = $this->post('id');
      $this->price_model->updateprice($data);
      $price = $data->id;
    } else {
      $price = $this->price_model->addprice($data);
      
    }
    $this->response($price, REST_Controller::HTTP_OK);
  }

  public function placeorder_post()
  {
    $data = new stdClass();
    $data->address = $this->post("mapaddress");
    if ( $this->post("date") != "" ) {
      $data->start_date = date("Y-m-d H:i:s", strtotime($this->post("date")));
    } else {
      $data->start_date = date("Y-m-d H:i:s", strtotime("now"));
    }
    
    $data->customer_id = $this->post("customer_id");
    $data->type_id = $this->post("lock_type");
    $data->status = 0;

    if ( !empty( $this->post("coupon") ) ) {
      $coupon = $this->coupon_model->couponExist($this->post("coupon"));
      if ( count( $coupon ) > 0 ) {
        $data->coupon_discount = $coupon->discount;
      }
    }

    if ( $id = $this->order_model->addorder($data) ) {
      $output["id"] = $id;
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    }
  }

  public function acceptorder_post()
  {
    $data = new stdClass();
    $data->id = $this->post('order_id');
    $data->locksmith_id = $this->post('locksmith_id');
    $data->eta = $this->post('duration');
    $data->status = 1;
    $data->accepted_date = date("Y-m-d H:i:s", strtotime("now"));
    $order = $this->order_model->get_order($this->post('order_id'));
    if ( count ( $order ) > 0 ) {
      if ( $order->type_id != 0 ) {
        $price = $this->price_model->getLocksmithTypePrice($order->type_id, $this->post('locksmith_id'));
        if ( count($price) > 0 ) {
          $data->price = $price->price;
        } else {
          $type = $this->type_model->get_type($order->type_id);
          if ( count ( $type ) > 0 ) {
            $data->price = $type->price;
          }
        }
      }
    }

    if ( $this->order_model->updateorder($data) ) {
      $getOrder = $this->order_model->get_order($this->post('order_id'));
      $this->set_response($getOrder, REST_Controller::HTTP_CREATED);
    } else {
      $output['message'] = "Something went wrong.";
      $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
    }
  }

  public function addreview_post()
  {
    $data = new stdClass();
    $data->rating = $this->post('rating');
    $data->review = $this->post('review');
    $data->customer_id = $this->post('customer_id');
    $data->locksmith_id = $this->post('locksmith_id');
    $data->order_id = $this->post('order_id');
    $data->posted_by = $this->post('posted_by');
    $data->creation_date = date("Y-m-d H:i:s", strtotime("now"));

    if ( $id = $this->review_model->addreview($data) ) {
      $data2 = new stdClass();
      $data2->id = $this->post('order_id');
      $data2->reviewed = 1;
      $this->order_model->updateorder($data2);
      $output['message'] = "Review added successfully.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    }
  }

  public function updatedevice_post()
  {
    $data = new stdClass();
    $data->id = $id = $this->post('customer_id');
    $data->device = $this->post('device');
    $user = $this->user_model->get_user($id);
    if ( count( $user ) > 0 ) {
      $this->user_model->update_user($data);
      $output['message'] = "Device Added.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      $output['message'] = "Device Not Added.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    }
  }

  public function addcreditcard_post()
  {
    $data = new stdClass();
    $data->cardnumber = $this->post('cardnumber');
    $data->cvc = $this->post('cvc');
    $data->expirymonth = $this->post('expirymonth');
    $data->expiryyear = $this->post('expiryyear');
    $data->user_id = $this->post('user_id');
    $data->creation_date = date("Y-m-d H:i:s", strtotime("now"));
    if ( $this->post('id') ) {
      $data->id = $this->post('id');
      $this->creditcard_model->updateCreditCard($data);
      $output['message'] = "Your credit card is updated successfully.";
      $this->set_response($output, REST_Controller::HTTP_CREATED);
    } else {
      if ( $this->creditcard_model->addCreditCard($data) ) {
        $output['message'] = "Your credit card is added.";
        $this->set_response($output, REST_Controller::HTTP_CREATED);
      } else {
        $output['message'] = "Something went wrong.";
        $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
      }
    }
  }

  public function uploadlicense_post()
  {
    $user_id = $this->post("user_id");
    if ( $_FILES['license'] ) {
      $new_name = time().$_FILES["license"]["name"];
      $uploaddir = "./uploads/user/" . $user_id . "/";
      $uploadfile = $uploaddir . basename($new_name);

      if ( !file_exists( $uploaddir ) ) {
        mkdir($uploaddir, 0777, true);
      }

      if (move_uploaded_file($_FILES['license']['tmp_name'], $uploadfile)) {
        $data = new stdClass();
        $data->id = $user_id;
        $data->license = $new_name;
        $this->user_model->update_user($data);
        
        $output['message'] = "License uploaded successfully.";
        $this->set_response($output, REST_Controller::HTTP_CREATED);
      }
    }
  }

  public function uploadinsurance_post()
  {
    $user_id = $this->post("user_id");
    if ( $_FILES['insurance'] ) {
      $new_name = time().$_FILES["insurance"]["name"];
      $uploaddir = "./uploads/user/" . $user_id . "/";
      $uploadfile = $uploaddir . basename($new_name);

      if ( !file_exists( $uploaddir ) ) {
        mkdir($uploaddir, 0777, true);
      }

      if (move_uploaded_file($_FILES['insurance']['tmp_name'], $uploadfile)) {
        $data = new stdClass();
        $data->id = $user_id;
        $data->insurance = $new_name;
        $this->user_model->update_user($data);
        
        $output['message'] = "Insurance uploaded successfully.";
        $this->set_response($output, REST_Controller::HTTP_CREATED);
      }
    }
  }

  public function sendnotification_post()
  {
    $user_id        = $this->post('customer_id');

    $user = $this->user_model->get_user($user_id);
    if ( count( $user ) > 0 ) {
      if ( $user->device != '' ) {
        $data['title']      = 'Pending Review';
        $data['message']    = 'Please give review.';
        $data['data']       = ['test' => 'test'];
        $data['key']          = 'AIzaSyA-xogGCu3aAyKamoWN376_rCrI48JRNtA';

        $fields = array(
          "registration_ids" => $user->device, //1000 per request logic is pending
          "content_available" => true,
          "priority" => "high",
          "data" => $data['data'],
          "notification" => array(
            "body" => strip_tags($data['message']),
            "title" => $data['title'],
            "sound" => "default",
          )
        );

        //$url = 'https://gcm-http.googleapis.com/gcm/send'; //note: its different than android.
        $url = 'https://android.googleapis.com/gcm/send';
        $headers = array(
          'Authorization: key='.$data['key'],
          'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);echo '<pre>';print_r($result); print_r(curl_error($ch)); echo '</pre>';// exit;
        if ($result === FALSE) {
          $output['message'] = curl_error($ch);
          $this->set_response($output, REST_Controller::HTTP_CREATED);

          die('Curl failed: ' . curl_error($ch));
        } else {
          $output['message'] = curl_error($ch);
          $this->set_response($output, REST_Controller::HTTP_CREATED);
        }
        // Close connection
        curl_close($ch);

      }
    }

  }

  function notify_post()
  {
    // API access key from Google API's Console
    // replace API
    $to = $this->post("id");
//    define('API_ACCESS_KEY', 'AIzaSyAfprQ7ln063Zy26OmL1M4MDfMfnMItG6g');
    $registrationIds = array($to);
    $msg = array
    (
    'message' => "Testing testing 123...",
    'title' => "Hello",
    'vibrate' => 1,
    'sound' => 1

    // you can also add images, additionalData
    );
    $fields = array
    (
    'registration_ids' => $registrationIds,
    'data' => $msg
    );
    $headers = array
    (
    'Authorization: key=AAAAFL5WrqA:APA91bEjKkQ4O-7Zn9QwWpj7ZvXE42bov_WoYmviQySGk_amIzyqPCwy_xY-8EKDWAdQbDwYVq06VadvvSot5CdTRCt3I826NKOO3ot2w-Aw94qj8GeNwX4ydF19V_GEN81yqe3WzNM5',
    'Content-Type: application/json'
    );
    
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    if ($result === FALSE) {
        $response = array("status" => 'error', 'code'=>200, 'message'=>curl_error($ch));
        $this->set_response($response, REST_Controller::HTTP_CREATED);

        die('Curl failed: ' . curl_error($ch));
    }else {
        $response = array("status" => 'success', 'code'=>200, 'message'=>$result);
        $this->set_response($response, REST_Controller::HTTP_CREATED);
    }
    // Close connection
    curl_close($ch);
  }
  
  public function sendPushNotification($data, $register_keys)
  {
    $fields = array(
      //"to" => $gcm_ios_mobile_reg_key,
      "registration_ids" => $register_keys, //1000 per request logic is pending
      "content_available" => true,
      "priority" => "high",
      "data" => $data['data'],
      "notification" => array(
        "body" => strip_tags($data['message']),
        "title" => $data['title'],
        "sound" => "default",
      )
    );


    $url = 'https://gcm-http.googleapis.com/gcm/send'; //note: its different than android.
    $headers = array(
      'Authorization: key='.$data['key'],
      'Content-Type: application/json'
    );

    // Open connection
    $ch = curl_init();

    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    // Execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
        $response = array("status" => 'error', 'code'=>200, 'message'=>curl_error($ch));
        $this->set_response($response, REST_Controller::HTTP_CREATED);

        die('Curl failed: ' . curl_error($ch));
    }else {
        $response = array("status" => 'success', 'code'=>200, 'message'=>$result);
        $this->set_response($response, REST_Controller::HTTP_CREATED);
    }
    // Close connection
    curl_close($ch);
  }

}