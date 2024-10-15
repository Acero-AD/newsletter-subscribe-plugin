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
