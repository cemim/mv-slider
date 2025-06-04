<?php 


if (! class_exists('MV_Slider_Shortcode')) {
    class MV_Slider_Shortcode {
        public function __construct()
        {
            add_shortcode( 'mv_slider', array($this, 'add_shortcode') );
        }

        public function add_shortcode($atts = array(), $content = null, $tag = '')
        {
            $atts = array_change_key_case((array) $atts, CASE_LOWER);

            // Extract cria variavéis coms as informações passadas pelo usuário
            extract(shortcode_atts(
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));

            if(!empty($id)){
                // Cria um array com os ids e usa a função absint em cada item do array
                $id = array_map('absint', explode(',', $id));
            }            

            /**
             * Como o shortcode é um filtro ele precisa retornar algo
             * Para retornar a saída HTML enviamos para um buffer interno e depois despejar esse HTML
             */
            ob_start();
            require(MV_SLIDER_PATH . 'views/mv-slider_shortcode.php');
            return ob_get_clean();            
        }
    }
}