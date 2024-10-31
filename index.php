<?php

/*
Plugin Name: Remove_n_Disable
Plugin URI: http://www.mediafire.com/?dhku3ilcdj3y3rv
Description: This plugin has several options to disable/enable several links from wordpress dashboard, disable browser update warning, wordpress core update etc. This plugin's option will be found under settings named as R_n_D.
Author: KF Elahi
Author URI: http://kfelahi.wordpress.com/
Version: 1.0
License: GPL2

The license under which the WordPress software is released is the GPLv2 (or later) from the Free Software Foundation. A copy of the license is included with every copy of WordPress, but you can also read the text of the license here.

Part of this license outlines requirements for derivative works, such as plugins or themes. Derivatives of WordPress code inherit the GPL license. Drupal, which has the same GPL license as WordPress, has an excellent page on licensing as it applies to themes and modules (their word for plugins).

There is some legal grey area regarding what is considered a derivative work, but we feel strongly that plugins and themes are derivative work and thus inherit the GPL license. If you disagree, you might want to consider a non-GPL platform such as Serendipity (BSD license) or Habari (Apache license) instead.
 */


register_activation_hook(__FILE__, 'adding_option');
add_action('admin_menu','impo_ten_create');
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );


function replace_footer_admin()   
{  
    echo '<span id="footer-thankyou"></span>';  

}  

function replace_footer_version() 
{
	return '';
}

function disable_browser_upgrade_warning() {
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
}

function adding_option()
{

    global $ini_settings;
    $ini_settings = array(
        'wp_logo_remove' => '',
        'remove_about'=>'',
        'remove_org'=>'',
        'remove_documentation'=>'',
        'remove_support_forum'=>'',
        'remove_feedback'=>'',
        'remove_view_site'=>'',
        'remove_footer_version'=>'',
        'remove_footer_text' =>'',
        'disable_browser_upgrade_warning' => '',
        'disable_wordpress_update' => ''
        
    );
    add_option('c_box', $ini_settings);

}

function wps_admin_bar() {

    global $wp_admin_bar;
    $alter_set = get_option('c_box');
    //var_dump($alter_set) ;
    
    if($alter_set['remove_footer_version'] !='')
        add_filter( 'update_footer', 'replace_footer_version',212);
    
    if($alter_set['remove_footer_text'] != '')
        add_filter('admin_footer_text', 'replace_footer_admin');
    
    if($alter_set['disable_browser_upgrade_warning'] != '')
         add_action( 'wp_dashboard_setup', 'disable_browser_upgrade_warning' );
    
    if($alter_set['disable_wordpress_update'] != '')
        add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
    
    if($alter_set['wp_logo_remove'] != '')
     $wp_admin_bar->remove_menu('wp-logo');
    
    if($alter_set['remove_about'] != '')
     $wp_admin_bar->remove_menu('about');
    
    if($alter_set['remove_org'] != '')
    $wp_admin_bar->remove_menu('wporg');
    
    if($alter_set['remove_documentation'] != '')
    $wp_admin_bar->remove_menu('documentation');
    
    if($alter_set['remove_support_forum'] != '')
    $wp_admin_bar->remove_menu('support-forums');
    
    if($alter_set['remove_feedback'] != '')
    $wp_admin_bar->remove_menu('feedback');
    
    if($alter_set['remove_view_site'] != '')
    $wp_admin_bar->remove_menu('view-site');


}

function impo_ten_create()
{
    add_options_page('remove and desable', 'R_n_D', 'manage_options', 'r_n_d_slug', 'impo_ten_page_function');
}

function impo_ten_page_function()
{
    if ( !empty($_POST) && check_admin_referer('many_remover','many_remover_nonce') )
    {
        $ini_setttings = get_option('c_box');
        var_dump($_POST);
        
        foreach ($_POST as $key => $value) {
            if($value == 'on')
            {
                $ini_settings[$key] = 'checked = "checked"';
            }
            else { 
                if(in_array($key, $ini_setttings))
                 $ini_settings[$key] = '';
            }
        }
            var_dump($ini_settings);
        update_option('c_box', $ini_settings);

     ?>

<script type="text/javascript">
    location.reload();
</script>
<?php

      
    }
    
    $prev_set = get_option('c_box');
    ?>
<?php screen_icon();?> <h1>Remove and Disable Settings</h1><br />
<div class="wrapper">

    <fieldset>
        <form action="" method="post">
            <?php wp_nonce_field('many_remover', 'many_remover_nonce');?>
            <label for="wp_logo_remove">
                <input type="checkbox" name="wp_logo_remove" <?php echo $prev_set['wp_logo_remove'];?>/> 
                Remove Wp Logo
			</label>
           	<br/>
            <label for="remove_about">
    	        <input type="checkbox" name="remove_about" <?php echo $prev_set['remove_about'];?>/>   
	                Remove About Link
            </label>
            
            <br />
            <label for="remove_org">
		<input type="checkbox" name="remove_org" <?php echo $prev_set['remove_org'];?>/> 
		 Remove Org Link
            </label>
            <br />
			
            <label for="remove_documentation">
            	<input type="checkbox" name="remove_documentation" <?php echo $prev_set['remove_documentation'];?>/>
                Remove Documentation Link
            </label>
            <br />

			<label for="remove_support_forum">
            	<input type="checkbox" name="remove_support_forum" <?php echo $prev_set['remove_support_forum'];?>/>
                Remove support forum Link
            </label>
            <br />


		<label for="remove_feedback">
            	<input type="checkbox" name="remove_feedback" <?php echo $prev_set['remove_feedback'];?>/>
                Remove Feedback Link
            </label>
            <br />

            <label for="remove_view_site">
            	<input type="checkbox" name="remove_view_site" <?php echo $prev_set['remove_view_site'];?>/>
                Remove View Site Link
            </label>
            <br />

            <label for="remove_footer_version">
            	<input type="checkbox" name="remove_footer_version" <?php echo $prev_set['remove_footer_version'];?>/>
                Remove Footer Version
            </label>
            <br />
            
            <label for="remove_footer_text">
            	<input type="checkbox" name="remove_footer_text" <?php echo $prev_set['remove_footer_text'];?>/>
                Remove Footer Text
            </label>
            <br />
            
            <label for="disable_browser_upgrade_warning">
            	<input type="checkbox" name="disable_browser_upgrade_warning" <?php echo $prev_set['disable_browser_upgrade_warning'];?>/>
                Disable Browser Upgrade Warning
            </label>
            <br />
            
             <label for="disable_wordpress_update">
            	<input type="checkbox" name="disable_wordpress_update" <?php echo $prev_set['disable_wordpress_update'];?>/>
                Disable Wordpress Update
            </label>
            <br />
            
            <input type="submit" value="save" name="submit" />
      </form>
  </fieldset>
</div>
<?php
}


?>