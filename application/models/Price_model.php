<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Price_model extends CI_Model
{
  var $column_price = array(null, "types.name", "prices.price", "prices.eve_price", "prices.week_price");
  var $column_price2 = array(null, "types.name", "prices.price", "prices.eve_price", "prices.week_price");

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addprice($data)
  {
    $this->db->insert("prices", $data);
    return $this->db->insert_id();
  }

  public function updateprice($data)
  {
    $this->db->where("id", $data->id)->update("prices", $data);
    return true;
  }

  public function get_price($id)
  {
    $this->db->from("prices");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getLocksmithTypePrice($type_id, $locksmith_id)
  {
    $this->db->from("prices");
    $this->db->where("type_id", $type_id);
    $this->db->where("user_id", $locksmith_id);
    return $this->db->get()->row();
  }

  public function get_allprices($locksmith_id)
  {
    $select = "prices.id as price_id,prices.price,prices.type_id,prices.week_price,prices.eve_price,prices.week_method,prices.eve_method,prices.user_id,types.id,types.name";
    $this->db->select($select);
    $this->db->from("prices");
    $this->db->join("types", "prices.type_id=types.id", "left");
    $this->db->where("prices.user_id = $locksmith_id");

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("types.name", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_price2[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else {
      $this->db->order_by("prices.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function count_lock_all($id)
  {
    $this->db->from("prices");
    $this->db->where("user_id", $id);
    return $this->db->count_all_results();
  }

  public function deleteprice($id)
  {
    $this->db->from("prices")->where("id", $id)->delete();
  }
}