<?php
defined("BASEPATH") OR exit("No direct script access allowed");
/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model
{
  /**
   * __construct function.
   * 
   * @access public
   * @return void
   */
  var $column_locksmith = array("id", "name", "email", "contact_no", "address", null);
  var $column_customer = array("id", "name", "email", "contact_no", "address", null);

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  /**
   * create_user function.
   * 
   * @access public
   * @param mixed $username
   * @param mixed $email
   * @param mixed $password
   * @return bool true on success, false on failure
   */
  public function create_user($data)
  {
    $data->password = $this->hash_password($data->password);
    $this->db->insert("rnr_users", $data);
    return $this->db->insert_id();
  }

  public function update_user($data)
  {
    if ( isset( $data->password ) && !empty( $data->password ) ) {
      $data->password = $this->hash_password($data->password);
    }
    $this->db->where("id", $data->id)->update("rnr_users", $data);
    return true;
  }

  /**
   * resolve_user_login function.
   * 
   * @access public
   * @param mixed $email
   * @param mixed $password
   * @return bool true on success, false on failure
   */
  public function resolve_user_login($data)
  {
    $this->db->select("password");
    $this->db->from("rnr_users");
    $this->db->where("email", $data->email);
    $this->db->where("level", $data->level);
    $this->db->where("status", 1);
    $hash = $this->db->get()->row("password");

    return $this->verify_password_hash($data->password, $hash);
  }

  public function resolve_admin_lock_login($data)
  {
    $this->db->select("password");
    $this->db->from("rnr_users");
    $this->db->where("email", $data->email);
   // $this->db->where("level", $data->level);
    $this->db->where("level", 1);
    $this->db->where("status", 1);
    $hash = $this->db->get()->row("password");

    return $this->verify_password_hash($data->password, $hash);
  }

  /**
   * get_user_id_from_username function.
   * 
   * @access public
   * @param mixed $email
   * @return int the user id
   */
  public function get_user_id_from_email($data)
  {
	  //print_r($data);
    $this->db->select("id");
    $this->db->from("rnr_users");
    $this->db->where("email", $data->email);
	if(isset($data->level))
		$this->db->where("level", $data->level);
    return $this->db->get()->row("id");
  }

  public function get_user_id_from_email_admin_lock($data)
  {
    $this->db->select("id");
    $this->db->from("rnr_users");
    $this->db->where("email", $data->email);
    //$this->db->where("level", $data->level);
    $this->db->where("level", 1);
    return $this->db->get()->row("id");
  }

  /**
   * get_user function.
   * 
   * @access public
   * @param mixed $user_id
   * @return object the user object
   */
  public function get_user($user_id)
  {
    $this->db->from("rnr_users");
    $this->db->where("id", $user_id);
    return $this->db->get()->row();
  }

  public function getUserbyInfo($text)
  {
    $this->db->select("id, firstname, lastname, contact_no, current_address, occupation, image");
    $this->db->from("rnr_users");
    $this->db->like("firstname", $text);
    $this->db->or_like("lastname", $text);
    $this->db->or_like("contact_no", $text);
    return $this->db->get()->result_array();
  }

  public function getAllLocksmith()
  {
    $this->db->from("rnr_users");
    $this->db->where("level", 2);
    $this->db->where("status", 1);

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("name", $_POST["search"]["value"]);
      $this->db->or_like("email", $_POST["search"]["value"]);
      $this->db->or_like("contact_no", $_POST["search"]["value"]);
      $this->db->or_like("address", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_locksmith[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else {
      $this->db->order_by("id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function getAllCustomers()
  {
    $this->db->from("rnr_users");
    $this->db->where("level", 3);
    $this->db->where("status", 1);

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("name", $_POST["search"]["value"]);
      $this->db->or_like("email", $_POST["search"]["value"]);
      $this->db->or_like("contact_no", $_POST["search"]["value"]);
      $this->db->or_like("address", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_customer[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else {
      $this->db->order_by("id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function count_all_lock()
  {
    $this->db->from("rnr_users");
    $this->db->where("level", 2);
    $this->db->where("status", 1);
    return $this->db->count_all_results();
  }

  public function count_all_cust()
  {
    $this->db->from("rnr_users");
    $this->db->where("level", 3);
    $this->db->where("status", 1);
    return $this->db->count_all_results();
  }

  public function getNewLocksmiths()
  {
    $this->db->from("rnr_users");
    $this->db->where("level", 2);
    $this->db->where("status", 1);
    $this->db->where("creation_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $this->db->order_by("id", "desc");
    return $this->db->get()->result_array();
  }

  public function getNewCustomers()
  {
    $this->db->from("rnr_users");
    $this->db->where("level", 3);
    $this->db->where("status", 1);
    $this->db->where("creation_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $this->db->order_by("id", "desc");
    return $this->db->get()->result_array();
  }

  public function getNewCustomersofLocksmith($user_id)
  {
    $this->db->from("orders");
    $this->db->where("locksmith_id", $user_id);
    $this->db->where("start_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $this->db->group_by("customer_id");
    $this->db->order_by("id", "desc");
    return $this->db->get()->result_array();
  }

  public function getCustomersByLock($id)
  {
    $this->db->from("rnr_users");
    $this->db->where("level", 3);
    $this->db->where("status", 1);
    $this->db->where("loc_id", $id);
    return $this->db->get()->result_array();
  }

  public function deleteuser($id)
  {
    $this->db->from("rnr_users")->where("id", $id)->delete();
  }

  /**
   * hash_password function.
   * 
   * @access private
   * @param mixed $password
   * @return string|bool could be a string on success, or bool false on failure
   */
  private function hash_password($password)
  {
    return password_hash($password, PASSWORD_BCRYPT);
  }

  /**
   * verify_password_hash function.
   * 
   * @access private
   * @param mixed $password
   * @param mixed $hash
   * @return bool
   */
  private function verify_password_hash($password, $hash)
  {
    return password_verify($password, $hash);
  }

  public function checkUserEmailLevel($data)
  {
    $this->db->from("rnr_users");
    $this->db->where("email", $data->email);
    $this->db->where("level", $data->level);
    return $this->db->get()->row();
  }

  public function locksmithData($id)
  {
    $query = $this->db->from("rnr_users")
                      ->where("rnr_users.id", $id)
                      ->get()
                      ->row();

    $query2 = $this->db->from("rnr_reviews")
                       ->where("reviews.locksmith_id", $id)
                       ->get()->result_array();
    
    $sum = $this->db->from("rnr_reviews")->select_sum("rating")
                    ->where("rnr_reviews.locksmith_id", $id)
                    ->get()->row();

    $average = (int) $sum->rating / (int) count($query2);

    $data = array(
      "locksmith_id" => $query->id,
      "locksmith_name" => $query->name,
      "locksmith_email" => $query->email,
      "locksmith_contact" => $query->contact_no,
      "locksmith_address" => $query->address,
      "locksmith_experience" => $query->experience,
      "locksmith_image" => $query->image,
      "locksmith_averagerating" => $average,
      "locksmith_reviews" => $query2
    );

    return $data;
  }
}