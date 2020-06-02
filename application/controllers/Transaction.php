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

		if ($this->uri->segment(1) == 'order' || ($this->uri->segment(1) == 'transaction' && $this->uri->segment(2) == '')) {
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
		$id = date("YmdHis");
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
			if ($this->invoice($id)) {
				$this->session->set_flashdata('success', 'Success close bill');
				redirect(base_url());
			} else {
				$this->session->set_flashdata('danger', 'Failed to send bill');
				redirect(base_url());
			}
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

	public function invoice($id)
	{
		$data['transaction'] = $this->Transaction_model->getById($id)[0];
		$data['orders'] = $this->Order_model->getOrders($id);
		$data['payments'] = $this->Payment_model->getByTransactionId($id);

		$data['transaction']->transaction_subtotal = $this->Order_model->getSubtotal($id)[0]->order_subtotal;
		$data['transaction']->transaction_tax = $data['transaction']->transaction_subtotal * 0.1;
		$data['transaction']->transaction_open_bill = date("l, d F Y H:i:s", strtotime($data['transaction']->transaction_open_bill));
		$data['transaction']->transaction_close_bill = date("l, d F Y H:i:s", strtotime($data['transaction']->transaction_close_bill));

		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'mail.smtp2go.com',
			'smtp_port' => 2525,
			'smtp_user' => 'waroenkabnormal',
			'smtp_pass' => 'anshary08',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n",
		];
		$this->load->library('email');
		$this->email->initialize($config);

		$this->email->from('farrel.anshary@binus.ac.id', 'Waroenk Abnormal');
		$this->email->to($data['transaction']->customer_email);
		$this->email->subject('Your E-receipt for transaction ' . $id);
		$this->email->message($this->load->view('Invoice', $data, true));

		if ($this->email->send()) {
			if ($this->input->get('method') == 'resend') {
				echo json_encode(['status' => true]);
			} else {
				return true;
			}
		} else {
			if ($this->input->get('method') == 'resend') {
				echo json_encode(['status' => false]);
			} else {
				return false;
			}
		}
	}
}
