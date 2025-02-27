<?php
/**
 * Super Forms
 *
 * @package   Super Forms
 * @author    feeling4design
 * @link      http://codecanyon.net/user/feeling4design
 * @copyright 2019 by feeling4design
 *
 * @wordpress-plugin
// build-SUPER_FORMS_BUNDLE
 * Plugin Name: Super Forms - All In One Bundle
// build-SUPER_FORMS_BUNDLE_END
 * Plugin Name: Super Forms - Drag & Drop Form Builder
 * Plugin URI:  http://codecanyon.net/user/feeling4design
 * Description: Build forms anywhere on your website with ease.
 * Version:     4.7.2
 * Author:      feeling4design
 * Author URI:  http://codecanyon.net/user/feeling4design
 * Text Domain: super-forms
 * Domain Path: /i18n/languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if(!class_exists('SUPER_Forms')) :


    /**
     * Main SUPER_Forms Class
     *
     * @class SUPER_Forms
     */
    final class SUPER_Forms {
    
        
        /**
         * @var string
         *
         *  @since      1.0.0
        */
        public $version = '4.7.2';
        public $slug = 'super-forms';


        /**
         * @var array
         *
         *  @since      1.1.8
        */
        public $common_i18n;


        /**
         * @var array
         *
         *  @since      1.1.6
        */
        public $elements_i18n;


        /**
         * @var array
         *
         *  @since      4.2
        */
        public $global_settings;


        /**
         * @var string
         *
         *  @since      1.3
        */
        public $form_custom_css;


        /**
         * @var string
         *
         *  @since      4.2.0
        */
        public $theme_custom_js;

       
        /**
         * @var SUPER_Forms The single instance of the class
         *
         *  @since      1.0.0
        */
        protected static $_instance = null;

        
        /**
         * Contains an array of registered script handles
         *
         * @var array
         *
         *  @since      1.0.0
        */
        private static $scripts = array();
        
        
        /**
         * Contains an array of localized script handles
         *
         * @var array
         *
         *  @since      1.0.0
        */
        private static $wp_localize_scripts = array();
        
        
        /**
         * Main SUPER_Forms Instance
         *
         * Ensures only one instance of SUPER_Forms is loaded or can be loaded.
         *
         * @static
         * @see SUPER_Forms()
         * @return SUPER_Forms - Main instance
         *
         *  @since      1.0.0
        */
        public static function instance() {
            if(is_null( self::$_instance)){
                self::$_instance = new self();
                self::$_instance->session = new SUPER_Session();
            }
            return self::$_instance;
        }

        
        /**
         * SUPER_Forms Constructor.
         *
         *  @since      1.0.0
        */
        public function __construct(){
            $this->define_constants();
            $this->includes();
            $this->init_hooks();
            do_action('super_loaded');
        }

        
        /**
         * Define SUPER_Forms Constants
         *
         *  @since      1.0.0
        */
        private function define_constants(){
            
            // define plugin info
            $this->define( 'SUPER_PLUGIN_NAME', 'Super Forms' );
            // build-SUPER_FORMS_BUNDLE
            $this->define( 'SUPER_PLUGIN_NAME', 'Super Forms - All In One Bundle' );
            // build-SUPER_FORMS_BUNDLE_END

            $this->define( 'SUPER_PLUGIN_FILE', plugin_dir_url( __FILE__ ) ); // http://domain.com/wp-content/plugins/super-forms/
            $this->define( 'SUPER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // super-forms/super-forms.php
            $this->define( 'SUPER_PLUGIN_DIR', dirname( __FILE__ ) ); // /home/domains/domain.com/public_html/wp-content/plugins/super-forms
            $this->define( 'SUPER_VERSION', $this->version );
            $this->define( 'SUPER_WC_ACTIVE', in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );

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
        public static function is_request($type){
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
         * Include required core files used in admin and on the frontend.
         *
         *  @since      1.0.0
        */
        public function includes(){

            // @since 3.2.0 - first load session manager
            include_once( 'includes/class-super-session.php' );

            include_once( 'includes/class-common.php' );
                        
            if ( $this->is_request( 'admin' ) ) {
                include_once( 'includes/class-install.php' );
                include_once( 'includes/class-menu.php' );
                include_once( 'includes/class-pages.php' );
                include_once( 'includes/class-settings.php' );
                include_once( 'includes/class-shortcodes.php' );
                include_once( 'includes/class-field-types.php' );
            }

            if ( $this->is_request( 'ajax' ) ) {
                $this->ajax_includes();
            }

            if ( $this->is_request( 'frontend' ) ) {
                include_once( 'includes/class-shortcodes.php' );
            }
            
            // Registers post types
            include_once('includes/class-post-types.php');            

        }


        // build-SUPER_FORMS_BUNDLE
        /**
         * Include add-ons
         *
         *  @since      1.0.0
        */        
        public static function include_add_ons(){
            // Include Add-ons
            $directory = SUPER_PLUGIN_DIR . '/add-ons';
            $folders = array_diff(scandir($directory), array('..', '.'));
            foreach($folders as $k => $v){
                @include_once('add-ons/'.$v.'/'.$v.'.php');
            }
        }
        // build-SUPER_FORMS_BUNDLE_END


        /**
         * Hook into actions and filters
         *
         *  @since      1.0.0
        */
        private function init_hooks() {
            
            // build-SUPER_FORMS_BUNDLE
            add_action( 'plugins_loaded', array( $this, 'include_add_ons' ), 0 );
            // build-SUPER_FORMS_BUNDLE_END

            register_activation_hook( __FILE__, array( 'SUPER_Install', 'install' ) );
            
            // @since 1.9
            register_deactivation_hook( __FILE__, array( 'SUPER_Install', 'deactivate' ) );

            // Actions since 1.0.0
            add_action( 'init', array( $this, 'init' ), 0 );
            add_action( 'init', array( $this, 'register_shortcodes' ) );

            // Filters since 1.2.3
            if ( ( $this->is_request( 'frontend' ) ) || ( $this->is_request( 'admin' ) ) ) {
                add_filter( 'super_common_js_dynamic_functions_filter', array( $this, 'add_dynamic_function' ), 100, 2 );
                add_filter( 'super_common_js_dynamic_functions_filter', array( $this, 'add_html_tags_dynamic_function' ), 120, 2 );
                add_filter( 'super_common_js_dynamic_functions_filter', array( $this, 'add_action_attribute_tags_dynamic_function' ), 140, 2 );
            }

            if ( $this->is_request( 'frontend' ) ) {

                add_action( 'wp_head', array( $this, 'ga_tracking_code' ), 1 );
    
                // Filters since 1.0.0
                //add_filter( 'the_content', 'do_shortcode', 100 ); // disabled because of some weird conflicts?
                add_filter( 'widget_text', 'do_shortcode', 100 );

                // Actions since 1.0.6
                add_action( 'loop_start', array( $this, 'print_message_before_content' ) );
                add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_message_scripts' ) );

                /**
                 * Check if this site uses Ajax calls to generate content dynamically
                 * If this is the case make sure the styles and scripts for the element(s) are loaded
                 *
                 *  @since      1.1.9.5
                */
                add_action( 'wp_enqueue_scripts', array( $this, 'load_frontend_scripts_before_ajax' ) );
                
                /**
                 * Make sure the custom styles are loaded at the very end
                 * This way we don't have to use !important tags (which is always a good thing for extra flexibility)
                 *
                 *  @since      1.3
                */
                add_action( 'wp_footer', array( $this, 'add_form_styles' ), 500 );

                // @since 4.2.0 - add custom JS script
                add_action( 'wp_footer', array( $this, 'add_form_scripts' ), 500 );

            }
            
            if ( $this->is_request( 'admin' ) ) {

                // Actions since 1.0.0
                add_action( 'admin_menu', 'SUPER_Menu::register_menu' );
                add_action( 'current_screen', array( $this, 'after_screen' ), 0 );
                add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
                add_action( 'admin_print_scripts', array( $this, 'localize_printed_scripts' ), 5 );
                add_action( 'admin_print_footer_scripts', array( $this, 'localize_printed_scripts' ), 5 );
                add_action( 'admin_action_duplicate_super_form', array( $this, 'duplicate_form_action' ) );
                add_action( 'admin_action_duplicate_super_contact_entry', array( $this, 'duplicate_contact_entry_action' ) );
                add_action( 'init', array( $this, 'custom_contact_entry_status' ) );
                add_action( 'admin_footer-post.php', array( $this, 'append_contact_entry_status_list' ) );
                
                // Actions since 1.2.6
                add_action( 'init', array( $this, 'update_plugin' ) );

                // Actions since 1.7
                add_action( 'restrict_manage_posts', array( $this, 'contact_entry_filter_form_dropdown' ) );
                add_action( 'restrict_manage_posts', array( $this, 'contact_entry_filter_date_range' ) );
  
                // Actions since 3.1.0
                add_action( 'before_delete_post', array( $this, 'delete_form_backups' ) );

                // Actions since 3.4.0
                add_action( 'all_admin_notices', array( $this, 'show_whats_new' ) );
                add_action( 'current_screen', array( $this, 'whats_new_page' ) );

                // Actions since 4.0.0
                add_action( 'all_admin_notices', array( $this, 'show_php_version_error' ) );



            }
            
            if ( $this->is_request( 'ajax' ) ) {
            }

            // Filters since 3.6.0 - filter to apply if statements on emails
            add_filter( 'super_before_sending_email_body_filter', array( $this, 'email_if_statements' ), 10, 2 );
            add_filter( 'super_before_sending_confirm_body_filter', array( $this, 'email_if_statements' ), 10, 2 );

            // Actions since 1.2.7
            add_action( 'phpmailer_init', array( $this, 'add_string_attachments' ) );

            // Actions since 3.3.0
            add_action( 'vc_before_init', array( $this, 'super_forms_addon' ) );

            // @since 4.7.0 - trigger onchange for tinyMCE editor, this is used for the calculator add-on to count words
            add_filter('tiny_mce_before_init', array( $this, 'onchange_tinymce' ) );

            add_action( 'upgrader_process_complete', array( $this, 'api_post_update' ), 10, 2);
            register_activation_hook( __FILE__, array( $this, 'api_post_activation' ) );
            register_deactivation_hook( __FILE__, array( $this, 'api_post_deactivation' ) );

        }
        public function api_post_activation() {
            self::api_post('activation');
        }
        public function api_post_deactivation() {
            self::api_post('deactivation');
        }
        public function api_post_update( $upgrader_object, $options ) {
            $current_plugin_path_name = plugin_basename( __FILE__ );
            if ($options['action'] == 'update' && $options['type'] == 'plugin' ){
                foreach($options['plugins'] as $each_plugin){
                    if ($each_plugin==$current_plugin_path_name){
                        self::api_post('update');
                    }
                }
            }
        }
        public function api_post($type) {
            $slug = $this->slug;
            // build-SUPER_FORMS_BUNDLE
            $slug = $this->slug . '-bundle';
            // build-SUPER_FORMS_BUNDLE_END
            $data = array(
                'version' => $this->version,
                'slug' => $slug,
                'domain' => get_home_url(),
                'type' => $type
            );
            $response = wp_remote_post( 
                'https://f4d.nl/super-forms/?api=update-plugin', 
                array(
                    'timeout' => 45,
                    'body' => $data
                )
            );
        }



        public function onchange_tinymce( $init ) {
            ob_start();
            echo 'function(editor){
                var word_count_timeout = null;
                editor.on("keyup blur", function(e){
                    var $this = this,
                        $time = 250,
                        $text,
                        $words;
                    if(e.type!="keyup") $time = 0;
                    if (word_count_timeout !== null) {
                        clearTimeout(word_count_timeout);
                    }
                    word_count_timeout = setTimeout(function () {
                        $text = editor.getContent();
                        $words = $text.match(/\S+/g);
                        $words = $words ? $words.length : 0;
                        jQuery($this.targetElm).attr("data-word-count", $words);
                        SUPER.after_field_change_blur_hook(jQuery($this.targetElm));
                    }, $time);
                });
            }';
            $init['setup'] = ob_get_contents();
            ob_end_clean();
            return $init;
        }


        /**
         * Add google analytics tracking code
         *
         *  @since      3.6.0
        */
        public static function ga_tracking_code() {
            $global_settings = SUPER_Common::get_global_settings();
            if( (!empty($global_settings['form_enable_ga_tracking'])) && (!empty($global_settings['form_ga_code'])) ) {
                echo '<!-- Super Forms - Google Tracking Code -->';
                echo '<script>' . stripslashes( $global_settings['form_ga_code'] ) . '</script>';
                echo '<!-- End Super Forms - Google Tracking Code -->';
            }
        }

        /**
         * Apply email if statements
         *
         *  @since      3.6.0
        */
        public static function email_if_statements($email_body, $data) {
            
            // Example statements for emails:

            /*
            if('admin1'!='admin2'):
                Single statement TEST!!!!
            endif;

            if('administrator'==administrator):
                You are admin!
            elseif:
                Regular user role...
            endif;

            foreach(fieldname):
                Product number <%counter%> {fieldname}
            endforeach;
            
            !isset(fieldname):
                Field did not exist or was not submitted
            endif;

            isset(fieldname):
                Field exists and was submitted
            endif;

            */

            // Regex to do foreach loop for dynamic column fields
            $regex = '/foreach\s?\(\s?[\'|"|\s|]?(.*?)[\'|"|\s|]?\)\s?:([\s\S]*?)(?:endforeach\s?;)/';
            $match = preg_match_all($regex, $email_body, $matches, PREG_SET_ORDER, 0);
            foreach($matches as $k => $v){
                $original = $v[0];
                $field_name = $v[1];
                $return = '';
                if( isset( $v[2] ) ) $return = $v[2];
                $rows = '';
                if( isset( $data['data'][$field_name] ) ) {
                    // Of course we have at least one row, so always return the first row
                    $row = str_replace( '<%counter%>', 1, $return ); 
                    $row = str_replace( '<%', '{', $row ); 
                    $row = str_replace( '%>', '}', $row );
                    $row = SUPER_Common::email_tags( $row, $data['data'], $data['settings'] );
                    $rows .= $row;

                    // Loop through all the fields that have been dynamically added by the user
                    $i=2;
                    while( isset( $data['data'][$field_name . '_' . ($i)]) ) {
                        $row = str_replace( '<%counter%>', $i, $return );
                        $row = str_replace( '<%', '{', $row ); 
                        $row = str_replace( '%>', '_'.$i.'}', $row );
                        $row = SUPER_Common::email_tags( $row, $data['data'], $data['settings'] );
                        $rows .= $row;
                        $i++;
                    }
                }
                $email_body = str_replace( $original, $rows, $email_body);
            }

            // Regex to check if field was submitted (with isset and !isset)
            $regex = '/!isset\s?\(\s?[\'|"|\s|]?(.*?)[\'|"|\s|]?\)\s?:([\s\S]*?)(?:endif\s?;|(?:elseif\s?:([\s\S]*?))endif\s?;)/';
            $match = preg_match_all($regex, $email_body, $matches, PREG_SET_ORDER, 0);
            foreach($matches as $k => $v){
                $original = $v[0];
                $field_name = $v[1];
                $true = '';
                $false = '';
                if( isset( $v[2] ) ) $true = $v[2];
                if( isset( $v[3] ) ) $false = $v[3];
                if(!isset($data['data'][$field_name])){
                    $statement = $true;
                }else{
                    $statement = $false;
                }
                $email_body = str_replace( $original, $statement, $email_body);
            }

            // Regex to check if field was submitted (with isset and !isset)
            $regex = '/isset\s?\(\s?[\'|"|\s|]?(.*?)[\'|"|\s|]?\)\s?:([\s\S]*?)(?:endif\s?;|(?:elseif\s?:([\s\S]*?))endif\s?;)/';
            $match = preg_match_all($regex, $email_body, $matches, PREG_SET_ORDER, 0);
            foreach($matches as $k => $v){
                $original = $v[0];
                $field_name = $v[1];
                $true = '';
                $false = '';
                if( isset( $v[2] ) ) $true = $v[2];
                if( isset( $v[3] ) ) $false = $v[3];
                if(isset($data['data'][$field_name])){
                    $statement = $true;
                }else{
                    $statement = $false;
                }
                $email_body = str_replace( $original, $statement, $email_body);
            }

            // $regex = '/if\s?\(\s?[\'|"|\s|]?(.*?)[\'|"|\s|]?(==|!=|>=|<=|>|<)\s?[\'|"|\s|]?(.*?)[\'|"|\s|]?\)\s?:([\s\S]*?)(?:endif\s?;|(?:elseif\s?:([\s\S]*?))endif\s?;)/';
            $email_body = SUPER_Common::filter_if_statements($email_body);
            return $email_body;
        }


        /**
         * Add super forms shortcode to visual composer elements
         *
         *  @since      3.3.0
        */
        public static function super_forms_addon($form_id) {

            // Get all Forms created with Super Forms (post type: super_form)
            $args = array(
                'post_type' => 'super_form', //We want to retrieve all the Forms
                'posts_per_page' => -1 //Make sure all matching forms will be retrieved
            );
            $forms = get_posts( $args );
            $forms_array = array();
            foreach( $forms as $k => $v ) {
                $forms_array['#' . $v->ID . ' - ' . $v->post_title] = $v->ID;
            }
            vc_map( array(
                'name' => esc_html__( 'Super Form' ),
                'icon' => SUPER_PLUGIN_FILE . '/assets/images/vc_icon.png',
                'base' => 'super_form',
                'category' => esc_html__( 'Content' ),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'holder' => 'div',
                        'class' => '',
                        'heading' => esc_html__( 'Select your form' ),
                        'param_name' => 'id',
                        'value' => $forms_array,
                        'description' => esc_html__( 'Choose the form you want to use.' )
                    )
                )
            ) );
        }


        /**
         * Add form filter dropdown
         *
         *  @since      3.1.0
        */
        public static function delete_form_backups($form_id) {

            // We check if the global post type isn't ours and just return
            global $post_type;
            if ( $post_type != 'super_form' ) return;
     
            // Delete form backups
            $args = array( 
                'post_parent' => $form_id,
                'post_type' => 'super_form',
                'post_status' => 'backup',
                'posts_per_page' => -1 //Make sure all matching backups will be retrieved
            );
            $backups = get_posts( $args );
            if(is_array($backups) && count($backups) > 0) {
                foreach( $backups as $v ) {
                    wp_delete_post( $v->ID, true );
                }
            }
        }
        

        /**
         * Add form filter dropdown
         *
         *  @since      1.7
        */
        public static function contact_entry_filter_form_dropdown($post_type) {
            if( $post_type=='super_contact_entry') {
                echo '<select name="super_form_filter">';
                $args = array(
                    'post_type' => 'super_form',
                    'posts_per_page' => -1
                );
                $forms = get_posts( $args );
                if(count($forms)==0){
                    echo '<option value="0">' . esc_html__( 'No forms found', 'super-forms' ) . '</option>';
                }else{
                    $super_form_filter = (isset($_GET['super_form_filter']) ? $_GET['super_form_filter'] : 0);
                    echo '<option value="0">' . esc_html__( 'All forms', 'super-forms' ) . '</option>';
                    foreach( $forms as $value ) {
                        echo '<option value="' . $value->ID . '" ' . ($value->ID==$super_form_filter ? 'selected="selected"' : '') . '>' . $value->post_title . '</option>';
                    }
                }
                echo '</select>';
            }
        }


        /**
         * Add date range filter
         *
         *  @since      4.4.5
        */
        public static function contact_entry_filter_date_range($post_type) {
            if( $post_type=='super_contact_entry') {
                $from = ( isset( $_GET['sffrom'] ) && $_GET['sffrom'] ) ? $_GET['sffrom'] : '';
                $to = ( isset( $_GET['sfto'] ) && $_GET['sfto'] ) ? $_GET['sfto'] : '';
                echo '<input autocomplete="off" type="text" name="sffrom" placeholder="Date From" value="' . $from . '" />';
                echo '<input autocomplete="off" type="text" name="sfto" placeholder="Date To" value="' . $to . '" />';
            }
        }


        /**
         * Add contact entry export button
         *
         *  @since      1.7
        */
        public static function contact_entry_export_button($post_type) {
            add_thickbox();
            echo '<div class="alignleft actions">';
            echo '<span style="margin-bottom:1px;margin-top:1px;" class="button super-export-entries">';
            echo 'Export to CSV';
            echo '</span>';
            echo '<a style="display:none;" href="#TB_inline?width=600&height=550&inlineId=super-export-entries-content" title="Select & Sort the data that needs to be exported " class="thickbox super-export-entries-thickbox"></a>';
            echo '</div>';
            echo '<div id="super-export-entries-content" style="display:none;"></div>';
        }       


        /**
         * Add form custom CSS
         *
         *  @since      1.2.6
        */
        public static function add_form_styles() {
            if( isset(SUPER_Forms()->form_custom_css) ) {
                $css = SUPER_Forms()->form_custom_css;
                $global_css = '';
                if( isset(SUPER_Forms()->global_settings) ) {
                    if( isset(SUPER_Forms()->global_settings['theme_custom_css']) ) {
                        $global_css = stripslashes(SUPER_Forms()->global_settings['theme_custom_css']);
                    }
                }
                if( $css!='' ) echo '<style type="text/css">' . $global_css . $css . '</style>';
            }
        }


        /**
         * Add custom JS
         *
         *  @since      4.2.0
        */
        public static function add_form_scripts() {
            if( isset(SUPER_Forms()->theme_custom_js) ) {
                $js = SUPER_Forms()->theme_custom_js;
                if( $js!='' ) {
                    ?>
                    <script type="text/javascript">
                    //<![CDATA[
                        <?php echo stripslashes(apply_filters( 'super_form_js_filter', $js )); ?>
                    //]]>
                    </script>
                    <?php
                }
            }
        }


        /**
         * Add string attachments
         *
         *  @since      1.2.6
        */
        function add_string_attachments( $phpmailer ) {
            $attachments = SUPER_Forms()->session->get( 'super_string_attachments' );
            if( $attachments!=false ) {
                foreach( $attachments as $v ) {
                    $phpmailer->AddStringAttachment( base64_decode($v['data']), $v['filename'], $v['encoding'], $v['type'] );
                }
                SUPER_Forms()->session->set( 'super_string_attachments', false );
            }
        }


        /**
         * Show PHP version error if PHP below v5.4 is installed
         *
         *  @since      4.0.0
        */
        public function show_php_version_error() {
            if( version_compare(phpversion(), '5.4.0', '<') ) {
                echo '<div class="notice notice-error">'; // notice-success, notice-error
                echo '<p>';
                echo sprintf( esc_html__( '%sPlease note:%s Super Forms requires at least v5.4.0 or higher to be installed to work properly, your current PHP version is %s', 'super_forms' ), '<strong>', '</strong>', phpversion() );
                echo '</p>';
                echo '</div>';
            }
        }


        /**
         * Show what's new message
         *
         *  @since      3.4.0
        */
        public function show_whats_new() {
            $global_settings = SUPER_Common::get_global_settings();
            if(!isset($global_settings['backend_disable_whats_new_notice'])){
                $version = get_option( 'super_current_version', '1.0.0' );
                if( version_compare($version, $this->version, '<') ) {
                    update_option( 'super_current_version', $this->version );
                    echo '<div class="notice notice-success">'; // notice-success, notice-error
                        echo '<p>';
                        echo sprintf( esc_html__( 'Successfully updated Super Forms to v' . $this->version . ' - %sCheck what\'s new!%s', 'super_forms' ), '<a target="_blank" href="' . admin_url() . 'admin.php?super_whats_new=true">', '</a>' );
                        echo sprintf( esc_html__( '%sDisable this notification%s', 'super-forms' ), '<a style="padding-left:15px;" target="_blank" href="' . admin_url() . 'admin.php?page=super_settings#backend-settings">', '</a>');
                        echo '</p>';
                    echo '</div>';
                }
            }
        }


        /**
         * What's new page
         *
         *  @since      3.4.0
        */
        public function whats_new_page() {
            if( (isset($_GET['super_whats_new'])) && ($_GET['super_whats_new']=='true') ) {
                ?>
                <style>
                body {
                    float: left;
                    width: 100%;
                    background-color: #fff;
                    font-family: monospace;
                    margin:50px 0px 50px 0px;
                }
                .super-whats-new-wrapper {
                    margin: auto;
                    width: 75%;
                }
                .super-whats-new {
                    background-color: #f9f9f9;
                    border: 2px solid #ececec;
                    width: 100%;
                    float:left;
                    padding: 20px 10px 20px 30px;
                    margin: 0px auto 0 auto;
                    -webkit-border-radius: 10px;
                    -moz-border-radius: 10px;
                    border-radius: 10px;
                    -webkit-box-sizing: border-box;
                    -moz-box-sizing: border-box;
                    box-sizing: border-box;
                }
                .super-whats-new.blank {
                    background:none;
                    padding: 0;
                    border: 0;
                }
                .super-whats-new > .super-whats-new {
                    width: 38%;
                    float: left;
                    padding: 20px 30px 20px 30px;
                    margin-right: 2%;
                    margin-top: 2%;
                    text-align: center;
                    min-height: 165px;
                }
                .super-whats-new > .super-whats-new:first-child {
                    width: 25%;
                }
                .super-whats-new > .super-whats-new:last-child {
                    margin-right: 0;
                    width: 33%;
                }

                input[name="EMAIL"] {
                    float:left;width:58%;margin-right:2%;padding:2px 5px;
                }
                input[name="subscribe"] {
                    width: 40%;
                    float: left;
                    padding: 2px 5px;
                }
                p {
                    float:left;
                    width:100%;
                }
                h3 {
                    margin: 0px 0px 10px 0px;
                    float: left;
                    width: 100%;
                }
                h1 > span {
                    font-weight:100;
                    position: relative;
                }
                h1 img {
                    position: absolute;
                    right: -45px;
                    top: -3px;
                }
                h1 {
                    background-repeat: no-repeat;
                    background-position: 0px 22px;
                    background-size: 100px;
                    padding: 40px 10px 0px 95px;
                    margin:0px 0px 20px 0px;
                    background-image:url(<?php echo SUPER_PLUGIN_FILE . 'assets/images/logo.jpg'; ?>);
                }
                .super-whats-new.rating > h3:after {
                    content: '';
                    width: 100px;
                    height: 16px;
                    display: block;
                    margin: auto;
                    margin-top: 5px;
                    background-repeat: repeat-x;
                    background-image:url(<?php echo SUPER_PLUGIN_FILE . 'assets/images/rating.png'; ?>);
                }
                @media only screen and (min-width: 10px) and (max-width: 1000px) {
                    .super-whats-new-wrapper {
                        margin: auto;
                        width: 100%;
                        float: left;
                        padding: 0px 20px;
                        -webkit-box-sizing: border-box;
                        -moz-box-sizing: border-box;
                        box-sizing: border-box;
                    }
                    .super-whats-new > .super-whats-new {
                        width:100%!important;
                        margin:20px 0px 0px 0px;
                    }
                    h1 {font-size: 13px;}
                    h3 {font-size: 12px;}
                    h1 img {
                        right: -40px;
                        top: -17px;
                    }
                }
                @media only screen and (min-width: 10px) and (max-width: 505px) {
                    .super-whats-new-wrapper {
                        position:relative;
                    }
                    h1 > span {
                        position: inherit;
                    }
                    h1 img {
                        right: 20px;
                        top: 38px;
                    }
                }
                </style>
                <?php
                $words = array(
                    'Superb',
                    'Super astonishing',
                    'Super awesome',
                    'Super fantastic',
                    'Super incredible',
                    'Super marvelous',
                    'Super outrageous',
                    'Super phenomenal',
                    'Super remarkable',
                    'Super spectacular',
                    'Super terrific',
                    'Super rad',
                    'Super neat',
                    'Super nice',
                    'Super cool',
                );
                shuffle($words);
                echo '<div class="super-whats-new-wrapper">';
                    echo '<div class="super-whats-new blank">';
                        echo '<a href="' . admin_url() . '">< Back to WordPress Dashboard...</a>';
                        echo '<h1><strong>Super Forms v' . $this->version . '</strong> - <span>Enjoy the new features! <img src="' . SUPER_PLUGIN_FILE . 'assets/images/emoji-happy.png" /></span></h1>';
                    echo '</div>';

                    echo '<div class="super-whats-new">';
                        echo '<h3>What\'s new in this "' . $words[0] . '" version?</h3>';
                        ob_start();
                        require_once( SUPER_PLUGIN_DIR . '/docs/changelog.md' );
                        $origin_changelog = ob_get_clean();
                        $changelog = explode("\n", $origin_changelog);
                        unset($changelog[0]);
                        foreach( $changelog as $v ) {
                            if( (empty($v)) || ($v=='') || ($v==' ') || ($v=="\n") || (strlen($v)==1) ) {
                                break;
                            }
                            echo htmlentities($v) . '<br />';
                        }
                        echo '<p><a href="https://renstillmann.github.io/super-forms/#/changelog" target="_blank">View full changelog</a></p>';
                    echo '</div>';
              
                    echo '<div class="super-whats-new blank">';

                        echo '<div class="super-whats-new rating">';
                            echo '<h3>Leave a review:</h3>';
                            echo '<p>';
                                echo 'Leave your thoughts about our work by leaving a review:<br />';
                                echo '<a target="_blank" href="https://codecanyon.net/item/super-forms-drag-drop-form-builder/13979866">Leave a review/rating</a>';
                            echo '</p>';
                        echo '</div>';

                        echo '<div class="super-whats-new">';
                            echo '<h3>Staying up to date:</h3>';
                            echo '<p>';
                                echo 'To stay up to date with the latest news regarding Super Forms, <a target="_blank" href="https://codecanyon.net/user/feeling4design/followers">follow us on codecanyon</a> and <a target="_blank" href="https://my.sendinblue.com/users/subscribe/js_id/37455/id/1">subscribe to our newsletter</a>.';
                            echo '</p>';
                        echo '</div>';

                        echo '<div class="super-whats-new">';
                            echo '<h3>Buy the developer a beer!</h3>';
                            echo 'Donate and support this ' . str_replace('Super', '', $words[0]) . ' plugin:';
                            echo '<form style="margin-top:15px;" target="_blank" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">';
                                echo '<input type="hidden" name="cmd" value="_s-xclick">';
                                echo '<input type="hidden" name="hosted_button_id" value="WP68J5ZK3VFNJ">';
                                echo '<input type="image" src="https://www.paypalobjects.com/en_US/NL/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">';
                                echo '<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">';
                            echo '</form>';
                        echo '</div>';

                    echo '</div>';

                    echo '<div class="super-whats-new blank" style="margin-top:20px;">';
                        echo '<a href="' . admin_url() . '">< Back to WordPress Dashboard...</a>';
                    echo '</div>';

                echo '</div>';
                exit;
            }
        }


        /**
         * Automatically update Super Forms from the repository
         *
         *  @since      1.2.6
        */
        public function update_plugin() {
            // @since 3.8.0 - check if settings do not exist, make sure we save default settings
            if( !get_option( 'super_settings' ) ) {
                SUPER_Install::install();
            }

            $slug = $this->slug;
            // build-SUPER_FORMS_BUNDLE
            $slug = 'super-forms-bundle';
            // build-SUPER_FORMS_BUNDLE_END

            require_once ( 'includes/admin/plugin-update-checker/plugin-update-checker.php' );
            $MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
                'http://f4d.nl/@super-forms-updates/?action=get_metadata&slug=' . $slug,  //Metadata URL
                __FILE__, //Full path to the main plugin file.
                $slug //Plugin slug. Usually it's the same as the name of the directory.
            );
        }


        /**
         * Hook into the where query to filter custom meta data
         *
         *  @since      1.7
        */
        public static function custom_posts_where( $where, $object ) {
            global $wpdb;
            $table = $wpdb->prefix . 'posts';
            $table_meta = $wpdb->prefix . 'postmeta';
            $where = "";
            if( (isset($_GET['s'])) && ($_GET['s']!='') ) {
                $s = sanitize_text_field($_GET['s']);
                $where .= " AND (";
                    $where .= "($table.post_title LIKE '%$s%') OR ($table.post_excerpt LIKE '%$s%') OR ($table.post_content LIKE '%$s%') OR";
                    $where .= "($table_meta.meta_key = '_super_contact_entry_data' AND $table_meta.meta_value LIKE '%$s%') OR";
                    $where .= "($table_meta.meta_key = '_super_contact_entry_ip' AND $table_meta.meta_value LIKE '%$s%') OR";
                    $where .= "($table_meta.meta_key = '_super_contact_entry_status' AND $table_meta.meta_value LIKE '%$s%')"; // @since 3.4.0 - custom entry status
                $where .= ")";
            }
            if( ( (isset($_GET['sffrom'])) && ($_GET['sffrom']!='') ) && ( (isset($_GET['sfto'])) && ($_GET['sfto']!='') ) ) {
                $sffrom = date('Y-m-d', strtotime($_GET['sffrom']));
                $sfto = date('Y-m-d', strtotime($_GET['sfto']));
                $where .= " AND ( (date($table.post_date) BETWEEN '$sffrom' AND '$sfto') )";
            }
            if( (isset($_GET['super_form_filter'])) && (absint($_GET['super_form_filter'])!=0) ) {
                $super_form_filter = absint($_GET['super_form_filter']);
                $where .= " AND (";
                    $where .= "($table.post_parent = $super_form_filter)";
                $where .= ")";
            }
            if( (isset($_GET['post_status'])) && ($_GET['post_status']!='') && ($_GET['post_status']!='all') ) {
                $post_status = sanitize_text_field($_GET['post_status']);
                $where .= " AND (";
                    $where .= "($table.post_status = '$post_status')";
                $where .= ")";
            }else{
                // @since 2.8.6 - fix issue with showing "All" contact entries also showing deleted items
                $where .= " AND (";
                    $where .= "($table.post_status != 'trash')";
                $where .= ")";     
            }
            $where .= " AND (";
                $where .= "($table.post_type = 'super_contact_entry')";
            $where .= ")";
            return $where;
        }


        /**
         * Hook into the join query to filter custom meta data
         *
         *  @since      1.7
        */
        public static function custom_posts_join( $join, $object ) {
            if( (isset($_GET['s'])) && ($_GET['s']!='') ) {
                global $wpdb;
                $prefix = $wpdb->prefix;
                $table_posts = $wpdb->prefix . 'posts';
                $table_meta = $wpdb->prefix . 'postmeta';
                $join = "INNER JOIN $table_meta ON $table_meta.post_id = $table_posts.ID";
            }
            return $join;
        }


        /**
         * Hook into the groupby query to filter custom meta data
         *
         *  @since      1.7
        */
        public static function custom_posts_groupby( $groupby, $object ) {
            if( (isset($_GET['s'])) && ($_GET['s']!='') ) {
                global $wpdb;
                $table = $wpdb->prefix . 'posts';
                $groupby = "$table.ID";
            }
            return $groupby;
        }


        /**
         * Hook into the dynamic javascript functions of Super Forms
         *
         *  @since      1.0.0
        */
        public static function add_dynamic_function( $functions ) {
            $functions['before_validating_form_hook'][] = array( 'name' => 'conditional_logic' );
            $functions['after_initializing_forms_hook'][] = array( 'name' => 'conditional_logic' );
            $functions['after_dropdown_change_hook'][] = array( 'name' => 'conditional_logic' );           
            $functions['after_field_change_blur_hook'][] = array( 'name' => 'conditional_logic' );
            $functions['after_radio_change_hook'][] = array( 'name' => 'conditional_logic' );
            $functions['after_checkbox_change_hook'][] = array( 'name' => 'conditional_logic' );

            // @since 3.5.0
            $functions['after_dropdown_change_hook'][] = array( 'name' => 'calculate_distance' );

            // @since 3.5.0
            $functions['before_validating_form_hook'][] = array( 'name' => 'google_maps_init' );
            $functions['after_initializing_forms_hook'][] = array( 'name' => 'google_maps_init' );
            $functions['after_dropdown_change_hook'][] = array( 'name' => 'google_maps_init' );           
            $functions['after_field_change_blur_hook'][] = array( 'name' => 'google_maps_init' );
            $functions['after_radio_change_hook'][] = array( 'name' => 'google_maps_init' );
            $functions['after_checkbox_change_hook'][] = array( 'name' => 'google_maps_init' );

            return $functions;
        }


        /**
         * Replace HTML element {tags} with field values
         *
         *  @since      1.2.7
        */
        public static function add_html_tags_dynamic_function( $functions ) {
            $functions['after_initializing_forms_hook'][] = array(
                'name' => 'init_replace_html_tags'
            );
            $functions['before_validating_form_hook'][] = array(
                'name' => 'init_replace_html_tags'
            );
            $functions['after_dropdown_change_hook'][] = array(
                'name' => 'init_replace_html_tags'
            );
            $functions['after_field_change_blur_hook'][] = array(
                'name' => 'init_replace_html_tags'
            );
            $functions['after_radio_change_hook'][] = array(
                'name' => 'init_replace_html_tags'
            );
            $functions['after_checkbox_change_hook'][] = array(
                'name' => 'init_replace_html_tags'
            );
            return $functions;
        }

        /**
         * Replace action attribute {tags} with field values
         *
         *  @since      4.4.6
        */
        public static function add_action_attribute_tags_dynamic_function( $functions ) {
            $functions['after_initializing_forms_hook'][] = array(
                'name' => 'init_replace_post_url_tags'
            );
            $functions['before_validating_form_hook'][] = array(
                'name' => 'init_replace_post_url_tags'
            );
            $functions['after_dropdown_change_hook'][] = array(
                'name' => 'init_replace_post_url_tags'
            );
            $functions['after_field_change_blur_hook'][] = array(
                'name' => 'init_replace_post_url_tags'
            );
            $functions['after_radio_change_hook'][] = array(
                'name' => 'init_replace_post_url_tags'
            );
            $functions['after_checkbox_change_hook'][] = array(
                'name' => 'init_replace_post_url_tags'
            );
            return $functions;
        }

            

        /**
         * Enqueue [super-form] shortcode styles
         *
         *  @since      1.1.9.5
        */
        public static function enqueue_element_styles() {
            wp_enqueue_style( 'super-font-awesome', SUPER_PLUGIN_FILE . 'assets/css/fonts/css/all.min.css', array(), SUPER_VERSION );
            wp_enqueue_style( 'super-elements', SUPER_PLUGIN_FILE . 'assets/css/frontend/elements.css', array(), SUPER_VERSION );
        }


        /**
         * Enqueue [super-form] shortcode scripts
         *
         *  @since      1.1.9.5
        */
        public static function enqueue_element_scripts( $settings=array(), $ajax=false ) {

            $handle = 'super-common';
            $name = str_replace( '-', '_', $handle ) . '_i18n';
            wp_register_script( $handle, SUPER_PLUGIN_FILE . 'assets/js/common.js', array( 'jquery' ), SUPER_VERSION, false );  

            // @since 3.1.0 - add WPML langauge parameter to ajax URL's required for for instance when redirecting to WooCommerce checkout/cart page
            $ajax_url = SUPER_Forms()->ajax_url();
            $my_current_lang = apply_filters( 'wpml_current_language', NULL ); 
            if ( $my_current_lang ) $ajax_url = add_query_arg( 'lang', $my_current_lang, $ajax_url );

            wp_localize_script(
                $handle,
                $name,
                array( 
                    'super_ajax_url'=>SUPER_Forms()->super_ajax_url(),
                    'ajaxurl'=>$ajax_url,
                    'preload'=>$settings['form_preload'],
                    'duration'=>$settings['form_duration'],
                    'dynamic_functions' => SUPER_Common::get_dynamic_functions(),
                    'loading'=>SUPER_Forms()->common_i18n['loading'],
                    'tab_index_exclusion' => SUPER_Forms()->common_i18n['tab_index_exclusion'],
                    'directions'=>SUPER_Forms()->common_i18n['directions'],
                    'errors'=>SUPER_Forms()->common_i18n['errors'],
                    // @since 3.6.0 - google tracking
                    'ga_tracking' => ( !isset( $settings['form_ga_tracking'] ) ? "" : $settings['form_ga_tracking'] ) 
                )
            );
            wp_enqueue_script( $handle );
            
            $handle = 'super-elements';
            $name = str_replace( '-', '_', $handle ) . '_i18n';
            wp_register_script( $handle, SUPER_PLUGIN_FILE . 'assets/js/frontend/elements.js', array( 'super-common' ), SUPER_VERSION, false );  
            wp_localize_script( $handle, $name, SUPER_Forms()->elements_i18n );
            wp_enqueue_script( $handle );

            $handle = 'super-frontend-common';
            $name = str_replace( '-', '_', $handle ) . '_i18n';
            wp_register_script( $handle, SUPER_PLUGIN_FILE . 'assets/js/frontend/common.js', array( 'super-common' ), SUPER_VERSION, false );  
            wp_localize_script( $handle, $name, array( 'includes_url'=>includes_url(), 'plugin_url'=>SUPER_PLUGIN_FILE ) );
            wp_enqueue_script( $handle );

            // Add js files that are needed in case when theme makes an Ajax call to load content dynamically
            if( $ajax==true ) {
                // We need to add these, just in case the form has an file upload element
                wp_enqueue_script( 'jquery-ui-datepicker', false, array( 'jquery' ), SUPER_VERSION, false );
                wp_enqueue_script( 'jquery-timepicker', SUPER_PLUGIN_FILE . 'assets/js/frontend/timepicker.js', array( 'jquery' ), SUPER_VERSION, false );
                wp_enqueue_script( 'super-date-format', SUPER_PLUGIN_FILE . 'assets/js/frontend/date-format.js', array( 'jquery' ), SUPER_VERSION, false );
        
                wp_enqueue_style( 'super-simpleslider', SUPER_PLUGIN_FILE . 'assets/css/backend/simpleslider.css', array(), SUPER_VERSION, false ); 
                wp_enqueue_script( 'super-simpleslider', SUPER_PLUGIN_FILE . 'assets/js/backend/simpleslider.js', array( 'jquery' ), SUPER_VERSION, false );

                $dir = SUPER_PLUGIN_FILE . 'assets/js/frontend/jquery-file-upload/';
                wp_enqueue_script( 'super-upload-iframe-transport', $dir . 'jquery.iframe-transport.js', array( 'jquery', 'jquery-ui-widget' ), SUPER_VERSION, false );
                wp_enqueue_script( 'super-upload-fileupload', $dir . 'jquery.fileupload.js', array( 'jquery', 'jquery-ui-widget' ), SUPER_VERSION, false );
                wp_enqueue_script( 'super-upload-fileupload-process', $dir . 'jquery.fileupload-process.js', array( 'jquery', 'jquery-ui-widget' ), SUPER_VERSION, false );
                wp_enqueue_script( 'super-upload-fileupload-validate', $dir . 'jquery.fileupload-validate.js', array( 'jquery', 'jquery-ui-widget' ), SUPER_VERSION, false );
                
                // @since 3.1.0 - google maps API places library
                if( !empty($settings['form_google_places_api']) ) {
                    wp_enqueue_script( 'super-google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=' . $settings['form_google_places_api'] . '&libraries=drawing,geometry,places,visualization&callback=SUPER.google_maps_init', array( 'super-common' ), SUPER_VERSION, false );
                }

                // Needed for Text Editor
                wp_enqueue_media();

            }

            // @since 1.2.8 -   super_after_enqueue_element_scripts_action
            do_action( 'super_after_enqueue_element_scripts_action', array( 'settings'=>$settings, 'ajax'=>$ajax ) );

        }


        /**
         * Enqueue scripts before ajax call is made
         *
         *  @since      1.1.9.5
        */
        public static function load_frontend_scripts_before_ajax() {
            $global_settings = SUPER_Common::get_global_settings();
            if( isset( $global_settings['enable_ajax'] ) ) {
                if( $global_settings['enable_ajax']=='1' ) {            
                    require_once( SUPER_PLUGIN_DIR . '/includes/class-settings.php' );
                    $default_settings = SUPER_Settings::get_defaults();
                    $global_settings = array_merge( $default_settings, $global_settings );
                    self::enqueue_element_styles();
                    self::enqueue_element_scripts( $global_settings, true );
                }
            }
        }


        /**
         * Include required ajax files.
         *
         *  @since      1.0.0
        */
        public function enqueue_scripts_before_ajax_calls() {
            
            include_once('includes/class-ajax.php'); // Ajax functions for admin and the front-end
        
        }

        
        /**
         * Include required ajax files.
         *
         *  @since      1.0.0
        */
        public function ajax_includes() {
            
            include_once( 'includes/class-ajax.php' ); // Ajax functions for admin and the front-end
        
        }

        
        /**
         * Include required frontend files.
         *
         *  @since      1.0.0
        */
        public function frontend_includes() {
                        
        }

        
        /**
         * Init Super Forms when WordPress Initialises.
         *
         *  @since      1.0.0
        */
        public function init() {

            // Before init action
            do_action('before_super_init');
    
            $this->load_plugin_textdomain();

            // @since 3.2.0 - filter hook for javascrip translation string and other manipulation
            $this->common_i18n = apply_filters( 'super_common_i18n_filter', 
                array(  

                    // @since 3.2.0 - dynamic tab index class exclusion
                    'tab_index_exclusion' => '.super-color, .super-calculator, .super-toggle, .super-spacer, .super-divider, .super-recaptcha, .super-heading, .super-image, .super-skype, .super-rating, .super-file, .super-slider, .hidden, .super-prev-multipart, .super-html',

                    'loading' => esc_html__( 'Loading...', 'super-forms' ),
                    'directions' => array(
                        'next' => esc_html__( 'Next', 'super-forms' ),
                        'prev' => esc_html__( 'Prev', 'super-forms' ),
                    ),
                    'errors' => array(
                        'fields' => array(
                            'required' => esc_html__( 'Field is required!', 'super-forms' )
                        ),
                        'file_upload' => array(
                            'upload_limit_reached' => esc_html__( 'Upload size limit reached!', 'super-forms' ),
                            'incorrect_file_extension' => esc_html__( 'Sorry, file extension is not allowed!', 'super-forms' ),
                            'filesize_too_big' => esc_html__( 'Filesize is too big', 'super-forms' ),
                        ),
                        'distance_calculator' => array(
                            'zero_results' => esc_html__( 'Sorry, no distance could be calculated based on entered data. Please enter a valid address or zipcode.', 'super-forms' ),
                            'error' => esc_html__( 'Something went wrong while calculating the distance.', 'super-forms' )
                        )
                    )
                )
            );

            // @since 3.2.0 - filter hook for javascrip translation string and other manipulation
            $this->elements_i18n = apply_filters( 'super_elements_i18n_filter', 
                array(

                    'super_ajax_url' => SUPER_Forms()->super_ajax_url(),
                    'ajaxurl' => SUPER_Forms()->ajax_url(),

                    // @since 3.2.0 - dynamic tab index class exclusion
                    'tab_index_exclusion' => $this->common_i18n['tab_index_exclusion'],

                    'monthNames' => array(
                        esc_html__( 'January', 'super-forms' ),
                        esc_html__( 'February', 'super-forms' ),
                        esc_html__( 'March', 'super-forms' ),
                        esc_html__( 'April', 'super-forms' ),
                        esc_html__( 'May', 'super-forms' ),
                        esc_html__( 'June', 'super-forms' ),
                        esc_html__( 'July', 'super-forms' ),
                        esc_html__( 'August', 'super-forms' ),
                        esc_html__( 'September', 'super-forms' ),
                        esc_html__( 'October', 'super-forms' ),
                        esc_html__( 'November', 'super-forms' ),
                        esc_html__( 'December', 'super-forms' )
                    ),
                    'monthNamesShort' => array(
                        esc_html__( 'Jan', 'super-forms' ),
                        esc_html__( 'Feb', 'super-forms' ),
                        esc_html__( 'Mar', 'super-forms' ),
                        esc_html__( 'Apr', 'super-forms' ),
                        esc_html__( 'May', 'super-forms' ),
                        esc_html__( 'Jun', 'super-forms' ),
                        esc_html__( 'Jul', 'super-forms' ),
                        esc_html__( 'Aug', 'super-forms' ),
                        esc_html__( 'Sep', 'super-forms' ),
                        esc_html__( 'Oct', 'super-forms' ),
                        esc_html__( 'Nov', 'super-forms' ),
                        esc_html__( 'Dec', 'super-forms' )
                    ),
                    'dayNames' => array(
                        esc_html__( 'Sunday', 'super-forms' ),
                        esc_html__( 'Monday', 'super-forms' ),
                        esc_html__( 'Tuesday', 'super-forms' ),
                        esc_html__( 'Wednesday', 'super-forms' ),
                        esc_html__( 'Thursday', 'super-forms' ),
                        esc_html__( 'Friday', 'super-forms' ),
                        esc_html__( 'Saturday', 'super-forms' )
                    ),
                    'dayNamesShort' => array(
                        esc_html__( 'Sun', 'super-forms' ),
                        esc_html__( 'Mon', 'super-forms' ),
                        esc_html__( 'Tue', 'super-forms' ),
                        esc_html__( 'Wed', 'super-forms' ),
                        esc_html__( 'Thu', 'super-forms' ),
                        esc_html__( 'Fri', 'super-forms' ),
                        esc_html__( 'Sat', 'super-forms' )
                    ),
                    'dayNamesMin' => array(
                        esc_html__( 'Su', 'super-forms' ),
                        esc_html__( 'Mo', 'super-forms' ),
                        esc_html__( 'Tu', 'super-forms' ),
                        esc_html__( 'We', 'super-forms' ),
                        esc_html__( 'Th', 'super-forms' ),
                        esc_html__( 'Fr', 'super-forms' ),
                        esc_html__( 'Sa', 'super-forms' )
                    ),
                    'weekHeader' => esc_html__( 'Wk', 'super-forms' ),
                )
            );

            // Init action
            do_action('super_init');
            
        }
        
        
        /**
         * Call Classes and Execute Functions based on current screen ID 
         *
         * @param  string $current_screen
         * 
         * @since       1.0.0
        */
        public function after_screen( $current_screen ) {

            if($current_screen->id==='super-forms_page_super_create_form'){
                add_action( 'super_create_form_builder_tab', array( 'SUPER_Pages', 'builder_tab' ), 10, 1 );
                add_action( 'super_create_form_translations_tab', array( 'SUPER_Pages', 'translations_tab' ), 10, 1 );
                add_action( 'super_create_form_triggers_tab', array( 'SUPER_Pages', 'triggers_tab' ), 10, 1 );
            }

            // @since 1.7 - add the export button only on the super_contact_entry page
            if( $current_screen->id=='edit-super_contact_entry' ) {
                add_action( 'manage_posts_extra_tablenav', array( $this, 'contact_entry_export_button' ) );
                add_filter( 'posts_where', array( $this, 'custom_posts_where' ), 0, 2 );
                add_filter( 'posts_join', array( $this, 'custom_posts_join' ), 0, 2 );
                add_filter( 'posts_groupby', array( $this, 'custom_posts_groupby' ), 0, 2 );
            }

            if( $current_screen->id=='edit-super_form' ) {
                include_once( 'includes/admin/form-list-page.php' );
            }
            if( $current_screen->id=='edit-super_contact_entry' ) {
                include_once( 'includes/admin/contact-entry-list-page.php' );
            }

            // @since 1.2.8 -   check if plugin is updated
            if( $current_screen->id=='update' ) {
                if( (isset($_REQUEST['action'])) && (isset($_REQUEST['plugin'])) ) {
                    if( ($_REQUEST['action']=='upgrade-plugin') && ($_REQUEST['plugin']=='super-forms/super-forms.php') ){
                        $downloaded = wp_remote_fopen('http://f4d.nl/super-forms/download/super-forms/');
                    }
                }
            }
            
        }
    

        /**
         * Enqueue styles used for displaying messages
         * 
         * @since       1.0.6
        */
        public function enqueue_message_scripts() {
            $super_msg = SUPER_Forms()->session->get( 'super_msg' );
            if( $super_msg!=false ) {
                $global_settings = SUPER_Common::get_global_settings();
                wp_enqueue_style( 'super-font-awesome', SUPER_PLUGIN_FILE . 'assets/css/fonts/css/all.min.css', array(), SUPER_VERSION );
                wp_enqueue_style( 'super-elements', SUPER_PLUGIN_FILE . 'assets/css/frontend/elements.css', array(), SUPER_VERSION );
                
                $handle = 'super-common';
                $name = str_replace( '-', '_', $handle ) . '_i18n';
                wp_register_script( $handle, SUPER_PLUGIN_FILE . 'assets/js/common.js', array( 'jquery' ), SUPER_VERSION, false );

                // @since 3.1.0 - add WPML langauge parameter to ajax URL's required for for instance when redirecting to WooCommerce checkout/cart page
                $ajax_url = SUPER_Forms()->ajax_url();
                $my_current_lang = apply_filters( 'wpml_current_language', NULL ); 
                if ( $my_current_lang ) $ajax_url = add_query_arg( 'lang', $my_current_lang, $ajax_url );

                wp_localize_script(
                    $handle,
                    $name,
                    array(
                        'super_ajax_url'=>SUPER_Forms()->super_ajax_url(),
                        'ajaxurl'=>$ajax_url,
                        'preload'=>$global_settings['form_preload'],
                        'duration'=>$global_settings['form_duration'],
                        'dynamic_functions' => SUPER_Common::get_dynamic_functions(),
                        'loading'=>$this->common_i18n['loading'],
                        'tab_index_exclusion'=>$this->common_i18n['tab_index_exclusion'],
                        'directions'=>$this->common_i18n['directions'],
                        'errors'=>$this->common_i18n['errors'],
                        // @since 3.6.0 - google tracking
                        'ga_tracking' => ( !isset( $global_settings['form_ga_tracking'] ) ? "" : $global_settings['form_ga_tracking'] ) 
                    )
                );
                wp_enqueue_script( $handle );

                $handle = 'super-elements';
                $name = str_replace( '-', '_', $handle ) . '_i18n';
                wp_register_script( $handle, SUPER_PLUGIN_FILE . 'assets/js/frontend/elements.js', array( 'super-common' ), SUPER_VERSION, false );  
                wp_localize_script(
                    $handle,
                    $name,
                    $this->elements_i18n
                );
                wp_enqueue_script( $handle );
                wp_enqueue_script( 'super-frontend-common', SUPER_PLUGIN_FILE . 'assets/js/frontend/common.js', array( 'super-common' ), SUPER_VERSION, false );
            }
        }


        /**
         * Enqueue scripts for each admin page
         * 
         * @since       1.0.0
        */
        public function enqueue_scripts() {
            
            if ( function_exists( 'get_current_screen' ) ) {
                $current_screen = get_current_screen();
            }else{
                $current_screen = new stdClass();
                $current_screen->id = '';
            }

            if( ( $current_screen->id=='super-forms_page_super_create_form' ) || ( $current_screen->id=='super-forms_page_super_settings' ) ) {
                wp_enqueue_media();
            }

            // Enqueue Javascripts
            if( $enqueue_scripts = self::get_scripts() ) {
                foreach( $enqueue_scripts as $handle => $args ) {
                    if ( ( in_array( $current_screen->id, $args['screen'] ) ) || ( $args['screen'][0]=='all' ) ) {
                        if($args['method']=='register'){
                            self::$scripts[] = $handle;
                            wp_register_script( $handle, $args['src'], $args['deps'], $args['version'], $args['footer'] );
                        }else{
                            wp_enqueue_script( $handle, $args['src'], $args['deps'], $args['version'], $args['footer'] );
                        }
                    }
                }
            }
            
            // Enqueue Styles
            if( $enqueue_styles = self::get_styles() ) {
                foreach( $enqueue_styles as $handle => $args ) {
                    if ( ( in_array( $current_screen->id, $args['screen'] ) ) || ( $args['screen'][0]=='all' ) ) {
                        if($args['method']=='register'){
                            wp_register_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'] );
                        }else{
                            wp_enqueue_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'] );
                        }
                    }
                }
            }
            
        }
        
        
        /**
         * Get styles for the backend
         *
         * @access private
         * @return array
         * [$handle, $src, $deps, $ver, $media]
         *
         * @since       1.0.0
        */
        public static function get_styles() {

            $assets_path    = str_replace( array( 'http:', 'https:' ), '', SUPER_PLUGIN_FILE ) . 'assets/';
            $backend_path   = $assets_path . 'css/backend/';
            $frontend_path  = $assets_path . 'css/frontend/';
            $fonts_path  = $assets_path . 'css/fonts/css/';
            
            return apply_filters( 
                'super_enqueue_styles', 
                array(
                    'super-common' => array(
                        'src'     => $backend_path . 'common.css',
                        'deps'    => array( 'farbtastic', 'wp-color-picker' ),
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array(
                            'super-forms_page_super_create_form',
                            'super-forms_page_super_settings'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'jquery-ui' => array(
                        'src'     => $backend_path . 'jquery-ui.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                            'edit-super_contact_entry'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-create-form' => array(
                        'src'     => $backend_path . 'create-form.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-create-form-responsive' => array(
                        'src'     => $backend_path . 'create-form-responsive.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 'super-forms_page_super_create_form' ),
                        'method'  => 'enqueue',
                    ),
                    'super-flags' => array(
                        'src'     => $frontend_path . 'flags.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-contact-entry' => array(
                        'src'     => $backend_path . 'contact-entry.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 
                            'edit-super_contact_entry',
                            'admin_page_super_contact_entry'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-settings' => array(
                        'src'     => $backend_path . 'settings.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 'super-forms_page_super_settings' ),
                        'method'  => 'enqueue',
                    ),
                    'super-marketplace' => array(
                        'src'     => $backend_path . 'marketplace.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 'super-forms_page_super_marketplace' ),
                        'method'  => 'enqueue',
                    ),
                    'super-colorpicker' => array(
                        'src'     => $frontend_path . 'colorpicker.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array(
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-simpleslider' => array(
                        'src'     => $backend_path . 'simpleslider.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array(
                            'super-forms_page_super_create_form',
                            'super-forms_page_super_settings'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-tooltip' => array(
                        'src'     => $backend_path . 'tooltips.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array(
                            'super-forms_page_super_create_form',
                            'super-forms_page_super_settings'
                        ),
                        'method'  => 'enqueue',
                    ),                  
                    'super-font-awesome' => array(
                        'src'     => $fonts_path . 'all.min.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array(
                            'super-forms_page_super_create_form',
                            'super-forms_page_super_settings',
                            'edit-super_contact_entry',
                            'admin_page_super_contact_entry',
                            'super-forms_page_super_marketplace'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-elements' => array(
                        'src'     => $frontend_path . 'elements.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                        ),
                        'method'  => 'enqueue',
                    ),

                    // @since 4.0.0 - hints/introduction
                    'super-hints' => array(
                        'src'     => $backend_path . 'hints.css',
                        'deps'    => '',
                        'version' => SUPER_VERSION,
                        'media'   => 'all',
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                        ),
                        'method'  => 'enqueue',
                    ),

                )
            );
        }
        
        
        /**
         * Get scripts for the backend
         *
         * @access private
         * @return array
         * [$handle, $src, $deps, $ver, $in_footer]
         *
         * @since       1.0.0
        */
        public static function get_scripts() {
            
            $assets_path    = str_replace( array( 'http:', 'https:' ), '', SUPER_PLUGIN_FILE ) . 'assets/';
            $backend_path   = $assets_path . 'js/backend/';
            $frontend_path  = $assets_path . 'js/frontend/';
            $global_settings = SUPER_Common::get_global_settings();
            return apply_filters( 
                'super_enqueue_scripts', 
                array(   
                    'jquery-ui-datepicker' => array(
                        'src'     => $frontend_path . 'timepicker.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-timepicker' => array(
                        'src'     => $frontend_path . 'timepicker.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-date-format' => array(
                        'src'     => $frontend_path . 'date-format.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-skype' => array(
                        'src'     => 'https://secure.skypeassets.com/i/scom/js/skype-uri.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-common' => array(
                        'src'     => $assets_path . 'js/common.js',
                        'deps'    => array( 'jquery', 'farbtastic', 'wp-color-picker' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                            'super-forms_page_super_settings'
                        ),
                        'method'  => 'register', // Register because we need to localize it
                        'localize'=> array(
                            'preload' => ( !isset( $global_settings['form_preload'] ) ? '1' : $global_settings['form_preload'] ),
                            'duration' => ( !isset( $global_settings['form_duration'] ) ? 500 : $global_settings['form_duration'] ),
                            'dynamic_functions' => SUPER_Common::get_dynamic_functions(),
                            'loading' => SUPER_Forms()->common_i18n['loading'],
                            'tab_index_exclusion' => SUPER_Forms()->common_i18n['tab_index_exclusion'],
                            'directions' => SUPER_Forms()->common_i18n['directions'],
                            'errors' => SUPER_Forms()->common_i18n['errors'],
                            // @since 3.6.0 - google tracking
                            'ga_tracking' => ( !isset( $global_settings['form_ga_tracking'] ) ? "" : $global_settings['form_ga_tracking'] ) 

                        )
                    ),
                    'super-backend-common' => array(
                        'src'     => $backend_path . 'common.js',
                        'deps'    => array( 'super-common' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array(
                            'super-forms_page_super_create_form',
                            'super-forms_page_super_settings'
                        ),
                        'method'  => 'enqueue',
                    ),

                    // @since 4.0.0 - hints/introduction
                    'super-hints' => array(
                        'src'     => $backend_path . 'hints.js',
                        'deps'    => array( 'super-backend-common' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-create-form' => array(
                        'src'     => $backend_path . 'create-form.js',
                        'deps'    => array( 'super-backend-common', 'jquery-ui-sortable', 'super-hints' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array(
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'register', // Register because we need to localize it
                        'localize'=> array(
                            'super_ajax_url' => SUPER_Forms()->super_ajax_url(),
                            'not_editing_an_element' => sprintf( esc_html__( 'You are currently not editing an element.%sEdit any alement by clicking the %s icon.', 'super-forms' ), '<br />', '<i class="fa fa-pencil"></i>' ),
                            'no_backups_found' => esc_html__( 'No backups found...', 'super-forms' ),
                            'confirm_reset' => esc_html__( 'Are you sure you want to reset all the form settings according to your current global settings?', 'super-forms' ),
                            'confirm_deletion' => esc_html__( 'Please confirm deletion!', 'super-forms' ),
                            'confirm_import' => esc_html__( "Please confirm import!\nThis will override your current progress!", 'super-forms' ),
                            'export_form_error' => esc_html__( 'Something went wrong while exporting form data.', 'super-forms' ),
                            'import_form_error' => esc_html__( 'Something went wrong while importing form data.', 'super-forms' ),
                            'import_form_select_option' => esc_html__( 'Please select what you want to import!', 'super-forms' ),
                            'import_form_choose_file' => esc_html__( 'Please choose an import file first!', 'super-forms' ),
                            'confirm_clear_form' => esc_html__( 'Please confirm to clear form!', 'super-forms' ),
                            'confirm_reset_submission_counter' => esc_html__( 'Please confirm to reset submission counter!', 'super-forms' ),
                            'confirm_load_form' => esc_html__( 'This will delete your current progress. Before you proceed, please confirm that you want to delete all elements and insert this example form!', 'super-forms' ),
                            'alert_select_form' => esc_html__( 'You did not select a form!', 'super-forms' ),
                            'alert_save' => esc_html__( 'Before you can preview it, you need to save your form!', 'super-forms' ),
                            'alert_duplicate_field_names' => esc_html__( 'You have duplicate field names. Please make sure each field has a unique name!', 'super-forms' ),
                            'alert_multipart_error' => esc_html__( 'It\'s not possible to insert a Multipart inside a Multipart', 'super-forms' ),
                            'alert_empty_field_name' => esc_html__( 'Unique field name may not be empty!', 'super-forms' ),
                            'deleting' => esc_html__( 'Deleting...', 'super-forms' )
                        ),
                    ),
                    'super-contact-entry' => array(
                        'src'     => $backend_path . 'contact-entry.js',
                        'deps'    => array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-sortable' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array(
                            'edit-super_contact_entry',
                            'admin_page_super_contact_entry'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-jquery-pep' => array(
                        'src'     => $backend_path . 'jquery-pep.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 'super-forms_page_super_create_form' ),
                        'method'  => 'enqueue',
                    ),
                    'super-settings' => array(
                        'src'     => $backend_path . 'settings.js',
                        'deps'    => array( 'jquery-ui-datepicker', 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 'super-forms_page_super_settings' ),
                        'method'  => 'register', // Register because we need to localize it
                        'localize' => array(
                            'import_working' => esc_html__( 'Importing...', 'super-forms' ),
                            'import_completed' => esc_html__( 'Import completed', 'super-forms' ),
                            'import_error' => esc_html__( 'Import failed: something went wrong while importing.', 'super-forms' ),
                            'export_entries_working' => esc_html__( 'Downloading file...', 'super-forms' ),
                            'export_entries_error' => esc_html__( 'Something went wrong while downloading export.', 'super-forms' ),
                            'deactivate_confirm' => esc_html__( 'This will deactivate your plugin for this domain. Click OK if you are sure to continue!', 'super-forms' ),
                            'deactivate_working' => esc_html__( 'Deactivating plugin...', 'super-forms' ),
                            'deactivate_error' => esc_html__( 'Something went wrong while deactivating the plugin.', 'super-forms' ),
                            'restore_default_confirm' => esc_html__( 'This will delete all your current settings. Click OK if you are sure to continue!', 'super-forms' ),
                            'restore_default_working' => esc_html__( 'Restoring settings...', 'super-forms' ),
                            'restore_default_error' => esc_html__( 'Something went wrong while restoring default settings.', 'super-forms' ),
                            'save_loading' => esc_html__( 'Loading...', 'super-forms' ),
                            'save_settings' => esc_html__( 'Save Settings', 'super-forms' ),
                            'save_success' => esc_html__( 'All settings have been saved.', 'super-forms' ),
                            'save_error' => esc_html__( 'Something went wrong while saving your settings.', 'super-forms' ),
                        ),
                    ),
                    'super-marketplace' => array(
                        'src'     => $backend_path . 'marketplace.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 'super-forms_page_super_marketplace' ),
                        'method'  => 'register', // Register because we need to localize it
                        'localize' => array(
                            'reason' => esc_html__( 'Reason', 'super-forms' ),
                            'reason_empty' => esc_html__( 'Please enter a reason!', 'super-forms' ),
                            'connection_lost' => esc_html__( 'Connection lost, please try again', 'super-forms' ),
                        ),
                    ),
                    'super-colorpicker' => array(
                        'src'     => $frontend_path . 'colorpicker.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-upload-iframe-transport' => array(
                        'src'     => $frontend_path . 'jquery-file-upload/jquery.iframe-transport.js',
                        'deps'    => array( 'jquery', 'jquery-ui-widget' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-upload-fileupload' => array(
                        'src'     => $frontend_path . 'jquery-file-upload/jquery.fileupload.js',
                        'deps'    => array( 'jquery', 'jquery-ui-widget' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-upload-fileupload-process' => array(
                        'src'     => $frontend_path . 'jquery-file-upload/jquery.fileupload-process.js',
                        'deps'    => array( 'jquery', 'jquery-ui-widget' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-upload-fileupload-validate' => array(
                        'src'     => $frontend_path . 'jquery-file-upload/jquery.fileupload-validate.js',
                        'deps'    => array( 'jquery', 'jquery-ui-widget' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-simpleslider' => array(
                        'src'     => $backend_path . 'simpleslider.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                            'super-forms_page_super_settings'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-tooltip' => array(
                        'src'     => $backend_path . 'tooltips.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                            'super-forms_page_super_settings'
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-masked-input' => array(
                        'src'     => $frontend_path . 'masked-input.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-masked-currency' => array(
                        'src'     => $frontend_path . 'masked-currency.js',
                        'deps'    => array( 'jquery' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array( 
                            'super-forms_page_super_create_form',
                        ),
                        'method'  => 'enqueue',
                    ),
                    'super-elements' => array(
                        'src'     => $frontend_path . 'elements.js',
                        'deps'    => array( 'super-backend-common' ),
                        'version' => SUPER_VERSION,
                        'footer'  => false,
                        'screen'  => array(
                            'super-forms_page_super_create_form',
                        ),
                        'method'  => 'register',
                        'localize' => SUPER_Forms()->elements_i18n,
                    ),
                )
            );
        }
        
        
        /**
         * Localize a script once.
         *
         * @access private
         * @param  string $handle
         *
         * @since       1.0.0
        */
        private static function localize_script( $handle ) {
            if ( ! in_array( $handle, self::$wp_localize_scripts ) && wp_script_is( $handle, 'registered' ) && ( $data = self::get_script_data( $handle ) ) ) {
                $name = str_replace( '-', '_', $handle ) . '_i18n';
                self::$wp_localize_scripts[] = $handle;
                wp_localize_script( $handle, $name, apply_filters( $name, $data ) );
                wp_enqueue_script( $handle );
            }        
        }
        
        
        /**
         * Localize scripts only when enqueued
         *
         * @access private
         * @param  string $handle
         *
         * @since       1.0.0
        */
        public static function localize_printed_scripts() {
            foreach ( self::$scripts as $handle ) {
                self::localize_script( $handle );
            }
        }
        
        
        /**
         * Return data for script handles.
         * @access private
         * @param  string $handle
         * @return array|bool
        */
        private static function get_script_data( $handle ) {
            $scripts = self::get_scripts();
            if( isset( $scripts[$handle]['localize'] ) ) {
                return $scripts[$handle]['localize'];
            }
            return false;
        }


        /**
         * Display message before the content
         *
         * @param  string $content
         *
         * @since       1.0.6
        */
        public function print_message_before_content( $query ) {
            $super_msg = SUPER_Forms()->session->get( 'super_msg' );
            if( $super_msg!=false ) {
                do_action( 'super_before_printing_message', $query );
                if( $super_msg['msg']!='' ) {
                    $custom_content = '';
                    $custom_content .= '<div class="super-msg super-'.$super_msg['type'].' super-visible">';
                    $custom_content .= $super_msg['msg'];
                    $custom_content .= '<span class="close"></span>';
                    $custom_content .= '</div>';
                    // @since 2.6.0 - also load the correct styles for success message even if we are on a page that hasn't loaded these styles
                    $form_id = absint($super_msg['data']['hidden_form_id']['value']);
                    echo '<div class="super-form-' . $form_id . '">' . $custom_content . '</div>';
                    $style_content  = '';
                    $settings = $super_msg['settings'];
                    if( ( isset( $settings['theme_style'] ) ) && ( $settings['theme_style']!='' ) ) {
                        $style_content .= require( SUPER_PLUGIN_DIR . '/assets/css/frontend/themes/' . str_replace( 'super-', '', $settings['theme_style'] ) . '.php' );
                    }
                    $style_content .= require( SUPER_PLUGIN_DIR . '/assets/css/frontend/themes/style-default.php' );
                    SUPER_Forms()->form_custom_css .= apply_filters( 'super_form_styles_filter', $style_content, array( 'id'=>$form_id, 'settings'=>$settings ) );
                    
                    $global_settings = SUPER_Common::get_global_settings();
                    if( !isset( $global_settings['theme_custom_css'] ) ) $global_settings['theme_custom_css'] = '';
                    $global_settings['theme_custom_css'] = stripslashes($global_settings['theme_custom_css']);
                    SUPER_Forms()->form_custom_css .= $global_settings['theme_custom_css'];
                    
                    if( !isset( $settings['form_custom_css'] ) ) $settings['form_custom_css'] = '';
                    $settings['form_custom_css'] = stripslashes($settings['form_custom_css']);
                    SUPER_Forms()->form_custom_css .= $settings['form_custom_css'];
                    
                    if( SUPER_Forms()->form_custom_css!='' ) {
                        echo '<style type="text/css">' . SUPER_Forms()->form_custom_css . '</style>';
                    }

                    SUPER_Forms()->session->set( 'super_msg', false );
                }
            }
        }


        /**
         * Duplicates a Contact Entry
         *
         * @since       3.3.0
        */
        public function duplicate_contact_entry_action() {
            if ( empty( $_REQUEST['post'] ) ) {
                wp_die( esc_html__( 'No Contact Entry to duplicate has been supplied!', 'super-forms' ) );
            }

            // Get the original page
            $id = isset( $_REQUEST['post'] ) ? absint( $_REQUEST['post'] ) : '';

            check_admin_referer( 'super-duplicate-contact-entry_' . $id );

            $post = $this->get_contact_entry_to_duplicate( $id );

            // Copy the page and insert it
            if ( ! empty( $post ) ) {
                $new_id = $this->duplicate_contact_entry( $post );
                do_action( 'super_duplicate_contact_entry', $new_id, $post );
                wp_redirect( admin_url( 'admin.php?page=super_contact_entry&id=' . $new_id ) );
                exit;
            } else {
                wp_die( esc_html__( 'Contact Entry creation failed, could not find original Contact Entry:', 'super-forms' ) . ' ' . $id );
            }
        }
        public function duplicate_contact_entry( $post, $parent = 0, $post_status = '' ) {
            global $wpdb;
            $new_post_author = wp_get_current_user();
            $new_post_date = current_time( 'mysql' );
            $new_post_date_gmt = get_gmt_from_date( $new_post_date );
            if ( $parent > 0 ) {
                $post_parent = $parent;
                $post_status = $post_status ? $post_status : 'publish';
                $suffix = '';
            } else {
                $post_parent = $post->post_parent;
                $post_status = $post_status ? $post_status : 'publish';
                $suffix = ' ' . esc_html__( '(Copy)', 'super-forms' );
            }
            $wpdb->insert(
                $wpdb->posts,
                array(
                    'post_author'               => $new_post_author->ID,
                    'post_date'                 => $new_post_date,
                    'post_date_gmt'             => $new_post_date_gmt,
                    'post_content'              => $post->post_content,
                    'post_content_filtered'     => $post->post_content_filtered,
                    'post_title'                => $post->post_title . $suffix,
                    'post_excerpt'              => $post->post_excerpt,
                    'post_status'               => $post_status,
                    'post_type'                 => $post->post_type,
                    'comment_status'            => $post->comment_status,
                    'ping_status'               => $post->ping_status,
                    'post_password'             => $post->post_password,
                    'to_ping'                   => $post->to_ping,
                    'pinged'                    => $post->pinged,
                    'post_modified'             => $new_post_date,
                    'post_modified_gmt'         => $new_post_date_gmt,
                    'post_parent'               => $post_parent,
                    'menu_order'                => $post->menu_order,
                    'post_mime_type'            => $post->post_mime_type
                )
            );
            $new_post_id = $wpdb->insert_id;
            $this->duplicate_entry_post_meta( $post->ID, $new_post_id );
            return $new_post_id;
        }
        private function get_contact_entry_to_duplicate( $id ) {
            global $wpdb;
            $id = absint( $id );
            if ( ! $id ) {
                return false;
            }
            $post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );
            if ( isset( $post->post_type ) && $post->post_type == "revision" ) {
                $id   = $post->post_parent;
                $post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );
            }
            return $post[0];
        }
        private function duplicate_entry_post_meta( $id, $new_id ) {
            global $wpdb;
            $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d AND meta_key;", absint( $id ) ) );
            if ( count( $post_meta_infos ) != 0 ) {
                $sql_query_sel = array();
                $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                foreach ( $post_meta_infos as $meta_info ) {
                    $meta_key = $meta_info->meta_key;
                    $meta_value = addslashes( $meta_info->meta_value );
                    $sql_query_sel[]= $wpdb->prepare( "SELECT %d, '%s', '%s'", $new_id, $meta_key, $meta_value );
                }
                $sql_query.= implode( " UNION ALL ", $sql_query_sel );
                $wpdb->query($sql_query);
            }
            $entry_data = get_post_meta( $id, '_super_contact_entry_data', true );
            add_post_meta( $new_id, '_super_contact_entry_data', $entry_data );
            
            $entry_ip = get_post_meta( $id, '_super_contact_entry_ip', true );
            add_post_meta( $new_id, '_super_contact_entry_ip', $entry_ip );

            // @since 3.4.0 - custom entry status
            $entry_status = get_post_meta( $id, '_super_contact_entry_status', true );
            add_post_meta( $new_id, '_super_contact_entry_status', $entry_status );

        }

        /**
         * Duplicates a form
         *
         * @since       1.0.0
        */
        public function duplicate_form_action() {

            if ( empty( $_REQUEST['post'] ) ) {
                wp_die( esc_html__( 'No form to duplicate has been supplied!', 'super-forms' ) );
            }

            // Get the original page
            $id = isset( $_REQUEST['post'] ) ? absint( $_REQUEST['post'] ) : '';

            check_admin_referer( 'super-duplicate-form_' . $id );

            $post = $this->get_form_to_duplicate( $id );

            // Copy the page and insert it
            if ( ! empty( $post ) ) {
                $new_id = $this->duplicate_form( $post );
                do_action( 'super_duplicate_form', $new_id, $post );
                wp_redirect( admin_url( 'admin.php?page=super_create_form&id=' . $new_id ) );
                exit;
            } else {
                wp_die( esc_html__( 'Form creation failed, could not find original form:', 'super-forms' ) . ' ' . $id );
            }
        }
        public function duplicate_form( $post, $parent = 0, $post_status = '' ) {
            global $wpdb;
            $new_post_author = wp_get_current_user();
            $new_post_date = current_time( 'mysql' );
            $new_post_date_gmt = get_gmt_from_date( $new_post_date );
            if ( $parent > 0 ) {
                $post_parent = $parent;
                $post_status = $post_status ? $post_status : 'publish';
                $suffix = '';
            } else {
                $post_parent = $post->post_parent;
                $post_status = $post_status ? $post_status : 'publish';
                $suffix = ' ' . esc_html__( '(Copy)', 'super-forms' );
            }
            $wpdb->insert(
                $wpdb->posts,
                array(
                    'post_author'               => $new_post_author->ID,
                    'post_date'                 => $new_post_date,
                    'post_date_gmt'             => $new_post_date_gmt,
                    'post_content'              => $post->post_content,
                    'post_content_filtered'     => $post->post_content_filtered,
                    'post_title'                => $post->post_title . $suffix,
                    'post_excerpt'              => $post->post_excerpt,
                    'post_status'               => $post_status,
                    'post_type'                 => $post->post_type,
                    'comment_status'            => $post->comment_status,
                    'ping_status'               => $post->ping_status,
                    'post_password'             => $post->post_password,
                    'to_ping'                   => $post->to_ping,
                    'pinged'                    => $post->pinged,
                    'post_modified'             => $new_post_date,
                    'post_modified_gmt'         => $new_post_date_gmt,
                    'post_parent'               => $post_parent,
                    'menu_order'                => $post->menu_order,
                    'post_mime_type'            => $post->post_mime_type
                )
            );
            $new_post_id = $wpdb->insert_id;
            $this->duplicate_form_post_meta( $post->ID, $new_post_id );
            return $new_post_id;
        }
        private function get_form_to_duplicate( $id ) {
            global $wpdb;
            $id = absint( $id );
            if ( ! $id ) {
                return false;
            }
            $post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );
            if ( isset( $post->post_type ) && $post->post_type == "revision" ) {
                $id   = $post->post_parent;
                $post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );
            }
            return $post[0];
        }
        private function duplicate_form_post_meta( $id, $new_id ) {
            global $wpdb;
            $post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d AND meta_key;", absint( $id ) ) );
            if ( count( $post_meta_infos ) != 0 ) {
                $sql_query_sel = array();
                $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                foreach ( $post_meta_infos as $meta_info ) {
                    $meta_key = $meta_info->meta_key;
                    $meta_value = addslashes( $meta_info->meta_value );
                    $sql_query_sel[]= $wpdb->prepare( "SELECT %d, '%s', '%s'", $new_id, $meta_key, $meta_value );
                }
                $sql_query.= implode( " UNION ALL ", $sql_query_sel );
                $wpdb->query($sql_query);
            }

            $form_settings = SUPER_Common::get_form_settings($id);
            add_post_meta( $new_id, '_super_form_settings', $form_settings );

            $elements = get_post_meta( $id, '_super_elements', true );
            if( !is_array($elements) ) {
                $elements = json_decode( $elements, true );
            }
            add_post_meta( $new_id, '_super_elements', $elements );

            // @since 4.7.0 - translations
            $translations = SUPER_Common::get_form_translations($id);
            add_post_meta( $new_id, '_super_translations', $translations );

        }


        /**
         * Register post status for contact entries
         *
         *  @since      1.0.0
        */
        public static function custom_contact_entry_status() {
            register_post_status(
                'super_unread',
                array(
                    'label' => esc_html__( 'Unread', 'super-forms' ),
                    'public' => true,
                    'exclude_from_search' => false,
                    'show_in_admin_all_list' => true,
                    'show_in_admin_status_list' => true,
                    'label_count' => _n_noop( 'Unread <span class="count">(%s)</span>', 'Unread <span class="count">(%s)</span>' ),
                )
            );
            register_post_status(
                'super_read', 
                array(
                    'label' => esc_html__('Read', 'super-forms' ),
                    'public' => true,
                    'exclude_from_search' => false,
                    'show_in_admin_all_list' => true,
                    'show_in_admin_status_list' => true,
                    'label_count' => _n_noop( 'Read <span class="count">(%s)</span>', 'Read <span class="count">(%s)</span>' ),
                )
            );
            register_post_status(
                'backup', 
                array(
                    'label' => esc_html__('Backups', 'super-forms' ),
                    'public' => false,
                    'exclude_from_search' => true,
                    'show_in_admin_all_list' => false,
                    'show_in_admin_status_list' => false,
                    'label_count' => _n_noop( 'Backups <span class="count">(%s)</span>', 'Backups <span class="count">(%s)</span>' ),
                )
            );

        }
        public static function append_contact_entry_status_list() {
             global $post;
             $complete = '';
             $label = '';
             if( $post->post_type=='super_contact_entry' ) {
                  if( $post->post_status == 'super_unread' ) {
                       $complete = ' selected="selected"';
                       $label = '<span id="post-status-display"> Unread</span>';
                  }
                  echo '<script>
                  jQuery(document).ready(function($){
                       $("select#post_status").append("<option value="archive" ' . $complete . '>Archive</option>");
                       $(".misc-pub-section label").append("'. $label . '");
                  });
                  </script>';
                  if( $post->post_status == 'super_read' ) {
                       $complete = ' selected="selected"';
                       $label = '<span id="post-status-display"> Read</span>';
                  }
                  echo '<script>
                  jQuery(document).ready(function($){
                       $("select#post_status").append("<option value="archive" ' . $complete . '>Archive</option>");
                       $(".misc-pub-section label").append("' . $label . '");
                  });
                  </script>';
             }
        }



        /**
         * Return data for script handles.
         *
         *  @since      1.0.0
        */        
        public static function register_shortcodes(){
            add_shortcode( 'super_form', array( 'SUPER_Shortcodes', 'super_form_func' ) );
        }

        
        /**
         * Load Localisation files.
         * Note: the first-loaded translation file overrides any following ones if the same translation is present.
         */
        public function load_plugin_textdomain() {
            $locale = apply_filters( 'plugin_locale', get_locale(), 'super-forms' );
            load_textdomain( 'super-forms', WP_LANG_DIR . '/super-forms/super-forms-' . $locale . '.mo' );
            load_plugin_textdomain( 'super-forms', false, plugin_basename( dirname( __FILE__ ) ) . '/i18n/languages' );
        }
        

        /** 
         *  Get Ajax URL
         *
         *  @since      1.0.0
        */
        public function ajax_url() {
            return admin_url( 'admin-ajax.php', 'relative' );
        }
        public function super_ajax_url() {
            return SUPER_PLUGIN_FILE . 'includes/ajax-handler.php';
        }


        /**
         * Add the Add-on activation under the "Activate" TAB
         * 
         * @since       2.0.0
        */
        public static function add_on_activation($array, $add_on, $add_on_name) {
            $global_settings = SUPER_Common::get_global_settings();
            if(!isset($global_settings['license_' . $add_on])) $global_settings['license_' . $add_on] = '';
            $sac = get_option( 'sac_' . $add_on, 0 );
            if( $sac==1 ) {
                $sact = '<strong style="color:green;">' . esc_html__( 'Add-on is activated!', 'super-forms' ) . '</strong>';
                $dact = '<br /><br />---';
                $dact .= '<br /><br /><strong style="color:green;">' . esc_html__( 'If you want to transfer this add-on to another domain,', 'super-forms' ) . '<br />';
                $dact .= esc_html__( 'you can deactivate it on this domain by clicking the following button:', 'super-forms' ) . '</strong>';
                $dact .= '<br /><br /><span class="button super-button deactivate-add-on">' . esc_html__( 'Deactivate on current domain', 'super-forms' ) . '</span>';
            }else{
                $dact = '';
                $sact = '<strong style="color:red;">' . esc_html__( 'Add-on is not yet activated!', 'super-forms' ) . '</strong>';
                $sact .= '<br /><br />---';
                $sact .= '<br /><br /><span class="button super-button activate-add-on">' . esc_html__( 'Activate', 'super-forms' ) . '</span>';
                $sact .= '';
            }
            $new_activation_html = '';
            $new_activation_html .= '<div class="super-field">';
            $new_activation_html .= '<div class="super-field-info"></div>';
            $new_activation_html .= '<div class="input"><strong>Super Forms - ' . $add_on_name . '</strong><br /><input type="text" name="license_' . $add_on . '" class="element-field" value="' . $global_settings['license_' . $add_on] . '" /></div>';
            $new_activation_html .= '<input type="hidden" name="add_on" value="' . $add_on . '" />';
            $new_activation_html .= '<div class="input add-on-activation-msg">' . $sact . $dact . '</div>';
            $new_activation_html .= '</div>';
            $array['activation']['html'][] = $new_activation_html;
            return $array;
        }


        /**  
         *  Deactivate
         *
         *  Upon plugin deactivation delete activation
         *
         *  @since      2.0.0
         */
        public static function add_on_deactivate($add_on){
            $global_settings = SUPER_Common::get_global_settings();
            if(isset($global_settings['license_' . $add_on])){
                $license = $global_settings['license_' . $add_on];
                $domain = $_SERVER['SERVER_NAME'];
                $url = 'http://f4d.nl/super-forms/?api=license-deactivate-add-on&add-on=' . $add_on . '&key=' . $license . '&domain=' . $domain;
                wp_remote_get( $url, array('timeout'=>60) );
            }
            delete_option( 'sac_' . $add_on );
        }


        /**
         * Check license and show activation message
         * 
         * @since       2.0.0
        */
        public static function add_on_activation_message( $activation_msg, $add_on, $add_on_name ) {
            /*
            $sac = get_option( 'sac_' . $add_on, 0 );
            if( $sac!=1 ) {
                $activation_msg .= '<div class="super-msg super-error"><h1>Please note:</h1>';
                $activation_msg .= esc_html__( 'You haven\'t activated Super Forms - ' . $add_on_name . ' yet', 'super-forms' ) . '<br />';
                $activation_msg .= sprintf( esc_html__( 'Please click %dhere%d and enter you Purchase Code under the Activation TAB.', 'super-forms' ), '<a target="_blank" href="' . admin_url() . 'admin.php?page=super_settings#activate">', '</a>' )
                $activation_msg .= '<span class="close"></span>';
                $activation_msg .= '</div>';
            }
            return $activation_msg;
            */
        }



        
        /** 
         *  Sample function title
         *
         *  Sample function description
         *  @param  string $name
         *  @param  string $value
         *
         *  @since      1.0.0
        */
        public function sample_function() {
           
        }
        
        
    }
endif;


/**
 * Returns the main instance of SUPER_Forms to prevent the need to use globals.
 *
 * @return SUPER_Forms
 */
if(!function_exists('SUPER_Forms')){
    function SUPER_Forms() {
        return SUPER_Forms::instance();
    }

    // Global for backwards compatibility.
    $GLOBALS['super'] = SUPER_Forms();
}