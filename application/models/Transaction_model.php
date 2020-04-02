<?php defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{

    private $_table = 'transaction';

    public function getAll()
    {
        $this->db->where('transaction_close_bill !=', NULL);
        return $this->db->get($this->_table)->result();
    }

    public function getUnfinished()
    {
        $this->db->where('transaction_close_bill', NULL);
        return $this->db->get($this->_table)->result();
    }

    public function getById($id)
    {
        $this->db->where('transaction_id', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getUnique($column, $term, $id)
    {
        $this->db->where($column, $term);
        $this->db->where('transaction_id <>', $id);
        return $this->db->get($this->_table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('transaction_id', $id);
        return $this->db->update($this->_table, $data);
    }
}
