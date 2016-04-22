<?php
if ( ! class_exists( 'Wp_Theme_Update_Manager' ) ) 
{
	class Wp_Theme_Update_Manager 
	{	
		private $api_endpoint; 
		private $theme_name; 
		private $username; 
		private $password; 
		private $text_domain; 
		private $product_name; 
		private $product_id; 

		public function __construct( $themename,$api_url ) 
		{   
			$this->theme_name = $themename;        
			$this->api_endpoint = $api_url;        			
			add_action( 'admin_menu', array( $this, 'add_update_settings_page' ) );
			add_action( 'admin_init', array( $this, 'add_update_settings_fields' ) );
			add_action( 'admin_notices', array( $this, 'show_admin_notices' ) );			
			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_for_update' ) );	

		}	
		public function check_for_update( $transient ) 
		{			
			if ( empty( $transient->checked ) ) 
			{
				return $transient;
			}
			
			$info = $this->is_update_available();	
			
			if ( $info !== false ) 
			{
				$theme_data = wp_get_theme();
				$theme_slug = $theme_data->get_template();
				$transient->response[$theme_slug] = array(
					'new_version' => $info->version,
					'package' => $info->package_url,
					'url' => $info->description_url
				);        
			}
			return $transient;
		}
		public function is_update_available() 
		{
			$update_info = $this->get_update_info();
			
			if ( $this->is_api_error( $update_info ) ) 
			{
				return false;
			}
			if ( version_compare( $update_info->version, $this->get_local_version(), '>' ) ) 
			{
				return $update_info;
			}
			return false;
		}

		public function get_update_info() 
		{
			$options = get_option( $this->get_settings_field_name() );
			
			if ( ! isset( $options['username'] ) && !isset($options['password']) ) 
			{       
				return false;
			}		 
			$info = $this->call_api(array('username' =>  $options['username'],'password' =>  $options['password'] ,"theme"=>$this->theme_name));					
			return $info;
		}
		private function call_api( $params ) 
		{
			$url = $this->api_endpoint ;
			$url .= '?' . http_build_query( $params );
			$response = wp_remote_get( $url );
			
			if ( is_wp_error( $response ) ) 
			{
                $errobj = (object) array('status' => 'fail', 'errormsg'=>'Can\'t connect to theme4press.com : '.$response->get_error_message() );
                return $errobj;
				//return false;
			}
			$response_body = wp_remote_retrieve_body( $response );
			$result = json_decode( $response_body );   
			
			return $result;
		}
		private function get_local_version() 
		{
			$theme_data = wp_get_theme();
			return $theme_data->Version;
		}
		protected function get_settings_field_name() 
		{
			return $this->product_id . '-update-settings';
		}
		private function is_api_error( $response ) 
		{
			if ( $response === false ) 
			{
				return true;
			}
		 
			if ( ! is_object( $response ) )
			{
				return true;
			}
		 
			if ( $response->status == 'ok' )
			{
				return false;
			}	 
			return true;
		}
		
		public function add_update_settings_page() 
		{
			$title = sprintf( __( '%s Theme Update', 'evolve' ), $this->product_name );
			add_submenu_page('themes.php','Theme Updates', 'Theme Updates', 'manage_options','t4p-theme-updates', array( $this, 'render_update_menu' )); 
		}

        function validateOption( $input ) {
            //$options = get_option( $this->get_settings_field_name() );


            if (empty ($input['username'])){
                add_settings_error(  $this->get_settings_field_name(), 'invalid-username', __('Please enter your Theme4Press account username', 'evolve') );
            } else {
                //$options['username'] = $input['username'];
            }

            if (empty ($input['password'])){
                add_settings_error(  $this->get_settings_field_name(), 'invalid-password', __('Please enter your Theme4Press account password', 'evolve') );
            } else {
                //$options['password'] = $input['password'];
            }

            if (!empty($input['username']) && !empty($input['password'])){

                $info = $this->call_api(array('username' =>  $input['username'],'password' =>  $input['password'] ,"theme"=>$this->theme_name));
                if ($info->status == 'fail'){
                    add_settings_error(  $this->get_settings_field_name(), 'invalid-logins', $info->errormsg );
                } else {
                    set_transient('Theme4press_ok', 'yes', MINUTE_IN_SECONDS );
                }
            }


            //return the inputed one
            return $input;
        }

		public function add_update_settings_fields() 
		{
			$settings_group_id = $this->product_id . '-update-settings-group';
			$settings_section_id = $this->product_id . '-update-settings-section'; 
			register_setting( $settings_group_id, $this->get_settings_field_name() , array( $this,'validateOption' ));
 
			add_settings_section($settings_section_id,  __( 'Insert your Theme4Press username and password details to enable theme update notifications.', 'evolve' ), array( $this,'render_settings_section' ),$settings_group_id);
 
			add_settings_field($this->product_id . '-update-username',  __( 'Username', 'evolve' ), array( $this, 'render_username_settings_field' ), $settings_group_id, $settings_section_id);
			
			add_settings_field($this->product_id . '-update-password',  __( 'Password', 'evolve' ), array( $this, 'render_password_settings_field' ), $settings_group_id, $settings_section_id);
		}
		
		public function render_settings_section() 
		{
			
		}
		
		public function render_update_menu() 
		{
			$title = sprintf( __( '%s Theme Update', 'evolve' ), $this->product_name );
			$settings_group_id = $this->product_id . '-update-settings-group';



            if (get_transient('Theme4press_ok') === 'yes'){
                ?>
                <div id="theme-message" class="updated fade">
                <p><strong>Username and password are correct.</strong> You will be notified when new update is available.</p>
                </div>
                <script>
                    jQuery(document).ready(function(){
                        jQuery('div.fade').delay(5000).fadeOut( 1000);
                    })
                </script>
                <?php
                delete_transient('Theme4press_ok');
            }
?>




			<div class="wrap">
				<form action='options.php' method='post'> 
                <h2><?php echo $title; ?></h2> 
<?php
                    settings_fields( $settings_group_id );
                    do_settings_sections( $settings_group_id );
                    submit_button();
?> 
				</form>
			</div>
<?php
		}
		public function render_username_settings_field() 
		{
			$settings_field_name = $this->get_settings_field_name();
			$options = get_option( $settings_field_name );
?>
			<input type='text' name='<?php echo $settings_field_name; ?>[username]' value='<?php echo $options['username']; ?>' class='regular-text'>
<?php
		}
		
		public function render_password_settings_field() 
		{
			$settings_field_name = $this->get_settings_field_name();
			$options = get_option( $settings_field_name );
?>
			<input type='password' name='<?php echo $settings_field_name; ?>[password]' value='<?php echo $options['password']; ?>' class='regular-text'>
<?php
		}
		
		public function get_settings_page_slug() 
		{
			return 't4p-theme-updates'; // $this->product_id . '-updates';
		}
		public function show_admin_notices() 
		{
            settings_errors(  $this->get_settings_field_name()  );

			$options = get_option( $this->get_settings_field_name() );
 
			if ( !$options || ! isset( $options['username'] ) ||  $options['username'] == ''  ||  ! isset( $options['password'] ) ||  $options['password'] == '' ) 
			{
				$msg = __( 'Please enter your username and password to enable updates to %s.', 'evolve' );
				$msg = sprintf( $msg, $this->theme_name );
?>
				<div class="update-nag">
					<p><?php echo $msg; ?></p> 
					<p>
						<a href="<?php echo admin_url( 'themes.php?page=t4p-theme-updates' ); ?>">
                        <?php _e( 'Complete the setup now.', 'evolve' ); ?></a>
					</p>
				</div>
<?php
			}
		}
	}
}
 
