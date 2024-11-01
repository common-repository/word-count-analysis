<?php do_action('wca_tab_header'); ?>
    <div class="p-2">
        <table id="author" class="table-auto w-full font-sans bg-white">
            <thead class="text-left text-gray-600">
            <tr>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Author', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Posts', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Words', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Uniq Words', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Characters', 'wcadomain') ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __('Sentence Length', 'wcadomain') ?></th>
            </tr>
            </thead>
            <tbody class="font-medium border-2">
            <?php foreach ($this->wca_post_total as $t): ?>
                <tr class="border-b-2 border-dashed border-gray-100">
                    <td class="p-2">
                        <div class="flex space-x-3">
                            <div>
                                <img src="<?php echo esc_url(get_avatar_url($t->author_id)); ?>" width="140"
                                     height="140" class="w-10 rounded-md"
                                     alt="<?php echo the_author_meta('display_name', esc_html($t->author_id)); ?>"/>
                            </div>
                            <div>
                                <div class="">
                                    <?php echo the_author_meta('display_name', esc_html($t->author_id)); ?>
                                </div>
                                <div class="text-sm text-gray-400 font-normal"><?php echo the_author_meta('email', esc_html($t->author_id)); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="p-2">
                        <div class="flex flex-col">
                            <div class=""><?php echo esc_html($t->post_count) ?></div>
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
                            <div class=""><?php echo round($t->post_sentence_length_avg) ?> Avg</div>
                            <div class="text-sm text-gray-400 font-normal">Min
                                <b><?php echo esc_html($t->post_sentence_length_min) ?></b> - Max
                                <b><?php echo esc_html($t->post_sentence_length_max) ?></b></div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>

<?php do_action('wca_tab_footer'); ?>