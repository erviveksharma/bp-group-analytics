<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * @author Vivek Sharma
 * @since  1.0
 * @version 1.0
 */
if (class_exists('BP_Group_Extension')) : // Recommended, to prevent problems during upgrade or when Groups are disabled

    class BP_Group_Analytics_Plugin_Extension extends BP_Group_Extension {

        function __construct() {
            global $bp;
            $this->name =  __('Analytics', 'bp-group-analytics');
            $this->slug = BP_GROUP_ANALYTICS_SLUG;

            /* For internal identification */
            $this->id = 'group_analytics';
            //$this->format_notification_function = 'bp_group_analytics_format_notifications';

            if ($bp->groups->current_group) {
                $this->nav_item_name = $this->name;
                $this->nav_item_position = 61;
            }

            $this->admin_name =  __('Analytics', 'bp-group-analytics');
            $this->admin_slug = BP_GROUP_ANALYTICS_SLUG;
        }

        function create_screen() { }

        function create_screen_save() { }

        function edit_screen() { }

        function edit_screen_save() {   }

        /**
         * @version 1.0
         * @since version 1.0
         * @author Vivek Sharma
         */
        function display() {
            //do_action('bp_group_analytics_display');
            //add_action('bp_template_content_header', 'bp_group_analytics_display_header');
            //add_action('bp_template_title', 'bp_group_analytics_display_title');
            $this->bp_group_analytics_display();
        }

        function bp_group_analytics_display(){
            $members_data = $this->_bp_group_analytics_generate_member_data(array(392,502));
            if(!empty($members_data)){
                echo "<h3>Role</h3>";
                foreach($members_data['392'] as $key => $data){
                    echo $key.'( '.$data.' )'."<br/>";
                }

                echo "<h3>Country</h3>";
                foreach($members_data['502'] as $key => $data){
                    echo $key.'( '.$data.' )'."<br/>";
                }
            }
        }

        function _bp_group_analytics_generate_member_data($fields = array()){
            global $bp;
            $results = array();
            if(empty($fields)) return false;
            $group_id = $bp->groups->current_group->id;
            $has_members_str = "group_id=" . $group_id;
            if ( bp_group_has_members( $has_members_str ) ) {
                while ( bp_group_members() ) : bp_group_the_member();
                foreach ($fields as $field) {
                    $field_data = xprofile_get_field_data( $field , bp_get_group_member_id());
                    $results[$field] = $this->_update_item_key($results[$field],$field_data);
                }
                endwhile;
            }
            return $results;
        }

        function _update_item_key($array = array(), $key){
            if(!empty($array)){

                if (in_array($key, array_keys($array))) {
                    $array[$key] = $array[$key]+1;
                } else {
                    $array[$key] = 1;
                }
            } else {
                $array[$key] = 1;
            }
            return $array;
        }

    }
/**
 * @author Vivek Sharma
 * @since 0.5
 * @version 1.3, 25/10/2013 Makes sure the get_home_path function is defined before trying to use it
 * v1.2.2 remove admin-uploads.php file
 * v1, 5/3/2013
 */
function bp_group_analytics_include_files() {
    //to be done later
}

bp_register_group_extension('BP_Group_Analytics_Plugin_Extension');
endif; // class_exists( 'BP_Group_Extension' )
?>
