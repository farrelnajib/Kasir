<?php defined('BASEPATH') or exit('No direct script access allowed');

class Payment_method_model extends CI_Model
{

    private $_table = 'payment_method';

    public function getAll()
    {
        $this->db->order_by('method_name', 'asc');
        return $this->db->get($this->_table)->result();
    }

    public function get()
    {
        $this->db->where('status', 1);
        return $this->db->get($this->_table)->result();
    }

    public function getById($id)
    {
        $this->db->where('method_id', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getSmallestId()
    {
        $this->db->select_min('method_id');
        $this->db->where('status', 1);
        return $this->db->get($this->_table)->result();
    }

    public function getUnique($column, $term, $id)
    {
        $this->db->where($column, $term);
        $this->db->where('method_id <>', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getMethodFromPayment($id)
    {
        $this->db->where('method_id', $id);
        return $this->db->get('payment')->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('method_id', $id);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id)
    {
        $this->db->where('method_id', $id);
        return $this->db->delete($this->_table);
    }
}
