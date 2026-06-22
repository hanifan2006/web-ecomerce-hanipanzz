<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_rupiah')) {
    function format_rupiah($amount)
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }
}

if (!function_exists('order_status_badge')) {
    function order_status_badge($status)
    {
        $map = array(
            'diproses' => 'badge-amber',
            'dikirim' => 'badge-blue',
            'selesai' => 'badge-green',
            'dibatalkan' => 'badge-red'
        );
        $class = isset($map[$status]) ? $map[$status] : 'badge-gray';
        return '<span class="badge ' . $class . '">' . html_escape($status) . '</span>';
    }
}

if (!function_exists('payment_label')) {
    function payment_label($method)
    {
        $labels = array(
            'transfer' => 'Transfer Bank',
            'cod' => 'Bayar di Tempat (COD)',
            'qris' => 'QRIS',
            'ewallet' => 'E-Wallet'
        );
        return isset($labels[$method]) ? $labels[$method] : $method;
    }
}

if (!function_exists('flash_messages')) {
    function flash_messages()
    {
        $CI =& get_instance();
        $types = array('success', 'error', 'info', 'warning');
        $html = '';
        foreach ($types as $type) {
            $msg = $CI->session->flashdata($type);
            if ($msg) {
                $alert = $type === 'error' ? 'danger' : $type;
                $html .= '<div class="alert alert-' . $alert . ' alert-dismissible fade show" role="alert">'
                    . html_escape($msg)
                    . '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>';
            }
        }
        return $html;
    }
}
