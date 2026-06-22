<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Product_model', 'Category_model'));
        $this->load->library(array('form_validation', 'upload'));
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $this->require_permission('products.manage');
        $this->render('admin/products/index', array(
            'title' => 'Manajemen Produk',
            'products' => $this->Product_model->get_admin_list(array(
                'search' => $this->input->get('q', TRUE)
            )),
            'categories' => $this->Category_model->get_all()
        ));
    }

    public function create()
    {
        $this->require_permission('products.manage');
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('brand', 'Merek', 'required|trim');
            $this->form_validation->set_rules('name', 'Nama Produk', 'required|trim');
            $this->form_validation->set_rules('category_id', 'Kategori', 'required|integer');
            $this->form_validation->set_rules('price', 'Harga', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('stock', 'Stok', 'required|integer');
            if ($this->form_validation->run() !== FALSE) {
                $id = $this->Product_model->create($this->collect_product_data());
                $this->log_activity('product.create', 'Menambah produk ID ' . $id);
                $this->session->set_flashdata('success', 'Produk berhasil ditambahkan.');
                redirect('admin/products');
            }
        }
        $this->render('admin/products/form', array(
            'title' => 'Tambah Produk',
            'product' => NULL,
            'categories' => $this->Category_model->get_all()
        ));
    }

    public function edit($id)
    {
        $this->require_permission('products.manage');
        $product = $this->Product_model->get((int) $id);
        if (!$product) show_404();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('brand', 'Merek', 'required|trim');
            $this->form_validation->set_rules('name', 'Nama Produk', 'required|trim');
            $this->form_validation->set_rules('category_id', 'Kategori', 'required|integer');
            $this->form_validation->set_rules('price', 'Harga', 'required|numeric|greater_than[0]');
            $this->form_validation->set_rules('stock', 'Stok', 'required|integer');
            if ($this->form_validation->run() !== FALSE) {
                $this->Product_model->update($id, $this->collect_product_data());
                $this->log_activity('product.update', 'Mengubah produk ID ' . $id);
                $this->session->set_flashdata('success', 'Produk berhasil diperbarui.');
                redirect('admin/products');
            }
        }
        $this->render('admin/products/form', array(
            'title' => 'Edit Produk',
            'product' => $product,
            'categories' => $this->Category_model->get_all()
        ));
    }

    public function delete($id)
    {
        $this->require_permission('products.manage');
        $this->Product_model->delete((int) $id);
        $this->log_activity('product.delete', 'Menghapus produk ID ' . $id);
        $this->session->set_flashdata('success', 'Produk berhasil dihapus.');
        redirect('admin/products');
    }

    public function export_excel()
    {
        $this->require_permission('products.manage');
        $products = $this->Product_model->get_admin_list();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=produk_' . date('Ymd') . '.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, array('ID', 'Merek', 'Nama', 'Kategori', 'Harga', 'Stok', 'Terjual', 'Rating'));
        foreach ($products as $p) {
            fputcsv($out, array($p['id'], $p['brand'], $p['name'], $p['category_name'], $p['price'], $p['stock'], $p['sold'], $p['rating']));
        }
        fclose($out);
        exit;
    }

    protected function collect_product_data()
    {
        $specs_raw = $this->input->post('specs', TRUE);
        $specs = $specs_raw ? array_map('trim', explode(',', $specs_raw)) : array();
        $data = array(
            'brand' => $this->input->post('brand', TRUE),
            'name' => $this->input->post('name', TRUE),
            'slug' => url_title($this->input->post('brand', TRUE) . '-' . $this->input->post('name', TRUE), '-', TRUE),
            'category_id' => (int) $this->input->post('category_id'),
            'price' => $this->input->post('price'),
            'old_price' => $this->input->post('old_price') ?: NULL,
            'stock' => (int) $this->input->post('stock'),
            'badge' => $this->input->post('badge', TRUE) ?: 'Baru',
            'rating' => $this->input->post('rating') ?: 4.0,
            'icon' => $this->input->post('icon', TRUE) ?: '💻',
            'image' => $this->input->post('image', TRUE),
            'specs' => $specs,
            'is_active' => $this->input->post('is_active') ? 1 : 0
        );

        if (!empty($_FILES['image_file']['name'])) {
            $config = array(
                'upload_path' => FCPATH . 'uploads/products/',
                'allowed_types' => 'gif|jpg|jpeg|png|webp',
                'max_size' => 2048,
                'encrypt_name' => TRUE
            );
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image_file')) {
                $upload = $this->upload->data();
                $data['image'] = base_url('uploads/products/' . $upload['file_name']);
            }
        }
        return $data;
    }
}
