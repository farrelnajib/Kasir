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
        $this->load->model('Payment_model');
        $this->load->model('Menu_model');
        $this->load->model('Order_model');
    }

    public function index()
    {
        $data['todayEarnings'] = $this->Transaction_model->sumDaily()[0]->transaction_total;
        $data['thisMonthEarnings'] = $this->Transaction_model->sumMonthly()[0]->transaction_total;
        $data['totalMenu'] = $this->Menu_model->getTotalMenu();
        $data['totalTransactions'] = $this->Transaction_model->count();
        $data['transactions'] = $this->Transaction_model->getAll();
        $this->load->view('admin/dashboard', $data);
    }

    public function topSellings()
    {
        $temp = $this->Order_model->getTopSellings();
        echo json_encode($temp);
    }

    public function salesPerMonth()
    {
        $result = array();
        for ($i = 12; $i >= 0; $i--) {
            $thisMonth = $this->Transaction_model->getMonthTransaction($i)[0];
            if ($thisMonth->total == null) {
                $thisMonth->total = 0;
            }

            $thisMonth->month = date('m') - $i;
            if ($thisMonth->month <= 0) {
                $thisMonth->month += 12;
            }

            $thisMonth->month = DateTime::createFromFormat('!m', $thisMonth->month)->format('M');

            $result[] = $thisMonth;
        }

        echo json_encode($result);
    }

    public function invoice($id)
    {
        $data['transaction'] = $this->Transaction_model->getById($id)[0];
        $data['orders'] = $this->Order_model->getOrders($id);
        $data['payments'] = $this->Payment_model->getByTransactionId($id);

        $data['transaction']->transaction_subtotal = $this->Order_model->getSubtotal($id)[0]->order_subtotal;
        $data['transaction']->transaction_tax = $data['transaction']->transaction_subtotal * 0.1;
        $data['transaction']->transaction_open_bill = date("l, d F Y H:i:s", strtotime($data['transaction']->transaction_open_bill));
        $data['transaction']->transaction_close_bill = date("l, d F Y H:i:s", strtotime($data['transaction']->transaction_close_bill));
        echo json_encode($data);
    }
}
