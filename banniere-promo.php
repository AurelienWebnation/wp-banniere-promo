<?php
/**
 * Plugin Name: Bannière Promo
 * Version: 1.2
 * Author: Aurélien Cabiol
 **/

function custom_promo_banner_menu() {
    add_menu_page(
        'Bannière Promotionnelle',   // Titre de la page
        'Bannière Promo',            // Nom dans le menu
        'manage_woocommerce',        // Capacité requise
        'promo-banner',              // Slug de la page
        'custom_promo_banner_page',  // Fonction d'affichage
        'dashicons-megaphone',       // Icône
        20                           // Position
    );
}
add_action('admin_menu', 'custom_promo_banner_menu');

function custom_promo_banner_page() {
    ?>
    <div class="wrap">
        <h1>Bannière Promotionnelle & Popup</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('promo_banner_options');
            do_settings_sections('promo-banner');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function custom_promo_banner_text_field() {
    $value = get_option('promo_banner_text', '');

    $args = array(
        'textarea_name' => 'promo_banner_text',
        'editor_height' => 200,
        'media_buttons' => true,
        'tinymce'       => true,
        'quicktags'     => true
    );

    wp_editor($value, 'promo_banner_text', $args);
}

function custom_popup_title_field() {
    $value = get_option('promo_popup_title', '');
    echo '<input type="text" name="promo_popup_title" value="' . esc_attr($value) . '" class="regular-text">';
}

function custom_popup_text_field() {
    $value = get_option('promo_popup_text', '');

    $args = array(
        'textarea_name' => 'promo_popup_text',
        'editor_height' => 200,
        'media_buttons' => true,
        'tinymce'       => true,
        'quicktags'     => true
    );

    wp_editor($value, 'promo_popup_text', $args);
}

function custom_promo_banner_settings() {
    register_setting('promo_banner_options', 'promo_banner_text');
    register_setting('promo_banner_options', 'promo_popup_text');
    register_setting('promo_banner_options', 'promo_popup_title');

    add_settings_section(
        'promo_banner_section',
        'Bannière promotionnelle',
        null,
        'promo-banner'
    );

    add_settings_field(
        'promo_banner_text',
        'Texte de la bannière',
        'custom_promo_banner_text_field',
        'promo-banner',
        'promo_banner_section'
    );

    add_settings_section(
        'promo_popup_section',
        'Popup promotionnelle',
        null,
        'promo-banner'
    );

    add_settings_field(
        'promo_popup_title',
        'Titre de la popup',
        'custom_popup_title_field',
        'promo-banner',
        'promo_popup_section'
    );

    add_settings_field(
        'promo_popup_text',
        'Texte de la popup',
        'custom_popup_text_field',
        'promo-banner',
        'promo_popup_section'
    );
}
add_action('admin_init', 'custom_promo_banner_settings');

function promo_banner_shortcode() {
    $text = get_option('promo_banner_text', '');
    return wpautop($text);
}
add_shortcode('promo_banner', 'promo_banner_shortcode');

function promo_popup_shortcode() {
    $text = get_option('promo_popup_text', '');
    return wpautop($text);
}
add_shortcode('promo_popup', 'promo_popup_shortcode');

function promo_popup_title_shortcode() {
    $title = get_option('promo_popup_title', '');
    return esc_html($title);
}
add_shortcode('promo_popup_title', 'promo_popup_title_shortcode');

add_filter('option_page_capability_promo_banner_options', function($capability) {
    return 'manage_woocommerce';
});
