<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends Shop_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Product_model', 'Category_model', 'Order_model', 'User_model'));
        $this->load->library(array('form_validation', 'upload'));
        $this->load->helper('form');
    }

    public function index()
    {
        $filters = array(
            'search' => $this->input->get('q', TRUE),
            'category' => $this->input->get('cat', TRUE) ?: '',
            'sort' => $this->input->get('sort', TRUE) ?: 'default'
        );
        if ($filters['category'] === 'all') {
            $filters['category'] = '';
        }

        $this->render('shop/index', array(
            'title' => 'Semua Laptop - NipzzStore!!',
            'products' => $this->Product_model->get_all($filters),
            'categories' => $this->Category_model->get_all(),
            'filters' => $filters,
            'product_count' => $this->Product_model->count_all(),
            'customer_count' => $this->User_model->count_by_role('user')
        ));
    }

    public function product($id)
    {
        $product = $this->Product_model->get((int) $id);
        if (!$product) {
            show_404();
        }
        $this->render('shop/detail', array(
            'title' => $product['name'] . ' - NipzzStore!!',
            'product' => $product
        ));
    }

    public function promo()
    {
        $this->render('shop/promo', array(
            'title' => 'Promo - NipzzStore!!',
            'products' => $this->Product_model->get_all(array('promo' => TRUE))
        ));
    }

    public function orders()
    {
        $this->require_login();
        $user = $this->current_user;
        $this->render('shop/orders', array(
            'title' => 'Pesanan Saya - NipzzStore!!',
            'orders' => $this->Order_model->get_all(array('user_id' => $user['id']))
        ));
    }

    public function account()
    {
        $this->render_account('profile', 'Profil Saya - NipzzStore!!', 'profile');
    }

    public function account_edit()
    {
        $this->render_account('edit', 'Edit Profil - NipzzStore!!', 'edit');
    }

    public function account_update()
    {
        $this->require_login();
        if ($this->current_user['role_slug'] !== 'user') {
            redirect('admin/dashboard');
        }

        $user_id = (int) $this->current_user['id'];

        $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('phone', 'Telepon', 'trim');
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password Baru', 'min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');
        }

        if ($this->form_validation->run() === FALSE) {
            return $this->render_account('edit', 'Edit Profil - NipzzStore!!', 'edit');
        }

        $data = array(
            'full_name' => $this->input->post('full_name', TRUE),
            'phone' => $this->input->post('phone', TRUE)
        );
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }

        if (!empty($_FILES['avatar']['name'])) {
            $upload_path = FCPATH . 'uploads/avatars/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $config = array(
                'upload_path' => $upload_path,
                'allowed_types' => 'gif|jpg|jpeg|png',
                'max_size' => 2048,
                'file_name' => 'avatar_' . $user_id . '_' . time(),
                'overwrite' => FALSE,
            );

            $this->upload->initialize($config);
            if (!$this->upload->do_upload('avatar')) {
                return $this->render_account('edit', 'Edit Profil - NipzzStore!!', 'edit', array(
                    'upload_error' => $this->upload->display_errors('', ''),
                ));
            }

            $upload_data = $this->upload->data();
            $new_avatar = 'uploads/avatars/' . $upload_data['file_name'];
            if (!empty($this->current_user['avatar']) && strpos($this->current_user['avatar'], 'uploads/avatars/') === 0) {
                $old_avatar_path = FCPATH . $this->current_user['avatar'];
                if (is_file($old_avatar_path)) {
                    @unlink($old_avatar_path);
                }
            }
            $data['avatar'] = $new_avatar;
        }

        $this->User_model->update($user_id, $data);
        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        redirect('akun/edit-profil');
    }

    protected function render_account($inner_view, $title, $active_tab, $extra = array())
    {
        $ctx = array_merge($this->get_account_data(), $extra);
        $ctx['title'] = $title;
        $ctx['active_tab'] = $active_tab;
        $ctx['account_content'] = $this->load->view('shop/account/' . $inner_view, $ctx, TRUE);
        $this->render('shop/account/wrapper', $ctx);
    }

    protected function get_account_data()
    {
        $this->require_login();
        if ($this->current_user['role_slug'] !== 'user') {
            redirect('admin/dashboard');
        }

        $user = $this->User_model->get_with_role($this->current_user['id']);
        if (!$user) {
            $this->session->set_flashdata('error', 'Data akun tidak ditemukan.');
            redirect('shop');
        }

        $orders = $this->Order_model->get_all(array('user_id' => $user['id']));
        $total_spent = 0;
        foreach ($orders as $o) {
            if ($o['status'] !== 'dibatalkan') {
                $total_spent += (float) $o['total'];
            }
        }

        return array(
            'user' => $user,
            'order_count' => count($orders),
            'completed_count' => count(array_filter($orders, function ($o) {
                return $o['status'] === 'selesai';
            })),
            'total_spent' => $total_spent,
            'recent_orders' => array_slice($orders, 0, 3)
        );
    }
}
