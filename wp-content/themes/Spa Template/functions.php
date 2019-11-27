<?php
register_nav_menus(array(
    'topMenu' => __('Top Menu', 'theme'),
    'footerMenu' => __('Footer Menu', 'theme'),
));

add_theme_support('menus');

function loadStylesheets(){
    //wp_register_style( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), rand(111,9999), 'all');
    wp_enqueue_style('bootstrap');
    
    //wp_register_style( string $handle, string|bool $src, array $deps = array(), string|bool|null $ver = false, string $media = 'all' )
    wp_register_style('style', get_template_directory_uri() . '/style.css', array(), false, 'all');
    wp_enqueue_style('style');
}
add_action('wp_enqueue_scripts', 'loadStyleSheets');

function loadJquery(){
    wp_deregister_script('jquery');

    wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', '', 1, true);

    add_action('wp_enqueue_scripts', 'jquery');
}
add_action('wp_enqueue_scripts', 'loadJquery');

function loadJs(){
    wp_register_script('jsScript', get_template_directory_uri() . '/js/scripts.js', '', 1, true);
    wp_enqueue_script('jsScript');

    wp_register_script('bootstrapJs', get_template_directory_uri() . '/js/bootstrap.min.js', '', 1, true);
    wp_enqueue_script('bootstrapJs');
}
add_action('wp_enqueue_scripts', 'loadJs');


