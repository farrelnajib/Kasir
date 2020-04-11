<?php defined('BASEPATH') or exit('No direct script access allowed');

class Methods extends CI_Controller
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

        $this->load->model('Payment_method_model');
    }

    public function index()
    {
        $data['methods'] = $this->Payment_method_model->getAll();
        $this->load->view('admin/methods/index', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'name', 'required|is_unique[payment_method.method_name]');
        $this->form_validation->set_message('required', 'Please fill the %s');
        $this->form_validation->set_message('is_unique', 'Invalid because %s is already used');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/methods/_form');
        } else {
            $data = [
                'method_name' => $this->input->post('name'),
                'status' => $this->input->post('status')
            ];

            if ($this->Payment_method_model->insert($data)) {
                $this->session->set_flashdata('success', 'Successfully saved payment method');
                redirect(base_url('admin/methods'));
            } else {
                $this->session->set_flashdata('danger', 'Failed to save payment method');
                $this->load->view('admin/methods/_form');
            }
        }
    }


    public function check_name($name)
    {
        $id = $this->input->post('id');
        $name = $this->Payment_method_model->getUnique('method_name', $name, $id);

        if (count($name) == 0) {
            return true;
        } else {
            $this->form_validation->set_message('check_name', 'Invalid name because it\'s already used');
            return false;
        }
    }


    public function details($id)
    {
        if (!isset($id)) show_404();

        $data['method'] = $this->Payment_method_model->getById($id);
        if ($data['method'] == null) show_404();

        $this->form_validation->set_rules('name', 'Name', 'required|callback_check_name');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/methods/_form', $data);
        } else {
            $dataUpdate = [
                'method_name' => $this->input->post('name'),
                'status' => $this->input->post('status')
            ];
            $this->Payment_method_model->update($id, $dataUpdate);
            $this->session->set_flashdata('success', 'Success edit payment method data');
            redirect(base_url('admin/methods'));
        }
    }

    public function delete($id)
    {
        if (!isset($id)) show_404();

        $method = $this->Payment_method_model->getById($id);
        $payment = $this->Payment_method_model->getMethodFromPayment($id);
        if (count($payment) > 0) {
            $this->session->set_flashdata('danger', 'Can\'t delete because ' . $method[0]->method_name . ' has been used in payment');
            redirect(base_url('admin/methods'));
        } else if (count($method) > 0) {
            if ($this->Payment_method_model->delete($id)) {
                $this->session->set_flashdata('success', 'Payment method has been deleted');
                redirect(base_url('admin/methods'));
            } else {
                $this->session->set_flashdata('danger', 'Failed to delete payment method');
                redirect(base_url('admin/methods'));
            }
        } else {
            $this->session->set_flashdata('danger', 'Payment method not found');
            redirect(base_url('admin/methods'));
        }
    }
}
