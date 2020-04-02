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

        $data['menu'] = array();
        foreach ($data['category'] as $category) {
            $temp = $this->Menu_model->getByCategory($category->category_id);
            $data['menu'][$category->category_id] = $temp;
        }

        $this->load->view('order', $data);
    }

    public function add()
    {
        $data = [
            'transaction_id' => $this->input->post('transaction_id'),
            'menu_id' => $this->input->post('menu_id'),
            'order_quantity' => 1,
            'order_subtotal' => $this->input->post('price')
        ];

        $unique = $this->Order_model->getUnique($data['transaction_id'], $data['menu_id']);

        if (count($unique) == 0) {
            if ($this->Order_model->insert($data)) {
                echo json_encode(["status" => true]);
            }
        } else {
            echo json_encode(["status" => false]);
        }
    }
}
