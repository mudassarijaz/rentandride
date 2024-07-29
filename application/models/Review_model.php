<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Review_model extends CI_Model
{
  var $column_review = array(null, "u1.name", "u2.name", "rnr_reviews.review", "rnr_reviews.rating", "rnr_reviews.creation_date");
  var $column_review2 = array(null, "u2.name", "rnr_reviews.review", "rnr_reviews.rating", "rnr_reviews.creation_date");
  var $column_search = array("locksmith_id", "user_id", "amount", "status");
  var $review = array("id" => "asc");

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function addreview($data)
  {
    $this->db->insert("rnr_reviews", $data);
    return $this->db->insert_id();
  }

  public function updatereview($data)
  {
    $this->db->where("id", $data->id)->update("rnr_reviews", $data);
    return true;
  }

  public function get_review($id)
  {
   $select = "rnr_reviews.id,rnr_reviews.user_id,rnr_reviews.review,rnr_reviews.rating,rnr_reviews.order_id,rnr_reviews.creation_date,u2.name as customer_name";
    $this->db->select($select);
    $this->db->from("rnr_reviews");
    //$this->db->join("rnr_users u1", "rnr_reviews.locksmith_id=u1.id", "left");
    $this->db->join("rnr_users u2", "rnr_reviews.user_id=u2.id", "left");
    $this->db->where("rnr_reviews.id", $id);
    return $this->db->get()->row();
  }

  public function getLocksmithReviews($user_id)
  {
    $select = "rnr_reviews.id,rnr_reviews.user_id,rnr_reviews.locksmith_id,rnr_reviews.review,rnr_reviews.rating,rnr_reviews.order_id,rnr_reviews.creation_date,u2.name as customer_name";
    $this->db->select($select);
    $this->db->from("rnr_reviews");
    $this->db->join("rnr_users u2", "rnr_reviews.user_id=u2.id", "left");
    $this->db->where("rnr_reviews.locksmith_id", $user_id);

    $i = 0;
    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("rnr_reviews.review", $_POST["search"]["value"]);
      $this->db->or_like("u2.name", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_review2[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else {
      $this->db->order_by("rnr_reviews.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function getReviewsofLocksmith($user_id)
  {
    $select = "rnr_reviews.id,rnr_reviews.user_id,rnr_reviews.locksmith_id,rnr_reviews.review,rnr_reviews.rating,rnr_reviews.posted_by,rnr_reviews.creation_date,u2.name as customer_name";
    $this->db->select($select);
    $this->db->from("rnr_reviews");
    $this->db->join("rnr_users u2", "rnr_reviews.user_id=u2.id", "left");
    $this->db->where("rnr_reviews.locksmith_id", $user_id);
    $this->db->where("rnr_reviews.posted_by !=", $user_id);
    $this->db->where("rnr_reviews.creation_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $this->db->order_by("rnr_reviews.id", "desc");
    return $this->db->get()->result_array();
  }

  public function getNewReviews()
  {
    $select = "rnr_reviews.id,rnr_reviews.user_id,rnr_reviews.locksmith_id,rnr_reviews.rating,rnr_reviews.creation_date,rnr_reviews.posted_by,u1.name as locksmith_name,u2.name as customer_name";
    $this->db->select($select);
    $this->db->from("rnr_reviews");
    $this->db->join("rnr_users u1", "rnr_reviews.locksmith_id=u1.id", "left");
    $this->db->join("rnr_users u2", "rnr_reviews.user_id=u2.id", "left");
    $this->db->where("rnr_reviews.creation_date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()");
    $this->db->order_by("rnr_reviews.id", "desc");
    return $this->db->get()->result_array();
  }

  public function getAllReviews()
  {
    $select = "rnr_reviews.id,rnr_reviews.user_id,rnr_reviews.review,rnr_reviews.rating,rnr_reviews.order_id,rnr_reviews.creation_date,rnr_reviews.posted_by,u2.name as customer_name";
    $this->db->select($select);
    $this->db->from("rnr_reviews");
    //$this->db->join("rnr_users u1", "rnr_reviews.locksmith_id=u1.id", "left");
    $this->db->join("rnr_users u2", "rnr_reviews.user_id=u2.id", "left");

    if ( !empty( $_POST["search"]["value"] ) ) {
      $this->db->like("u1.name", $_POST["search"]["value"]);
      $this->db->or_like("u2.name", $_POST["search"]["value"]);
      $this->db->or_like("rnr_reviews.review", $_POST["search"]["value"]);
    }

    if( isset( $_POST["order"] ) ) {
      $this->db->order_by($this->column_review[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
    } else {
      $this->db->order_by("rnr_reviews.id", "desc");
    }

    if( isset( $_POST["length"] ) && $_POST["length"] != -1) {
      $this->db->limit($_POST["length"], $_POST["start"]);
    }

    return $this->db->get()->result_array();
  }

  public function count_all($id)
  {
    $this->db->from("rnr_reviews");
    $this->db->where("locksmith_id", $id);
    return $this->db->count_all_results();
  }

  public function count_for_all()
  {
    $this->db->from("rnr_reviews");
    return $this->db->count_all_results();
  }

  public function deletereview($id)
  {
    $this->db->from("rnr_reviews")->where("id", $id)->delete();
  }
}