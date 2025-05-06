<?php 

if (!class_exists('MV_Slider_Post_Type')) {
    class MV_Slider_Post_Type {
        function __construct() {
            add_action('init', array($this, 'create_post_type'));
        }

        public function create_post_type()
        {
            /**
             * Menu Position:
             * 2 Dashboard
             * 4 Separator
             * 5 Posts
             * 10 Media
             * 15 Links
             * 20 Pages
             * 25 Comments
             * 59 Separator
             * 60 Appearance
             * 65 Plugins
             * 70 Users
             * 75 Tools
             * 80 Settings
             * 99 Separator
             */
            register_post_type(
                post_type: 'mv-slider',
                args: array(
                    'label' => 'Slider',
                    'description' => 'Sliders',
                    'labels' => array(
                        'name' => 'Sliders',
                        'singular_name' => 'Slider'),
                    'public' => true,
                    'supports' => array('title', 'editor', 'thumbnail'/*, 'page-attributes'*/),
                    //'hierarchical' => true, // Permite páginas com hierárquia, necessário 'page-attributes'
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true, // Exibir em novo na barra de admin
                    'show_in_nav_menus' => true, // Permite adicionar ao menu, caso nãoapareçã, habilite em opções de tela
                    'can_export' => true,
                    'has_archive' => false, // Permite listar em uma página os posts
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'show_in_rest' => true, // Permite executar a rest no post, importante para usar o editor de bloco
                    'menu_icon' => 'dashicons-embed-post' // https://developer.wordpress.org/resource/dashicons/
                ),
            );
        }
    }
}
