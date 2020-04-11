<?php defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends CI_Controller
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

        $this->load->model('Category_model');
    }

    public function index()
    {
        $data['categories'] = $this->Category_model->getAll();
        $this->load->view('admin/categories/index', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'name', 'required|is_unique[categories.category_name]');
        $this->form_validation->set_message('required', 'Please fill the %s');
        $this->form_validation->set_message('is_unique', 'Invalid because %s is already used');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/categories/_form');
        } else {
            $name = $this->input->post('name');
            $data = ['category_name' => $name];

            if ($this->Category_model->insert($data)) {
                $this->session->set_flashdata('success', 'Successfully saved category');
                redirect(base_url('admin/categories'));
            } else {
                $this->session->set_flashdata('danger', 'Failed to save category');
                $this->load->view('admin/categories/_form');
            }
        }
    }


    public function check_name($name)
    {
        $id = $this->input->post('id');
        $name = $this->Category_model->getUnique('category_name', $name, $id);

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

        $data['category'] = $this->Category_model->getById($id);
        if ($data['category'] == null) show_404();

        $this->form_validation->set_rules('name', 'Name', 'required|callback_check_name');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/categories/_form', $data);
        } else {
            $dataUpdate = ['category_name' => $this->input->post('name')];
            $this->Category_model->update($id, $dataUpdate);
            $this->session->set_flashdata('success', 'Success edit category data');
            redirect(base_url('admin/categories'));
        }
    }

    public function delete($id)
    {
        if (!isset($id)) show_404();

        $category = $this->Category_model->getById($id);
        $menu = $this->Category_model->getCategoryFromMenu($id);
        if (count($menu) > 0) {
            $this->session->set_flashdata('danger', 'Can\'t delete because ' . $category[0]->category_name . ' has been used in menu');
            redirect(base_url('admin/categories'));
        } else if (count($category) > 0) {
            if ($this->Category_model->delete($id)) {
                $this->session->set_flashdata('success', 'Category has been deleted');
                redirect(base_url('admin/categories'));
            } else {
                $this->session->set_flashdata('danger', 'Failed to delete category');
                redirect(base_url('admin/categories'));
            }
        } else {
            $this->session->set_flashdata('danger', 'Category not found');
            redirect(base_url('admin/categories'));
        }
    }
}
