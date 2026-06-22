<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log_model extends CI_Model
{
    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('activity_logs', $data);
    }

    public function get_all($limit = 100)
    {
        return $this->db->select('activity_logs.*, users.full_name, users.email')
            ->join('users', 'users.id = activity_logs.user_id', 'left')
            ->order_by('activity_logs.id', 'DESC')
            ->limit($limit)
            ->get('activity_logs')->result_array();
    }
}
