<?php
/*
 Plugin Name: Awsom Archive
 Plugin URI: http://www.awsom.org
 Author: Harknell
 Author URI: http://www.harknell.com
 Version: 1.5.0
 Description:  Displays an Archive at the top of your Posts on your Index Page and Post pages or anywhere else.

additional code from the plugin Archives for a category: Copyright 2007, 2008, 2009 Rob Schlüter. 

 */


$awsom_archive_db_version = 5;
$awsom_archive_table_name = $wpdb->prefix . "awsomarchive";
if ( !defined('WP_CONTENT_URL') )
define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if ( !defined('WP_CONTENT_DIR') )
define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
$plugin_path = WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__));
$awsom_archive_get_path = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';

//$awsom_archive_get_path = get_option('siteurl')."/wp-content/plugins/awsomarchive/";
$awsom_archive_displayed = 0;




function display_my_awsom_archive_custom() {
global $wpdb, $awsom_archive_table_name;

$usecustomarchivesize = get_option('awsom_archive_style_info');
$usecustomarchivecss = get_option('awsom_archive_custom_css');
$addpxatend = "px";
$usecustomarchive = get_option('awsom_archive_type_info');
	if ($usecustomarchive == 0) {

			$archiveparams = array( 'type'   => 'postbypost',
						     'format' => 'option');
			}


		if ($usecustomarchive == 1) {
				$archiveparams = array( 'type'   => 'monthly',
						                       'format' => 'option');
	}


		if ($usecustomarchive == 2) {
				$currentcustomtype = get_option('awsom_archive_custom_type');
				$currentcustomlimit = get_option('awsom_archive_custom_limit');
				$currentcustomcatnumber = get_option('awsom_archive_custom_catnumber');
				$currentcustomformat = get_option('awsom_archive_custom_format');
				$currentcustombefore = get_option('awsom_archive_custom_before');
				$currentcustomafter = get_option('awsom_archive_custom_after');
				$currentcustompostcount = get_option('awsom_archive_custom_postcount');
				if ($currentcustomcatnumber != ""){
						$archiveparams = array( 'type' => $currentcustomtype,
												'limit' => $currentcustomlimit,
												'format' => $currentcustomformat,
												'before' => $currentcustombefore,
												'after' => $currentcustomafter,
												'cat' => $currentcustomcatnumber,
												'show_post_count' => $currentcustompostcount);
						}
						else {
						$archiveparams = array( 'type' => $currentcustomtype,
														'limit' => $currentcustomlimit,
														'format' => $currentcustomformat,
														'before' => $currentcustombefore,
														'after' => $currentcustomafter,
														'show_post_count' => $currentcustompostcount);
			}
	}


?>

		<br /><div class="awsomarchive" <?php if ($usecustomarchivecss !== "") { echo"style=\"$usecustomarchivecss\"";} ?>>
			 <?php if ($usecustomarchive == 2 && $currentcustomformat == "option" || $usecustomarchive == 1 || $usecustomarchive == 0) { ?>
			<form id="awsomarchiveformcustom" action="">
			<select name="awsom_archive_chrono" <?php if ($usecustomarchivesize !== "0") { echo"style=\"width:$usecustomarchivesize$addpxatend;\"";} ?> onchange="window.location =
			(document.forms.awsomarchiveformcustom.awsom_archive_chrono[document.forms.awsomarchiveformcustom.awsom_archive_chrono.selectedIndex].value);">
			<option value=''> <?php $usecustomname = get_option('awsom_archive_custom_name'); if ($usecustomname !== "") { echo $usecustomname;} else { bloginfo('name'); echo" Archives";} ?> </option>
			<?php wp_get_archives($archiveparams); ?>
			</select>
			</form> <?php } else { $usecustomname = get_option('awsom_archive_custom_name'); if ($usecustomname !== "") { echo $usecustomname."<br /><ul>";} else { bloginfo('name'); echo" Archives <br /><ul>";} wp_get_archives($archiveparams); echo"</ul>";} ?>


			</div><br />
<?php

	}

function display_my_awsom_archive_inpost($content) {
global $wpdb, $awsom_archive_table_name;

if (strpos($content,'%%awsomarchive%%')!== false) {
$usecustomarchivesize = get_option('awsom_archive_style_info');
$usecustomarchivecss = get_option('awsom_archive_custom_css');
$addpxatend = "px";
$usecustomarchive = get_option('awsom_archive_type_info');
	if ($usecustomarchive == 0) {

			$archiveparams = array( 'type'   => 'postbypost',
						     'format' => 'option');
			}


		if ($usecustomarchive == 1) {
				$archiveparams = array( 'type'   => 'monthly',
						                       'format' => 'option');
	}


		if ($usecustomarchive == 2) {
				$currentcustomtype = get_option('awsom_archive_custom_type');
				$currentcustomlimit = get_option('awsom_archive_custom_limit');
				$currentcustomcatnumber = get_option('awsom_archive_custom_catnumber');
				$currentcustomformat = get_option('awsom_archive_custom_format');
				$currentcustombefore = get_option('awsom_archive_custom_before');
				$currentcustomafter = get_option('awsom_archive_custom_after');
				$currentcustompostcount = get_option('awsom_archive_custom_postcount');
				if ($currentcustomcatnumber != ""){
						$archiveparams = array( 'type' => $currentcustomtype,
												'limit' => $currentcustomlimit,
												'format' => $currentcustomformat,
												'before' => $currentcustombefore,
												'after' => $currentcustomafter,
												'cat' => $currentcustomcatnumber,
												'show_post_count' => $currentcustompostcount);
						}
						else {
						$archiveparams = array( 'type' => $currentcustomtype,
														'limit' => $currentcustomlimit,
														'format' => $currentcustomformat,
														'before' => $currentcustombefore,
														'after' => $currentcustomafter,
														'show_post_count' => $currentcustompostcount);
			}
	}

	ob_start();
	wp_get_archives($archiveparams);
	$awsomarchive_get_elements = ob_get_contents();
	ob_end_clean();

	$display_awsomarchive_inpost .= "<br /><!-- Start AWSOM Archive Output --><div class=\"awsomarchive\"";
	if ($usecustomarchivecss !== "") { $display_awsomarchive_inpost .=" style=\"".$usecustomarchivecss."\"";}
	$display_awsomarchive_inpost .=">";
	if ($usecustomarchive == 2 && $currentcustomformat == "option" || $usecustomarchive == 1 || $usecustomarchive == 0) {
	$display_awsomarchive_inpost .="<form id=\"awsomarchiveforminpost\" action=\"\">
			<select name=\"awsom_archive_chrono\"";
	if ($usecustomarchivesize !== "0") { $display_awsomarchive_inpost .=" \"style=\"width:".$usecustomarchivesize.$addpxatend."\"";}
	 $display_awsomarchive_inpost .=" onchange=\"window.location =(document.forms.awsomarchiveforminpost.awsom_archive_chrono[document.forms.awsomarchiveforminpost.awsom_archive_chrono.selectedIndex].value);\">
			<option value=''>";
	$usecustomname = get_option('awsom_archive_custom_name');
	if ($usecustomname !== "") { $display_awsomarchive_inpost .= $usecustomname;}
	else { $awsom_archive_blog_name_display = get_option('blogname'); $display_awsomarchive_inpost .= $awsom_archive_blog_name_display." Archives";}
	$display_awsomarchive_inpost .=" </option>";
	$display_awsomarchive_inpost .= $awsomarchive_get_elements;
	$display_awsomarchive_inpost .="</select>
			</form>";
	} else {
	$usecustomname = get_option('awsom_archive_custom_name');
	if ($usecustomname !== "") { $display_awsomarchive_inpost .= $usecustomname."<br /><ul>";}
	else { $display_awsomarchive_inpost .= bloginfo('name');
	$display_awsomarchive_inpost .=" Archives <br /><ul>";}
	$display_awsomarchive_inpost .= $awsomarchive_get_elements."</ul>";

	}
	$display_awsomarchive_inpost .="</div><br /><!-- End AWSOM Archive Output -->";


	}
	$content = str_replace("%%awsomarchive%%", $display_awsomarchive_inpost, $content);
	return $content;
}


function display_my_awsom_archive() {
global $wpdb, $awsom_archive_table_name,  $awsom_archive_displayed;

$should_i_show_default = get_option('awsom_archive_use_default');
if ($should_i_show_default == "0" && $awsom_archive_displayed == "0") {
if (!is_admin() && !is_page() && !is_feed() && !isset($_GET['akst_action']) ){
$awsom_archive_displayed = 1;
$usecustomarchivesize = get_option('awsom_archive_style_info');
$usecustomarchivecss = get_option('awsom_archive_custom_css');
$addpxatend = "px";
$usecustomarchive = get_option('awsom_archive_type_info');
	if ($usecustomarchive == 0) {

		$archiveparams = array( 'type'   => 'postbypost',
					     'format' => 'option');
		}


	if ($usecustomarchive == 1) {
		$archiveparams = array( 'type'   => 'monthly',
				                       'format' => 'option');
	}
	if ($usecustomarchive == 2) {
		$currentcustomtype = get_option('awsom_archive_custom_type');
		$currentcustomcatnumber = get_option('awsom_archive_custom_catnumber');
		$currentcustomlimit = get_option('awsom_archive_custom_limit');
		$currentcustomformat = get_option('awsom_archive_custom_format');
		$currentcustombefore = get_option('awsom_archive_custom_before');
		$currentcustomafter = get_option('awsom_archive_custom_after');
		$currentcustompostcount = get_option('awsom_archive_custom_postcount');
		if ($currentcustomcatnumber != ""){
		$archiveparams = array( 'type' => $currentcustomtype,
								'limit' => $currentcustomlimit,
								'format' => $currentcustomformat,
								'before' => $currentcustombefore,
								'after' => $currentcustomafter,
								'cat' => $currentcustomcatnumber,
								'show_post_count' => $currentcustompostcount);
		}
		else {
		$archiveparams = array( 'type' => $currentcustomtype,
										'limit' => $currentcustomlimit,
										'format' => $currentcustomformat,
										'before' => $currentcustombefore,
										'after' => $currentcustomafter,
										'show_post_count' => $currentcustompostcount);
			}
	}
	?>
<br /><!-- Start AWSOM Archive output --><div class="awsomarchive" <?php if ($usecustomarchivecss !== "") { echo"style=\"$usecustomarchivecss\"";} ?> >
			<?php if ($usecustomarchive == 2 && $currentcustomformat == "option" || $usecustomarchive == 1 || $usecustomarchive == 0) { ?>
			<form id="awsomarchiveform" action="">
			<select name="awsom_archive_chrono" <?php if ($usecustomarchivesize !== "0") { echo"style=\"width:$usecustomarchivesize$addpxatend;\"";} ?> onchange="window.location =
			(document.forms.awsomarchiveform.awsom_archive_chrono[document.forms.awsomarchiveform.awsom_archive_chrono.selectedIndex].value);">
			<option value=''> <?php $usecustomname = get_option('awsom_archive_custom_name'); if ($usecustomname !== "") { echo $usecustomname;} else { bloginfo('name'); echo" Archives";} ?> </option>
			<?php wp_get_archives($archiveparams);  ?>
			</select>
			</form><?php } else { $usecustomname = get_option('awsom_archive_custom_name'); if ($usecustomname !== "") { echo $usecustomname."<br /><ul>";} else { bloginfo('name'); echo" Archives <br /><ul>";} wp_get_archives($archiveparams); echo"</ul>";} ?>
			</div><br /><!-- End AWSOM Archive Output -->

<?php

	}
		}
}

function awsom_archive_options(){
global $wpdb, $awsom_archive_table_name, $awsom_archive_get_path;


if ( function_exists('current_user_can') && !current_user_can('manage_options') )
      	die(__('Cheating uh?'));


	if (isset($_POST['awsom_archive_update']))
		{
		check_admin_referer('adda_update_archive_options');
		$updatedarchivesize = $_POST['setarchivesize'];
		$updatedarchivesize = trim($updatedarchivesize);
		$updatedarchivesize = $wpdb->escape($updatedarchivesize);

		$updatedarchivename = $_POST['setarchivename'];
		$updatedarchivename = trim($updatedarchivename);
		$updatedarchivename = $wpdb->escape($updatedarchivename);

		$updatedarchivetype = $_POST['setarchivetype'];
		$updatedarchivetype = $wpdb->escape($updatedarchivetype);

		$updatedarchivefootercredit = $_POST['setarchivefootercredit'];
		$updatedarchivefootercredit = $wpdb->escape($updatedarchivefootercredit);


		$updatedarchivedefaultcase = $_POST['setarchivedefaultcase'];
		$updatedarchivedefaultcase = $wpdb->escape($updatedarchivedefaultcase);

		$updatedarchivecustype = $_POST['setarchivecustomtype'];
		$updatedarchivecustype = trim($updatedarchivecustype);
		$updatedarchivecustype = $wpdb->escape($updatedarchivecustype);

		$updatedarchivecuslimit = $_POST['setarchivecustomlimit'];
		$updatedarchivecuslimit = trim($updatedarchivecuslimit);
		$updatedarchivecuslimit = $wpdb->escape($updatedarchivecuslimit);

		$updatedarchivecusformat = $_POST['setarchivecustomformat'];
		$updatedarchivecusformat = trim($updatedarchivecusformat);
		$updatedarchivecusformat = $wpdb->escape($updatedarchivecusformat);

		$updatedarchivebefore = $_POST['setarchivecustombefore'];
		$updatedarchivebefore = trim($updatedarchivebefore);
		$updatedarchivebefore = $wpdb->escape($updatedarchivebefore);

		$updatedarchiveafter = $_POST['setarchivecustomafter'];
		$updatedarchiveafter = trim($updatedarchiveafter);
		$updatedarchiveafter = $wpdb->escape($updatedarchiveafter);

		$updatedarchivecatnumber = $_POST['setarchivecustomcatnumber'];
		$updatedarchivecatnumber = trim($updatedarchivecatnumber);
		$updatedarchivecatnumber = $wpdb->escape($updatedarchivecatnumber);

		$updatedarchivepostcount = $_POST['setarchivecustompostcount'];
		$updatedarchivepostcount = trim($updatedarchivepostcount);
		$updatedarchivepostcount = $wpdb->escape($updatedarchivepostcount);

		$updatedarchivecss = $_POST['setarchivecss'];
		$updatedarchivecss = trim($updatedarchivecss);
		$updatedarchivecss = $wpdb->escape($updatedarchivecss);

		if ($updatedarchivesize == "") {
		$updatedarchivesize = 0;
		}
		if ($updatedarchivetype == "") {
		$updatedarchivesize = 0;
		}
		if ($updatedarchivepostcount == "") {
				$updatedarchivepostcount = 0;
		}

		update_option('awsom_archive_style_info', $updatedarchivesize);
		update_option('awsom_archive_custom_name', $updatedarchivename);
		update_option('awsom_archive_type_info', $updatedarchivetype);
		update_option('awsom_archive_custom_type', $updatedarchivecustype);
		update_option('awsom_archive_custom_limit', $updatedarchivecuslimit);
		update_option('awsom_archive_custom_format', $updatedarchivecusformat);
		update_option('awsom_archive_custom_before', $updatedarchivebefore);
		update_option('awsom_archive_custom_after', $updatedarchiveafter);
		update_option('awsom_archive_custom_catnumber', $updatedarchivecatnumber);
		update_option('awsom_archive_custom_postcount', $updatedarchivepostcount);
		update_option('awsom_archive_custom_css', $updatedarchivecss);
		update_option('awsom_archive_use_default', $updatedarchivedefaultcase);
		update_option('awsom_archive_display_credit', $updatedarchivefootercredit);
		echo "<div class='updated'><p><strong>Archive updated successfully! </strong></p></div>";
		}

?>

<div class="wrap">
  <form method="post"><?php if (function_exists('wp_nonce_field')) { wp_nonce_field('adda_update_archive_options'); } ?>

  <br />

    <h2>AWSOM Archive ver. 1.5.0 Options Page</h2>

The plugin will display by default an Archive above your posts on the index page and single post pages (default archive type is a drop down box of all posts). If your Archive is not displaying the full text of your posts you can adjust the size of the archive by adding a number in pixels to the form on this page, this will
force the Archive text box to become that size in pixels.<br /><br /><a href="<?php echo $awsom_archive_get_path; ?>help_docs/known_issues.txt" style="text-decoration:none" target="_blank">Read the Known Issues file.</a> To get support or check for updates please go to <a href="http://www.awsom.org">Awsom.org</a>
<br />If you want to use the Archive in a custom location place the following code in your theme file where you want the archive to appear:
<pre>
&#60;!-- Start AWSOM Archive Output --&#62;
&#60;?php if (function_exists('display_my_awsom_archive_custom')) { display_my_awsom_archive_custom(); } ?&#62;
&#60;!-- End AWSOM Archive Output --&#62;
</pre>
<br />
You can also add the Archive to a post or page by including the code <b>&#37;&#37;awsomarchive&#37;&#37;</b> , this will make the archive appear in the post where the code is placed.
<hr>

<fieldset>
	<table border=0 cellpadding=0 cellspacing=0>
		<tr><td><b>AWSOM Archive Default Location:</b> By Default the Awsom Archive appears at the top of your Index page and Single posts pages above the first post. You can disable this and only use a custom location (using the code listed above) by switching the following setting:<br />
		  		<select name="setarchivedefaultcase">
				 <?php $currentarchivedefaultcase = get_option("awsom_archive_use_default"); ?>

				  <option value ="0" <?php if ($currentarchivedefaultcase == '0') echo "selected"; ?>>Use Default and Custom Locations</option>
				  <option value ="1" <?php if ($currentarchivedefaultcase == '1') echo "selected"; ?>>Use Only Custom Locations</option>
				   </select><a href="<?php echo $awsom_archive_get_path; ?>help_docs/default_location_setting.txt" style="text-decoration:none" target="_blank"><img src="<?php echo $awsom_archive_get_path; ?>images/help.png" border="0" align="top" title="Click here to get Help on the Default Location setting" alt="Get Help on the Default Location Setting"></a><br /><br />
  </td></tr>
		<tr><td><b>AWSOM Archive Name Customization:</b> By Default the first line of the Option box will say the name of your blog plus the word "Archives". Input a Custom name in the following box. To use the default name again leave the box empty.<br />
				<input type='text' name="setarchivename" value="<?php $currentname = get_option("awsom_archive_custom_name"); echo $currentname; ?>" style="width:440px;"><br /><br /></td></tr>


		<tr><td><b>AWSOM Archive Size Customization:</b> Add the size in pixels you would like the Archive box to appear in the text field. To remove and turn off the Custom sizing enter 0 for the size.<br />
		<input type='text' name="setarchivesize" value="<?php $currentsize = get_option("awsom_archive_style_info"); echo $currentsize; ?>" style="width:40px;"><a href="<?php echo $awsom_archive_get_path; ?>help_docs/custom_size_setting.txt" style="text-decoration:none" target="_blank"><img src="<?php echo $awsom_archive_get_path; ?>images/help.png" border="0" align="top" title="Click here to get Help on the Custom Size setting" alt="Get Help on the Custom Size Setting"></a><br /><br /></td></tr>


  <tr><td><b>AWSOM Archive CSS Customization:</b> You may add any CSS style modifications to the presentation of your Archive in the following box, and example input is <b>text-align: center;</b> . These CSS Customizations will affect the div that holds the archive. To remove and turn off the CSS Customization leave the field blank.<br />
  		<input type='text' name="setarchivecss" value="<?php $currentcssstyle = get_option("awsom_archive_custom_css"); echo $currentcssstyle; ?>" style="width:540px;"><a href="<?php echo $awsom_archive_get_path; ?>help_docs/custom_css_setting.txt" style="text-decoration:none" target="_blank"><img src="<?php echo $awsom_archive_get_path; ?>images/help.png" border="0" align="top" title="Click here to get Help on the Custom CSS setting" alt="Get Help on the Custom CSS Setting"></a><br /><br /></td></tr>


  		<tr><td><b>AWSOM Archive Type:</b> By default the AWSOM Drop Down Archive displays all posts in a Select List. You can choose other preset types, or select 'Custom' and set your own parameters below.<br />
  		<select name="setarchivetype">
		 <?php $currentarchivetype = get_option("awsom_archive_type_info"); ?>

		  <option value ="0" <?php if ($currentarchivetype == '0') echo "selected"; ?>>All Posts</option>
		  <option value ="1" <?php if ($currentarchivetype == '1') echo "selected"; ?>>Monthly</option>
		  <option value ="2" <?php if ($currentarchivetype == '2') echo "selected"; ?>>Custom</option>
		  </select><br /><br />
  </td></tr>

  <tr><td><b>AWSOM Archive Type Customization:</b> If You have selected "Custom" as your archive type in the above selection box, enter your archive customization in the following boxes. (Make sure to put each box in the Query String format, see <a href="https://developer.wordpress.org/reference/functions/wp_get_archives/" target="_blank">This Wordpress Codex page</a> for more info.)<br />The functionality for limiting or excluding categories using the custom archive type has now been integrated directly into this plugin. if you were previously using the plugin Archives for a Category for this feature you can disable that plugin.<br /><a href="<?php echo $awsom_archive_get_path; ?>help_docs/custom_archive_setting.txt" style="text-decoration:none" target="_blank"><img src="<?php echo $awsom_archive_get_path; ?>images/help.png" border="0" align="top" title="Click here to get Help on the Custom archive settings" alt="Get Help on the Custom archive Settings"></a><br />
  		<b>Type:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name="setarchivecustomtype" value="<?php  $currentcustomtype = get_option("awsom_archive_custom_type"); echo $currentcustomtype; ?>" style="width:100px;"><br />
  		<b>limit:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name="setarchivecustomlimit" value="<?php  $currentcustomlimit = get_option("awsom_archive_custom_limit"); echo $currentcustomlimit; ?>" style="width:100px;"><br />
  		<b>Format:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name="setarchivecustomformat" value="<?php  $currentcustomformat = get_option("awsom_archive_custom_format"); echo $currentcustomformat; ?>" style="width:100px;"><br />
  		<b>Before:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name="setarchivecustombefore" value="<?php  $currentcustombefore = get_option("awsom_archive_custom_before"); echo $currentcustombefore; ?>" style="width:150px;"><br />
  		<b>After:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name="setarchivecustomafter" value="<?php echo $currentcustomafter = get_option("awsom_archive_custom_after"); $currentcustomafter; ?>" style="width:150px;"><br />
  		<b>Show Post Count:</b><input type='text' name="setarchivecustompostcount" value="<?php $currentcustompostcount = get_option("awsom_archive_custom_postcount"); echo $currentcustompostcount; ?>" style="width:40px;"><br />
  		<b>Limit to Category Numbers:</b><input type='text' name="setarchivecustomcatnumber" value="<?php $currentcustomcatnumber = get_option("awsom_archive_custom_catnumber"); echo $currentcustomcatnumber; ?>" style="width:100px;"><br />
  		<br /><br /></td></tr>
<tr><td><b>AWSOM Archive Footer Credit:</b> Would you like to show your support for AWSOM.org by adding a credit to your footer to the AWSOM.org website? Not required for usage, but greatly appreciated :)<br />
  		<select name="setarchivefootercredit">
		 <?php $currentarchivefootercredit = get_option("awsom_archive_display_credit"); ?>

		  <option value ="1" <?php if ($currentarchivefootercredit == '1') echo "selected"; ?>>Yes</option>
		  <option value ="0" <?php if ($currentarchivefootercredit == '0') echo "selected"; ?>>No</option>
		   </select><br /><br />
  </td></tr>

	</table>
	<br />

</fieldset>
<div class="submit" style="text-align: left;"><input type="submit" name="awsom_archive_update" value="Update Options" /></div>

</form>
</div>

<?php
}

/* The following 2 functions adapted from Kwebble Archives for a category */

/**
 * Changes the WHERE clause for wp_get_archives to select only posts for the categories in the
 * 'cat' parameter.
 *
 * @param String $where
 *             a SQL WHERE clause.
 * @param Array $args
 *             arguments passed to the wp_get_archives() function.
 *
 * @return String
 *             modified SQL WHERE clause with additional selection by category if $args contains a
 *             parameter called cat.
 */

 function awsom_getarchives_where_for_category($where, $args){
	global $awsom_getarchives_data, $wpdb;

	if (isset($args['cat'])){
		// Preserve the category for later use.
		$awsom_getarchives_data['cat'] = $args['cat'];

		// Split 'cat' parameter in categories to include and exclude.
		$allCategories = explode(',', $args['cat']);

		// Element 0 = included, 1 = excluded.
		$categories = array(array(), array());
		foreach ($allCategories as $cat) {
			if (strpos($cat, ' ') !== FALSE) {
				// Multi category selection.
			}
			$idx = $cat < 0 ? 1 : 0;
			$categories[$idx][] = abs($cat);
		}

		$includedCatgories = implode(',', $categories[0]);
		$excludedCatgories = implode(',', $categories[1]);

		// Add SQL to perform selection.
		if (get_bloginfo('version') < 2.3){
			$where .= " AND $wpdb->posts.ID IN (SELECT DISTINCT ID FROM $wpdb->posts JOIN $wpdb->post2cat post2cat ON post2cat.post_id=ID";

			if (!empty($includedCatgories)) {
				$where .= " AND post2cat.category_id IN ($includedCatgories)";
			}
			if (!empty($excludedCatgories)) {
				$where .= " AND post2cat.category_id NOT IN ($excludedCatgories)";
			}

			$where .= ')';
		} else{
			$where .= ' AND ' . $wpdb->prefix . 'posts.ID IN (SELECT DISTINCT ID FROM ' . $wpdb->prefix . 'posts'
					. ' JOIN ' . $wpdb->prefix . 'term_relationships term_relationships ON term_relationships.object_id = ' . $wpdb->prefix . 'posts.ID'
					. ' JOIN ' . $wpdb->prefix . 'term_taxonomy term_taxonomy ON term_taxonomy.term_taxonomy_id = term_relationships.term_taxonomy_id'
					. ' WHERE term_taxonomy.taxonomy = \'category\'';
			if (!empty($includedCatgories)) {
				$where .= " AND term_taxonomy.term_id IN ($includedCatgories)";
			}
			if (!empty($excludedCatgories)) {
				$where .= " AND term_taxonomy.term_id NOT IN ($excludedCatgories)";
			}

			$where .= ')';
		}
	}

	return $where;
}



/**
 * Changes the archive link to include the categories from the 'cat' parameter.
 * 
 * @param String
 *             $url the generated URL for an archive.
 *
 * @return String
 *             modified URL that includes the category.
 */
 function awsom_archive_link_for_category($url){
	global $awsom_getarchives_data;

	if (isset($awsom_getarchives_data['cat'])){
		$url .= strpos($url, '?') === false ? '?' : '&';
		$url .= 'cat=' . $awsom_getarchives_data['cat'];
	}

	return $url;
}

function awsom_archive_create_admin()
{
    if (function_exists('add_options_page'))
		add_options_page('AWSOM Drop Down Archive Options', 'AWSOM Archive', 8, basename(__FILE__), 'awsom_archive_options');
}


function awsomarchive_TableInstall() {
   global $wpdb, $news_table_name, $awsom_archive_db_version;

$blog_title = get_bloginfo('name');
$startingsize = "0";
$startwithdefault = "0";
$showalllocations = "0";
$showfootercredit = "1";
if (!get_option('awsom_archive_db_version')) {
	update_option('awsom_archive_style_info', $startingsize);
	update_option('awsom_archive_custom_name', $blog_title." Archives");
	update_option('awsom_archive_type_info', $showalllocations);
	update_option('awsom_archive_db_version', $awsom_archive_db_version);
	update_option('awsom_archive_custom_css', "text-align: center;");
	update_option('awsom_archive_use_default', $startwithdefault);
	update_option('awsom_archive_display_credit', $showfootercredit);
}

	$installed_ver = get_option( 'awsom_archive_db_version' );
   if( $installed_ver < $awsom_archive_db_version ) {
      require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
      update_option('awsom_archive_db_version', $awsom_archive_db_version);
      update_option('awsom_archive_type_info', $showalllocations);
      update_option('awsom_archive_custom_css', "text-align: center;");
      update_option('awsom_archive_use_default', $startwithdefault);
      update_option('awsom_archive_custom_name', $blog_title." Archives");
      update_option('awsom_archive_display_credit', $showfootercredit);
  }
}

function AWSOM_Archive_Footer_Credit()
{
?>
<div id="awsomfootercredit"><!--- AWSOM Archive Footer Credit Block -->
 <a href="http://www.awsom.org" title="AWSOM Plugin Powered">AWSOM Powered</a>
</div><!--- end AWSOM Archive Footer Credit Block -->
<?php
}

function awsom_multi_loop_blocker ()
{
global $awsom_archive_displayed;

$awsom_archive_displayed = 0;
}

function awsom_reset_loop()
{
$awsom_archive_displayed = 0;
}


$awsomarchive_footercredit = get_option('awsom_archive_display_credit');
if ($awsomarchive_footercredit == "1") {
	 if (function_exists('AWSOM_Footer_Credit')){
	 remove_action('wp_footer', 'AWSOM_Footer_Credit',11);
	 }
	 if (function_exists('PixGallery_Footer_Credit')){
	 	 remove_action('wp_footer', 'PixGallery_Footer_Credit');
	 }

	add_action('wp_footer', 'AWSOM_Archive_Footer_Credit',11);
	}

$is_default_active = get_option('awsom_archive_use_default');
if ($is_default_active == "0") {

add_action('loop_start', 'display_my_awsom_archive',9);
add_action('init', 'awsom_multi_loop_blocker');
add_action('shutdown', 'awsom_reset_loop');
}
add_action('activate_awsom-drop-down-archive/awsomarchive.php','awsomarchive_TableInstall');
add_action('admin_menu',	'awsom_archive_create_admin');
add_filter('the_content','display_my_awsom_archive_inpost', 7);

/* Kwebble actions */
add_filter('getarchives_where', 'awsom_getarchives_where_for_category', 10, 2);
add_filter('year_link', 'awsom_archive_link_for_category');
add_filter('month_link', 'awsom_archive_link_for_category');
add_filter('day_link', 'awsom_archive_link_for_category');

?>