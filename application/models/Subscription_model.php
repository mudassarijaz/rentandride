<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Subscription_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addSubscription($data)
  {
    $this->db->insert("subscriptions", $data);
    return $this->db->insert_id();
  }

  public function updateSubscription($data)
  {
    $this->db->where("id", $data->id)->update("subscriptions", $data);
    return true;
  }

  public function getSubscription($id)
  {
    $this->db->from("subscriptions");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllSubscription($user_id)
  {
    $this->db->from("subscriptions");
    $this->db->where("user_id", $user_id);
    return $this->db->get()->result_array();
  }

  public function getSubscriptionByUser($user_id)
  {
    $this->db->from("subscriptions");
    $this->db->where("user_id", $user_id);
    $this->db->order_by("id", "desc");
    return $this->db->get()->row();
  }

  public function deleteSubscription($id)
  {
    $this->db->from("subscriptions")->where("id", $id)->delete();
  }
}