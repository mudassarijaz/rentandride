<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Service_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addService($data)
  {
    $this->db->insert("services", $data);
    return $this->db->insert_id();
  }

  public function updateService($data)
  {
    $this->db->where("id", $data->id)->update("services", $data);
    return true;
  }

  public function getService($id)
  {
    $this->db->from("services");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllServices()
  {
    $this->db->from("services");
    return $this->db->get()->result_array();
  }

  public function deleteService($id)
  {
    $this->db->from("services")->where("id", $id)->delete();
  }
}