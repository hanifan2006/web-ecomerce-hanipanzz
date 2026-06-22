<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends Shop_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Product_model', 'Order_model'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->require_login();
        $cart = $this->get_cart();
        if (empty($cart['items'])) {
            $this->session->set_flashdata('error', 'Keranjang masih kosong.');
            redirect('shop');
        }

        $this->render('shop/checkout', array(
            'title' => 'Checkout - Nipzz!! Store',
            'cart' => $cart['items'],
            'subtotal' => $cart['total'],
            'shipping' => (float) $this->config->item('shipping_cost'),
            'user' => $this->current_user
        ));
    }

    public function process()
    {
        $this->require_login();
        $cart = $this->get_cart();
        if (empty($cart['items'])) {
            redirect('shop');
        }

        $this->form_validation->set_rules('customer_name', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('phone', 'Telepon', 'required|trim');
        $this->form_validation->set_rules('address', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('city', 'Kota', 'required|trim');
        $this->form_validation->set_rules('payment_method', 'Metode Pembayaran', 'required|in_list[transfer,cod,qris,ewallet]');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
            return;
        }

        foreach ($cart['items'] as $item) {
            $product = $this->Product_model->get($item['id']);
            if (!$product || $product['stock'] < $item['qty']) {
                $this->session->set_flashdata('error', 'Stok ' . $item['name'] . ' tidak mencukupi.');
                redirect('checkout');
            }
        }

        $shipping = (float) $this->config->item('shipping_cost');
        $subtotal = $cart['total'];
        $user = $this->current_user;

        $order_data = array(
            'order_number' => $this->Order_model->generate_order_number(),
            'user_id' => $user['id'],
            'customer_name' => $this->input->post('customer_name', TRUE),
            'email' => $user['email'],
            'phone' => $this->input->post('phone', TRUE),
            'address' => $this->input->post('address', TRUE),
            'city' => $this->input->post('city', TRUE),
            'zip_code' => $this->input->post('zip_code', TRUE),
            'note' => $this->input->post('note', TRUE),
            'payment_method' => $this->input->post('payment_method', TRUE),
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total' => $subtotal + $shipping,
            'status' => 'diproses'
        );

        $items = array();
        foreach ($cart['items'] as $item) {
            $items[] = array(
                'product_id' => $item['id'],
                'product_name' => $item['brand'] . ' ' . $item['name'],
                'qty' => $item['qty'],
                'price' => $item['price']
            );
        }

        $order_id = $this->Order_model->create($order_data, $items);
        if (!$order_id) {
            $this->session->set_flashdata('error', 'Gagal membuat pesanan.');
            redirect('checkout');
        }

        foreach ($cart['items'] as $item) {
            $this->Product_model->decrease_stock($item['id'], $item['qty']);
        }

        $this->session->unset_userdata('cart');
        $order = $this->Order_model->get($order_id);
        $this->render('shop/order_success', array(
            'title' => 'Pesanan Berhasil',
            'order' => $order
        ));
    }

    protected function get_cart()
    {
        $cart_session = $this->session->userdata('cart') ?: array();
        $items = array();
        $total = 0;
        foreach ($cart_session as $item) {
            $p = $this->Product_model->get($item['id']);
            if (!$p) continue;
            $sub = $p['price'] * $item['qty'];
            $items[] = array(
                'id' => $p['id'],
                'brand' => $p['brand'],
                'name' => $p['name'],
                'price' => $p['price'],
                'qty' => $item['qty'],
                'image' => $p['image'],
                'icon' => $p['icon'],
                'subtotal' => $sub
            );
            $total += $sub;
        }
        return array('items' => $items, 'total' => $total);
    }
}
