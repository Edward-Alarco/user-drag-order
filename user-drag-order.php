<?php

/**
 * Plugin Name: User Drag Order
 * Description: Drag & drop ordering for WordPress users using wp_users.user_order
 * Version: 1.0.0
 * Author: Edward Alarco
 */

if (!defined('ABSPATH')) {
    exit;
}

class User_Drag_Order
{

    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_ajax_save_users_order', [$this, 'save_users_order']);
        add_action('admin_head', [$this, 'admin_styles']);
    }

    /**
     * Load scripts only on users.php
     */
    public function enqueue_assets($hook)
    {

        if ($hook !== 'users.php') {
            return;
        }

        wp_enqueue_script('jquery-ui-sortable');

        wp_enqueue_script(
            'user-drag-order',
            plugin_dir_url(__FILE__) . 'assets/js/admin-drag-order.js',
            ['jquery', 'jquery-ui-sortable'],
            '1.0.0',
            true
        );

        wp_localize_script('user-drag-order', 'UserDragOrder', [
            'ajax'  => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('user_drag_order_nonce'),
        ]);
    }

    /**
     * Save new order via AJAX
     */
    public function save_users_order()
    {

        check_ajax_referer('user_drag_order_nonce');

        if (empty($_POST['order']) || !is_array($_POST['order'])) {
            wp_send_json_error('Invalid order');
        }

        global $wpdb;

        $order = array_map('intval', $_POST['order']);
        $position = 1;

        foreach ($order as $user_id) {
            $wpdb->update(
                $wpdb->users,
                ['user_order' => $position],
                ['ID' => $user_id],
                ['%d'],
                ['%d']
            );
            $position++;
        }

        wp_send_json_success();
    }

    /**
     * Small UX improvement
     */
    public function admin_styles()
    {
        $screen = get_current_screen();
        if ($screen && $screen->id === 'users') {
            echo '<style>
                .wp-list-table.users tbody tr {
                    cursor: move;
                }
            </style>';
        }
    }
}

new User_Drag_Order();

add_action('pre_user_query', function ($query) {

    if (
        ! is_admin()
        && isset($query->query_vars['orderby'])
        && $query->query_vars['orderby'] === 'user_order'
    ) {
        global $wpdb;
        $query->query_orderby = "ORDER BY {$wpdb->users}.user_order ASC";
    }
});