<?php defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{
    private $_table = 'orders';

    public function getOrders($tid)
    {
        $this->db->where('transaction_id', $tid);
        $this->db->join('menu', 'menu.menu_id = orders.menu_id');
        return $this->db->get($this->_table)->result();
    }

    public function getUnique($tid, $mid)
    {
        $this->db->where('menu_id', $mid);
        $this->db->where('transaction_id', $tid);
        return $this->db->get($this->_table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }
}
