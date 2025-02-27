<?php
/**
 * Callbacks to generate pages
 *
 * @author      feeling4design
 * @category    Admin
 * @package     SUPER_Forms/Classes
 * @class       SUPER_Pages
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if( !class_exists( 'SUPER_Pages' ) ) :

/**
 * SUPER_Pages
 */
class SUPER_Pages {


    /**
     * Handles the output for the settings page in admin
     */
    public static function settings() {
    
        // Get all available setting fields
        $fields = SUPER_Settings::fields();
        
        wp_enqueue_script( 'jquery-ui-datepicker', false, array( 'jquery' ), SUPER_VERSION );

        // Include the file that handles the view
        include_once(SUPER_PLUGIN_DIR.'/includes/admin/views/page-settings.php' );

    }
    
    /**
     * Handle TAB outputs on builder page (create form page)
     */
    public static function builder_tab($atts) {
        extract($atts);
        $elements = get_post_meta( $form_id, '_super_elements', true );
        $form_html = SUPER_Common::generate_backend_elements($form_id, $shortcodes, $elements);
        // Display translation mode message to the user if translation mode is enabled
        echo '<div class="super-translation-mode-notice">';
            echo '<p>' . esc_html__( 'Currently in translation mode for language', 'super-forms' ) . ': <span class="super-i18n-language"></span></p>';
        echo '</div>';
        ?>
        <div class="super-preview-elements super-dropable super-form-<?php echo $form_id; ?> <?php echo $theme_style; ?>"><?php echo $form_html; ?></div>
        <style type="text/css"><?php echo apply_filters( 'super_form_styles_filter', $style_content, array( 'id'=>$form_id, 'settings'=>$settings ) ) . $settings['theme_custom_css']; ?></style>
        <?php
    }
    public static function translations_tab($atts) {
        extract($atts);
        require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
        //$languages = get_available_languages();
        $available_translations = wp_get_available_translations();

        $language_placeholder = esc_html__( 'Choose language', 'super-forms' );
        $flags_placeholder = esc_html__( 'Choose a flag', 'super-forms' );
        $flags = SUPER_Common::get_flags();

        if(empty($settings['i18n_switch'])) $settings['i18n_switch'] = 'false';
        ?>
        <div class="super-setting">

            <div class="super-i18n-switch<?php echo ($settings['i18n_switch']=='true' ? ' super-active' : ''); ?>">
                <?php echo esc_html__('Add Language Switch', 'super-forms' ) . ' <span>(' . esc_html__( 'this will add a dropdown at the top of your form from which the user can choose a language', 'super-forms') . ')</span>'; ?>
            </div>

            <ul class="translations-list">
                <li>
                    <div class="super-group">
                        <div class="super-dropdown" data-name="language" data-placeholder="- <?php echo $language_placeholder; ?> -">
                            <div class="super-dropdown-placeholder">- <?php echo $language_placeholder; ?> -</div>
                            <div class="super-dropdown-search"><input type="text" placeholder="<?php echo esc_html__( 'Filter', 'super-forms' ); ?>..." /></div>
                            <ul class="super-dropdown-items">
                                <?php
                                foreach($available_translations as $k => $v){
                                    echo '<li data-value="' . $v['language'] . '">' . $v['native_name'] . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="super-group">
                        <div class="super-dropdown" data-name="flag" data-placeholder="- <?php echo $flags_placeholder; ?> -">
                            <div class="super-dropdown-placeholder">- <?php echo $flags_placeholder; ?> -</div>
                            <div class="super-dropdown-search"><input type="text" placeholder="<?php echo esc_html__( 'Filter', 'super-forms' ); ?>..." /></div>
                            <ul class="super-dropdown-items">
                                <?php
                                foreach($flags as $k => $v){
                                    echo '<li data-value="' . $k . '"><img src="'. SUPER_PLUGIN_FILE . 'assets/images/blank.gif" class="flag flag-' . $k . '" />' . $v . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="super-group super-rtl super-tooltip" data-title="<?php echo esc_html__('Enable Right To Left Layout', 'super-forms' ); ?>">
                        RTL
                    </div>
                    <input type="text" readonly="readonly" class="super-get-form-shortcodes super-tooltip" data-title="<?php echo esc_html__('Paste shortcode on any page', 'super-forms' ); ?>" value="choose a language first!">
                    <div class="edit super-tooltip" data-title="<?php echo esc_html__('Edit Translation', 'super-forms' ); ?>"></div>
                    <div class="delete super-tooltip" data-title="<?php echo esc_html__('Delete Translation', 'super-forms' ); ?>"></div>
                </li>

                <?php
                if(!empty($translations)){
                    $i = 0;
                    foreach($translations as $k => $v){
                        ?>
                        <li<?php echo ($i==0 ? ' class="super-default-language"' : ''); ?>>
                            <div class="super-group">
                                <?php
                                if($i==0){
                                    echo '<span>' . esc_html__( 'Default language', 'super-forms' ) . ':</span>';
                                }
                                ?>
                                <div class="super-dropdown" data-name="language" data-placeholder="- <?php echo $language_placeholder; ?> -">
                                    <div class="super-dropdown-placeholder"><?php echo $v['language']; ?></div>
                                    <div class="super-dropdown-search"><input type="text" placeholder="<?php echo esc_html__( 'Filter', 'super-forms' ); ?>..." /></div>
                                    <ul class="super-dropdown-items">
                                        <?php
                                        foreach($available_translations as $tk => $tv){
                                            echo '<li data-value="' . $tv['language'] . '"' . ($tv['language']==$k ? ' class="super-active"' : '') . '>' . $tv['native_name'] . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="super-group">
                                <?php
                                if($i==0){
                                    echo '<span>' . esc_html__( 'Choose a flag for this language', 'super-forms' ) . ':</span>';
                                }
                                ?>
                                <div class="super-dropdown" data-name="flag" data-placeholder="- <?php echo $flags_placeholder; ?> -">
                                    <div class="super-dropdown-placeholder"><?php echo '<img src="'. SUPER_PLUGIN_FILE . 'assets/images/blank.gif" class="flag flag-' . $v['flag'] . '" />' . $flags[$v['flag']]; ?></div>
                                    <div class="super-dropdown-search"><input type="text" placeholder="<?php echo esc_html__( 'Filter', 'super-forms' ); ?>..." /></div>
                                    <ul class="super-dropdown-items">
                                        <?php
                                        foreach($flags as $fk => $fv){
                                            echo '<li data-value="' . $fk . '"' . ($fk==$v['flag'] ? ' class="super-active"' : '') . '><img src="'. SUPER_PLUGIN_FILE . 'assets/images/blank.gif" class="flag flag-' . $fk . '" />' . $fv . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="super-group super-rtl<?php echo ($v['rtl']=='true' ? ' super-active' : ''); ?> super-tooltip" title="<?php echo esc_html__('Enable Right To Left Layout', 'super-forms' ); ?>">
                                RTL
                            </div>

                            <?php
                            $shortcode = '[form-not-saved-yet]';
                            if($form_id!=0){
                                if($i==0){
                                    $shortcode = '[super_form id=&quot;'. $form_id . '&quot;]';
                                }else{
                                    $shortcode = '[super_form i18n=&quot;' . $k . '&quot; id=&quot;'. $form_id . '&quot;]';
                                }
                            }
                            ?>
                            <input type="text" readonly="readonly" class="super-get-form-shortcodes super-tooltip" title="<?php echo esc_html__('Paste shortcode on any page', 'super-forms' ); ?>" value="<?php echo $shortcode; ?>">
                            <div class="edit super-tooltip" title="<?php echo ($i==0 ? esc_html__('Return to builder', 'super-forms' ) : esc_html__('Edit Translation', 'super-forms' )); ?>"></div>
                            <?php
                            if($i>0){
                                echo '<div class="delete super-tooltip" title="' . esc_html__('Delete Translation', 'super-forms' ) . '"></div>';
                            }
                            ?>
                        </li>
                        <?php
                        $i++;
                    }
                }else{
                    ?>
                    <li class="super-default-language">
                        <div class="super-group">
                            <span><?php echo esc_html__( 'Default language', 'super-forms' ); ?>:</span>
                            <div class="super-dropdown" data-name="language" data-placeholder="- <?php echo $language_placeholder; ?> -">
                                <div class="super-dropdown-placeholder">- <?php echo $language_placeholder; ?> -</div>
                                <div class="super-dropdown-search"><input type="text" placeholder="<?php echo esc_html__( 'Filter', 'super-forms' ); ?>..." /></div>
                                <ul class="super-dropdown-items">
                                    <?php
                                    foreach($available_translations as $k => $v){
                                        echo '<li data-value="' . $v['language'] . '">' . $v['native_name'] . '</li>';
                                        //echo '<li data-language="' . $v['language'] . '"><img src="'. SUPER_PLUGIN_FILE . 'assets/images/blank.gif" class="flag flag-' . $v['iso'][1] . '" />' . $v['iso'][1]. ' / '.$v['english_name'] . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="super-group">
                            <span><?php echo esc_html__( 'Choose a flag for this language', 'super-forms' ); ?>:</span>
                            <div class="super-dropdown" data-name="flag" data-placeholder="- <?php echo $flags_placeholder; ?> -">
                                <div class="super-dropdown-placeholder">- <?php echo $flags_placeholder; ?> -</div>
                                <div class="super-dropdown-search"><input type="text" placeholder="<?php echo esc_html__( 'Filter', 'super-forms' ); ?>..." /></div>
                                <ul class="super-dropdown-items">
                                    <?php
                                    foreach($flags as $k => $v){
                                        echo '<li data-value="' . $k . '"><img src="'. SUPER_PLUGIN_FILE . 'assets/images/blank.gif" class="flag flag-' . $k . '" />' . $v . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="super-group super-rtl super-tooltip" title="<?php echo esc_html__('Enable Right To Left Layout', 'super-forms' ); ?>">
                            RTL
                        </div>
                        <?php
                        $shortcode = '[form-not-saved-yet]';
                        $i18n = '';
                        if($form_id!=0){
                            if($i18n!=''){
                                $shortcode = '[super_form i18n="' . $i18n . '" id="'. $form_id . '"]';
                            }else{
                                $shortcode = '';
                            }
                        }
                        ?>
                        <input type="text" readonly="readonly" class="super-get-form-shortcodes super-tooltip" title="<?php echo esc_html__('Paste shortcode on any page', 'super-forms' ); ?>" value="<?php echo $shortcode; ?>">
                        <div class="edit super-tooltip" title="<?php echo esc_html__('Return to builder', 'super-forms' ); ?>"></div>
                    </li>
                    <?php
                }
                ?>

            </ul>

            <div class="create-translation">
                <span class="super-button super-create-translation save"><?php echo esc_html__( 'Add Translation', 'super-forms' ); ?></span>
            </div>

        </div>
        <?php
    }
    public static function triggers_tab() {
        echo 'Triggers TAB content...';
    }




    /**
     * Handles the output for the create form page in admin
     */
    public static function create_form() {
    
        // Get all Forms created with Super Forms (post type: super_form)
        $args = array(
            'post_type' => 'super_form', //We want to retrieve all the Forms
            'posts_per_page' => -1 //Make sure all matching forms will be retrieved
        );
        $forms = get_posts( $args );

        // Check if we are editing an existing Form
        if( isset( $_GET['id'] ) ) {
            $form_id = absint( $_GET['id'] );
            $title = get_the_title( $form_id );
            // @since 3.1.0 - get all Backups for this form.
            $args = array(
                'post_parent' => $form_id,
                'post_type' => 'super_form',
                'post_status' => 'backup',
                'posts_per_page' => -1 //Make sure all matching backups will be retrieved
            );
            $backups = get_posts( $args );
        }else{
            $form_id = 0;
            $title = esc_html__( 'Form Name', 'super-forms' );
        }
        $settings = SUPER_Common::get_form_settings($form_id);

        // Retrieve all settings with the correct default values
        $form_settings = SUPER_Settings::fields( $settings, 0 );

        // Get all available shortcodes
        $shortcodes = SUPER_Shortcodes::shortcodes();
        
        // @since 4.7.0 - translations
        $translations = SUPER_Common::get_form_translations($form_id);

        // Include the file that handles the view
        include_once( SUPER_PLUGIN_DIR . '/includes/admin/views/page-create-form.php' );
       
    }


    /**
     * List of all the demo forms & community forms
     */
    public static function marketplace() {
        wp_enqueue_script( 'thickbox' );
        wp_enqueue_style( 'thickbox' );  
        include_once( SUPER_PLUGIN_DIR . '/includes/admin/views/page-marketplace.php' );
    }


    /**
     * List of all the contact entries
     */
    public static function contact_entries() {

    }


    /**
     * Handles the output for the view contact entry page in admin
     */
    public static function contact_entry() {
        $id = $_GET['id'];
        if ( (FALSE === get_post_status($id)) && (get_post_type($id)!='super_contact_entry') ) {
            // The post does not exist
            echo 'This contact entry does not exist.';
        } else {
            $my_post = array(
                'ID' => $id,
                'post_status' => 'super_read',
            );
            wp_update_post($my_post);
            $date = get_the_date(false,$id);
            $time = get_the_time(false,$id);
            $ip = get_post_meta($id, '_super_contact_entry_ip', true);
            $entry_status = get_post_meta($id, '_super_contact_entry_status', true);
            $global_settings = SUPER_Common::get_global_settings();
            $data = get_post_meta($_GET['id'], '_super_contact_entry_data', true);
            $data[] = array();
            foreach($data as $k => $v){
                if((isset($v['type'])) && (($v['type']=='varchar') || ($v['type']=='var') || ($v['type']=='text') || ($v['type']=='field') || ($v['type']=='barcode') || ($v['type']=='files'))){
                    $data['fields'][] = $v;
                }elseif((isset($v['type'])) && ($v['type']=='form_id')){
                    $data['form_id'][] = $v;
                }
            }
                                    
            // @since 3.4.0  - custom contact entry status
            $statuses = SUPER_Settings::get_entry_statuses($global_settings);
            ?>
            <script>
                jQuery('.toplevel_page_super_forms').removeClass('wp-not-current-submenu').addClass('wp-menu-open wp-has-current-submenu');
                jQuery('.toplevel_page_super_forms').find('li:eq(4)').addClass('current');
            </script>
            <div class="wrap">

                <div id="poststuff">

                    <div id="titlediv" style="margin-bottom:10px;">
                        <div id="titlewrap">
                            <input placeholder="<?php _e( 'Contact Entry Title', 'super-forms' ); ?>" type="text" name="super_contact_entry_post_title" size="30" value="<?php echo get_the_title($id); ?>" id="title" spellcheck="true" autocomplete="off">
                        </div>
                    </div>

                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="postbox-container-1" class="postbox-container">
                            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                                <div id="submitdiv" class="postbox ">
                                    <div class="handlediv" title="">
                                        <br>
                                    </div>
                                    <h3 class="hndle ui-sortable-handle">
                                        <span><?php echo esc_html__('Lead Details', 'super-forms' ); ?>:</span>
                                    </h3>
                                    <div class="inside">
                                        <div class="submitbox" id="submitpost">
                                            <div id="minor-publishing">
                                                <div class="misc-pub-section">
                                                    <span><?php echo esc_html__('Submitted', 'super-forms' ).':'; ?> <strong><?php echo $date.' @ '.$time; ?></strong></span>
                                                </div>
                                                <div class="misc-pub-section">
                                                    <span><?php echo esc_html__('IP-address', 'super-forms' ).':'; ?> <strong><?php if(empty($ip)){ echo esc_html__('Unknown', 'super-forms' ); }else{ echo $ip; } ?></strong></span>
                                                </div>
                                                <div class="misc-pub-section">
                                                    <?php echo '<span>' . esc_html__('Based on Form', 'super-forms' ) . ': <strong><a href="admin.php?page=super_create_form&id=' . $data['form_id'][0]['value'] . '">' . get_the_title( $data['form_id'][0]['value'] ) . '</a></strong></span>'; ?>
                                                </div>
                                                <?php
                                                if(SUPER_WC_ACTIVE){
                                                    $wc_order_id = get_post_meta($id, '_super_contact_entry_wc_order_id', true);
                                                    if(!empty($wc_order_id)){
                                                        ?>
                                                        <div class="misc-pub-section">
                                                            <span><?php echo esc_html__('WooCommerce Order', 'super-forms' ).':'; ?> <strong><?php echo '<a href="'.get_edit_post_link($wc_order_id,'').'">#'.$wc_order_id.'</a>'; ?></strong></span>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                $post_author_id = get_post_field( 'post_author', $id );
                                                if( !empty($post_author_id) ) {
                                                    $user_info = get_userdata($post_author_id);
                                                    echo '<div class="misc-pub-section">';
                                                        echo '<span>' . esc_html__( 'Submitted by', 'super-forms' ) . ': <a href="' . get_edit_user_link($user_info->ID) . '"><strong>' . $user_info->display_name . '</strong></a></span>';
                                                    echo '</div>';
                                                }
                                                ?>
                                                <div class="misc-pub-section">
                                                    <?php
                                                    echo '<span>' . esc_html__('Entry status', 'super-forms' ).':&nbsp;</span>';
                                                    echo '<select name="entry_status">';
                                                    foreach($statuses as $k => $v){
                                                        echo '<option value="'.$k.'" ' . ($entry_status==$k ? 'selected="selected"' : '') . '>'.$v['name'].'</option>';
                                                    }
                                                    echo '</select>';
                                                    ?>
                                                </div>
                                                <div class="clear"></div>
                                            </div>

                                            <div id="major-publishing-actions">
                                                <div id="delete-action">
                                                    <a class="submitdelete super-delete-contact-entry" data-contact-entry="<?php echo absint($id); ?>" href="#"><?php echo esc_html__('Move to Trash', 'super-forms' ); ?></a>
                                                </div>
                                                <div id="publishing-action">
                                                    <span class="spinner"></span>
                                                    <input name="print" type="submit" class="super-print-contact-entry button button-large" value="<?php echo esc_html__('Print', 'super-forms' ); ?>">
                                                    <input name="save" type="submit" class="super-update-contact-entry button button-primary button-large" data-contact-entry="<?php echo absint($id); ?>" value="<?php echo esc_html__('Update', 'super-forms' ); ?>">
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="postbox-container-2" class="postbox-container">
                            <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                                <div id="super-contact-entry-data" class="postbox ">
                                    <div class="handlediv" title="">
                                        <br>
                                    </div>
                                    <h3 class="hndle ui-sortable-handle">
                                        <span><?php echo esc_html__('Lead Information', 'super-forms' ); ?>:</span>
                                    </h3>
                                    <?php
                                    $shipping = 0;
                                    $currency = '';
                                    ?>
                                    <div class="inside">
                                        <?php
                                        echo '<table>';
                                            if( ( isset($data['fields']) ) && (count($data['fields'])>0) ) {
                                                foreach( $data['fields'] as $k => $v ) {
                                                    $v['label'] = SUPER_Common::convert_field_email_label($v['label'], 0, true);
                                                    if( $v['type']=='barcode' ) {
                                                        echo '<tr><th align="right">' . $v['label'] . '</th><td>';
                                                        echo '<div class="super-barcode">';
                                                            echo '<div class="super-barcode-target"></div>';
                                                            echo '<input type="hidden" value="' . $v['value'] . '" data-barcodetype="' . $v['barcodetype'] . '" data-modulesize="' . $v['modulesize'] . '" data-quietzone="' . $v['quietzone'] . '" data-rectangular="' . $v['rectangular'] . '" data-barheight="' . $v['barheight'] . '" data-barwidth="' . $v['barwidth'] . '" />';
                                                        echo '</div>';
                                                    }else if( $v['type']=='files' ) {
                                                        if( isset( $v['files'] ) ) {
                                                            foreach( $v['files'] as $fk => $fv ) {
                                                                $url = $fv['url'];
                                                                if( isset( $fv['attachment'] ) ) {
                                                                    $url = wp_get_attachment_url( $fv['attachment'] );
                                                                }
                                                                if( $fk==0 ) {
                                                                    $fv['label'] = SUPER_Common::convert_field_email_label($fv['label'], 0, true);
                                                                    echo '<tr><th align="right">' . $fv['label'] . '</th><td><span class="super-contact-entry-data-value"><a target="_blank" href="' . $url . '">' . $fv['value'] . '</a></span></td></tr>';
                                                                }else{
                                                                    echo '<tr><th align="right">&nbsp;</th><td><span class="super-contact-entry-data-value"><a target="_blank" href="' . $url . '">' . $fv['value'] . '</a></span></td></tr>';
                                                                }
                                                            }
                                                        }else{
                                                            echo '<tr><th align="right">' . $v['label'] . '</th><td><span class="super-contact-entry-data-value">';
                                                            echo '<input type="text" disabled="disabled" value="' . esc_html__( 'No files uploaded', 'super-forms' ) . '" />';
                                                            echo '</span></td></tr>';
                                                        }
                                                    }else if( ($v['type']=='varchar') || ($v['type']=='var') || ($v['type']=='field') ) {
                                                        if( !isset($v['value']) ) $v['value'] = '';
                                                        if ( strpos( $v['value'], 'data:image/png;base64,') !== false ) {
                                                            echo '<tr><th align="right">' . $v['label'] . '</th><td><span class="super-contact-entry-data-value"><img src="' . $v['value'] . '" /></span></td></tr>';

                                                            // @since 2.3 - convert it to an actual image (for future reference)
                                                            /*
                                                            $img_data = $v['value'];
                                                            list($type, $img_data) = explode(';', $img_data);
                                                            list(, $img_data) = explode(',', $img_data);
                                                            $img_data = base64_decode($img_data);
                                                            $img_path = SUPER_PLUGIN_DIR . "/uploads/php/files/" . $v['name'] . "-" . $data['form_id'][0]['value'] . ".png"; 
                                                            file_put_contents($img_path, $img_data);
                                                            $img_url = SUPER_PLUGIN_FILE . "uploads/php/files/" . $v['name'] . "-" . $data['form_id'][0]['value'] . ".png";
                                                            echo '<tr><th align="right">' . $v['label'] . '</th><td><span class="super-contact-entry-data-value"><img src="' . $img_url . '" /></span></td></tr>';
                                                            */

                                                        }else{
                                                            echo '<tr>';
                                                            if( empty($v['label']) ) $v['label'] = '&nbsp;';
                                                            echo '<th align="right">' . $v['label'] . '</th>';
                                                            echo '<td>';
                                                            echo '<span class="super-contact-entry-data-value">';

                                                            echo '<input class="super-shortcode-field" type="text" name="' . esc_attr($v['name']) . '" value="' . sanitize_text_field($v['value']) . '" />';
                                                            echo '</span>';
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                    }else if( $v['type']=='text' ) {
                                                        echo '<tr>';
                                                        echo '<th align="right">' . $v['label'] . '</th>';
                                                        echo '<td>';
                                                        echo '<span class="super-contact-entry-data-value">';
                                                        echo '<textarea class="super-shortcode-field" name="' . esc_attr($v['name']) . '">' . $v['value'] . '</textarea>';
                                                        echo '</span>';
                                                        echo '</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                            }
                                            echo '<tr><th align="right">&nbsp;</th><td><span class="super-contact-entry-data-value">&nbsp;</span></td></tr>';
                                            echo '<tr><th align="right">' . esc_html__( 'Based on Form', 'super-forms' ) . ':</th><td><span class="super-contact-entry-data-value">';
                                            echo '<input type="hidden" class="super-shortcode-field" name="form_id" value="' . absint($data['form_id'][0]['value']) . '" />';
                                            echo '<a href="admin.php?page=super_create_form&id=' . $data['form_id'][0]['value'] . '">' . get_the_title( $data['form_id'][0]['value'] ) . '</a>';
                                            echo '</span></td></tr>';

                                            echo apply_filters( 'super_after_contact_entry_data_filter', '', array( 'entry_id'=>$_GET['id'], 'data'=>$data ) );

                                        echo '</table>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
                        </div>
                    </div>
                    <!-- /post-body -->
                    <br class="clear">
                </div>
            <?php
        }
    }   
    
}
endif;