<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('User_model');

        if (empty($this->session->userdata('id')) || $this->session->userdata('isLoggedIn') != true) {
            $this->session->set_flashdata('danger', 'Please log in first');
            redirect(base_url('admin/login'));
        } else if ($this->session->userdata('role') != 1) {
            $this->session->set_flashdata('danger', 'Your role is not strong enough');
            redirect(base_url('order'));
        }
    }
    public function index()
    {
        $data['users'] = $this->User_model->getAll();
        $this->load->view('admin/user/index', $data);
    }

    public function select_validate($value)
    {
        if ($value == null || $value == 0) {
            $this->form_validation->set_message('select_validate', 'Please choose one');
            return false;
        } else {
            return true;
        }
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[user.user_name]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[user.user_email]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|callback_select_validate');
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|matches[password2]|min_length[6]');
        $this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password1]');

        $this->form_validation->set_message('required', 'Please fill the %s.');
        $this->form_validation->set_message('is_unique', 'Invalid %s because it\'s already used.');
        $this->form_validation->set_message('min_length', '%s too short.');
        $this->form_validation->set_message('matches', '%s don\'t match.');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/user/_form');
        } else {
            $dataRegister = [
                'user_name' => htmlspecialchars($this->input->post('name')),
                'user_email' => htmlspecialchars($this->input->post('email')),
                'user_password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role'),
            ];
            $this->User_model->insert($dataRegister);

            $this->session->set_flashdata('success', "Successfully add user");
            redirect(base_url('admin/user'));
        }
    }

    public function check_name($name)
    {
        $id = $this->input->post('id');
        $users = $this->User_model->getUnique('user_name', $name, $id);

        if (count($users) > 0) {
            $this->form_validation->set_message('check_name', 'Invalid %s because it\'s already used.');
            return false;
        } else {
            return true;
        }
    }

    public function check_email($email)
    {
        $id = $this->input->post('id');
        $users = $this->User_model->getUnique('user_email', $email, $id);

        if (count($users) > 0) {
            $this->form_validation->set_message('check_email', 'Invalid %s because it\'s already used.');
            return false;
        } else {
            return true;
        }
    }

    public function details($id)
    {
        if (empty($id) || $this->User_model->getById($id) == null) {
            show_404();
        }

        $this->form_validation->set_rules('name', 'Name', 'trim|required|callback_check_name');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|callback_select_validate');
        $this->form_validation->set_rules('password1', 'Password', 'trim|matches[password2]|min_length[6]');
        $this->form_validation->set_rules('password2', 'Password', 'trim|matches[password1]');

        $this->form_validation->set_message('required', 'Please fill the %s.');
        $this->form_validation->set_message('is_unique', 'Invalid %s because it\'s already used.');
        $this->form_validation->set_message('min_length', '%s too short.');
        $this->form_validation->set_message('matches', '%s don\'t match.');

        $data['user'] = $this->User_model->getById($id);

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/user/_form', $data);
        } else {
            $dataEdit = [
                'user_name' => htmlspecialchars($this->input->post('name')),
                'user_email' => htmlspecialchars($this->input->post('email')),
                'role_id' => $this->input->post('role'),
            ];

            $password = $this->input->post('password1');
            if (!empty($password) && trim($password) != '') {
                $dataEdit['user_password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($this->User_model->update($id, $dataEdit)) {
                $this->session->set_flashdata('success', 'Successfully edit user');
                redirect(base_url('admin/user'));
            } else {
                $this->session->set_flashdata('danger', 'Failed to edit user');
                redirect(base_url('admin/user/details') . $id);
            }
        }
    }

    public function delete($id)
    {
        if (empty($id) || $this->User_model->getById($id) == null) {
            show_404();
        }

        $user = $this->User_model->getById($id);
        if (count($user) > 0) {
            if ($this->User_model->delete($id)) {
                $this->session->set_flashdata('success', 'User successfully deleted');
                redirect(base_url('admin/user'));
            } else {
                $this->session->set_flashdata('danger', 'Failed to delete user');
                redirect(base_url('admin/user'));
            }
        } else {
            $this->session->set_flashdata('danger', 'User not found');
            redirect(base_url('admin/user'));
        }
    }
}
