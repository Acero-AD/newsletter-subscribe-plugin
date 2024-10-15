<?php

/**
* Plugin Name: Newsletter Subscribe
* Description: Plugin that allows users to create a newsletter subscription form.
* Version: 0.1
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
      <button type="submit" id="newsletterSubscribeButton">Subscribe</button>
    </form>
    <div id="newsletterSubscribeMessage"></div>
  </div>
  <?php

  return ob_get_clean();
}

add_shortcode('newsletter-subscribe-form', 'subscribe_form');

add_action('admin_menu', 'newsletter_subscribe_plugin_menu');

function newsletter_subscribe_plugin_menu() {
  add_menu_page(
    'Newsletter Plugins Settings',
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
