<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Coupon_model extends CI_Model
{
  var $column_coupon = array("id", "name", "discount", "count");

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addcoupon($data)
  {
    $this->db->insert("coupons", $data);
    return $this->db->insert_id();
  }

  public function updatecoupon($data)
  {
    $this->db->where("id", $data->id)->update("coupons", $data);
    return true;
  }

  public function getcoupon($id)
  {
    $this->db->from("coupons");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllCoupons()
  {
    $this->db->from("coupons");

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("name", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_coupon[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else {
      $this->db->order_by("id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function count_all()
  {
    $this->db->from("coupons");
    return $this->db->count_all_results();
  }

  public function couponExist($query)
  {
    $this->db->from("coupons");
    $this->db->like("name", $query);
    return $this->db->get()->row();
  }

  public function deletecoupon($id)
  {
    $this->db->from("coupons")->where("id", $id)->delete();
  }
}