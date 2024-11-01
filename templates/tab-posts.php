<?php do_action('wca_tab_header');?>
    <div class="">
        <table id="posts" class="table-auto w-full font-sans bg-white">
            <thead class="text-left text-gray-600">
            <tr>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __( 'Title', 'wcadomain' ) ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __( 'Words', 'wcadomain' ) ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __( 'Uniq Words', 'wcadomain' ) ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __( 'Characters', 'wcadomain' ) ?></th>
                <th class="border-l-2 border-t-2 bg-gray-200 p-2"><?php echo __( 'Sentence Length', 'wcadomain' ) ?></th>
            </tr>
            </thead>
            <tbody class="font-medium border-2">
            <tr class="border-b-2 border-dashed border-gray-100">
                <td class="p-2">
                    <div class="flex space-x-3">

                        <div>
                            <div class="">Shower Stools for Shaving Legs More Comfortably</div>
                            <div class="text-sm text-gray-500 font-normal"><b>7</b> <?php echo __( 'Word', 'wcadomain' ) ?> - <b>5</b> <?php echo __( 'Uniq Word', 'wcadomain' ) ?></div>
                        </div>
                    </div>
                </td>
                <td class="p-2">
                    <div class="flex flex-col">
                        <div class="">3.251</div>
                        <div class="text-sm text-gray-400 font-normal"><?php echo __( 'Word', 'wcadomain' ) ?></div>
                    </div>
                </td>
                <td class="p-2">
                    <div class="flex flex-col">
                        <div class="">3.251</div>
                        <div class="text-sm text-gray-400 font-normal"><?php echo __( 'Uniq Word', 'wcadomain' ) ?></div>
                    </div>
                </td>
                <td class="p-2">
                    <div class="flex flex-col">
                        <div class="">13.251</div>
                    </div>
                </td>
                <td class="p-2">
                    <div class="flex flex-col">
                        <div class="">13 Avg</div>
                        <div class="text-sm text-gray-400 font-normal">Min <b>4</b> - Max <b>16</b></div>
                    </div>
                </td>
            </tr>

            </tbody>
        </table>

    </div>
<?php do_action('wca_tab_footer');?>