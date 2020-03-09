<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    private $_table = 'menu';

    public function getAll()
    {
        $this->db->join('categories', 'categories.category_id = menu.category_id');
        $this->db->order_by('category_name', 'asc');
        return $this->db->get($this->_table)->result();
    }

    public function getById($id)
    {
        $this->db->where('menu_id', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getByCategory($id)
    {
        $this->db->where('category_id', $id);
        return $this->db->get($this->_table)->result();
    }

    public function getUnique($column, $term, $id)
    {
        $this->db->where($column, $term);
        $this->db->where('menu_id <>', $id);
        return $this->db->get($this->_table)->result();
    }

    // public function getCategoryFromMenu($id)
    // {
    //     $this->db->where('category_id', $id);
    //     return $this->db->get('menu')->result();
    // }

    public function insert($data)
    {
        return $this->db->insert($this->_table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('menu_id', $id);
        return $this->db->update($this->_table, $data);
    }

    public function delete($id, $image)
    {
        $this->db->where('menu_id', $id);
        unlink('./assets/img/' . $image);
        return $this->db->delete($this->_table);
    }
}
