<?php

if (! class_exists('MV_Slider_Settings')) {
    class MV_Slider_Settings
    {
        public static $options;

        public function __construct()
        {
            self::$options = get_option('mv_slider_options');
            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init()
        {
            register_setting('mv_slider_group', 'mv_slider_options', array($this, 'mv_slider_validate'));
            // Criar uma sessão de configuração
            add_settings_section(
                'mv_slider_main_section',
                'How does it work?',
                null,
                'mv_slider_page1'
            );

            add_settings_section(
                'mv_slider_secound_section',
                'Other plugin Options',
                null,
                'mv_slider_page2'
            );

            // Criar uma campo dentro da sessão
            add_settings_field(
                'mv_slider_shortcode',
                'Shortcode',
                array($this, 'mv_slider_shortcode_callback'),
                'mv_slider_page1',
                'mv_slider_main_section'
            );

            add_settings_field(
                'mv_slider_title',
                'Slider Title',
                array($this, 'mv_slider_title_callback'),
                'mv_slider_page2',
                'mv_slider_secound_section',
                array(
                    'label_for' => 'mv_slider_title'
                )
            );

            add_settings_field(
                'mv_slider_bullets',
                'Display Bullets',
                array($this, 'mv_slider_bullets_callback'),
                'mv_slider_page2',
                'mv_slider_secound_section',
                array(
                    'label_for' => 'mv_slider_bullets'
                )
            );

            add_settings_field(
                'mv_slider_style',
                'Slider Style',
                array($this, 'mv_slider_style_callback'),
                'mv_slider_page2',
                'mv_slider_secound_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'mv_slider_style'
                )
            );
        }

        public function mv_slider_shortcode_callback()
        {
            echo "<span>Use the shortcode [mv_slider] to display the slider in any page/post/widget</span>";
        }

        public function mv_slider_title_callback($args)
        {
           $opt = esc_attr(self::$options['mv_slider_title']) ?? '';

            echo "<input type=\"text\"
                name=\"mv_slider_options[mv_slider_title]\"
                id=\"mv_slider_title\"
                value=\"$opt\">";
        
        }

        public function mv_slider_bullets_callback($args)
        {
            $ck = isset(self::$options['mv_slider_bullets']) ? checked("1", self::$options['mv_slider_bullets'], false) : '';
                
            echo "<input type=\"checkbox\"
                name=\"mv_slider_options[mv_slider_bullets]\"
                id=\"mv_slider_bullets\"
                value=\"1\" $ck>
            <label for=\"mv_slider_bullets\">Whether to display Bullets or not</label>";

        }

        public function mv_slider_style_callback($args)
        {           
            $opt = '';
            foreach($args['items'] as $item ){
                // Verifica se os campos foram selecionados
                $select = isset(self::$options['mv_slider_style']) ? selected($item, self::$options['mv_slider_style'], false) : '';
                
                $itemAtt = esc_attr($item);
                $itemHtml = esc_html(ucfirst($item));
                $opt .= "<option value=\"$itemAtt\" $select>$itemHtml</option>";
            }

            echo "<select id=\"mv_slider_style\" name=\"mv_slider_options[mv_slider_style]\">";
            echo $opt;
            echo "</select>";
        }

        public function mv_slider_validate($input)
        {
            $new_input = array();
            
            foreach($input as $key => $value){
                switch ($key) {
                    case 'mv_slider_title':                        
                        if ($this->isEmpty($value)) {
                            add_settings_error( 'mv_slider_options', 'mv_slider_message', 'The title field can not be left empty', 'error' );
                            $value = 'Please, type some text';
                        }
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                    default:
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                }                
            }

            return $new_input;
        }

        private function isEmpty(string|bool|int|null $value): bool
        {
            // Converte o valor para string e remove todos os espaços
            $normalized = str_replace(' ', '', (string)$value);
            return $normalized === '';
        }
    }
}
