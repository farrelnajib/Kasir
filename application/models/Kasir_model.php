<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kasir_model extends CI_Model
{

    private $order_table = 'order';
    private $transaction_table = 'transaction';

    public function getAll()
    {
        $this->db->order_by('category_name', 'asc');
        return $this->db->get($this->_table)->result();
    }

    public function getById($id)
    {
        $this->db->where('category_id', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getUnique($column, $term, $id)
    {
        $this->db->where($column, $term);
        $this->db->where('category_id <>', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getCategoryFromMenu($id)
    {
        $this->db->where('category_id', $id);
        return $this->db->get('menu')->result();
    }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('category_id', $id);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id)
    {
        $this->db->where('category_id', $id);
        return $this->db->delete($this->_table);
    }
}
