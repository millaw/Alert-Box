# Alert Box Plugin for WordPress

A simple WordPress plugin to display alert messages on your website. This plugin allows you to store alert text in a database and manage it through a dedicated admin page. The alert text is displayed on your site via a simple shortcode.

## Features

- **Store Alert Text**: The plugin creates a database table to store alert messages with timestamps.
- **Shortcode**: Use the `[alert_box]` shortcode to display the most recent alert message.
- **Admin Settings**: Manage the alert text from the WordPress admin dashboard.
- **Secure**: Protects against SQL injection and CSRF attacks.

## Installation

### 1. Download the Plugin
- Download the plugin from the [GitHub repository](https://github.com/millaw/alert-box).

### 2. Upload the Plugin to WordPress
- Upload the `alert-box` plugin folder to the `/wp-content/plugins/` directory of your WordPress installation.

### 3. Activate the Plugin
- Go to the WordPress Admin Dashboard.
- Navigate to **Plugins > Installed Plugins**.
- Find **Alert Box** in the plugin list and click **Activate**.

## Usage

### Display Alert
To display the most recent alert message on any page or post, use the following shortcode:
[alert_box]

### Admin Settings
- After activation, go to the WordPress admin menu and click on **Alert Box**.
- Use the form to update the alert message.
- The most recent alert will be displayed on the front end wherever you have added the shortcode.

## Security
- The plugin uses `wp_nonce_field` for CSRF protection in the admin form.
- It uses `$wpdb->prepare()` and `$wpdb->insert()` to securely interact with the database and prevent SQL injection.

## License

MIT License. See [LICENSE](LICENSE) for more details.

## Author

Milla Wynn  
[GitHub Profile](https://github.com/millaw)

## Contributing

Feel free to fork the repository and submit pull requests if you have any improvements or bug fixes.

## Changelog

### 1.0
- Initial release of the plugin.
