<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model
{
    protected $cache;

    public function get_all()
    {
        if ($this->cache !== NULL) {
            return $this->cache;
        }
        $rows = $this->db->get('settings')->result_array();
        $this->cache = array();
        foreach ($rows as $row) {
            $this->cache[$row['setting_key']] = $row['setting_value'];
        }
        return $this->cache;
    }

    public function get($key, $default = '')
    {
        $all = $this->get_all();
        return isset($all[$key]) ? $all[$key] : $default;
    }

    public function set($key, $value)
    {
        $exists = $this->db->get_where('settings', array('setting_key' => $key))->row_array();
        if ($exists) {
            $this->db->where('setting_key', $key)->update('settings', array(
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ));
        } else {
            $this->db->insert('settings', array(
                'setting_key' => $key,
                'setting_value' => $value,
                'updated_at' => date('Y-m-d H:i:s')
            ));
        }
        $this->cache = NULL;
    }

    public function update_batch($data)
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }
}
