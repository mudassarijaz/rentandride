<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Page_model extends CI_Model
{
  var $column_page = array("id", "title", "slug", "description", "section");
  
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addpage($data)
  {
    $this->db->insert("pages", $data);
    return $this->db->insert_id();
  }

  public function updatepage($data)
  {
    $this->db->where("id", $data->id)->update("pages", $data);
    return true;
  }

  public function getpage($id)
  {
    $this->db->from("pages");
    $this->db->where("id", $id);
    return $this->db->get()->row();
  }

  public function getAllPages()
  {
    $this->db->from("pages");

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("title", $_POST["search"]["value"]);
      $this->db->or_like("slug", $_POST["search"]["value"]);
      $this->db->or_like("description", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_page[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
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
    $this->db->from("pages");
    return $this->db->count_all_results();
  }

  public function deletepage($id)
  {
    $this->db->from("pages")->where("id", $id)->delete();
  }

  public function getPageBySlug($slug)
  {
    return $this->db->from("pages")->like("slug", $slug)->get()->row();
  }
}