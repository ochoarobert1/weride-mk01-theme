<?php
/* WOOCOMMERCE CUSTOM COMMANDS */

/* WOOCOMMERCE - DECLARE THEME SUPPORT - BEGIN */
add_action('after_setup_theme', 'weride_woocommerce_support');
function weride_woocommerce_support()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
/* WOOCOMMERCE - DECLARE THEME SUPPORT - END */

/* WOOCOMMERCE - CUSTOM WRAPPER - BEGIN */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'weride_woocommerce_custom_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'weride_woocommerce_custom_wrapper_end', 10);

function weride_woocommerce_custom_wrapper_start()
{
    echo '<section id="main" class="container-fluid p-0"><div class="row no-gutters"><div class="woocustom-main-container col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
}

function weride_woocommerce_custom_wrapper_end()
{
    echo '</div></div></section>';
}
/* WOOCOMMERCE - CUSTOM WRAPPER - END */

/* WOOCOMMERCE - ARCHIVE PRODUCT - START */
//remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/* WOOCOMMERCE - ARCHIVE PRODUCT - END */

/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a href="<?php echo wc_get_cart_url(); ?>" class="cart-customlocation"><i class="fa fa-shopping-bag"></i><span class="badge badge-success"><?php echo WC()->cart->get_cart_contents_count(); ?></span> <span class="cart-total"><?php echo WC()->cart->get_cart_total(); ?></span></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}


/* WOOCOMMERCE - CUSTOM CONTENT PRODUCT - SHOP - START */
//remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
//remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
//remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
//remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
/* WOOCOMMERCE - CUSTOM CONTENT PRODUCT - SHOP - END */


/* WOOCOMMERCE - SINGLE PRODUCT - START */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
/* WOOCOMMERCE - SINGLE PRODUCT - END */


/* Replace text of Sale! badge with percentage */

add_filter('woocommerce_sale_flash', 'ds_replace_sale_text');

function ds_replace_sale_text($text)
{
    global $product;
    $stock = $product->get_stock_status();
    $product_type = $product->get_type();
    $sale_price  = 0;
    $regular_price = 0;
    if ($product_type == 'variable') {
        $product_variations = $product->get_available_variations();
        foreach ($product_variations as $kay => $value) {
            if ($value['display_price'] < $value['display_regular_price']) {
                $sale_price = $value['display_price'];
                $regular_price = $value['display_regular_price'];
            }
        }
        if ($regular_price > $sale_price && $stock != 'outofstock') {
            $product_sale = intval(((intval($regular_price) - intval($sale_price)) / intval($regular_price)) * 100);
            if ($product_sale > 5) {
                return '<span class="onsale"> <span class="sale-icon" aria-hidden="true" data-icon="&#xe0da"></span> - ' . $product_sale . '%</span>';
            }
            if ($product_sale <= 5) {
                return '<span class="onsale"> <span class="sale-icon" aria-hidden="true" data-icon="&#xe0da"></span>Sale!</span>';
            }
        } else {
            return  '';
        }
    } else {
        $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
        $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
        if ($regular_price > 5) {
            $product_sale = intval(((intval($regular_price) - intval($sale_price)) / intval($regular_price)) * 100);
            return '<span class="onsale"> <span class="sale-icon" aria-hidden="true" data-icon="&#xe0da"></span> - ' . $product_sale . '%</span>';
        }
        if ($regular_price >= 0 && $regular_price <= 5) {
            $product_sale = intval(((intval($regular_price) - intval($sale_price)) / intval($regular_price)) * 100);
            return '<span class="onsale"> <span class="sale-icon" aria-hidden="true" data-icon="&#xe0da"></span>Sale!</span>';
        } else {
            return '';
        }
    }
}


add_action( 'woocommerce_before_add_to_cart_quantity', 'bbloomer_display_quantity_plus' );
  
function bbloomer_display_quantity_plus() {
   echo '<button type="button" class="plus" >+</button>';
}
  
add_action( 'woocommerce_after_add_to_cart_quantity', 'bbloomer_display_quantity_minus' );
  
function bbloomer_display_quantity_minus() {
   echo '<button type="button" class="minus" >-</button>';
}
 
// Note: to place minus @ left and plus @ right replace above add_actions with:
// add_action( 'woocommerce_before_add_to_cart_quantity', 'bbloomer_display_quantity_minus' );
// add_action( 'woocommerce_after_add_to_cart_quantity', 'bbloomer_display_quantity_plus' );
  
// -------------
// 2. Trigger jQuery script
  
add_action( 'wp_footer', 'bbloomer_add_cart_quantity_plus_minus' );
  
function bbloomer_add_cart_quantity_plus_minus() {
   // Only run this on the single product page
   if ( ! is_product() ) return;
   ?>
      <script type="text/javascript">
           
      jQuery(document).ready(function($){   
           
         $('form.cart').on( 'click', 'button.plus, button.minus', function() {
  
            // Get current quantity values
            var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
            var val   = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));
  
            // Change the value if plus or minus
            if ( $( this ).is( '.plus' ) ) {
               if ( max && ( max <= val ) ) {
                  qty.val( max );
               } else {
                  qty.val( val + step );
               }
            } else {
               if ( min && ( min >= val ) ) {
                  qty.val( min );
               } else if ( val > 1 ) {
                  qty.val( val - step );
               }
            }
              
         });
           
      });
           
      </script>
   <?php
}