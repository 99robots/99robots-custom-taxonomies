<?php
/*
Plugin Name: Gabfire Custom Taxonomies Beta
plugin URI:
Description: Creates a User Interface to add taxonomies.
version: 0.9
Author: Gabfire Themes
Author URI: http://gabfirethemes.com
License: GPL2
*/

/* Plugin verison */

if (!defined('GABFIRE_CUSTOM_TAXONOMY_VERSION_NUM'))
    define('GABFIRE_CUSTOM_TAXONOMY_VERSION_NUM', '0.9.0');

/**
 * Activatation / Deactivation
 */

register_activation_hook( __FILE__, array('Gabfire_Taxonomies', 'register_activation'));


/**
 * Hooks / Filter
 */

add_action('admin_menu', array('Gabfire_Taxonomies','gabfire_menu'));
add_action('init', array('Gabfire_Taxonomies','gabfire_dashboard_register_custom_taxonomy'));
add_action('admin_enqueue_scripts', array('Gabfire_Taxonomies', 'gabfire_include_admin_scripts'));

add_action('init', array('Gabfire_Taxonomies', 'gabfire_load_textdoamin'));

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", array('Gabfire_Taxonomies', 'gabfire_settings_link'));

/**
 * Gabfire_Taxonomies class.
 */
class Gabfire_Taxonomies {

	/**
	 * dashboard_page
	 *
	 * (default value: 'gabfire-custom-taxonomies-dashboard')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $dashboard_page = 'gabfire-custom-taxonomies-dashboard';

	/**
	 * add_new_page
	 *
	 * (default value: 'gabfire-custom-taxonomies-add-new')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $add_new_page = 'gabfire-custom-taxonomies-add-new';

	/**
	 * text_domain
	 *
	 * (default value: 'gabfire-custom-taxonomies')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $text_domain = 'gabfire-custom-taxonomies';

	/**
	 * default
	 *
	 * (default value: '')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	private static $default = '';

	/**
	 * Performs tasks needed upon activation
	 *
	 * @since 1.0.0
	 */
	static function register_activation() {

		/* Check if multisite, if so then save as site option */

		if (is_multisite()) {
			add_site_option('gabfire_custom_taxonomies_version', GABFIRE_CUSTOM_TAXONOMY_VERSION_NUM);
		} else {
			add_option('gabfire_custom_taxonomies_version', GABFIRE_CUSTOM_TAXONOMY_VERSION_NUM);
		}
	}

	/**
	 * Hooks to 'plugin_action_links_' filter
	 *
	 * @since 1.0.0
	 */
	static function gabfire_settings_link($links) {
		$settings_link = '<a href="admin.php?page=' . self::$dashboard_page . '">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * Load the text domain
	 *
	 * @since 1.0.0
	 */
	static function gabfire_load_textdoamin() {
		load_plugin_textdomain(self::$text_domain, false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Registers the custom taxonomy
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_register_custom_taxonomy() {

		// Get settings

		if (function_exists('is_multisite') && is_multisite()) {
			$settings = get_site_option('gabfire_taxonomies_settings');
		} else {
			$settings = get_option('gabfire_taxonomies_settings');
		}

		if ($settings === false) {
			$settings = self::$default;
		}

		if (is_array($settings)) {
			/* Register all custom post types */

			foreach ($settings as $taxonomy => $item) {
				register_taxonomy($taxonomy, $item['post_type'], $item['args']);
			}
		}
	}

	/**
	 * Hook for the admin menu
	 *
	 * @since 1.0.0
	 */
	static function gabfire_menu() {
		add_menu_page(
			"Gabfire Taxonomies",
			"Gabfire Taxonomies",
			'manage_options',
			self::$dashboard_page,
			array('Gabfire_Taxonomies','gabfire_dashboard'));

		$gabfire_admin_page_list = add_submenu_page(
			self::$dashboard_page,
			"All Taxonomies",
			"All Taxonomies",
			'manage_options',
			self::$dashboard_page,
			array('Gabfire_Taxonomies','gabfire_dashboard'));
		add_action('load-' . $gabfire_admin_page_list, array('Gabfire_Taxonomies','gabfire_dashboard_help_list'));

		$gabfire_admin_page_new = add_submenu_page(
			self::$dashboard_page,
			"Add New",
			"Add New",
			'manage_options',
			self::$add_new_page,
			array('Gabfire_Taxonomies','gabfire_dashboard_add_new'));
		add_action('load-' . $gabfire_admin_page_new, array('Gabfire_Taxonomies','gabfire_dashboard_help_new'));

	 	/* add_submenu_page(self::$dashboard_page, "Help", "Help",'manage_options', "gabfire-taxonomies-admin-help", array('Gabfire_taxonomies','gabfire_dashboard_help')); */
	}

	/**
	 * Displays on the All Items Dashboard
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard() {

		require('admin/dashboard.php');

		wp_localize_script('gabfire_taxonomies_js', 'gabfire_ahref_array', $gabfire_ahref_array);
	}

	/**
	 * Displays on the Add New page
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_add_new() {

		/* Get all post types that are public */
		$post_types = get_post_types(array('public' => true));

		// Get settings

		if (function_exists('is_multisite') && is_multisite()) {
			$settings = get_site_option('gabfire_taxonomies_settings');
		} else {
			$settings = get_option('gabfire_taxonomies_settings');
		}

		if ($settings === false) {
			$settings = self::$default;
		}

		/* Deleting a Custom Post Type */

		if (isset($_GET['action']) && $_GET['action'] == "delete" && check_admin_referer('gabfire_taxonomy_delete')) {
			if (isset($_GET['taxonomy']))
				unset($settings[$_GET['taxonomy']]);

			if (is_multisite()) {
				update_site_option('gabfire_taxonomies_settings', $settings);
			}else {
				update_option('gabfire_taxonomies_settings', $settings);
			}

			?>
			<script type="text/javascript">
				window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$dashboard_page; ?>";
			</script>
			<?php
		}

		/* Add new -Default- */

		$data['taxonomy'] = '';
		$data['post_type'] = array('post');
		$data['args'] = array(
			'public'              	=> true,
			'show_ui'             	=> true,
			'show_in_nav_menus'   	=> true,
			'show_tagcloud'       	=> true,
			'show_admin_column'   	=> true,
			'hierarchical'        	=> false,
			'update_count_callback' => true,
			'query_var'           	=> true,
			'sort' 					=> false,
			/*
'capabilities' 		  	=> array(
				'manage_terms'      => 'manage_terms',
				'edit_terms'        => 'edit_terms',
				'delete_terms'      => 'delete_terms',
				'assign_terms'      => 'assign_terms'
			),
*/
			'rewrite' 				=> true,
			'labels' 				=> array()
		);

		/* Edit Existing */

		if (isset($_GET['action']) && $_GET['action'] == "edit"/*  && check_admin_referer('gabfire_taxonomy_add') */) {
			if (isset($_GET['taxonomy'])) {
				$data = $settings[$_GET['taxonomy']];
			}
		}

		/* Save option */
		if (isset($_POST['submit'])/*  && check_admin_referer('gabfire_taxonomy_add') */) {

			/* Determine Post Types */

			$post_types_array = array();

			foreach ($post_types as $post_type) {
				if (isset($_POST['gct_post_type_' . $post_type]) && $_POST['gct_post_type_' . $post_type])
					$post_types_array[] = $post_type;
			}


			/* Determine Capabilities */

			/*
$capabilites = array();

			if (!empty($_POST['gct_capabilities_manage_terms'])) {
				$capabilites['manage_terms'] = sanitize_text_field($_POST['gct_capabilities_manage_terms']);
			} else {
				$capabilites['manage_terms'] = 'manage_categories';
			}

			if (!empty($_POST['gct_capabilities_edit_terms'])) {
				$capabilites['edit_terms'] = sanitize_text_field($_POST['gct_capabilities_edit_terms']);
			} else {
				$capabilites['edit_terms'] = 'manage_categories';
			}

			if (!empty($_POST['gct_capabilities_delete_terms'])) {
				$capabilites['delete_terms'] = sanitize_text_field($_POST['gct_capabilities_delete_terms']);
			} else {
				$capabilites['delete_terms'] = 'manage_categories';
			}

			if (!empty($_POST['gct_capabilities_assign_terms'])) {
				$capabilites['assign_terms'] = sanitize_text_field($_POST['gct_capabilities_assign_terms']);
			} else {
				$capabilites['assign_terms'] = 'edit_posts';
			}
*/

			/* Determine Rewrite */

			if (isset($_POST['gct_rewrite']) && $_POST['gct_rewrite'] == 'true') {
				$rewrite = true;
			}else if (isset($_POST['gct_rewrite']) && $_POST['gct_rewrite'] == 'false') {
				$rewrite = false;
			}else if (isset($_POST['gct_rewrite']) && $_POST['gct_rewrite'] == 'advanced') {
				$rewrite = array(
					'with_front' 	 => isset($_POST['gct_rewrite_with_front']) && $_POST['gct_rewrite_with_front'] ? true : false,
					'hierarchical' 	 => isset($_POST['gct_rewrite_hierarchical']) && $_POST['gct_rewrite_hierarchical'] ? true : false
				);
				if (isset($_POST['gct_rewrite_slug'])) $rewrite['slug'] = sanitize_text_field($_POST['gct_rewrite_slug']);
			}

			/* Determine Labels */

			$custom_taxonomy_id = strtolower(str_replace(' ','',sanitize_text_field($_POST['gct_taxonomy'])));

			$custom_taxonomy_id_UC = ucfirst($custom_taxonomy_id);

			$labels = array();

			!empty($_POST['gct_label_name']) ? $labels['name'] = sanitize_text_field($_POST['gct_label_name']) : $labels['name'] = $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_singular_name']) ? $labels['singular_name'] = sanitize_text_field($_POST['gct_label_singular_name']) : $labels['singular_name'] = $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_menu_name']) ? $labels['menu_name'] = sanitize_text_field($_POST['gct_label_menu_name']) : $labels['menu_name'] = $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_all_items']) ? $labels['all_items'] = sanitize_text_field($_POST['gct_label_all_items']) : $labels['all_items'] = 'All ' . $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_edit_item']) ? $labels['edit_item'] = sanitize_text_field($_POST['gct_label_edit_item']) : $labels['edit_item'] = 'Edit ' . $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_update_item']) ? $labels['update_item'] = sanitize_text_field($_POST['gct_label_update_item']) : $labels['update_item'] = 'Update ' . $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_view_item']) ? $labels['view_item'] = sanitize_text_field($_POST['gct_label_view_item']) : $labels['view_item'] = 'View ' . $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_add_new_item']) ? $labels['add_new_item'] = sanitize_text_field($_POST['gct_label_add_new_item']) : $labels['add_new_item'] = 'Add New ' . $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_new_item_name']) ? $labels['new_item_name'] = sanitize_text_field($_POST['gct_label_new_item_name']) : $labels['new_item_name'] = 'New ' . $custom_taxonomy_id_UC;
			!empty($_POST['gct_label_parent_item']) ? $labels['parent_item'] = sanitize_text_field($_POST['gct_label_parent_item']) : $labels['parent_item'] = 'Parent ' . $custom_taxonomy_id;
			!empty($_POST['gct_label_parent_item_colon']) ? $labels['parent_item_colon'] = sanitize_text_field($_POST['gct_label_parent_item_colon']) : $labels['parent_item_colon'] = 'Parent ' . $custom_taxonomy_id . ':';
			!empty($_POST['gct_label_search_items']) ? $labels['search_items'] = sanitize_text_field($_POST['gct_label_search_items']) : $labels['search_items'] = 'Search ' . $custom_taxonomy_id;
			!empty($_POST['gct_label_popular_items']) ? $labels['popular_items'] = sanitize_text_field($_POST['gct_label_popular_items']) : $labels['popular_items'] = 'Popular ' . $custom_taxonomy_id;
			!empty($_POST['gct_label_separate_items_with_commas']) ? $labels['separate_items_with_commas'] = sanitize_text_field($_POST['gct_label_separate_items_with_commas']) : $labels['separate_items_with_commas'] = 'Separate ' . $custom_taxonomy_id . ' with commas';
			!empty($_POST['gct_label_add_or_remove_items']) ? $labels['add_or_remove_items'] = sanitize_text_field($_POST['gct_label_add_or_remove_items']) : $labels['add_or_remove_items'] = 'Add or Remove ' . $custom_taxonomy_id;
			!empty($_POST['gct_label_choose_from_most_used']) ? $labels['choose_from_most_used'] = sanitize_text_field($_POST['gct_label_choose_from_most_used']) : $labels['choose_from_most_used'] = 'Choose from most used ' . $custom_taxonomy_id;
			!empty($_POST['gct_label_not_found']) ? $labels['not_found'] = sanitize_text_field($_POST['gct_label_not_found']) : $labels['not_found'] = $custom_taxonomy_id_UC . ' not found';

			/* Determine All Arguments */

			$args = array(
				'labels'            => $labels,
				'public'            => isset($_POST['gct_public']) && $_POST['gct_public'] ? true : false,
				'show_ui'           => isset($_POST['gct_show_ui']) && $_POST['gct_show_ui'] ? true : false,
				'show_in_nav_menus' => isset($_POST['gct_show_in_nav_menus']) && $_POST['gct_show_in_nav_menus'] ? true : false,
				'show_tagcloud'     => isset($_POST['gct_show_tagcloud']) && $_POST['gct_show_tagcloud'] ? true : false,
				'show_admin_column' => isset($_POST['gct_show_admin_column']) && $_POST['gct_show_admin_column'] ? true : false,
				'rewrite'           => $rewrite,
				/* 'capabilities'   => $capabilites, */
				'hierarchical'      => isset($_POST['gct_hierarchical']) && $_POST['gct_hierarchical'] ? true : false,
				'sort'              => isset($_POST['gct_sort']) && $_POST['gct_sort'] ? true : false,
			);

			/* Query Variable bool/string */

			/* Query Variable bool/string */

			if (isset($_POST['gct_query_var']) && $_POST['gct_query_var'] && empty($_POST['gct_query_var_name']))
				$args['query_var'] = true;
			else if (isset($_POST['gct_query_var']) && !$_POST['gct_query_var'] && empty($_POST['gct_query_var_name']))
				$args['query_var'] = false;
			else if (!empty($_POST['gct_query_var_name']))
				$args['query_var'] = sanitize_text_field($_POST['gct_query_var_name']);

			/* Check if all required settigns are met */
			if (isset($_POST['gct_taxonomy']) && $_POST['gct_taxonomy'] != '' && count($post_types_array) > 0) {
				if (isset($_GET['action']) && $_GET['action'] == "edit") {

					/* Add/Edit and save custom post type */

					$settings[$custom_taxonomy_id] = array(
						'taxonomy'	=> $custom_taxonomy_id,
						'post_type'	=> $post_types_array,
						'args'		=> $args
					);

					if (is_multisite()) {
						update_site_option('gabfire_taxonomies_settings', $settings);
					}else {
						update_option('gabfire_taxonomies_settings', $settings);
					}

					/* Go back to the main dashboard */
					?>
					<script type="text/javascript">
						window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$dashboard_page; ?>";
					</script>
					<?php
				} else {
					if (!array_key_exists($custom_taxonomy_id, $settings)) {
						/* Add/Edit and save custom post type */

						$settings[$custom_taxonomy_id] = array(
							'taxonomy'	=> $custom_taxonomy_id,
							'post_type'	=> $post_types_array,
							'args'		=> $args
						);

						if (is_multisite()) {
							update_site_option('gabfire_taxonomies_settings', $settings);
						}else {
							update_option('gabfire_taxonomies_settings', $settings);
						}

						/* Go back to the main dashboard */
						?>
						<script type="text/javascript">
							window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$dashboard_page; ?>";
						</script>
						<?php
					} else {
						/* Go back to the main dashboard */
						?>
						<script type="text/javascript">
							window.location = "<?php echo $_SERVER['PHP_SELF']?>?page=<?php echo self::$dashboard_page; ?>&error=duplicate";
						</script>
						<?php
					}
				}
			}else {
				error_log(__('Gabfire Custom Taxonomy:: Missing the required taxonomy name field and/or the build into post type check boxes.',self::$text_domain));
			}
		}

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-tabs');

		require('admin/add_edit.php');
	}

	/**
	 * Displays the help tab
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_list() {
		$screen = get_current_screen();
		$screen->add_help_tab( array(
		    'id'      	=> 'gabfire-taxonomies-help-list-overview', // This should be unique for the screen.
		    'title'   	=> 'Overview',
		    'content'	=> '',
		    'callback'	=> array('Gabfire_Taxonomies', 'gabfire_dashboard_help_list_overview')
		));
	}

	/**
	 * Displays the help tab
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_new() {
		$screen = get_current_screen();
		$screen->add_help_tab( array(
		    'id'      	=> 'gabfire-taxonomies-help-new-parameters', // This should be unique for the screen.
		    'title'   	=> 'Parameters',
		    'content'	=> '',
		    'callback'	=> array('Gabfire_Taxonomies', 'gabfire_dashboard_help_new_parameters')
		));

		$screen->add_help_tab( array(
		    'id'      	=> 'gabfire-taxonomies-help-new-reserved-terms', // This should be unique for the screen.
		    'title'   	=> 'Reserved Terms',
		    'content'	=> '',
		    'callback'	=> array('Gabfire_Taxonomies', 'gabfire_dashboard_help_new_reserved_terms')
		));
	}

	/**
	 * Displays the overview tab in the help tab in the all taxonomies page
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_list_overview() {
		?>
		<span><?php _e('This is an overview.',self::$text_domain); ?></span>
		<?php
	}

	/**
	 * Displays the parameter tab in the help tab in the add new taxonomies page
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_new_parameters() {
		_e('All parameters details can be found ',self::$text_domain);
		?><a target="_blank" href="http://codex.wordpress.org/Function_Reference/register_taxonomy#Parameters"><?php _e('here.',self::$text_domain); ?></a><?php
	}

	/**
	 * Displays the reserved terms tab in the help tab in the add new taxonomies page
	 *
	 * @since 1.0.0
	 */
	static function gabfire_dashboard_help_new_reserved_terms() {
		_e('All reserved terms details can be found ',self::$text_domain);
		?><a target="_blank" href="http://codex.wordpress.org/Function_Reference/register_taxonomy#Reserved_Terms"><?php _e('here.',self::$text_domain); ?></a><?php
	}

	/**
	 * Register scripts for admin page
	 *
	 * @since 1.0.0
	 *
	 * @param 	N/A
	 * @return 	N/A
	 */
	static function gabfire_include_admin_scripts() {

		if (isset($_GET['page']) && ($_GET['page'] == self::$dashboard_page || $_GET['page'] == self::$add_new_page)) {
			wp_register_script('gabfire_taxonomies_js', plugins_url( '/js/gabfire_taxonomies.js', __FILE__ ), array(), false, true);
			wp_enqueue_script('gabfire_taxonomies_js');

			wp_register_style('gabfire_taxonomies_css', plugins_url('css/gabfire_taxonomies.css', __FILE__));
			wp_enqueue_style('gabfire_taxonomies_css');
		}
	}
}