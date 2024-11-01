<div class="flex flex-col">
    <div class="p-2">
        <h1 class="text-2xl font-bold">Word Count and Analysis</h1>
        <div class="mt-2 flex space-x-1 border-b-2  font-medium text-gray-600">
            <div class="border-t-2 border-l-2 border-r-2 p-3 hover:bg-white <?php if (isset($this->wca_tab)) {
                echo esc_html($this->wca_tab == 'wca_tab_dashboard' ? 'bg-white' : 'bg-gray-300');
            } ?>">
                <a href="<?php echo add_query_arg(array('page' => 'wca_dashboard'), admin_url('admin.php')); ?>">Posts</a>
            </div>
            <div class="border-t-2 border-l-2 border-r-2 <?php if (isset($this->wca_tab)) {
                echo esc_html($this->wca_tab == 'wca_tab_authors' ? 'bg-white' : 'bg-gray-300');
            } ?> p-3 hover:bg-white"><a href="<?php echo add_query_arg(array(
                    'page' => 'wca_dashboard',
                    'tab' => 'wca_tab_authors'
                ), admin_url('admin.php')); ?>">Author</a></div>
            <div class="border-t-2 border-l-2 border-r-2 <?php if (isset($this->wca_tab)) {
                echo esc_html($this->wca_tab == 'wca_tab_re_calculate' ? 'bg-white' : 'bg-gray-300');
            } ?> p-3 hover:bg-white"><a href="<?php echo add_query_arg(array(
                    'page' => 'wca_dashboard',
                    'tab' => 'wca_tab_re_calculate'
                ), admin_url('admin.php')); ?>">Re Calculate</a></div>
            <div class="border-t-2 border-l-2 border-r-2 <?php if (isset($this->wca_tab)) {
                echo esc_html($this->wca_tab == 'wca_tab_pro' ? 'bg-white' : 'bg-orange-600 text-white');
            } ?> p-3 hover:bg-white "><a href="<?php echo add_query_arg(array(
                    'page' => 'wca_dashboard',
                    'tab' => 'wca_tab_pro'
                ), admin_url('admin.php')); ?>">Upgrade PRO</a></div>
        </div>
    </div>

</div>
<div class="p-1 -mt-3">
    <div class="p-2">