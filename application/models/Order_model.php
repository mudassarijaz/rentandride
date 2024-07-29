<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Order_model extends CI_Model
{
  var $column_order = array("id", "u1.name", "u2.name", "rnr_rides.type_id", "rnr_rides.price", "rnr_rides.evening", "rnr_rides.weekend", "rnr_rides.status", "rnr_rides.start_date");
  var $column_order2 = array("id", "u2.name", "rnr_rides.type_id", "rnr_rides.price", "rnr_rides.evening", "rnr_rides.weekend", "rnr_rides.status", "rnr_rides.start_date");
  var $column_order3 = array("rnr_rides.customer_id", "u2.name", "u2.email", "u2.contact_no", "u2.city", "u2.address");
  var $column_search = array("locksmith_id", "customer_id", "type_id", "price", "status");
  var $column_corder = array("id", "u1.name", "u2.name", "t.name", "rnr_rides.price", "rnr_rides.status", "rnr_rides.completed_date");
  var $column_corderlock = array("id", "u2.name", "t.name", "rnr_rides.price", "rnr_rides.status", "rnr_rides.completed_date");
  var $order = array("id" => "asc");

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addorder($data)
  {
    $this->db->insert("rnr_rides", $data);
    return $this->db->insert_id();
  }

  public function updateorder($data)
  {
    $this->db->where("id", $data->id)->update("rnr_rides", $data);
    return true;
  }

  public function get_order($id)
  {
    $select = "rnr_rides.id,rnr_rides.customer_id,rnr_rides.locksmith_id,rnr_rides.type_id,rnr_rides.price,rnr_rides.evening,rnr_rides.weekend,rnr_rides.quantity,rnr_rides.status,rnr_rides.start_date,rnr_rides.end_date,rnr_rides.city,rnr_rides.address,rnr_rides.paid,u1.name as locksmith_name,u2.name as customer_name,u1.image as locksmith_image,u2.image as customer_image,u1.contact_no as locksmith_contact,u2.contact_no as customer_contact,u1.email as locksmith_email,u2.email as customer_email,types.name as type_name";
    $this->db->select($select);
    $this->db->from("rnr_rides");
    //$this->db->join("users u1", "rnr_rides.locksmith_id=u1.id", "left");
    $this->db->join("users u2", "rnr_rides.customer_id=u2.id", "left");
    $this->db->join("types", "rnr_rides.type_id=types.id", "left");
    $this->db->where("orders.id", $id);
    return $this->db->get()->row();
  }

  public function getAllOrders()
  {
    $select = "rnr_rides.*,u2.name as customer_name";
    $this->db->select($select);
    $this->db->from("rnr_rides");
   // $this->db->join("users u1", "rnr_rides.locksmith_id=u1.id", "left");
    $this->db->join("rnr_users u2", "rnr_rides.user_id=u2.id", "left");
    //$this->db->join("types", "rnr_rides.type_id=types.id", "left");

    $i = 0;
    if ( !empty( $_POST["search"]["value"] ) ) {
     // $this->db->like("u1.name", $_POST["search"]["value"]);
      $this->db->or_like("u2.name", $_POST["search"]["value"]);
     // $this->db->or_like("types.name", $_POST["search"]["value"]);
    }

    if( isset( $_POST["rnr_rides"] ) ) {
      $this->db->order_by($this->column_order[$_POST["rnr_rides"]["0"]["column"]], $_POST["rnr_rides"]["0"]["dir"]);
    } else {
      $this->db->order_by("rnr_rides.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function getCompletedOrders($user_id = null)
  {
    $select = "rnr_rides.id,rnr_rides.customer_id,rnr_rides.locksmith_id,rnr_rides.price,rnr_rides.status,rnr_rides.completed_date,u1.name as locksmith_name,u2.name as customer_name,t.name as type_name";
    $this->db->select($select);
    $this->db->from("rnr_rides");
    $this->db->join("users u1", "rnr_rides.locksmith_id=u1.id", "left");
    $this->db->join("users u2", "rnr_rides.customer_id=u2.id", "left");
    $this->db->join("types t", "rnr_rides.type_id=t.id", "left");
    $this->db->where("rnr_rides.status", "3");

    if ( $user_id ) {
      $this->db->where("rnr_rides.locksmith_id", $user_id);
    }

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("u1.name", $_POST["search"]["value"]);
      $this->db->or_like("u2.name", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      if ( $user_id ) {
        $this->db->order_by($this->column_corderlock[$_POST["rnr_rides"]["0"]["column"]], $_POST["rnr_rides"]["0"]["dir"]);
      } else {
        $this->db->order_by($this->column_corder[$_POST["rnr_rides"]["0"]["column"]], $_POST["rnr_rides"]["0"]["dir"]);
      }
    } else {
      $this->db->order_by("rnr_rides.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1 ) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function count_all_completed($user_id = null)
  {
    $this->db->from("rnr_rides");
    $this->db->where("status", "3");
    if ( $user_id ) {
      $this->db->where("locksmith_id", $user_id);
    }
    return $this->db->count_all_results();
  }

  public function count_all()
  {
    $this->db->from("rnr_rides");
    return $this->db->count_all_results();
  }

  public function count_lock_all($id)
  {
    $this->db->from("rnr_rides");

    return $this->db->count_all_results();
  }

  public function deleteorder($id)
  {
    $this->db->from("rnr_rides")->where("id", $id)->delete();
  }
    public function detailadminorder($id)
  {

     $select = "rnr_rides.id,rnr_rides.user_id,rnr_rides.price,rnr_rides.status,rnr_rides.address,rnr_rides.start_date,rnr_rides.end_date,rnr_rides.start_date,rnr_rides.start_latitude,rnr_rides.start_longitude,rnr_rides.start_street,rnr_rides.start_city,rnr_rides.end_latitude,rnr_rides.end_longitude,rnr_rides.end_address,rnr_rides.reviewed,u2.name as customer_name";

   $this->db->select($select);
   $this->db->from("rnr_rides");
 
    $this->db->join("rnr_users u2", "rnr_rides.user_id=u2.id", "left")->where("rnr_rides.id", $id);
     

       $i = 0;
    if ( !empty( $_POST["search"]["value"] ) ) {
     
      $this->db->or_like("u2.name", $_POST["search"]["value"]);
    
    }

    if( isset( $_POST["rnr_rides"] ) ) {
      $this->db->order_by($this->column_order[$_POST["rnr_rides"]["0"]["column"]], $_POST["rnr_rides"]["0"]["dir"]);
    } else {
      $this->db->order_by("rnr_rides.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();



  }

  public function getLocksmithOrders($user_id)
  {
    $select = "rnr_rides.id,rnr_rides.customer_id,rnr_rides.locksmith_id,rnr_rides.type_id,rnr_rides.price,rnr_rides.evening,rnr_rides.weekend,rnr_rides.quantity,rnr_rides.status,rnr_rides.start_date,rnr_rides.end_date,rnr_rides.city,rnr_rides.address,rnr_rides.coupon_discount,rnr_rides.paid,rnr_rides.reviewed,u2.name as customer_name,u2.email as customer_email,u2.contact_no as customer_contact,u2.image as customer_image,types.name as type_name,reviews.rating,reviews.review,reviews.posted_by";
    $this->db->select($select);
    $this->db->from("rnr_rides");
    $this->db->join("users u2", "rnr_rides.customer_id=u2.id", "left");
    $this->db->join("types", "rnr_rides.type_id=types.id", "left");
    $this->db->join("reviews", "rnr_rides.id=reviews.order_id", "left");
    $this->db->where("rnr_rides.locksmith_id", $user_id);

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("u2.name", $_POST["search"]["value"]);
      $this->db->or_like("types.name", $_POST["search"]["value"]);
    }

    if( isset( $_POST["rnr_rides"] ) ) {
      $this->db->order_by($this->column_order2[$_POST["rnr_rides"]["0"]["column"]], $_POST["rnr_rides"]["0"]["dir"]);
    } else {
      $this->db->order_by("rnr_rides.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function getCustomerOrders($user_id)
  {
    $select = "rnr_rides.id,rnr_rides.customer_id,rnr_rides.locksmith_id,rnr_rides.c_accepted as customerorderaccpted,rnr_rides.type_id,rnr_rides.price,rnr_rides.evening,rnr_rides.weekend,rnr_rides.quantity,rnr_rides.status,rnr_rides.start_date,rnr_rides.end_date,rnr_rides.city,rnr_rides.address,rnr_rides.coupon_discount,rnr_rides.reviewed,rnr_rides.paid,rnr_rides.eta,u1.name as locksmith_name,u1.email as locksmith_email,u1.contact_no as locksmith_contact,u1.experience as locksmith_experience,u1.image as locksmith_image,types.name as type_name,reviews.rating,reviews.review,reviews.posted_by";
    $this->db->select($select);
    $this->db->from("rnr_rides");
    $this->db->join("users u1", "rnr_rides.locksmith_id=u1.id", "left");
    $this->db->join("types", "rnr_rides.type_id=types.id", "left");
    $this->db->join("reviews", "rnr_rides.id=reviews.order_id", "left");
    $this->db->where("rnr_rides.customer_id", $user_id);
    $this->db->order_by("rnr_rides.id", "desc");

    return $this->db->get()->result_array();
  }

  public function getPendingOrders($ids = null)
  {
    $select = "orders.id,orders.customer_id,orders.locksmith_id,orders.type_id,orders.price,orders.evening,orders.weekend,orders.quantity,orders.status,orders.start_date,orders.end_date,orders.address,orders.paid,orders.eta,u1.name as locksmith_name,u1.experience as locksmith_experience,u2.name as customer_name,types.name as type_name";
    $this->db->select($select);
    $this->db->from("orders");
    $this->db->join("users u1", "orders.locksmith_id=u1.id", "left");
    $this->db->join("users u2", "orders.customer_id=u2.id", "left");
    $this->db->join("types", "orders.type_id=types.id", "left");
    $this->db->where("orders.status", 0);
    $this->db->order_by("orders.id", "desc");
    if ( count( $ids ) > 0 ) {
      $this->db->where_not_in("orders.id", $ids);
    }

    return $this->db->get()->result_array();
  }

  public function getNewOrders($ids)
  {
    $select = "rnr_rides.id,rnr_rides.customer_id,rnr_rides.locksmith_id,rnr_rides.type_id,rnr_rides.price,rnr_rides.evening,rnr_rides.weekend,rnr_rides.quantity,rnr_rides.status,rnr_rides.start_date,rnr_rides.end_date,rnr_rides.paid,rnr_rides.address,rnr_rides.eta,u1.name as locksmith_name,u1.experience as locksmith_experience,u2.name as customer_name,types.name as type_name";
    $this->db->select($select);
    $this->db->from("rnr_rides");
    $this->db->join("users u1", "rnr_rides.locksmith_id=u1.id", "left");
    $this->db->join("users u2", "rnr_rides.customer_id=u2.id", "left");
    $this->db->join("types", "rnr_rides.type_id=types.id", "left");
    $this->db->where("rnr_rides.status", 0);
    $this->db->where_not_in("rnr_rides.id", $ids);

    return $this->db->get()->result_array();
  }

  public function checkOrderComplete($customer_id)
  {
    $select = "orders.id,orders.customer_id,orders.locksmith_id,orders.type_id,orders.price,orders.evening,orders.weekend,orders.quantity,orders.status,orders.start_date,orders.end_date,orders.address,orders.paid,u1.name as locksmith_name,u1.email as locksmith_email,u1.contact_no as locksmith_contact,u1.image as locksmith_image,u2.name as customer_name,types.name as type_name,reviews.rating,reviews.review,reviews.posted_by";
    $this->db->select($select);
    $this->db->from("orders");
    $this->db->join("users u1", "orders.locksmith_id=u1.id", "left");
    $this->db->join("users u2", "orders.customer_id=u2.id", "left");
    $this->db->join("types", "orders.type_id=types.id", "left");
    $this->db->join("reviews", "orders.id=reviews.order_id", "left");
    $this->db->where("orders.status", 3);
    $this->db->where("orders.viewed", 0);
    $this->db->where("orders.customer_id", $customer_id);
    $this->db->order_by("orders.id", "desc");

    return $this->db->get()->row();
  }

  public function checkLastOrder($customer_id, $order_id)
  {
    $select = "orders.id,orders.customer_id,orders.locksmith_id,orders.type_id,orders.price,orders.evening,orders.weekend,orders.quantity,orders.status,orders.start_date,orders.end_date,orders.address,orders.paid,orders.eta,u1.name as locksmith_name,u1.email as locksmith_email,u1.contact_no as locksmith_contact,u1.experience as locksmith_experience,u1.image as locksmith_image,u2.name as customer_name,types.name as type_name,reviews.rating,reviews.review,reviews.posted_by";
    $this->db->select($select);
    $this->db->from("orders");
    $this->db->join("users u1", "orders.locksmith_id=u1.id", "left");
    $this->db->join("users u2", "orders.customer_id=u2.id", "left");
    $this->db->join("types", "orders.type_id=types.id", "left");
    $this->db->join("reviews", "orders.id=reviews.order_id", "left");
    $this->db->where("orders.status", 1);
    $this->db->where("orders.customer_id", $customer_id);
    $this->db->where("orders.id", $order_id);

    return $this->db->get()->row();
  }

  public function getNew()
  {
    $this->db->from("orders");
    $this->db->where("start_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $this->db->order_by("id", "desc");
    return $this->db->get()->result_array();
  }

  public function getMonthsOrders()
  {
    $completed = $this->db->select("MONTH(start_date) as month, YEAR(start_date) as year, COUNT(id) as total")
            ->from("orders")
            ->where("status", "3")
            ->group_by("month")
            ->limit(12)
            ->get()->result_array();

    $pending = $this->db->select("MONTH(start_date) as month, YEAR(start_date) as year, COUNT(id) as total")
            ->from("orders")
            ->where("status", "0")
            ->group_by("month")
            ->limit(12)
            ->get()->result_array();

    $accepted = $this->db->select("MONTH(start_date) as month, YEAR(start_date) as year, COUNT(id) as total")
            ->from("orders")
            ->where("status", "1")
            ->group_by("month")
            ->limit(12)
            ->get()->result_array();
    
    $data = array(
      "completed" => $completed,
      "pending" => $pending,
      "accepted" => $accepted
    );

    return $data;
  }

  public function getLockMonthsOrders($user_id)
  {
    $completed = $this->db->select("MONTH(start_date) as month, YEAR(start_date) as year, COUNT(id) as total")
            ->from("orders")
            ->where("status", "3")
            ->where("locksmith_id", $user_id)
            ->group_by("month")
            ->limit(12)
            ->get()->result_array();

    $pending = $this->db->select("MONTH(creation_date) as month, YEAR(creation_date) as year, COUNT(id) as total")
            ->from("rejectorders")
            ->where("locksmith_id", $user_id)
            ->group_by("month")
            ->limit(12)
            ->get()->result_array();

    $accepted = $this->db->select("MONTH(start_date) as month, YEAR(start_date) as year, COUNT(id) as total")
            ->from("orders")
            ->where("status", "1")
            ->where("locksmith_id", $user_id)
            ->group_by("month")
            ->limit(12)
            ->get()->result_array();
    
    $data = array(
      "completed" => $completed,
      "pending" => $pending,
      "accepted" => $accepted
    );

    return $data;
  }

  public function getNewOrderofLocksmith($user_id)
  {
    $this->db->from("orders");
    $this->db->where("start_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $this->db->where("locksmith_id", $user_id);
    $this->db->order_by("id", "desc");
    return $this->db->get()->result_array();
  }

  public function getAllPayments()
  {
    $this->db->from("orders");
    $this->db->select_sum("price");
    $this->db->where("status", 3);
    return $this->db->get()->row();
  }

  public function getLockPayments($user_id)
  {
    $this->db->from("orders");
    $this->db->select_sum("price");
    $this->db->where("status", 3);
    $this->db->where("locksmith_id", $user_id);
    return $this->db->get()->row();
  }

  public function getLast4CustomerOrders()
  {
    $select = "orders.id,orders.customer_id,orders.locksmith_id,orders.type_id,orders.price,orders.evening,orders.weekend,orders.quantity,orders.status,orders.start_date,orders.end_date,orders.city,orders.address,orders.paid,orders.coupon_discount,orders.reviewed,u1.name as locksmith_name,u1.email as locksmith_email,u1.contact_no as locksmith_contact,u1.image as locksmith_image,u2.name as customer_name,types.name as type_name,reviews.rating,reviews.review,reviews.posted_by";
    $this->db->select($select);
    $this->db->from("orders");
    $this->db->join("users u1", "orders.locksmith_id=u1.id", "left");
    $this->db->join("users u2", "orders.customer_id=u2.id", "left");
    $this->db->join("types", "orders.type_id=types.id", "left");
    $this->db->join("reviews", "orders.id=reviews.order_id", "left");
    $this->db->order_by("orders.id", "desc");
    $this->db->limit(4);

    return $this->db->get()->result_array();
  }

  public function getLast4CustomerOrdersofLocksmith($user_id)
  {
    $select = "orders.id,orders.customer_id,orders.locksmith_id,orders.type_id,orders.price,orders.evening,orders.weekend,orders.quantity,orders.status,orders.start_date,orders.end_date,orders.city,orders.address,orders.paid,orders.coupon_discount,orders.reviewed,u1.name as locksmith_name,u1.email as locksmith_email,u1.contact_no as locksmith_contact,u1.image as locksmith_image,u2.name as customer_name,types.name as type_name,reviews.rating,reviews.review,reviews.posted_by";
    $this->db->select($select);
    $this->db->from("orders");
    $this->db->join("users u1", "orders.locksmith_id=u1.id", "left");
    $this->db->join("users u2", "orders.customer_id=u2.id", "left");
    $this->db->join("types", "orders.type_id=types.id", "left");
    $this->db->join("reviews", "orders.id=reviews.order_id", "left");
    $this->db->where("orders.locksmith_id", $user_id);
    $this->db->order_by("orders.id", "desc");
    $this->db->limit(4);

    return $this->db->get()->result_array();
  }

  public function getCustomersfromOrder($user_id)
  {
    $select = "orders.customer_id,orders.locksmith_id,u2.id,u2.name as customer_name,u2.email as customer_email,u2.contact_no as customer_contact,u2.city as customer_city,u2.address as customer_address";
    $this->db->select($select);
    $this->db->from("orders");
    $this->db->join("users u2", "orders.customer_id=u2.id", "left");
    $this->db->where("orders.locksmith_id", $user_id);
    $this->db->group_by("orders.customer_id");

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("u2.name", $_POST["search"]["value"]);
      $this->db->or_like("u2.email", $_POST["search"]["value"]);
      $this->db->or_like("u2.contact_no", $_POST["search"]["value"]);
      $this->db->or_like("u2.city", $_POST["search"]["value"]);
      $this->db->or_like("u2.address", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_order3[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else {
      $this->db->order_by("u2.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }
}