<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Type_model extends CI_Model
{
  var $column_type = array("id", "name", "price", "locksmithprice");

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addtype($data)
  {
    $this->db->insert("types", $data);
    return $this->db->insert_id();
  }

  public function updatetype($data)
  {
    $this->db->where("id", $data->id)->update("types", $data);
    return true;
  }

  public function get_type($id)
  {
    $this->db->from("types");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllTypes()
  {
    $this->db->from("types");

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("name", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_type[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
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
    $this->db->from("types");
    return $this->db->count_all_results();
  }

  public function getAllTypesforlock()
  {
    $select = "id, name, locksmithprice AS price";
    $this->db->select($select);
    $this->db->from("types");
    return $this->db->get()->result_array();
  }
  
  public function getLocksmithTypes()
  {}

  public function deletetype($id)
  {
    $this->db->from("types")->where("id", $id)->delete();
  }
}