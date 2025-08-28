<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserApiGeneratorFormController extends Controller
{
    private $counter = 0; // Initialize counter to keep track of clicks

    public function generateApiScript()
{
    // Generate a random unique number for each request
    $randomNumber = mt_rand(1, 10000); // Ensure a sufficiently large range to avoid collisions
    $randomOption = 'license_activated_' . $randomNumber;

    // Example script with dynamic function names
    $script = <<<EOD
<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Function to check if the plugin is activated
function is_plugin_activated{$randomNumber}() {
    return get_option('{$randomOption}', false);
}

// Get prefilled license data
function get_license_data{$randomNumber}(\$key) {
    return get_option("license_{$randomNumber}_\$key", '');
}

// Add License Validator submenu under Settings
add_action('admin_menu', 'license_validator_menu{$randomNumber}');
function license_validator_menu{$randomNumber}() {
    add_submenu_page(
        'options-general.php', // Parent menu (Settings)
        'License Validator',   // Page title
        'License Validator',   // Menu title
        'manage_options',      // Capability
        'license-validator{$randomNumber}', // Menu slug
        'license_validator_page{$randomNumber}' // Callback function
    );
}

// Display a license activation notification under the plugin
add_filter('plugin_row_meta', 'add_license_activation_notice{$randomNumber}', 10, 2);
function add_license_activation_notice{$randomNumber}(\$plugin_meta, \$plugin_file) {
    if (\$plugin_file === plugin_basename(__FILE__) && !is_plugin_activated{$randomNumber}()) {
        \$plugin_meta[] = '<strong style="color: red;"><a href="' . admin_url('options-general.php?page=license-validator{$randomNumber}') . '" style="color: red;">Please activate your license to enable updates.</a></strong>';
    }
    return \$plugin_meta;
}

// License Validator Page
function license_validator_page{$randomNumber}() {
    \$is_activated = is_plugin_activated{$randomNumber}();
    \$user_email = get_license_data{$randomNumber}('user_email');
    \$product_name = get_license_data{$randomNumber}('product_name');
    \$user_license = get_license_data{$randomNumber}('user_license');
    ?>
    <div class="wrap">
        <h1>License Validator</h1>
        <form id="license-validator-form" method="post">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Email</th>
                    <td><input type="email" id="user_email" name="user_email" value="<?php echo esc_attr(\$user_email); ?>" required <?php echo \$is_activated ? 'readonly' : ''; ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Product Name</th>
                    <td><input type="text" id="product_name" name="product_name" value="<?php echo esc_attr(\$product_name); ?>" required <?php echo \$is_activated ? 'readonly' : ''; ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">License Code</th>
                    <td><input type="text" id="user_license" name="user_license" value="<?php echo esc_attr(\$user_license); ?>" required <?php echo \$is_activated ? 'readonly' : ''; ?> /></td>
                </tr>
            </table>
            <?php if (!\$is_activated): ?>
                <button type="button" id="validate-license" class="button button-primary">Validate License</button>
            <?php else: ?>
                <button type="submit" name="deactivate_license" class="button button-secondary">Deactivate License</button>
            <?php endif; ?>
        </form>
        <div id="license-response" style="margin-top: 20px; font-weight: bold;"></div>
    </div>
    <?php
}

// Handle license deactivation
add_action('admin_init', 'handle_license_deactivation{$randomNumber}');
function handle_license_deactivation{$randomNumber}() {
    if (isset(\$_POST['deactivate_license'])) {
        delete_option('{$randomOption}');
        delete_option('license_{$randomNumber}_user_email');
        delete_option('license_{$randomNumber}_product_name');
        delete_option('license_{$randomNumber}_user_license');
        wp_redirect(admin_url('options-general.php?page=license-validator{$randomNumber}'));
        exit;
    }
}

// JavaScript for License Validation
add_action('admin_footer', 'license_validation_script{$randomNumber}');
function license_validation_script{$randomNumber}() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const validateButton = document.getElementById('validate-license');
            validateButton.addEventListener('click', async function () {
                const userEmail = document.getElementById('user_email').value;
                const productName = document.getElementById('product_name').value;
                const userLicense = document.getElementById('user_license').value;
                const domain = window.location.hostname;

                const responseDiv = document.getElementById('license-response');

                try {
                    const postResponse = await fetch(ajaxurl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            action: 'validate_license{$randomNumber}',
                            user_email: userEmail,
                            product_name: productName,
                            user_license: userLicense,
                            domain: domain,
                            active: 1
                        })
                    });

                    const result = await postResponse.json();
                    responseDiv.textContent = result.message;

                    if (result.success) {
                        responseDiv.style.color = 'green';
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        responseDiv.style.color = 'red';
                    }
                } catch (error) {
                    responseDiv.textContent = 'An error occurred while validating the license.';
                    responseDiv.style.color = 'red';
                }
            });
        });
    </script>
    <?php
}

// AJAX Handler for License Validation
add_action('wp_ajax_validate_license{$randomNumber}', 'handle_license_validation{$randomNumber}');
function handle_license_validation{$randomNumber}() {
    \$user_email = sanitize_email(\$_POST['user_email']);
    \$product_name = sanitize_text_field(\$_POST['product_name']);
    \$user_license = sanitize_text_field(\$_POST['user_license']);
    \$domain = sanitize_text_field(\$_POST['domain']);
    \$active = intval(\$_POST['active']);

    \$post_response = wp_remote_post('https://app.myverilock.com/licenses/validate', [
        'body' => json_encode([
            'user_email' => \$user_email,
            'product_name' => \$product_name,
            'user_license' => \$user_license,
            'domain' => \$domain,
            'active' => \$active
        ]),
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ]);

    if (is_wp_error(\$post_response)) {
        wp_send_json(['success' => false, 'message' => 'Error: Unable to connect to the API.']);
    }

    \$result = json_decode(wp_remote_retrieve_body(\$post_response), true);

    if (isset(\$result['status']) && \$result['status'] === 'success') {
        update_option('{$randomOption}', true);
        wp_send_json(['success' => true, 'message' => 'License validated successfully!']);
    } else {
        wp_send_json(['success' => false, 'message' => \$result['message'] ?? 'Unexpected response from API.']);
    }
}
EOD;

    return response()->json(['success' => true, 'script' => $script]);
}


    public function index(){
        return view('users.apigenerate.apigenerate');
    }
}
