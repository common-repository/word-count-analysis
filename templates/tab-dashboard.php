<?php do_action('wca_tab_header'); ?>
    <div class="">
        <table id="posts" class="table-auto w-full font-sans bg-white">
            <thead class="text-left text-gray-600">
            <tr>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Title', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Words', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Uniq Words', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Characters', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Sentence Length', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Post Modified', 'wcadomain') ?></th>
            </tr>
            </thead>

            <tbody class="font-medium border-2">
            <?php foreach ($this->wca_post_total as $t): ?>
                <tr class="border-b-2 border-dashed border-gray-100">
                    <td class="p-2">
                        <div class="flex space-x-3">

                            <div>
                                <div class=""><?php echo get_the_title($t->post_id); ?> | <?php
                                    edit_post_link(__('Edit', 'textdomain'), '<span>', '</span>', $t->post_id, 'text-blue-600');
                                    ?>
                                </div>
                                <div class="text-sm text-gray-500 font-normal">
                                    <b><?php echo esc_html($t->title_word_count) ?></b> <?php echo __('Word', 'wcadomain') ?>
                                    -
                                    <b><?php echo esc_html($t->title_word_uniq_count) ?></b> <?php echo __('Uniq Word', 'wcadomain') ?>
                                    -
                                    <?php echo __('Post Type', 'wcadomain') ?>
                                    <b><?php echo esc_html($t->post_type) ?></b></div>
                            </div>
                        </div>
                    </td>
                    <td class="p-2">
                        <div class="flex flex-col">
                            <div class=""><?php echo esc_html($t->post_word_count) ?></div>
                        </div>
                    </td>
                    <td class="p-2">
                        <div class="flex flex-col">
                            <div class=""><?php echo esc_html($t->post_word_uniq_count) ?></div>
                        </div>
                    </td>
                    <td class="p-2">
                        <div class="flex flex-col">
                            <div class=""><?php echo esc_html($t->post_char_count) ?></div>
                        </div>
                    </td>
                    <td class="p-2">
                        <div class="flex flex-col">
                            <div class=""><?php echo esc_html(round($t->post_sentence_length_avg)) ?> Avg</div>
                            <div class="text-sm text-gray-400 font-normal">Min
                                <b><?php echo esc_html($t->post_sentence_length_min) ?></b> - Max
                                <b><?php echo esc_html($t->post_sentence_length_max) ?></b></div>
                        </div>
                    </td>
                    <td class="p-2">
                        <div class="flex flex-col">
                            <div class=""><?php echo esc_html($t->post_modified) ?></div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
<?php do_action('wca_tab_footer'); ?>