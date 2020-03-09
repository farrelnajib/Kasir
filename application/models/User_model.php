<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    private $_table = 'user';

    public function getAll()
    {
        $this->db->order_by('user_name', 'asc');
        return $this->db->get($this->_table)->result();
    }

    public function getById($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getUnique($column, $term, $id)
    {
        $this->db->where($column, $term);
        $this->db->where('user_id <>', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getEmail($email)
    {
        $this->db->where('user_email', $email);
        return $this->db->get($this->_table)->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('user_id', $id);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->delete($this->_table);
    }
}
