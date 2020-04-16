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
        $this->load->model('Order_model');
        $this->load->model('Transaction_model');
        $this->load->model('Payment_model');
        $this->load->model('Payment_method_model');

        if (empty($this->session->userdata('id')) || $this->session->userdata('isLoggedIn') != true) {
            $this->session->set_flashdata('danger', 'Please log in first');
            redirect(base_url('login'));
        }
    }


    public function index($id)
    {
        if (count($this->Transaction_model->getById($id)) == 0) {
            $this->session->set_flashdata('danger', 'Transaction not found');
            redirect(base_url());
        }
        $data['category'] = $this->Category_model->getAll();
        $data['transaction_id'] = $id;
        $data['orders'] = $this->Order_model->getOrders($id);
        $data['purchased'] = $this->Order_model->getPurchased($id);
        $data['transaction'] = $this->Transaction_model->getById($id);
        $data['payments'] = $this->Payment_model->getByTransactionId($id);
        $data['totalPayments'] = $this->Payment_model->getTotalPayment($id)[0];
        if ($data['totalPayments']->total == null) {
            $data['totalPayments']->total = 0;
        }
        $data['methods'] = $this->Payment_method_model->get();
        $data['purchasedArray'] = [];
        $data['totals'] = $this->get_subtotal($id);

        foreach ($data['purchased'] as $purchased) {
            array_push($data['purchasedArray'], $purchased->menu_id);
        }

        $data['menu'] = array();
        foreach ($data['category'] as $category) {
            $temp = $this->Menu_model->getByCategory($category->category_id, $id);
            $data['menu'][$category->category_id] = $temp;
        }

        $this->load->view('order', $data);
    }

    private function get_subtotal($tid)
    {
        $subtotal = $this->Order_model->getSubtotal($tid)[0]->order_subtotal;
        if ($subtotal == null) {
            $subtotal = 0;
        }
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        $this->Transaction_model->update($tid, ['transaction_total' => $total]);

        $data = [
            "subtotal" => $subtotal,
            "tax" => $tax,
            "total" => $total
        ];

        return $data;
    }

    private function addTotal($tid)
    {
        $total = $this->get_subtotal($tid)["total"];

        return $this->Transaction_model->update($tid, ['transaction_total' => $total]);
    }

    public function add()
    {
        $data = [
            'transaction_id' => $this->input->post('transaction_id'),
            'menu_id' => $this->input->post('menu_id'),
            'order_quantity' => 1,
            'order_subtotal' => $this->input->post('price')
        ];

        $tid = $data['transaction_id'];
        $mid = $data['menu_id'];

        $unique = $this->Order_model->getUnique($tid, $mid);

        if (count($unique) == 0) {
            if ($this->Order_model->insert($data) && $this->addTotal($tid)) {
                $order_id = $this->Order_model->getOrderID($tid, $mid)[0]->order_id;

                echo json_encode([
                    "status" => true,
                    "order_id" => $order_id
                ]);
            } else {
                echo json_encode(["status" => false]);
            }
        } else {
            echo json_encode(["status" => false]);
        }
    }

    public function edit()
    {
        $oid = $this->input->post('order_id');
        $tid = $this->input->post('transaction_id');
        $qty = $this->input->post('amount');

        $data = [
            'order_quantity' => $qty,
            'order_subtotal' => $this->input->post('price') * $qty
        ];

        if ($this->Order_model->update($oid, $data)) {
            if ($this->addTotal($tid)) {
                echo json_encode(["status" => true]);
            } else {
                echo json_encode(["status" => false]);
            }
        } else {
            echo json_encode(["status" => false]);
        }
    }

    public function delete()
    {
        $oid = $this->input->post('order_id');
        $tid = $this->input->post('transaction_id');

        if ($this->Order_model->delete($oid)) {
            if ($this->addTotal($tid)) {
                $data_order = $this->get_subtotal($tid);
                $data_order["status"] = true;

                echo json_encode($data_order);
            } else {
                echo json_encode([
                    "status" => false
                ]);
            }
        } else {
            echo json_encode([
                "status" => false
            ]);
        }
    }

    private function saveCustomer($tid, $data, $column)
    {
        if ($this->Transaction_model->insertCustomer($tid, [$column => $data])) {
            echo json_encode([
                "status" => true
            ]);
        } else {
            echo json_encode([
                "status" => false
            ]);
        }
    }

    public function saveName()
    {
        $name = $this->input->post('name');
        $tid = $this->input->post('transaction_id');

        $this->saveCustomer($tid, $name, 'customer_name');
    }

    public function savePhone()
    {
        $tid = $this->input->post('transaction_id');
        $phone = $this->input->post('phone');
        $column = 'customer_email';
        if (is_numeric($phone)) {
            $column = 'customer_phone';
            $this->Transaction_model->insertCustomer($tid, ['customer_email' => '']);
        } else {
            $this->Transaction_model->insertCustomer($tid, ['customer_phone' => '']);
        }

        $this->saveCustomer($tid, $phone, $column);
    }

    public function addPayment()
    {
        $tid = $this->input->post('transaction_id');
        $payment_id = $this->Payment_model->getLatestId();
        if (count($payment_id) == 0) {
            $payment_id = 0;
        } else {
            $payment_id = $payment_id[0]->latest_id;
        }
        $payment_id += 1;
        $data = [
            'payment_id' => $payment_id,
            'transaction_id' => $tid,
            'method_id' => 1
        ];

        if ($this->Payment_model->insert($data)) {
            echo json_encode([
                "status" => true,
                "payment_id" => $payment_id
            ]);
        } else {
            echo json_encode(["status" => false]);
        }
    }

    public function removePayment()
    {
        $pid = $this->input->post('payment_id');

        if ($this->Payment_model->delete($pid)) {
            echo json_encode(["status" => true]);
        } else {
            echo json_encode(["status" => false]);
        }
    }

    public function changePaymentMethod()
    {
        $pid = $this->input->post('payment_id');
        $method = $this->input->post('method');

        if ($this->Payment_model->update($pid, ['method_id' => $method])) {
            echo json_encode(["status" => true]);
        } else {
            echo json_encode(["status" => false]);
        }
    }

    public function changePaymentAmount()
    {
        $pid = $this->input->post('payment_id');
        $tid = $this->input->post('transaction_id');
        $payment = $this->input->post('payment');
        $totalPayment = $this->input->post('total_payment');
        $changes = $this->input->post('changes');

        $data = [
            'transaction_payment' => $totalPayment,
            'transaction_change' => $changes
        ];

        if ($this->Payment_model->update($pid, ['payment_amount' => $payment]) && $this->Transaction_model->update($tid, $data)) {
            echo json_encode(["status" => true]);
        } else {
            echo json_encode(["status" => false]);
        }
    }
}
