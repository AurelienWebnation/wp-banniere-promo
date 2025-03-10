<?php
/**
* Plugin Name: Bannière Promo
* Version: 1.0
* Author: Aurélien Cabiol
**/

function custom_promo_banner_menu() {
    add_menu_page(
        'Bannière Promotionnelle',   // Titre de la page
        'Bannière Promo',            // Nom dans le menu
        'manage_woocommerce',            // Capacité requise
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
        <h1>Bannière Promotionnelle</h1>
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
        'textarea_name' => 'promo_banner_text', // Nom du champ
        'editor_height' => 200, // Hauteur en pixels
        'media_buttons' => true, // Afficher le bouton "Ajouter un média"
        'tinymce'       => true, // Activer TinyMCE
        'quicktags'     => true  // Activer les balises rapides
    );

    wp_editor($value, 'promo_banner_text', $args);
}

function custom_promo_banner_settings() {
    register_setting('promo_banner_options', 'promo_banner_text');

    add_settings_section(
        'promo_banner_section',
        'Texte de la bannière',
        null,
        'promo-banner'
    );

    add_settings_field(
        'promo_banner_text',
        'Texte de la promotion',
        'custom_promo_banner_text_field',
        'promo-banner',
        'promo_banner_section'
    );
}
add_action('admin_init', 'custom_promo_banner_settings');

function promo_banner_shortcode() {
    $text = get_option('promo_banner_text', '');
    
    return wpautop($text);
}
add_shortcode('promo_banner', 'promo_banner_shortcode');

add_filter('option_page_capability_promo_banner_options', function($capability) {
    return 'manage_woocommerce';
});