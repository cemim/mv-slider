<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()) ?></h1>
    <?php 
        $active_tab = $_GET['tab'] ?? 'main_options';
    ?>
    <!-- Ver todas as options dominio + /wp-admin/options.php -->
     <h2 class="nav-tab-wrapper">
        <a href="?page=mv_slider_admin&tab=main_options" class="nav-tab <?= $active_tab === 'main_options' ? 'nav-tab-active' : '' ?>">Main Options</a>
        <a href="?page=mv_slider_admin&tab=additional_options" class="nav-tab <?= $active_tab === 'additional_options' ? 'nav-tab-active' : '' ?>">Additional Options</a>
     </h2>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'mv_slider_group' ); 
            
            if($active_tab === 'main_options'){
                do_settings_sections( 'mv_slider_page1' );
            } else {
                do_settings_sections( 'mv_slider_page2' );
            }
            
            submit_button('Save Settings');
        ?>
    </form>
</div>