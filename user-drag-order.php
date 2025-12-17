<?php
/**
 * Plugin Name: User Drag Order
 * Plugin URI: https://github.com/Edward-Alarco/user-drag-order
 * Description: Drag & drop ordering for WordPress users using wp_users.user_order
 * Version: 1.0.0
 * Author: Edward Alarco
 * Author URI: https://edward-alarco.github.io/edwardalarco/
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) {
    exit;
}

// Autoload simple
require_once plugin_dir_path(__FILE__) . 'includes/class-user-drag-order.php';
require_once plugin_dir_path(__FILE__) . 'includes/user-order-query.php';
require_once plugin_dir_path(__FILE__) . 'includes/plugin-links.php';

// Init
new User_Drag_Order();