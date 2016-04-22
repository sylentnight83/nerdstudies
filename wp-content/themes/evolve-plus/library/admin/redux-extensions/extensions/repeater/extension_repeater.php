<?php

    /**
     * Redux Framework is free software: you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation, either version 2 of the License, or
     * any later version.
     * Redux Framework is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     * GNU General Public License for more details.
     * You should have received a copy of the GNU General Public License
     * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
     *
     * @package     Redux Framework
     * @subpackage  Repeater
     * @subpackage  Wordpress
     * @author      Dovy Paukstys (dovy)
     * @author      Kevin Provance (kprovance)
     * @version     1.2.0
     */

    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // Don't duplicate me!
    if ( ! class_exists( 'ReduxFramework_extension_repeater' ) ) {


        /**
         * Main ReduxFramework css_layout extension class
         *
         * @since       1.0.0
         */
        class ReduxFramework_extension_repeater {

            public static $version = '1.2.0';

            // Protected vars
            protected $parent;
            public $extension_url;
            public $extension_dir;
            public static $theInstance;
            public $field_id = '';
            private $class_css = '';

            /**
             * Class Constructor. Defines the args for the extions class
             *
             * @since       1.0.0
             * @access      public
             *
             * @param       array $parent Parent settings.
             *
             * @return      void
             */
            public function __construct( $parent ) {

                $redux_ver = ReduxFramework::$_version;

                // Set parent object
                $this->parent = $parent;

                // Set extension dir
                if ( empty( $this->_extension_dir ) ) {
                    $this->_extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                    $this->_extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->_extension_dir ) );
                }

                // Set field name
                $this->field_name = 'repeater';

                // Set instance
                self::$theInstance = $this;

                // Adds the local field
                add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array(
                    &$this,
                    'overload_field_path'
                ) );

                add_filter( "redux/{$this->parent->args['opt_name']}/field/{$this->field_name}/defaults", array(
                    $this,
                    'set_defaults'
                ), 10, 3 );

            }

            static public function getInstance() {
                return self::$theInstance;
            }

            // Forces the use of the embeded field path vs what the core typically would use
            public function overload_field_path( $field ) {
                return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
            }

            public function set_defaults( $defaults = array(), $field ) {

                if ( isset( $field['group_values'] ) && $field['group_values'] ) {
                    $data = array();
                    foreach ( $defaults as $key => $value ) {
                        foreach ( $value as $k => $v ) {
                            if ( ! isset( $data[ $k ] ) ) {
                                $data[ $k ] = array();
                            }
                            $data[ $k ][ $key ] = $v;
                        }
                    }
                    $count = 0;
                    foreach ( $data as $key => $value ) {
                        if ( count( $value ) > $count ) {
                            $count = count( $value );
                        }
                    }

                    $data['redux_repeater_data'] = array();
                    for ( $i = 0; $i < $count; $i ++ ) {
                        $data['redux_repeater_data'][] = array( 'title' => '' );
                    }
                    $defaults = $data;
                }

                //print_r($field);
                //exit();

                return $defaults;
            }


        } // class
    } // if
