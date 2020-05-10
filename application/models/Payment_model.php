<?php defined('BASEPATH') or exit('No direct script access allowed');

class Payment_model extends CI_Model
{

    private $_table = 'payment';

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }

    public function getLatestId()
    {
        $this->db->select_max('payment_id', 'latest_id');
        return $this->db->get($this->_table)->result();
    }

    public function getByTransactionId($id)
    {
        $this->db->where('transaction_id', $id);
        $this->db->join('payment_method', 'payment.method_id = payment_method.method_id');
        return $this->db->get($this->_table)->result();
    }

    public function getTotalPayment($tid)
    {
        $this->db->where('transaction_id', $tid);
        $this->db->select_sum('payment_amount', 'total');
        return $this->db->get($this->_table)->result();
    }

    public function getUnique($column, $term, $id)
    {
        $this->db->where($column, $term);
        $this->db->where('payment_id <>', $id);
        return $this->db->get($this->_table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('payment_id', $id);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id)
    {
        $this->db->where('payment_id', $id);
        return $this->db->delete($this->_table);
    }

    public function deleteTransaction($id)
    {
        $this->db->where('transaction_id', $id);
        return $this->db->delete($this->_table);
    }
}
