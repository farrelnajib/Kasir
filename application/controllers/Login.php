<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/login');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->User_model->getEmail($email);

        if ($user) {
            if (password_verify($password, $user->user_password)) {
                $data['id'] = $user->user_id;
                $data['name'] = $user->user_name;
                $data['email'] = $user->user_email;
                $data['role'] = $user->role_id;
                $data['isLoggedIn'] = true;
                $this->session->set_userdata($data);
                redirect(base_url());
            } else {
                $this->session->set_flashdata('danger', 'Wrong password');
                $this->load->view('admin/login');
            }
        } else {
            $this->session->set_flashdata('danger', 'Email is not registered');
            $this->load->view('admin/login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->set_userdata('isLoggedIn', false);

        $this->session->sess_destroy();

        $this->session->set_flashdata('success', 'You have been logged out');
        redirect(base_url('login'));
    }
}
