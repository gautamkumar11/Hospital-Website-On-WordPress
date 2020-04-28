<?php
/**
 * Medical Theme - Theme Options Config File
 * This file is based on Redux Framework
 * For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Medical_Theme_Redux_Framework_Config')) {

    class Medical_Theme_Redux_Framework_Config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            if( function_exists('dynamic_section') ){
                add_filter('redux/options/' . $this->args['opt_name'] . '/sections', 'dynamic_section');
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }



        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments( $args ) {
            $args['dev_mode'] = false;
            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'framework'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e( 'Current theme preview', 'framework' ); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'framework' ); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'framework'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'framework'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'framework') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'framework' ) . '</p>', __('http://codex.wordpress.org/Child_Themes', 'framework'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS

	        /*----------------------------------------------------------------------*/
	        /* Design Variation Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Design Variation', 'framework'),
		        'desc' => __('This section contains options related to website design variation.', 'framework'),
		        'fields' => array(
			        array(
				        'id'        => 'inspiry_design_variation',
				        'type'      => 'image_select',
				        'title'     => __('Select design variation', 'framework'),
				        'default'   => 'default',
				        'options'   => array(
					        'default' => array('title' => __('Default', 'framework'), 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/design-variation-1.png'),
					        'reborn' => array('title' => __('Reborn', 'framework'), 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/design-variation-2.png'),
				        ),
			        ),
		        )
	        );


            /*----------------------------------------------------------------------*/
            /* Header Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Header', 'framework'),
                'desc' => __('This section contains options related to website header.', 'framework'),
                'fields' => array(
	                array(
		                'id' => 'sticky_header',
		                'type' => 'switch',
		                'title' => __('Sticky Header?', 'framework'),
		                'subtitle' => __('Enable or Disable Sticky Header', 'framework'),
		                'default' => '0',
		                'on' => __('Enabled','framework'),
		                'off' => __('Disabled','framework'),
		                'required'  => array('inspiry_design_variation', '=', 'default')
	                ),
	                array(
		                'id'            => 'main_nav_top_margin',
		                'type'          => 'spacing',
		                'output'        => array('nav.main-menu'), // An array of CSS selectors to apply this font style to
		                'mode'          => 'margin',    // absolute, padding, margin, defaults to padding
		                'all'           => true,        // Have one field that applies to all
		                //'top'           => false,     // Disable the top
		                'right'         => false,     // Disable the right
		                'bottom'        => false,     // Disable the bottom
		                'left'          => false,     // Disable the left
		                'units'         => 'px',      // You can specify a unit value. Possible: px, em, %
		                //'units_extended'=> 'true',    // Allow users to select any type of unit
		                //'display_units' => 'true',   // Set to false to hide the units if the units are specified
		                'title'         => __('Top Margin for Main Menu', 'framework'),
		                'desc'      => __('You can provide the top margin in pixels for main menu, To make it look well in the middle of your uploaded logo.', 'framework'),
		                'default'       => array(
			                'margin-top'    => '0'
		                ),
		                'required'  => array('inspiry_design_variation', '=', 'default')
	                ),
                    array(
                        'id'        => 'display_top_header',
                        'type'      => 'switch',
                        'title'     => __('Header Top Bar', 'framework'),
                        'subtitle'     => __('Do you want to display header top bar ?', 'framework'),
                        'default'   => 1,
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework')
                    ),
	                array(
		                'id' => 'top_header_text',
		                'type' => 'text',
		                'title' => __('Header Top Text', 'framework'),
		                'subtitle' => __('Provide the text to display in header top bar', 'framework'),
                        'required' => array( array( 'display_top_header', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
	                ),
	                array(
		                'id' => 'header_opening_hours_label',
		                'type' => 'text',
		                'title' => __('Opening Hours Label', 'framework'),
						'default' => 'Opening Hours',
		                'subtitle' => __('Provide opening hours label to display in header top bar', 'framework'),
		                'required'  => array('display_top_header', '=', '1')
	                ),
                    array(
                        'id' => 'header_opening_hours',
                        'type' => 'text',
                        'title' => __('Opening Hours', 'framework'),
                        'desc' => __('Example: Monday to Friday - 9am to 5pm', 'framework'),
                        'subtitle' => __('Provide opening hours information to display in header top bar', 'framework'),
                        'required'  => array('display_top_header', '=', '1')
                    ),
	                array(
		                'id'        => 'display_top_header_social_links',
		                'type'      => 'switch',
		                'title'     => __('Social Icons', 'framework'),
		                'subtitle'     => __('Do you want to display social icons in header top bar?', 'framework'),
		                'default'   => 1,
		                'on'        => __('Display','framework'),
		                'off'       => __('Hide','framework'),
		                'required' => array( array( 'display_top_header', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'        => 'display_top_header_search',
		                'type'      => 'switch',
		                'title'     => __('Search Box', 'framework'),
		                'subtitle'     => __('Do you want to display search box in header top bar?', 'framework'),
		                'default'   => 1,
		                'on'        => __('Display','framework'),
		                'off'       => __('Hide','framework'),
		                'required' => array( array( 'display_top_header', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id' => 'header_contact_address',
		                'type' => 'text',
		                'title' => __('Contact Address', 'framework'),
		                'subtitle' => __('Provide your contact address to display in header', 'framework'),
		                'required' => array('inspiry_design_variation', '=', 'reborn')
	                ),
	                array(
		                'id' => 'header_contact_number_label',
		                'type' => 'text',
		                'title' => __('Contact Number Label', 'framework'),
		                'default' => 'Contact',
		                'subtitle' => __('Provide label to display above contact number.', 'framework'),
	                ),
                    array(
                        'id' => 'header_contact_number',
                        'type' => 'text',
                        'title' => __('Contact Number', 'framework'),
                        'subtitle' => __('Provide your contact number to display in header', 'framework'),
                    ),
	                array(
		                'id'        => 'display_wpml_flags',
		                'type'      => 'switch',
		                'title'     => __('WPML Language Switcher Flags', 'framework'),
		                'subtitle'     => __('Do you want to display WPML language switcher flags in header top bar ?', 'framework'),
		                'desc'     => __('This option only works if WPML plugin is installed.', 'framework'),
		                'default'   => 1,
		                'on'        => __('Display','framework'),
		                'off'       => __('Hide','framework'),
		                'required'  => array('inspiry_design_variation', '=', 'default')
	                ),
                )
            );


	        /*----------------------------------------------------------------------*/
	        /* Logo Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Site Logo', 'framework'),
		        'desc' => __('This section contains options related to site logo.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id'       => 'website_logo',
				        'type'     => 'media',
				        'url'      => false,
				        'title'    => __('Logo', 'framework'),
				        'subtitle' => __('Upload logo image for your Website. Otherwise site title will be displayed in place of logo.', 'framework')
			        ),
			        array(
				        'id'       => 'website_retina_logo',
				        'type'     => 'media',
				        'url'      => false,
				        'title'    => __('Retina Logo', 'framework'),
				        'subtitle' => __('Upload double size of your default logo image. For example, if your default logo image size is 200px by 30px, your retina logo image size should be 400px by 60px.', 'framework')
			        ),
		        )
	        );


	        /*----------------------------------------------------------------------*/
	        /* Social Icons Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Social Icons', 'framework'),
		        'desc' => __('This section contains options related to social icons.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id'=>'skype_username',
				        'type' => 'text',
				        'title' => __('Skype Username', 'framework'),
				        'subtitle' => __('Provide skype username to display its icon.', 'framework'),
				        'required'  => array('display_footer_social_icons', '=', '1')
			        ),
			        array(
				        'id'=>'twitter_url',
				        'type' => 'text',
				        'title' => __('Twitter', 'framework'),
				        'subtitle' => __('Provide twitter url to display its icon.', 'framework'),
				        'required'  => array('display_footer_social_icons', '=', '1')
			        ),
			        array(
				        'id'=>'facebook_url',
				        'type' => 'text',
				        'title' => __('Facebook', 'framework'),
				        'subtitle' => __('Provide facebook url to display its icon.', 'framework'),
				        'required'  => array('display_footer_social_icons', '=', '1')
			        ),
			        array(
				        'id'=>'google_url',
				        'type' => 'text',
				        'title' => __('Google+', 'framework'),
				        'subtitle' => __('Provide google+ url to display its icon.', 'framework'),
				        'required'  => array('display_footer_social_icons', '=', '1')
			        ),
			        array(
				        'id'=>'linkedin_url',
				        'type' => 'text',
				        'title' => __('LinkedIn', 'framework'),
				        'subtitle' => __('Provide LinkedIn url to display its icon.', 'framework'),
				        'required'  => array('display_footer_social_icons', '=', '1')
			        ),
			        array(
				        'id'=>'instagram_url',
				        'type' => 'text',
				        'title' => __('Instagram', 'framework'),
				        'subtitle' => __('Provide Instagram url to display its icon.', 'framework'),
				        'required'  => array('display_footer_social_icons', '=', '1')
			        ),
			        array(
				        'id'=>'youtube_url',
				        'type' => 'text',
				        'title' => __('YouTube', 'framework'),
				        'subtitle' => __('Provide YouTube url to display its icon.', 'framework'),
				        'required'  => array('display_footer_social_icons', '=', '1')
			        ),
			        array(
				        'id'=>'rss_url',
				        'type' => 'text',
				        'title' => __('RSS', 'framework'),
				        'subtitle' => __('Provide RSS feed url to display its icon.', 'framework'),
				        'required'  => array('display_footer_social_icons', '=', '1')
			        )
		        )
	        );


	        /*----------------------------------------------------------------------*/
	        /* Banner Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Banner', 'framework'),
		        'desc' => __('This section contains options related to banner.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id' => 'display_page_banner',
				        'type' => 'switch',
				        'title' => __('Display Page Banner?', 'framework'),
				        'subtitle' => __('Enable or Disable Page Banner', 'framework'),
				        'default' => '1',
				        'on' => __('Enabled','framework'),
				        'off' => __('Disabled','framework')
			        ),
			        array(
				        'id'       => 'default_page_banner',
				        'type'     => 'media',
				        'url'      => false,
				        'title'    => __('Default Banner Image', 'framework'),
				        'desc'     => __('Banner image should have minimum width of 2000px and minimum height of 180px.', 'framework'),
				        'subtitle' => __('Default banner image will be displayed on all the pages where banner image is not overridden by page specific banner settings.', 'framework')
			        ),
		        )
	        );


	        /*----------------------------------------------------------------------*/
	        /* Breadcrumb Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Breadcrumb', 'framework'),
		        'desc' => __('This section contains options related to breadcrumbs.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id' => 'breadcrumb',
				        'type' => 'switch',
				        'title' => __('Breadcrumb ?', 'framework'),
				        'subtitle' => __('Enable or Disable Breadcrumb.', 'framework'),
				        'default' => '1',
				        'on' => __('Enabled','framework'),
				        'off' => __('Disabled','framework')
			        ),
			        array(
				        'id'       => 'inspiry_doctors_page',
				        'type'     => 'select',
				        'data'     => 'pages',
				        'title'    => __( 'Doctors Page for Breadcrumbs', 'framework' ),
				        'required'  => array( 'breadcrumb', '=', '1' ),
			        ),
			        array(
				        'id'       => 'inspiry_services_page',
				        'type'     => 'select',
				        'data'     => 'pages',
				        'title'    => __( 'Services Page for Breadcrumbs', 'framework' ),
				        'required'  => array( 'breadcrumb', '=', '1' ),
			        ),
			        array(
				        'id'       => 'inspiry_gallery_page',
				        'type'     => 'select',
				        'data'     => 'pages',
				        'title'    => __( 'Gallery Page for Breadcrumbs', 'framework' ),
				        'required'  => array( 'breadcrumb', '=', '1' ),
			        ),
		        )
	        );


	        /*----------------------------------------------------------------------*/
	        /* Quick JavaScript Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Quick JavaScript', 'framework'),
		        'desc' => __('This section contains options related to JavaScript.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id'        => 'quick_js',
				        'type'      => 'ace_editor',
				        'title'     => __('Quick JavaScript', 'framework'),
				        'desc'  => __('You can paste your JavaScript code here.', 'framework'),
				        'mode'      => 'javascript',
				        'theme'     => 'chrome'
			        )
		        )
	        );


	        /*----------------------------------------------------------------------*/
            /* Home Section - Slider & Appointment
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home', 'framework'),
                'icon'    => 'el-icon-home',
                'desc' => __('This section contains options related to website homepage.', 'framework'),
                'fields' => array(
                    /* Homepage Slider Section */
                    array(
                        'id'       => 'display_slider_on_home',
                        'type'     => 'switch',
                        'title'    => __('Homepage Slider', 'framework'),
                        'subtitle' => __('Do you want to display slider on homepage ?', 'framework'),
                        'desc'     => __('Image banner will be displayed if slider is disabled', 'framework'),
                        'default'  => '1',
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework')
                    ),
                    array(
                        'id'        => 'slider_type',
                        'type'      => 'button_set',
                        'title'     => __('Slider Type', 'framework'),
                        'subtitle'  => __('Select the type of slider that you want to use.', 'framework'),
                        'options'   => array(
                            '1' => __('Default Slider','framework'),
                            '2' => __('Revolution Slider','framework')
                        ),
                        'default'   => '1',
                        'required'  => array('display_slider_on_home', '=', '1')
                    ),
                    array(
                        'id' => 'revolution_slider_alias',
                        'type' => 'text',
                        'title' => __('Revolution Slider Alias', 'framework'),
                        'subtitle' => __('If you want to use revolution slider then provide its alias here.', 'framework'),
                        'desc' => __('For more information consult documentation.', 'framework'),
                        'required'  => array('slider_type', '=', '2')
                    ),
                    array(
                        'id' => 'slides',
                        'type' => 'slides',
                        'title' => __('Homepage Slider Slides', 'framework'),
                        'subtitle' => __('Add slides for homepage slider.', 'framework'),
                        'desc' => __('The recommended image size is 2000px by 800px. You can use bigger or smaller image size but try to keep the width to height ratio 100px to 40px and use the exactly same size images for all slides.', 'framework'),
                        'show' => array(
                            'title'         => true,
                            'description'   => true,
                            'url'           => true
                        ),
                        'placeholder' => array(
                            'title' => __('Slide title text', 'framework'),
                            'description' => __('Slide description text', 'framework'),
                            'url' => __('Provide URL for button', 'framework')
                        ),
                        'required'  => array('slider_type', '=', '1')
                    ),
                    array(
                        'id' => 'slider_button_text',
                        'type' => 'text',
                        'title' => __('Slider Button Text', 'framework'),
                        'desc' => __('Add button text to be displayed on each slide.', 'framework'),
                        'default' => __('Read More', 'framework'),
                        'required' => array( array( 'slider_type', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
                    ),
                    array(
                        'id'       => 'display_slider_plus_sign',
                        'type'     => 'switch',
                        'title'    => __('Plus Sign After Slide Text', 'framework'),
                        'default'  => '1',
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework'),
                        'required' => array( array( 'slider_type', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
                    ),
                    array(
                        'id'       => 'display_slider_text_bg',
                        'type'     => 'switch',
                        'title'    => __('Slider Text Content Background', 'framework'),
                        'subtitle' => __('Do you want to display a semi transparent background behind slider text contents ?', 'framework'),
                        'desc' => __('This choice depends on the graphics in your slider images as the text might be hard to read without this background.', 'framework'),
                        'default'  => '0',
                        'on'        => __('Display','framework'),
                        'off'       => __('Hide','framework'),
                        'required' => array( array( 'slider_type', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
                    ),

	                /* Homepage Slider Announcement Section */
	                array(
		                'id' => 'display_announcement',
		                'type' => 'switch',
		                'title' => __('Announcement', 'framework'),
		                'subtitle' => __('Do you want to display announcement on slider ?', 'framework'),
		                'default' => '1',
		                'on' => __('Display','framework'),
		                'off' => __('Hide','framework'),
		                'required' => array( array( 'slider_type', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id' => 'announcement_title',
		                'type' => 'text',
		                'title' => __('Announcement Title', 'framework'),
		                'default' => __('MedicalPress Health Checkup Round', 'framework'),
		                'required'  => array( array( 'display_announcement', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') ),
	                ),
	                array(
		                'id' => 'discount_amount',
		                'type' => 'text',
		                'title' => __('Discount Amount', 'framework'),
		                'default' => __('50', 'framework'),
		                'required'  => array( array( 'display_announcement', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') ),
	                ),
	                array(
		                'id' => 'discount_amount_symbol',
		                'type' => 'text',
		                'title' => __('Discount Amount Symbol', 'framework'),
		                'default' => __('%', 'framework'),
		                'required'  => array( array( 'display_announcement', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') ),
	                ),
	                array(
		                'id' => 'discount_text',
		                'type' => 'text',
		                'title' => __('Discount Text', 'framework'),
		                'default' => __('Discount', 'framework'),
		                'required'  => array( array( 'display_announcement', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') ),
	                ),
	                array(
		                'id' => 'announcement_button_text',
		                'type' => 'text',
		                'title' => __('Slider Button Text', 'framework'),
		                'desc' => __('Add button text to be displayed on each slide.', 'framework'),
		                'default' => __('AVAIL THIS BENEFIT NOW', 'framework'),
		                'required'  => array('inspiry_design_variation', '=', 'reborn'),
	                ),
	                /* Homepage Appointment Form Section */
	                array(
		                'id' => 'display_appointment_form',
		                'type' => 'switch',
		                'title' => __('Appointment Form', 'framework'),
		                'subtitle' => __('Do you want to display appointment form on homepage ?', 'framework'),
		                'default' => '1',
		                'on' => __('Display','framework'),
		                'off' => __('Hide','framework')
	                ),
                    array(
                        'id'        => 'appointment_form_variation',
                        'type'      => 'image_select',
                        'title'     => __('Appointment Form Design', 'framework'),
                        'subtitle'  => __('Select the design variation that you want to use for appointment form.', 'framework'),
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('title' => __('Horizontal form over slider', 'framework'), 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/appointment_form_variation_1.jpg'),
                            '2' => array('title' => __('Vertical form over slider', 'framework'), 'img'   => INSPIRY_COMMON_DIR_URI . '/images/theme-options/appointment_form_variation_2.jpg'),
                            '3' => array('title' => __('Separate form below slider', 'framework'), 'img'  => INSPIRY_COMMON_DIR_URI . '/images/theme-options/appointment_form_variation_3.jpg')
                        ),
                        'default'   => '1',
                        'required' => array( array( 'display_appointment_form', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
                    ),
	                array(
		                'id' => 'collapse_appointment_form',
		                'type' => 'switch',
		                'title' => __( 'Collapse Appointment Form', 'framework' ),
		                'subtitle' => __( 'Do you want to collapse appointment form by default on homepage ?', 'framework' ),
		                'default' => '0',
		                'on' => __( 'Yes','framework' ),
		                'off' => __( 'No','framework' ),
		                'required'  => array( 'appointment_form_variation', '=', array( '1', '2' ) )
	                ),
	                array(
		                'id' => 'appointment_button_title',
		                'type' => 'text',
		                'title' => __('Appointment Button Title', 'framework'),
		                'default' => __('Make an Appointment', 'framework'),
		                'required' => array( array( 'display_appointment_form', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') ),
	                ),
	                array(
		                'id' => 'appointment_form_title',
		                'type' => 'text',
		                'title' => __('Appointment Form Title', 'framework'),
		                'required'  => array('display_appointment_form', '=', '1'),
		                'default' => __('Make an Appointment', 'framework')
	                ),
	                array(
		                'id' => 'appointment_form_desc',
		                'type' => 'textarea',
		                'title' => __('Appointment Form Description Text', 'framework'),
		                'required'  => array('appointment_form_variation', '=', '3'),
		                'validate' => 'no_html'
	                ),
	                array(
		                'id'       => 'appointment_form_bg_img',
		                'type'     => 'media',
		                'url'      => false,
		                'required'  => array('appointment_form_variation', '=', '3'),
		                'title'    => __('Appointment Form Background Image', 'framework'),
		                'desc' => __('Upload an image that will be displayed in the background of appointment form.', 'framework')
	                ),
	                array(
		                'id' => 'appointment_form_email',
		                'type' => 'text',
		                'title' => __('Appointment Email Address', 'framework'),
		                'subtitle' => __('Provide email address that will receive appointment request messages.', 'framework'),
		                'validate'  => 'email',
	                ),
	                array(
		                'id' => 'appointment_cc_form_email',
		                'type' => 'text',
		                'title' => __('Appointment CC Email Address', 'framework'),
		                'subtitle' => __('You can add multiple comma separated cc email addresses, to get a carbon copy of appointment form message.', 'framework'),
	                ),
	                array(
		                'id' => 'appointment_bcc_form_email',
		                'type' => 'text',
		                'title' => __('Appointment BCC Email Address', 'framework'),
		                'subtitle' => __('You can add multiple comma separated bcc email addresses, to get a blind carbon copy of appointment form message.', 'framework'),
	                ),
	                array(
                        'id' => 'appointment_confirmation_email',
                        'type' => 'textarea',
                        'title' => __('Appointment Confirmation Email', 'framework'),
                        'subtitle' => '<strong>%1$s</strong> means the FULL NAME of the person <br/> <strong>%2$s</strong> means the BLOG TITLE. <br/>HTML is not allowed. You can use <strong>enter</strong> or <strong>return</strong> as line breaks. You can copy the default template below:<br/>',
                        'default' => 'Dear %1$s,

                        Thanks for your appointment request with the %2$s.

                        We will get back to you soon.

                        Regards',
                        'validate' => 'no_html'
                    ),
	                array(
		                'id'       => 'appointment_thankyou_page',
		                'type'     => 'select',
		                'data'     => 'pages',
		                'title'    => __( 'Thank you page for Appointment Form', 'framework' ),
		                'desc'      => 'Redirect user to a specific page after successful form submission.'
	                ),
	                array(
		                'id' => 'display_appointment_recaptcha',
		                'type' => 'switch',
		                'title' => __('reCAPTCHA in Appointment Form', 'framework'),
		                'subtitle' => __('Do you want to display reCAPTCHA in appointment form ?', 'framework'),
		                'desc' => __('reCAPTCHA will not be displayed on 1st variation of appointment form due to design limitation.', 'framework'),
		                'default' => true,
		                'on' => __('Display','framework'),
		                'off' => __('Hide','framework')
	                ),
	                array(
		                'id'        => 'recaptcha_info_notice',
		                'type'      => 'info',
		                'notice'    => true,
		                'style'     => 'info',
		                'title'     => __('reCAPTCHA Requirements', 'framework'),
		                'desc'      => 'To use reCAPTCHA on appointment forms you need to configure its public and private keys in "Theme Options > Contact > Google reCAPTCHA" section.'
	                ),
                )
            );

	        /*----------------------------------------------------------------------*/
	        /* Home Layout Manager
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Layout Manager', 'framework'),
		        'desc'    => __('Organize Homepage sections, By the order in which you want them to appear.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id'      => 'home_sections',
				        'type'    => 'sorter',
				        'title'   => __('Homepage Layout Manager', 'framework'),
				        'options' => array(
					        'enabled'  => array(
						        'features'      => __('Features', 'framework'),
						        'content'       => __('Content', 'framework'),
						        'doctors'       => __('Doctors', 'framework'),
						        'news'          => __('News', 'framework'),
						        'testimonials'  => __('Testimonials', 'framework'),
					        ),
					        'disabled' => array(
						        'services'      => __('Services', 'framework'),
					        )
				        )
			        ),
                )
            );

            /*----------------------------------------------------------------------*/
            /* Home Features Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Features', 'framework'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'home_features_title',
                        'type' => 'text',
                        'title' => __('Features Title', 'framework'),
                        'subtitle' => __('Provide title to display above features section on homepage.', 'framework'),
                        'desc' => 'You can wrap few words in span tag to make them bold. Example: '.htmlentities('<span>Bold Words</span> Regular Words'),
                        'required'  => array('inspiry_design_variation', '=', 'default')
                    ),
                    array(
                        'id' => 'home_features_description',
                        'type' => 'textarea',
                        'title' => __('Features Description', 'framework'),
                        'subtitle' => __('Provide the text description to display below title in features section on homepage.', 'framework'),
                        'validate' => 'no_html',
                        'required'  => array('inspiry_design_variation', '=', 'default')
                    ),
                    array(
                        'id'        => 'features_variation',
                        'type'      => 'image_select',
                        'title'     => __('Features Section Design', 'framework'),
                        'subtitle'  => __('Select the design variation that you want to use for features on homepage.', 'framework'),
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('title' => __('1st Variation', 'framework'), 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/features_variation_1.jpg'),
                            '2' => array('title' => __('2nd Variation', 'framework'), 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/features_variation_2.jpg'),
                            '3' => array('title' => __('3rd Variation', 'framework'), 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/features_variation_3.jpg')
                        ),
                        'default'   => '1',
                        'required'  => array('inspiry_design_variation', '=', 'default')
                    ),

                    /* 1st Variation - Common Fields */
                    array(
                        'id' => 'features_button_text',
                        'type' => 'text',
                        'title' => __('Button Text', 'framework'),
                        'subtitle' => __('Provide label text for button in 1st variation', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'features_button_url',
                        'type' => 'text',
                        'validate'  => 'url',
                        'title' => __('Target URL for Button', 'framework'),
                        'subtitle' => __('Provide target url for button in 1st variation', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id'        => 'feature_var_1_info_notice',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'info',
                        'icon'      => 'el-icon-info-sign',
                        'title'     => __('Note', 'framework'),
                        'desc'      => '1st variation uses <a target="_blank" href="http://fontawesome.io/icons/">Font Awesome Icons</a>. So, your choice is limited to the set of icons available in font awesome collection. Please note that you need to provide the icon code in following format <strong>'.htmlentities('<i class="fa fa-ambulance"></i>').'</strong>',
                        'required'  => array('features_variation', '=', '1')
                    ),

                    /* 1st Variation - Options set 1*/
                    array(
                        'id' => 'feature_var_1_icon_1',
                        'type' => 'text',
                        'title' => __('1st Feature Icon Code', 'framework'),
                        'subtitle' => __('Provide the Font Awesome icon code', 'framework'),
                        'desc' => 'Example value: '.htmlentities('<i class="fa fa-plus-square"></i>'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_title_1',
                        'type' => 'text',
                        'title' => __('1st Feature Title', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_url_1',
                        'type' => 'text',
                        'validate'  => 'url',
                        'title' => __('1st Feature URL', 'framework'),
                        'subtitle' => __('If you want to display feature title as link then provide the target URL.', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_desc_1',
                        'type' => 'textarea',
                        'title' => __('1st Feature Description', 'framework'),
                        'subtitle' => __('Provide feature description text.', 'framework'),
                        'validate' => 'no_html',
                        'required'  => array( 'features_variation', '=', '1' )
                    ),

                    /* 1st Variation - Options set 2*/
                    array(
                        'id' => 'feature_var_1_icon_2',
                        'type' => 'text',
                        'title' => __('2nd Feature Icon Code', 'framework'),
                        'subtitle' => __('Provide the Font Awesome icon code', 'framework'),
                        'desc' => 'Example value: '.htmlentities('<i class="fa fa-wheelchair"></i>'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_title_2',
                        'type' => 'text',
                        'title' => __('2nd Feature Title', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_url_2',
                        'type' => 'text',
                        'validate'  => 'url',
                        'title' => __('2nd Feature URL', 'framework'),
                        'subtitle' => __('If you want to display feature title as link then provide the target URL.', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_desc_2',
                        'type' => 'textarea',
                        'title' => __('2nd Feature Description', 'framework'),
                        'subtitle' => __('Provide feature description text.', 'framework'),
                        'validate' => 'no_html',
                        'required'  => array( 'features_variation', '=', '1' )
                    ),

                    /* 1st Variation - Options set 3*/
                    array(
                        'id' => 'feature_var_1_icon_3',
                        'type' => 'text',
                        'title' => __('3rd Feature Icon Code', 'framework'),
                        'subtitle' => __('Provide the Font Awesome icon code', 'framework'),
                        'desc' => 'Example value: '.htmlentities('<i class="fa fa-user-md"></i>'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_title_3',
                        'type' => 'text',
                        'title' => __('3rd Feature Title', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_url_3',
                        'type' => 'text',
                        'validate'  => 'url',
                        'title' => __('3rd Feature URL', 'framework'),
                        'subtitle' => __('If you want to display feature title as link then provide the target URL.', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_desc_3',
                        'type' => 'textarea',
                        'title' => __('3rd Feature Description', 'framework'),
                        'subtitle' => __('Provide feature description text.', 'framework'),
                        'validate' => 'no_html',
                        'required'  => array( 'features_variation', '=', '1' )
                    ),

                    /* 1st Variation - Options set 1*/
                    array(
                        'id' => 'feature_var_1_icon_4',
                        'type' => 'text',
                        'title' => __('4th Feature Icon Code', 'framework'),
                        'subtitle' => __('Provide the Font Awesome icon code', 'framework'),
                        'desc' => 'Example value: '.htmlentities('<i class="fa fa-ambulance"></i>'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_title_4',
                        'type' => 'text',
                        'title' => __('4th Feature Title', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_url_4',
                        'type' => 'text',
                        'validate'  => 'url',
                        'title' => __('4th Feature URL', 'framework'),
                        'subtitle' => __('If you want to display feature title as link then provide the target URL.', 'framework'),
                        'required'  => array( 'features_variation', '=', '1' )
                    ),
                    array(
                        'id' => 'feature_var_1_desc_4',
                        'type' => 'textarea',
                        'title' => __('4th Feature Description', 'framework'),
                        'subtitle' => __('Provide feature description text.', 'framework'),
                        'validate' => 'no_html',
                        'required'  => array( 'features_variation', '=', '1' )
                    ),

                    /* 2nd Variation */
                    array(
                        'id' => 'variation_2_features',
                        'type' => 'slides',
                        'title' => __('2nd Variation Features', 'framework'),
                        'subtitle' => __('Feature images should have similar width and height.', 'framework'),
                        'show' => array(
                            'title'         => true,
                            'description'   => true,
                            'url'           => true
                        ),
                        'placeholder' => array(
                            'title' => __('Feature Title', 'framework'),
                            'description' => __('Feature Description', 'framework'),
                            'url' => __('Feature link if any', 'framework')
                        ),
                        'required'  => array( 'features_variation', '=', '2' )
                    ),

                    /* 3rd Variation */
                    array(
                        'id' => 'variation_3_features',
                        'type' => 'slides',
                        'title' => __('3rd Variation Features', 'framework'),
                        'subtitle' => __('Feature images should have 70px width and 70px height.', 'framework'),
                        'show' => array(
                            'title'         => true,
                            'description'   => true,
                            'url'           => true
                        ),
                        'placeholder' => array(
                            'title' => __('Feature Title', 'framework'),
                            'description' => __('Feature Description', 'framework'),
                            'url' => __('Feature link if any', 'framework')
                        ),
                        'required'  => array( 'features_variation', '=', '3' )
                    ),

	                /* Variation Two Features */
	                array(
		                'id' => 'features_variation_2',
		                'type' => 'slides',
		                'title' => __('Features', 'framework'),
		                'subtitle' => __('Feature images should have similar width and height.', 'framework'),
		                'show' => array(
			                'title'         => true,
			                'description'   => true,
			                'url'           => true
		                ),
		                'placeholder' => array(
			                'title' => __('Feature Title', 'framework'),
			                'description' => __('Feature Description', 'framework'),
			                'url' => __('Feature link if any', 'framework')
		                ),
		                'required'  => array('inspiry_design_variation', '=', 'reborn')
	                ),
                )
            );


            /*----------------------------------------------------------------------*/
            /* Home Doctors Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Doctors', 'framework'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'home_doctors_title',
                        'type' => 'text',
                        'title' => __('Doctors Title', 'framework'),
                        'subtitle' => __('Provide title to display above doctors section on homepage.', 'framework'),
                        'desc' => 'You can wrap few words in span tag to make them bold. Example: '.htmlentities('<span>Bold Words</span> Regular Words'),
                    ),
                    array(
                        'id' => 'home_doctors_description',
                        'type' => 'textarea',
                        'title' => __('Doctors Description', 'framework'),
                        'subtitle' => __('Provide the text description to display below title in doctors section on homepage.', 'framework'),
                        'validate' => 'no_html',
                    ),
                    array(
                        'id'        => 'doctors_variation',
                        'type'      => 'image_select',
                        'title'     => __('Doctors Section Design', 'framework'),
                        'subtitle'  => __('Select the design variation that you want to use for doctors on homepage.', 'framework'),
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('title' => '', 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/doctors_variation_1.jpg'),
                            '2' => array('title' => '', 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/doctors_variation_2.jpg'),
                        ),
                        'default'   => '1',
                        'required'  => array('inspiry_design_variation', '=', 'default')
                    ),
                    array(
                        'id'       => 'home_doctors_columns',
                        'type'     => 'select',
                        'title'    => __('Number of Columns to Display', 'framework'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                        'default'  => '4',
                        'required'  => array('inspiry_design_variation', '=', 'default')
                    ),
                    array(
                        'id'       => 'home_doctors_count',
                        'type'     => 'select',
                        'title'    => __('Number of Doctors to Display', 'framework'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6',
                            '7' => '7',
                            '8' => '8',
                            '9' => '9',
                            '10' => '10',
                            '11' => '11',
                            '12' => '12',
                            '13' => '13',
                            '14' => '14',
                            '15' => '15',
                            '16' => '16',
                        ),
                        'default'  => '4',
                        'required'  => array('inspiry_design_variation', '=', 'default')
                    ),
	                array(
		                'id'       => 'reborn_home_doctors_count',
		                'type'     => 'select',
		                'title'    => __('Number of Doctors to Display', 'framework'),
		                'options'  => array(
			                '1' => '1',
			                '2' => '2',
			                '3' => '3',
			                '4' => '4',
			                '8' => '8',
			                '12' => '12',
			                '16' => '16',
		                ),
		                'default'  => '4',
		                'required'  => array('inspiry_design_variation', '=', 'reborn')
	                ),
	                array(
		                'id' => 'display_show_all_doctor_button',
		                'type' => 'switch',
		                'title' => __('Display "View All Doctor" Button', 'framework'),
		                'default' => '0',
		                'on' => __('Display','framework'),
		                'off' => __('Hide','framework'),
		                'required'  => array('inspiry_design_variation', '=', 'reborn')
	                ),
	                array(
		                'id' => 'show_all_doctor_button_text',
		                'type' => 'text',
		                'title' => __('Button Text', 'framework'),
		                'required' => array( array( 'display_show_all_doctor_button', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id' => 'show_all_doctor_button_link',
		                'type' => 'text',
		                'title' => __('Button Link', 'framework'),
		                'required' => array( array( 'display_show_all_doctor_button', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
                )
            );


            /*----------------------------------------------------------------------*/
            /* Home Services Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Services', 'framework'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'home_services_title',
                        'type' => 'text',
                        'title' => __('Services Title', 'framework'),
                        'subtitle' => __('Provide title to display above services section on homepage.', 'framework'),
                        'desc' => 'You can wrap few words in span tag to make them bold. Example: '.htmlentities('<span>Bold Words</span> Regular Words'),
                    ),
                    array(
                        'id' => 'home_services_description',
                        'type' => 'textarea',
                        'title' => __('Services Description', 'framework'),
                        'subtitle' => __('Provide the text description to display below title in services section on homepage.', 'framework'),
                        'validate' => 'no_html',
                    ),
	                array(
		                'id' => 'service_item_thumb',
		                'type' => 'switch',
		                'title' => __('What to display for services.', 'framework'),
		                'default' => '1',
		                'on' => __('Featured Image','framework'),
		                'off' => __('Icon','framework'),
		                'required'  => array('inspiry_design_variation', '=', 'reborn')
	                ),
	                array(
		                'id'       => 'home_total_services',
		                'type'     => 'select',
		                'title'    => __('Number of Services to Display', 'framework'),
		                'default'  => '3',
		                'options'  => array(
			                '3' => '3',
			                '6' => '6',
			                '9' => '9',
			                '12' => '12',
			                '15' => '15'
		                ),
		                'required'  => array('inspiry_design_variation', '=', 'reborn')
	                ),
                    array(
	                    'id' => 'display_show_all_services_button',
	                    'type' => 'switch',
	                    'title' => __('Display "View All Services" Button', 'framework'),
	                    'default' => '0',
	                    'on' => __('Display','framework'),
	                    'off' => __('Hide','framework'),
	                    'required'  => array('inspiry_design_variation', '=', 'reborn')
                    ),
	                array(
		                'id' => 'show_all_services_button_link',
		                'type' => 'text',
		                'title' => __('Button Link', 'framework'),
		                'required' => array( array( 'display_show_all_services_button', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
                )
            );


            /*----------------------------------------------------------------------*/
            /* Home News Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - News', 'framework'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'home_news_title',
                        'type' => 'text',
                        'title' => __('News Title', 'framework'),
                        'subtitle' => __('Provide title to display above news section on homepage.', 'framework'),
                        'desc' => 'You can wrap few words in span tag to make them bold. Example: '.htmlentities('<span>Bold Words</span> Regular Words'),
                    ),
                    array(
                        'id' => 'home_news_description',
                        'type' => 'textarea',
                        'title' => __('News Description', 'framework'),
                        'subtitle' => __('Provide the text description to display below title in news section on homepage.', 'framework'),
                        'validate' => 'no_html',
                    ),
                    array(
                        'id'        => 'news_variation',
                        'type'      => 'image_select',
                        'title'     => __('News Section Design', 'framework'),
                        'subtitle'  => __('Select the design variation that you want to use for news section on homepage.', 'framework'),
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('title' => '', 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/news_variation_1.jpg'),
                            '2' => array('title' => '', 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/news_variation_2.jpg')
                        ),
                        'default'   => '1',
                        'required'  => array('inspiry_design_variation', '=', 'default')
                    ),
                    array(
                        'id'       => 'home_news_count',
                        'type'     => 'select',
                        'title'    => __('Number of News to Display', 'framework'),
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                        'default'  => '3',
                        'required'  => array('inspiry_design_variation', '=', 'default')
                    ),
                    array(
	                    'id'       => 'home_news_per_page',
	                    'type'     => 'select',
	                    'title'    => __('Number of News to Display', 'framework'),
	                    'options'  => array(
		                    '1' => '1',
		                    '2' => '2',
		                    '3' => '3',
		                    '4' => '4',
		                    '5' => '5',
	                    ),
	                    'default'  => '5',
	                    'required'  => array('inspiry_design_variation', '=', 'reborn')
                    )
                )
            );


            /*----------------------------------------------------------------------*/
            /* Home Testimonials Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Home - Testimonials', 'framework'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'        => 'testimonials_variation',
                        'type'      => 'image_select',
                        'title'     => __('Testimonials Section Design', 'framework'),
                        'subtitle'  => __('Select the design variation that you want to use for testimonials section on homepage.', 'framework'),
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('title' => '', 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/testimonials_variation_1.jpg'),
                            '2' => array('title' => '', 'img' => INSPIRY_COMMON_DIR_URI . '/images/theme-options/testimonials_variation_2.jpg'),
                        ),
                        'default'   => '1',
	                    'required'  => array('inspiry_design_variation', '=', 'default')
                    ),
                    array(
                        'id' => 'home_testimonials_title',
                        'type' => 'text',
                        'title' => __('Testimonials Title', 'framework'),
                        'subtitle' => __('Provide the title text to display above testimonials on homepage.', 'framework'),
                        'desc' => 'You can wrap few words in span tag to make them bold. Example: '.htmlentities('<span>Bold Words</span> Regular Words'),
                    ),
                    array(
                        'id' => 'home_testimonials_description',
                        'type' => 'textarea',
                        'title' => __('Testimonials Description', 'framework'),
                        'subtitle' => __('Provide the text description to display below title in testimonials section on homepage.', 'framework'),
                        'validate' => 'no_html',
                    ),
	                array(
		                'id'       => 'home_testimonials_per_page',
		                'type'     => 'select',
		                'title'    => __('Number of Testimonials to Display', 'framework'),
		                'options'  => array(
			                '1' => '1',
			                '2' => '2',
			                '3' => '3',
			                '4' => '4',
			                '5' => '5',
			                '6' => '6',
			                '7' => '7',
			                '8' => '8',
			                '9' => '9',
			                '10' => '10',
		                ),
		                'default'  => '2',
		                'required'  => array('inspiry_design_variation', '=', 'reborn')
	                )
                )
            );


            /*----------------------------------------------------------------------*/
            /* General Settings
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('General', 'framework'),
                'icon'    => 'el-icon-cog',
                'heading' => __('General Options', 'framework'),
                'desc' => __('This section contains options related to overall theme.', 'framework'),
                'fields' => array(
	                array(
		                'id' => 'inspiry_boxed_layout',
		                'type' => 'switch',
		                'title' => __('Boxed Layout?', 'framework'),
		                'subtitle' => __('You can enable or disable Boxed Layout for the theme.', 'framework'),
		                'default' => '0',
		                'on' => __('Enable','framework'),
		                'off' => __('Disable','framework')
	                ),
                    array(
                        'id' => 'swipebox',
                        'type' => 'switch',
                        'title' => __('Swipebox Lightbox ?', 'framework'),
                        'subtitle' => __('You can enable or disable swipebox lightbox for overall site.', 'framework'),
                        'default' => '1',
                        'on' => __('Enable','framework'),
                        'off' => __('Disable','framework')
                    ),
                    array(
                        'id' => 'display_doctor_department',
                        'type' => 'switch',
                        'title' => __('Display Doctor Departments', 'framework'),
                        'subtitle' => __('Do you want to display doctor department on listing page?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id' => 'display_gallery_categories',
                        'type' => 'switch',
                        'title' => __('Display Gallery Categories', 'framework'),
                        'subtitle' => __('Do you want to display gallery categories on gallery listing page?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                ),
            );


            /*----------------------------------------------------------------------*/
            /* Doctor Listing Page
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Doctor', 'framework'),
                'icon'    => 'el-icon-user',
                'heading' => __('Doctor Listing Page', 'framework'),
                'desc' => __('This section contains options for doctor listing page.', 'framework'),
                'fields' => array(
                    array(
                        'id'=>'doctor_sort',
                        'type' => 'select',
                        'title' => __('Sort Order', 'framework'),
                        'subtitle' => __('Ascending OR Descending.', 'framework'),
                        'options'  => array(
                            'ASC' => 'Ascending',
                            'DESC' => 'Descending',
                        ),
                    ),
                    array(
                        'id'=>'doctor_sort_by',
                        'type' => 'select',
                        'title' => __('Sort By', 'framework'),
                        'subtitle' => __('Select the option to sort the doctors by Name, Date Speciality and Education.', 'framework'),
                        'options'  => array(
                            'title' => 'Name',
                            'date' => 'Date',
                            'doctor_speciality' => 'Speciality',
                            'doctor_education' => 'Education',
                        ),
                    )
                ),
            );

            /*----------------------------------------------------------------------*/
            /* Doctor Detail Page
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Doctor Detail Page', 'framework'),
                'subsection'    => true,
                'heading' => __('Doctor Detail Page', 'framework'),
                'desc' => __('This section contains options related to doctor detail page.', 'framework'),
                'fields' => array(
                    array(
                        'id'=>'doctor_detail_title',
                        'type' => 'text',
                        'title' => __('Doctor Page Title', 'framework'),
                        'subtitle' => __('Provide title text to display below image banner on doctor detail page.', 'framework'),
                        'default' => __('Doctor', 'framework'),
                        'required' => array('inspiry_design_variation', '=', 'default')
                    ),
                    array(
                        'id' => 'display_related_doctors',
                        'type' => 'switch',
                        'title' => __('Related Doctors', 'framework'),
                        'subtitle' => __('Do you want to display related doctors section on doctor detail page ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'related_doctors_title',
                        'type' => 'text',
                        'title' => __('Related Doctors Title', 'framework'),
                        'subtitle' => __('Provide the title text to display above related doctors section.', 'framework'),
                        'desc' => 'You can wrap few words in span tag to make them bold. Example: '.htmlentities('<span>Bold Words</span> Regular Words'),
                        'required'  => array('display_related_doctors', '=', '1'),
                        'default' => __('Related Doctors', 'framework')
                    ),
                    array(
                        'id'=>'related_doctors_description',
                        'type' => 'textarea',
                        'title' => __(' Related Doctors Description', 'framework'),
                        'subtitle' => __('Provide the text description to display below title in related doctors section.', 'framework'),
                        'required'  => array('display_related_doctors', '=', '1'),
                        'validate' => 'no_html'
                    ),
	                array(
		                'id' => 'display_all_doctor_button',
		                'type' => 'switch',
		                'title' => __('Display "View All Doctor" Button', 'framework'),
		                'default' => '0',
		                'on' => __('Display','framework'),
		                'off' => __('Hide','framework'),
		                'required'  => array('inspiry_design_variation', '=', 'reborn')
	                ),
	                array(
		                'id' => 'display_all_doctor_button_text',
		                'type' => 'text',
		                'title' => __('Button Text', 'framework'),
		                'required' => array( array( 'display_all_doctor_button', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id' => 'display_all_doctor_button_link',
		                'type' => 'text',
		                'title' => __('Button Link', 'framework'),
		                'required' => array( array( 'display_all_doctor_button', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
                ),
            );


            /*----------------------------------------------------------------------*/
            /* Gallery Detail Page
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Gallery Item', 'framework'),
                'icon'    => 'el-icon-picture',
                'heading' => __('Gallery Item Detail Page', 'framework'),
                'desc' => __('This section contains options related to gallery detail page.', 'framework'),
                'fields' => array(

                    array(
                        'id' => 'display_related_gallery_items',
                        'type' => 'switch',
                        'title' => __('Related Gallery Items', 'framework'),
                        'subtitle' => __('Do you want to display related gallery items section on gallery detail page ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'related_gallery_items_title',
                        'type' => 'text',
                        'title' => __('Related Gallery Items Title', 'framework'),
                        'subtitle' => __('Provide the title text to display above related gallery items section.', 'framework'),
                        'desc' => 'You can wrap few words in span tag to make them bold. Example: '.htmlentities('<span>Bold Words</span> Regular Words'),
                        'required'  => array('display_related_gallery_items', '=', '1'),
                        'default' => __('Related Gallery Items', 'framework')
                    ),
                    array(
                        'id'=>'related_gallery_items_description',
                        'type' => 'textarea',
                        'title' => __(' Related Gallery Items Description', 'framework'),
                        'subtitle' => __('Provide the text description to display below title in related gallery items section.', 'framework'),
                        'required'  => array('display_related_gallery_items', '=', '1'),
                        'validate' => 'no_html'
                    )
                ),
            );


            /*----------------------------------------------------------------------*/
            /* Services Listing Page
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Services', 'framework'),
                'icon'    => 'el-icon-cog-alt',
                'heading' => __('Services Listing Pages', 'framework'),
                'desc' => __('This section contains options related to Services listing pages.', 'framework'),
                'fields' => array(
                    array(
                        'id' => 'display_services_pagination',
                        'type' => 'switch',
                        'title' => __('Display Services Pagination', 'framework'),
                        'subtitle' => __('Do you want to display pagination on Services listing pages?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
	                array(
		                'id' => 'service_page_item_thumb',
		                'type' => 'switch',
		                'title' => __('What to display for services.', 'framework'),
		                'default' => '1',
		                'on' => __('Featured Image','framework'),
		                'off' => __('Icon','framework'),
		                'required'  => array('inspiry_design_variation', '=', 'reborn')
	                ),
                ),
            );


            /*----------------------------------------------------------------------*/
            /* Contact Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Contact  ', 'framework'),
                'icon'    => 'el-icon-envelope',
                'desc' => __('This section contains options related to contact page.', 'framework'),
                'fields' => array(
                    array(
                        'id' => 'display_contact_form',
                        'type' => 'switch',
                        'title' => __('Contact Form', 'framework'),
                        'subtitle' => __('Do you want to display contact form on contact page ?', 'framework'),
                        'default' => '1',
                        'on' => __('Display','framework'),
                        'off' => __('Hide','framework')
                    ),
                    array(
                        'id'=>'contact_email',
                        'type' => 'text',
                        'title' => __('Contact Form Email', 'framework'),
                        'subtitle' => __('Provide the email address where you want to receive contact form messages.', 'framework'),
                        'required'  => array('display_contact_form', '=', '1'),
                        'validate'  => 'email'
                    ),
	                array(
		                'id' => 'contact_cc_email',
		                'type' => 'text',
		                'title' => __('Contact CC Email Address', 'framework'),
		                'subtitle' => __('You can add multiple comma separated cc email addresses, to get a carbon copy of contact form message.', 'framework'),
	                ),
	                array(
		                'id' => 'contact_bcc_email',
		                'type' => 'text',
		                'title' => __('Contact BCC Email Address', 'framework'),
		                'subtitle' => __('You can add multiple comma separated bcc email addresses, to get a blind carbon copy of contact form message.', 'framework'),
	                ),
	                array(
		                'id' => 'display_contact_recaptcha',
		                'type' => 'switch',
		                'title' => __('Display reCAPTCHA', 'framework'),
		                'subtitle' => __('Do you want to display reCAPTCHA in contact form ?', 'framework'),
		                'default' => '1',
		                'required'  => array('display_contact_form', '=', '1'),
		                'on' => __('Display','framework'),
		                'off' => __('Hide','framework')
	                ),
	                array(
		                'id'        => 'recaptcha_info_notice_2',
		                'type'      => 'info',
		                'notice'    => true,
		                'style'     => 'info',
		                'title'     => __('reCAPTCHA Requirements', 'framework'),
		                'desc'      => 'To use reCAPTCHA on contact forms you need to configure its public and private keys in "Theme Options > Contact > Google reCAPTCHA" section.'
	                ),
                )
            );


	        /*----------------------------------------------------------------------*/
	        /* Google reCAPTCHA Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
	            'title' => __('Google reCAPTCHA', 'framework'),
		        'desc' => __('This section contains options related to Google reCAPTCHA.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id'        => 'recaptcha_info_notice',
				        'type'      => 'info',
				        'notice'    => true,
				        'style'     => 'info',
				        'title'     => __('About Google reCAPTCHA', 'framework'),
				        'desc'      => 'This theme uses Google reCAPTCHA and you can get your public and private keys from <a target="_blank" href="https://www.google.com/recaptcha/intro/index.html">Google reCAPTCHA Website</a>. Provide these keys if you want to use reCAPTCHA with various forms in this theme.'
			        ),
			        array(
				        'id'=>'recaptcha_public_key',
				        'type' => 'text',
				        'title' => __('reCAPTCHA Site key', 'framework')
			        ),
			        array(
				        'id'=>'recaptcha_private_key',
				        'type' => 'text',
				        'title' => __('reCAPTCHA Secret key', 'framework')
			        ),
		        )
	        );


	        /*----------------------------------------------------------------------*/
	        /* Contact Detail Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Contact Details ', 'framework'),
		        'desc' => __('This section contains options related to contact details on contact page.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id' => 'display_contact_details',
				        'type' => 'switch',
				        'title' => __('Other Contact Details', 'framework'),
				        'subtitle' => __('Do you want to display other contact details like address, phone and social icons on contact page ?', 'framework'),
				        'default' => '1',
				        'on' => __('Display','framework'),
				        'off' => __('Hide','framework')
			        ),
			        array(
				        'id'=>'contact_details_title',
				        'type' => 'text',
				        'required'  => array('display_contact_details', '=', '1'),
				        'title' => __('Contact Details Title', 'framework')
			        ),
			        array(
				        'id'=>'contact_address',
				        'type' => 'textarea',
				        'title' => __('Address', 'framework'),
				        'desc' => __('HTML is allowed', 'framework'),
				        'required'  => array('display_contact_details', '=', '1'),
				        'validate' => 'html'
			        ),
			        array(
				        'id'=>'contact_phone',
				        'type' => 'text',
				        'title' => __('Phone Number', 'framework'),
				        'required'  => array('display_contact_details', '=', '1')
			        ),
			        array(
				        'id'=>'contact_fax',
				        'type' => 'text',
				        'title' => __('Fax Number', 'framework'),
				        'required'  => array('display_contact_details', '=', '1')
			        ),
			        array(
				        'id' => 'display_social_icons',
				        'type' => 'switch',
				        'title' => __('Social Icons', 'framework'),
				        'subtitle' => __('Do you want to display social icons on contact page ?', 'framework'),
				        'desc' => __('Social icons settings are provided in social icons section under Header tab.', 'framework'),
				        'default' => '1',
				        'on' => __('Display','framework'),
				        'off' => __('Hide','framework'),
				        'required'  => array('display_contact_details', '=', '1')
			        ),
		        )
	        );


	        /*----------------------------------------------------------------------*/
	        /* Google Map Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Google Map', 'framework'),
		        'desc' => __('This section contains options related to google map on contact page.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id' => 'display_google_map',
				        'type' => 'switch',
				        'title' => __('Google Map', 'framework'),
				        'subtitle' => __('Do you want to display google map on contact page ?', 'framework'),
				        'default' => '1',
				        'on' => __('Display','framework'),
				        'off' => __('Hide','framework')
			        ),
			        array(
				        'id'=>'google_map_style',
				        'type' => 'button_set',
				        'title' => __('Google Map Style', 'framework'),
				        'options' => array(
					        '1' => __('Default','framework'),
					        '2' => __('Full Width ','framework'),
				        ),
				        'default' => '1',
				        'required'=> array('display_google_map', '=', '1'),
			        ),
			        array(
				        'id'=>'google_map_title',
				        'type' => 'text',
				        'title' => __('Google Map Title', 'framework'),
				        'required' => array(
					        array( 'display_google_map', '=', '1' ),
					        array( 'google_map_style', '=', '1' )
				        ),
			        ),
			        array(
				        'id'        => 'google_map_api_key',
				        'type'      => 'text',
				        'title'     => __( 'Google Map Api Key', 'framework' ),
				        'subtitle' => __( 'It\'s required.', 'framework' ),
				        'description' => __( 'Get your Google Map API Key by <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key">clicking here</a>.', 'framework' ),
				        'required'  => array( 'display_google_map', '=', '1' )
			        ),
			        array(
				        'id'=>'google_map_latitude',
				        'type' => 'text',
				        'title' => __('Google Map Latitude', 'framework'),
				        'desc' => 'Latitude and longitude of a point can be obtained from <a target="_blank" href="http://itouchmap.com/latlong.html">following site</a>.',
				        'required'  => array('display_google_map', '=', '1')
			        ),
			        array(
				        'id'=>'google_map_longitude',
				        'type' => 'text',
				        'title' => __('Google Map Longitude', 'framework'),
				        'required'  => array('display_google_map', '=', '1')
			        ),
			        array(
				        'id'=>'google_map_zoom',
				        'type' => 'text',
				        'validate'  => 'numeric',
				        'title' => __('Google Map Zoom', 'framework'),
				        'default'   => '14',
				        'required'  => array('display_google_map', '=', '1')
			        )
		        )
	        );


            /*----------------------------------------------------------------------*/
            /* Footer Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Footer', 'framework'),
                'desc' => __('This section contains footer related options.', 'framework'),
                'fields' => array(
	                array(
		                'id' => 'display_call_to_action',
		                'type' => 'switch',
		                'title' => __('Call to Action Section', 'framework'),
		                'subtitle' => __('Do you want to display call to action section above footer ?', 'framework'),
		                'default' => '1',
		                'on' => __('Display','framework'),
		                'off' => __('Hide','framework'),
		                'required' => array('inspiry_design_variation', '=', 'reborn')
	                ),
	                array(
		                'id'       => 'CTA_address_icon',
		                'type'     => 'media',
		                'url'      => false,
		                'title'    => __('Address Section Icon', 'framework'),
		                'subtitle' => __('Upload icon for address section.', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'=>'CTA_address',
		                'type' => 'text',
		                'title' => __('Address', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'       => 'CTA_number_icon',
		                'type'     => 'media',
		                'url'      => false,
		                'title'    => __('Number Section Icon', 'framework'),
		                'subtitle' => __('Upload icon for number section.', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'=>'CTA_number_title',
		                'type' => 'text',
		                'title' => __('Number Section Title', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'=>'CTA_number',
		                'type' => 'text',
		                'title' => __('Number', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'       => 'CTA_email_icon',
		                'type'     => 'media',
		                'url'      => false,
		                'title'    => __('Email Section Icon', 'framework'),
		                'subtitle' => __('Upload icon for email section.', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'=>'CTA_email_title',
		                'type' => 'text',
		                'title' => __('Email Section Title', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'=>'CTA_email',
		                'type' => 'text',
		                'title' => __('Email', 'framework'),
		                'validate'  => 'email',
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'       => 'CTA_appointment_icon',
		                'type'     => 'media',
		                'url'      => false,
		                'title'    => __('Appointment Section Icon', 'framework'),
		                'subtitle' => __('Upload icon for appointment section.', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'=>'CTA_appointment_title',
		                'type' => 'text',
		                'title' => __('Appointment Section Title', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'=>'CTA_appointment',
		                'type' => 'text',
		                'title' => __('Appointment Text', 'framework'),
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'       => 'CTA_appointment_page_url',
		                'type'     => 'select',
		                'data'     => 'pages',
		                'title'    => __( 'Appointment Page', 'framework' ),
		                'desc'      => 'Redirect user to appointment form page.',
		                'required' => array( array( 'display_call_to_action', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id' => 'footer_social_nav_title',
		                'type' => 'text',
		                'title' => __('Social Nav Title', 'framework'),
		                'required' => array('inspiry_design_variation', '=', 'reborn')
	                ),
	                array(
		                'id' => 'display_footer_social_icons',
		                'type' => 'switch',
		                'title' => __('Social Icons', 'framework'),
		                'subtitle' => __('Do you want to display social icons in footer ?', 'framework'),
		                'default' => '1',
		                'on' => __('Display','framework'),
		                'off' => __('Hide','framework')
	                ),
                    array(
                        'id'=>'footer_copyright',
                        'type' => 'text',
                        'title' => __('Copyright Text', 'framework')
                    ),
                ) );


            /*----------------------------------------------------------------------*/
            /* Styling Section
            /*----------------------------------------------------------------------*/
            $this->sections[] = array(
                'title' => __('Styling', 'framework'),
                'icon'      => 'el-icon-website',
                'desc' => __('This section contains styles related options.', 'framework'),
                'fields' => array(
                    array(
                        'id' => 'animation',
                        'type' => 'switch',
                        'title' => __('Animation?', 'framework'),
                        'subtitle' => __('Enable or Disable CSS3 animation on various components', 'framework'),
                        'default' => '1',
                        'on' => __('Enabled','framework'),
                        'off' => __('Disabled','framework')
                    ),
                    array(
                        'id' => 'want_to_change_fonts',
                        'type' => 'switch',
                        'title' => __('Do you want to change fonts?', 'framework'),
                        'default' => '0',
                        'on' => __('Yes','framework'),
                        'off' => __('No','framework')
                    ),
                    array(
                        'id'        => 'heading_font',
                        'type'      => 'typography',
                        'title'     => __('Heading Font', 'framework'),
                        'subtitle'  => __('Specify the font for headings.', 'framework'),
                        'desc'  => __('Raleway is default font.', 'framework'),
                        'required'  => array('want_to_change_fonts', '=', '1'),
                        'google'    => true,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'color'         => false,
                        'text-align'    => false,
                        'output'        => array( 'h1','h2','h3','h4','h5','h6' ),
                        'default'       => array(
                            'font-family' => 'Raleway',
                            'google'      => true
                        )
                    ),
                    array(
                        'id'        => 'body_font',
                        'type'      => 'typography',
                        'title'     => __('Text Font', 'framework'),
                        'subtitle'  => __('Specify the font for body text.', 'framework'),
                        'desc'  => __('Raleway is default font.', 'framework'),
                        'required'  => array('want_to_change_fonts', '=', '1'),
                        'google'    => true,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'color'         => false,
                        'text-align'    => false,
                        'output'        => array( 'body' ),
                        'default'       => array(
                            'font-family' => 'Raleway',
                            'google'      => true
                        )
                    ),
                    array(
                        'id'        => 'testimonials_font',
                        'type'      => 'typography',
                        'title'     => __('Testimonials Text Font', 'framework'),
                        'subtitle'  => __('Specify the font for testimonials and quotes text.', 'framework'),
                        'desc'      => __('Droid Serif is default font.', 'framework'),
                        'required' => array( array( 'want_to_change_fonts', '=', '1' ), array( 'inspiry_design_variation', '=', 'default' ) ),
                        'google'    => true,
                        'font-style'    => true,
                        'font-weight'   => true,
                        'font-size'     => false,
                        'line-height'   => false,
                        'color'         => false,
                        'text-align'    => false,
                        'output'        => array( '.entry-content blockquote p','.entry-content blockquote', '.home-testimonial blockquote p' ),
                        'default'       => array(
                            'font-family' => 'Droid Serif',
                            'font-style' => 'italic',
                            'font-weight' => '400',
                            'google'      => true
                        ),
                    ),
	                array(
		                'id' => 'want_to_change_theme_styling',
		                'type' => 'switch',
		                'title' => __('Do you want to change Theme Styling?', 'framework'),
		                'default' => '0',
		                'on' => __('Yes','framework'),
		                'off' => __('No','framework')
	                ),
	                array(
		                'id'        => 'body_background',
		                'type'      => 'background',
		                'output'    => array('body'),
		                'title'     => __('Body Background', 'framework'),
		                'subtitle'     => __('Configure body background of your choice. (default:#f0f5f7)', 'framework'),
		                'default'   => '#f0f5f7',
		                'required' => array( 'want_to_change_theme_styling', '=', '1' )
	                ),
	                array(
		                'id'        => 'overall_theme_color_one',
		                'type'      => 'color',
		                'transparent' => false,
		                'title'     => __('Overall Theme Color One', 'framework'),
		                'desc'  => 'default: #7ace4c',
		                'default'   => '#7ace4c',
		                'validate'  => 'color',
		                'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'        => 'overall_theme_color_reborn',
		                'type'      => 'color',
		                'transparent' => false,
		                'title'     => __('Overall Theme Color Two', 'framework'),
		                'desc'  => 'default: #007d9e',
		                'default'   => '#007d9e',
		                'validate'  => 'color',
		                'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
                    array(
                        'id'        => 'heading_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, h1 span, h2 span, h3 span, h4 span, h5 span, h6 span'),
                        'title'     => __('Heading Color', 'framework'),
                        'subtitle'     => __('Color for h1, h2, h3, h4, h5 and h6 tags', 'framework'),
                        'desc'  => 'default: #3a3c41',
                        'default'   => '#3a3c41',
                        'validate'  => 'color',
                        'required' => array( 'want_to_change_theme_styling', '=', '1' )
                    ),
                    array(
                        'id'        => 'text_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'output'    => array('body'),
                        'title'     => __('Text Color', 'framework'),
                        'desc'  => 'default: #7b7d85',
                        'default'   => '#7b7d85',
                        'validate'  => 'color',
                        'required' => array( 'want_to_change_theme_styling', '=', '1' )
                    ),
                    array(
                        'id'        => 'overall_link_color',
                        'type'      => 'link_color',
                        'title'     => __('Link Color', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#3a3c41',
                            'hover'     => '#f15b5a'
                        ),
                        'required' => array( 'want_to_change_theme_styling', '=', '1' )
                    ),
                    array(
                        'id'        => 'default_btn_bg',
                        'type'      => 'link_color',
                        'title'     => __('Default Button Background Color', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#3a3c41',
                            'hover'     => '#f15b5a'
                        ),
                        'required' => array( 'want_to_change_theme_styling', '=', '1' )
                    ),
                    array(
                        'id'        => 'default_btn_text_color',
                        'type'      => 'link_color',
                        'title'     => __('Default Button Text Color', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#ffffff'
                        ),
                        'required' => array( 'want_to_change_theme_styling', '=', '1' )
                    ),
                    array(
                        'id'        => 'read_more_btn_bg',
                        'type'      => 'link_color',
                        'title'     => __('Read More Button Background Color', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#67c9e0',
                            'hover'     => '#f15b5a'
                        ),
                        'required' => array( 'want_to_change_theme_styling', '=', '1' )
                    ),
                    array(
                        'id'        => 'read_more_btn_text_color',
                        'type'      => 'link_color',
                        'title'     => __('Read More Button Text Color', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#ffffff'
                        ),
                        'required' => array( 'want_to_change_theme_styling', '=', '1' )
                    ),
                    array(
                        'id'        => 'appo_form_heading_bg_color',
                        'type'      => 'link_color',
                        'transparent' => false,
                        'title'     => __('Appointment Form Heading Background', 'framework'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#3a3c41',
                            'hover'     => '#000'
                        ),
                        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
                    ),
                    array(
                        'id'        => 'appo_form_bg_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'title'     => __('Appointment Form Background', 'framework'),
                        'desc'  => 'default: #67c9e0',
                        'default'   => '#67c9e0',
                        'validate'  => 'color',
                         'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
                    ),
//                    array(
//                        'id'        => 'appo_fields_border_color',
//                        'type'      => 'color',
//                        'transparent' => false,
//                        'title'     => __('Appointment Form Fields Bottom Border', 'framework'),
//                        'desc'  => 'default: #adebfa',
//                        'default'   => '#adebfa',
//                        'validate'  => 'color',
//	                      'required' => array( 'want_to_change_theme_styling', '=', '1' )
//                    ),
                    array(
                        'id'        => 'appo_calendar_hover_color',
                        'type'      => 'color',
                        'transparent' => false,
                        'title'     => __('Appointment Form Calender Hover', 'framework'),
                        'desc'  => 'default: #3fa6be',
                        'default'   => '#3fa6be',
                        'validate'  => 'color',
                         'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
                    ),
	                array(
		                'id'        => 'banner_overlay_bg_color',
		                'type'      => 'color',
		                'transparent' => false,
		                'output'    => array(
			                'background-color' => '.banner-image-overlay',
		                ),
		                'title'     => __('Banner Overlay Background Color', 'framework'),
		                'desc'  => 'default: #007d9e',
		                'default'   => '#007d9e',
		                'validate'  => 'color',
		                'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'        => 'banner_title_color',
		                'type'      => 'color',
		                'transparent' => false,
		                'output'    => array('.page-title'),
		                'title'     => __('Banner Title Color', 'framework'),
		                'desc'  => 'default: #ffffff',
		                'default'   => '#ffffff',
		                'validate'  => 'color',
		                'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'        => 'breadcrumb_color',
		                'type'      => 'color',
		                'transparent' => false,
		                'output'    => array('.breadcrumb'),
		                'title'     => __('Breadcrumb Color', 'framework'),
		                'desc'  => 'default: #d5e4ea',
		                'default'   => '#d5e4ea',
		                'validate'  => 'color',
		                'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
	                array(
		                'id'        => 'breadcrumb_link_hover_color',
		                'type'      => 'color',
		                'transparent' => false,
		                'output'    => array('.breadcrumb a:hover'),
		                'title'     => __('Breadcrumb Link Hover Color', 'framework'),
		                'desc'  => 'default: #ffffff',
		                'default'   => '#ffffff',
		                'validate'  => 'color',
		                'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
	                ),
                )
            );

	        /*----------------------------------------------------------------------*/
	        /* Header Styling Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Header', 'framework'),
		        'subsection' => true,
		        'desc' => __('This section contains styling options for header', 'framework'),
		        'fields' => array(
			        array(
				        'id'        => 'theme_styling_info_notice_1',
				        'type'      => 'info',
				        'notice'    => true,
				        'style'     => 'info',
				        'title'     => __('Header Styling', 'framework'),
				        'desc'      => 'To change header styling, set the option "Do you want to change Theme Styling?" to Yes from Theme Options > Styling section.',
				        'required' => array( 'want_to_change_theme_styling', '=', '0' )
			        ),
			        array(
				        'id'        => 'header_top_background',
				        'type'      => 'color',
				        'mode'      => 'background-color',
				        'output'    => array('.header-top'),
				        'title'     => __('Header Top Bar Background', 'framework'),
				        'desc'     => 'default: #60646d',
				        'default'   => '#60646d',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'header_top_text_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('.header-top p'),
				        'title'     => __('Header Top Bar Text Color', 'framework'),
				        'desc'  => 'default: #bbbfc9',
				        'default'   => '#bbbfc9',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'header_top_text_highlight_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('.header-top p span'),
				        'title'     => __('Header Top Bar Text Highlight Color', 'framework'),
				        'desc'  => 'default: #fefefe',
				        'default'   => '#fefefe',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'header_background',
				        'type'      => 'color',
				        'mode'      => 'background-color',
				        'output'    => array('#header, .site-header'),
				        'title'     => __('Header Background Color', 'framework'),
				        'desc'     => 'default: #ffffff',
				        'default'   => '#ffffff',
				        'required' => array( 'want_to_change_theme_styling', '=', '1' )
			        ),
			        array(
				        'id'        => 'header_nav_text_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('nav.main-menu ul > li > a'),
				        'title'     => __('Main Navigation Text Color', 'framework'),
				        'desc'  => 'default: #60646d',
				        'default'   => '#60646d',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'header_nav_hover_bg_color',
				        'type'      => 'color',
				        'mode'      => 'background-color',
				        'output'    => array('nav.main-menu ul > li:hover > a, nav.main-menu ul > .current-menu-item > a, nav.main-menu ul > li ul'),
				        'title'     => __('Main Navigation Hover Background Color', 'framework'),
				        'desc'  => 'default: #67c9e0',
				        'default'   => '#67c9e0',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'header_nav_hover_text_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('nav.main-menu ul > li:hover > a, nav.main-menu ul > .current-menu-item > a, nav.main-menu ul > li ul li a'),
				        'title'     => __('Main Navigation Hover Text Color', 'framework'),
				        'desc'  => 'default: #ffffff',
				        'default'   => '#ffffff',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'header_nav_dropdown_hover_bg_color',
				        'type'      => 'color',
				        'mode'      => 'background-color',
				        'output'    => array('nav.main-menu ul > li ul li:hover a'),
				        'title'     => __('Main Navigation Drop Down Hover Background Color', 'framework'),
				        'desc'  => 'default: #53c3dd',
				        'default'   => '#53c3dd',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'header_nav_border_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'title'     => __('Main Navigation Drop Down Border Color', 'framework'),
				        'desc'  => 'default: #73d1e7',
				        'default'   => '#73d1e7',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'responsive_menu_text_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'color' => '.mean-container .mean-nav ul li a, .mean-container a.meanmenu-reveal',
					        'background-color' => '.mean-container a.meanmenu-reveal span',
				        ),
				        'title'     => __('Responsive Menu Text Color', 'framework'),
				        'desc'     => 'default: #ffffff',
				        'default'   => '#ffffff',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'responsive_menu_bar_bg_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'title'     => __('Responsive Menu Bar Background', 'framework'),
				        'desc'     => 'Only used below 530px screen width. default: #53c3dd',
				        'default'   => '#53c3dd',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'responsive_menu_bg_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'background-color' => '.mean-container .mean-bar a.meanmenu-reveal, .mean-container .mean-bar .mean-nav',
				        ),
				        'title'     => __('Responsive Menu Overall Background', 'framework'),
				        'desc'     => 'default: #67c9e0',
				        'default'   => '#67c9e0',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'responsive_menu_border_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'border-color' => '.mean-container .mean-bar .mean-nav ul li a',
				        ),
				        'title'     => __('Responsive Menu Border Color', 'framework'),
				        'desc'     => 'default: #73d1e7',
				        'default'   => '#73d1e7',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'page_top_background',
				        'type'      => 'color',
				        'mode'      => 'background-color',
				        'output'    => array('.page-top'),
				        'title'     => __('Page Top Area Background Color', 'framework'),
				        'subtitle'     => __('Page top area exists below banner image and above page contents.', 'framework'),
				        'desc'     => 'default: #ffffff',
				        'default'   => '#ffffff',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'header_top_bottom_border_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'border-bottom-color' => '.site-header-top',
				        ),
				        'title'     => __('Header Top Border Bottom Color', 'framework'),
				        'desc'     => 'default: #ecf1f2',
				        'default'   => '#ecf1f2',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'header_text_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('.opening-hours-label, .header-social-nav a, .header-address address, .header-contact-number small, .tag-line'),
				        'title'     => __('Header Text Color', 'framework'),
				        'desc'  => 'default: #bbbfc9',
				        'default'   => '#bbbfc9',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'header_text_highlight_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('.opening-hours-content'),
				        'title'     => __('Header Highlight Text Color', 'framework'),
				        'desc'  => 'default: #2f3d4a',
				        'default'   => '#2f3d4a',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'header_contact_number_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('.header-contact-number > span, .header-contact-number > a'),
				        'title'     => __('Header Contact Number Text Color', 'framework'),
				        'desc'  => 'default: #007d9e',
				        'default'   => '#007d9e',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
                    array(
	                    'id'        => 'main_menu_text_color',
	                    'type'      => 'color',
	                    'transparent' => false,
	                    'output'    => array(
		                    'color' => '.main-navigation a',
	                    ),
	                    'title'     => __('Main Menu Text Color', 'framework'),
	                    'desc'     => 'default: #7d98ad',
	                    'default'   => '#7d98ad',
	                    'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
                    ),
			        array(
				        'id'        => 'main_menu_current_item_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'color' => '.main-navigation .main-menu > li.current-menu-item > a',
				        ),
				        'title'     => __('Main Menu Active Text Color', 'framework'),
				        'desc'     => 'default: #2f3d4a',
				        'default'   => '#2f3d4a',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'main_menu_item_hover_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'color' => '.main-navigation .main-menu > li:hover > a, .mean-container a.meanmenu-reveal',
				        ),
				        'title'     => __('Main Menu Hover Text Color', 'framework'),
				        'desc'     => 'default: #ffffff',
				        'default'   => '#ffffff',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'main_menu_item_hover_bg_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'background-color' => '.main-navigation .main-menu > li:hover > a, .main-navigation .sub-menu, .mean-container a.meanmenu-reveal, .mean-container .mean-nav',
				        ),
				        'title'     => __('Main Menu Hover Background Color', 'framework'),
				        'desc'     => 'default: #7ace4c',
				        'default'   => '#7ace4c',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'main_menu_dropdown_bg_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'background-color' => '.main-navigation .sub-menu a:hover, .mean-container .mean-nav ul li a.mean-expand',
				        ),
				        'title'     => __('Sub Menu Item Hover Background Color', 'framework'),
				        'desc'     => 'default: #60b532',
				        'default'   => '#60b532',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'appointment_button_bg_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'background-color' => '.header-appointment-button',
				        ),
				        'title'     => __('Appointment Button Background Color', 'framework'),
				        'desc'     => 'default: #7ace4c',
				        'default'   => '#7ace4c',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'appointment_button_bg_hover_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'background-color' => '.header-appointment-button:hover',
				        ),
				        'title'     => __('Appointment Button Hover Background Color', 'framework'),
				        'desc'     => 'default: #60b532',
				        'default'   => '#60b532',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
		        )
	        );


	        /*----------------------------------------------------------------------*/
	        /* Footer Styling Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Footer', 'framework'),
		        'subsection' => true,
		        'desc' => __('This section contains styling options for footer', 'framework'),
		        'fields' => array(
			        array(
				        'id'        => 'theme_styling_info_notice_2',
				        'type'      => 'info',
				        'notice'    => true,
				        'style'     => 'info',
				        'title'     => __('Footer Styling', 'framework'),
				        'desc'      => 'To change footer styling, set the option "Do you want to change Theme Styling?" to Yes from Theme Options > Styling section.',
				        'required' => array( 'want_to_change_theme_styling', '=', '0' )
			        ),
			        array(
				        'id'        => 'footer_cta_gradient_color_one',
				        'type'      => 'color',
				        'transparent' => false,
				        'title'     => __('Call to Action Gradient Color One', 'framework'),
				        'desc'     => 'default: #7ace4c',
				        'default'   => '#7ace4c',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'footer_cta_gradient_color_two',
				        'type'      => 'color',
				        'transparent' => false,
				        'title'     => __('Call to Action Gradient Color Two', 'framework'),
				        'desc'     => 'default: #017e9d',
				        'default'   => '#017e9d',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'footer_cta_text_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'color' => '.call-to-action',
				        ),
				        'title'     => __('Call to Action Text Color', 'framework'),
				        'desc'     => 'default: #ffffff',
				        'default'   => '#ffffff',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'footer_cta_text_link_hover_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array(
					        'color' => '.call-to-action a:hover',
				        ),
				        'title'     => __('Call to Action Link Hover Color', 'framework'),
				        'desc'     => 'default: #ffffff',
				        'default'   => '#ffffff',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'footer_background',
				        'type'      => 'color',
				        'mode'      => 'background-color',
				        'output'    => array('#main-footer, .site-footer'),
				        'title'     => __('Footer Background Color', 'framework'),
				        'desc'     => 'default: #3a3c41',
				        'default'   => '#3a3c41',
				        'validate'  => 'color',
				        'required' => array( 'want_to_change_theme_styling', '=', '1' )
			        ),
			        array(
				        'id'        => 'footer_text_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('#main-footer, .site-footer'),
				        'title'     => __('Footer Text Color', 'framework'),
				        'desc'  => 'default: #9ba0aa',
				        'default'   => '#9ba0aa',
				        'validate'  => 'color',
				        'required' => array( 'want_to_change_theme_styling', '=', '1' )
			        ),
			        array(
				        'id'        => 'footer_link_color',
				        'type'      => 'link_color',
				        'title'     => __('Footer Link Color', 'framework'),
				        'default'   => array(
					        'regular'   => '#b5bac6',
					        'hover'     => '#cbd1de',
					        'active'    => '#cbd1de'
				        ),
				        'required' => array( 'want_to_change_theme_styling', '=', '1' )
			        ),
			        array(
				        'id'        => 'footer_widget_title_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('#main-footer .widget h3.title, .site-footer .title, .footer-social-nav-title'),
				        'title'     => __('Footer Widget Title Color', 'framework'),
				        'desc'  => 'default: #f0f5f7',
				        'default'   => '#f0f5f7',
				        'validate'  => 'color',
				        'required' => array( 'want_to_change_theme_styling', '=', '1' )
			        ),
			        array(
				        'id'        => 'footer_bottom_background_color',
				        'type'      => 'color',
				        'mode'      => 'background-color',
				        'output'    => array('.site-footer-bottom'),
				        'title'     => __('Footer Bottom Background Color', 'framework'),
				        'desc'     => 'default: #262d33',
				        'default'   => '#262d33',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'footer_bottom_text_color',
				        'type'      => 'color',
				        'output'    => array('.site-footer-bottom'),
				        'title'     => __('Footer Bottom Text Color', 'framework'),
				        'desc'     => 'default: #798693',
				        'default'   => '#798693',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'reborn') )
			        ),
			        array(
				        'id'        => 'footer_border_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'title'     => __('Borders Color in Footer', 'framework'),
				        'desc'  => 'default: #4a4c52',
				        'default'   => '#4a4c52',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
			        array(
				        'id'        => 'footer_copyright_text_color',
				        'type'      => 'color',
				        'transparent' => false,
				        'output'    => array('.footer-bottom p'),
				        'title'     => __('Footer Copyright Text Color', 'framework'),
				        'desc'  => 'default: #7a7d86',
				        'default'   => '#7a7d86',
				        'validate'  => 'color',
				        'required' => array( array( 'want_to_change_theme_styling', '=', '1' ), array('inspiry_design_variation', '=', 'default') )
			        ),
		        )
            );


	        /*----------------------------------------------------------------------*/
	        /* Quick CSS Section
			/*----------------------------------------------------------------------*/
	        $this->sections[] = array(
		        'title' => __('Quick CSS', 'framework'),
		        'desc' => __('This section contains options related to css. If you need to change major portions of the theme please use the custom.css file in css folder. In case you are using child theme then please use child-custom.css file in child theme.', 'framework'),
		        'subsection' => true,
		        'fields' => array(
			        array(
				        'id'        => 'quick_css',
				        'type'      => 'ace_editor',
				        'title'     => __('Quick CSS', 'framework'),
				        'desc'      => __('Just want to do some quick CSS changes? Enter them here, they will be applied to the theme.', 'framework'),
				        'mode'      => 'css',
				        'theme'     => 'monokai'
			        )
		        )
	        );


            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'framework'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'framework'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'framework')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'framework'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'framework')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'framework');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array (
                'opt_name' => 'redux_demo',
                'global_variable' => 'theme_options',
                'admin_bar' => '1',
                'allow_sub_menu' => '1',
                'default_mark' => '*',
                'google_api_key' => 'AIzaSyDGNqc0QLD7SceugylqYVWcik-hGVxlnAs',
                'hint-icon' => 'el-icon-question-sign',
                'icon_position' => 'right',
                'icon_size' => 'normal',
                'tip_style_color' => 'light',
                'tip_position_my' => 'top left',
                'tip_position_at' => 'bottom right',
                'tip_show_duration' => '500',
                'tip_show_event' => 
                array (
                  0 => 'mouseover',
                ),
                'tip_hide_duration' => '500',
                'tip_hide_event' => 
                array (
                  0 => 'mouseleave',
                  1 => 'unfocus',
                ),
                'menu_title' => 'Theme Options',
                'menu_type' => 'menu',
                'output' => '1',
                'output_tag' => '1',
                'page_icon' => 'icon-themes',
                'page_parent_post_type' => 'your_post_type',
                'page_permissions' => 'manage_options',
                'page_slug' => '_options',
                'page_title' => 'Theme Options',
                'save_defaults' => '1',
                'show_import_export' => '1',
                'forced_dev_mode_off' => true,
                'show_options_object' => false
            );

            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"] = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Medical_Theme_Redux_Framework_Config();
}

/**
 * Custom function for the callback referenced above
 */
if (!function_exists('redux_demo_my_custom_field')):
    function redux_demo_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
 * Custom function for the callback validation referenced above
 */
if (!function_exists('redux_demo_validate_callback_function')):
    function redux_demo_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;

if ( ! function_exists( 'redux_update_notifications_dismissal' ) ):
	function redux_update_notifications_dismissal() {
		echo "<style>.rAds,.redux-message.updated { display: none !important; }</style>";
	}

	add_action( 'admin_head', 'redux_update_notifications_dismissal' );
endif;