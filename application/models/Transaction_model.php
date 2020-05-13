<?php defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_model extends CI_Model
{

    private $_table = 'transaction';

    public function getAll()
    {
        $this->db->where('transaction_close_bill !=', NULL);
        $this->db->order_by('transaction_id', 'DESC');
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

    public function sumMonthly()
    {
        $this->db->select_sum('transaction_total');
        $this->db->where('MONTH(transaction_close_bill)', date('m'));
        $this->db->where('YEAR(transaction_close_bill)', date('Y'));
        return $this->db->get($this->_table)->result();
    }

    public function sumDaily()
    {
        $this->db->select_sum('transaction_total');
        $this->db->where('DATE(transaction_close_bill)', date('Y-m-d'));
        return $this->db->get($this->_table)->result();
    }

    public function count()
    {
        $this->db->where('MONTH(transaction_close_bill)', date('m'));
        $this->db->where('YEAR(transaction_close_bill)', date('Y'));
        return $this->db->count_all_results($this->_table);
    }

    public function getMonthTransaction($monthInterval)
    {
        // $this->db->select_sum('transaction_total', 'total');
        // $this->db->where('YEAR(transaction_close_bill)', "YEAR(CURRENT_DATE - INTERVAL 0 MONTH)");
        // $this->db->where('MONTH(transaction_close_bill)', "MONTH(CURRENT_DATE - INTERVAL 0 MONTH)");
        // return $this->db->get($this->_table)->result();

        $query = $this->db->query('
            SELECT SUM(`transaction_total`) AS total FROM `transaction`
            WHERE YEAR(`transaction_close_bill`) = YEAR(CURRENT_DATE - INTERVAL ' . $monthInterval . ' MONTH)
            AND MONTH(`transaction_close_bill`) = MONTH(CURRENT_DATE - INTERVAL ' . $monthInterval . ' MONTH)
        ');
        return $query->result();
    }

    public function getUnique($id)
    {
        $this->db->where('transaction_id', $id);
        return $this->db->get($this->_table)->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function insertCustomer($tid, $data)
    {
        $this->db->where('transaction_id', $tid);
        $this->db->update($this->_table, $data);
        return true;
    }

    public function update($id, $data)
    {
        $this->db->where('transaction_id', $id);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id)
    {
        $this->db->where('transaction_id', $id);
        return $this->db->delete($this->_table);
    }
}
