<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()) ?></h1>
    <!-- Ver todas as options dominio + /wp-admin/options.php -->
    <form action="options.php" method="post">
        <?php 
            settings_fields( 'mv_slider_group' );
            do_settings_sections( 'mv_slider_page1' );
            submit_button('Save Settings');
        ?>
    </form>
</div>