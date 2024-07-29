<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Content_model extends CI_Model
{
  var $column_content = array("id", "name", "content_order", "description");

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addcontent($data)
  {
    $this->db->insert("contents", $data);
    return $this->db->insert_id();
  }

  public function updatecontent($data)
  {
    $this->db->where("id", $data->id)->update("contents", $data);
    return true;
  }

  public function getcontent($id)
  {
    $this->db->from("contents");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllContents()
  {
    $this->db->from("contents");

    return $this->db->get()->result_array();
  }

  public function deletecontent($id)
  {
    $this->db->from("contents")->where("id", $id)->delete();
  }

  public function getPagesContentforHome($page)
  {
    $this->db->from("contents")->where("page_id", $page)->order_by("content_order", "ASC");
    return $this->db->get()->result_array();
  }

  public function getContentsByPage($page)
  {
    $this->db->from("contents")->where("page_id", $page);

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("name", $_POST["search"]["value"]);
      $this->db->or_like("description", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_content[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else {
      $this->db->order_by("id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function count_all($page)
  {
    $this->db->from("contents");
    $this->db->where("page_id", $page);
    return $this->db->count_all_results();
  }
}