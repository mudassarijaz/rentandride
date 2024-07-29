<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Rejectorder_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addRejectorder($data)
  {
    $this->db->insert("rejectorders", $data);
    return $this->db->insert_id();
  }

  public function updateRejectorder($data)
  {
    $this->db->where("id", $data->id)->update("rejectorders", $data);
    return true;
  }

  public function getRejectorder($id)
  {
    $this->db->from("rejectorders");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getRejectorderbyCustomer($id)
  {
    $this->db->from("rejectorders");
    $this->db->where("customer_id", $id);
    return $this->db->get()->result_array();
  }

  public function getRejectorderbyLocksmith($id)
  {
    $this->db->from("rejectorders");
    $this->db->where("locksmith_id", $id);
    return $this->db->get()->result_array();
  }

  public function getAllRejectorders()
  {
    $this->db->from("rejectorders");
    return $this->db->get()->result_array();
  }

  public function deleteRejectorder($id)
  {
    $this->db->from("rejectorders")->where("id", $id)->delete();
  }
}