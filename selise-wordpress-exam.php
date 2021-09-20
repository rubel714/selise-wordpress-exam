<?php
/**
 * Plugin Name:       Selise Wordpress Examination
 * Description:       Selise Wordpress Examination
 * Author:            Rubel
 * Version:           1.0.0
 */
 

add_action('wp_enqueue_scripts', 'selies_contactpagefiles',999);

function selies_contactpagefiles() {
 
	wp_enqueue_script( 'customjs-script', plugins_url( '/js/customjs.js', __FILE__ ), array('jquery'), 1.0, false);
	
	wp_localize_script( 'customjs-script', 'wpgmap_ajax_object', array( 'wpgmap_ajax_url' => admin_url('admin-ajax.php')));
}

 
add_shortcode( 'contactpage',  'mycustomcontactpage');	 
 
function mycustomcontactpage(  ) {
	 return '<div style="margin: 0 auto; width: 400px"><label for="ufname">First Name</label><br/>
			<input type="text" id="ufname" name="ufname"><br/>
			<label for="ulname">Last Name</label><br/>
			<input type="text" id="ulname" name="ulname"><br/>
			<label for="uemail">Email</label><br/>
			<input type="text" id="uemail" name="uemail"><br/>
			<label for="umessage">Message</label><br/>
			<input type="text" id="umessage" name="umessage"><br/>
			<input type="button" id="postcontact"  name="postcontact" value="submit"><br/></div>';
}


add_shortcode( 'allcontactinfo',  'getallcontactinfo');	 
 
function getallcontactinfo(  ) {
	global $wpdb;
  $result = $wpdb->get_results( "SELECT * from selise_contact order by id desc;" );	 
	
	$conhtml="<table><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Message</th></tr>";
	 foreach ($result as $contactinfo) { 
		$conhtml.="<tr><td>".$contactinfo->fname."</td><td>".$contactinfo->lname."</td><td>".$contactinfo->email."</td><td>".$contactinfo->message."</td></tr>";
	 }  

	 $conhtml.="</table>";
	
	 return $conhtml;  
}


/*Start of Data Insert*/
add_action( 'wp_ajax_onWPContactDataAjax', 'onWPContactDataAjax' );

function onWPContactDataAjax() {
	global $wpdb;

	if(isset($_POST['ufname'])){$ufname = $_POST['ufname'];}else{$ufname = 'NA';} 
	if(isset($_POST['ulname'])){$ulname = $_POST['ulname'];}else{$ulname = 'NA';} 
	if(isset($_POST['uemail'])){$uemail = $_POST['uemail'];}else{$uemail = 'NA';} 
	if(isset($_POST['umessage'])){$umessage = $_POST['umessage'];}else{$umessage = 'NA';} 
	 
	$table_col_and_val = array(
		'fname' => $ufname,
		'lname' => $ulname,
		'email' => $uemail,
		'message' => $umessage
	);

	$insert = $wpdb->insert("selise_contact", $table_col_and_val);  
	if($insert){
		echo 1;
	}else{
		echo 0;
	}

	wp_die(); // this is required to terminate immediately and return a proper response
}

function create_plugin_database_table()
{
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE selise_contact (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  fname varchar(30) NOT NULL,
	  lname varchar(30) NOT NULL,
	  email varchar(30) NOT NULL,
	  message text NOT NULL,
	  PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

register_activation_hook( __FILE__, 'create_plugin_database_table' );


?>