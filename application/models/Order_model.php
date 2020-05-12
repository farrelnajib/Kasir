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

    public function getPurchased($tid)
    {
        $this->db->where('transaction_id', $tid);
        $this->db->select('menu_id');
        return $this->db->get($this->_table)->result();
    }

    public function getSubtotal($tid)
    {
        $this->db->select_sum('order_subtotal');
        $this->db->select('transaction_id');
        $this->db->where('transaction_id', $tid);
        return $this->db->get($this->_table)->result();
    }

    public function getOrderID($tid, $mid)
    {
        $this->db->where('transaction_id', $tid);
        $this->db->where('menu_id', $mid);
        return $this->db->get($this->_table)->result();
    }

    public function getTopSellings()
    {
        $this->db->select_sum('order_quantity', 'total');
        $this->db->select('menu.menu_name');
        $this->db->join('menu', 'menu.menu_id = orders.menu_id');
        $this->db->group_by('orders.menu_id');
        $this->db->order_by('total', 'DESC');
        return $this->db->get($this->_table)->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->_table, $data);
        return true;
    }

    public function update($id, $data)
    {
        $this->db->where('order_id', $id);
        $this->db->update($this->_table, $data);
        return true;
    }

    public function delete($id)
    {
        $this->db->where('order_id', $id);
        $this->db->delete($this->_table);
        return true;
    }

    public function deleteTransaction($id)
    {
        $this->db->where('transaction_id', $id);
        $this->db->delete($this->_table);
        return true;
    }
}
