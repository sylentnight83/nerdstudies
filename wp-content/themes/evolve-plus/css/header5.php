<?php
$evolve_css_data = '';
$evolve_header_background_opacity = evolve_get_option('evl_header_background_opacity', '0.8');
$evolve_social_color = evolve_get_option('evl_social_color_scheme', '#999999');
/* WooCommerce Menu */

$evolve_css_data .= '
.sc_menu li {
    float: none;
}
.title-container #logo a {
    padding: 0px;
}
.title-container #logo {
    float: none;
}
.searchform {
  float: left;
}
.icos-right {
  float: right;
  padding-top: 5px;
}
.woocommerce-menu .cart > a:hover,
.woocommerce-menu .my-account> a:hover {
     border:1px solid '. $evolve_top_menu_hover_font_color .';  
     color:'. $evolve_top_menu_hover_font_color .' !important;
}
.header .woocommerce-menu {
	margin-right: 0px;
	margin-top:5px;
}
#social {
  float: left;
  margin-top: 10px;
}
.woocommerce-menu .cart > a,.woocommerce-menu .my-account > a{
color: ' . $evolve_social_color . ' !important;
border: 1px solid ' . $evolve_social_color . ' ;
height: 35px;
}
#search-text-top,#search-text-box #search_label_top::after{
color: ' . $evolve_social_color . ' !important;
border-color: ' . $evolve_social_color . ' !important;
}

#search-text-box #search_label_top{
    top: 5px;
}
#search-text-box #search_label_top::after {
  border-radius: 3px;
  color: rgb(255, 255, 255);
  content: "\e91e";
  cursor: pointer;
  font-family: icomoon;
  font-size: 18px !important;
  font-weight: normal;
  position: absolute;
  right: 33px;
  text-align: center;
  top: 5px;
}
#search-text-top {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: 1px solid rgb(255, 255, 255);
  /*box-shadow: none;*/
  float: right !important;
  line-height: 35px;  
  padding: 0;
  height: 35px;
  width: 40px;
}
.woocommerce-menu .cart > a {
  border-radius: 3px;
  display: block;
  font-size: 0 !important;  
  padding: 4px !important;
  text-align: center;
  width: 40px;
}
.woocommerce-menu .my-account> a {
  border-radius: 3px;
  display: block;
  font-size: 0 !important;  
  padding: 4px !important;
  text-align: center;
  width: 40px;
}
.header .woocommerce-menu .cart > a::before {
  font-size: 18px;
  margin-right:-5px;
}
.header .woocommerce-menu .my-account> a::before {
  font-size: 18px;
  margin-right:-9px;
}
div#search-text-box {
  margin-right: 0;
  width: 100%;
}

.my-account-link {
  font-size: 0 !important;
}
.my-account-link i {
  border: 1px solid rgb(255, 255, 255);
  border-radius: 3px;
  color: rgb(255, 255, 255);
  display: block;
  font-size: 20px;
  padding: 7px !important;
  text-align: center;
  width: 40px;
}
.header .woocommerce-menu li {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
}
.woocommerce-menu-holder {
  float: left;
}
.woocommerce-menu .cart-checkout a {
  display: inline-block;
  float: left;
  padding: 15px 0 !important;
  text-indent: 10px;
  width: 50%;
  text-indent: 13px;
}
ul.nav-menu li:hover{
    background: none;
}
.primary-menu{
    text-align: center;
}
.link-effect .sub-menu a span{
    text-align:left;
}
ul.nav-menu li:first-child .slash{
	display:none;
}
ul.nav-menu li ul li .slash{
	display:none;
}
.sc_menu a.tipsytext:hover{
        color: '.$evolve_top_menu_hover_font_color.' !important;
}

@media (max-width: 768px){
ul.nav-menu ul.sub-menu .sf-with-ul:after {
	top: 11px;
}
}

@media only screen and (max-width: 768px) {
    #social {
  float: none;
}
    .sc_menu{
        float: none;
        margin-bottom: 10px;
    }
    .sc_menu li {
        float: none;
        margin: 0 5px;
    }
    .woocommerce-menu-holder {
        float: left;
        text-align: center;
        width: 100%;
    }
    #search-text-top {
        display: block;
        margin-right: 0;
        text-indent: 1px !important;
        width: 170px;
    }
    #search-text-top{
		box-shadow: none;
		background-color: #fff;
		border: 1px solid rgba(0, 0, 0, .1);
		font-size: 12px;
		width: 170px;
		border-radius: 3px;
		z-index: 0;
		font-weight: normal;
		position: relative;
		left: 0px;
		height: 35px;
		padding: 5px 40px 5px 7px;
    }
    .icos-right {
        float: none;    
    }
    .searchform {
        float: left;
        width: 100%;
    }
    .sc_menu li a{
	margin: 0px;

    }    
    #search_label_top::after {
        right: 18px !important;
        top: 4px !important;
    }
}
@media only screen and (min-width: 769px) {
    .primary-menu .nav{display: inline-block;}
    .woocommerce-menu li > a {
        margin: 0 0 1px;
    }
    .header .woocommerce-menu li:first-child {
       margin: 0 20px 0 10px;
    }
.my-account ul li{
        margin:0px !important;
}
}
';

if (is_front_page()) {
    $rgbcode = evolve_hex2rgb($evolve_menu_back_color);
    $header_pattern = $rgbcode[0] . ',' . $rgbcode[1] . ',' . $rgbcode[2] . ',' . $evolve_header_background_opacity;

    $evolve_css_data .= '@media only screen and (min-width: 769px) {
.menu-container .menu-header {
                            background: rgba(' . $header_pattern . ') none repeat scroll 0 0 !important;
                            position: absolute;
                            z-index:2;
                            width:100%;
                        }
                        } ';
}

global $evl_options;
$options = $evl_options;
if ($options['evl_menu_font']['color'] != '') {
    $color = $options['evl_menu_font']['color'];
    
    $evolve_css_data .= 'ul.nav-menu li .slash{
							position: absolute;
							top: 34%;
							left: -5px;
							color: '.$color.' !important;
						}
						ul.nav-menu li:hover .slash{
							color: '.$color.' !important;
						}';
}