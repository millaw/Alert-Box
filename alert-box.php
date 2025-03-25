<?php
/**
 * Plugin Name: Alert Box
 * Plugin URI: https://github.com/millaw/alert-box
 * Description: A simple plugin to display alert messages on your WordPress site. This plugin creates a database table to store the alert text and timestamp, and adds a menu page to manage the alert text. The menu page contains a form to update the alert text, which is stored in the database along with a timestamp. The plugin also adds a shortcode [alert_box] that displays the most recent alert text.
 * Version: 1.0
 * Author: Milla Wynn
 * Author URI: https://github.com/millaw
 * License: MIT
 */


// Create the database table for storing the alert text and timestamp
function alert_box_install() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'alert_box';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        text text NOT NULL,
        timestamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'alert_box_install');


// Add the shortcode to display the alert text
function alert_box_shortcode() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'alert_box';
    $query = $wpdb->prepare("SELECT * FROM {$table_name} ORDER BY timestamp DESC LIMIT 1");
    $alert = $wpdb->get_row($query);

    if ($alert) {
        if(strlen($alert->text) > 0)
            return '<div class="alert-box">' . esc_html($alert->text) . '</div>';
    }
}
add_shortcode('alert_box', 'alert_box_shortcode');

// Add the menu page for managing the alert text
function alert_box_menu() {
    add_menu_page(
        'Alert Box Settings',
        'Alert Box',
        'manage_options',
        'alert-box',
        'alert_box_settings_page',
        'dashicons-warning'
    );
}
add_action('admin_menu', 'alert_box_menu');


// Create the settings page for managing the alert text
function alert_box_settings_page() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'alert_box';

    // Handle form submission to update the alert text
    if (isset($_POST['alert_text']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'alert_box_update_alert')) {
        $alert_text = sanitize_text_field($_POST['alert_text']);
        $wpdb->insert($table_name, array('text' => $alert_text, 'timestamp' => current_time('mysql')));
    }

    // Retrieve the current alert text from the database
    $alert = $wpdb->get_row("SELECT * FROM $table_name ORDER BY timestamp DESC LIMIT 1");

    // Display the form to update the alert text
    ?>
    <div class="wrap">
        <h1>Alert Box Settings</h1>
        <form method="post">
            <?php wp_nonce_field('alert_box_update_alert'); ?>
            <label for="alert_text">Alert Text:</label>
            <input type="text" name="alert_text" id="alert_text" value="<?php echo $alert ? esc_attr($alert->text) : ''; ?>" />
            <input type="submit" value="Save" class="button button-primary" />
        </form>
        <div><p>Use the short-code <b>[alert_box]</b> to display this message.</p></div>
    </div>
    <?php
}
