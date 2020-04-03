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

        if (empty($this->session->userdata('id')) || $this->session->userdata('isLoggedIn') != true) {
            $this->session->set_flashdata('danger', 'Please log in first');
            redirect(base_url('login'));
        }
    }


    public function index($id)
    {
        $data['category'] = $this->Category_model->getAll();
        $data['transaction_id'] = $id;
        $data['orders'] = $this->Order_model->getOrders($id);
        $data['subtotal'] = $this->Order_model->getSubtotal($id)[0];
        $data['purchased'] = $this->Order_model->getPurchased($id);
        $data['purchasedArray'] = [];

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
            if ($this->Order_model->insert($data)) {
                $order_id = $this->Order_model->getOrderID($tid, $mid)[0]->order_id;
                $order_data = $this->get_subtotal($tid);

                $order_data["status"] = true;
                $order_data["order_id"] = $order_id;
                echo json_encode($order_data);
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
            $order_data = $this->get_subtotal($tid);
            $order_data["status"] = true;
            echo json_encode($order_data);
        } else {
            echo json_encode([
                "status" => false
            ]);
        }
    }

    public function delete()
    {
        $oid = $this->input->post('order_id');
        $tid = $this->input->post('transaction_id');

        if ($this->Order_model->delete($oid)) {
            $data_order = $this->get_subtotal($tid);
            $data_order["status"] = true;

            echo json_encode($data_order);
        } else {
            echo json_encode([
                "status" => false
            ]);
        }
    }
}
