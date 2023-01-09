<?php 

class SmShortcodesHelper
{
    
    public static function shortcode_fmff_form_ruf($atts, $content = "")
    {
        $atts = shortcode_atts( array(
            'caption' => __('Stripe Manager', 'latepoint')
        ), $atts );

        ob_start();
        include(FMFF_MANAGER_VIEWS_PARTIALS_ABSPATH . '_fmff_form_ruf.php');
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    public static function shortcode_fmff_manager_form( $atts, $content = "" ){

        $atts = shortcode_atts( array(
            'caption' => __('Stripe Manager', 'latepoint')
        ), $atts );
    
        ob_start();

        ?>
        
        <div class='card stripe-manager-content'>
            <?php 
                $current_user = wp_get_current_user();
                $stripe_customer = SmPaymentsStripeHelper::find_customer( array(  'email' => $current_user->user_email ) ); 

                if( count( $stripe_customer->data ) ):
                $last_item = $stripe_customer->data[0]; //array_slice( $stripe_customer->data , -1)[0];

                $default_payment_method = $last_item->invoice_settings->default_payment_method;
                $cards = $last_item->sources->data;
                $total_cards = count($cards);
                if($default_payment_method){
                    $card_default = array_filter($cards, function ( $card ) use($default_payment_method) {                    
                        return $card->id == $default_payment_method;
                    });
                    $card_default = array_pop($card_default);      
                }else{
                    $card_default = $cards[0];
                }
            ?>
            <div style='display: flex; align-items: center; justify-content: center;' >
                <div class='card-payment'>
                    <div class='d-flex'>      
                        <?php if($total_cards):?>
                            <div>
                                <p class='m-0'> •••• <?php echo $card_default->last4;?></p>
                            </div>
                            <div>
                                <p class='m-0'> <span class='badge badge-light'> Default</span> </p>
                            </div>      
                            <div>
                                <p class='m-0'> Expires <?php echo $card_default->exp_month."/".$card_default->exp_year;?></p>
                            </div>                      
                            <div>
                                <p id='clic_change_paymentmethod' class='m-0' style='color: darkviolet; cursor: pointer;' > change </p>
                            </div>
                        <?php else:?>
                            <div>
                                <p id='clic_change_paymentmethod' class='m-0' style='color: darkviolet; cursor: pointer;' > Register a payment method </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="form_register_card"  style="justify-content: center; padding: 1em;  display: flex; "  hidden >
                <div class="close_aaction_pm" > <span  class="pr-2 pl-2" >x </span> </div>
                <form action=""  data-sm-action="<?php echo SmRouterHelper::build_route_name('settings', 'update'); ?>"  >
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="full_name"> Full Name </label>
                        <input type="text" class="form-control" id="full_name" name="settings[name]" aria-describedby="full_name" placeholder="Enter full name">                    
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="number"> Number </label>
                        <input type="text" class="form-control" id="number" name="settings[number]" aria-describedby="number" placeholder="****** 4242">                    
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="expire_month"> Expire Month </label>
                        <input type="text" class="form-control" id="expire_month" name="settings[exp_month]" aria-describedby="expire_month" max="2" placeholder="12">                    
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="expire_year"> Expire Year </label>
                        <input type="text" class="form-control" id="expire_year" name="settings[exp_year]" aria-describedby="expire_year" max="2" placeholder="22">                    
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="ccv"> CVC </label>
                        <input type="text" class="form-control" id="cvc" name="settings[cvc]" aria-describedby="cvc" max="4" placeholder="***">                    
                    </div>  
                    <input type="hidden" name="customer[customer_id]" value="<?php echo $last_item->id; ?>" >                 
                </div>
                <div class="form-row">
                    <div class="col-sm-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-outline-secondary stripe-manager-btn">Save</button>
                    </div>
                </div>

                </form>
            </div>
            
            <?php else:?>
                <p> Not fund .... </p>
            <?php   endif; ?>
        </div>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }



}
