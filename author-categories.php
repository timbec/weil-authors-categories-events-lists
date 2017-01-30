<?php
/*
Plugin Name: Weil Author and Categories Lists
Plugin URI: http://www.weil.com
Description: Includes 'Weil Category', 'Weil Authors' and 'Weil Events' List widgets. 
Version: 1.2.6
Author: Tim Beckett
Author URI: http://tim-beckett.com


*/

//plugin_error(); 

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


if ( ! class_exists( 'Author_Categories_lists' ) ) :
	final class Author_Categories_Lists {


		/** Singleton *************************************************************/

		/**
		* @var Author_Categories_Lists
		*/
		private static $instance;



		/**
		* Main Class Instance
		*
		* Insures that only one instance of Author_Categories_Lists exists in memory at any one
		* time. Also prevents needing to define globals all over the place.
		*
		* @since v1.0
		* @staticvar array $instance
		* @see pw_Author_Categories_Lists_load()
		* @return The one true Author_Categories_Lists
		*/
		public static function instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new Author_Categories_Lists;
				self::$instance->includes();
				//self::$instance->init();
				do_action( 'author_categories_lists_loaded' );
			}
			return self::$instance;
		}

		private function includes() {
			include_once( dirname( __FILE__ ) . '/authors-widget.php' );
			//include_once( dirname( __FILE__ ) . '/categories-widget.php' );
			include_once( dirname( __FILE__ ) . '/display-categories-widget.php' );
			include_once( dirname( __FILE__ ) . '/upcoming-events-widget.php' );
		}

		/** Filters & Actions **/
		// private function init() {

		// }

	}
endif; 


function wp_authors_categories_list_load() {
	return Author_Categories_Lists ::instance();
}

// Get WPACE runnigx
wp_authors_categories_list_load();

?>