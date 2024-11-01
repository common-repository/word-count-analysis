<?php


add_filter('manage_post_posts_columns', function ($columns) {

    return array_merge($columns, ['words' => __('Words', 'textdomain')]);
});
add_action('manage_post_posts_custom_column', function ($column_key, $post_id) {

    if ($column_key == 'words') {
        $wca_total = wca_post($post_id)[0];

        _e('Word Count', 'wcadomain');
        _e(' : ' . $wca_total->post_word_count);
        _e("<br />");
        _e('Unique Word Count', 'wcadomain');
        _e(' : ' . $wca_total->post_word_uniq_count);
        _e("<br />");
        _e('Sentences', 'wcadomain');
        _e(' : ' . $wca_total->post_sentence_count);
        _e("<br />");
        _e('Characters', 'wcadomain');
        _e(' : ' . $wca_total->post_char_count);
        _e("<br />");
        _e('<a href="admin.php?page=wca_dashboard">' . __('View', 'textdomain') . '</a>');

    }

}, 10, 2);
function wca_post($post_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'wca_posts';
    $sql_posts = "select post_word_count,post_word_uniq_count,post_sentence_count,post_char_count from $table_name where post_id=$post_id";
    $wca_posts = $wpdb->get_results($sql_posts);

    return $wca_posts;

}


add_action('transition_post_status', 'hooks_transition_post_status', 10, 3);
function hooks_transition_post_status($new_status, $old_status, $post)
{
    if ($new_status == 'auto-draft' || $new_status == 'inherit') {
        return;
    }

    if($post->post_type=='wp_template')
    {
        return;
    }
    if(empty($post->post_content))
    {
        return;
    }
    echo "Post içerik " .$post->post_content;
    var_dump($post);
    echo "<script>console.log('new : $new_status - old: $old_status post: $post->post_type ')</script>";

    include_once(WCA_LIBS . 'wca_sql.php');
    $_sql = new WCA_Sql();
    $_sql->calculation($post);
}

function wca_add_dashboard_widgets()
{

    wp_add_dashboard_widget(
        'wca_dashboard_widget',                          // Widget slug.
        esc_html__('Word Count and Analysis Overview', 'wca'), // Title.
        'wca_dashboard_widget_render'                    // Display function.
    );

}

function wca_dashboard_widget_render()
{
    include_once(WCA_LIBS . 'wca_sql.php');
    $_sql = new WCA_Sql();
    $_total = $_sql->statics();
    ?>
    <h3> Posts</h3>
    <div class="wca-grid wca-grid-rows-3 wca-gap-4 wca-divide-y-2 wca-border-2 wca-rounded-md">
        <div class="wca-flex wca-flex-col wca-items-center wca-space-y-3">
            <span class="wca-text-3xl wca-font-bold"><?php esc_html_e(number_format_i18n($_total->word_total)); ?></span>
            <span class="wca-font-normal"><?php echo __('Word Count', 'wcadomain') ?></span>
        </div>
        <div class="wca-flex wca-flex-col wca-items-center wca-space-y-3">
            <span class="wca-text-3xl wca-font-bold"><?php esc_html_e(number_format_i18n($_total->char_total)); ?></span>
            <span class="wca-font-normal"><?php echo __('Character Count', 'wcadomain') ?></span>
        </div>
        <div class="wca-flex wca-flex-col wca-items-center wca-space-y-3">
            <span class="wca-text-3xl wca-font-bold"><?php esc_html_e(number_format_i18n($_total->sentence_total)); ?></span>
            <span class="wca-font-normal"><?php echo __('Sentence Count', 'wcadomain') ?></span>
        </div>
    </div>
    <style>
        *,
        ::before,
        ::after {
            box-sizing: border-box;
            /* 1 */
            border-width: 0;
            /* 2 */
            border-style: solid;
            /* 2 */
            border-color: #e5e7eb;
            /* 2 */
        }

        *, ::before, ::after {
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
        }

        .wca-flex {
            display: flex;
        }

        .wca-grid {
            display: grid;
        }

        .wca-grid-rows-3 {
            grid-template-rows: repeat(3, minmax(0, 1fr));
        }

        .wca-flex-col {
            flex-direction: column;
        }

        .wca-items-center {
            align-items: center;
        }

        .wca-gap-4 {
            gap: 1rem;
        }

        .wca-space-y-3 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.75rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.75rem * var(--tw-space-y-reverse));
        }

        .wca-divide-y-2 > :not([hidden]) ~ :not([hidden]) {
            --tw-divide-y-reverse: 0;
            border-top-width: calc(2px * calc(1 - var(--tw-divide-y-reverse)));
            border-bottom-width: calc(2px * var(--tw-divide-y-reverse));
        }

        .wca-rounded-md {
            border-radius: 0.375rem;
        }

        .wca-border-2 {
            border-width: 2px;
        }

        .wca-text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .wca-font-semibold {
            font-weight: 600;
        }

        .wca-font-bold {
            font-weight: 700;
        }

        .wca-font-normal {
            font-weight: 400;
        }


    </style>
    <?php
}

add_action('wp_dashboard_setup', 'wca_add_dashboard_widgets');

/*function wca_upgrade_function($upgrader_object, $options)
{
    $current_plugin_path_name = plugin_basename(__FILE__);

    if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'])) {
        foreach ($options['plugins'] as $each_plugin) {
            if ($each_plugin == $current_plugin_path_name) {
                update_option('wca_version', WORD_COUNT_ANALYSIS_VERSION);
            }
        }
    }
}
add_action('upgrader_process_complete', 'wca_upgrade_function', 10, 2);*/
