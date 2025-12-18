<?php

/**
 * Plugin Name: User Drag Order
 * Description: Drag & drop ordering for WordPress users using wp_users.user_order
 * Version: 1.0.0
 * Author: Edward Alarco
 * Author URI: https://edward-alarco.github.io/edwardalarco/
 * License: GPL v2 or later
 */

if (!defined('ABSPATH')) exit;

define('UDO_PLUGIN_FILE', __FILE__);
define('UDO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('UDO_PLUGIN_URL', plugin_dir_url(__FILE__));

// Includes
require_once UDO_PLUGIN_DIR . 'includes/plugin-links.php';
require_once UDO_PLUGIN_DIR . 'includes/class-user-drag-order.php';
require_once UDO_PLUGIN_DIR . 'includes/user-order-query.php';

// On activation: ensure column exists
register_activation_hook(__FILE__, function () {
    User_Drag_Order::ensure_user_order_column();
});

// Init
new User_Drag_Order();