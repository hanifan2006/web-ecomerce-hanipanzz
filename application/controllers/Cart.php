<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Shop_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index()
    {
        $cart = $this->get_cart_details();
        $this->render('shop/cart', array(
            'title' => 'Keranjang - Nipzz!! Store',
            'cart' => $cart['items'],
            'total' => $cart['total']
        ));
    }

    public function add()
    {
        $id = (int) $this->input->post('product_id');
        $qty = max(1, (int) $this->input->post('qty'));
        $product = $this->Product_model->get($id);

        if (!$product || $product['stock'] < 1) {
            $this->json_response(FALSE, 'Stok habis.');
        }

        $cart = $this->session->userdata('cart') ?: array();
        $found = FALSE;
        foreach ($cart as &$item) {
            if ($item['id'] == $id) {
                $new_qty = $item['qty'] + $qty;
                if ($new_qty > $product['stock']) {
                    $this->json_response(FALSE, 'Stok tidak mencukupi.');
                }
                $item['qty'] = $new_qty;
                $found = TRUE;
                break;
            }
        }
        if (!$found) {
            if ($qty > $product['stock']) {
                $this->json_response(FALSE, 'Stok tidak mencukupi.');
            }
            $cart[] = array('id' => $id, 'qty' => $qty);
        }
        $this->session->set_userdata('cart', $cart);
        $this->json_response(TRUE, 'Produk ditambahkan ke keranjang.', array('count' => $this->cart_count()));
    }

    public function update()
    {
        $id = (int) $this->input->post('product_id');
        $qty = (int) $this->input->post('qty');
        $product = $this->Product_model->get($id);
        $cart = $this->session->userdata('cart') ?: array();

        foreach ($cart as $k => &$item) {
            if ($item['id'] == $id) {
                if ($qty <= 0) {
                    unset($cart[$k]);
                    $cart = array_values($cart);
                } else {
                    if ($product && $qty > $product['stock']) {
                        $this->json_response(FALSE, 'Stok tidak mencukupi.');
                    }
                    $item['qty'] = $qty;
                }
                break;
            }
        }
        $this->session->set_userdata('cart', $cart);
        $details = $this->get_cart_details();
        $this->json_response(TRUE, 'Keranjang diperbarui.', array(
            'count' => $this->cart_count(),
            'total' => $details['total']
        ));
    }

    public function remove($id)
    {
        $cart = $this->session->userdata('cart') ?: array();
        $cart = array_values(array_filter($cart, function ($item) use ($id) {
            return $item['id'] != (int) $id;
        }));
        $this->session->set_userdata('cart', $cart);
        if ($this->input->is_ajax_request()) {
            $this->json_response(TRUE, 'Item dihapus.');
        }
        redirect('cart');
    }

    protected function get_cart_details()
    {
        $cart = $this->session->userdata('cart') ?: array();
        $items = array();
        $total = 0;
        foreach ($cart as $item) {
            $p = $this->Product_model->get($item['id']);
            if (!$p) continue;
            $sub = $p['price'] * $item['qty'];
            $items[] = array(
                'id' => $p['id'],
                'brand' => $p['brand'],
                'name' => $p['name'],
                'price' => $p['price'],
                'qty' => $item['qty'],
                'stock' => $p['stock'],
                'image' => $p['image'],
                'icon' => $p['icon'],
                'subtotal' => $sub
            );
            $total += $sub;
        }
        return array('items' => $items, 'total' => $total);
    }

    protected function json_response($success, $message, $extra = array())
    {
        $this->output->set_content_type('application/json')
            ->set_output(json_encode(array_merge(array('success' => $success, 'message' => $message), $extra)));
    }
}
