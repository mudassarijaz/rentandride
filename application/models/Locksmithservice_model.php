<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Locksmithservice_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addLocksmithService($data)
  {
    $this->db->insert("locksmith_services", $data);
    return $this->db->insert_id();
  }

  public function updateLocksmithService($data)
  {
    $this->db->where("id", $data->id)->update("locksmith_services", $data);
    return true;
  }

  public function getLocksmithService($id)
  {
    $this->db->from("locksmith_services");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllLocksmithServices($user_id)
  {
    $select = "locksmith_services.user_id,locksmith_services.service_id,types.id,types.name,types.price";
    $this->db->select($select);
    $this->db->from("locksmith_services");
    $this->db->join("types", "locksmith_services.service_id=types.id", "left");
    $this->db->where("locksmith_services.user_id", $user_id);
    return $this->db->get()->result_array();
  }

  public function deleteLocksmithService($id)
  {
    $this->db->from("locksmith_services")->where("id", $id)->delete();
  }
}