<?php
/**
 * Class WCA_plugin
 *
 *
 */
// include only file
if (!defined('ABSPATH')) {
    die('Do not open this file directly.');
}

class WCA_Plugin
{
    public $wca_tab;
    public $wca_setup = 0;
    public $count;
    public $stopwords;
    public $post;
    public $wca_post_total;

    public function __construct()
    {
        $this->wca_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'wca_tab_dashboard';
        add_action('admin_menu', array($this, 'wca_options_page'));
        add_action('wca_tab_header', array($this, 'wca_header'));
        add_action('wca_tab_footer', array($this, 'wca_footer'));


        if ($this->wca_tab == "wca_tab_re_calculate" || $this->wca_setup == 0) {
            $this->wca_setup = 0;

            $this->_ajax_script();
        }


        /*
            add_action( 'wca_tab_authors', array( $this, 'wca_tab_authors' ) );*/
    }

    public function _ajax_script()
    {

        wp_enqueue_script('ajax-script', plugins_url('/js/wca_ajax.js', __FILE__), array('jquery'));
        wp_localize_script('ajax-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        add_action('wp_ajax_calculation', array($this, 'calculation'));
    }

    public function wca_options_page()
    {
        $icon_svg = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiBhcmlhLWhpZGRlbj0idHJ1ZSIgcm9sZT0iaW1nIiBjbGFzcz0iaWNvbmlmeSBpY29uaWZ5LS1jb2RpY29uIiB3aWR0aD0iMWVtIiBoZWlnaHQ9IjFlbSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ieE1pZFlNaWQgbWVldCIgdmlld0JveD0iMCAwIDE2IDE2Ij48cGF0aCBmaWxsPSJjdXJyZW50Q29sb3IiIGQ9Ik0xNSA0aC01VjNoNXYxem0tMSAzaC0ydjFoMlY3em0tNCAwSDF2MWg5Vjd6bTIgNkgxdjFoMTF2LTF6bS01LTNIMXYxaDZ2LTF6bTggMGgtNXYxaDV2LTF6TTggMnYzSDFWMmg3ek03IDNIMnYxaDVWM3oiPjwvcGF0aD48L3N2Zz4=';
        add_menu_page(
            __('Word Count And Analysis', 'wcadomain'),
            __('Word C&A', 'wcadomain'),
            'manage_options',
            'wca_dashboard',
            array($this, 'wca_dashboard'),
            $icon_svg,
            9999
        );

    }

    public function wca_dashboard()
    {
        $this->wca_setup = $this->wca_setup();
        if ($this->wca_setup == 0) {
            return include_once('templates/calculate.php');
        }
        $this->_datatablescript();
        add_action('wp_footer', '_datatableAuthor');
        if ($this->wca_tab == 'wca_tab_authors') {
            $this->wca_post_total = $this->wca_author();
            return include_once('templates/tab-authors.php');
        } elseif ($this->wca_tab == 'wca_tab_posts') {
            return include_once('templates/tab-posts.php');
        } elseif ($this->wca_tab == 'wca_tab_re_calculate') {
            return include_once('templates/tab-re-calculate.php');
        } elseif ($this->wca_tab == 'wca_tab_pro') {
            return include_once('templates/tab-pro.php');
        }

        $this->wca_post_total = $this->wca_posts();
        include_once('templates/tab-dashboard.php');
    }

    public function wca_posts()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wca_posts';
        $sql_posts = "select * from $table_name where post_type='post' order by post_date asc";
        $wca_posts = $wpdb->get_results($sql_posts);

        return $wca_posts;
    }

    public function wca_author()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wca_posts';
        $sql_posts = "
            select 
                  author_id, 
                  count(post_id) as post_count,
                  sum(post_sentence_count) as post_sentence_count,
                  sum(post_word_count) as post_word_count,
                  sum(post_word_uniq_count) as post_word_uniq_count,
                  sum(post_char_count) as post_char_count,
                  max(post_sentence_length_max) as post_sentence_length_max,
                  min(post_sentence_length_max) as post_sentence_length_min,
                  avg(post_sentence_length_avg) as post_sentence_length_avg
            from $table_name where post_type='post' group by author_id;
        ";
        $wca_auhor = $wpdb->get_results($sql_posts);
        return $wca_auhor;
    }

    public function wca_setup()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wca_posts';
        $sql_posts = "select count(*) as count from $table_name";
        $wca_posts = $wpdb->get_results($sql_posts);

        return $wca_posts[0]->count;
    }

    /**
     * @param post $post The post object
     * @param $count
     * @param string $post_type
     *
     * @return mixed|string
     */
    public function insert($post, $count, $post_type = 'post')
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wca_posts';
        if ($post_type == 'comment') {
            return $post_type;
        }

        $sql_data_insert = "insert into $table_name (post_id,author_id,post_type,post_status,post_date,post_modified,calc_date,title_word_count,title_word_uniq_count,post_word_count,post_word_uniq_count,post_sentence_count,post_sentence_length_min,post_sentence_length_max,post_sentence_length_avg,post_char_count)"
            . " values (%d,%d,%s,%s,%s,%s,%s,%d,%d,%d,%d,%d,%d,%d,%f,%d) "
            . "ON DUPLICATE KEY UPDATE "
            . "post_id = %d,"
            . "author_id = %d,"
            . "post_type = %s,"
            . "post_status = %s,"
            . "post_date = %s,"
            . "post_modified = %s,"
            . "calc_date = %s,"
            . "title_word_count = %d,"
            . "title_word_uniq_count = %d,"
            . "post_word_count = %d,"
            . "post_word_uniq_count = %d,"
            . "post_sentence_count = %d,"
            . "post_sentence_length_min = %d,"
            . "post_sentence_length_max = %d,"
            . "post_sentence_length_avg = %f,"
            . "post_char_count = %d";

        $now = date_create('now')->format('Y-m-d H:i:s');


        $_data = $wpdb->prepare($sql_data_insert,
            $post->ID,
            $post->post_author,
            $post->post_type,
            $post->post_status,
            $post->post_date,
            $post->post_modified,
            $now,
            $count['title']['word_count'],
            $count['title']['stop_words_count'],
            $count['content']['word_count'],
            $count['content']['stop_words_count'],
            $count['content']['sentence_count']['sentence_count'],
            $count['content']['sentence_count']['sentence_words_min'],
            $count['content']['sentence_count']['sentence_words_max'],
            $count['content']['sentence_count']['sentence_words_avg'],
            $count['content']['char_count'],
            $post->ID,
            $post->post_author,
            $post->post_type,
            $post->post_status,
            $post->post_date,
            $post->post_modified,
            $now,
            $count['title']['word_count'],
            $count['title']['stop_words_count'],
            $count['content']['word_count'],
            $count['content']['stop_words_count'],
            $count['content']['sentence_count']['sentence_count'],
            $count['content']['sentence_count']['sentence_words_min'],
            $count['content']['sentence_count']['sentence_words_max'],
            $count['content']['sentence_count']['sentence_words_avg'],
            $count['content']['char_count']
        );

        $data = $wpdb->query($_data);

        return $data;


    }

    public function calculation()
    {

        include_once(WCA_LIBS . 'wca_sql.php');
        $_sql = new WCA_Sql();
        //posts
        $wpb_all_query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));
        while ($wpb_all_query->have_posts()) {
            $wpb_all_query->the_post();
            $_post = get_post();
            $_sql->calculation($_post);
        }
        wp_die();
    }


    public function _datatablescript()
    {
        wp_register_script('datatable-js', plugins_url('/js/jquery.dataTables.min.js', __FILE__), array());
        wp_enqueue_script('datatable-js');

        wp_register_script('table-js', plugins_url('/js/wca_script.js', __FILE__), array());
        wp_enqueue_script('table-js');

        wp_register_style('datatable-css', plugins_url('/css/jquery.dataTables.min.css', __FILE__), array());
        wp_enqueue_style('datatable-css');
    }

    public function wca_header()
    {
        include_once('templates/header.php');
    }

    public function wca_footer()
    {
        include_once('templates/footer.php');
    }


    public static function _activation()
    {
        global $wpdb;

        $updated = update_option('wca_version', WORD_COUNT_ANALYSIS_VERSION);
        $table_name = $wpdb->prefix . 'wca_posts';
        $wpdb->query('DROP TABLE IF EXISTS ' . $table_name);
        $sql = "CREATE TABLE $table_name (
						  post_id int(11) DEFAULT NULL,
						  author_id int(11) DEFAULT NULL,
						  post_type varchar(255) DEFAULT NULL,
						  post_status varchar(255) DEFAULT NULL,
						  post_date datetime DEFAULT NULL,
						  post_modified datetime DEFAULT NULL,
						  calc_date datetime DEFAULT NULL,
						  title_word_count int(11) DEFAULT NULL,
						  title_word_uniq_count int(11) DEFAULT NULL,
						  post_word_count int(11) DEFAULT NULL,
						  post_word_uniq_count int(11) DEFAULT NULL,
						  post_sentence_count int(11) DEFAULT NULL,
						  post_sentence_length_min int(11) DEFAULT NULL,
						  post_sentence_length_max int(11) DEFAULT NULL,
						  post_sentence_length_avg int(11) DEFAULT NULL,
						  post_char_count int(11) DEFAULT NULL,
						  UNIQUE KEY post_id (post_id)
					)";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        return dbDelta($sql);
    }

    public static function _deactivation()
    {
        global $wpdb;
        $redirect_table = $wpdb->prefix . "wca_posts";
        $wpdb->query('DROP TABLE IF EXISTS ' . $redirect_table);
        delete_option( 'wca_version' );
    }


}