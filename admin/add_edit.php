<div class="wrap gabfire-plugin-settings">

	<?php require_once('header.php'); ?>

	<div class="metabox-holder has-right-sidebar">

		<?php require_once('sidebar.php'); ?>

		<div id="post-body">
			<div id="post-body-content">

				<form class="gabfire_custom_taxonomy_form" method="post">

				<div id="tabs">
					<ul>
						<li><a href="#gabfire_div_taxonomy"><span class="gabfire_admin_panel_content_tabs"><?php _e('Taxonomy',self::$text_domain); ?></span></a></li>
						<li><a href="#gabfire_div_labels"><span class="gabfire_admin_panel_content_tabs"><?php _e('Labels',self::$text_domain); ?></span></a></li>
						<!-- <li><a href="#gabfire_div_capabilities"><span class="gabfire_admin_panel_content_tabs"><?php _e('Capabilities',self::$text_domain); ?></span></a></li> -->
						<li><a href="#gabfire_div_visibility"><span class="gabfire_admin_panel_content_tabs"><?php _e('Visibility',self::$text_domain); ?></span></a></li>
						<li><a href="#gabfire_div_permalinks"><span class="gabfire_admin_panel_content_tabs"><?php _e('Permalinks',self::$text_domain); ?></span></a></li>
						<li><a href="#gabfire_div_query"><span class="gabfire_admin_panel_content_tabs"><?php _e('Query',self::$text_domain); ?></span></a></li>
					</ul>

					<div id="gabfire_div_taxonomy">
						<h3 class="title"><?php _e('Taxonomy', self::$text_domain); ?></h3>

						<table>
						<tbody>

							<!-- Taxonomy Name -->
							<tr>
								<th class="gabfire_taxonomies_admin_table_th">
									<label><?php _e('Taxonomy Name',self::$text_domain); ?></label>
									<td class="gabfire_taxonomies_admin_table_td">
										<input size="40" type="text" id="gct_taxonomy" name="gct_taxonomy" placeholder="e.g genre" value="<?php echo ((isset($_GET['action']) && $_GET['action'] == "edit" && (isset($_GET['taxonomy']) && $_GET['taxonomy'] != '')) ? $_GET['taxonomy'] : ''); ?>"  <?php echo((isset($_GET['action']) && $_GET['action'] == "edit") ? 'readonly' : ''); ?> /><br/>

										<em><?php _e('No more than 32 characters long, no whitespaces, and no capital letters.',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Build into certain post types -->
							<tr>
								<th class="gabfire_taxonomies_admin_table_th">
									<label><?php _e('Build into Post Type', self::$text_domain); ?></label>
									<td class="gabfire_taxonomies_admin_table_td">
										<?php
										foreach ($post_types as $post_type) {
										?>
											<input type="checkbox" class="gct_post_type" id="gct_post_type_<?php echo $post_type; ?>" name="gct_post_type_<?php echo $post_type; ?>" <?php echo (isset($data['post_type']) && in_array($post_type, $data['post_type']) ? 'checked="checked"' : '');?>/><label><?php printf(__('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%s', self::$text_domain), $post_type); ?></label><br />
										<?php
										} ?>
									</td>
								</th>
							</tr>

							<!-- Hierarchical -->
							<tr>
								<th class="gabfire_taxonomies_admin_table_th">
									<label><?php _e('Hierarchical', self::$text_domain); ?></label>
									<td class="gabfire_taxonomies_admin_table_td">
										<input type="checkbox" id="gct_hierarchical" name="gct_hierarchical" <?php echo (isset($data['args']['hierarchical']) && $data['args']['hierarchical'] ? 'checked="checked"' : ''); ?> /><em><?php _e('Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.', self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<!-- Sort -->
							<tr>
								<th class="gabfire_taxonomies_admin_table_th">
									<label><?php _e('Sort', self::$text_domain); ?></label>
									<td class="gabfire_taxonomies_admin_table_td">
										<input type="checkbox" id="gct_sort" name="gct_sort" <?php echo (isset($data['args']['sort']) && $data['args']['sort'] ? 'checked="checked"' : ''); ?> /><em><?php _e('Whether this taxonomy should remember the order in which terms are added to objects.', self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

						</tbody>
						</table>

					</div>

					<div id="gabfire_div_labels">

						<h3 class="title"><?php _e('Labels', self::$text_domain); ?></h3>

						<table>
						<tbody>

						<!-- Name (usually plural) -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Name',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_name" name="gct_label_name" placeholder="e.g Genres" value="<?php echo ((isset($data['args']['labels']['name']) && $data['args']['labels']['name'] != '') ? esc_attr($data['args']['labels']['name']) : ''); ?>"/><br/>
									<em><?php _e('Usually plural.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Singular Name -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Singular Name',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_singular_name" name="gct_label_singular_name" placeholder="e.g Genre" value="<?php echo ((isset($data['args']['labels']['singular_name']) && $data['args']['labels']['singular_name'] != '') ? esc_attr($data['args']['labels']['singular_name']) : ''); ?>"/><br/>
									<em><?php _e('Name for one object of this taxonomy.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Menu Name -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Menu Name',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_menu_name" name="gct_label_menu_name" placeholder="e.g Genre" value="<?php echo ((isset($data['args']['labels']['menu_name']) && $data['args']['labels']['menu_name'] != '') ? esc_attr($data['args']['labels']['menu_name']) : ''); ?>"/><br/>
									<em><?php _e('This string is the name to give menu items.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- All Items -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('All Items',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_all_items" name="gct_label_all_items" placeholder="e.g All Genres" value="<?php echo ((isset($data['args']['labels']['all_items']) && $data['args']['labels']['all_items'] != '') ? esc_attr($data['args']['labels']['all_items']) : ''); ?>"/><br/>
									<em><?php _e('The all items text.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Edit Item -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Edit Item',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_edit_item" name="gct_label_edit_item" placeholder="e.g Edit Genre" value="<?php echo ((isset($data['args']['labels']['edit_item']) && $data['args']['labels']['edit_item'] != '') ? esc_attr($data['args']['labels']['edit_item']) : ''); ?>"/><br/>
									<em><?php _e('The edit item text.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- View Item -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('View Item',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_view_item" name="gct_label_view_item" placeholder="e.g View Genre" value="<?php echo ((isset($data['args']['labels']['view_item']) && $data['args']['labels']['view_item'] != '') ? esc_attr($data['args']['labels']['view_item']) : ''); ?>"/><br/>
									<em><?php _e('The view item text.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Update Item -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Update Item',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_update_item" name="gct_label_update_item" placeholder="e.g Update Genre" value="<?php echo ((isset($data['args']['labels']['update_item']) && $data['args']['labels']['update_item'] != '') ? esc_attr($data['args']['labels']['update_item']) : ''); ?>"/><br/>
									<em><?php _e('The update item text.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Add New Item -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Add New Item',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_add_new_item" name="gct_label_add_new_item" placeholder="e.g Add New Genre" value="<?php echo ((isset($data['args']['labels']['add_new_item']) && $data['args']['labels']['add_new_item'] != '') ? esc_attr($data['args']['labels']['add_new_item']) : ''); ?>"/><br/>
									<em><?php _e('The add new item text.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- New Item Name -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('New Item Name',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_new_item_name" name="gct_label_new_item_name" placeholder="e.g New Genre Name" value="<?php echo ((isset($data['args']['labels']['new_item_name']) && $data['args']['labels']['new_item_name'] != '') ? esc_attr($data['args']['labels']['new_item_name']) : ''); ?>"/><br/>
									<em><?php _e('The new item name text.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Parent Item -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Parent Item',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_parent_item" name="gct_label_parent_item" placeholder="e.g Parent Genre" value="<?php echo ((isset($data['args']['labels']['parent_item']) && $data['args']['labels']['parent_item'] != '') ? esc_attr($data['args']['labels']['parent_item']) : ''); ?>"/><br/>
									<em><?php _e('This string is not used on non-hierarchical taxonomies such as post tags',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Parent Item Colon -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Parent Item Colon',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_parent_item_colon" name="gct_label_parent_item_colon" placeholder="e.g Parent Genre:" value="<?php echo ((isset($data['args']['labels']['parent_item_colon']) && $data['args']['labels']['parent_item_colon'] != '') ? esc_attr($data['args']['labels']['parent_item_colon']) : ''); ?>"/><br/>
									<em><?php _e('The same as parent_item, but with colon : in the end',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Search Items -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Search Items',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_search_items" name="gct_label_search_items" placeholder="e.g Search genres" value="<?php echo ((isset($data['args']['labels']['search_items']) && $data['args']['labels']['search_items'] != '') ? esc_attr($data['args']['labels']['search_items']) : ''); ?>"/><br/>
									<em><?php _e('The search items text.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Popular Items -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Popular Items',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_popular_items" name="gct_label_popular_items" placeholder="e.g Popular genres" value="<?php echo ((isset($data['args']['labels']['popular_items']) && $data['args']['labels']['popular_items'] != '') ? esc_attr($data['args']['labels']['popular_items']) : ''); ?>"/><br/>
									<em><?php _e('The popular items text.',self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Separate Items With Commas -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Separate Items With Commas',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_separate_items_with_commas" name="gct_label_separate_items_with_commas" placeholder="e.g Separate genres with commas" value="<?php echo ((isset($data['args']['labels']['separate_items_with_commas']) && $data['args']['labels']['separate_items_with_commas'] != '') ? esc_attr($data['args']['labels']['separate_items_with_commas']) : ''); ?>"/><br/>
									<em><?php _e("The separate item with commas text used in the taxonomy meta box. This string isn't used on hierarchical taxonomies",self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Add or Remove Items -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Add or Remove Items',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_add_or_remove_items" name="gct_label_add_or_remove_items" placeholder="e.g Add or remove genres" value="<?php echo ((isset($data['args']['labels']['add_or_remove_items']) && $data['args']['labels']['add_or_remove_items'] != '') ? esc_attr($data['args']['labels']['add_or_remove_items']) : ''); ?>"/><br/>
									<em><?php _e("The add or remove items text and used in the meta box when JavaScript is disabled. This string isn't used on hierarchical taxonomies.",self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Choose From Most Used -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Choose From Most Used',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_choose_from_most_used" name="gct_label_choose_from_most_used" placeholder="e.g Choose from the most used genres" value="<?php echo ((isset($data['args']['labels']['choose_from_most_used']) && $data['args']['labels']['choose_from_most_used'] != '') ? esc_attr($data['args']['labels']['choose_from_most_used']) : ''); ?>"/><br/>
									<em><?php _e("The choose from most used text used in the taxonomy meta box. This string isn't used on hierarchical taxonomies",self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Not Found -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Not Found',self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_label_not_found" name="gct_label_not_found" placeholder="e.g genre not found" value="<?php echo ((isset($data['args']['labels']['not_found']) && $data['args']['labels']['not_found'] != '') ? esc_attr($data['args']['labels']['not_found']) : ''); ?>"/><br/>
									<em><?php _e("The text displayed via clicking 'Choose from the most used tags' in the taxonomy meta box when no tags are available. This string isn't used on hierarchical taxonomies.",self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						</tbody>
						</table>

					</div>

					<!--
<div id="gabfire_div_capabilities">
						<h3 class="title"><?php _e('Capabilities', self::$text_domain); ?></h3>

						<table>
						<tbody>

						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Manage Terms', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_capabilities_manage_terms" name="gct_capabilities_manage_terms" placeholder="e.g manage_terms" value="<?php echo ((isset($data['args']['capabilities']['manage_terms']) && $data['args']['capabilities']['manage_terms'] != '') ? esc_attr($data['args']['capabilities']['manage_terms']) : 'manage_terms'); ?>"/><br/>
									<em><label><?php _e('Default: manage_categories', self::$text_domain); ?></label></em><br />
								</td>
							</th>
						</tr>

						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Edit Terms', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_capabilities_edit_terms" name="gct_capabilities_edit_terms" placeholder="e.g edit_terms" value="<?php echo ((isset($data['args']['capabilities']['edit_terms']) && $data['args']['capabilities']['edit_terms'] != '') ? esc_attr($data['args']['capabilities']['edit_terms']) : 'edit_terms'); ?>"/><br/>
									<em><label><?php _e('Default: manage_categories', self::$text_domain); ?></label></em><br />
								</td>
							</th>
						</tr>

						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Delete Terms', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_capabilities_delete_terms" name="gct_capabilities_delete_terms" placeholder="e.g delete_terms" value="<?php echo ((isset($data['args']['capabilities']['delete_terms']) && $data['args']['capabilities']['delete_terms'] != '') ? esc_attr($data['args']['capabilities']['delete_terms']) : 'delete_terms'); ?>"/><br/>
									<em><label><?php _e('Default: manage_categories', self::$text_domain); ?></label></em><br />
								</td>
							</th>
						</tr>

						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Assign Terms', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_capabilities_assign_terms" name="gct_capabilities_assign_terms" placeholder="e.g assign_terms" value="<?php echo ((isset($data['args']['capabilities']['assign_terms']) && $data['args']['capabilities']['assign_terms'] != '') ? esc_attr($data['args']['capabilities']['assign_terms']) : 'assign_terms'); ?>"/><br/>
									<em><label><?php _e('Default: edit_posts', self::$text_domain); ?></label></em><br />
								</td>
							</th>
						</tr>

						</tbody>
						</table>

					</div>
-->

					<div id="gabfire_div_visibility">
						<h3 class="title"><?php _e('Visibility', self::$text_domain); ?></h3>

						<table>
						<tbody>

						<!-- Public -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Public', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input type="checkbox" id="gct_public" name="gct_public" <?php echo (isset($data['args']['public']) && $data['args']['public'] ? 'checked="checked"' : ''); ?> /><em><?php _e('If the taxonomy should be publicly queryable.', self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Show User Interface -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Show User Interface', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input type="checkbox" id="gct_show_ui" name="gct_show_ui" <?php echo (isset($data['args']['show_ui']) && $data['args']['show_ui'] ? 'checked="checked"' : ''); ?> /><em><?php _e('Whether to generate a default UI for managing this taxonomy.', self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Show In Navigation Menus -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Show In Navigation Menus', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input type="checkbox" id="gct_show_in_nav_menus" name="gct_show_in_nav_menus" <?php echo (isset($data['args']['show_in_nav_menus']) && $data['args']['show_in_nav_menus'] ? 'checked="checked"' : ''); ?> /><em><?php _e('True makes this taxonomy available for selection in navigation menus', self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Show In Tag Cloud -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Show In Tag Cloud', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input type="checkbox" id="gct_show_tagcloud" name="gct_show_tagcloud" <?php echo (isset($data['args']['show_tagcloud']) && $data['args']['show_tagcloud'] ? 'checked="checked"' : ''); ?> /><em><?php _e('Whether to allow the Tag Cloud widget to use this taxonomy.', self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<!-- Show In Admin Column -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Show In Admin Column', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input type="checkbox" id="gct_show_admin_column" name="gct_show_admin_column" <?php echo (isset($data['args']['show_admin_column']) && $data['args']['show_admin_column'] ? 'checked="checked"' : ''); ?> /><em><?php _e('Whether to allow automatic creation of taxonomy columns on associated post-types table.', self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						</tbody>
						</table>
					</div>

					<div id="gabfire_div_permalinks">
						<h3 class="title"><?php _e('Permalinks', self::$text_domain); ?></h3>

						<table>
						<tbody>

						<!-- Rewrite -->
						<tr>
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Rewrite', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input type="radio" id="gct_rewrite" name="gct_rewrite" value="true" <?php echo ((isset($data['args']['rewrite']) && !is_array($data['args']['rewrite']) && $data['args']['rewrite'] == true) ? 'checked' : ''); ?>/><label><?php _e('True',self::$text_domain); ?></label><br />
									<input type="radio" id="gct_rewrite" name="gct_rewrite" value="false" <?php echo ((isset($data['args']['rewrite']) && !is_array($data['args']['rewrite']) && $data['args']['rewrite'] == false) ? 'checked' : ''); ?>/><label><?php _e('False',self::$text_domain); ?></label><br />
									<input type="radio" id="gct_rewrite" name="gct_rewrite" value="advanced" <?php echo ((isset($data['args']['rewrite']) && is_array($data['args']['rewrite'])) ? 'checked' : ''); ?>/><label><?php _e('Advanced',self::$text_domain); ?></label><br />
									<label><em><?php _e('Default: true',self::$text_domain); ?></em></label>
								</td>
							</th>
						</tr>

						<tr class="gabfire_custom_taxonomy_admin_settings_rewite_advanced">
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Slug', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input size="40" type="text" id="gct_rewrite_slug" name="gct_rewrite_slug" placeholder="e.g genre" value="<?php echo ((isset($data['args']['rewrite']['slug']) && $data['args']['rewrite']['slug'] != '') ? esc_attr($data['args']['rewrite']['slug']) : ''); ?>"/><br/><em><?php _e('Used as pretty permalink text (i.e. /tag/).', self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						<tr class="gabfire_custom_taxonomy_admin_settings_rewite_advanced">
							<th class="gabfire_taxonomies_admin_table_th">
								<label><?php _e('Structure', self::$text_domain); ?></label>
								<td class="gabfire_taxonomies_admin_table_td">
									<input type="checkbox" id="gct_rewrite_with_front" name="gct_rewrite_with_front" <?php echo (isset($data['args']['rewrite']['with_front']) && $data['args']['rewrite']['with_front'] ? 'checked="checked"' : ''); ?> /><label><?php _e('With Front', self::$text_domain); ?></label><br />
									<em style="padding-left:1.5em"><?php _e('Allowing permalinks to be prepended with front base.', self::$text_domain); ?></em><br/>

									<input type="checkbox" id="gct_rewrite_hierarchical" name="gct_rewrite_hierarchical" <?php echo (isset($data['args']['rewrite']['hierarchical']) && $data['args']['rewrite']['hierarchical'] ? 'checked="checked"' : ''); ?> /><label><?php _e('Hierarchical', self::$text_domain); ?></label><br/>
									<em style="padding-left:1.5em"><?php _e('Allowing hierarchical urls.', self::$text_domain); ?></em>
								</td>
							</th>
						</tr>

						</tbody>
						</table>

					</div>

					<div id="gabfire_div_query">
						<h3 class="title"><?php _e('Query', self::$text_domain); ?></h3>

						<table>
						<tbody>

							<!-- Query Variable -->
							<tr>
								<th class="gabfire_taxonomies_admin_table_th">
									<label><?php _e('Query Variable', self::$text_domain); ?></label><br/>
									<em><?php _e('Either use the checkbox or textfield.', self::$text_domain); ?></em>
									<td class="gabfire_taxonomies_admin_table_td">
										<input size="40" type="checkbox" id="gct_query_var" name="gct_query_var" <?php echo ((isset($data['args']['query_var']) && $data['args']['query_var'] && is_bool($data['args']['query_var'])) ? 'checked="checked"' : ''); ?>/><br/>
										<em><?php _e('True - allows you to request a custom taxonomy (genre) using this: example.com/?genre=rock',self::$text_domain); ?></em>
										<em><?php _e('False - a taxonomy cannot be loaded at /?{query_var}={single_post_slug}',self::$text_domain); ?></em>
									</td>
								</th>
							</tr>

							<tr>
								<th class="gabfire_taxonomies_admin_table_th">
									<td class="gabfire_taxonomies_admin_table_td">
										<input size="40" type="text" id="gct_query_var_name" name="gct_query_var_name" placeholder="e.g genre" value="<?php echo ((isset($data['args']['query_var']) && $data['args']['query_var'] != '' && !is_bool($data['args']['query_var'])) ? esc_attr($data['args']['query_var']) : ''); ?>"/><br/>

										<em><label><?php _e('If set to a string rather than true (for example ‘music’), you can do: example.com/?music=rock',self::$text_domain); ?></label></em>
									</td>
								</th>
							</tr>

						</tbody>
						</table>

					</div>

				</div>

				<?php submit_button(); ?>
				</form>

<?php require_once('footer.php'); ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$( "#tabs" ).tabs();
	});
</script>