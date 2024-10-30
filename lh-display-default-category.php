<?php
/**
 * Plugin Name: LH Display Default Category
 * Plugin URI: https://lhero.org/portfolio/lh-display-default-category/
 * Description: Displays info about the default category via a shortcode
 * Author: Peter Shaw
 * Version: 1.01
 * Author URI: https://shawfactor.com/
*/

if (!class_exists('LH_Display_default_category_plugin')) {


class LH_Display_default_category_plugin {
    
    private static $instance;
    
    public function shortcode_output($atts = null,$content = null)  {
        
        $atts = extract(
            shortcode_atts(
                array (
                    'taxonomy' => 'category',
                    'key' => 'name',
                ),
                $atts
            )
        );
        
        

        
        $default_option = get_option('default_'.$taxonomy);
        
        $term_obj = get_term( $default_option, $taxonomy);
        
        if (!is_wp_error($term_obj) && isset($term_obj->$key)){
        
            return $term_obj->$key;
        
        } else {
            
          return 'There is no default in this taxonomy';  
            
        }
        
        
    }
    
    
    public function register_shortcodes(){
        
        add_shortcode('lh_display_default_category', array($this,'shortcode_output'));

    }
    
    /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
     
    public static function get_instance(){
        
        if (null === self::$instance) {
            
            self::$instance = new self();
            
        }
 
        return self::$instance;
        
    }
    
    
        public function __construct() {
            
            add_action('init', array($this,'register_shortcodes'));
            
        }
    
    
    
}

$lh_display_default_category_instance = LH_Display_default_category_plugin::get_instance();


}
 
?>