<?php
include_once( WCA_LIBS . 'StopWords.php' );

/**
 * Class Words
 * el : Stopwords Greek (EL)
 * cs : Stopwords Czech (CS)
 * id : Stopwords Indonesian (ID)
 * hi : Stopwords Hindi (HI)
 * bg : Stopwords Bulgarian (BG)
 * pl : Stopwords Polish (PL)
 * zh : Stopwords Chinese (ZH)
 * es : Stopwords Spanish (ES)
 * sv : Stopwords Swedish (SV)
 * ru : Stopwords Russian (RU)
 * pt : Stopwords Portuguese (PT)
 * nl : Stopwords Dutch (NL)
 * da : Stopwords Danish (DA)
 * lv : Stopwords Latvian (LV)
 * js : Stopwords Japanese (JA)
 */
class WCA_Words {
	/**
	 * @var
	 */
	private $text;
	/**
	 * @var mixed|string
	 */
	private $lang;


	/**
	 * Words constructor.
	 *
	 * @param $data
	 */
	public function __construct( $data, $lang = 'en' ) {

		$this->text = $data;
		$this->lang = $lang;
	}

	/**
	 * @return array
	 */
	public function all() {


		$_stop_words_count = $this->stopWordsCount( $this->lang );
		$_word_count       = $this->word_count();
		$_sentence_count   = $this->sentence_split( $this->text );
		$_char_count       = $this->char_count();


		return [
			'word_count'       => $_word_count,
			'sentence_count'   => $_sentence_count,
			'char_count'       => $_char_count,
			'stop_words_count' => count( $_stop_words_count[0] ),
		];
	}

	/**
	 * We do not count punctuation marks such as question marks or exclamation points.
	 * @return false|int
	 */
	public function word_count() {
		return preg_match_all( "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u", strip_tags( wp_filter_nohtml_kses( $this->text ) ), $matches );
	}


	/**
	 * @return int
	 */
	public function char_count() {
		return strlen( str_replace( ' ', '', strip_tags( wp_filter_nohtml_kses( $this->text ) ) ) );
	}

	/**
	 * @return mixed
	 */
	public function _get_content() {
		return $this->text;
	}

	//

	/**
	 * @param $text
	 *
	 * @return string|string[]|null
	 */
	private function _clear_h1( $text ) {
		$h      = '/<h.*?(.*?)>(.*)<\/h[^>]+>/u';
		$subst  = '';
		$result = preg_replace( $h, $subst, $text );

		return $result;
	}

	/**
	 * @param $text
	 *
	 * @return string|string[]|null
	 */
	private function _clear_html( $text ) {
		return preg_replace( '/<[^>]*>/', '', $text );
	}


	/**
	 * @param $text
	 * özel karakterleri ve alt satırlari siler
	 *
	 * @return string|string[]|null
	 */
	private function _clear_special_char( $text ) {
		$re    = '/[^\w!@£]/u';
		$subst = ' ';

		$result = preg_replace( $re, $subst, $text );

		return $this->_remove_duplicate_space( $result );
	}

	/**
	 * @param $text
	 *
	 * @return string|string[]|null
	 */
	private function _clear_ul( $text ) {
		$re     = '/<u.*?(.*?)>(.*)<\/u[^>]+>/u';
		$subst  = '';
		$result = preg_replace( $re, $subst, $text );

		return $result;
	}

	/**
	 * @param $text
	 *
	 * @return string|string[]|null
	 */
	private function _remove_button( $text ) {
		$re    = '/<button(.*?)>(.*)<\/[^>]+>/u';
		$subst = ' ';

		$result = preg_replace( $re, $subst, $text );

		return $this->_remove_duplicate_space( $result );
	}

	/**
	 * @param $text
	 *
	 * @return string|string[]|null
	 */
	private function _remove_duplicate_space( $text ) {
		$string = preg_replace( "/\p{Z}+/mui", ' ', $text );

		return $string;
	}

	/**
	 * @param $text
	 *
	 * @return string|string[]|null
	 */
	private function _remove_numbers( $text ) {
		$re    = '/[0-9]/u';
		$subst = ' ';

		$result = preg_replace( $re, $subst, $text );

		return $result;
	}


	/**
	 * @param $text
	 * @param false $type
	 *
	 * @return array
	 */
	public function sentence_split( $text, $type = false ) {

		//$text                 = $this->_clear_h1( $text );

		include_once( WCA_VENDOR . 'autoload.php' );

		$text = preg_replace( '/\n/u', ' ', $this->_clear_html( $this->_clear_h1( $this->text ) ) );
		$text = str_replace( '&nbsp;', ' ', $text );

		$sentence  = new \Vanderlee\Sentence\Sentence();
		$sentences = $sentence->split( $text );

		if ( $type == false ) {
			$_count = array();
			foreach ( $sentences as $value ) {
				//$c = preg_match_all( "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u", $value, $matches );
				$re = '/\p{L}[\p{L}\p{Mn}\p{Pd}\'\x{2019}(0-9]*/u';
				preg_match_all( $re, $value, $matches, PREG_SET_ORDER, 0 );
				array_push( $_count, count( $matches ) );
			}
			$minmax = array(
				'sentence_words_min' => min( $_count ),
				'sentence_words_max' => max( $_count ),
				'sentence_words_avg' => array_sum( $_count ) / count( $_count ),
				'sentence_count'        => $sentence->count( $text )
			);

			return $minmax;
		}

		return $sentences;


	}


	/**
	 * @param $text
	 *
	 * @return string|string[]|null
	 */
	private function removeDuplicateWords( $text ) {
		$re    = '/\b(\w+)\b(?=.*?\b\1\b)/ui';
		$subst = ' ';

		$result = preg_replace( $re, $subst, $text );
		$result = preg_replace( "/\p{Z}+/mui", ' ', $result );

		return $result;
	}

	/**
	 * @param $lang
	 *
	 * @return mixed
	 */
	public function stopWordsCount( $lang ) {
		$_count    = new WCA_StopWords( $lang );
		$stopwords = $this->_clear_html( $this->text );
		$stopwords = $this->_clear_special_char( $stopwords );
		$stopwords = $this->_remove_numbers( $stopwords );
		$stopwords = $_count->remove( $stopwords );
		$stopwords = $this->removeDuplicateWords( $stopwords );
		preg_match_all( "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u", $stopwords, $matches );

		return $matches;
	}
}
