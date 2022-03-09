<div class="woocommerce">
      <div class="woocommerce-order">
            <?php do_action('woocommerce_before_thankyou', $this->order->get_id());?>
                  
            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), $this->order); ?></p>

            <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                  <li class="woocommerce-order-overview__order order">
                        <?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
                        <strong><?php echo $this->order->get_order_number(); ?></strong>
                  </li>

                  <li class="woocommerce-order-overview__date date">
                        <?php esc_html_e( 'Date:', 'woocommerce' ); ?>
                        <strong><?php echo wc_format_datetime( $this->order->get_date_created() ); ?></strong>
                  </li>

                  <?php if ( is_user_logged_in() && $this->order->get_user_id() === get_current_user_id() && $this->order->get_billing_email() ) : ?>
                        <li class="woocommerce-order-overview__email email">
                              <?php esc_html_e( 'Email:', 'woocommerce' ); ?>
                              <strong><?php echo $this->order->get_billing_email(); ?></strong>
                        </li>
                  <?php endif; ?>

                  <li class="woocommerce-order-overview__total total">
                        <?php esc_html_e( 'Total:', 'woocommerce' ); ?>
                        <strong><?php echo $this->order->get_formatted_order_total(); ?></strong>
                  </li>

                  <?php if ( $this->order->get_payment_method_title() ) : ?>
                        <li class="woocommerce-order-overview__payment-method method">
                              <?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
                              <strong><?php echo wp_kses_post( $this->order->get_payment_method_title() ); ?></strong>
                        </li>
                  <?php endif; ?>
            </ul>

            <?php do_action('woocommerce_thankyou_' . $this->order->get_payment_method(), $this->order->get_id()); ?>
            <?php do_action('woocommerce_thankyou', $this->order->get_id()); ?>
      </div>
</div>