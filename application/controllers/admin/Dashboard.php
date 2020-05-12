<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');

        if (empty($this->session->userdata('id')) || $this->session->userdata('isLoggedIn') != true) {
            $this->session->set_flashdata('danger', 'Please log in first');
            redirect(base_url('admin/login'));
        } else if ($this->session->userdata('role') != 1) {
            $this->session->set_flashdata('danger', 'Your role is not strong enough');
            redirect(base_url('order'));
        }

        $this->load->model('Transaction_model');
        $this->load->model('Menu_model');
        $this->load->model('Order_model');
    }

    public function index()
    {
        $data['todayEarnings'] = $this->Transaction_model->sumDaily()[0]->transaction_total;
        $data['thisMonthEarnings'] = $this->Transaction_model->sumMonthly()[0]->transaction_total;
        $data['totalMenu'] = $this->Menu_model->getTotalMenu();
        $data['totalTransactions'] = $this->Transaction_model->count();
        $this->load->view('admin/dashboard', $data);
    }

    public function topSellings()
    {
        $temp = $this->Order_model->getTopSellings();
        echo json_encode($temp);
    }
}
