<div class="wrap gabfire-plugin-settings">

	<?php require_once('header.php'); ?>

	<div class="metabox-holder has-right-sidebar">

		<?php require_once('sidebar.php'); ?>

		<div id="post-body">
			<div id="post-body-content">

				<div class="wrap">
					<div id="icon-edit" class="icon32 icon32-posts-post"><br/></div>
					<h2><?php _e('Gabfire Taxonomies',self::$text_domain); ?><a class="add-new-h2" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$add_new_page, 'gabfire_taxonomy_add'); ?>"><?php _e('Add New', self::$text_domain); ?></a></h2>

				<br />

				<!-- Detect errors -->
				<?php if (isset($_GET['error']) && $_GET['error'] == 'duplicate') { ?>
					<h3 style="color:red"><?php _e('Error: Cannot add duplicate custom taxonomy', self::$text_domain); ?></h3>
				<?php } ?>

				<table class="wp-list-table widefat fixed posts">
					<thead>
						<tr>
							<th><?php _e('Taxonomy', self::$text_domain); ?></th>
							<th><?php _e('Name', self::$text_domain); ?></th>
							<th><?php _e('Builtin Post Types', self::$text_domain); ?></th>
							<th><?php _e('Public', self::$text_domain); ?></th>
							<th><?php _e('Hierarchical', self::$text_domain); ?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th><?php _e('Taxonomy', self::$text_domain); ?></th>
							<th><?php _e('Name', self::$text_domain); ?></th>
							<th><?php _e('Builtin Post Types', self::$text_domain); ?></th>
							<th><?php _e('Public', self::$text_domain); ?></th>
							<th><?php _e('Hierarchical', self::$text_domain); ?></th>
						</tr>
					</tfoot>
					<tbody>
					<?php
						$settings = array();
						$gabfire_ahref_array = array();

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

							/* Loop through all custom post types */

							foreach ($settings as $taxonomy => $item) {
								$gabfire_ahref_array[] = $taxonomy;

								/*
$post_type_str = '';
								if (isset($item['post_type']) && is_array($item['post_type'])) {
									foreach ($item['post_type'] as $item2) {
										$post_type_str .= $item2 . ',';
									}
								} else if (isset($item['post_type']) && !is_array($item['post_type'])) {
									$post_type_str = $item['post_type'];
								}else {
									$post_type_str = 'N/A';
								}
*/

								?>
								<tr>
									<!-- Taxonomy -->
									<td>
										<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$add_new_page . '&taxonomy=' . $taxonomy . '&action=edit', 'gabfire_taxonomy_add'); ?>"><strong><?php _e($taxonomy,self::$text_domain); ?></strong></a>
									</td>

									<!-- Name -->
									<td>
										<label><?php echo isset($item['args']['labels']['name']) ? $item['args']['labels']['name'] : ''; ?></label>

										<div class="row-actions">
											<span class="edit">
												<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$add_new_page . '&taxonomy=' . $taxonomy . '&action=edit', 'gabfire_taxonomy_add'); ?>"><?php _e("Edit",self::$text_domain); ?></a>
											</span> |

											<span class="trash">

												<a href="#" class="gabfire_taxonomies_admin_delete" id="<?php echo $taxonomy; ?>"><?php _e('Delete', self::$text_domain); ?></a>

												<span id="gabfire_custom_taxonomies_delete_url_<?php echo $taxonomy; ?>" style="display:none;"><?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$add_new_page . '&taxonomy=' . $taxonomy . '&action=delete', 'gabfire_taxonomy_delete'); ?></span>

											</span>
										</div>
									</td>

									<!-- Bulitin Posts -->
									<td><?php
										 foreach ($item['post_type'] as $post_type) {
											 ?><div><a href="edit.php?post_type=<?php _e($post_type, self::$text_domain); ?>"><?php _e($post_type, self::$text_domain); ?></a></div><?php
										 } //echo __(trim($post_type_str, ","), self::$text_domain);
									?></td>

									<!-- Public -->
									<td> <?php echo (isset($item['args']['public']) && $item['args']['public'] ? __('yes',self::$text_domain) : __('no',self::$text_domain)); ?> </td>

									<!-- Hierarchical -->
									<td> <?php echo (isset($item['args']['hierarchical']) && $item['args']['hierarchical'] ? __('yes',self::$text_domain) : __('no',self::$text_domain)); ?> </td>
								</tr>
								<?php
							}
						}
					?>
					</tbody>
				</table>
				</div>
				<!-- <label style="color:red"><?php _e('**Please note that if plugin is deleted then all Gabfire Taxonomies will be deleted.  Also, if this plugin is deactivated, then all Gabfire Taxonomies will be deactivated as well.', self::$text_domain); ?></label> -->

<?php require_once('footer.php'); ?>