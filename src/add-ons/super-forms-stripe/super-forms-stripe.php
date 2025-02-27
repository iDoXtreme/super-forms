<?php
/**
 * Super Forms - Stripe
 *
 * @package   Super Forms - Stripe
 * @author    feeling4design
 * @link      http://codecanyon.net/user/feeling4design
 * @copyright 2016 by feeling4design
 *
 * @wordpress-plugin
 * Plugin Name: Super Forms - Stripe
 * Plugin URI:  http://codecanyon.net/user/feeling4design
 * Description: Charge your customers with Stripe
 * Version:     1.0.0
 * Author:      feeling4design
 * Author URI:  http://codecanyon.net/user/feeling4design
 * Text Domain: super-forms
 * Domain Path: /i18n/languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


if(!class_exists('SUPER_Stripe')) :


    /**
     * Main SUPER_Stripe Class
     *
     * @class SUPER_Stripe
     * @version 1.0.0
     */
    final class SUPER_Stripe {
    
        
        /**
         * @var string
         *
         *  @since      1.0.0
        */
        public $version = '1.0.0';


        /**
         * @var string
         *
         *  @since      1.0.0
        */
        public $add_on_slug = 'stripe';
        public $add_on_name = 'Stripe';

        
        /**
         * @var SUPER_Stripe The single instance of the class
         *
         *  @since      1.0.0
        */
        protected static $_instance = null;

        
        /**
         * Main SUPER_Stripe Instance
         *
         * Ensures only one instance of SUPER_Stripe is loaded or can be loaded.
         *
         * @static
         * @see SUPER_Stripe()
         * @return SUPER_Stripe - Main instance
         *
         *  @since      1.0.0
        */
        public static function instance() {
            if(is_null( self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }


        /**
         * SUPER_Stripe Constructor.
         *
         *  @since      1.0.0
        */
        public function __construct(){
            $this->includes();
            $this->init_hooks();
            do_action('super_stripe_loaded');
        }

        
        /**
         * Include required core files used in admin and on the frontend.
         *
         *  @since      1.0.0
        */
        public function includes(){


        }


        /**
         * Define constant if not already set
         *
         * @param  string $name
         * @param  string|bool $value
         *
         *  @since      1.0.0
        */
        private function define($name, $value){
            if(!defined($name)){
                define($name, $value);
            }
        }

        
        /**
         * What type of request is this?
         *
         * string $type ajax, frontend or admin
         * @return bool
         *
         *  @since      1.0.0
        */
        private function is_request($type){
            switch ($type){
                case 'admin' :
                    return is_admin();
                case 'ajax' :
                    return defined( 'DOING_AJAX' );
                case 'cron' :
                    return defined( 'DOING_CRON' );
                case 'frontend' :
                    return (!is_admin() || defined('DOING_AJAX')) && ! defined('DOING_CRON');
            }
        }

        
        /**
         * Hook into actions and filters
         *
         *  @since      1.0.0
        */
        private function init_hooks() {
            add_action( 'init', array( $this, 'load_plugin_textdomain' ), 0 );
            add_filter( 'super_shortcodes_after_form_elements_filter', array( $this, 'add_stripe_element' ), 10, 2 );
            add_action( 'wp_head', array( $this, 'stripe_ipn'));
            if ( $this->is_request( 'admin' ) ) {
                add_filter( 'super_settings_after_smtp_server_filter', array( $this, 'add_settings' ), 10, 2 );
                add_action( 'init', array( $this, 'update_plugin' ) );
                add_action( 'all_admin_notices', array( $this, 'display_activation_msg' ) );
            }
            if ( $this->is_request( 'ajax' ) ) {
            }

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			//add_filter( 'super_common_js_dynamic_functions_filter', array( $this, 'add_dynamic_function' ), 110, 2 );
        
            //add_action( 'super_before_sending_email_hook', array( $this, 'stripe_request' ) );
            //add_action( 'super_before_email_success_msg_action', array( $this, 'create_source' ) );
            //add_action( 'super_before_sending_email_hook', array( $this, 'create_source' ) );
            add_filter( 'super_redirect_url_filter', array( $this, 'stripe_redirect' ), 10, 2 );

            //$settings = apply_filters( 'super_before_sending_email_settings_filter', $settings );
            //$redirect = apply_filters( 'super_redirect_url_filter', $redirect, array( 'data'=>$data, 'settings'=>$settings ) );

        }

        /**
         * Redirect to Stripe Checkout page
         *
         * @since       1.0.0
         */
        public function stripe_redirect($redirect, $atts) {
            $settings = $atts['settings'];
            $data = $atts['data'];
            // Check if Stripe checkout is enabled
            if($settings['stripe_checkout']=='true'){
                // If enabled determine what checkout method was choosen by the end user
                if( (!empty($data['stripe_ideal'])) && (!empty($data['stripe_ideal']['value'])) ) {
                    $bank = sanitize_text_field($data['stripe_ideal']['value']);
                    $amount = SUPER_Common::email_tags( $settings['stripe_amount'], $data, $settings );
                    // Create Source for iDeal payment
                    $url = 'https://api.stripe.com/v1/sources';
                    $response = wp_remote_post( 
                        $url, 
                        array(
                            'timeout' => 45,
                            'headers'=>array(
                                'Authorization' => 'Bearer sk_test_CczNHRNSYyr4TenhiCp7Oz05'
                            ),                      
                            'body' => array(
                                'type' => 'ideal',
                                'currency' => 'eur', // iDeal only supports EUR currency
                                'amount' => SUPER_Common::tofloat($amount)*100, // The amount to charge times hundred (because amount is in cents)
                                'ideal' => array(
                                    'bank' => $bank
                                ),
                                'statement_descriptor' => 'TEST STATEMENT 1234',
                                'owner' => array(
                                    'name' => 'Rens Tillmann',
                                    'email' => 'jenny.rosen@example.com'
                                ),
                                'redirect' => array(
                                    'return_url' => 'https://f4d.nl/dev' // Required for iDeal Source
                                )
                            )
                        )
                    );
                    if ( is_wp_error( $response ) ) {
                        $error_message = $response->get_error_message();
                    } else {
                        $obj = json_decode($response['body']);
                        return $obj->redirect->url;
                    }
                }else{
                    if(!isset($data['stripe_ideal'])){
                        SUPER_Common::output_error(
                            $error = true,
                            $msg = sprintf( esc_html__( 'No element found named %sstripe_ideal%s. Please make sure your Stripe iDeal element is named %sstripe_ideal%s.', 'super-forms' ), '<strong>', '</strong>', '<strong>', '</strong>' )
                        ); 
                    }else{
                        SUPER_Common::output_error(
                            $error = true,
                            $msg = esc_html__( 'Please choose a bank.', 'super-forms' )
                        );             
                    }
                }
            }
            return $redirect;
        }


        /**
         * Create Stripe Source
         *
         * @since       1.0.0
         */
        public function create_source($atts) {
            $settings = $atts['settings'];
            $data = $atts['post']['data'];
            // Check if Stripe checkout is enabled
            if($settings['stripe_checkout']=='true'){
                // If enabled determine what checkout method was choosen by the end user
                if( (!empty($data['stripe_ideal'])) && (!empty($data['stripe_ideal']['value'])) ) {
                    var_dump('Bank:');
                    var_dump($data['stripe_ideal']['value']);
                    // Create Source for iDeal payment
                    $url = 'https://api.stripe.com/v1/sources';
                    $response = wp_remote_post( 
                        $url, 
                        array(
                            'timeout' => 45,
                            'headers'=>array(
                                'Authorization' => 'Bearer sk_test_CczNHRNSYyr4TenhiCp7Oz05'
                            ),                      
                            'body' => array(
                                'type' => 'ideal',
                                'currency' => 'eur', // iDeal only supports EUR currency
                                'amount' => 15*100, // The amount to charge times hundred (because amount is in cents)
                                'owner' => array(
                                    'name' => 'Rens Tillmann',
                                    'email' => 'jenny.rosen@example.com'
                                ),
                                'redirect' => array(
                                    'return_url' => 'https://f4d.nl/dev' // Required for iDeal Source
                                )
                            )
                        )
                    );
                    if ( is_wp_error( $response ) ) {
                        $error_message = $response->get_error_message();
                        var_dump($error_message);
                    } else {
                        $obj = json_decode($response['body']);
                        var_dump($obj);
                        //$obj->redirect->url
                    }

                    // require_once( 'stripe-php/init.php' );
                    // $token = sanitize_text_field($data['_stripe_token']['value']);
                    // var_dump($token);
                    // \Stripe\Stripe::setApiKey("sk_test_CczNHRNSYyr4TenhiCp7Oz05");
                    // $response = \Stripe\Customer::create([
                    //   'description' => "Customer for feeling4design@gmail.com",
                    //   'email' => 'feeling4design@gmail.com',
                    //   'source' => $token // obtained with Stripe.js
                    // ]);
                    // var_dump($response);

                }else{
                    if(!isset($data['stripe_ideal'])){
                        SUPER_Common::output_error(
                            $error = true,
                            $msg = sprintf( esc_html__( 'No element found named %sstripe_ideal%s. Please make sure your Stripe iDeal element is named %sstripe_ideal%s.', 'super-forms' ), '<strong>', '</strong>', '<strong>', '</strong>' )
                        ); 
                    }else{
                        SUPER_Common::output_error(
                            $error = true,
                            $msg = esc_html__( 'Please choose a bank.', 'super-forms' )
                        );             
                    }
                }
            }
            exit;

            // $data = $atts['post']['data'];
            // $settings = $atts['settings'];
            // if(!empty($data['_stripe_token'])){
            //     require_once( 'stripe-php/init.php' );
            //     $token = sanitize_text_field($data['_stripe_token']['value']);
            //     var_dump($token);
            //     \Stripe\Stripe::setApiKey("sk_test_CczNHRNSYyr4TenhiCp7Oz05");
            //     $response = \Stripe\Customer::create([
            //       'description' => "Customer for feeling4design@gmail.com",
            //       'email' => 'feeling4design@gmail.com',
            //       'source' => $token // obtained with Stripe.js
            //     ]);
            //     var_dump($response);
            // }

        }


        /**
         * Stripe IPN (better know as WebHooks handler)
         *
         * @since       1.0.0
         */
        public function stripe_ipn() {

            if( !empty($_GET['client_secret']) ) {
            	$status = $GLOBALS['stripe_obj']->status;

            	// canceled == payment was canceled
            	// pending == payment method can take up to a few days to be processed
	            // chargeable == waiting for bank to process payment
	            // failed == canceled by user or due to other reason
	            // consumed == completed

	            ?>
				<div class="verifying-payment">
					<div class="wrapper">
						<svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink">
							<circle class="border" cx="42" cy="42" r="40" stroke-linecap="round" stroke-width="4" stroke="#000" fill="none"></circle>
						</svg>
						<div class="caption verifying">
							<div class="title">
								<svg width="34px" height="34px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink"></svg>
								<span>Verifying payment...</span>
							</div>
						</div>
					</div>
				</div>
	            <?php
        		die();
            }

            if ((isset($_GET['page'])) && ($_GET['page'] == 'super_stripe_ipn')) {
                require_once( 'stripe-php/init.php' );
                // Set your secret key: remember to change this to your live secret key in production
                // See your keys here: https://dashboard.stripe.com/account/apikeys
                \Stripe\Stripe::setApiKey('sk_test_CczNHRNSYyr4TenhiCp7Oz05');
                // You can find your endpoint's secret in your webhook settings
                $endpoint_secret = 'whsec_ghatJ98Av3MmvhHiWHZ9DJfaJ8qEGj6n';
                $payload = @file_get_contents('php://input');
                $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
                $event = null;
                try {
                    $event = \Stripe\Webhook::constructEvent(
                        $payload, $sig_header, $endpoint_secret
                    );
                } catch(\UnexpectedValueException $e) {
                    // Invalid payload
                    http_response_code(400);
                    exit();
                } catch(\Stripe\Error\SignatureVerification $e) {
                    // Invalid signature
                    http_response_code(400);
                    exit();
                }


                // WebHook responses:
                // source.chargeable - A Source object becomes chargeable after a customer has authenticated and verified a payment.   
                // @Todo: Create a Charge.

                // source.failed - A Source object failed to become chargeable as your customer declined to authenticate the payment.  
                // @Todo: Cancel the order and optionally re-engage the customer in your payment flow.

                // source.canceled - A Source object expired and cannot be used to create a charge.  
                // @Todo: Cancel the order and optionally re-engage the customer in your payment flow.

                // charge.pending - The Charge is pending (asynchronous payments only). 
                // @Todo: Nothing to do.

                // charge.succeeded - The Charge succeeded and the payment is complete.
                // @Todo: Finalize the order and send a confirmation to the customer over email.
                
                // charge.failed - The Charge has failed and the payment could not be completed.
                // @Todo: Cancel the order and optionally re-engage the customer in your payment flow.

                // Handle the event
                switch ($event->type) {

                    case 'source.chargeable':
                        // A Source object becomes chargeable after a customer has authenticated and verified a payment.   
                        // @Todo: Create a Charge.
                        // @Message: Your order was received and is awaiting payment confirmation.
                        $charge = \Stripe\Charge::create([
                          'amount' => $event->data->object->amount, // e.g: 1099,
                          'currency' => $event->data->object->currency, // e.g: 'eur',
                          'source' => $event->data->object->id // e.g: 'src_18eYalAHEMiOZZp1l9ZTjSU0',
                        ]);
                        break;

                    case 'source.failed':
                        // A Source object failed to become chargeable as your customer declined to authenticate the payment.
                        // @Todo: Cancel the order and optionally re-engage the customer in your payment flow.
                        // @Message: Your payment failed and your order couldn’t be processed.
                        break;

                    case 'source.canceled':
                        // A Source object expired and cannot be used to create a charge.
                        // @Todo: Cancel the order and optionally re-engage the customer in your payment flow.
                        // @Message: Your payment failed and your order couldn’t be processed.
                        break;

                    case 'source.pending':
                        // @Message: Your order was received and is awaiting payment confirmation.


                    case 'charge.succeeded':
                        // The Charge succeeded and the payment is complete.
                        // @Todo: Finalize the order and send a confirmation to the customer over email.
                        // @Message: Your payment is confirmed and your order is complete.
                        break;

                    case 'charge.failed':
                        // The Charge has failed and the payment could not be completed.
                        // @Todo: Cancel the order and optionally re-engage the customer in your payment flow.
                        // @Message: Your payment failed and your order couldn’t be processed.
                        break;

                    case 'charge.pending':
                        // The Charge is pending (asynchronous payments only)
                        // @Todo: Nothing to do.
                        // @Message: Your order was received and is awaiting payment confirmation.
                        break;

                    default:
                        // Unexpected event type
                        http_response_code(400);
                        exit();
                        
                }
                http_response_code(200);
                die();
            }
        }


        /**
         * Hook into elements and add Stripe element
         *
         *  @since      1.0.0
        */
        public static function stripe_request( $atts ) {
            // \Stripe\Stripe::setApiKey("pk_test_1i3UyFAuxbe3Po62oX1FV47U");

            // $endpoint = \Stripe\WebhookEndpoint::create([
            //   "url" => "https://example.com/my/webhook/endpoint",
            //   "enabled_events" => ["charge.failed", "charge.succeeded"]
            // ]);

            $data = $atts['post']['data'];
            $settings = $atts['settings'];
            if(!empty($data['_stripe_token'])){
                require_once( 'stripe-php/init.php' );
                $token = sanitize_text_field($data['_stripe_token']['value']);
                var_dump($token);
                \Stripe\Stripe::setApiKey("sk_test_CczNHRNSYyr4TenhiCp7Oz05");
                $response = \Stripe\Customer::create([
                  'description' => "Customer for feeling4design@gmail.com",
                  'email' => 'feeling4design@gmail.com',
                  'source' => $token // obtained with Stripe.js
                ]);
                var_dump($response);
            }


            // Set your secret key: remember to change this to your live secret key in production
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            // \Stripe\Stripe::setApiKey('sk_test_CczNHRNSYyr4TenhiCp7Oz05');
            // $charge = \Stripe\Charge::create([
            //     'amount' => 999,
            //     'currency' => 'usd',
            //     'source' => 'tok_visa',
            //     'receipt_email' => 'jenny.rosen@example.com',
            // ]);


            // // Create subsciption
            // // Set your secret key: remember to change this to your live secret key in production
            // // See your keys here: https://dashboard.stripe.com/account/apikeys
            // \Stripe\Stripe::setApiKey('sk_test_CczNHRNSYyr4TenhiCp7Oz05');

            // $subscription = \Stripe\Subscription::create([
            //     'customer' => 'cus_4fdAW5ftNQow1a',
            //     'items' => [['plan' => 'plan_CBb6IXqvTLXp3f']],
            //     'coupon' => 'free-period',
            // ]);


            // Create a subscription [requires to create a customer beforehand]

            // customer [required]                                          - The identifier of the customer to subscribe.
            // items [required]                                             - List of subscription items, each with an attached plan.
            // items.plan [required]                                        - Plan ID for this item, as a string.
            // items.billing_thresholds [optional]                          - Define thresholds at which an invoice will be sent, and the subscription advanced to a new billing period
            // items.billing_thresholds.usage_gte [required]                - Usage threshold that triggers the subscription to advance to a new billing period
            // items.metadata [optional]                                    - Set of key-value pairs that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
            // items.quantity [optional]                                    - Quantity for this item.
            // items.tax_rates [optional]                                   - The tax rates which apply to this `subscription_item`. When set, the `default_tax_rates` on the subscription do not apply to this `subscription_item`.

            // coupon [optional]                                            - The code of the coupon to apply to this subscription. A coupon applied to a subscription will only affect invoices created for that particular subscription. This can be unset by updating the value to null and then saving.

            // // ADVANCED SETTINGS:

            // metadata [optional]                                          - A set of key-value pairs that you can attach to a `Subscription` object. It can be useful for storing additional information about the subscription in a structured format.
            // prorate [optional]                                           - Boolean (defaults to `true`) telling us whether to credit for unused time when the billing cycle changes (e.g. when switching plans, resetting `billing_cycle_anchor=now`, or starting a trial), or if an item’s `quantity` changes. If `false`, the anchor period will be free (similar to a trial) and no proration adjustments will be created.

            // trial_end [optional]                                         - Unix timestamp representing the end of the trial period the customer will get before being charged for the first time. This will always overwrite any trials that might apply via a subscribed plan. If set, trial_end will override the default trial period of the plan the customer is being subscribed to. The special value `now` can be provided to end the customer’s trial immediately. Can be at most two years from `billing_cycle_anchor`

            // trial_from_plan [optional]                                   - Indicates if a plan’s `trial_period_days` should be applied to the subscription. Setting `trial_end` per subscription is preferred, and this defaults to `false`. Setting this flag to `true` together with `trial_end` is not allowed.
            // @IMPORTANT
            // trial_period_days [optional]                                 - Integer representing the number of trial period days before the customer is charged for the first time. This will always overwrite any trials that might apply via a subscribed plan.
            // @IMPORTANT

            // application_fee_percent [optional]                           - A non-negative decimal between 0 and 100, with at most two decimal places. This represents the percentage of the subscription invoice subtotal that will be transferred to the application owner’s Stripe account. 
            // billing [optional]                                           - Either `charge_automatically`, or `send_invoice`. When charging automatically, Stripe will attempt to pay this subscription at the end of the cycle using the default source attached to the customer. When sending an invoice, Stripe will email your customer an invoice with payment instructions.
            // billing_cycle_anchor [optional]                              - A future timestamp to anchor the subscription’s billing cycle. This is used to determine the date of the first full invoice, and, for plans with month or year intervals, the day of the month for subsequent invoices.
            // billing_thresholds [optional]                                - Define thresholds at which an invoice will be sent, and the subscription advanced to a new billing period. Pass an empty string to remove previously-defined thresholds.
            // billing_thresholds.amount_gte [optional]                     - Monetary threshold that triggers the subscription to advance to a new billing period
            // billing_thresholds.reset_billing_cycle_anchor [optional]     - Indicates if the `billing_cycle_anchor` should be reset when a threshold is reached. If true, `billing_cycle_anchor` will be updated to the date/time the threshold was last reached; otherwise, the value will remain unchanged.
            // cancel_at_period_end [optional]                              - Boolean indicating whether this subscription should cancel at the end of the current period.
            // days_until_due [optional]                                    - Number of days a customer has to pay invoices generated by this subscription. Valid only for subscriptions where `billing` is set to `send_invoice`.
            // default_payment_method [optional]                            - ID of the default payment method for the subscription. It must belong to the customer associated with the subscription. If not set, invoices will use the default payment method in the customer’s invoice settings.
            // default_source [optional]                                    - ID of the default payment source for the subscription. It must belong to the customer associated with the subscription and be in a chargeable state. If not set, defaults to the customer’s default source.
            // default_tax_rates [optional]                                 - The tax rates that will apply to any subscription item that does not have tax_rates set. Invoices created will have their default_tax_rates populated from the subscription.

            //var_dump($charge);
            //exit;

        }


        /**
         * Hook into elements and add Stripe element
         *
         *  @since      1.0.0
        */
        public static function add_stripe_element( $array, $attributes ) {

            // Include the predefined arrays
            require( SUPER_PLUGIN_DIR . '/includes/shortcodes/predefined-arrays.php' );
            $array['form_elements']['shortcodes']['stripe'] = array(
                'callback' => 'SUPER_Stripe::stripe_cc',
                'name' => 'Credit card',
                'icon' => 'stripe;fab',
                'atts' => array(
                    'general' => array(
                        'name' => __( 'General', 'super-forms' ),
                        'fields' => array(
                            // 'name' => SUPER_Shortcodes::name( $attributes, '' ),
                        )
                    )
                )
            );

            $banks = array(
                'abn_amro' => 'ABN Amro',
                'asn_bank' => 'ASN Bank',
                'bunq' => 'bunq B.V.‎',
                'handelsbanken' => 'Handelsbanken',
                'ing' => 'ING Bank',
                'knab' => 'Knab',
                'moneyou' => 'Moneyou',
                'rabobank' => 'Rabobank',
                'regiobank' => 'RegioBank',
                'sns_bank' => 'SNS Bank',
                'triodos_bank' => 'Triodos Bank',
                'van_lanschot' => 'Van Lanschot'
            );
            $dropdown_items = array();
            foreach($banks as $k => $v){
                $dropdown_items[] = array(
                    'checked' => false,
                    'label' => $v,
                    'value' => $k
                );
            }
            $array['form_elements']['shortcodes']['stripe_ideal'] = array(
                'name' => esc_html__( 'iDeal', 'super-forms' ),
                'icon' => 'stripe;fab',
                'predefined' => array(
                    array(
                        'tag' => 'dropdown',
                        'group' => 'form_elements',
                        'data' => array(
                            'name' => esc_html__( 'stripe_ideal', 'super-forms' ),
                            'email' => esc_html__( 'Stripe iDeal:', 'super-forms' ),
                            'placeholder' => esc_html__( '- selecteer uw bank -', 'super-forms' ),
                            'icon' => 'caret-square-down;far',
                            'dropdown_items' => $dropdown_items,
                            'validation' => 'empty',
                            'error' => esc_html__( 'Selecteer uw bank!', 'super-forms' )
                        )
                    )
                ),
                'atts' => array(),
            );


            // $banks = array(
            //     'ABN Amro',
            //     'ASN Bank',
            //     'bunq B.V.‎',
            //     'Handelsbanken',
            //     'ING Bank',
            //     'Knab',
            //     'Moneyou',
            //     'Rabobank',
            //     'RegioBank',
            //     'SNS Bank',
            //     'Triodos Bank',
            //     'Van Lanschot'
            // );
            // $dropdown_items = array();
            // foreach($banks as $v){
            //     $dropdown_items[] = array(
            //         'checked' => false,
            //         'label' => $v,
            //         'value' => $v
            //     );
            // }
            // $array['form_elements']['shortcodes']['stripe_ideal'] = array(
            //     'name' => 'iDeal',
            //     'icon' => 'stripe;fab',
            //     'predefined' => array(
            //         array(
            //             'tag' => 'dropdown',
            //             'group' => 'form_elements',
            //             'data' => array(
            //                 'dropdown_items' => $dropdown_items,
            //                 'name' => esc_html__( 'ideal', 'super-forms' ),
            //                 'email' => esc_html__( 'iDeal:', 'super-forms' ),
            //                 'placeholder' => esc_html__( '- selecteer uw bank -', 'super-forms' ),
            //                 'validation' => 'empty',
            //                 'icon' => 'caret-square-down;far',
            //             )
            //         )
            //     ),
            //     'atts' => array(),
            // );

            return $array;
        }


        /**
         * Handle the Stripe iDeal element output
         *
         *  @since      1.0.0
        */
        public static function stripe_ideal( $tag, $atts, $inner, $shortcodes=null, $settings=null, $i18n=null ) {
            // Fallback check for older super form versions
            if (method_exists('SUPER_Common','generate_array_default_element_settings')) {
                $defaults = SUPER_Common::generate_array_default_element_settings($shortcodes, 'form_elements', $tag);
            }else{
                $defaults = array(
                    // 'name' => 'subtotal'
                );
            }
            $atts = wp_parse_args( $atts, $defaults );
            // @since Super Forms 4.7.0 - translation
            if (method_exists('SUPER_Shortcodes','merge_i18n')) {
                $atts = SUPER_Shortcodes::merge_i18n($atts, $i18n); 
            }
            // wp_enqueue_style( 'super-calculator', plugin_dir_url( __FILE__ ) . 'assets/css/frontend/calculator.min.css', array(), SUPER_Calculator()->version );
            // wp_enqueue_script( 'super-stripe', plugin_dir_url( __FILE__ ) . 'assets/js/frontend/calculator.min.js', array( 'jquery', 'super-common' ), SUPER_Calculator()->version );

            // Enqueu required scripts
            wp_enqueue_script( 'stripe-v3', 'https://js.stripe.com/v3/', array(), SUPER_Stripe()->version, false );  
            $handle = 'super-stripe-ideal';
            $name = str_replace( '-', '_', $handle ) . '_i18n';
            wp_register_script( $handle, plugin_dir_url( __FILE__ ) . 'scripts-ideal.js', array( 'jquery', 'super-common' ), SUPER_Stripe()->version, false );  
            $global_settings = SUPER_Common::get_global_settings();
            if(empty($global_settings['stripe_pk'])){
                $global_settings['stripe_pk'] = 'pk_test_1i3UyFAuxbe3Po62oX1FV47U';
            }
            wp_localize_script(
                $handle,
                $name,
                array( 
                    'stripe_pk' => $global_settings['stripe_pk'],
                    'styles' => array(
                        
                    )
                )
            );
            wp_enqueue_script( $handle );

            $result = SUPER_Shortcodes::opening_tag( $tag, $atts );
            $result .= SUPER_Shortcodes::opening_wrapper( $atts, $inner, $shortcodes, $settings );

            $result .= '<input hidden class="super-shortcode-field super-hidden" data-validation="empty" type="text" name="super_stripe_ideal" style="display:none;"';
            $result .= SUPER_Shortcodes::common_attributes( $atts, $tag );
            $result .= ' />';
            $result .= '<div class="super-stripe-ideal-element"></div>';
            $result .= '<div class="super-ideal-errors" role="alert"></div>';

            
            $result .= '</div>';
            $result .= SUPER_Shortcodes::loop_conditions( $atts );
            $result .= '</div>';
            return $result;        
        }


        /**
         * Handle the Stripe Credit Card element output
         *
         *  @since      1.0.0
        */
        public static function stripe_cc( $tag, $atts, $inner, $shortcodes=null, $settings=null, $i18n=null ) {
            // Fallback check for older super form versions
            if (method_exists('SUPER_Common','generate_array_default_element_settings')) {
                $defaults = SUPER_Common::generate_array_default_element_settings($shortcodes, 'form_elements', $tag);
            }else{
                $defaults = array(
                    // 'name' => 'subtotal'
                );
            }
            $atts = wp_parse_args( $atts, $defaults );
            // @since Super Forms 4.7.0 - translation
            if (method_exists('SUPER_Shortcodes','merge_i18n')) {
                $atts = SUPER_Shortcodes::merge_i18n($atts, $i18n); 
            }
            // wp_enqueue_style( 'super-calculator', plugin_dir_url( __FILE__ ) . 'assets/css/frontend/calculator.min.css', array(), SUPER_Calculator()->version );
			// wp_enqueue_script( 'super-stripe', plugin_dir_url( __FILE__ ) . 'assets/js/frontend/calculator.min.js', array( 'jquery', 'super-common' ), SUPER_Calculator()->version );

			// Enqueu required scripts
            wp_enqueue_script( 'stripe-v3', 'https://js.stripe.com/v3/', array(), SUPER_Stripe()->version, false );  
            $handle = 'super-stripe-cc';
            $name = str_replace( '-', '_', $handle ) . '_i18n';
            wp_register_script( $handle, plugin_dir_url( __FILE__ ) . 'scripts-cc.js', array( 'jquery', 'super-common' ), SUPER_Stripe()->version, false );  
            $global_settings = SUPER_Common::get_global_settings();
            if(empty($global_settings['stripe_pk'])){
            	$global_settings['stripe_pk'] = 'pk_test_1i3UyFAuxbe3Po62oX1FV47U';
            }
            wp_localize_script(
                $handle,
                $name,
                array( 
                    'stripe_pk' => $global_settings['stripe_pk']
                )
            );
            wp_enqueue_script( $handle );

            $result = SUPER_Shortcodes::opening_tag( $tag, $atts );
	        $result .= SUPER_Shortcodes::opening_wrapper( $atts, $inner, $shortcodes, $settings );

	        $result .= "<style></style>";
			$result .= '<div class="form-row">';
			$result .= '<div class="super-stripe-cc-element">';
			$result .= '</div>';
			$result .= '<!-- Used to display form errors. -->';
			$result .= '<div class="super-card-errors" role="alert"></div>';
			$result .= '</div>';

	        $result .= SUPER_Shortcodes::common_attributes( $atts, $tag );
	        $result .= '</div>';
	        $result .= SUPER_Shortcodes::loop_conditions( $atts );
	        $result .= '</div>';
	        return $result;        
        }


        /**
         * Load Localisation files.
         * Note: the first-loaded translation file overrides any following ones if the same translation is present.
         */
        public function load_plugin_textdomain() {
            $locale = apply_filters( 'plugin_locale', get_locale(), 'super-forms' );
            load_textdomain( 'super-forms', WP_LANG_DIR . '/super-forms-' . $this->add_on_slug . '/super-forms-' . $this->add_on_slug . '-' . $locale . '.mo' );
            load_plugin_textdomain( 'super-forms', false, plugin_basename( dirname( __FILE__ ) ) . '/i18n/languages' );
        }



        /**
         * Enqueue scripts
         *
         *  @since      1.0.0
        */
        public function enqueue_scripts() {
            if( !empty($_GET['client_secret']) ) {
            	$client_secret = sanitize_text_field($_GET['client_secret']);
            	$livemode = sanitize_text_field($_GET['livemode']);
            	$source = sanitize_text_field($_GET['source']);
		        // Get Source status
				// https://f4d.nl/dev/?client_secret=src_client_secret_FAjQj85HSzhwvo4EzUTgC4dm&livemode=false&source=src_1EgNxUFKn7uROhgClC0MmsoJ
		        $url = 'https://api.stripe.com/v1/sources/' . $source;
		        $response = wp_remote_post( 
		            $url, 
		            array(
		                'timeout' => 45,
						'headers'=>array(
                            'Authorization' => 'Bearer sk_test_CczNHRNSYyr4TenhiCp7Oz05'
                        ),		                
		                'body' => array()
		            )
		        );
		        if ( is_wp_error( $response ) ) {
		            $error_message = $response->get_error_message();
		        	$GLOBALS['stripe_error_message'] = $error_message;
		        } else {
		            $obj = json_decode($response['body']);
		            $GLOBALS['stripe_obj'] = $obj;
		        }

	        	// Enqueue styles
	    		wp_enqueue_style( 'stripe-confirmation', plugin_dir_url( __FILE__ ) . 'confirmation.css', array(), SUPER_Stripe()->version );
				// Enqueue scripts
	            wp_enqueue_script( 'stripe-v3', 'https://js.stripe.com/v3/', array(), SUPER_Stripe()->version, false ); 
	            $handle = 'super-stripe-confirmation';
	            $name = str_replace( '-', '_', $handle ) . '_i18n';
	            wp_register_script( $handle, plugin_dir_url( __FILE__ ) . 'confirmation.js', array(), SUPER_Stripe()->version, false ); 
	            $global_settings = SUPER_Common::get_global_settings();
	            if(empty($global_settings['stripe_pk'])){
	            	$global_settings['stripe_pk'] = 'pk_test_1i3UyFAuxbe3Po62oX1FV47U';
	            }
	            wp_localize_script(
	                $handle,
	                $name,
	                array( 
	                    'stripe_pk' => $global_settings['stripe_pk'],
	                    'status' => (!empty($GLOBALS['stripe_obj']) ? $GLOBALS['stripe_obj']->status : ''),
	                    'client_secret' => $client_secret,
	                    'livemode' => $livemode,
	                    'source' => $source
	                )
	            );
	            wp_enqueue_script( $handle );

	        }

        	// // https://js.stripe.com/v3/
         //    wp_enqueue_script( 'stripe-v3', 'https://js.stripe.com/v3/', array(), SUPER_Stripe()->version, false );  
            
         //    $handle = 'super-stripe';
         //    $name = str_replace( '-', '_', $handle ) . '_i18n';
         //    wp_register_script( $handle, plugin_dir_url( __FILE__ ) . 'scripts.js', array( 'jquery', 'super-common' ), SUPER_Stripe()->version, false );  
            
         //    $global_settings = SUPER_Common::get_global_settings();
         //    if(empty($global_settings['stripe_pk'])){
         //    	$global_settings['stripe_pk'] = 'pk_test_1i3UyFAuxbe3Po62oX1FV47U';
         //    }
         //    wp_localize_script(
         //        $handle,
         //        $name,
         //        array( 
         //            'stripe_pk' => $global_settings['stripe_pk']
         //        )
         //    );
         //    wp_enqueue_script( $handle );

        }


        /**
         * Hook into JS filter and add the Stripe Token
         *
         *  @since      1.0.0
        */
        public static function add_dynamic_function( $functions ) {
            $functions['before_submit_hook'][] = array(
                'name' => 'stripe_cc_create_payment_method'
            );
            $functions['before_email_send_hook'][] = array(
                'name' => 'stripe_ideal_create_source'
            );
            $functions['after_email_send_hook'][] = array(
                'name' => 'stripe_ideal_redirect'
            );
            return $functions;
		}


        /**
         * Display activation message for automatic updates
         *
         *  @since      1.0.0
        */
        public function display_activation_msg() {
            if( !class_exists('SUPER_Forms') ) {
                echo '<div class="notice notice-error">'; // notice-success
                    echo '<p>';
                    echo sprintf( 
                        esc_html__( '%sPlease note:%s You must install and activate %4$s%1$sSuper Forms%2$s%5$s in order to be able to use %1$s%s%2$s!', 'super_forms' ), 
                        '<strong>', 
                        '</strong>', 
                        'Super Forms - ' . $this->add_on_name, 
                        '<a target="_blank" href="https://codecanyon.net/item/super-forms-drag-drop-form-builder/13979866">', 
                        '</a>' 
                    );
                    echo '</p>';
                echo '</div>';
            }
        }


        /**
         * Automatically update plugin from the repository
        */
        public function update_plugin() {
            if( defined('SUPER_PLUGIN_DIR') ) {
                if(@include( SUPER_PLUGIN_DIR . '/includes/admin/plugin-update-checker/plugin-update-checker.php')){
                    $MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
                        'http://f4d.nl/@super-forms-updates/?action=get_metadata&slug=super-forms-' . $this->add_on_slug,  //Metadata URL
                        __FILE__, //Full path to the main plugin file.
                        'super-forms-' . $this->add_on_slug //Plugin slug. Usually it's the same as the name of the directory.
                    );
                }
            }
        }



        /**
         * Hook into settings and add Stripe settings
         *
         *  @since      1.0.0
        */
        public static function add_settings( $array, $settings ) {
           
            // Stripe Settings
            $array['stripe_checkout'] = array(        
                'name' => esc_html__( 'Stripe Checkout', 'super-forms' ),
                'label' => esc_html__( 'Stripe Checkout', 'super-forms' ),
                'html' => array( '<style>.super-settings .stripe-settings-html-notice {display:none;}</style>', '<p class="stripe-settings-html-notice">' . sprintf( esc_html__( 'Need to send more E-mails? You can increase the amount here:%s%s%sSuper Forms > Settings > Stripe Settings%s%s', 'super-forms' ), '<br />', '<a target="_blank" href="' . admin_url() . 'admin.php?page=super_settings#stripe-settings">', '<strong>', '</strong>', '</a>' ) . '</p>' ),
                'fields' => array(
                    'stripe_email_amount' => array(
                        'hidden' => true,
                        'name' => esc_html__( 'Select how many individual E-mails you require', 'super-forms' ),
                        'desc' => esc_html__( 'If you need to send 3 individual E-mails enter: 3', 'super-forms' ),
                        'default' => SUPER_Settings::get_value( 0, 'stripe_email_amount', $settings['settings'], '2' )
                    ),
                    'stripe_checkout' => array(
                        'hidden_setting' => true,
                        'default' => SUPER_Settings::get_value(0, 'stripe_checkout', $settings['settings'], '' ),
                    	'type' => 'checkbox',
                    	'filter' => true,
                     	'values' => array(
                    		'true' => esc_html__( 'Enable Stripe Checkout', 'super-forms' ),
                    	),
                    ),
                    'stripe_mode' => array(
                      	'default' => SUPER_Settings::get_value(0, 'stripe_mode', $settings['settings'], '' ),
                      	'type' => 'checkbox',
                      	'values' => array(
                      		'sandbox' => esc_html__( 'Enable Stripe Sandbox mode (for testing purposes only)', 'super-forms' ),
                      	),
                      	'filter' => true,
                      	'parent' => 'stripe_checkout',
                      	'filter_value' => 'true',
                    ),
                    'stripe_amount' => array(
                        'name' => esc_html__( 'Amount to charge', 'super-forms' ),
                        'label' => esc_html__( 'You are allowed to use {tags}', 'super-forms' ),
                        'default' => SUPER_Settings::get_value(0, 'stripe_amount', $settings['settings'], '' ),
                        'filter' => true,
                        'parent' => 'stripe_checkout',
                        'filter_value' => 'true',
                    ),
                    'stripe_currency' => array(
                        'name' => esc_html__( 'Currency', 'super-forms' ),
                        'label' => esc_html__( 'Three-letter ISO code for the currency e.g: USD, AUD, EUR', 'super-forms' ),
                        'default' => SUPER_Settings::get_value(0, 'stripe_currency', $settings['settings'], 'USD' ),
                        'filter' => true,
                        'parent' => 'stripe_checkout',
                        'filter_value' => 'true',
                    )
                )
            );
             
            if(empty($settings['settings']['stripe_email_amount'])) $settings['settings']['stripe_email_amount'] = 3;
            $limit = absint($settings['settings']['stripe_email_amount']);
            if($limit==0) $limit = 2;

            $x = 1;
            while($x <= $limit) {
                $stripe_checkout = array(
                    'stripe_email_'.$x => array(
                        'hidden_setting' => true,
                        'desc' => sprintf( esc_html__( 'Send payment completed E-mail #%s', 'super-forms' ), $x ), 
                        'default' => SUPER_Settings::get_value( 0, 'stripe_email_'.$x, $settings['settings'], '' ),
                        'type' => 'checkbox',
                        'values' => array(
                            'true' => sprintf( esc_html__( 'Send payment completed E-mail #%s', 'super-forms' ), $x ),
                        ),
                      	'filter' => true,
                      	'parent' => 'stripe_checkout',
                      	'filter_value' => 'true'
                    )
                );
                $array['stripe_checkout']['fields'] = array_merge($array['stripe_checkout']['fields'], $stripe_checkout);

                $fields = $array['confirmation_email_settings']['fields'];
                $new_fields = array();
                foreach($fields as $k => $v){
                    if($k=='confirm'){
                        unset($fields[$k]);
                        continue;
                    }
                    if( !empty($v['parent']) ) {
                        if($v['parent']=='confirm'){
                            $v['parent'] = 'stripe_email_'.$x;
                            $v['filter_value'] = 'true';
                        }else{
                            $v['parent'] = str_replace('confirm_', 'stripe_email_'.$x.'_', $v['parent']);
                        }
                    }
                    unset($fields[$k]);
                    $k = str_replace('confirm_', 'stripe_email_'.$x.'_', $k);
                    if( !empty($v['default']) ) {
                        $v['default'] = SUPER_Settings::get_value( 0, $k, $settings['settings'], $v['default'] );
                    }
                    $v['hidden_setting'] = true;
                    $new_fields[$k] = $v;
                }
                $new_fields['stripe_email_'.$x.'_attachments'] = array(
                    'hidden_setting' => true,
                    'name' => sprintf( esc_html__( 'Attachments E-mail #%s', 'super-forms' ), $x ),
                    'desc' => esc_html__( 'Upload a file to send as attachment', 'super-forms' ),
                    'default'=> SUPER_Settings::get_value( 0, 'stripe_email_'.$x.'_attachments', $settings['settings'], '' ),
                    'type' => 'file',
                    'multiple' => 'true',
                    'filter'=>true,
                    'parent'=>'stripe_email_'.$x,
                    'filter_value'=>'true'
                );
                $array['stripe_checkout']['fields'] = array_merge($array['stripe_checkout']['fields'], $new_fields);
                $x++;
            }
            return $array;
        }

    }
        
endif;


/**
 * Returns the main instance of SUPER_Stripe to prevent the need to use globals.
 *
 * @return SUPER_Stripe
 */
if(!function_exists('SUPER_Stripe')){
    function SUPER_Stripe() {
        return SUPER_Stripe::instance();
    }
    // Global for backwards compatibility.
    $GLOBALS['SUPER_Stripe'] = SUPER_Stripe();
}
