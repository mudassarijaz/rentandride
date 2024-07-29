<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Payment_model extends CI_Model
{
  var $column_payments = array("payments.id", "u1.name", "payments.amount", "payments.status", "payments.creation_date", "payments.creation_date");
  var $column_paymentslock = array("payments.id", "payments.amount", "payments.status", "payments.creation_date", "payments.creation_date");

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addPayment($data)
  {
    $this->db->insert("payments", $data);
    return $this->db->insert_id();
  }

  public function updatePayment($data)
  {
    $this->db->where("id", $data->id)->update("payments", $data);
    return true;
  }

  public function getPayment($id)
  {
    $this->db->from("payments");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllPayments()
  {
    $this->db->from("payments");
    return $this->db->get()->result_array();
  }

  public function getCompletedPayments()
  {
    $this->db->from("payments");
    $this->db->where("status", 1);
    $this->db->select_sum("amount");
    return $this->db->get()->row();
  }

  public function getLockCompletedPayments($user_id)
  {
    $this->db->from("payments");
    $this->db->where("status", 1);
    $this->db->where("locksmith_id", $user_id);
    $this->db->select_sum("amount");
    return $this->db->get()->row();
  }

  public function detailPayments($user_id = null)
  {
    $select = "payments.id,payments.customer_id,payments.locksmith_id,payments.amount,payments.status,payments.creation_date,u1.name as locksmith_name";
    $this->db->select($select);
    $this->db->from("payments");
    $this->db->join("users u1", "payments.locksmith_id=u1.id", "left");
    $this->db->where("payments.status", 1);
    
    if ( $user_id ) {
      $this->db->where("payments.locksmith_id", $user_id);
    }

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("u1.name", $_POST["search"]["value"]);
      $this->db->or_like("payments.amount", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      if ( $user_id ) {
        $this->db->order_by($this->column_paymentslock[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
      } else {
        $this->db->order_by($this->column_payments[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
      }
    } else {
      $this->db->order_by("payments.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function count_all($user_id = null)
  {
    $this->db->from("payments");
    
    if ( $user_id ) {
      $this->db->where("locksmith_id", $user_id);
    }

    return $this->db->count_all_results();
  }

  public function deletePayment($id)
  {
    $this->db->from("payments")->where("id", $id)->delete();
  }
}