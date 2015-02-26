/*
 * Created by Kyle Benk
 * http://kylebenkapps.com
 */

jQuery(document).ready(function($) {

	/* Admin form make the name field required */

	$(".gabfire_custom_taxonomy_form").submit(function(e){

		$("#gct_taxonomy").removeClass('gabfire_custom_taxonomy_admin_required');
		$(".gct_post_type").removeClass('gabfire_custom_taxonomy_admin_required');

		/* Taxonomy */

		if ($("#gct_taxonomy").val() == '') {
			$("#gct_taxonomy").addClass('gabfire_custom_taxonomy_admin_required');
			e.preventDefault();
		}

		/* Build into post types */

		if (!$(".gct_post_type").is(':checked')) {
			$(".gct_post_type").addClass('gabfire_custom_taxonomy_admin_required');
			e.preventDefault();
		}
	});

	$(".gabfire_taxonomies_admin_delete").click(function(){
		gabfire_custom_taxonomy_delete($(this).attr('id'), $("#gabfire_custom_taxonomies_delete_url_" + $(this).attr('id')).text());
	});

	$('input:radio[name="gct_rewrite"]').change(function(){
		if ($(this).val() == 'advanced') {
			$(".gabfire_custom_taxonomy_admin_settings_rewite_advanced").show();
		} else {
			$(".gabfire_custom_taxonomy_admin_settings_rewite_advanced").hide();
		}
	});

	if ($('input[name="gct_rewrite"]:checked').val() == 'advanced') {
		$(".gabfire_custom_taxonomy_admin_settings_rewite_advanced").show();
	} else {
		$(".gabfire_custom_taxonomy_admin_settings_rewite_advanced").hide();
	}
});

function gabfire_custom_taxonomy_delete(message, url) {

	var c = confirm("Are you sure you want to delete: " + message);

	if (c == true) {
		window.location = url;
	}
}