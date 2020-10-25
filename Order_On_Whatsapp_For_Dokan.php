<?php

/*

Plugin Name: Woocommerce Order On Whatsapp for Dokan

Plugin URI: https://codecanyon.net/user/gordonweb

Description: Increase sales by letting customers contact Vendors via Whatsapp.

Version: 1.0

Author: Gordon

Author URI: https://codecanyon.net/user/gordonweb

License: Commercial License

*/


// create custom plugin settings menu
add_action('admin_menu', 'order_on_whatsapp_submenu');


//*********************************************************************************************************************************************************************************************************************
//* Admin Menu and Settings
//***********************************************************************
function order_on_whatsapp_submenu() {
	//create the admin menu for plugin district if not exists
	global $menu;
	$menuExist = false;
	foreach($menu as $item) {
		if(strtolower($item[0]) == strtolower('orderonwhatsapp')) {
			$menuExist = true;
		}
	}
	if(!$menuExist)

 add_menu_page('string page_title', 'Whatsapp', 0, 'orderonwhatsapp-dashboard', 'orderonwhatsapp_continueshopping_settings_page',plugins_url('/img/logo.png', __FILE__));
	//call register settings function
	add_action( 'admin_init', 'register_orderonwhatsapp_settings' );
}




function register_orderonwhatsapp_settings() {
	//register our settings
	register_setting( 'orderonwhatsapp-settings-group', 'orderonwhatsapp_Beginning_message' );
	register_setting( 'orderonwhatsapp-settings-group', 'orderonwhatsapp_phone_number' );
}

function orderonwhatsapp_continueshopping_settings_page() {
	?>
	<div class="postbox-container" style="min-width:400px; max-width:600px; padding: 0 20px 0 0;">
	<h2>Whatsapp Settings</h2>
			<hr>
	<?php if( isset($_GET['settings-updated']) ) { ?>
		<div id="message" class="updated">
			<p><strong><?php _e('Settings saved.') ?></strong></p>
		</div>
	<?php } ?>
		<form method="post" action="options.php">
		<?php settings_fields( 'orderonwhatsapp-settings-group' ); ?>
		<?php do_settings_sections( 'orderonwhatsapp-settings-group' ); ?>
		<table class="form-table">
						<tr valign="top">


			<tr valign="top">
			<th scope="row">Enter Message to appear on the WhatsApp conversation (E.g: Hi, I have a question about this product ):</th>
			<td><input type="textbox" style="width:350px;" name="orderonwhatsapp_Beginning_message" value="<?php echo get_option('orderonwhatsapp_Beginning_message'); ?>" /></td>
			</tr>

		</table>

		<?php submit_button(); ?>

	</form>
	</div>

<?php }


// Shortcode to use

add_shortcode("Product_Templates_Mirror_display", "Product_Templates_Mirror_display");




function custom_woocommerce_before_cart() {



// Get the author ID (the vendor ID) and phone number
$vendor_id = get_post_field( 'post_author', get_the_id() );
$vendor = dokan()->vendor->get( $vendor_id );
$phone = $vendor->get_phone();

	$text = get_option('orderonwhatsapp_Beginning_message');
	$number = $phone;

		  $urlimgthumb= wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
			$product_title= get_the_title();
      $productx = get_page_by_title( $product_title, OBJECT,'product' );
      $product_height = get_post_meta( $productx->ID,'_my_meta_value_keyyQ',true );
      $product_width = get_post_meta( $productx->ID,'_my_meta_value_key',true );
      $urlp = get_permalink(get_the_ID());

   		$urlimg=  plugins_url('img/buttontryeiton.png',__FILE__) ;
  		$urldelimg=  plugins_url('img/buttovntryeiton.png',__FILE__) ;
  		$product_url=get_post_meta( get_the_ID(),'_my_meta_value_keyy',true );

      $product = wc_get_product();
      $id = $product->get_id();



		echo"
		<form style='margin-bottom:18%' >
		​<textarea id='zipfieldw' name='zip' rows='5' cols='70' style='display:none'>$product_width</textarea>
		​<textarea id='zipfieldh' name='zip' rows='5' cols='70' style='display:none'>$product_height</textarea>
		​<textarea id='zipfieldl' name='ziplink' rows='5' cols='70' style='display:none' >$urlp</textarea>
    <ul class='tshirts'>

		<a href='https://api.whatsapp.com/send?phone=$number&text=$text%20$product_title:%20$urlp'>

    <li style='float: left; list-style:none !important;'>
   	    <img id='scrapy' type='image' src='$urlimg' border='0' style='margin-left:7%;' value='$product_title' ></img>
   </li>
   </a>
   </ul>
	 </form>";
	 }

add_action( 'woocommerce_after_add_to_cart_form' , 'custom_woocommerce_before_cart', 10, 2 );
