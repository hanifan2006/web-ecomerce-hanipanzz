<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->where('is_active', 1)->order_by('name')->get('categories')->result_array();
    }

    public function get_by_slug($slug)
    {
        return $this->db->get_where('categories', array('slug' => $slug))->row_array();
    }

    public function get($id)
    {
        return $this->db->get_where('categories', array('id' => (int) $id))->row_array();
    }
}
