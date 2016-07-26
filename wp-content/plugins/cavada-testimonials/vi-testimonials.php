<?php
if ( ! class_exists( 'testimonials_metabox' ) ) {
	class testimonials_metabox {
		/**
		 * @var array Meta box information
		 */
		public $meta_box;

		// Safe to start up
		public function __construct ( $args ) {

			// Assign meta box values to local variables and add it's missed values
			$this->meta_box   = $args;

			// Add meta boxes on the 'add_meta_boxes' hook.
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
			// Enqueue common styles and scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			// Save post meta
			add_action('save_post', array( $this, 'save_data' ) );
 		}
		function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'vi-meta-box', TESTIMONIALS_PLUGIN_URL . '/assets/css/meta-box.css', array(), "" );
		}
		/**
		 * Add meta box for multiple post types
		 *
		 * @return void
		 */
		public function add_meta_boxes () {
			// Use nonce for verification
			// create a custom nonce for submit verification later
			foreach ( $this->meta_box['pages'] as $page ) {
				add_meta_box(
					$this->meta_box['id'],
					$this->meta_box['title'],
					array( $this, 'meta_boxes_callback' ),
					$page,
					isset( $this->meta_box['context'] ) ? $this->meta_box['context'] : 'normal',
					isset( $this->meta_box['priority'] ) ? $this->meta_box['priority'] : 'default',
					$this->meta_box['fields']
				);
			}
		}

		// Callback function, uses helper function to print each meta box
		public function meta_boxes_callback ( $post, $fields ) {
			// create a custom nonce for submit verification later
			echo '<input type="hidden" name="vi_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

			foreach ( $fields['args'] as $field ) {
				switch( $field['type'] )
				{
					case 'textfield':
						$this->textfield( $field, $post->ID );
						break;
					case 'textarea':
						$this->textarea( $field, $post->ID );
						break;
					case 'checkbox':
						$this->checkbox( $field, $post->ID );
						break;
					case 'select':
						$this->select( $field, $post->ID );
						break;
  				}
			}
		}

		private function textarea ( $field, $post_id ) {
			$post_meta = get_post_meta( $post_id, $field['id'], true );
			if (isset($field['class'])) {
				$extra_class = " ".$field['class'];
			}else {$extra_class = "";}
			echo '<div class="vi-field'.$extra_class.'">';

			echo '<div class="vi-label"><label>'.$field['name'].': </label></div>';

			echo '<div class="vi-input">';
			echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'">'.$post_meta.'</textarea>';
			echo '<div class="desc">'.$field['desc'].'</div>';
			echo '</div>';

			echo '</div>';
		}

		private function textfield ( $field, $post_id ) {
			$post_meta = get_post_meta( $post_id, $field['id'], true );
			if (isset($field['class'])) {
				$extra_class = " ".$field['class'];
			}else {$extra_class = "";}

			printf(
				'<div class="vi-field%s"><div class="vi-label"><label>%s: </label></div> <div class="vi-input"><input type="text" name="%s" value="%s" /> <div class="desc">%s</div></div></div>',
				$extra_class,
				$field['name'],
				$field['id'],
				$post_meta,
				$field['desc']
			);
		}

		private function checkbox ( $field, $post_id ) {
			$post_meta = get_post_meta( $post_id, $field['id'], true );
			$post_meta = get_post_meta( $post_id, $field['id'], true );
			if (isset($field['class'])) {
				$extra_class = " ".$field['class'];
			}else {$extra_class = "";}
			echo '<div class="vi-field'.$extra_class.'">';

			echo '<div class="vi-label"><label>'.$field['name'].'</label></div>';
			?>

			<div class="vi-input"><input type="checkbox" name="<?php echo $field['id']; ?>" <?php checked($post_meta, 'on' ); ?> /> <div class="desc"><?php echo $field['desc']; ?></div></div>
			</div>
		<?php
		}

		private function select ( $field, $post_id ) {
			$post_meta = get_post_meta( $post_id, $field['id'], true );
			$post_meta = get_post_meta( $post_id, $field['id'], true );
			if (isset($field['class'])) {
				$extra_class = " ".$field['class'];
			}else {$extra_class = "";}
			echo '<div class="vi-field'.$extra_class.'">';

			echo '<div class="vi-label"><label>'.$field['name'].'</label></div>';

			echo '<div class="vi-input"><select name="'.$field['id'].'" id="'.$field['id'].'">';

			foreach ($field['options'] as $key => $value) {
				echo '<option '.( ( $key == $post_meta) ? ' selected ' : '' ).' value="'.$key.'">'.$value.'</option>';
			}
			echo '</select><div class="desc">'.(isset($field['desc']) ? $field['desc'] : "").'</div></div></div>';
		}

		// Save data from meta box
		public function save_data($post_id) {
			// verify nonce
			if (!isset($_POST['vi_meta_box_nonce']) || !wp_verify_nonce($_POST['vi_meta_box_nonce'], basename(__FILE__))) {
				return $post_id;
			}
			// check autosave
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return $post_id;
			}
			// check permissions
			if ('page' == $_POST['post_type']) {
				if (!current_user_can('edit_page', $post_id)) {
					return $post_id;
				}
			} elseif (!current_user_can('edit_post', $post_id)) {
				return $post_id;
			}

			foreach ($this->meta_box['fields'] as $field) {
				$old = get_post_meta($post_id, $field['id'], true);
				$new = $_POST[$field['id']];
				if ($new && $new != $old) {
					update_post_meta($post_id, $field['id'], $new);
				} elseif ('' == $new && $old) {
					delete_post_meta($post_id, $field['id'], $old);
				}
			}
		}
	}
}
if ( ! class_exists( 'VI_Testimonials' ) ) {
	/**
	 * Villatheme
	 *
	 * Manage the testimonials in the VI Framework
	 *
	 * @class VI_Testimonials
	 * @package	villathemepress
	 * @since 1.0
	 * @author kien16
	 */
	class VI_Testimonials {

		/**
	     * @var string
	     * @since 1.0
	     */
	    public $version = VI_TESTIMONIALS_VERSION;

	    /**
	     * @var object The single instance of the class
	     * @since 1.0
	     */
	    protected static $_instance = null;

		/**
	     * @var string
	     * @since 1.0
	     */
	    public $plugin_url;

	    /**
	     * @var string
	     * @since 1.0
	     */
	    public $plugin_path;

	    /**
		 * The array of templates that this plugin tracks.
		 *
		 * @var      array
		 */
		protected $templates;

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'testimonials_template_path', 'vi-testimonials/' );
		}

		/**
	     * Main plugin Instance
	     *
	     * @static
	     * @return object Main instance
	     *
	     * @since 1.0
	     * @author Antonino Scarfì <antonino.scarfi@yithemes.com>
	     */
	    public static function instance() {
	        if ( is_null( self::$_instance ) ) {
	            self::$_instance = new self();
	        }

	        return self::$_instance;
	    }

		/**
		 * Constructor
		 *
		 * Initialize plugin and registers the testimonials cpt
		 */
		public function __construct() {

	        // Define the url and path of plugin
	        $this->plugin_url  = untrailingslashit( plugins_url( '/', __FILE__ ) );
	        $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );


	       	add_action('wp_footer', array($this, 'vi_scripts'));


	        // Register CPTU
	        add_action( 'after_setup_theme', array( $this, 'register_cptu' ), 20 );

	        // Register Taxonomy
	       // add_action( 'after_setup_theme', array( $this, 'register_taxonomy' ), 20 );


	        // Display custom update messages for posts edits
			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

			// Display custom update messages for posts edits
			add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

			// Include OWN Metabox
			add_action( 'admin_init', 'testimonials_register_meta_boxes' );
			function testimonials_register_meta_boxes()
			{
				$meta_boxes = apply_filters( 'testimonials_meta_boxes', array() );
				foreach ( $meta_boxes as $meta_box )
				{
					new testimonials_metabox( $meta_box );
				}
			}
			add_filter( 'testimonials_meta_boxes', array( $this, 'testimonials_register_metabox' ), 20 );
			add_action('template_redirect', array( $this, 'template_redirect' ), 20 );
            
	    }

	    /**
         * Enqueue script and styles in admin side
         *
         * Add style and scripts to administrator
         *
         * @return void
         * @since    1.0
         * @author   villatheme
         */
        public function vi_scripts() {
        }

	    /**
		 * Template part Redirect.
		 *
		 * @access public
		 * @return void
		 */
	    public function template_redirect() {
	    	global $wp_query;
	    	if (get_post_type() == "testimonials" && (is_category() || is_archive()) ) {
	    		$this->get_template_part( 'archive' , "testimonials");
	    		exit();
	    	}
	    	else if (get_post_type() == "testimonials" && is_single()) {
	    		$this->get_template_part("single", "testimonials");
	    		exit();
	    	}
	    	else {
	    		return;
	    	}
		}

		/**
		 * Get template part (for templates like the shop-loop).
		 *
		 * @access public
		 *
*@param mixed $slug
		 * @param string $name (default: '')
		 *
*@return void
		 */
		public function get_template_part( $slug, $name = '' ) {
			$template = '';
			// Look in yourtheme/slug-name.php and yourtheme/testimonials/slug-name.php
			if ( $name ) {
				$template = locate_template( array( "{$slug}-{$name}.php", 'testimonials/' . "{$slug}-{$name}.php" ) );
			}
			// Get default slug-name.php
			if ( ! $template && $name && file_exists( $this->plugin_path . "/templates/{$slug}-{$name}.php" ) ) {
				$template = $this->plugin_path . "/templates/{$slug}-{$name}.php";
			}
			// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/testimonials/slug.php
			if ( ! $template ) {
				$template = locate_template( array( "{$slug}.php", 'testimonials/' . "{$slug}.php" ) );
			}
			// Allow 3rd party plugin filter template file from their plugin
			$template = apply_filters( 'get_template_part', $template, $slug, $name );

			if ( $template ) {
				load_template( $template, false );
			}
		}

	    /**
	     * Register the Custom Post Type Unlimited
	     *
	     * @return void
	     * @since 1.0
	     * @author villathemepress
	     */
	    public function register_cptu () {
	    	$labels = array(
				'name'               => _x( 'Testimonials', 'Post Type General Name', 'villatheme-testimonials' ),
				'singular_name'      => _x( 'Testimonials', 'Post Type Singular Name', 'villatheme-testimonials' ),
				'menu_name'          => __( 'Testimonials', 'villatheme-testimonials' ),
				'parent_item_colon'  => __( 'Parent Testimonials:', 'villatheme-testimonials' ),
				'all_items'          => __( 'All Testimonialss', 'villatheme-testimonials' ),
				'view_item'          => __( 'View Testimonials', 'villatheme-testimonials' ),
				'add_new_item'       => __( 'Add New Testimonials', 'villatheme-testimonials' ),
				'add_new'            => __( 'New Testimonials', 'villatheme-testimonials' ),
				'edit_item'          => __( 'Edit Testimonials', 'villatheme-testimonials' ),
				'update_item'        => __( 'Update Testimonials', 'villatheme-testimonials' ),
				'search_items'       => __( 'Search testimonials', 'villatheme-testimonials' ),
				'not_found'          => __( 'No testimonials found', 'villatheme-testimonials' ),
				'not_found_in_trash' => __( 'No testimonials found in Trash', 'villatheme-testimonials' ),
			);
			$args   = array(
				'labels'      => $labels,
				'supports'    => array( 'title', 'editor', 'thumbnail' ),
				'public'      => true,
				'has_archive' => true,
			);
			register_post_type( 'testimonials', $args );
	    }

	    /**
		 * Register Testimonials Taxonomy
		 *
		 * @return void
		 * @since  1.0
		 */
//		public function register_taxonomy () {
//			// Testimonials Categories
//			$labels = array(
//				'name'                       => _x( 'Testimonials Categories', 'Taxonomy General Name', 'villatheme-testimonials' ),
//				'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'villatheme-testimonials' ),
//				'menu_name'                  => __( 'Categories', 'villatheme-testimonials' ),
//				'all_items'                  => __( 'All Categories', 'villatheme-testimonials' ),
//				'parent_item'                => __( 'Parent Category', 'villatheme-testimonials' ),
//				'parent_item_colon'          => __( 'Parent Category:', 'villatheme-testimonials' ),
//				'new_item_name'              => __( 'New Category Name', 'villatheme-testimonials' ),
//				'add_new_item'               => __( 'Add New Category', 'villatheme-testimonials' ),
//				'edit_item'                  => __( 'Edit Category', 'villatheme-testimonials' ),
//				'update_item'                => __( 'Update Category', 'villatheme-testimonials' ),
//				'separate_items_with_commas' => __( 'Separate categories with commas', 'villatheme-testimonials' ),
//				'search_items'               => __( 'Search categories', 'villatheme-testimonials' ),
//				'add_or_remove_items'        => __( 'Add or remove categories', 'villatheme-testimonials' ),
//				'choose_from_most_used'      => __( 'Choose from the most used categories', 'villatheme-testimonials' ),
//			);
//			$args   = array(
//				'labels'       => $labels,
//				'hierarchical' => true,
//				'show_ui'           => true,
//				'show_admin_column' => true,
//				'query_var'         => true,
//				'rewrite'           => array( 'slug' => 'testimonials_category' ),
//			);
//			register_taxonomy( 'testimonials_category', 'testimonials', $args );
//		}

		/**
		 * Change updated messages
		 *
		 * @param  array $messages
		 *
		 * @return array
		 * @since  1.0
		 */
		public function updated_messages( $messages = array() ) {
			global $post, $post_ID;
			$messages['testimonials'] = array(
				0  => '',
				1  => sprintf( __( 'Testimonials updated. <a href="%s">View Testimonials</a>', 'villatheme-testimonials' ), esc_url( get_permalink( $post_ID ) ) ),
				2  => __( 'Custom field updated.', 'villatheme-testimonials' ),
				3  => __( 'Custom field deleted.', 'villatheme-testimonials' ),
				4  => __( 'Testimonials updated.', 'villatheme-testimonials' ),
				5  => isset( $_GET['revision'] ) ? sprintf( __( 'Testimonials restored to revision from %s', 'villatheme-testimonials' ), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false,
				6  => sprintf( __( 'Testimonials published. <a href="%s">View Testimonials</a>', 'villatheme-testimonials' ), esc_url( get_permalink( $post_ID ) ) ),
				7  => __( 'Testimonials saved.', 'villatheme-testimonials' ),
				8  => sprintf( __( 'Testimonials submitted. <a target="_blank" href="%s">Preview Testimonials</a>', 'villatheme-testimonials' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
				9  => sprintf( __( 'Testimonials scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Testimonials</a>', 'villatheme-testimonials' ), date_i18n( __( 'M j, Y @ G:i', 'villatheme-testimonials' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
				10 => sprintf( __( 'Testimonials draft updated. <a target="_blank" href="%s">Preview Testimonials</a>', 'villatheme-testimonials' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			);

			return $messages;
		}

		/**
		 * Register Testimonials Metabox
		 *
		 * @return void
		 * @since  1.0
		 */
		public function testimonials_register_metabox ($meta_boxes) {
			$meta_boxes[] = array(
		        'id' => 'testimonials_settings',
		        'title' => 'Testimonials Settings',
		        'pages' => array( 'testimonials' ),
		        'fields' => array(
					array(
						'name' => __( 'Regency', 'agapi' ),
						'id'   => 'regency',
						'type' => 'textfield',
						'desc'=>''
					),

					array(
						'name' => __( 'Website URL', 'agapi' ),
						'id'   => 'website_url',
						'type' => 'textfield',
						'desc'=>''
					),

		        )
			);

			return $meta_boxes;
		}
	}

	/**
	 * Main instance of plugin
	 *
	 * @return \VI_Testimonials
	 * @since  1.0
	 * @author villathemepress
	 */
	function VI_Testimonials() {
	    return VI_Testimonials::instance();
	}

	/**
	 * Instantiate Testimonials class
	 *
	 * @since  1.0
	 * @author villathemepress
	 */
	VI_Testimonials();
}