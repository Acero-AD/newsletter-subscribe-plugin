<?php

/**
* Plugin Name: Newsletter Subscribe
* Description: Plugin that allows users to create a newsletter subscription form.
* Version: 0.1.1
* Author: Diego Acero (Somosbytes)
* Author URI: http://www.somosbytes.es
*/

if (!defined('ABSPATH')) {
	exit;
}

function subscribe_form() {
  ob_start();

  ?>
  <div id="newsletterSubscribeContainer">
    <form id="newsletterSubscribeForm">
      <input type="email" id="newsletterSubscriptionEmail" name="email" placeholder="Email" required>
      <button type="button" id="newsletterSubscribeButton">Subscribe</button>
    </form>
    <div id="newsletterSubscribeMessage"></div>
  </div>
  <?php

  return ob_get_clean();
}

add_shortcode('NSP-form', 'subscribe_form');

add_action('admin_menu', 'newsletter_subscribe_plugin_menu');

function newsletter_subscribe_plugin_menu() {
  add_menu_page(
    'NSP plugin Settings',
    'Newsletter Settings',
    'manage_options',
    'newsletter-subscribe-settings',
    'newsletter_subscribe_plugin_page'
  );
}

function newsletter_subscribe_plugin_page() {
  ?>
    <div class="wrap">
        <h1>Configuración de Suscripción a Beehiiv</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('newsletter-subscribe-settings-group');
            do_settings_sections('newsletter-subscribe-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">URL de la API de Beehiiv</th>
                    <td><input type="text" name="provider_api_url" value="<?php echo esc_attr(get_option('provider_api_url')); ?>" style="width: 100%;"/></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Clave API de Beehiiv</th>
                    <td><input type="text" name="provider_api_key" value="<?php echo esc_attr(get_option('provider_api_key')); ?>" style="width: 100%;"/></td>
                </tr>
                <tr valign="top">
                    <th scope="row">CSS Personalizado</th>
                    <td><textarea name="form_custom_css" style="width: 100%; height: 150px;"><?php echo esc_attr(get_option('form_custom_css')); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'newsletter_subscribe_register_settings');

function newsletter_subscribe_register_settings() {
  register_setting('newsletter-subscribe-settings-group', 'provider_api_url');
  register_setting('newsletter-subscribe-settings-group', 'provider_api_key');
  register_setting('newsletter-subscribe-settings-group', 'form_custom_css');
}

function nsp_enqueue_scripts() {
    wp_enqueue_script('NSP-subscribe-script', plugins_url('/js/newsletter-form.js', __FILE__), array(), null, true);
    wp_localize_script('NSP-subscribe-script', 'form_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('newsletter-subscribe-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'nsp_enqueue_scripts');

function subscribe_newsletter() {
  check_ajax_referer('newsletter-subscribe-nonce', 'nonce');

  $email = sanitize_email($_POST['email']);
  
  if (!is_email($email)) {
    wp_send_json_error(array('message' => 'Invalid Email'));
  }

  $api_key = get_option('provider_api_key');
  $api_url = get_option('provider_api_url');

  if (!$api_key || !$api_url) {
    wp_send_json_error(array('message' => 'Missing provider API Key or URL'));
  }

  $response = wp_remote_post($api_url, array(
    'headers' => array(
      'Content-Type' => 'application/json',
      'Authorization' => 'Bearer ' . $api_key
    ),
    'body' => json_encode(array('email' => $email))
  ));

  if (is_wp_error($response)) {
    wp_send_json_error(array('message' => 'Error connecting to provider API'));
  }
 
  $body = wp_remote_retrieve_body($response);
  $result = json_decode($body, true);

  $response_code = wp_remote_retrieve_response_code($response);
  if ($response_code === 200 || $response_code === 201) {
        wp_send_json_success(array('message' => '¡Suscripción exitosa!'));
  } else {
        wp_send_json_error(array('message' => 'Error al suscribirse.'));
  }
}

add_action('wp_ajax_subscribe_newsletter', 'subscribe_newsletter');
add_action('wp_ajax_nopriv_subscribe_newsletter', 'subscribe_newsletter');

function form_custom_css() {
  $custom_css = get_option('form_custom_css');

  if (!empty($custom_css)) {
    echo '<style type=text/css>' . $custom_css . '</style>';
  }
}
add_action('wp_head', 'form_custom_css');
