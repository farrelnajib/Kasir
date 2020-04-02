<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Transaction_model');
        $this->load->model('Category_model');
        $this->load->model('Menu_model');

        if (empty($this->session->userdata('id')) || $this->session->userdata('isLoggedIn') != true) {
            $this->session->set_flashdata('danger', 'Please log in first');
            redirect(base_url('login'));
        }

        if ($this->uri->segment(1) != '') {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data['transactions'] = $this->Transaction_model->getAll();
        $data['unfinished_transactions'] = $this->Transaction_model->getUnfinished();
        $this->load->view('index', $data);
    }
}
