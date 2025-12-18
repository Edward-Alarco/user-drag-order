<?php

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

    public static function ensure_user_order_column()
    {
        global $wpdb;

        $table = $wpdb->users;
        $column = $wpdb->get_var(
            $wpdb->prepare("SHOW COLUMNS FROM `$table` LIKE %s", 'user_order')
        );

        if ($column) {
            return;
        }

        $wpdb->query("ALTER TABLE `$table` ADD COLUMN `user_order` INT(11) NOT NULL DEFAULT 0");
    }

    public function enqueue_assets($hook)
    {
        if ($hook !== 'users.php') {
            return;
        }

        wp_enqueue_script('jquery-ui-sortable');

        wp_enqueue_script(
            'user-drag-order',
            plugin_dir_url(__FILE__) . '../assets/js/admin-drag-order.js',
            ['jquery', 'jquery-ui-sortable'],
            '1.0.0',
            true
        );

        wp_localize_script('user-drag-order', 'UserDragOrder', [
            'ajax'  => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('user_drag_order_nonce'),
        ]);
    }

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
