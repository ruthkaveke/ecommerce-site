<?php
/**
 * Shopping Cart Widget
 *
 * Displays shopping cart widget
 *
 * @author 		YIThemes
 * @extends 	WP_Widget
 */
class YIT_Widget_Cart extends WP_Widget {

	var $woo_widget_cssclass;
	var $woo_widget_description;
	var $woo_widget_idbase;
	var $woo_widget_name;

	/**
	 * constructor
	 *
	 * @access public
	 * @return void
	 */
	function YIT_Widget_Cart() {

		/* Widget variable settings. */
		$this->woo_widget_cssclass 		= 'woocommerce widget_shopping_cart widget';
		$this->woo_widget_description 	= __( "Display the user's Cart in the header of the page. Note: the widget can be used only in the header.", 'yit' );
		$this->woo_widget_idbase 		= 'yit_widget_cart';
		$this->woo_widget_name 			= __( 'YIT Cart', 'yit' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );

		/* Create the widget. */
		$this->WP_Widget( 'shopping_cart', $this->woo_widget_name, $widget_ops );
	}


	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		global $woocommerce;

		extract( $args );

        if( !is_shop_installed() ) return;
        ?>
        <div class="yit_cart_widget widget_shopping_cart">
    		<div class="cart_label">
                <?php list( $cart_items, $cart_subtotal, $cart_currency ) = yit_get_current_cart_info(); ?>
                <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="cart-items">
                <span class="cart-items-number"><?php echo $cart_items ?></span> <?php echo $cart_items != 1 ? __('Items', 'yit') : __('Item', 'yit') ?>
                </a>
            </div>

            <div class="cart_wrapper" style="display:none">
                <div class="widget_shopping_cart_content group">
                    <ul class="cart_list product_list_widget">
                        <li class="empty"><?php _e( 'No products in the cart.', 'yit' ); ?></li>
                    </ul>
                </div>
            </div>

            <script type="text/javascript">
            jQuery(document).ready(function($){
                $(document).on('mouseover', '.cart_label', function(){
                    $(this).next('.cart_wrapper').fadeIn(300);
                }).on('mouseleave', '.cart_label', function(){
                    $(this).next('.cart_wrapper').fadeOut(300);
                });

                $(document)
                    .on('mouseenter', '.cart_wrapper', function(){ $(this).stop(true,true).show() })
                    .on('mouseleave', '.cart_wrapper',  function(){ $(this).fadeOut(300) });
            });
            </script>
        </div>
		<?php
	}


	/**
	 * update function.
	 *
	 * @see WP_Widget->update
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['hide_if_empty'] = empty( $new_instance['hide_if_empty'] ) ? 0 : 1;
		return $instance;
	}


	/**
	 * form function.
	 *
	 * @see WP_Widget->form
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		?>
        <p><?php _e('Display a dropdown cart for your WooCommerce store. This widget can be used only in Topbar Right Sidebar.', 'yit') ?></p>
		<?php
	}

}