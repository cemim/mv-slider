<?php
    // $meta = get_post_meta($post->ID);
    // $meta['mv_slider_link_url'][0]; //outra forma
    $link_text = get_post_meta($post->ID, 'mv_slider_link_text', true);
    $link_url = get_post_meta($post->ID, 'mv_slider_link_url', true);
?>
<table class="form-table mv-slider-metabox">
    <input type="hidden" name="mv_slider_nonce" value="<?= wp_create_nonce('mv_slider_nonce') ?>">
    <tr>
        <th>
            <label for="mv_slider_link_text">Link Text</label>
        </th>
        <td>
            <input 
                type="text" 
                name="mv_slider_link_text" 
                id="mv_slider_link_text" 
                class="regular-text link-text"
                value="<?= esc_html($link_text) ?? '' ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="mv_slider_link_url">Link URL</label>
        </th>
        <td>
            <input 
                type="url" 
                name="mv_slider_link_url" 
                id="mv_slider_link_url" 
                class="regular-text link-url"
                value="<?= esc_url($link_url) ?? '' ?>"
                required
            >
        </td>
    </tr>               
</table>