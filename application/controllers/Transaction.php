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
        $this->load->model('Order_model');
        $this->load->model('Payment_model');
        $this->load->model('Payment_method_model');
        $this->load->model('Menu_model');

        if (empty($this->session->userdata('id')) || $this->session->userdata('isLoggedIn') != true) {
            $this->session->set_flashdata('danger', 'Please log in first');
            redirect(base_url('login'));
        }

        if ($this->uri->segment(1) == 'order' || $this->uri->segment(1) == 'transaction') {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data['transactions'] = $this->Transaction_model->getAll();
        $data['unfinished_transactions'] = $this->Transaction_model->getUnfinished();
        $this->load->view('index', $data);
    }


    public function newTransaction()
    {
        $id = date("ymdHis");
        $date = date("Y-m-d H:i:s");

        $existingID = $this->Transaction_model->getUnique($id);
        if (count($existingID) > 0) {
            sleep(1);
            $this->newTransaction();
        }

        $dataTransaction = [
            'transaction_id' => $id,
            'transaction_total' => 0,
            'transaction_payment' => 0,
            'transaction_change' => 0,
            'transaction_open_bill' => $date
        ];

        if ($this->Transaction_model->insert($dataTransaction)) {
            $smallestPaymentMethod = $this->Payment_method_model->getSmallestId()[0]->method_id;
            $dataPayment = [
                'transaction_id' => $id,
                'method_id' => $smallestPaymentMethod
            ];
            if ($this->Payment_model->insert($dataPayment)) {
                redirect(base_url('order/') . $id);
            }
        }
    }

    public function finishTransaction($id)
    {
        $closeBill = date("Y-m-d H:i:s");

        if ($this->Transaction_model->update($id, ['transaction_close_bill' => $closeBill])) {
            $this->session->set_flashdata('success', 'Success close bill');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('danger', 'Failed close bill');
            redirect(base_url());
        }
    }

    public function delete($id)
    {
        if ($this->Payment_model->deleteTransaction($id)) {
            if ($this->Order_model->deleteTransaction($id)) {
                if ($this->Transaction_model->delete($id)) {
                    $this->session->set_flashdata('success', 'Successfully deleted transaction');
                    redirect(base_url());
                } else {
                    $this->session->set_flashdata('danger', 'Failed delete transaction');
                    redirect(base_url());
                }
            } else {
                $this->session->set_flashdata('danger', 'Failed delete orders');
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('danger', 'Failed delete payments');
            redirect(base_url());
        }
    }
}
