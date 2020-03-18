<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Category_model');
        $this->load->model('Menu_model');

        if (empty($this->session->userdata('id')) || $this->session->userdata('isLoggedIn') != true) {
            $this->session->set_flashdata('danger', 'Please log in first');
            redirect(base_url('login'));
        }
    }


    public function index()
    {
        $data['category'] = $this->Category_model->getAll();

        $data['menu'] = array();
        foreach ($data['category'] as $category) {
            $temp = $this->Menu_model->getByCategory($category->category_id);
            $data['menu'][$category->category_id] = $temp;
        }

        $this->load->view('index', $data);
    }
}
