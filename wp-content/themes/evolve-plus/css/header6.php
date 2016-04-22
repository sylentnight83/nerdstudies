<?php
global $evl_options;
$options = $evl_options;
    
$evolve_css_data = '';

/* WooCommerce Menu */
$evolve_css_data .= '
.header .woocommerce-menu {
	margin-right: 0;
}
.title-container #logo a {
	padding: 0px;
}
div#search-text-box{
    margin: 0px;
}
.searchform {
    float: right;
    clear: none;
}
#search-text-box #search_label_top .srch-btn{
        width:182px;
}
#search-text-box #search_label_top .srch-btn::before {
	color: #273039;
	content: "\f0d9";
	cursor: pointer;
	font-family: icomoon;
	font-size: 18px !important;
	font-weight: normal;
	position: absolute;
	right: 47px !important;
	text-align: center;
	top: -5px !important;
	width: 3px;
}
#search-text-box #search_label_top .srch-btn::after {
	background: #273039 none repeat scroll 0 0;
	border-radius: 3px;
	color:  '. $evolve_top_menu_hover_font_color .';
	content: "\e91e";
	cursor: pointer;
	font-family: icomoon;
	font-size: 18px !important;
	font-weight: normal;
	line-height: 35px;
	position: absolute;
	right: 7px !important;
	text-align: center;
	top: -10px !important;
	width: 38px;
}

#search-text-top {
  background: #fff none repeat scroll 0 0 !important;
  border: 1px solid #273039 !important;
  border-radius: 4px !important;
  /*box-shadow: 0 2px 5px #b5e9e0 inset;*/
  color: #757575 !important;
  float: right !important;
  font-family: Roboto !important;
  font-size: 14px;
  font-weight: 500;
  height: 35px;
  padding: 0 0 0 10px !important;
  position: relative;
  text-indent: 1px !important;
  transition: all 0.5s ease 0s;
  width: 170px !important;
}
.woocommerce-menu-holder{
    float: left;
    margin-top: 7px;
}
.top-menu-social {
    margin: 14px 0 0px; 
}
.header .woocommerce-menu li {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  margin-right: 20px;
}
.header .woocommerce-menu .cart-contents{
    right: auto;
}

.woocommerce-menu .my-account .fa-user{ height: 17px;}

.link-effect a{
	line-height: 2.5 !important;
}
@media (max-width: 768px) {
    #search-text-box {
            float: none;
            margin-bottom: 10px;
    }
    .title-container #logo a {
            padding: 0px;
    }
    .sc_menu{
        float: none;
        margin-bottom: 10px;
        text-align: center;
    }
    .woocommerce-menu-holder{
        float: none;
        margin: 0 0 10px 0;
    }
    .searchform {
        float: none;
        margin: 10px 0 0;
    }
}
ul.nav-menu > li.current-menu-item, 
ul.nav-menu > li.current-menu-ancestor,
ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a, 
ul.nav-menu li > li.current-menu-ancestor a,
ul.nav-menu li.current-menu-ancestor li.current-menu-item > a {
	background: '.$evolve_top_menu_hover_color.' none repeat scroll 0 0;
}

ul.nav-menu li.current-menu-item, 
ul.nav-menu li.current-menu-ancestor, 
ul.nav-menu li:hover {
	 background: '.$evolve_top_menu_hover_color.' none repeat scroll 0 0;
}

';

if ($options['evl_menu_font']['color'] != '') {
    $color = $options['evl_menu_font']['color'];
    
    $evolve_css_data .= '
                        .woocommerce-menu .cart>a:hover,
                        .woocommerce-menu .my-account-link:hover{ 
                            border:1px solid '. $evolve_top_menu_hover_font_color .' !important;  
                            color:'. $evolve_top_menu_hover_font_color .' !important;
                        }';
}
if ($options['evl_tagline_font']['color'] != '') {
    $color = $options['evl_tagline_font']['color'];
    
 $evolve_css_data .= '.woocommerce-menu .cart > a, 
                         .woocommerce-menu .my-account > a{
                          border: 1px solid '. $color .';
                          border-radius: 3px;
                          color: '. $color .' !important;
                          font-weight: 500 !important;
                          margin-bottom: 2px;
                          padding: 7px 15px !important;
                        }';
}
