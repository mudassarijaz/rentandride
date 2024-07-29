<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Promotion_model extends CI_Model
{
  var $column_promotion = array("id", "name", "description");

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addpromotion($data)
  {
    $this->db->insert("promotions", $data);
    return $this->db->insert_id();
  }

  public function updatepromotion($data)
  {
    $this->db->where("id", $data->id)->update("promotions", $data);
    return true;
  }

  public function getpromotion($id)
  {
    $this->db->from("promotions");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllPromotions()
  {
    $this->db->from("promotions");

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("name", $_POST["search"]["value"]);
      $this->db->or_like("description", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_promotion[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
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
    $this->db->from("promotions");
    return $this->db->count_all_results();
  }

  public function deletepromotion($id)
  {
    $this->db->from("promotions")->where("id", $id)->delete();
  }
}