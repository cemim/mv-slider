<?php 

if (!class_exists('MV_Slider_Post_Type')) {
    class MV_Slider_Post_Type {
        function __construct() {
            add_action('init', array($this, 'create_post_type'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_post'), 10, 2);
            
            // Adiciona coluna para filtrar CPT
            add_filter('manage_mv-slider_posts_columns', array($this, 'mv_slider_cpt_columns')); // Nome segue padrão manager + chave CPT + posts + columns

            // Preenche as colunas com as informações
            add_action('manage_mv-slider_posts_custom_column', array($this, 'mv_slider_custom_columns'), 10, 2); // Padrão: manage + chave CPT + posts + custom + column 

            // Permite ordenar as colunas
            add_filter('manage_edit-mv-slider_sortable_columns', array($this, 'mv_slider_sortable_columns')); // Padrão: manage + edit-chave CPT + sortable + columns
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
                    'label' => esc_html__('Slider', 'mv-slider'),
                    'description' => esc_html__('Sliders', 'mv-slider'),
                    'labels' => array(
                        'name' => esc_html__('Sliders', 'mv-slider'),
                        'singular_name' => esc_html__('Slider', 'mv-slider')),
                    'public' => true,
                    'supports' => array('title', 'editor', 'thumbnail'/*, 'page-attributes'*/),
                    //'hierarchical' => true, // Permite páginas com hierárquia, necessário 'page-attributes'
                    'hierarchical' => false,
                    'show_ui' => true,
                    'show_in_menu' => false,
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

        public function add_meta_boxes()
        {
            add_meta_box(
                'mv_slider_meta_box',
                esc_html__('Link Options', 'mv-slider'),
                array($this, 'add_inner_meta_boxes'),
                'mv-slider', // Chave CPT
                'normal',
                'high'                
            );
        }

        public function add_inner_meta_boxes($post )
        {
            require_once(MV_SLIDER_PATH . 'views/mv-slider_metabox.php');
        }

        public function save_post($post_id)
        {
            // Verificar token nonce
            if (!isset($_POST['mv_slider_nonce']) || !wp_verify_nonce($_POST['mv_slider_nonce'], 'mv_slider_nonce')) {
                return;
            }

            // Evitar auto Save
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            // Verificar se a solicitação veio da Interface do CPT            
            if (!isset($_POST['post_type']) || $_POST['post_type'] !== 'mv-slider') {
                return;
            }

            // Verificar se o usuário pode editar páginas e posts
            if(!current_user_can('edit_page', $post_id) ||  !current_user_can('edit_post', $post_id)) {
                return;
            }

            if (isset($_POST['action']) && $_POST['action'] == 'editpost') {
                $old_link_text = get_post_meta($post_id, 'mv_slider_link_text', true); // mv_slider_link_text name no input
                $new_link_text = sanitize_text_field($_POST['mv_slider_link_text']);
                $old_link_url = get_post_meta($post_id, 'mv_slider_link_url', true);
                $new_link_url = sanitize_text_field($_POST['mv_slider_link_url']);

                if (empty($new_link_text)) {
                    update_post_meta($post_id, 'mv_slider_link_text', esc_html__('Add some text', 'mv-slider'));
                } else {
                    update_post_meta($post_id, 'mv_slider_link_text', $new_link_text, $old_link_text);
                }

                if (empty($new_link_url)) {
                    update_post_meta($post_id, 'mv_slider_link_url', '#');
                } else {
                    update_post_meta($post_id, 'mv_slider_link_url', $new_link_url, $old_link_url);
                }
            }
        }

        public function mv_slider_cpt_columns($columns)
        {
            $columns['mv_slider_link_text'] = esc_html__('Link Text', 'mv-slider');
            $columns['mv_slider_link_url'] = esc_html__('Link URL', 'mv-slider');
            
            return $columns;
        }

        public function mv_slider_custom_columns($column, $post_id)
        {
            switch($column) {
                case 'mv_slider_link_text':
                    echo esc_html(get_post_meta($post_id, 'mv_slider_link_text', true));
                break;
                case 'mv_slider_link_url':
                    echo esc_url(get_post_meta($post_id, 'mv_slider_link_url', true));
                break;
            }
        }

        public function mv_slider_sortable_columns($columns)
        {
            $columns['mv_slider_link_text'] = 'mv_slider_link_text';
            $columns['mv_slider_link_url'] = 'mv_slider_link_url';
            return $columns;
        }


    }
}
