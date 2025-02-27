<?php
if(SUPER_WC_ACTIVE){
    $wc_get_order_statuses = wc_get_order_statuses();
}else{
    $wc_get_order_statuses = array('WooCommerce is not activated on this site!');
}


// Set empty values
$set_empty_attributes = array(
    'retrieve_method',
    'retrieve_method_exclude_users',
    'retrieve_method_role_filters',
    'retrieve_method_user_label',
    'retrieve_method_user_meta_keys',
    'retrieve_method_db_table',
    'retrieve_method_db_row_value',
    'retrieve_method_db_row_label',
    'retrieve_method_author_field',
    'retrieve_method_author_option_explode',
    'retrieve_method_author_line_explode',
    'retrieve_method_csv',
    'retrieve_method_delimiter',
    'retrieve_method_enclosure',                        
    'retrieve_method_taxonomy',
    'retrieve_method_product_attribute',
    'retrieve_method_post',
    'retrieve_method_post_status',
    'retrieve_method_orderby',
    'retrieve_method_order',
    'retrieve_method_exclude_taxonomy',
    'retrieve_method_exclude_post',
    'retrieve_method_filters',
    'retrieve_method_filter_relation',
    'retrieve_method_hide_empty',
    'retrieve_method_parent',
    'retrieve_method_value',
    'retrieve_method_meta_keys',
    'autosuggest_items',
    'dropdown_items',
    'checkbox_items',
    'radio_items'
);
foreach($set_empty_attributes as $v){
    if(!isset($attributes[$v]))
        $attributes[$v] = null;
    if(!isset($attributes['keywords_'.$v]))
        $attributes['keywords_'.$v] = null;
}
if(!isset($attributes['keywords_items']))
    $attributes['keywords_items'] = null;

$array['form_elements'] = array(
    'title' => esc_html__( 'Form Elements', 'super-forms' ),   
    'class' => 'super-form-elements',
    'shortcodes' => array(
        'email' => array(
            'name' => esc_html__( 'Email Address', 'super-forms' ),
            'icon' => 'envelope;far',
            'predefined' => array(
                array(
                    'tag' => 'text',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'email', 'super-forms' ),
                        'email' => esc_html__( 'Email address:', 'super-forms' ),
                        'placeholder' => esc_html__( 'Your Email Address', 'super-forms' ),
                        'type' => 'email',
                        'validation' => 'email',
                        'icon' => 'envelope;far'
                    )
                )
            ),
            'atts' => array(),
        ),
        'title' => array(
            'name' => esc_html__( 'Title', 'super-forms' ),
            'icon' => 'user',
            'predefined' => array(
                array(
                    'tag' => 'dropdown',
                    'group' => 'form_elements',
                    'data' => array(
                        'dropdown_items' => array(
                            array(
                                'checked' => false,
                                'label' => esc_html__( 'Mr.', 'super-forms' ),
                                'value' => esc_html__( 'Mr.', 'super-forms' )
                            ),
                            array(
                                'checked' => false,
                                'label' => esc_html__( 'Mis.', 'super-forms' ),
                                'value' => esc_html__( 'Mis.', 'super-forms' )
                            )
                        ),
                        'name' => esc_html__( 'title', 'super-forms' ),
                        'email' => esc_html__( 'Title:', 'super-forms' ),
                        'placeholder' => esc_html__( '- select your title -', 'super-forms' ),
                        'validation' => 'empty',
                        'icon' => 'caret-square-down;far',
                    )
                )
            ),
            'atts' => array(),
        ),
        'first_last_name' => array(
            'name' => esc_html__( 'First/Last name', 'super-forms' ),
            'icon' => 'user',
            'predefined' => array(
                array(
                    'tag' => 'column',
                    'group' => 'layout_elements',
                    'inner' => array(
                        array(
                            'tag' => 'text',
                            'group' => 'form_elements',
                            'data' => array(
                                'name' => 'first_name',
                                'email' => 'First name:',
                                'placeholder' => 'Your First Name',
                                'validation' => 'empty',
                            )
                        )
                    ),
                    'data' => array(
                        'size' => '1/2',                      
                    )
                ),
                array(
                    'tag' => 'column',
                    'group' => 'layout_elements',
                    'inner' => array(
                        array(
                            'tag' => 'text',
                            'group' => 'form_elements',
                            'data' => array(
                                'name' => 'last_name',
                                'email' => 'Last name:',
                                'placeholder' => 'Your Last Name',
                                'validation' => 'empty',
                            )
                        )
                    ),
                    'data' => array(
                        'size' => '1/2',
                    )
                ),
            ),
            'atts' => array(),
        ),
        'address' => array(
            'name' => esc_html__( 'Address', 'super-forms' ),
            'icon' => 'map-marker',
            'predefined' => array(
                array(
                    'tag' => 'text',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'address', 'super-forms' ),
                        'email' => esc_html__( 'Address:', 'super-forms' ),
                        'placeholder' => esc_html__( 'Your Address', 'super-forms' ),
                        'validation' => 'empty',
                        'icon_position' => 'outside',
                        'icon_align' => 'left',
                        'icon' => 'map-marker',
                    )
                )
            ),
            'atts' => array(),
        ),
        'zipcode_city_country' => array(
            'name' => esc_html__( 'Zipcode & City', 'super-forms' ),
            'icon' => 'map-marker',
            'predefined' => array(
                array(
                    'tag' => 'column',
                    'group' => 'layout_elements',
                    'inner' => array(
                        array(
                            'tag' => 'text',
                            'group' => 'form_elements',
                            'data' => array(
                                'name' => 'zipcode',
                                'email' => 'Zipcode:',
                                'placeholder' => 'Zipcode',
                                'validation' => 'empty',
                                'minlength' => '4',
                                'icon' => 'map-marker'
                            )
                        )
                    ),
                    'data' => array(
                        'size' => '1/3',                      
                    )
                ),
                array(
                    'tag' => 'column',
                    'group' => 'layout_elements',
                    'inner' => array(
                        array(
                            'tag' => 'text',
                            'group' => 'form_elements',
                            'data' => array(
                                'name' => 'city',
                                'email' => 'City:',
                                'placeholder' => 'City',
                                'validation' => 'empty',
                                'icon' => 'map-marker',
                            )
                        )
                    ),
                    'data' => array(
                        'size' => '1/3',                      
                    )
                ),
                array(
                    'tag' => 'column',
                    'group' => 'layout_elements',
                    'inner' => array(
                        array(
                            'tag' => 'countries',
                            'group' => 'form_elements',
                            'data' => array(
                                'name' => 'country',
                                'email' => 'Country:',
                                'placeholder' => '- select your country -',
                                'validation' => 'empty',
                                'icon' => 'globe',
                            )
                        )
                    ),
                    'data' => array(
                        'size' => '1/3',                      
                    )
                ),
            ),
            'atts' => array(),
        ),

        'text_predefined' => array(
            'name' => esc_html__( 'Text field', 'super-forms' ),
            'icon' => 'list',
            'predefined' => array(
                array(
                    'tag' => 'text',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'name', 'super-forms' ),
                        'email' => esc_html__( 'Name:', 'super-forms' ),
                        'placeholder' => esc_html__( 'Your Full Name', 'super-forms' ),
                        'icon' => 'user',
                    )
                )
            ),
            'atts' => array(),
        ),
        'text' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::text',
            'name' => esc_html__( 'Text field', 'super-forms' ),
            'icon' => 'list',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name( $attributes, '' ),
                        'email' => SUPER_Shortcodes::email( $attributes, '' ),
                        'label' => $label,
                        'description'=>$description,
                        'placeholder' => SUPER_Shortcodes::placeholder( $attributes, '' ),
                        'value' => array(
                            'default'=> ( !isset( $attributes['value'] ) ? '' : $attributes['value'] ),
                            'name' => esc_html__( 'Default value', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a default value for this field. {post_id} and {post_title} can be used (leave blank for none)', 'super-forms' ),
                            'i18n' => true
                        ),
                        'type' => array(
                            'name' => esc_html__( 'Field type', 'super-forms' ), 
                            'label' => esc_html__( 'Choose an appropriate type for your field. Please note that this setting will affect the keyboard layout on mobile devices, choose wisely!', 'super-forms' ),
                            'type' => 'select',
                            'values' => array(
                                'text' => esc_html__( '[text] normal text field (default)', 'super-forms' ), 
                                'email' => esc_html__( '[email] for entering email addresses', 'super-forms' ), 
                                'tel' => esc_html__( '[tel] for entering phonenumbers', 'super-forms' ), 
                                'url' => esc_html__( '[url] for entering URL\'s', 'super-forms' ), 
                                'number' => esc_html__( '[number] for entering numbers (validation will automatically be set to "float")', 'super-forms' ), 
                                'color' => esc_html__( '[color] for choosing HEX colors (or use the native Colorpicker element)', 'super-forms' ),
                                'date' => esc_html__( '[date] for choosing dates (or use the native Date element)', 'super-forms' ),
                                'datetime-local' => esc_html__( '[datetime-local] for choosing date + time', 'super-forms' ),
                                'month' => esc_html__( '[month] for choosing months', 'super-forms' ),
                                'time' => esc_html__( '[time] for choosing time', 'super-forms' )
                            ),
                        ),
                        'step' => array(
                            'name' => esc_html__( 'Step (defaults to "any")', 'super-forms' ), 
                            'label' => esc_html__( 'Specifies the value granularity of the element\'s value.', 'super-forms' ),
                            'default'=> ( !isset( $attributes['step'] ) ? 'any' : $attributes['step'] ),
                            'filter'=>true,
                            'parent'=>'type',
                            'filter_value'=>'number'
                        ),
                        'validation' => $special_validations,
                        'tooltip' => $tooltip,
                        'custom_regex' => $custom_regex,
                        'conditional_validation' => $conditional_validation,
                        'conditional_validation_value' => $conditional_validation_value,
                        'conditional_validation_value2' => $conditional_validation_value2, // @since 3.6.0
                        'may_be_empty' => $may_be_empty,
                        'error' => $error,
                    ),
                ),
                'auto_suggest' => array(
                    'name' => esc_html__( 'Auto suggest', 'super-forms' ),
                    'fields' => array(
                        'enable_auto_suggest' => array(
                            'desc' => esc_html__( 'Wether or not to use the auto suggest feature', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['enable_auto_suggest'] ) ? '' : $attributes['enable_auto_suggest'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Enable auto suggest', 'super-forms' ),
                            )
                        ),
                        'retrieve_method' => SUPER_Shortcodes::sf_retrieve_method( $attributes['retrieve_method'], 'enable_auto_suggest' ),
                        'retrieve_method_exclude_users' => SUPER_Shortcodes::sf_retrieve_method_exclude_users( $attributes['retrieve_method_exclude_users'], 'retrieve_method' ),
                        'retrieve_method_role_filters' => SUPER_Shortcodes::sf_retrieve_method_role_filters( $attributes['retrieve_method_role_filters'], 'retrieve_method' ),
                        'retrieve_method_user_label' => SUPER_Shortcodes::sf_retrieve_method_user_label( $attributes['retrieve_method_user_label'], 'retrieve_method' ),
                        'retrieve_method_user_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_user_meta_keys( $attributes['retrieve_method_user_meta_keys'], 'retrieve_method' ),
                        'retrieve_method_db_table' => SUPER_Shortcodes::sf_retrieve_method_db_table( $attributes['retrieve_method_db_table'], 'retrieve_method' ),
                        'retrieve_method_db_row_value' => SUPER_Shortcodes::sf_retrieve_method_db_row_value( $attributes['retrieve_method_db_row_value'], 'retrieve_method' ),
                        'retrieve_method_db_row_label' => SUPER_Shortcodes::sf_retrieve_method_db_row_label( $attributes['retrieve_method_db_row_label'], 'retrieve_method' ),
                        'retrieve_method_author_field' => SUPER_Shortcodes::sf_retrieve_method_author_field( $attributes['retrieve_method_author_field'], 'retrieve_method' ),
                        'retrieve_method_author_option_explode' => SUPER_Shortcodes::sf_retrieve_method_author_option_explode( $attributes['retrieve_method_author_option_explode'], 'retrieve_method' ),
                        'retrieve_method_author_line_explode' => SUPER_Shortcodes::sf_retrieve_method_author_line_explode( $attributes['retrieve_method_author_line_explode'], 'retrieve_method' ),
                        'retrieve_method_csv' => SUPER_Shortcodes::sf_retrieve_method_csv( $attributes['retrieve_method_csv'], 'retrieve_method' ),
                        'retrieve_method_delimiter' => SUPER_Shortcodes::sf_retrieve_method_delimiter( $attributes['retrieve_method_delimiter'], 'retrieve_method' ),
                        'retrieve_method_enclosure' => SUPER_Shortcodes::sf_retrieve_method_enclosure( $attributes['retrieve_method_enclosure'], 'retrieve_method' ),                        
                        'retrieve_method_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_taxonomy( $attributes['retrieve_method_taxonomy'], 'retrieve_method' ),
                        'retrieve_method_product_attribute' => SUPER_Shortcodes::sf_retrieve_method_product_attribute( $attributes['retrieve_method_product_attribute'], 'retrieve_method' ),
                        'retrieve_method_post' => SUPER_Shortcodes::sf_retrieve_method_post( $attributes['retrieve_method_post'], 'retrieve_method' ),
                        'retrieve_method_post_status' => SUPER_Shortcodes::sf_retrieve_method_post_status( $attributes['retrieve_method_post_status'], 'retrieve_method' ),
                        'retrieve_method_orderby' => SUPER_Shortcodes::sf_retrieve_method_orderby( $attributes['retrieve_method_orderby'], 'retrieve_method' ),
                        'retrieve_method_order' => SUPER_Shortcodes::sf_retrieve_method_order( $attributes['retrieve_method_order'], 'retrieve_method' ),
                        'retrieve_method_exclude_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_exclude_taxonomy( $attributes['retrieve_method_exclude_taxonomy'], 'retrieve_method' ),
                        'retrieve_method_exclude_post' => SUPER_Shortcodes::sf_retrieve_method_exclude_post( $attributes['retrieve_method_exclude_post'], 'retrieve_method' ),
                        'retrieve_method_filters' => SUPER_Shortcodes::sf_retrieve_method_filters( $attributes['retrieve_method_filters'], 'retrieve_method' ),
                        'retrieve_method_filter_relation' => SUPER_Shortcodes::sf_retrieve_method_filter_relation( $attributes['retrieve_method_filter_relation'], 'retrieve_method' ),
                        'retrieve_method_hide_empty' => SUPER_Shortcodes::sf_retrieve_method_hide_empty( $attributes['retrieve_method_hide_empty'], 'retrieve_method' ),
                        'retrieve_method_parent' => SUPER_Shortcodes::sf_retrieve_method_parent( $attributes['retrieve_method_parent'], 'retrieve_method' ),
                        'retrieve_method_value' => SUPER_Shortcodes::sf_retrieve_method_value( $attributes['retrieve_method_value'], 'retrieve_method' ),
                        'retrieve_method_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_meta_keys( $attributes['retrieve_method_meta_keys'], 'retrieve_method_value' ),
                        'autosuggest_items' => SUPER_Shortcodes::sf_retrieve_method_custom_items( $attributes['autosuggest_items'], 'retrieve_method', 'autosuggest_items' ),
                    )
                ),

                // @since 3.1.0 - google distance calculation between 2 addresses
                // Example GET request: http://maps.googleapis.com/maps/api/directions/json?gl=uk&units=imperial&origin=Ulft&destination=7064BW
                'distance_calculator' => array(
                    'name' => esc_html__( 'Distance / Duration calculation (google directions)', 'super-forms' ),
                    'fields' => array(
                        'enable_distance_calculator' => array(
                            'desc' => esc_html__( 'Wether or not to use the distance calculator feature', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['enable_distance_calculator'] ) ? '' : $attributes['enable_distance_calculator'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Enable distance calculator', 'super-forms' ),
                            )
                        ),
                        'distance_method' => array(
                            'name' => esc_html__( 'Select if this field must act as Start or Destination', 'super-forms' ), 
                            'desc' => esc_html__( 'This option is required so that Super Forms knows how to calculate the distance', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['distance_method'] ) ? 'start' : $attributes['distance_method'] ),
                            'type' => 'select', 
                            'values' => array(
                                'start' => esc_html__( 'Start address', 'super-forms' ), 
                                'destination' => esc_html__( 'Destination address', 'super-forms' )
                            ),
                            'filter'=>true,
                            'parent'=>'enable_distance_calculator',
                            'filter_value'=>'true'
                        ),
                        'distance_start' => array(
                            'name' => esc_html__( 'Starting address (required)', 'super-forms' ), 
                            'label' => esc_html__( 'Enter a fixed address/zipcode or enter the unique field name to retrieve dynamic address from users', 'super-forms' ),
                            'desc' => esc_html__( 'Required to calculate distance between 2 locations', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['start'] ) ? '' : $attributes['start'] ),
                            'filter'=>true,
                            'parent'=>'distance_method',
                            'filter_value'=>'destination'
                        ),
                        'distance_destination' => array(
                            'name' => esc_html__( 'Destination address (required)', 'super-forms' ), 
                            'label' => esc_html__( 'Enter a fixed address/zipcode or enter the unique field name to retrieve dynamic address from users', 'super-forms' ),
                            'desc' => esc_html__( 'Required to calculate distance between 2 locations', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['destination'] ) ? '' : $attributes['destination'] ),
                            'filter'=>true,
                            'parent'=>'distance_method',
                            'filter_value'=>'start'
                        ),
                        'distance_value' => array(
                            'name' => esc_html__( 'Select what value to return (distance or duration)', 'super-forms' ), 
                            'desc' => esc_html__( 'After calculating the distance either the amount of meters or seconds can be returned', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['distance_value'] ) ? 'distance' : $attributes['distance_value'] ),
                            'type' => 'select', 
                            'values' => array(
                                'distance' => esc_html__( 'Distance in meters', 'super-forms' ), 
                                'duration' => esc_html__( 'Duration in seconds', 'super-forms' ),
                                'dis_text' => esc_html__( 'Distance text in km or miles', 'super-forms' ), 
                                'dur_text' => esc_html__( 'Duration text in minutes', 'super-forms' )
                            ),
                            'filter'=>true,
                            'parent'=>'distance_method',
                            'filter_value'=>'start'
                        ),
                        'distance_units' => array(
                            'name' => esc_html__( 'Select a unit system', 'super-forms' ), 
                            'desc' => esc_html__( 'This will determine if the textual distance is returned in meters or miles', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['distance_units'] ) ? 'metric' : $attributes['distance_units'] ),
                            'type' => 'select', 
                            'values' => array(
                                'metric' => esc_html__( 'Metric (distance returned in kilometers and meters)', 'super-forms' ), 
                                'imperial' => esc_html__( 'Imperial (distance returned in miles and feet)', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'distance_value',
                            'filter_value'=>'dis_text'
                        ),
                        'distance_field' => array(
                            'name' => esc_html__( 'Enter the unique field name which the distance value should be populated to (required)', 'super-forms' ), 
                            'label' => esc_html__( 'This can be a Text field or Hidden field (do not add brackets before and after).', 'super-forms' ),
                            'desc' => esc_html__( 'After doing the calculation the value will be populated to this field', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['distance_field'] ) ? '' : $attributes['distance_field'] ),
                            'filter'=>true,
                            'parent'=>'distance_method',
                            'filter_value'=>'start'
                        ),
                    )
                ),

                // @since 3.0.0 - google placed auto complete
                'address_auto_complete' => array(
                    'name' => esc_html__( 'Address auto complete (google places)', 'super-forms' ),
                    'fields' => array(
                        'enable_address_auto_complete' => array(
                            'desc' => esc_html__( 'Wether or not to use the address auto complete feature', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['enable_address_auto_complete'] ) ? '' : $attributes['enable_address_auto_complete'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Enable address auto complete', 'super-forms' ),
                            )
                        ),
                        'address_api_key' => array(
                            'name' => esc_html__( 'Google API key', 'super-forms' ), 
                            'label' => sprintf( esc_html__( 'In order to make calls you have to enable these libraries in your %sAPI manager%s:%s- Google Maps JavaScript API%s- Google Places API Web Service', 'super-forms' ), '<a target="_blank" href="https://console.developers.google.com">', '</a>', '<br />', '<br />' ),
                            'desc' => esc_html__( 'Required to do API calls to retrieve data', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['address_api_key'] ) ? '' : $attributes['address_api_key'] ),
                            'filter'=>true,
                            'parent'=>'enable_address_auto_complete',
                            'filter_value'=>'true',
                            'required'=>true,
                        ),
                        'enable_address_auto_populate' => array(
                            'desc' => esc_html__( 'Auto populate address fields', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['enable_address_auto_populate'] ) ? '' : $attributes['enable_address_auto_populate'] ),
                            'type' => 'checkbox', 
                            'values' => array(
                                'true' => esc_html__( 'Enable address auto populate', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'enable_address_auto_complete',
                            'filter_value'=>'true'
                        ),
                        'address_auto_populate_mappings' => array( 
                            'name' => esc_html__( 'Map data with fields', 'super-forms' ), 
                            'desc' => esc_html__( 'The fields that should be populated with the address data.', 'super-forms' ),
                            'type' => 'address_auto_populate',
                            'default' => (!isset($attributes['address_auto_populate_mappings']) ? '' : $attributes['address_auto_populate_mappings']),
                            'filter' => true,
                            'parent' => 'enable_address_auto_populate',
                            'filter_value' => 'true'
                        ),
                    )
                ),
                // @since 2.9.0 - keyword input field
                'keyword_field' => array(
                    'name' => esc_html__( 'Enable keyword field', 'super-forms' ),
                    'fields' => array(
                        'enable_keywords' => array(
                            'desc' => esc_html__( 'Wether or not to enable keyword feature', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['enable_keywords'] ) ? '' : $attributes['enable_keywords'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Enable keyword user input', 'super-forms' ),
                            )
                        ),
                        'keywords_retrieve_method' => SUPER_Shortcodes::sf_retrieve_method( $attributes['keywords_retrieve_method'], 'enable_keywords' ),
                        'keywords_retrieve_method_exclude_users' => SUPER_Shortcodes::sf_retrieve_method_exclude_users( $attributes['keywords_retrieve_method_exclude_users'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_role_filters' => SUPER_Shortcodes::sf_retrieve_method_role_filters( $attributes['keywords_retrieve_method_role_filters'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_user_label' => SUPER_Shortcodes::sf_retrieve_method_user_label( $attributes['keywords_retrieve_method_user_label'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_user_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_user_meta_keys( $attributes['keywords_retrieve_method_user_meta_keys'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_db_table' => SUPER_Shortcodes::sf_retrieve_method_db_table( $attributes['keywords_retrieve_method_db_table'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_db_row_value' => SUPER_Shortcodes::sf_retrieve_method_db_row_value( $attributes['keywords_retrieve_method_db_row_value'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_db_row_label' => SUPER_Shortcodes::sf_retrieve_method_db_row_label( $attributes['keywords_retrieve_method_db_row_label'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_author_field' => SUPER_Shortcodes::sf_retrieve_method_author_field( $attributes['keywords_retrieve_method_author_field'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_author_option_explode' => SUPER_Shortcodes::sf_retrieve_method_author_option_explode( $attributes['keywords_retrieve_method_author_option_explode'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_author_line_explode' => SUPER_Shortcodes::sf_retrieve_method_author_line_explode( $attributes['keywords_retrieve_method_author_line_explode'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_csv' => SUPER_Shortcodes::sf_retrieve_method_csv( $attributes['keywords_retrieve_method_csv'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_delimiter' => SUPER_Shortcodes::sf_retrieve_method_delimiter( $attributes['keywords_retrieve_method_delimiter'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_enclosure' => SUPER_Shortcodes::sf_retrieve_method_enclosure( $attributes['keywords_retrieve_method_enclosure'], 'keywords_retrieve_method' ),                        
                        'keywords_retrieve_method_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_taxonomy( $attributes['keywords_retrieve_method_taxonomy'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_product_attribute' => SUPER_Shortcodes::sf_retrieve_method_product_attribute( $attributes['keywords_retrieve_method_product_attribute'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_post' => SUPER_Shortcodes::sf_retrieve_method_post( $attributes['keywords_retrieve_method_post'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_post_status' => SUPER_Shortcodes::sf_retrieve_method_post_status( $attributes['keywords_retrieve_method_post_status'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_orderby' => SUPER_Shortcodes::sf_retrieve_method_orderby( $attributes['keywords_retrieve_method_orderby'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_order' => SUPER_Shortcodes::sf_retrieve_method_order( $attributes['keywords_retrieve_method_order'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_exclude_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_exclude_taxonomy( $attributes['keywords_retrieve_method_exclude_taxonomy'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_exclude_post' => SUPER_Shortcodes::sf_retrieve_method_exclude_post( $attributes['keywords_retrieve_method_filters'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_filters' => SUPER_Shortcodes::sf_retrieve_method_filters( $attributes['keywords_retrieve_method_filters'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_filter_relation' => SUPER_Shortcodes::sf_retrieve_method_filter_relation( $attributes['keywords_retrieve_method_filter_relation'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_hide_empty' => SUPER_Shortcodes::sf_retrieve_method_hide_empty( $attributes['keywords_retrieve_method_hide_empty'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_parent' => SUPER_Shortcodes::sf_retrieve_method_parent( $attributes['keywords_retrieve_method_parent'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_value' => SUPER_Shortcodes::sf_retrieve_method_value( $attributes['keywords_retrieve_method_value'], 'keywords_retrieve_method' ),
                        'keywords_retrieve_method_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_meta_keys( $attributes['keywords_retrieve_method_meta_keys'], 'keywords_retrieve_method_value' ),
                        'keywords_items' => SUPER_Shortcodes::sf_retrieve_method_custom_items( $attributes['keywords_items'], 'keywords_retrieve_method', 'radio_items' ),

                        'keyword_max' => array(
                            'name' => esc_html__( 'Maximum allowed keywords', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a keyword limit for the user to enter', 'super-forms' ), 
                            'type' => 'slider', 
                            'default'=> ( !isset( $attributes['keyword_max'] ) ? 5 : $attributes['keyword_max'] ),
                            'min' => 0,
                            'max' => 20,
                            'steps' => 1,
                            'filter'=>true,
                            'parent'=>'enable_keywords',
                            'filter_value'=>'true'
                        ),
                        'keyword_split_method' => array(
                            'name' => esc_html__( 'Keywords split method (default=both)', 'super-forms' ), 
                            'desc' => esc_html__( 'Select to split words by comma or space or both', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['keyword_split_method'] ) ? 'both' : $attributes['keyword_split_method'] ),
                            'type' => 'select', 
                            'values' => array(
                                'comma' => esc_html__( '"," (comma only)', 'super-forms' ), 
                                'space' => esc_html__( '" " (space only)', 'super-forms' ),
                                'both' => esc_html__( 'Both (comma and space)', 'super-forms' )
                            ),
                            'filter'=>true,
                            'parent'=>'keywords_retrieve_method',
                            'filter_value'=>'free'
                        ),
                    ),
                ),

                // @since 2.2.0
                'enable_search' => array(
                    'name' => esc_html__( 'Contact entry search (populate form with data)', 'super-forms' ),
                    'fields' => array(
                        'enable_search' => array(
                            'label' => sprintf( esc_html__( 'By default it will search for contact entries based on their title.%sA filter hook can be used to retrieve different data.', 'super-forms' ), '<br />' ),
                            'desc' => esc_html__( 'Wether or not to use the contact entry search feature', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['enable_search'] ) ? '' : $attributes['enable_search'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Enable contact entry search by title', 'super-forms' ),
                            )
                        ),
                        'search_method' => array(
                            'name' => esc_html__( 'Search method', 'super-forms' ), 
                            'desc' => esc_html__( 'Select how you want to filter entries', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['search_method'] ) ? 'equals' : $attributes['search_method'] ),
                            'type' => 'select', 
                            'values' => array(
                                'equals' => esc_html__( '== Equal (default)', 'super-forms' ),
                                'contains' => esc_html__( '?? Contains', 'super-forms' ), 
                            ),
                            'filter'=>true,
                            'parent'=>'enable_search',
                            'filter_value'=>'true'
                        ),
                        // @since 3.2.0 - skip specific field from being autopopulated after a successfull search result
                        'search_skip' => array(
                            'name' => esc_html__( 'Fields to skip (enter unique field names seperated by pipes)', 'super-forms' ), 
                            'label' => esc_html__( 'Example: first_name|last_name|email', 'super-forms' ), 
                            'desc' => esc_html__( 'Do not fill out the following field with entry data:', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['search_skip'] ) ? '' : $attributes['search_skip'] ),
                            'filter'=>true,
                            'parent'=>'enable_search',
                            'filter_value'=>'true'
                        ),

                    )
                ),
                'wc_order_search' => array(
                    'name' => esc_html__( 'WooCommerce Order Search (populate form with order data)', 'super-forms' ),
                    'fields' => array(
                        'wc_order_search' => array(
                            'default'=> ( !isset( $attributes['wc_order_search'] ) ? '' : $attributes['wc_order_search'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Enable WooCommerce Order Search', 'super-forms' ),
                            )
                        ),
                        'wc_order_search_method' => array(
                            'name' => esc_html__( 'Search method', 'super-forms' ), 
                            'desc' => esc_html__( 'Select how you want to filter orders', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['wc_order_search_method'] ) ? 'equals' : $attributes['wc_order_search_method'] ),
                            'type' => 'select', 
                            'values' => array(
                                'equals' => esc_html__( '== Equal (default)', 'super-forms' ),
                                'contains' => esc_html__( '?? Contains', 'super-forms' ), 
                            ),
                            'filter'=>true,
                            'parent'=>'wc_order_search',
                            'filter_value'=>'true'
                        ),
                        'wc_order_search_filterby' => array(
                            'name' => esc_html__( 'Filter by (leave blank to search all)', 'super-forms' ), 
                            'label' => esc_html__( "Define each on a new line e.g:\nID\n_billing_email\n_billing_address_1\n_billing_postcode\n_billing_first_name\n_billing_last_name\n_billing_company", 'super-forms' ), 
                            'default'=> ( !isset( $attributes['wc_order_search_filterby'] ) ? '' : $attributes['wc_order_search_filterby'] ),
                            'type' => 'textarea', 
                            'filter'=>true,
                            'parent'=>'wc_order_search',
                            'filter_value'=>'true'
                        ),
                        'wc_order_search_status' => array(
                            'name' => esc_html__( 'Filter by order status (leave blank to search all)', 'super-forms' ), 
                            'label' => esc_html__( 'Define each on a new line e.g:', 'super-forms' ) . '<br />' . implode('<br />',array_keys($wc_get_order_statuses)),
                            'default'=> ( !isset( $attributes['wc_order_search_status'] ) ? '' : $attributes['wc_order_search_status'] ),
                            'type' => 'textarea', 
                            'filter'=>true,
                            'parent'=>'wc_order_search',
                            'filter_value'=>'true'
                        ),
                        'wc_order_search_return_label' => array(
                            'name' => esc_html__( 'Return label format (define how the results are displayed)', 'super-forms' ), 
                            'label' => esc_html__( "Default format is: [Order #{ID} - {_billing_email}, {_billing_first_name} {_billing_last_name}]", 'super-forms' ), 
                            'default'=> ( !isset( $attributes['wc_order_search_return_label'] ) ? '' : $attributes['wc_order_search_return_label'] ),
                            'placeholder'=> esc_html__( '[Order #{ID} - {_billing_email}, {_billing_first_name} {_billing_last_name}]', 'super-forms' ),
                            'filter'=>true,
                            'parent'=>'wc_order_search',
                            'filter_value'=>'true'
                        ),
                        'wc_order_search_return_value' => array(
                            'name' => esc_html__( 'Return value format (define how the value is returned)', 'super-forms' ), 
                            'label' => esc_html__( "Default format is: ID;_billing_email;_billing_first_name;_billing_last_name", 'super-forms' ), 
                            'default'=> ( !isset( $attributes['wc_order_search_return_value'] ) ? '' : $attributes['wc_order_search_return_value'] ),
                            'placeholder'=> esc_html__( 'ID;_billing_email;_billing_first_name;_billing_last_name', 'super-forms' ),
                            'filter'=>true,
                            'parent'=>'wc_order_search',
                            'filter_value'=>'true'
                        ),
                        'wc_order_search_populate' => array(
                            'default'=> ( !isset( $attributes['wc_order_search_populate'] ) ? 'true' : $attributes['wc_order_search_populate'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'parent'=>'wc_order_search',
                            'filter_value'=>'true',
                            'values' => array(
                                'true' => esc_html__( 'Populate form with Contact Entry data if exists', 'super-forms' ),
                            )
                        ),
                        'wc_order_search_skip' => array(
                            'name' => esc_html__( 'Fields to skip (enter unique field names seperated by pipes)', 'super-forms' ), 
                            'label' => esc_html__( 'Example: first_name|last_name|email', 'super-forms' ), 
                            'desc' => esc_html__( 'Do not fill out the following field with entry data:', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['wc_order_search_skip'] ) ? '' : $attributes['wc_order_search_skip'] ),
                            'filter'=>true,
                            'parent'=>'wc_order_search',
                            'filter_value'=>'true'
                        ),
                    )
                ),

                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'disabled' => $disabled,
                        'readonly' => $readonly,
                        'autocomplete' => $autocomplete,
                        'grouped' => $grouped,
                        'mask' => array(
                            'default'=> ( !isset( $attributes['mask'] ) ? '' : $attributes['mask'] ),
                            'name' => esc_html__( 'Enter a predefined mask e.g: (999) 999-9999', 'super-forms' ), 
                            'label' => sprintf( esc_html__( '(leave blank for no input mask)%sa - Represents an alpha character (A-Z,a-z)%s9 - Represents a numeric character (0-9)%s* - Represents an alphanumeric character (A-Z,a-z,0-9)', 'super-forms' ), '<br />', '<br />', '<br />' ),
                        ),
                        'uppercase' => array(
                            'name' => esc_html__( 'Automatically transform text to uppercase', 'super-forms' ),
                            'label' => esc_html__( 'User input will automatically be converted into uppercase text', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['uppercase'] ) ? '' : $attributes['uppercase'] ),
                            'type' => 'checkbox', 
                            'values' => array(
                                'true' => esc_html__( 'Enable uppercase transformation', 'super-forms' ),
                            )
                        ),
                        'maxlength' => $maxlength,
                        'minlength' => $minlength,
                        'maxnumber' => $maxnumber,
                        'minnumber' => $minnumber,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 3.2.0 - custom TAB index
                        'custom_tab_index' => $custom_tab_index,

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_variable' => $conditional_variable_array,
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'textarea_predefined' => array(
            'name' => esc_html__( 'Text area', 'super-forms' ),
            'icon' => 'list-alt',
            'predefined' => array(
                array(
                    'tag' => 'textarea',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'question', 'super-forms' ),
                        'email' => esc_html__( 'Question:', 'super-forms' ),
                        'placeholder' => esc_html__( 'Ask us any questions...', 'super-forms' ),
                        'icon' => 'question',
                    )
                )
            ),
            'atts' => array(),
        ),
        'textarea' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::textarea',
            'name' => esc_html__( 'Text area', 'super-forms' ),
            'icon' => 'list-alt',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, '' ),
                        'email' => SUPER_Shortcodes::email($attributes, '' ),
                        'label' => $label,
                        'description'=>$description,
                        'placeholder' => SUPER_Shortcodes::placeholder($attributes, '' ),
                        'value' => array(
                            'name' => esc_html__( 'Default value', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a default value for this field. {post_id}, {post_title} and {user_****} can be used (leave blank for none)', 'super-forms' ),
                            'type' => 'textarea',
                            'default'=> ( !isset( $attributes['value'] ) ? '' : $attributes['value'] ),
                            'i18n' => true
                        ),
                        'tooltip' => $tooltip,
                        'validation' => $validation_empty,
                        'error' => $error,  
                    )
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'disabled' => $disabled,
                        'readonly' => $readonly,
                        'autocomplete' => $autocomplete,
                        'grouped' => $grouped,
                        'maxlength' => array(
                            'name' => esc_html__( 'Max characters/selections allowed', 'super-forms' ), 
                            'label' => esc_html__( 'Please note: The textarea max length setting will not cut off the user from being able to type beyond the limitation. This is for user friendly purposes to avoid text being cut of when a user tries to copy/paste text that would exceed the limit (which would be annoying in some circumstances).', 'super-forms' ),
                            'desc' => esc_html__( 'Set to 0 to remove limitations.', 'super-forms' ),
                            'type' => 'slider', 
                            'default'=> (!isset($attributes['maxlength']) ? 0 : $attributes['maxlength']),
                            'min' => 0, 
                            'max' => 100, 
                            'steps' => 1 
                        ),
                        'minlength' => $minlength,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'height' => $height,                    
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 3.2.0 - custom TAB index
                        'custom_tab_index' => $custom_tab_index,                        

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'editor_settings' => array(
                    'name' => esc_html__( 'Text Editor Settings', 'super-forms' ),
                    'fields' => array(
                        'editor' => array(
                            'name' => esc_html__( 'Enable the WordPress text editor', 'super-forms' ), 
                            'desc' => esc_html__( 'Wether to use the WordPress text editor (wp_editor)', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['editor'] ) ? 'false' : $attributes['editor'] ),
                            'type' => 'select', 
                            'values' => array(
                                'false' => esc_html__( 'No (disabled)', 'super-forms' ), 
                                'true' => esc_html__( 'Yes (enabled)', 'super-forms' ),
                            ),
                            'filter'=>true,
                        ),
                        'media_buttons' => array(
                            'name' => esc_html__( 'Enable media upload button', 'super-forms' ), 
                            'desc' => esc_html__( 'Whether to display media insert/upload buttons', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['media_buttons'] ) ? 'true' : $attributes['media_buttons'] ),
                            'type' => 'select', 
                            'values' => array(
                                'false' => esc_html__( 'No (disabled)', 'super-forms' ), 
                                'true' => esc_html__( 'Yes (enabled)', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'editor',
                            'filter_value'=>'true'
                        ),
                        'drag_drop_upload' => array(
                            'name' => esc_html__( 'Enable Drag & Drop Upload Support', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['drag_drop_upload'] ) ? 'false' : $attributes['drag_drop_upload'] ),
                            'type' => 'select', 
                            'values' => array(
                                'false' => esc_html__( 'No (disabled)', 'super-forms' ), 
                                'true' => esc_html__( 'Yes (enabled)', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'media_buttons',
                            'filter_value'=>'true'
                        ),
                        'wpautop' => array(
                            'name' => esc_html__( 'Automatically add paragraphs', 'super-forms' ), 
                            'desc' => esc_html__( 'Whether to use wpautop for adding in paragraphs', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['wpautop'] ) ? 'true' : $attributes['wpautop'] ),
                            'type' => 'select', 
                            'values' => array(
                                'false' => esc_html__( 'Yes (enabled)', 'super-forms' ), 
                                'true' => esc_html__( 'No (disabled)', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'editor',
                            'filter_value'=>'true'
                        ),
                        'force_br' => array(
                            'name' => esc_html__( 'Force to use line breaks instead of paragraphs', 'super-forms' ), 
                            'desc' => esc_html__( 'Let a new line break act as shift+enter', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['force_br'] ) ? 'false' : $attributes['force_br'] ),
                            'type' => 'select', 
                            'values' => array(
                                'false' => esc_html__( 'No (disabled)', 'super-forms' ),
                                'true' => esc_html__( 'Yes (enabled)', 'super-forms' ), 
                            ),
                            'filter'=>true,
                            'parent'=>'editor',
                            'filter_value'=>'true'
                        ),
                        'editor_height' => array(
                            'name' => esc_html__( 'Editor height in pixels', 'super-forms' ), 
                            'desc' => esc_html__( 'The height to set the editor in pixels', 'super-forms' ), 
                            'type' => 'slider', 
                            'default'=> ( !isset( $attributes['editor_height'] ) ? 100 : $attributes['editor_height'] ),
                            'min' => 0,
                            'max' => 500,
                            'steps' => 10,
                            'filter'=>true,
                            'parent'=>'editor',
                            'filter_value'=>'true'
                        ),
                        'teeny' => array(
                            'name' => esc_html__( 'Use minimal editor config', 'super-forms' ), 
                            'desc' => esc_html__( 'Whether to output the minimal editor configuration used in PressThis', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['teeny'] ) ? 'false' : $attributes['teeny'] ),
                            'type' => 'select', 
                            'values' => array(
                                'false' => esc_html__( 'No (disabled)', 'super-forms' ), 
                                'true' => esc_html__( 'Yes (enabled)', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'editor',
                            'filter_value'=>'true'
                        ),
                        'quicktags' => array(
                            'name' => esc_html__( 'Load Quicktags', 'super-forms' ), 
                            'desc' => esc_html__( 'Disable this to remove your editor\'s Visual and Text tabs', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['quicktags'] ) ? 'true' : $attributes['quicktags'] ),
                            'type' => 'select', 
                            'values' => array(
                                'false' => esc_html__( 'No (disabled)', 'super-forms' ), 
                                'true' => esc_html__( 'Yes (enabled)', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'editor',
                            'filter_value'=>'true'
                        ),
                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'dropdown_predefined' => array(
            'name' => esc_html__( 'Dropdown', 'super-forms' ),
            'icon' => 'caret-square-down;far',
            'predefined' => array(
                array(
                    'tag' => 'dropdown',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'option', 'super-forms' ),
                        'email' => esc_html__( 'Option:', 'super-forms' ),
                        'placeholder' => esc_html__( '- select a option -', 'super-forms' ),
                        'icon' => 'caret-square-down;far',
                        'dropdown_items' => array(
                            array(
                                'checked' => false,
                                'label' => esc_html__( 'First choice', 'super-forms' ),
                                'value' => esc_html__( 'first_choice', 'super-forms' )
                            ),
                            array(
                                'checked' => false,
                                'label' => esc_html__( 'Second choice', 'super-forms' ),
                                'value' => esc_html__( 'second_choice', 'super-forms' )
                            ),
                            array(
                                'checked' => false,
                                'label' => esc_html__( 'Third choice', 'super-forms' ),
                                'value' => esc_html__( 'third_choice', 'super-forms' )
                            )
                        )
                    )
                )
            ),
            'atts' => array(),
        ),
        'dropdown' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::dropdown',
            'name' => esc_html__( 'Dropdown', 'super-forms' ),
            'icon' => 'caret-square-down;far',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),

                        'disable_filter' => array(
                            'name' => esc_html__( 'Disallow users to filter items', 'super-forms' ), 
                            'label' => esc_html__( 'Enabling this will also prevent the keyboard from popping up on mobile devices', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['disable_filter'] ) ? '' : $attributes['disable_filter'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Disallow users to filter items', 'super-forms' ),
                            )
                        ),

                        'retrieve_method' => SUPER_Shortcodes::sf_retrieve_method( $attributes['retrieve_method'], '' ),
                        'retrieve_method_exclude_users' => SUPER_Shortcodes::sf_retrieve_method_exclude_users( $attributes['retrieve_method_exclude_users'], 'retrieve_method' ),
                        'retrieve_method_role_filters' => SUPER_Shortcodes::sf_retrieve_method_role_filters( $attributes['retrieve_method_role_filters'], 'retrieve_method' ),
                        'retrieve_method_user_label' => SUPER_Shortcodes::sf_retrieve_method_user_label( $attributes['retrieve_method_user_label'], 'retrieve_method' ),
                        'retrieve_method_user_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_user_meta_keys( $attributes['retrieve_method_user_meta_keys'], 'retrieve_method' ),
                        'retrieve_method_db_table' => SUPER_Shortcodes::sf_retrieve_method_db_table( $attributes['retrieve_method_db_table'], 'retrieve_method' ),
                        'retrieve_method_db_row_value' => SUPER_Shortcodes::sf_retrieve_method_db_row_value( $attributes['retrieve_method_db_row_value'], 'retrieve_method' ),
                        'retrieve_method_db_row_label' => SUPER_Shortcodes::sf_retrieve_method_db_row_label( $attributes['retrieve_method_db_row_label'], 'retrieve_method' ),
                        'retrieve_method_author_field' => SUPER_Shortcodes::sf_retrieve_method_author_field( $attributes['retrieve_method_author_field'], 'retrieve_method' ),
                        'retrieve_method_author_option_explode' => SUPER_Shortcodes::sf_retrieve_method_author_option_explode( $attributes['retrieve_method_author_option_explode'], 'retrieve_method' ),
                        'retrieve_method_author_line_explode' => SUPER_Shortcodes::sf_retrieve_method_author_line_explode( $attributes['retrieve_method_author_line_explode'], 'retrieve_method' ),
                        'retrieve_method_csv' => SUPER_Shortcodes::sf_retrieve_method_csv( $attributes['retrieve_method_csv'], 'retrieve_method' ),
                        'retrieve_method_delimiter' => SUPER_Shortcodes::sf_retrieve_method_delimiter( $attributes['retrieve_method_delimiter'], 'retrieve_method' ),
                        'retrieve_method_enclosure' => SUPER_Shortcodes::sf_retrieve_method_enclosure( $attributes['retrieve_method_enclosure'], 'retrieve_method' ),
                        'retrieve_method_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_taxonomy( $attributes['retrieve_method_taxonomy'], 'retrieve_method' ),
                        'retrieve_method_product_attribute' => SUPER_Shortcodes::sf_retrieve_method_product_attribute( $attributes['retrieve_method_product_attribute'], 'retrieve_method' ),
                        'retrieve_method_post' => SUPER_Shortcodes::sf_retrieve_method_post( $attributes['retrieve_method_post'], 'retrieve_method' ),
                        'retrieve_method_post_status' => SUPER_Shortcodes::sf_retrieve_method_post_status( $attributes['retrieve_method_post_status'], 'retrieve_method' ),
                        'retrieve_method_orderby' => SUPER_Shortcodes::sf_retrieve_method_orderby( $attributes['retrieve_method_orderby'], 'retrieve_method' ),
                        'retrieve_method_order' => SUPER_Shortcodes::sf_retrieve_method_order( $attributes['retrieve_method_order'], 'retrieve_method' ),
                        'retrieve_method_exclude_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_exclude_taxonomy( $attributes['retrieve_method_exclude_taxonomy'], 'retrieve_method' ),
                        'retrieve_method_exclude_post' => SUPER_Shortcodes::sf_retrieve_method_exclude_post( $attributes['retrieve_method_exclude_post'], 'retrieve_method' ),
                        'retrieve_method_filters' => SUPER_Shortcodes::sf_retrieve_method_filters( $attributes['retrieve_method_filters'], 'retrieve_method' ),
                        'retrieve_method_filter_relation' => SUPER_Shortcodes::sf_retrieve_method_filter_relation( $attributes['retrieve_method_filter_relation'], 'retrieve_method' ),
                        'retrieve_method_hide_empty' => SUPER_Shortcodes::sf_retrieve_method_hide_empty( $attributes['retrieve_method_hide_empty'], 'retrieve_method' ),
                        'retrieve_method_parent' => SUPER_Shortcodes::sf_retrieve_method_parent( $attributes['retrieve_method_parent'], 'retrieve_method' ),
                        'retrieve_method_value' => SUPER_Shortcodes::sf_retrieve_method_value( $attributes['retrieve_method_value'], 'retrieve_method' ),
                        'retrieve_method_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_meta_keys( $attributes['retrieve_method_meta_keys'], 'retrieve_method_value' ),
                        'dropdown_items' => SUPER_Shortcodes::sf_retrieve_method_custom_items( $attributes['dropdown_items'], 'retrieve_method', 'dropdown_items' ),

                        // @since 1.2.7
                        'admin_email_value' => $admin_email_value,
                        'confirm_email_value' => $confirm_email_value,
                        
                        // @since 1.2.9
                        'contact_entry_value' => $contact_entry_value,

                        'label' => $label,
                        'description'=>$description,
                        'placeholder' => SUPER_Shortcodes::placeholder($attributes, '' ),
                        'tooltip' => $tooltip,
                        'validation' => $validation_empty,
                        'error' => $error
                    )
                ),

                // @since 3.5.0 - google distance calculation between 2 addresses for dropdowns
                // Example GET request: http://maps.googleapis.com/maps/api/directions/json?gl=uk&units=imperial&origin=Ulft&destination=7064BW
                'distance_calculator' => array(
                    'name' => esc_html__( 'Distance / Duration calculation (google directions)', 'super-forms' ),
                    'fields' => array(
                        'enable_distance_calculator' => array(
                            'desc' => esc_html__( 'Wether or not to use the distance calculator feature', 'super-forms' ), 
                            'label' => sprintf( esc_html__( 'If you enable this option, make sure you have set your %sGoogle API key%s under "Super Forms > Settings > Form Settings"', 'super-forms' ), '<strong>', '</strong>' ), 
                            'default'=> ( !isset( $attributes['enable_distance_calculator'] ) ? '' : $attributes['enable_distance_calculator'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Enable distance calculator', 'super-forms' ),
                            )
                        ),
                        'distance_method' => array(
                            'name' => esc_html__( 'Select if this field must act as Start or Destination', 'super-forms' ), 
                            'desc' => esc_html__( 'This option is required so that Super Forms knows how to calculate the distance', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['distance_method'] ) ? 'start' : $attributes['distance_method'] ),
                            'type' => 'select', 
                            'values' => array(
                                'start' => esc_html__( 'Start address', 'super-forms' ), 
                                'destination' => esc_html__( 'Destination address', 'super-forms' )
                            ),
                            'filter'=>true,
                            'parent'=>'enable_distance_calculator',
                            'filter_value'=>'true'
                        ),
                        'distance_start' => array(
                            'name' => esc_html__( 'Starting address (required)', 'super-forms' ), 
                            'label' => esc_html__( 'Enter a fixed address/zipcode or enter the unique field name to retrieve dynamic address from users', 'super-forms' ),
                            'desc' => esc_html__( 'Required to calculate distance between 2 locations', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['start'] ) ? '' : $attributes['start'] ),
                            'filter'=>true,
                            'parent'=>'distance_method',
                            'filter_value'=>'destination'
                        ),
                        'distance_destination' => array(
                            'name' => esc_html__( 'Destination address (required)', 'super-forms' ), 
                            'label' => esc_html__( 'Enter a fixed address/zipcode or enter the unique field name to retrieve dynamic address from users', 'super-forms' ),
                            'desc' => esc_html__( 'Required to calculate distance between 2 locations', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['destination'] ) ? '' : $attributes['destination'] ),
                            'filter'=>true,
                            'parent'=>'distance_method',
                            'filter_value'=>'start'
                        ),
                        'distance_value' => array(
                            'name' => esc_html__( 'Select what value to return (distance or duration)', 'super-forms' ), 
                            'desc' => esc_html__( 'After calculating the distance either the amount of meters or seconds can be returned', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['distance_value'] ) ? 'distance' : $attributes['distance_value'] ),
                            'type' => 'select', 
                            'values' => array(
                                'distance' => esc_html__( 'Distance in meters', 'super-forms' ), 
                                'duration' => esc_html__( 'Duration in seconds', 'super-forms' ),
                                'dis_text' => esc_html__( 'Distance text in km or miles', 'super-forms' ), 
                                'dur_text' => esc_html__( 'Duration text in minutes', 'super-forms' )
                            ),
                            'filter'=>true,
                            'parent'=>'distance_method',
                            'filter_value'=>'start'
                        ),
                        'distance_units' => array(
                            'name' => esc_html__( 'Select a unit system', 'super-forms' ), 
                            'desc' => esc_html__( 'This will determine if the textual distance is returned in meters or miles', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['distance_units'] ) ? 'metric' : $attributes['distance_units'] ),
                            'type' => 'select', 
                            'values' => array(
                                'metric' => esc_html__( 'Metric (distance returned in kilometers and meters)', 'super-forms' ), 
                                'imperial' => esc_html__( 'Imperial (distance returned in miles and feet)', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'distance_value',
                            'filter_value'=>'dis_text'
                        ),
                        'distance_field' => array(
                            'name' => esc_html__( 'Enter the unique field name which the distance value should be populated to (required)', 'super-forms' ), 
                            'label' => esc_html__( 'This can be a Text field or Hidden field (do not add brackets before and after).', 'super-forms' ),
                            'desc' => esc_html__( 'After doing the calculation the value will be populated to this field', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['distance_field'] ) ? '' : $attributes['distance_field'] ),
                            'filter'=>true,
                            'parent'=>'distance_method',
                            'filter_value'=>'start'
                        ),
                    )
                ),

                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'readonly' => $readonly,
                        'maxlength' => $maxlength,
                        'minlength' => $minlength,
                        'grouped' => $grouped,
                        'width' => $width,                   
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'replace_commas' => $replace_commas,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position_left_only,

                        // @since 3.2.0 - custom TAB index
                        'custom_tab_index' => $custom_tab_index,

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,
                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array

            ),
        ),
        'dropdown_item' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::dropdown_item',
            'name' => '',
            'icon' => 'section-width',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'label' => array(
                            'name'=>esc_html__( 'Label', 'super-forms' ),
                            'default'=> ( !isset( $attributes['label']) ? esc_html__( 'Label', 'super-forms' ) : $attributes['label']),
                        ),
                        'value' => array(
                            'name'=>esc_html__( 'Value', 'super-forms' ),
                            'default'=> ( !isset( $attributes['value']) ? esc_html__( 'Value', 'super-forms' ) : $attributes['value']),
                        ),
                    )
                ),
            ),
        ),

        'checkbox_predefined' => array(
            'name' => esc_html__( 'Check box', 'super-forms' ),
            'icon' => 'check-square;far',
            'predefined' => array(
                array(
                    'tag' => 'checkbox',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'option', 'super-forms' ),
                        'email' => esc_html__( 'Option:', 'super-forms' ),
                        'icon' => 'check-square;far',
                        'checkbox_items' => array(
                            array(
                                'checked' => false,
                                'label' => esc_html__( 'First choice', 'super-forms' ),
                                'value' => esc_html__( 'first_choice', 'super-forms' )
                            ),
                            array(
                                'checked' => false,
                                'label' => esc_html__( 'Second choice', 'super-forms' ),
                                'value' => esc_html__( 'second_choice', 'super-forms' )
                            ),
                            array(
                                'checked' => false,
                                'label' => esc_html__( 'Third choice', 'super-forms' ),
                                'value' => esc_html__( 'third_choice', 'super-forms' )
                            )
                        )
                    )
                )
            ),
            'atts' => array(),
        ),
        'checkbox' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::checkbox',
            'name' => esc_html__( 'Check box', 'super-forms' ),
            'icon' => 'check-square-o',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'retrieve_method' => SUPER_Shortcodes::sf_retrieve_method( $attributes['retrieve_method'], '' ),
                        'retrieve_method_exclude_users' => SUPER_Shortcodes::sf_retrieve_method_exclude_users( $attributes['retrieve_method_exclude_users'], 'retrieve_method' ),
                        'retrieve_method_role_filters' => SUPER_Shortcodes::sf_retrieve_method_role_filters( $attributes['retrieve_method_role_filters'], 'retrieve_method' ),
                        'retrieve_method_user_label' => SUPER_Shortcodes::sf_retrieve_method_user_label( $attributes['retrieve_method_user_label'], 'retrieve_method' ),
                        'retrieve_method_user_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_user_meta_keys( $attributes['retrieve_method_user_meta_keys'], 'retrieve_method' ),
                        'retrieve_method_db_table' => SUPER_Shortcodes::sf_retrieve_method_db_table( $attributes['retrieve_method_db_table'], 'retrieve_method' ),
                        'retrieve_method_db_row_value' => SUPER_Shortcodes::sf_retrieve_method_db_row_value( $attributes['retrieve_method_db_row_value'], 'retrieve_method' ),
                        'retrieve_method_db_row_label' => SUPER_Shortcodes::sf_retrieve_method_db_row_label( $attributes['retrieve_method_db_row_label'], 'retrieve_method' ),
                        'retrieve_method_author_field' => SUPER_Shortcodes::sf_retrieve_method_author_field( $attributes['retrieve_method_author_field'], 'retrieve_method' ),
                        'retrieve_method_author_option_explode' => SUPER_Shortcodes::sf_retrieve_method_author_option_explode( $attributes['retrieve_method_author_option_explode'], 'retrieve_method' ),
                        'retrieve_method_author_line_explode' => SUPER_Shortcodes::sf_retrieve_method_author_line_explode( $attributes['retrieve_method_author_line_explode'], 'retrieve_method' ),
                        'retrieve_method_csv' => SUPER_Shortcodes::sf_retrieve_method_csv( $attributes['retrieve_method_csv'], 'retrieve_method' ),
                        'retrieve_method_delimiter' => SUPER_Shortcodes::sf_retrieve_method_delimiter( $attributes['retrieve_method_delimiter'], 'retrieve_method' ),
                        'retrieve_method_enclosure' => SUPER_Shortcodes::sf_retrieve_method_enclosure( $attributes['retrieve_method_enclosure'], 'retrieve_method' ),
                        'retrieve_method_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_taxonomy( $attributes['retrieve_method_taxonomy'], 'retrieve_method' ),
                        'retrieve_method_product_attribute' => SUPER_Shortcodes::sf_retrieve_method_product_attribute( $attributes['retrieve_method_product_attribute'], 'retrieve_method' ),
                        'retrieve_method_post' => SUPER_Shortcodes::sf_retrieve_method_post( $attributes['retrieve_method_post'], 'retrieve_method' ),
                        'retrieve_method_post_status' => SUPER_Shortcodes::sf_retrieve_method_post_status( $attributes['retrieve_method_post_status'], 'retrieve_method' ),
                        'retrieve_method_orderby' => SUPER_Shortcodes::sf_retrieve_method_orderby( $attributes['retrieve_method_orderby'], 'retrieve_method' ),
                        'retrieve_method_order' => SUPER_Shortcodes::sf_retrieve_method_order( $attributes['retrieve_method_order'], 'retrieve_method' ),
                        'retrieve_method_exclude_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_exclude_taxonomy( $attributes['retrieve_method_exclude_taxonomy'], 'retrieve_method' ),
                        'retrieve_method_exclude_post' => SUPER_Shortcodes::sf_retrieve_method_exclude_post( $attributes['retrieve_method_exclude_post'], 'retrieve_method' ),
                        'retrieve_method_filters' => SUPER_Shortcodes::sf_retrieve_method_filters( $attributes['retrieve_method_filters'], 'retrieve_method' ),
                        'retrieve_method_filter_relation' => SUPER_Shortcodes::sf_retrieve_method_filter_relation( $attributes['retrieve_method_filter_relation'], 'retrieve_method' ),
                        'retrieve_method_hide_empty' => SUPER_Shortcodes::sf_retrieve_method_hide_empty( $attributes['retrieve_method_hide_empty'], 'retrieve_method' ),
                        'retrieve_method_parent' => SUPER_Shortcodes::sf_retrieve_method_parent( $attributes['retrieve_method_parent'], 'retrieve_method' ),
                        'retrieve_method_value' => SUPER_Shortcodes::sf_retrieve_method_value( $attributes['retrieve_method_value'], 'retrieve_method' ),
                        'retrieve_method_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_meta_keys( $attributes['retrieve_method_meta_keys'], 'retrieve_method_value' ),
                        'checkbox_items' => SUPER_Shortcodes::sf_retrieve_method_custom_items( $attributes['checkbox_items'], 'retrieve_method', 'checkbox_items' ),

                        // @since 1.2.7
                        'admin_email_value' => $admin_email_value,
                        'confirm_email_value' => $confirm_email_value,
                        
                        // @since 1.2.9
                        'contact_entry_value' => $contact_entry_value,

                        'label' => $label,
                        'description'=>$description,
                        'tooltip' => $tooltip,
                        'validation' => $validation_empty,
                        'error' => $error,  
                    )
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'display' => array(
                            'name'=>esc_html__( 'Vertical / Horizontal display', 'super-forms' ), 
                            'type' => 'select',
                            'default'=> ( !isset( $attributes['display']) ? 'vertical' : $attributes['display']),
                            'values' => array(
                                'vertical' => esc_html__( 'Vertical display ( | )', 'super-forms' ), 
                                'horizontal' => esc_html__( 'Horizontal display ( -- )', 'super-forms' ), 
                            ),
                        ),
                        'grouped' => $grouped,                    
                        'maxlength' => $maxlength,
                        'minlength' => $minlength,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'replace_commas' => $replace_commas,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position_left_only,
                        
                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),
        'checkbox_item' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::checkbox_item',
            'name' => '',
            'icon' => 'section-width',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'label' => array(
                            'name'=>esc_html__( 'Label', 'super-forms' ),
                            'default'=> ( !isset( $attributes['label']) ? esc_html__( 'Label', 'super-forms' ) : $attributes['label']),
                        ),
                        'value' => array(
                            'name'=>esc_html__( 'Value', 'super-forms' ),
                            'default'=> ( !isset( $attributes['value']) ? esc_html__( 'Value', 'super-forms' ) : $attributes['value']),
                        ),
                    )
                ),
            ),
        ),

        'radio_predefined' => array(
            'name' => esc_html__( 'Radio buttons', 'super-forms' ),
            'icon' => 'dot-circle;far',
            'predefined' => array(
                array(
                    'tag' => 'radio',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'option', 'super-forms' ),
                        'email' => esc_html__( 'Option:', 'super-forms' ),
                        'icon' => 'dot-circle;far',
                        'radio_items' => array(
                            array(
                                'checked' => 'false',
                                'label' => esc_html__( 'First choice', 'super-forms' ),
                                'value' => esc_html__( 'first_choice', 'super-forms' )
                            ),
                            array(
                                'checked' => 'false',
                                'label' => esc_html__( 'Second choice', 'super-forms' ),
                                'value' => esc_html__( 'second_choice', 'super-forms' )
                            ),
                            array(
                                'checked' => 'false',
                                'label' => esc_html__( 'Third choice', 'super-forms' ),
                                'value' => esc_html__( 'third_choice', 'super-forms' )
                            )
                        )
                    )
                )
            ),
            'atts' => array(),
        ),
        'radio' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::radio',
            'name' => esc_html__( 'Radio buttons', 'super-forms' ),
            'icon' => 'dot-circle;far',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, '' ),
                        'email' => SUPER_Shortcodes::email($attributes, '' ),
                        'retrieve_method' => SUPER_Shortcodes::sf_retrieve_method( $attributes['retrieve_method'], '' ),
                        'retrieve_method_exclude_users' => SUPER_Shortcodes::sf_retrieve_method_exclude_users( $attributes['retrieve_method_exclude_users'], 'retrieve_method' ),
                        'retrieve_method_role_filters' => SUPER_Shortcodes::sf_retrieve_method_role_filters( $attributes['retrieve_method_role_filters'], 'retrieve_method' ),
                        'retrieve_method_user_label' => SUPER_Shortcodes::sf_retrieve_method_user_label( $attributes['retrieve_method_user_label'], 'retrieve_method' ),
                        'retrieve_method_user_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_user_meta_keys( $attributes['retrieve_method_user_meta_keys'], 'retrieve_method' ),
                        'retrieve_method_db_table' => SUPER_Shortcodes::sf_retrieve_method_db_table( $attributes['retrieve_method_db_table'], 'retrieve_method' ),
                        'retrieve_method_db_row_value' => SUPER_Shortcodes::sf_retrieve_method_db_row_value( $attributes['retrieve_method_db_row_value'], 'retrieve_method' ),
                        'retrieve_method_db_row_label' => SUPER_Shortcodes::sf_retrieve_method_db_row_label( $attributes['retrieve_method_db_row_label'], 'retrieve_method' ),
                        'retrieve_method_author_field' => SUPER_Shortcodes::sf_retrieve_method_author_field( $attributes['retrieve_method_author_field'], 'retrieve_method' ),
                        'retrieve_method_author_option_explode' => SUPER_Shortcodes::sf_retrieve_method_author_option_explode( $attributes['retrieve_method_author_option_explode'], 'retrieve_method' ),
                        'retrieve_method_author_line_explode' => SUPER_Shortcodes::sf_retrieve_method_author_line_explode( $attributes['retrieve_method_author_line_explode'], 'retrieve_method' ),
                        'retrieve_method_csv' => SUPER_Shortcodes::sf_retrieve_method_csv( $attributes['retrieve_method_csv'], 'retrieve_method' ),
                        'retrieve_method_delimiter' => SUPER_Shortcodes::sf_retrieve_method_delimiter( $attributes['retrieve_method_delimiter'], 'retrieve_method' ),
                        'retrieve_method_enclosure' => SUPER_Shortcodes::sf_retrieve_method_enclosure( $attributes['retrieve_method_enclosure'], 'retrieve_method' ),
                        'retrieve_method_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_taxonomy( $attributes['retrieve_method_taxonomy'], 'retrieve_method' ),
                        'retrieve_method_product_attribute' => SUPER_Shortcodes::sf_retrieve_method_product_attribute( $attributes['retrieve_method_product_attribute'], 'retrieve_method' ),
                        'retrieve_method_post' => SUPER_Shortcodes::sf_retrieve_method_post( $attributes['retrieve_method_post'], 'retrieve_method' ),
                        'retrieve_method_post_status' => SUPER_Shortcodes::sf_retrieve_method_post_status( $attributes['retrieve_method_post_status'], 'retrieve_method' ),
                        'retrieve_method_orderby' => SUPER_Shortcodes::sf_retrieve_method_orderby( $attributes['retrieve_method_orderby'], 'retrieve_method' ),
                        'retrieve_method_order' => SUPER_Shortcodes::sf_retrieve_method_order( $attributes['retrieve_method_order'], 'retrieve_method' ),
                        'retrieve_method_exclude_taxonomy' => SUPER_Shortcodes::sf_retrieve_method_exclude_taxonomy( $attributes['retrieve_method_exclude_taxonomy'], 'retrieve_method' ),
                        'retrieve_method_exclude_post' => SUPER_Shortcodes::sf_retrieve_method_exclude_post( $attributes['retrieve_method_exclude_post'], 'retrieve_method' ),
                        'retrieve_method_filters' => SUPER_Shortcodes::sf_retrieve_method_filters( $attributes['retrieve_method_filters'], 'retrieve_method' ),
                        'retrieve_method_filter_relation' => SUPER_Shortcodes::sf_retrieve_method_filter_relation( $attributes['retrieve_method_filter_relation'], 'retrieve_method' ),
                        'retrieve_method_hide_empty' => SUPER_Shortcodes::sf_retrieve_method_hide_empty( $attributes['retrieve_method_hide_empty'], 'retrieve_method' ),
                        'retrieve_method_parent' => SUPER_Shortcodes::sf_retrieve_method_parent( $attributes['retrieve_method_parent'], 'retrieve_method' ),
                        'retrieve_method_value' => SUPER_Shortcodes::sf_retrieve_method_value( $attributes['retrieve_method_value'], 'retrieve_method' ),
                        'retrieve_method_meta_keys' => SUPER_Shortcodes::sf_retrieve_method_meta_keys( $attributes['retrieve_method_meta_keys'], 'retrieve_method_value' ),
                        'radio_items' => SUPER_Shortcodes::sf_retrieve_method_custom_items( $attributes['radio_items'], 'retrieve_method', 'radio_items' ),

                        // @since 1.2.7
                        'admin_email_value' => $admin_email_value,
                        'confirm_email_value' => $confirm_email_value,

                        // @since 1.2.9
                        'contact_entry_value' => $contact_entry_value,

                        'label'=>$label,
                        'description'=>$description,
                        'tooltip' => $tooltip,
                        'validation' => $validation_empty,
                        'error' => $error,  
                    )
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'display' => array(
                            'name'=>esc_html__( 'Vertical / Horizontal display', 'super-forms' ), 
                            'type' => 'select',
                            'default'=> ( !isset( $attributes['display']) ? 'vertical' : $attributes['display']),
                            'values' => array(
                                'vertical' => esc_html__( 'Vertical display ( | )', 'super-forms' ), 
                                'horizontal' => esc_html__( 'Horizontal display ( -- )', 'super-forms' ), 
                            ),
                        ),
                        'grouped' => $grouped,                    
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'replace_commas' => $replace_commas,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position_left_only,
                        
                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),
        'radio_item' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::radio_item',
            'name' => '',
            'icon' => 'section-width',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'label' => array(
                            'name'=>esc_html__( 'Label', 'super-forms' ),
                            'default'=> ( !isset( $attributes['label']) ? esc_html__( 'Label', 'super-forms' ) : $attributes['label']),
                        ),
                        'value' => array(
                            'name'=>esc_html__( 'Value', 'super-forms' ),
                            'default'=> ( !isset( $attributes['value']) ? esc_html__( 'Value', 'super-forms' ) : $attributes['value']),
                        ),
                    )
                ),
            ),
        ),

        'quantity_predefined' => array(
            'name' => esc_html__( 'Quantity field', 'super-forms' ),
            'icon' => 'plus-square',
            'predefined' => array(
                array(
                    'tag' => 'quantity',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'quantity', 'super-forms' ),
                        'email' => esc_html__( 'Quantity:', 'super-forms' ),
                        'value' => '0'
                    )
                )
            ),
            'atts' => array(),
        ),
        'quantity' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::quantity_field',
            'name' => esc_html__( 'Quantity field', 'super-forms' ),
            'icon' => 'plus-square',
            'atts' => array(
                 'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,                    
                        'value' => array(
                            'default'=> ( !isset( $attributes['value'] ) ? '' : $attributes['value'] ),
                            'name' => esc_html__( 'Default value', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a default value for this field (leave blank for none)', 'super-forms' )
                        ),
                        'tooltip' => $tooltip,
                        'conditional_validation' => $conditional_validation,
                        'conditional_validation_value' => $conditional_validation_value,
                        'conditional_validation_value2' => $conditional_validation_value2, // @since 3.6.0
                        'may_be_empty' => $may_be_empty,
                        'error' => $error,
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'disabled' => $disabled,
                        'readonly' => $readonly,
                        'grouped' => $grouped,
                        'steps' => array(
                            'type' => 'slider', 
                            'default'=> (!isset($attributes['steps']) ? 1 : $attributes['steps']),
                            'min' => 0,
                            'max' => 50,
                            'steps' => 0.5,
                            'name' => esc_html__( 'The amount to add or deduct when button is clicked', 'super-forms' ), 
                        ),
                        'minnumber' => array(
                            'type' => 'slider', 
                            'default'=> (!isset($attributes['minnumber']) ? 0 : $attributes['minnumber']),
                            'min' => 0,
                            'max' => 100,
                            'steps' => 1,
                            'name' => esc_html__( 'The minimum amount', 'super-forms' ), 
                        ),
                        'maxnumber' => array(
                            'type' => 'slider', 
                            'default'=> (!isset($attributes['maxnumber']) ? 100 : $attributes['maxnumber']),
                            'min' => 0,
                            'max' => 100,
                            'steps' => 1,
                            'name' => esc_html__( 'The maximum amount', 'super-forms' ), 
                        ),
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 3.2.0 - custom TAB index
                        'custom_tab_index' => $custom_tab_index,

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        // @since 2.9.0 - toggle butotn
        'toggle_predefined' => array(
            'name' => esc_html__( 'Toggle field', 'super-forms' ),
            'icon' => 'toggle-on',
            'predefined' => array(
                array(
                    'tag' => 'toggle',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'quantity', 'super-forms' ),
                        'email' => esc_html__( 'Quantity:', 'super-forms' ),
                        'icon' => 'toggle-on'
                    )
                )
            ),
            'atts' => array(),
        ),
        'toggle' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::toggle_field',
            'name' => esc_html__( 'Toggle field', 'super-forms' ),
            'icon' => 'toggle-on',
            'atts' => array(
                 'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,

                        'prefix_label' => array(
                            'name'=>esc_html__( 'Prefix label', 'super-forms' ), 
                            'desc'=>esc_html__( 'Text on left side of the toggle button (leave blank for no text)', 'super-forms' ),
                            'default'=> (!isset($attributes['prefix_label']) ? '' : $attributes['prefix_label']),
                            'i18n' => true
                        ),
                        'prefix_tooltip' => array(
                            'name'=>esc_html__( 'Prefix question icon tooltip text', 'super-forms' ), 
                            'label'=>esc_html__( 'Leave blank for no question icon', 'super-forms' ), 
                            'desc'=>esc_html__( 'This will add a question mark with a tooltip (leave blank for no question icon)', 'super-forms' ),
                            'default'=> (!isset($attributes['prefix_tooltip']) ? '' : $attributes['prefix_tooltip']),
                            'i18n' => true
                        ),
                        'suffix_label' => array(
                            'name'=>esc_html__( 'Suffix label', 'super-forms' ), 
                            'desc'=>esc_html__( 'Text on right side of the toggle button (leave blank for no text)', 'super-forms' ),
                            'default'=> (!isset($attributes['suffix_label']) ? '' : $attributes['suffix_label']),
                            'i18n' => true
                        ),
                        'suffix_tooltip' => array(
                            'name'=>esc_html__( 'Suffix question icon tooltip text', 'super-forms' ), 
                            'label'=>esc_html__( 'Leave blank for no question icon', 'super-forms' ), 
                            'desc'=>esc_html__( 'This will add a question mark with a tooltip (leave blank for no question icon)', 'super-forms' ),
                            'default'=> (!isset($attributes['suffix_tooltip']) ? '' : $attributes['suffix_tooltip']),
                            'i18n' => true
                        ),
                        'value' => array(
                            'name' => esc_html__( 'Toggle start value (default status)', 'super-forms' ), 
                            'desc' => esc_html__( 'Select the toggle default status', 'super-forms' ),
                            'default'=> (!isset($attributes['value']) ? '0' : $attributes['value']),
                            'type'=>'select', 
                            'values'=>array(
                                '1' => esc_html__( 'On (toggle enabled)', 'super-forms' ),
                                '0' => esc_html__( 'Off (toggle disabled)', 'super-forms' ),
                            )
                        ),
                        'on_value' => array(
                            'default'=> ( !isset( $attributes['on_value'] ) ? 'on' : $attributes['on_value'] ),
                            'name' => esc_html__( '"On" value', 'super-forms' ), 
                            'desc' => esc_html__( 'This is the toggle value when the user enabled the toggle element', 'super-forms' ),
                        ),
                        'on_label' => array(
                            'default'=> ( !isset( $attributes['on_label'] ) ? esc_html__( 'On', 'super-forms' ) : $attributes['on_label'] ),
                            'name' => esc_html__( '"On" label', 'super-forms' ), 
                            'desc' => esc_html__( 'This is the toggle label when the user enabled the toggle element', 'super-forms' ),
                            'i18n' => true
                        ),
                        'off_value' => array(
                            'default'=> ( !isset( $attributes['off_value'] ) ? 'off' : $attributes['off_value'] ),
                            'name' => esc_html__( '"Off" value', 'super-forms' ), 
                            'desc' => esc_html__( 'This is the toggle value when the user disabled the toggle element', 'super-forms' ),
                        ),
                        'off_label' => array(
                            'default'=> ( !isset( $attributes['off_label'] ) ? esc_html__( 'Off', 'super-forms' ) : $attributes['off_label'] ),
                            'name' => esc_html__( '"Off" label', 'super-forms' ), 
                            'desc' => esc_html__( 'This is the toggle label when the user disabled the toggle element', 'super-forms' ),
                            'i18n' => true
                        ),
                        'tooltip' => $tooltip,
                        'conditional_validation' => $conditional_validation,
                        'conditional_validation_value' => $conditional_validation_value,
                        'conditional_validation_value2' => $conditional_validation_value2, // @since 3.6.0
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'grouped' => $grouped,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,
                    
                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),                
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        // @since 3.1.0 - color picker element
        'color_predefined' => array(
            'name' => esc_html__( 'Color picker', 'super-forms' ),
            'icon' => 'eye-dropper',
            'predefined' => array(
                array(
                    'tag' => 'color',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'color', 'super-forms' ),
                        'email' => esc_html__( 'Color:', 'super-forms' ),
                        'icon' => 'eye-dropper',
                    )
                )
            ),
            'atts' => array(),
        ),
        'color' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::color',
            'name' => esc_html__( 'Color picker', 'super-forms' ),
            'icon' => 'eye-dropper',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,
                        'prefix_label' => array(
                            'name'=>esc_html__( 'Prefix label', 'super-forms' ), 
                            'desc'=>esc_html__( 'Text on left side of the color picker (leave blank for no text)', 'super-forms' ),
                            'default'=> (!isset($attributes['prefix_label']) ? '' : $attributes['prefix_label']),
                            'i18n'=>true
                        ),
                        'prefix_tooltip' => array(
                            'name'=>esc_html__( 'Prefix question icon tooltip text', 'super-forms' ), 
                            'label'=>esc_html__( 'Leave blank for no question icon', 'super-forms' ), 
                            'desc'=>esc_html__( 'This will add a question mark with a tooltip (leave blank for no question icon)', 'super-forms' ),
                            'default'=> (!isset($attributes['prefix_tooltip']) ? '' : $attributes['prefix_tooltip']),
                            'i18n'=>true
                        ),
                        'suffix_label' => array(
                            'name'=>esc_html__( 'Suffix label', 'super-forms' ), 
                            'desc'=>esc_html__( 'Text on right side of the color picker (leave blank for no text)', 'super-forms' ),
                            'default'=> (!isset($attributes['suffix_label']) ? '' : $attributes['suffix_label']),
                            'i18n'=>true
                        ),
                        'suffix_tooltip' => array(
                            'name'=>esc_html__( 'Suffix question icon tooltip text', 'super-forms' ), 
                            'label'=>esc_html__( 'Leave blank for no question icon', 'super-forms' ), 
                            'desc'=>esc_html__( 'This will add a question mark with a tooltip (leave blank for no question icon)', 'super-forms' ),
                            'default'=> (!isset($attributes['suffix_tooltip']) ? '' : $attributes['suffix_tooltip']),
                            'i18n'=>true
                        ),
                        'value' => array(
                            'default'=> ( !isset( $attributes['value'] ) ? '' : $attributes['value'] ),
                            'name' => esc_html__( 'Default value', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a default color (leave blank for none)', 'super-forms' )
                        ),
                        'tooltip' => $tooltip,
                        'validation' => $special_validations,
                        'custom_regex' => $custom_regex,
                        'conditional_validation' => $conditional_validation,
                        'conditional_validation_value' => $conditional_validation_value,
                        'conditional_validation_value2' => $conditional_validation_value2, // @since 3.6.0
                        'may_be_empty' => $may_be_empty,
                        'error' => $error,
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'disabled' => $disabled,
                        'readonly' => $readonly,
                        'autocomplete' => $autocomplete,
                        'grouped' => $grouped,
                        'uppercase' => array(
                            'name' => esc_html__( 'Automatically transform text to uppercase', 'super-forms' ),
                            'label' => esc_html__( 'User input will automatically be converted into uppercase text', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['uppercase'] ) ? '' : $attributes['uppercase'] ),
                            'type' => 'checkbox', 
                            'values' => array(
                                'true' => esc_html__( 'Enable uppercase transformation', 'super-forms' ),
                            )
                        ),
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 3.2.0 - custom TAB index
                        'custom_tab_index' => $custom_tab_index,

                        'class' => $class,
                        'wrapper_class' => $wrapper_class,
                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'slider_predefined' => array(
            'name' => esc_html__( 'Slider field', 'super-forms' ),
            'icon' => 'sliders-h',
            'predefined' => array(
                array(
                    'tag' => 'slider',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'amount', 'super-forms' ),
                        'email' => esc_html__( 'Amount:', 'super-forms' ),
                        'value' => '0',
                        'currency' => '$',
                        'thousand_separator' => ',',
                        'icon' => 'sliders-h',
                    )
                )
            ),
            'atts' => array(),
        ),
        'slider' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::slider_field',
            'name' => esc_html__( 'Slider field', 'super-forms' ),
            'icon' => 'sliders-h',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,
                        'value' => array(
                            'default'=> ( !isset( $attributes['value'] ) ? '' : $attributes['value'] ),
                            'name' => esc_html__( 'Default value', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a default value for this field (leave blank for none)', 'super-forms' )
                        ),
                        'format' => array(
                            'default'=> ( !isset( $attributes['format'] ) ? '' : $attributes['format'] ),
                            'name' => esc_html__( 'Number format (example: GB / Gygabyte)', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a number format e.g: Gygabyte, Kilometers etc. (leave blank for none)', 'super-forms' ),
                            'i18n'=>true
                        ),
                        'currency' => array(
                            'name'=>esc_html__( 'Currency', 'super-forms' ), 
                            'desc'=>esc_html__( 'Set the currency of or leave empty for no currency e.g: $ or €', 'super-forms' ),
                            'default'=> ( !isset( $attributes['currency'] ) ? '' : $attributes['currency'] ),
                            'placeholder'=>'$',
                            'i18n'=>true
                        ),
                        'decimals' => array(
                            'name'=>esc_html__( 'Length of decimal', 'super-forms' ), 
                            'desc'=>esc_html__( 'Choose a length for your decimals (default = 2)', 'super-forms' ), 
                            'default'=> (!isset($attributes['decimals']) ? '2' : $attributes['decimals']),
                            'type'=>'select', 
                            'values'=>array(
                                '0' => esc_html__( '0 decimals', 'super-forms' ),
                                '1' => esc_html__( '1 decimal', 'super-forms' ),
                                '2' => esc_html__( '2 decimals', 'super-forms' ),
                                '3' => esc_html__( '3 decimals', 'super-forms' ),
                                '4' => esc_html__( '4 decimals', 'super-forms' ),
                                '5' => esc_html__( '5 decimals', 'super-forms' ),
                                '6' => esc_html__( '6 decimals', 'super-forms' ),
                                '7' => esc_html__( '7 decimals', 'super-forms' ),
                            ),
                            'i18n'=>true
                        ),
                        'decimal_separator' => array(
                            'name'=>esc_html__( 'Decimal separator', 'super-forms' ), 
                            'desc'=>esc_html__( 'Choose your decimal separator (comma or dot)', 'super-forms' ), 
                            'default'=> (!isset($attributes['decimal_separator']) ? '.' : $attributes['decimal_separator']),
                            'type'=>'select', 
                            'values'=>array(
                                '.' => esc_html__( '. (dot)', 'super-forms' ),
                                ',' => esc_html__( ', (comma)', 'super-forms' ), 
                            ),
                            'i18n'=>true
                        ),
                        'thousand_separator' => array(
                            'name'=>esc_html__( 'Thousand separator', 'super-forms' ), 
                            'desc'=>esc_html__( 'Choose your thousand separator (empty, comma or dot)', 'super-forms' ), 
                            'default'=> (!isset($attributes['thousand_separator']) ? '' : $attributes['thousand_separator']),
                            'type'=>'select', 
                            'values'=>array(
                                '' => esc_html__( 'None (empty)', 'super-forms' ),
                                '.' => esc_html__( '. (dot)', 'super-forms' ),
                                ',' => esc_html__( ', (comma)', 'super-forms' ), 
                            ),
                            'i18n'=>true
                        ),
                        'tooltip' => $tooltip,
                        'validation' => $special_validations,
                        'custom_regex' => $custom_regex,
                        'conditional_validation' => $conditional_validation,
                        'conditional_validation_value' => $conditional_validation_value,
                        'conditional_validation_value2' => $conditional_validation_value2, // @since 3.6.0
                        'may_be_empty' => $may_be_empty,
                        'error' => $error,
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'grouped' => $grouped,
                        'steps' => array(
                            'type' => 'slider', 
                            'default'=> (!isset($attributes['steps']) ? 1 : $attributes['steps']),
                            'min' => 0,
                            'max' => 100,
                            'steps' => 1,
                            'name' => esc_html__( 'The steps the slider makes when sliding', 'super-forms' ), 
                        ),
                        'minnumber' => array(
                            'type' => 'slider', 
                            'default'=> (!isset($attributes['minnumber']) ? 0 : $attributes['minnumber']),
                            'min' => 0,
                            'max' => 100,
                            'steps' => 1,
                            'name' => esc_html__( 'The minimum amount', 'super-forms' ), 
                        ),
                        'maxnumber' => array(
                            'type' => 'slider', 
                            'default'=> (!isset($attributes['maxnumber']) ? 100 : $attributes['maxnumber']),
                            'min' => 0,
                            'max' => 100,
                            'steps' => 1,
                            'name' => esc_html__( 'The maximum amount', 'super-forms' ), 
                        ),
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 1.9
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        // @since 2.1.0
        'currency_predefined' => array(
            'name' => esc_html__( 'Currency field', 'super-forms' ),
            'icon' => 'dollar-sign',
            'predefined' => array(
                array(
                    'tag' => 'currency',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'amount', 'super-forms' ),
                        'email' => esc_html__( 'Amount:', 'super-forms' ),
                        'currency' => '$',
                        'thousand_separator' => ',',
                        'icon' => 'dollar-sign',
                    )
                )
            ),
            'atts' => array(),
        ),
        'currency' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::currency',
            'name' => esc_html__( 'Currency field', 'super-forms' ),
            'icon' => 'dollar-sign',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,
                        
                        // @deprecated since 2.8.0 - currency fields no longer support placeholders due to validating the value and only allowing currency formats
                        //'placeholder' => SUPER_Shortcodes::placeholder( $attributes, esc_html__( '$0.00', 'super-forms' ) ),
                        
                        'value' => array(
                            'default'=> ( !isset( $attributes['value'] ) ? '' : $attributes['value'] ),
                            'name' => esc_html__( 'Default value', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a default value for this field (leave blank for none)', 'super-forms' )
                        ),
                        'format' => array(
                            'default'=> ( !isset( $attributes['format'] ) ? '' : $attributes['format'] ),
                            'name' => esc_html__( 'Number format (example: GB / Gygabyte)', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a number format e.g: Gygabyte, Kilometers etc. (leave blank for none)', 'super-forms' ),
                            'i18n'=>true
                        ),
                        'currency' => array(
                            'name'=>esc_html__( 'Currency', 'super-forms' ), 
                            'desc'=>esc_html__( 'Set the currency of or leave empty for no currency e.g: $ or €', 'super-forms' ),
                            'default'=> ( !isset( $attributes['currency'] ) ? '' : $attributes['currency'] ),
                            'placeholder'=>'$',
                            'i18n'=>true
                        ),
                        'decimals' => array(
                            'name'=>esc_html__( 'Length of decimal', 'super-forms' ), 
                            'desc'=>esc_html__( 'Choose a length for your decimals (default = 2)', 'super-forms' ), 
                            'default'=> (!isset($attributes['decimals']) ? '2' : $attributes['decimals']),
                            'type'=>'select', 
                            'values'=>array(
                                '0' => esc_html__( '0 decimals', 'super-forms' ),
                                '1' => esc_html__( '1 decimal', 'super-forms' ),
                                '2' => esc_html__( '2 decimals', 'super-forms' ),
                                '3' => esc_html__( '3 decimals', 'super-forms' ),
                                '4' => esc_html__( '4 decimals', 'super-forms' ),
                                '5' => esc_html__( '5 decimals', 'super-forms' ),
                                '6' => esc_html__( '6 decimals', 'super-forms' ),
                                '7' => esc_html__( '7 decimals', 'super-forms' ),
                            ),
                            'i18n'=>true
                        ),
                        'decimal_separator' => array(
                            'name'=>esc_html__( 'Decimal separator', 'super-forms' ), 
                            'desc'=>esc_html__( 'Choose your decimal separator (comma or dot)', 'super-forms' ), 
                            'default'=> (!isset($attributes['decimal_separator']) ? '.' : $attributes['decimal_separator']),
                            'type'=>'select', 
                            'values'=>array(
                                '.' => esc_html__( '. (dot)', 'super-forms' ),
                                ',' => esc_html__( ', (comma)', 'super-forms' ), 
                            ),
                            'i18n'=>true
                        ),
                        'thousand_separator' => array(
                            'name'=>esc_html__( 'Thousand separator', 'super-forms' ), 
                            'desc'=>esc_html__( 'Choose your thousand separator (empty, comma or dot)', 'super-forms' ), 
                            'default'=> (!isset($attributes['thousand_separator']) ? '' : $attributes['thousand_separator']),
                            'type'=>'select', 
                            'values'=>array(
                                '' => esc_html__( 'None (empty)', 'super-forms' ),
                                '.' => esc_html__( '. (dot)', 'super-forms' ),
                                ',' => esc_html__( ', (comma)', 'super-forms' ), 
                            ),
                            'i18n'=>true
                        ),
                        'tooltip' => $tooltip,
                        'validation' => $special_validations,
                        'custom_regex' => $custom_regex,
                        'conditional_validation' => $conditional_validation,
                        'conditional_validation_value' => $conditional_validation_value,
                        'conditional_validation_value2' => $conditional_validation_value2, // @since 3.6.0
                        'may_be_empty' => $may_be_empty,
                        'error' => $error,
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'disabled' => $disabled,
                        'readonly' => $readonly,
                        'autocomplete' => $autocomplete,
                        'grouped' => $grouped,
                        'maxlength' => $maxlength,
                        'minlength' => $minlength,
                        'maxnumber' => $maxnumber,
                        'minnumber' => $minnumber,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 3.2.0 - custom TAB index
                        'custom_tab_index' => $custom_tab_index,

                        // @since 4.2.0 - field change threshold
                        'threshold' => array(
                            'name'=> esc_html__( 'Threshold for the "keyup" event before hooks are fired (in milliseconds)', 'super-forms' ),
                            'label' => esc_html__( 'When the user starts typing without any pause for the given threshold it will not trigger any hooks. This threshold is applied on the "keyup" event only. Only as soon as the user stops typing and the threshold was filled it will execute the hooks. By default this value is set to 0 for instant triggers', 'super-forms' ), 
                            'desc' => esc_html__( 'Only change this if you feel that the form is freezing while you are typing (for large forms with above average triggers)', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['threshold']) ? 0 : $attributes['threshold']),
                            'type'=>'slider',
                            'min'=>0,
                            'max'=>5000,
                            'steps'=>100,
                        ),

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'file_predefined' => array(
            'name' => esc_html__( 'File upload', 'super-forms' ),
            'icon' => 'download',
            'predefined' => array(
                array(
                    'tag' => 'file',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'file', 'super-forms' ),
                        'email' => esc_html__( 'File:', 'super-forms' ),
                        'icon' => 'download',
                    )
                )
            ),
            'atts' => array(),
        ),
        'file' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::file',
            'name' => esc_html__( 'File upload', 'super-forms' ),
            'icon' => 'download',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'enable_image_button' => array(
                            'desc' => esc_html__( 'Wether or not to use an image button', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['enable_image_button'] ) ? '' : $attributes['enable_image_button'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Use image button instead of text button', 'super-forms' ),
                            )
                        ),
                        'image' => array(
                            'name'=>esc_html__( 'Image Button (leave blank to use text button)', 'super-forms' ),
                            'default'=> ( !isset( $attributes['image']) ? '' : $attributes['image']),
                            'type'=>'image',
                            'filter'=>true,
                            'parent'=>'enable_image_button',
                            'filter_value'=>'true'
                        ),
                        'max_img_width' => array(
                            'name'=>esc_html__( 'Max image width in pixels (0 = no max)', 'super-forms' ),
                            'desc'=>esc_html__( '0 = no max width', 'super-forms' ),
                            'default'=> ( !isset( $attributes['max_img_width']) ? 200 : $attributes['max_img_width']),
                            'type'=>'slider',
                            'min'=>1,
                            'max'=>500,
                            'steps'=>1,
                            'filter'=>true,
                            'parent'=>'enable_image_button',
                            'filter_value'=>'true'
                        ),
                        'max_img_height' => array(
                            'name'=>esc_html__( 'Max image height in pixels (0 = no max)', 'super-forms' ),
                            'desc'=>esc_html__( '0 = no max height', 'super-forms' ),
                            'default'=> ( !isset( $attributes['max_img_height']) ? 300 : $attributes['max_img_height']),
                            'type'=>'slider',
                            'min'=>1,
                            'max'=>500,
                            'steps'=>1,
                            'filter'=>true,
                            'parent'=>'enable_image_button',
                            'filter_value'=>'true'
                        ),
                        'label' => $label,
                        'description'=>$description,
                        'placeholder' => SUPER_Shortcodes::placeholder($attributes,'Upload your documents...'),
                        'tooltip' => $tooltip,
                        'extensions' => $extensions,
                        'filesize' => array(
                            'name'=>'Max file size in MB',
                            'default'=> ( !isset( $attributes['filesize']) ? 5 : $attributes['filesize']),
                            'type'=>'slider',
                            'min'=>1,
                            'max'=>100,
                            'steps'=>1,
                        ),
                        'upload_limit' => array(
                            'name'=>'Total upload limit for all files combined in MB',
                            'desc'=>esc_html__( '0 or blank = no limitations', 'super-forms' ),
                            'default'=> ( !isset( $attributes['upload_limit']) ? 0 : $attributes['upload_limit']),
                            'type'=>'slider',
                            'min'=>1,
                            'max'=>100,
                            'steps'=>1,
                        ),
                        'error' => $error,
                    )
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'grouped' => $grouped,
                        'maxlength' => $maxlength,
                        'minlength' => $minlength,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'phone' => array(
            'name' => esc_html__( 'Phone', 'super-forms' ),
            'icon' => 'phone',
            'predefined' => array(
                array(
                    'tag' => 'text',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'phonenumber', 'super-forms' ),
                        'email' => esc_html__( 'Phonenumber:', 'super-forms' ),
                        'placeholder' => esc_html__( 'Your Phonenumber', 'super-forms' ),
                        'validation' => 'phone',
                        'icon' => 'phone',
                        'type' => 'tel'
                    )
                )
            ),
            'atts' => array(),
        ),
        'website_url' => array(
            'name' => esc_html__( 'Website URL', 'super-forms' ),
            'icon' => 'link',
            'predefined' => array(
                array(
                    'tag' => 'text',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'website', 'super-forms' ),
                        'email' => esc_html__( 'Website:', 'super-forms' ),
                        'placeholder' => esc_html__( 'http://', 'super-forms' ),
                        'validation' => 'website',
                        'icon' => 'link',
                        'type' => 'url'
                    )
                )
            ),
            'atts' => array(),
        ),

        'date_predefined' => array(
            'name' => esc_html__( 'Date', 'super-forms' ),
            'icon' => 'calendar',
            'predefined' => array(
                array(
                    'tag' => 'date',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'date', 'super-forms' ),
                        'email' => esc_html__( 'Date:', 'super-forms' ),
                        'placeholder' => esc_html__( 'Select a date', 'super-forms' ),
                        'icon' => 'calendar',
                        'work_days' => 'true',
                        'weekends' => 'true',
                    )
                )
            ),
            'atts' => array(),
        ),
        'date' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::date',
            'name' => esc_html__( 'Date', 'super-forms' ),
            'icon' => 'calendar',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,
                        'placeholder' => SUPER_Shortcodes::placeholder($attributes, ''),
                        'tooltip' => $tooltip,
                        'range' => array(
                            'name'=>esc_html__( 'Enter a range', 'super-forms' ), 
                            'desc'=>esc_html__( 'Example 100 years in the past and 5 years in the future: -100:+5', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['range']) ? '-100:+5' : $attributes['range']),
                        ),
                        'value' => array(
                            'default'=> ( !isset( $attributes['value'] ) ? '' : $attributes['value'] ),
                            'name' => esc_html__( 'Default value', 'super-forms' ), 
                            'desc' => esc_html__( 'Set a default value for this field (leave blank for none)', 'super-forms' ),
                            'i18n'=>true
                        ),
                        'current_date' => array(
                            'default'=> ( !isset( $attributes['current_date'] ) ? '' : $attributes['current_date'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Return the current date as default value', 'super-forms' ),
                            )
                        ),
                        'work_days' => array(
                            'default'=> ( !isset( $attributes['work_days'] ) ? 'true' : $attributes['work_days'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Allow users to select work days', 'super-forms' ),
                            ),
                            'allow_empty' => true, // For backward compatibility with older forms
                        ),
                        'weekends' => array(
                            'default'=> ( !isset( $attributes['weekends'] ) ? 'true' : $attributes['weekends'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Allow users to select weekends', 'super-forms' ),
                            ),
                            'allow_empty' => true, // For backward compatibility with older forms
                        ),
                        // @since 3.6.0 - excl specific days from calendar
                        'excl_days' => array(
                            'name' => esc_html__( 'Exclude specific days from being selected by user', 'super-forms' ),
                            'label' => sprintf( esc_html__( 'Use numbers to specify days to exclude seperated by comma\'s e.g: 0,1,2%sWhere: 0 = Sunday and 1 = Monday etc.', 'super-forms' ), '<br />' ),
                            'desc' => esc_html__( 'Disable the option to select the specific day in the calendar e.g Sunday, Monday etc.', 'super-forms' ),
                            'default'=> ( !isset( $attributes['excl_days'] ) ? '' : $attributes['excl_days'] ),
                        ),
                        'format' => array(
                            'name'=>esc_html__( 'Date Format', 'super-forms' ), 
                            'desc'=>esc_html__( 'Change the date format', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['format']) ? 'dd-mm-yy' : $attributes['format']),
                            'filter'=>true,
                            'type'=>'select', 
                            'values'=>array(
                                'custom' => esc_html__( 'Custom date format', 'super-forms' ),
                                'dd-mm-yy' => esc_html__( 'European - dd-mm-yy', 'super-forms' ),
                                'mm/dd/yy' => esc_html__( 'Default - mm/dd/yy', 'super-forms' ),
                                'yy-mm-dd' => esc_html__( 'ISO 8601 - yy-mm-dd', 'super-forms' ),
                                'd M, y' => esc_html__( 'Short - d M, y', 'super-forms' ),
                                'd MM, y' => esc_html__( 'Medium - d MM, y', 'super-forms' ),
                                'DD, d MM, yy' => esc_html__( 'Full - DD, d MM, yy', 'super-forms' ),
                            ),
                            'i18n'=>true
                        ),
                        'custom_format' => array(
                            'name'=>'Enter a custom Date Format',
                            'default'=> ( !isset( $attributes['custom_format']) ? 'dd-mm-yy' : $attributes['custom_format']),
                            'filter'=>true,
                            'parent'=>'format',
                            'filter_value'=>'custom',
                            'i18n'=>true
                        ),

                        // @since 3.1.0 - option to change the first day of the week on date picker element
                        'first_day' => array(
                            'name'=>esc_html__( 'First day of week', 'super-forms' ), 
                            'desc'=>esc_html__( 'Change the first day of the week e.g Sunday or Monday', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['first_day']) ? '1' : $attributes['first_day']),
                            'type'=>'select', 
                            'values'=>array(
                                '1' => esc_html__( 'Monday (default)', 'super-forms' ),
                                '2' => esc_html__( 'Tuesday', 'super-forms' ),
                                '3' => esc_html__( 'Wednesday', 'super-forms' ),
                                '4' => esc_html__( 'Thursday', 'super-forms' ),
                                '5' => esc_html__( 'Friday', 'super-forms' ),
                                '6' => esc_html__( 'Saturday', 'super-forms' ),
                                '0' => esc_html__( 'Sunday', 'super-forms' ),
                            ),
                            'i18n'=>true
                        ),

                        'validation' => $validation_empty,
                        'error' => $error,
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'disabled' => $disabled,
                        'autocomplete' => $autocomplete,
                        'grouped' => $grouped,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'minlength' => array(
                            'name'=>esc_html__( 'Date range (minimum)', 'super-forms' ),
                            'desc'=> sprintf( esc_html__( 'Amount in days to add or deduct based on current day%s(leave blank to remove limitations)', 'super-forms' ), '<br />' ),
                            'default'=> ( !isset( $attributes['minlength']) ? '' : $attributes['minlength']),
                        ),
                        'connected_min' => array(
                            'name'=>esc_html__( 'Min. Connect with other datepicker', 'super-forms' ),
                            'desc'=>esc_html__( 'Achieve date range with 2 datepickers', 'super-forms' ),
                            'default'=> ( !isset( $attributes['connected_min']) ? '' : $attributes['connected_min']),
                            'type'=>'select',
                            'values'=>array(
                                '' => esc_html__( '- Not connected -', 'super-forms' ),
                            )
                        ),
                        'connected_min_days' => array(
                            'type' => 'slider', 
                            'default'=> ( !isset( $attributes['connected_min_days']) ? 1 : $attributes['connected_min_days']),
                            'min' => -100, 
                            'max' => 100, 
                            'steps' => 1, 
                            'name' => esc_html__( 'Days to add/deduct based on connected datepicker', 'super-forms' ), 
                        ),
                        'maxlength' => array(
                            'name'=>esc_html__( 'Date range (maximum)', 'super-forms' ),
                            'desc'=> sprintf( esc_html__( 'Amount in days to add or deduct based on current day%s(leave blank to remove limitations)', 'super-forms' ), '<br />' ),
                            'default'=> ( !isset( $attributes['maxlength']) ? '' : $attributes['maxlength']),
                        ),
                        'connected_max' => array(
                            'name'=>esc_html__( 'Max. Connect with other datepicker', 'super-forms' ),
                            'desc'=>esc_html__( 'Achieve date range with 2 datepickers', 'super-forms' ),
                            'default'=> ( !isset( $attributes['connected_max']) ? '' : $attributes['connected_max']),
                            'type'=>'select',
                            'values'=>array(
                                '' => esc_html__( '- Not connected -', 'super-forms' ),
                            )
                        ),
                        'connected_max_days' => array(
                            'type' => 'slider', 
                            'default'=> ( !isset( $attributes['connected_max_days']) ? 1 : $attributes['connected_max_days']),
                            'min' => -100, 
                            'max' => 100, 
                            'steps' => 1, 
                            'name' => esc_html__( 'Days to add/deduct based on connected datepicker', 'super-forms' ), 
                        ),

                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 3.2.0 - custom TAB index
                        'custom_tab_index' => $custom_tab_index,

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'time_predefined' => array(
            'name' => esc_html__( 'Time', 'super-forms' ),
            'icon' => 'clock;far',
            'predefined' => array(
                array(
                    'tag' => 'time',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'time', 'super-forms' ),
                        'email' => esc_html__( 'Time:', 'super-forms' ),
                        'placeholder' => esc_html__( 'Select a time', 'super-forms' ),
                        'icon' => 'clock;far',
                    )
                )
            ),
            'atts' => array(),
        ),
        'time' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::time',
            'name' => esc_html__( 'Time', 'super-forms' ),
            'icon' => 'clock;far',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,
                        'placeholder' => SUPER_Shortcodes::placeholder($attributes, ''),
                        'current_time' => array(
                            'default'=> ( !isset( $attributes['current_time'] ) ? '' : $attributes['current_time'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Return the current time as default value', 'super-forms' ),
                            )
                        ),
                        'tooltip' => $tooltip,
                        'validation' => $validation_empty,
                        'error' => $error,
                    ),
                ),
                'time_format' => array(
                    'name' => esc_html__( 'Time Format', 'super-forms' ),
                    'fields' => array(
                        'format' => array(
                            'name'=>esc_html__( 'Choose a Time format', 'super-forms' ),
                            'desc'=>esc_html__( 'How times should be displayed in the list and input element.', 'super-forms' ),
                            'type'=>'select',
                            'default'=> ( !isset( $attributes['format']) ? 'H:i' : $attributes['format']),
                            'values'=>array(
                                'H:i'=>'16:59 (Hour:Minutes)',
                                'H:i:s'=>'16:59:59 (Hour:Minutes:Seconds)',
                                'h:i A'=>'01:30 AM (Hour:Minutes Ante/Post meridiem)',
                            ),
                            'i18n'=>true
                        ),
                        'step' => SUPER_Shortcodes::slider($attributes, $default=15, $min=1, $max=60, $steps=1, esc_html__( 'Steps between times in minutes', 'super-forms' ), '', $key='step'),
                        'minlength' => array(
                            'name'=>esc_html__( 'The time that should appear first in the dropdown list (Minimum Time)', 'super-forms' ),
                            'desc'=>sprintf( esc_html__( 'Example: 09:00%s(leave blank to disable this feature)', 'super-forms' ), '<br />' ),
                            'default'=> ( !isset( $attributes['minlength']) ? '' : $attributes['minlength']),
                            'type'=>'time',
                        ),
                        'maxlength' => array(
                            'name'=>esc_html__( 'The time that should appear last in the dropdown list (Maximum Time)', 'super-forms' ),
                            'desc'=>sprintf( esc_html__( 'Example: 17:00%s(leave blank to disable this feature)', 'super-forms' ), '<br />' ),
                            'default'=> ( !isset( $attributes['maxlength']) ? '' : $attributes['maxlength']),
                            'type'=>'time',
                        ),
                        'range' => array(
                            'name'=>esc_html__( 'Disable time options by ranges', 'super-forms' ),
                            'desc'=>sprintf( esc_html__( 'Example:%s0:00|9:00%s17:00|0:00%s(enter each range on a new line)', 'super-forms' ), '<br />', '<br />', '<br />' ),
                            'type'=>'textarea',
                            'default'=> ( !isset( $attributes['range']) ? '' : $attributes['range']),
                        ),                            
                        'duration' => array(
                            'name'=>esc_html__( 'Show or hide the duration time', 'super-forms' ),
                            'desc'=>esc_html__( 'The duration time will be calculated based on the time that appears first in it\'s dropdown', 'super-forms' ),
                            'type'=>'select',
                            'default'=> ( !isset( $attributes['duration']) ? 'false' : $attributes['duration']),
                            'values'=>array(
                                'false'=>'Hide duration',
                                'true'=>'Show duration',
                            ),
                        ),
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'disabled' => $disabled,
                        'readonly' => $readonly,
                        'autocomplete' => $autocomplete,
                        'grouped' => $grouped,
                        'width' => SUPER_Shortcodes::width($attributes, $default=0),
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 3.2.0 - custom TAB index
                        'custom_tab_index' => $custom_tab_index,
                                                
                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,
                        
                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'rating_predefined' => array(
            'name' => esc_html__( 'Rating', 'super-forms' ),
            'icon' => 'star;far',
            'predefined' => array(
                array(
                    'tag' => 'rating',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'rating', 'super-forms' ),
                        'email' => esc_html__( 'Rating:', 'super-forms' ),
                        'icon' => 'heart',
                    )
                )
            ),
            'atts' => array(),
        ),
        'rating' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::rating',
            'name' => esc_html__( 'Rating', 'super-forms' ),
            'icon' => 'star;far',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,
                        'value' => array(
                            'name' => esc_html__( 'Default value 1-5 (empty = default)', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['value'] ) ? '' : $attributes['value'] )
                        ),
                        'tooltip' => $tooltip,
                        'validation' => $validation_not_empty,
                        'error' => $error,
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'grouped' => $grouped,
                        'width' => SUPER_Shortcodes::width($attributes, $default=0),
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'skype_predefined' => array(
            'name' => esc_html__( 'Skype', 'super-forms' ),
            'icon' => 'skype;fab',
            'predefined' => array(
                array(
                    'tag' => 'skype',
                    'group' => 'form_elements',
                    'data' => array(
                        'method' => 'call'
                    )
                )
            ),
            'atts' => array(),
        ),
        'skype' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::skype',
            'name' => esc_html__( 'Skype', 'super-forms' ),
            'icon' => 'skype',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'username' => array(
                            'name'=>esc_html__( 'Enter your Skype Name', 'super-forms' ),
                            'desc'=> esc_html__( 'This is should be your Skyp username.', 'super-forms' ),
                            'default'=> ( !isset( $attributes['username']) ? '' : $attributes['username']),
                        ),
                        'method' => array(
                            'name'=>'Choose what you\'d like your button to do',
                            'default'=> ( !isset( $attributes['method']) ? 'call' : $attributes['method']),
                            'type'=>'select', 
                            'values'=>array(
                                'call' => 'Call (starts a call with just a click)', 
                                'chat' => 'Chat (starts a conversation with an instant message)', 
                                'dropdown' => 'Dropdown (allow user to choose between call/chat)', 
                            ),
                        ),
                        'color' => array(
                            'name'=>'Choose your button color',
                            'default'=> ( !isset( $attributes['color']) ? 'blue' : $attributes['color']),
                            'type'=>'select', 
                            'values'=>array(
                                'blue' => 'Blue', 
                                'white' => 'White', 
                            ),
                        ),

                        'size' => array(
                            'name'=>'Choose your button size',
                            'default'=> ( !isset( $attributes['size']) ? 16 : $attributes['size']),
                            'type'=>'select', 
                            'values'=>array(
                                10 => '10px', 
                                12 => '12px', 
                                14 => '14px', 
                                16 => '16px', 
                                24 => '24px', 
                                32 => '32px', 
                            ),
                        ),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'countries_predefined' => array(
            'name' => esc_html__( 'Countries', 'super-forms' ),
            'icon' => 'globe',
            'predefined' => array(
                array(
                    'tag' => 'countries',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'country', 'super-forms' ),
                        'email' => esc_html__( 'Country:', 'super-forms' ),
                        'placeholder' => esc_html__( '- select your country -', 'super-forms' ),
                        'icon' => 'globe'
                    )
                )
            ),
            'atts' => array(),
        ),
        'countries' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::countries',
            'name' => esc_html__( 'Countries', 'super-forms' ),
            'icon' => 'globe',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name( $attributes, '' ),
                        'email' => SUPER_Shortcodes::email( $attributes, '' ),
                        'label' => $label,
                        'description'=>$description,
                        'placeholder' => SUPER_Shortcodes::placeholder( $attributes, '' ),
                        'tooltip' => $tooltip,
                        'validation' => $special_validations,
                        'custom_regex' => $custom_regex,
                        'conditional_validation' => $conditional_validation,
                        'conditional_validation_value' => $conditional_validation_value,
                        'conditional_validation_value2' => $conditional_validation_value2, // @since 3.6.0
                        'may_be_empty' => $may_be_empty,
                        'error' => $error,
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'grouped' => $grouped,
                        'maxlength' => $maxlength,
                        'minlength' => $minlength,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,
                        
                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'password_predefined' => array(
            'name' => esc_html__( 'Password field', 'super-forms' ),
            'icon' => 'lock',
            'predefined' => array(
                array(
                    'tag' => 'password',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'password', 'super-forms' ),
                        'email' => esc_html__( 'Password:', 'super-forms' ),
                        'placeholder' => esc_html__( 'Enter a strong password', 'super-forms' ),
                        'icon' => 'lock'
                    )
                )
            ),
            'atts' => array(),
        ),
        'password' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::password',
            'name' => esc_html__( 'Password field', 'super-forms' ),
            'icon' => 'lock',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name($attributes, ''),
                        'email' => SUPER_Shortcodes::email($attributes, ''),
                        'label' => $label,
                        'description'=>$description,
                        'placeholder' => SUPER_Shortcodes::placeholder($attributes,''),
                        'tooltip' => $tooltip,
                        'validation' => $special_validations,
                        'custom_regex' => $custom_regex,
                        'conditional_validation' => $conditional_validation,
                        'conditional_validation_value' => $conditional_validation_value,
                        'conditional_validation_value2' => $conditional_validation_value2, // @since 3.6.0
                        'may_be_empty' => $may_be_empty,
                        'error' => $error,
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'disabled' => $disabled,
                        'readonly' => $readonly,
                        'autocomplete' => $autocomplete,
                        'grouped' => $grouped,
                        'maxlength' => $maxlength,
                        'minlength' => $minlength,
                        'width' => $width,
                        'wrapper_width' => $wrapper_width,
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                        'error_position' => $error_position,

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,            

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'icon_position' => $icon_position,
                        'icon_align' => $icon_align,
                        'icon' => SUPER_Shortcodes::icon($attributes,''),
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'hidden_predefined' => array(
            'name' => esc_html__( 'Hidden field', 'super-forms' ),
            'icon' => 'eye-slash',
            'predefined' => array(
                array(
                    'tag' => 'hidden',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'hidden', 'super-forms' ),
                        'email' => esc_html__( 'Hidden:', 'super-forms' )
                    )
                )
            ),
            'atts' => array(),
        ),
        'hidden' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::hidden',
            'name' => esc_html__( 'Hidden field', 'super-forms' ),
            'icon' => 'eye-slash',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'name' => SUPER_Shortcodes::name( $attributes, '' ),
                        'email' => SUPER_Shortcodes::email( $attributes, '' ),
                        'value' => array(
                            'default' => '',
                            'name' => esc_html__( 'Hidden value', 'super-forms' ),
                            'desc' => esc_html__( 'The value for your hidden field.', 'super-forms' ),
                        ),
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'exclude' => $exclude,
                        'exclude_entry' => $exclude_entry, // @since 3.3.0 - exclude data from being saved into contact entry
                    ),
                ),
                'random_code' => array(
                    'name' => esc_html__( 'Unique code generation', 'super-forms' ),
                    'fields' => array(
                        'enable_random_code' => array(
                            'default'=> ( !isset( $attributes['enable_random_code'] ) ? '' : $attributes['enable_random_code'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Enable code generation', 'super-forms' ),
                            )
                        ),
                        'code_length' => array(
                            'type' => 'slider', 
                            'default'=> ( !isset( $attributes['code_length']) ? 7 : $attributes['code_length']),
                            'min' => 5, 
                            'max' => 15, 
                            'steps' => 1, 
                            'name' => esc_html__( 'Code length', 'super-forms' ), 
                            'filter'=>true,
                            'parent'=>'enable_random_code',
                            'filter_value'=>'true'                            
                        ),
                        'code_characters' => array(
                            'name'=>esc_html__( 'Characters the code should contain', 'super-forms' ),
                            'default'=> ( !isset( $attributes['code_characters']) ? '1' : $attributes['code_characters']),
                            'type'=>'select',
                            'values'=>array(
                                '1'=>esc_html__( 'Numbers and Letters (default)', 'super-forms' ),
                                '2'=>esc_html__( 'Numbers, letters and symbols', 'super-forms' ),
                                '3'=>esc_html__( 'Numbers only', 'super-forms' ),
                                '4'=>esc_html__( 'Letters only', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'enable_random_code',
                            'filter_value'=>'true'    
                        ),
                        'code_uppercase' => array(
                            'default'=> ( !isset( $attributes['code_uppercase'] ) ? 'true' : $attributes['code_uppercase'] ),
                            'type' => 'checkbox', 
                            'values' => array(
                                'true' => esc_html__( 'Allow uppercase letters', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'code_characters',
                            'filter_value'=>'1,2,4' 
                        ),
                        'code_lowercase' => array(
                            'default'=> ( !isset( $attributes['code_lowercase'] ) ? '' : $attributes['code_lowercase'] ),
                            'type' => 'checkbox', 
                            'values' => array(
                                'true' => esc_html__( 'Allow lowercase letters', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'code_characters',
                            'filter_value'=>'1,2,4' 
                        ),
                        'code_prefix' => array(
                            'name'=>esc_html__( 'Code prefix', 'super-forms' ),
                            'default'=> ( !isset( $attributes['code_prefix']) ? '' : $attributes['code_prefix']),
                            'filter'=>true,
                            'parent'=>'enable_random_code',
                            'filter_value'=>'true'    
                        ),

                        // @since 2.8.0 - invoice numbers
                        'code_invoice' => array(
                            'default'=> ( !isset( $attributes['code_invoice'] ) ? '' : $attributes['code_invoice'] ),
                            'type' => 'checkbox', 
                            'values' => array(
                                'true' => esc_html__( 'Enable invoice numbers increament e.g: 0001', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'enable_random_code',
                            'filter_value'=>'true'
                        ),
                        'code_invoice_padding' => array(
                            'name'=>esc_html__( 'Invoice number padding (leading zero\'s)', 'super-forms' ),
                            'label' => esc_html__( 'Enter "4" to display 16 as 0016', 'super-forms' ),
                            'default'=> ( !isset( $attributes['code_invoice_padding']) ? '4' : $attributes['code_invoice_padding']),
                            'filter'=>true,
                            'parent'=>'code_invoice',
                            'filter_value'=>'true'                        
                        ),

                        'code_suffix' => array(
                            'name'=>esc_html__( 'Code suffix', 'super-forms' ),
                            'default'=> ( !isset( $attributes['code_suffix']) ? '' : $attributes['code_suffix']),
                            'filter'=>true,
                            'parent'=>'enable_random_code',
                            'filter_value'=>'true'                        
                        ),


                    )
                ),
                'conditional_variable' => $conditional_variable_array
            ),
        ),

        'recaptcha_predefined' => array(
            'name' => esc_html__( 'reCAPTCHA', 'super-forms' ),
            'icon' => 'shield-alt',
            'predefined' => array(
                array(
                    'tag' => 'recaptcha',
                    'group' => 'form_elements',
                    'data' => array()
                )
            ),
            'atts' => array(),
        ),
        'recaptcha' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::recaptcha',
            'name' => esc_html__( 'reCAPTCHA', 'super-forms' ),
            'icon' => 'shield-alt',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'version' => array(
                            'name'=>esc_html__( 'Choose a reCAPTCHA version', 'super-forms' ),
                            'default'=> ( !isset( $attributes['version']) ? '2' : $attributes['version']),
                            'type'=>'select', 
                            'values'=>array(
                                'v2' => 'reCAPTCHA v2 (default)',
                                'v3' => 'reCAPTCHA v3'
                            ),
                            'filter'=>true
                        ),
                        'tooltip' => array(
                            'default'=> (!isset($attributes['tooltip']) ? '' : $attributes['tooltip']),
                            'name'=>esc_html__( 'Tooltip text', 'super-forms' ), 
                            'desc'=>esc_html__( 'The tooltip will appear as soon as the user hovers over the field with their mouse.', 'super-forms' ),
                            'filter'=>true,
                            'parent'=>'version',
                            'filter_value'=>'v2'
                        ),  
                        'align' => array(
                            'name'=>esc_html__( 'Alignment', 'super-forms' ),
                            'default'=> ( !isset( $attributes['align']) ? 'right' : $attributes['align']),
                            'type'=>'select', 
                            'values'=>array(
                                'left' => esc_html__( 'Align Left', 'super-forms' ),
                                'center' => esc_html__( 'Align Center', 'super-forms' ),
                                'right' => esc_html__( 'Align Right', 'super-forms' ),
                            ),
                            'filter'=>true,
                            'parent'=>'version',
                            'filter_value'=>'v2'
                        )
                    ),
                ),
                'conditional_logic' => $conditional_logic_array
            ),
        ),

        'button_predefined' => array(
            'name' => esc_html__( 'Button', 'super-forms' ),
            'icon' => 'hand-pointer;far',
            'predefined' => array(
                array(
                    'tag' => 'button',
                    'group' => 'form_elements',
                    'data' => array(
                        'name' => esc_html__( 'Submit', 'super-forms' ),
                        'loading' => esc_html__( 'Loading...', 'super-forms' ),
                    )
                )
            ),
            'atts' => array(),
        ),
        'button' => array(
            'hidden' => true,
            'callback' => 'SUPER_Shortcodes::button',
            'name' => 'Button',
            'icon' => 'hand-pointer;far',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        // @since 2.0.0
                        'action' => array(
                            'name'=>esc_html__( 'Button action / method', 'super-forms' ),
                            'desc'=>esc_html__( 'What should this button do?', 'super-forms' ),
                            'default'=> ( !isset( $attributes['action']) ? 'submit' : $attributes['action']),
                            'type'=>'select',
                            'values'=>array(
                                'submit'=>esc_html__( 'Submit the form (default)', 'super-forms' ),
                                'clear'=>esc_html__( 'Clear / Reset the form', 'super-forms' ),
                                'print'=>esc_html__( 'Print form data', 'super-forms' ),
                                'url'=>esc_html__( 'Redirect to link or URL', 'super-forms' ),
                            ),
                            'filter'=>true,
                        ),
                        'name' => array(
                            'name'=>esc_html__( 'Button name', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['name'] ) ? '' : $attributes['name'] ),
                            'i18n'=>true
                        ),

                        // @since 3.9.0 - option to print with custom HTML/CSS
                        'print_custom' => array(
                            'desc' => esc_html__( 'Wether or not to use the auto suggest feature', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['print_custom'] ) ? '' : $attributes['print_custom'] ),
                            'type' => 'checkbox', 
                            'filter'=>true,
                            'values' => array(
                                'true' => esc_html__( 'Use custom HTML and CSS when printing', 'super-forms' ),
                            ),
                            'parent'=>'action',
                            'filter_value'=>'print',
                            'filter'=>true,
                            'i18n'=>true
                        ),
                        'print_file' => array(
                            'name'=>esc_html__( 'Custom HTML (upload/browse for .html file)', 'super-forms' ), 
                            'label'=>esc_html__( '{tags} can be used to retrieve values dynamically', 'super-forms' ), 
                            'default'=> ( !isset( $attributes['print_file'] ) ? '' : $attributes['print_file'] ),
                            'type'=>'file',
                            'parent'=>'print_custom',
                            'filter_value'=>'true',
                            'filter'=>true,
                            'i18n'=>true
                        ),
                     

                        // @since 3.4.0 - contact entry statuses
                        'entry_status' => array(
                            'name'=>esc_html__( 'Contact entry status after submitting', 'super-forms' ),
                            'desc'=>esc_html__( 'What status should the contact entry get after submitting the form?', 'super-forms' ),
                            'default'=> ( !isset( $attributes['entry_status']) ? '' : $attributes['entry_status']),
                            'type'=>'select',
                            'values'=> $statuses,
                            'parent'=>'action',
                            'filter_value'=>'submit',
                            'filter'=>true,
                        ),
                        'entry_status_update' => array(
                            'name'=>esc_html__( 'Contact entry status after updating a contact entry', 'super-forms' ),
                            'desc'=>esc_html__( 'This will only be usefull if the form updates a previous created entry', 'super-forms' ),
                            'default'=> ( !isset( $attributes['entry_status_update']) ? '' : $attributes['entry_status_update']),
                            'type'=>'select',
                            'values'=> $statuses,
                            'parent'=>'action',
                            'filter_value'=>'submit',
                            'filter'=>true,
                        ),
                        // @since 2.0.0
                        'loading' => array(
                            'name' => esc_html__('Button loading name', 'super-forms' ),
                            'default'=> ( !isset( $attributes['loading'] ) ? '' : $attributes['loading'] ),
                            'parent'=>'action',
                            'filter_value'=>'submit',
                            'filter'=>true,
                            'i18n'=>true
                        ),
                        'link' => array(
                            'name'=>esc_html__( 'Button URL', 'super-forms' ),
                            'desc'=>esc_html__( 'Where should your image link to?', 'super-forms' ),
                            'default'=> ( !isset( $attributes['link']) ? '' : $attributes['link']),
                            'type'=>'select',
                            'values'=>array(
                                ''=>esc_html__( 'None', 'super-forms' ),
                                'custom'=>esc_html__( 'Custom URL', 'super-forms' ),
                                'post'=>esc_html__( 'Post', 'super-forms' ),
                                'page'=>esc_html__( 'Page', 'super-forms' ),
                            ),
                            'parent'=>'action',
                            'filter_value'=>'url',
                            'filter'=>true,
                        ),
                        'custom_link' => array(
                            'name'=>esc_html__( 'Enter a custom URL to link to', 'super-forms' ),
                            'default'=> ( !isset( $attributes['custom_link']) ? '' : $attributes['custom_link']),
                            'parent'=>'link',
                            'filter_value'=>'custom',
                            'filter'=>true,
                        ),
                        'post' => array(
                            'name'=>esc_html__( 'Select a post to link to', 'super-forms' ),
                            'default'=> ( !isset( $attributes['post']) ? '' : $attributes['post']),
                            'type'=>'select',
                            'values'=>SUPER_Common::list_posts_by_type_array('post'),
                            'parent'=>'link',
                            'filter_value'=>'post',
                            'filter'=>true,  
                        ),
                        'page' => array(
                            'name'=>esc_html__( 'Select a page to link to', 'super-forms' ),
                            'default'=> ( !isset( $attributes['page']) ? '' : $attributes['page']),
                            'type'=>'select',
                            'values'=>SUPER_Common::list_posts_by_type_array('page'),
                            'parent'=>'link',
                            'filter_value'=>'page',
                            'filter'=>true,
                        ),
                        'target' => array(
                            'name'=>esc_html__( 'Open new tab/window', 'super-forms' ),
                            'default'=> ( !isset( $attributes['target']) ? '' : $attributes['target']),
                            'type'=>'select',
                            'values'=>array(
                                ''=>esc_html__( 'Open in same window', 'super-forms' ),
                                '_blank'=>esc_html__( 'Open in new window', 'super-forms' ),
                            ),
                            'parent'=>'link',
                            'filter_value'=>'custom,post,page',
                            'filter'=>true,
                        ),
                    ),
                ),
                'colors' => array(
                    'name' => esc_html__( 'Colors', 'super-forms' ),
                    'fields' => array(
                        'custom_colors' => array(
                            'name'=>esc_html__( 'Enable custom settings', 'super-forms' ),
                            'desc'=>esc_html__( 'Use custom button settings or the default form button settings?', 'super-forms' ),
                            'default'=> ( !isset( $attributes['custom_colors']) ? '' : $attributes['custom_colors']),
                            'type'=>'select',
                            'values'=>array(
                                ''=>esc_html__( 'Disabled (use default form settings)', 'super-forms' ),
                                'custom'=>esc_html__( 'Enabled (use custom button settings)', 'super-forms' ),
                            ),
                            'filter'=>true,
                        ),
                        'colors' => array(
                            'name' => esc_html__('Button Colors', 'super-forms' ),
                            'type'=>'multicolor', 
                            'colors'=>array(
                                'color'=>array(
                                    'label'=>'Button background color',
                                    'default'=> ( !isset( $attributes['color']) ? '#f26c68' : $attributes['color']),
                                ),
                                'color_hover'=>array(
                                    'label'=>'Button background color hover',
                                    'default'=> ( !isset( $attributes['color_hover']) ? '#444444' : $attributes['color_hover']),
                                ),
                                'font'=>array(
                                    'label'=>'Button font color',
                                    'default'=> ( !isset( $attributes['font']) ? '#ffffff' : $attributes['font']),
                                ),
                                'font_hover'=>array(
                                    'label'=>'Button font color hover',
                                    'default'=> ( !isset( $attributes['font_hover']) ? '#ffffff' : $attributes['font_hover']),
                                ),                            
                            ),
                            'parent'=>'custom_colors',
                            'filter_value'=>'custom',
                            'filter'=>true,
                        ),
                    ),
                ),
                'advanced' => array(
                    'name' => esc_html__( 'Advanced', 'super-forms' ),
                    'fields' => array(
                        'custom_advanced' => array(
                            'name'=>esc_html__( 'Enable custom settings', 'super-forms' ),
                            'desc'=>esc_html__( 'Use custom button settings or the default form button settings?', 'super-forms' ),
                            'default'=> ( !isset( $attributes['custom_advanced']) ? '' : $attributes['custom_advanced']),
                            'type'=>'select',
                            'values'=>array(
                                ''=>esc_html__( 'Disabled (use default form settings)', 'super-forms' ),
                                'custom'=>esc_html__( 'Enabled (use custom button settings)', 'super-forms' ),
                            ),
                            'filter'=>true,
                        ),
                        'radius' => array(
                            'name'=> esc_html__('Button radius', 'super-forms' ),
                            'default'=> ( !isset( $attributes['radius']) ? 'square' : $attributes['radius']),
                            'type'=>'select',
                            'values'=>array(
                                'rounded'=>'Rounded',
                                'square'=>'Square',
                                'full-rounded'=>'Full Rounded',
                            ),
                            'parent'=>'custom_advanced',
                            'filter_value'=>'custom',
                            'filter'=>true,

                        ),
                        'type' => array(
                            'name'=> esc_html__('Button type', 'super-forms' ),
                            'default'=> ( !isset( $attributes['type']) ? 'flat' : $attributes['type']),
                            'type'=>'select',
                            'values'=>array(
                                '3d'=>'3D Button',
                                '2d'=>'2D Button',
                                'flat'=>'Flat Button',
                                'outline'=>'Outline Button',
                                'diagonal'=>'Diagonal Button',
                            ),
                            'parent'=>'custom_advanced',
                            'filter_value'=>'custom',
                            'filter'=>true,
                        ),
                        'size' => array(
                            'name'=> esc_html__('Button size', 'super-forms' ),
                            'default'=> ( !isset( $attributes['size']) ? 'medium' : $attributes['size']),
                            'type'=>'select', 
                            'values'=>array(
                                'mini' => 'Mini', 
                                'tiny' => 'Tiny', 
                                'small' => 'Small', 
                                'medium' => 'Medium', 
                                'large' => 'Large', 
                                'big' => 'Big', 
                                'huge' => 'Huge', 
                                'massive' => 'Massive', 
                            ),
                            'parent'=>'custom_advanced',
                            'filter_value'=>'custom',
                            'filter'=>true,
                        ),
                        'align' => array(
                            'name'=> esc_html__('Button position', 'super-forms' ),
                            'default'=> ( !isset( $attributes['align']) ? 'left' : $attributes['align']),
                            'type'=>'select', 
                            'values'=>array(
                                'left' => 'Align Left', 
                                'center' => 'Align Center', 
                                'right' => 'Align Right', 
                            ),
                            'parent'=>'custom_advanced',
                            'filter_value'=>'custom',
                            'filter'=>true,
                        ), 
                        'width' => array(
                            'name'=> esc_html__('Button width', 'super-forms' ),
                            'default'=> ( !isset( $attributes['width']) ? 'auto' : $attributes['width']),
                            'type'=>'select', 
                            'values'=>array(
                                'auto' => 'Auto', 
                                'fullwidth' => 'Fullwidth', 
                            ),
                            'parent'=>'custom_advanced',
                            'filter_value'=>'custom',
                            'filter'=>true,
                        ),

                        // @since 1.9
                        'class' => $class,
                        'wrapper_class' => $wrapper_class,

                    ),
                ),
                'icon' => array(
                    'name' => esc_html__( 'Icon', 'super-forms' ),
                    'fields' => array(
                        'custom_icon' => array(
                            'name'=>esc_html__( 'Enable custom settings', 'super-forms' ),
                            'desc'=>esc_html__( 'Use custom button settings or the default form button settings?', 'super-forms' ),
                            'default'=> ( !isset( $attributes['custom_icon']) ? '' : $attributes['custom_icon']),
                            'type'=>'select',
                            'values'=>array(
                                ''=>esc_html__( 'Disabled (use default form settings)', 'super-forms' ),
                                'custom'=>esc_html__( 'Enabled (use custom button settings)', 'super-forms' ),
                            ),
                            'filter'=>true,
                        ),
                        'icon_option' => array(
                            'name'=> esc_html__('Button icon position', 'super-forms' ),
                            'default'=> ( !isset( $attributes['icon_option']) ? 'none' : $attributes['icon_option']),
                            'type'=>'select', 
                            'values'=>array(
                                'none' => 'No icon', 
                                'left' => 'Left icon', 
                                'right' => 'Right icon', 
                            ),
                            'filter'=>true,
                            'parent'=>'custom_icon',
                            'filter_value'=>'custom',
                        ),
                        'icon_visibility' => array(
                            'name'=> esc_html__('Button icon visibility', 'super-forms' ),
                            'default'=> ( !isset( $attributes['icon_visibility']) ? 'visible' : $attributes['icon_visibility']),
                            'parent'=>'icon_option',
                            'filter_value'=>'left,right',
                            'type'=>'select', 
                            'values'=>array(
                                'visible' => 'Always Visible', 
                                'hidden' => 'Visible on hover (mouseover)', 
                            ),
                            'filter'=>true,
                        ),
                        'icon_animation' => array(
                            'name'=> esc_html__('Button icon animation', 'super-forms' ),
                            'default'=> ( !isset( $attributes['icon_animation']) ? 'horizontal' : $attributes['icon_animation']),
                            'parent'=>'icon_visibility',
                            'filter_value'=>'hidden',
                            'type'=>'select', 
                            'values'=>array(
                                'horizontal' => 'Horizontal animation', 
                                'vertical' => 'Vertical animation', 
                            ),
                            'filter'=>true,
                        ),                                
                        'icon' => array(
                            'name'=> esc_html__('Button icon', 'super-forms' ),
                            'default'=> ( !isset( $attributes['icon']) ? '' : $attributes['icon']),
                            'type'=>'icon',
                            'parent'=>'icon_option',
                            'filter_value'=>'left,right',
                            'filter'=>true,
                        ),
                    ),
                ),
            ),
        ),

        'conditional_item' => array(
            'hidden' => true,
            'name' => '',
            'icon' => 'section-width',
            'atts' => array(
                'general' => array(
                    'name' => esc_html__( 'General', 'super-forms' ),
                    'fields' => array(
                        'label' => array(
                            'name'=>esc_html__( 'Label', 'super-forms' ),
                            'default'=> ( !isset( $attributes['label']) ? esc_html__( 'Label', 'super-forms' ) : $attributes['label']),
                        ),
                        'value' => array(
                            'name'=>esc_html__( 'Value', 'super-forms' ),
                            'default'=> ( !isset( $attributes['value']) ? esc_html__( 'Value', 'super-forms' ) : $attributes['value']),
                        ),
                    )
                ),
            ),
        ),

    )
);