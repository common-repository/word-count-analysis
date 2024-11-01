<?php

class WCA_Sql
{

    public function calculation($post)
    {
        include_once(WCA_LIBS . 'words.php');
        $_content = new WCA_Words($post->post_content);
        $_title = new WCA_Words($post->post_title);
        $_count = array(
            'content' => $_content->all(),
            'title' => $_title->all()
        );
        $this->insert($post, $_count);

    }

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

    public function statics(){
        global $wpdb;

        $table_name = $wpdb->prefix . 'wca_posts';
        $sql_statics = "select sum(post_word_count) as word_total, sum(post_char_count) as char_total, sum(post_sentence_count) as sentence_total from $table_name where post_type='post'";
        $wca_total = $wpdb->get_results($sql_statics);
        return $wca_total[0];
    }
}