<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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

        $this->load->model('Menu_model');
        $this->load->model('Category_model');

        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $data['menu'] = $this->Menu_model->getAll();
        $this->load->view('admin/menu/index', $data);
    }


    public function select_validate($value)
    {
        if ($value == 0) {
            $this->form_validation->set_message('select_validate', 'Please choose category.');
            return false;
        } else {
            return true;
        }
    }

    public function check_picture()
    {
        if (empty($_FILES['menu_image']['name'])) {
            $this->form_validation->set_message('check_picture', 'Please select an image file');
            return false;
        } else {
            return true;
        }
    }

    private function image_compress($upload_data)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/' . $upload_data["file_name"];
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = true;
        $config['quality'] = '60%';
        $config['width'] = 500;
        $config['new_image'] = './assets/img/' . $upload_data["file_name"];

        $this->load->library('image_lib', $config);
    }


    public function add()
    {
        $data['categories'] = $this->Category_model->getAll();
        $config['upload_path'] = './assets/img/';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload');
        $this->upload->initialize($config);

        $this->form_validation->set_rules('name', 'name', 'trim|required|is_unique[menu.menu_name]');
        $this->form_validation->set_rules('price', 'price', 'trim|required');
        $this->form_validation->set_rules('discount', 'discount', 'trim|numeric');
        $this->form_validation->set_rules('final-price', 'final price', 'trim|required');
        $this->form_validation->set_rules('category', 'category', 'callback_select_validate');
        $this->form_validation->set_rules('menu_image', 'Image', 'callback_check_picture');
        $this->form_validation->set_message('required', 'Please fill the %s');
        $this->form_validation->set_message('is_unique', 'Invalid because %s is already used');
        $this->form_validation->set_message('greater_than', 'Price can\'t be negative');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/menu/_form', $data);
        } else {
            $img = '';

            if (empty($_FILES['menu_image']['name'])) {
                $this->session->set_flashdata('danger', 'Please upload a file');
                $this->load->view('admin/menu/_form', $data);
            } else {
                if (!$this->upload->do_upload('menu_image')) {
                    $data['error'] = $this->upload->display_errors();
                    $this->session->set_flashdata('danger', $data['error']);
                    $this->load->view('admin/menu/_form', $data);
                } else {
                    $upload_data = $this->upload->data();

                    $this->image_compress($upload_data);

                    if (!$this->image_lib->resize()) {
                        $data['error'] = $this->image_lib->display_errors();
                        $this->session->set_flashdata('danger', $data['error']);
                        $this->load->view('admin/menu/_form', $data);
                    } else {
                        $img = $upload_data['file_name'];
                        $data = [
                            'menu_name' => $this->input->post('name'),
                            'menu_price' => $this->parse_number($this->input->post('price')),
                            'menu_discount' => $this->input->post('discount'),
                            'menu_final_price' => $this->parse_number($this->input->post('final-price')),
                            'category_id' => $this->input->post('category'),
                            'menu_picture' => $img,
                            'status' => $this->input->post('status')
                        ];

                        if ($this->Menu_model->insert($data)) {
                            $this->session->set_flashdata('success', 'Successfully saved menu');
                            redirect(base_url('admin/menu'));
                        } else {
                            $this->session->set_flashdata('danger', 'Failed to save menu');
                            $this->load->view('admin/menu/_form', $data);
                        }
                    }
                }
            }
        }
    }


    public function check_name($name)
    {
        $id = $this->input->post('id');
        $name = $this->Menu_model->getUnique('menu_name', $name, $id);

        if (count($name) == 0) {
            return true;
        } else {
            $this->form_validation->set_message('check_name', 'Invalid name because it\'s already used');
            return false;
        }
    }

    public function check_edit_picture()
    {
        if (!empty($_FILES['menu_image']['name']) && !$this->upload->do_upload('menu_image')) {
            $this->form_validation->set_message('check_edit_picture', $this->upload->display_errors());
            return false;
        } else {
            return true;
        }
    }

    private function parse_number($number, $dec_point = null)
    {
        if (empty($dec_point)) {
            $locale = localeconv();
            $dec_point = $locale['decimal_point'];
        }
        return floatval(str_replace($dec_point, '.', preg_replace('/[^\d' . preg_quote($dec_point) . ']/', '', $number)));
    }


    public function details($id)
    {
        if (!isset($id)) show_404();

        $data['menu'] = $this->Menu_model->getById($id);
        $data['categories'] = $this->Category_model->getAll();
        if ($data['menu'] == null) show_404();

        $config['upload_path'] = './assets/img/';
        $config['allowed_types'] = 'gif|png|jpg|jpeg';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $this->form_validation->set_rules('name', 'Name', 'required|callback_check_name');
        $this->form_validation->set_rules('price', 'price', 'required');
        $this->form_validation->set_rules('discount', 'discount', 'trim|numeric');
        $this->form_validation->set_rules('final-price', 'final price', 'trim');
        $this->form_validation->set_rules('category', 'category', 'callback_select_validate');
        $this->form_validation->set_rules('menu_image', 'Image', 'callback_check_edit_picture');
        $this->form_validation->set_message('required', 'Please fill the %s');
        $this->form_validation->set_message('greater_than', 'Price can\'t be negative');

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/menu/_form', $data);
        } else {
            $dataUpdate = [
                'menu_name' => $this->input->post('name'),
                'menu_price' => $this->parse_number($this->input->post('price')),
                'menu_discount' => $this->input->post('discount'),
                'menu_final_price' => $this->parse_number($this->input->post('final-price')),
                'category_id' => $this->input->post('category'),
                'status' => $this->input->post('status')
            ];

            if (!empty($_FILES['menu_image']['name'])) {
                unlink('./assets/img/' . $data['menu'][0]->menu_picture);
                $upload_data = $this->upload->data();

                $this->image_compress($upload_data);

                if (!$this->image_lib->resize()) {
                    $data['error'] = $this->image_lib->display_errors();
                    $this->session->set_flashdata('danger', $data['error']);
                    $this->load->view('admin/menu/_form', $data);
                } else {
                    $img = $upload_data['file_name'];
                    $dataUpdate['menu_picture'] = $img;
                }
            }
            $this->Menu_model->update($id, $dataUpdate);
            $this->session->set_flashdata('success', 'Success edit menu data');
            redirect(base_url('admin/menu'));
        }
    }

    public function delete($id)
    {
        if (!isset($id)) show_404();

        $menu = $this->Menu_model->getById($id);
        if (count($menu) > 0) {
            if ($this->Menu_model->delete($id, $menu[0]->menu_picture)) {
                $this->session->set_flashdata('success', 'Menu has been deleted');
                redirect(base_url('admin/menu'));
            } else {
                $this->session->set_flashdata('danger', 'Failed to delete menu');
                redirect(base_url('admin/menu'));
            }
        } else {
            $this->session->set_flashdata('danger', 'Menu not found');
            redirect(base_url('admin/menu'));
        }
    }
}
