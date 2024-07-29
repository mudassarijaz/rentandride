<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Bike_model extends CI_Model
{

    var $column_bike = array("id", "model", "mac_address", "type", "creation_date", "modified_date");

  

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addbike($data)
  {
    $this->db->insert("rnr_bikes", $data);
    return $this->db->insert_id();
  }

  public function updatebike($data)
  {
    $this->db->where("id", $data->id)->update("rnr_bikes", $data);
    return true;
  }

  public function get_bike($id)
  {
    $this->db->from("rnr_bikes");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllBike()
  {
    $this->db->from("rnr_bikes");

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("name", $_POST["search"]["value"]);
    }

    if( isset( $_POST["rnr_rides"] ) ) {
      $this->db->order_by($this->column_bike[$_POST["rnr_rides"]["0"]["column"]], $_POST["rnr_rides"]["0"]["dir"]);
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
    $this->db->from("rnr_bikes");
    return $this->db->count_all_results();
  }

  public function getAllBikeforlock()
  {
    $select = "id, name, locksmithprice AS price";
    $this->db->select($select);
    $this->db->from("rnr_bikes");
    return $this->db->get()->result_array();
  }
  


  public function deletebike($id)
  {
    $this->db->from("rnr_bikes")->where("id", $id)->delete();
  }
}