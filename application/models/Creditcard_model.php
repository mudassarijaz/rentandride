<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Creditcard_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addCreditCard($data)
  {
    $this->db->insert("creditcards", $data);
    return $this->db->insert_id();
  }

  public function updateCreditCard($data)
  {
    $this->db->where("id", $data->id)->update("creditcards", $data);
    return true;
  }

  public function getCreditCard($id)
  {
    $this->db->from("creditcards");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllCreditCard()
  {
    $this->db->from("creditcards");
    return $this->db->get()->result_array();
  }

  public function getUserCard($id)
  {
    $this->db->from("creditcards");
    $this->db->where("user_id", $id);
    return $this->db->get()->row();
  }

  public function deleteCreditCard($id)
  {
    $this->db->from("creditcards")->where("id", $id)->delete();
  }
}