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

// Autoload simple
require_once plugin_dir_path(__FILE__) . 'includes/class-user-drag-order.php';
require_once plugin_dir_path(__FILE__) . 'includes/user-order-query.php';

// Init
new User_Drag_Order();