<?php
$evolve_css_data = '';
$evolve_header_background_opacity = evolve_get_option('evl_header_background_opacity', '0.8');

/* WooCommerce Menu */
$evolve_css_data .= '
.woocommerce-menu,
.woocommerce-menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative;
    z-index: 3;
}

.woocommerce-menu {
    float: right;
    margin-right: 20px;
}

.woocommerce-menu li {
    position: relative;
    margin: 0;
    padding: 0;
    float: left; 
}

.woocommerce-menu li li {
    padding: 0 10px;
    background-image: none;
    position: relative;
}

.woocommerce-menu li:first-child {
    background-image: none;
    margin-right: 20px;
}

.woocommerce-menu li .sub-menu {
    display: none;
    width: 100px;
    position: absolute;
    right: 0px;
}

.woocommerce-menu li:hover > .sub-menu {
    display: block;
    position: absolute;
    right: 0px;
}

.woocommerce-menu .sub-menu {
    background: #ffffff;
    border: 1px solid #e0dfdf;
    line-height: normal !important;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    -box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
}

ul.woocommerce-menu a {
    display: block;
}

ul.woocommerce-menu ul a {
    padding: 7px 10px;
}

.woocommerce-menu .cart-content a .cart-desc {
    display: inline-block;
    width: 95px;
    float: left;
}

.woocommerce-menu li .sub-menu ul {
    top: -1px!important;
}

.woocommerce-menu .cart-content a img {
    display: inline-block;
    float: left;
    margin-right: 15px;
    max-width: 36px;
}

.woocommerce-menu .cart-contents {
    background: #fff;
    display: none;
    position: absolute;
    right: -1px;
    top: auto;
    z-index: 99999999;
    font-size: 11px;
    border: 1px solid #E0DFDF;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    -box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, .1);    
}

.woocommerce-menu .cart-contents:last-child a {
    border-bottom: 0;
}

.woocommerce-menu .cart:hover .cart-contents {
    display: block;
}
.fa-shopping-cart {
  font-size: 18px;
  margin-right: 5px;
}
.woocommerce-menu .cart-content a .cart-title,
.woocommerce-menu .cart-content a .quantity {
    display: block;
    font-size: 12px;
}

.woocommerce-menu .cart-content a .cart-title {
    margin-bottom: 5px;
}

.woocommerce-menu .cart-checkout {
    border-top: 1px solid #e0dfdf;
    overflow: hidden;
}

.woocommerce-menu .cart-checkout a {
    display: inline-block;
    width: 50%;
    float: left;
    text-indent: 10px;
    padding: 15px 0px!important;
}

.woocommerce-menu .cart-checkout .cart-link a:before {
    font-family: icomoon;
    content: "\e90c";
    margin-right: 6px;
}

.woocommerce-menu .cart-checkout .checkout-link a:before {
    font-family: icomoon;
    content: "\e927";
    margin-right: 6px;
}

.woocommerce-menu .cart-checkout .cart-link a {
    text-indent: 13px;
}

.woocommerce-menu .cart-content a {
    border-bottom: 1px solid;
    display: block;
    line-height: normal;
    overflow: hidden;
    padding: 15px 13px !important;
    width: 190px;
}
.woocommerce-menu .cart > a:before {
    font-family: IcoMoon;
    content: "\e90c";
    margin-right: 10px;
}

div#search-text-box {
	margin-right: 0;
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
	color: '. $evolve_top_menu_hover_font_color .';
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

#search-text-box #search_label_top {
  height: 45px !important;
  width:180px;
}
.header .searchfield {
  background: rgba(51, 59, 70, 0.9) none repeat scroll 0 0;  
  border-radius: 3px;
  padding: 4px;
}
#search-text-top {
  background: #fff none repeat scroll 0 0 !important;
  border: 1px solid #273039 !important;
  border-radius: 4px !important;
  /*box-shadow: 0 2px 5px #b5e9e0 inset;*/
  color: #757575 !important;margin-right: 0;
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

#social {
	float: right;
}

.searchform {
    float: right;
    clear: none;
}

.title-container #logo a {
    padding: 0px;
}
.my-account-link {
    margin-left: 0 !important;
}
.woocommerce-menu {
    float: left;
    margin: 14px 0;
}
.top-menu-social-container{
    float: right;
    margin: 11px 0;
}
.menu-header .menu-item {
    text-transform: uppercase;
}

html, body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, code, del, dfn, em, img, q, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td{
     vertical-align: middle;
}

a{
	vertical-align: baseline;
}

body #header.sticky-header .nav ul.nav-menu ul li a{
     height: auto;
}

ul.nav-menu ul.sub-menu .sf-with-ul::after{
    top: 10%;
}

.sticky-header ul.nav-menu ul.sub-menu .sf-with-ul::after {
    margin-top: 2px;
}

@media screen and (-webkit-min-device-pixel-ratio:0) {
    ul.nav-menu ul {}
}

@media (max-width: 768px){
ul.nav-menu ul.sub-menu .sf-with-ul:after {
	top: 11px;
}
}

/*responsive*/
@media only screen and (max-width: 768px) {
    .woocommerce-menu .cart > a .amount{
        display: none;
    }
}
@media only screen and (max-width: 768px) {
    #search_label_top::after {
            right: 15px !important;
    }
    .searchform,
    #search-text-box,
    .top-menu-social-container{
        float: none;
    }  
    .woocommerce-menu {
        float: none;
        margin-right: 0;
    }
    .woocommerce-menu li {
        background-image: none;
    }
    .woocommerce-menu .dd-options li a {
        text-align: left;
    }
    .header .menu-container .col-md-3{
        text-align: center;
        width: 100%;
        float:none !important;
    }
    .mobilemenu-icon span{
        display: block;
        background: #FFF none repeat scroll 0% 0%;
        height: 3px;
        width: 40px;
        margin-top: 6px;
    }
    .mobilemenu-icon{
        position: fixed;
        top: 54%;
        left: 45%;
    }
    #wrapper .dd-options li a{
        line-height: normal !important;
        display: block;
        text-align: left;
    }
    .sc_menu{
        float: none;
        text-align: center;
    }
}

@media only screen
and (min-width: 769px) 
and (max-width: 992px) {
    .header .title-container #tagline{
            padding: 20px 0px;
    }
}

ul.nav-menu{
    padding: 0px;
}

ul.nav-menu li{
  display: inline-block;
  float: none;
}
ul.nav-menu li > a span{
    height: 39px;
}
ul.nav-menu li li > a span, ul.nav-menu li li li > a span, ul.nav-menu li li li li > a span{
    height: auto !important;
}
ul.nav-menu a::after{
	top: 1px;
}

ul.nav-menu li:hover .sf-with-ul:before{
   height: 0px;
}

ul.nav-menu ul.sub-menu li:hover .sf-with-ul:before, ul.nav-menu ul.sub-menu li ul.sub-menu li:hover .sf-with-ul:before,
ul.nav-menu ul.sub-menu li ul.sub-menu li ul.sub-menu li:hover .sf-with-ul:before{
   height: 0px;
}

body #header.sticky-header ul.nav-menu ul.sub-menu .sf-with-ul:after{
    top:21%;
}

.title-container #logo {
    float: none;
}

.header .woocommerce-menu {
    float: none;
    margin-right:0px;
    margin-top: 20px;
}

ul.nav-menu li:hover{
    background: none;
}

.new_menu_class ul li {
    padding: 15px;
}
new_menu_class #menu-short-menu li{
    padding: 15px;	
}
new_menu_class ul {
    margin:0px;	
}
#social {
    float:none;
}
.top-menu-social {
    margin:5px 0 0;
    overflow: hidden;
}
.title-container #logo a {
    padding: 0px;
}
.woocommerce-menu .my-account a{
    font-size: 12px;
}
.woocommerce-menu .cart > a .t4p-icon-cart::before{
    margin-right: 10px;
}
.woocommerce-menu .my-account > a .t4p-icon-user::before{
    margin-left: 10px;
}

.orderby-order-container{
	margin-bottom: 42px; 
}
.link-effect a span {
	-webkit-transition: all .1s ease-in;
    -moz-transition: all .1s ease-in;
    -o-transition: all .1s ease-in;
    -ms-transition: all .1s ease-in;
    transition: all .1s ease-in;
}
';
if (evolve_get_option('evl_main_menu_hover_effect', 'rollover') == 'smooth') {
        $evolve_css_data .= 'ul.nav-menu li.current-menu-item > a, 
                            ul.nav-menu li.current-menu-item > a span,
                            .sticky-header ul.nav-menu li.current-menu-item > a,
                            ul.nav-menu li span:hover,
                            .sticky-header .menu-item a:hover,
							ul.nav-menu li.current-menu-ancestor > a span
                            {
                               border-bottom: 2px solid ' . $evolve_top_menu_hover_font_color . ';
                            }
                            ul.nav-menu .sub-menu span {
                               border: none !important;
                            }                          
                            ';
	}
if (is_front_page()) {
    $rgbcode = evolve_hex2rgb($evolve_custom_header_color);
    $header_pattern = $rgbcode[0] . ',' . $rgbcode[1] . ',' . $rgbcode[2] . ',' . $evolve_header_background_opacity;

    $evolve_css_data .= '@media only screen and (min-width: 769px) {
                        .header-pattern {
                            background: rgba(' . $header_pattern . ') none repeat scroll 0 0 !important;
                            position: absolute;
                            z-index:2;
                            width:100%;
                        } 
                        }';
}

global $evl_options;
$options = $evl_options;
if ($options['evl_menu_font']['color'] != '') {
    $color = $options['evl_menu_font']['color'];
    
    $evolve_css_data .= '
                        .woocommerce-menu .my-cart-link:hover,
                        .woocommerce-menu .empty-cart:hover,
                        .woocommerce-menu .my-account-link:hover{ 
                            border:1px solid '. $evolve_top_menu_hover_font_color .'; 
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
                          margin-bottom: 1px;
                          padding: 7px 15px;
                          height: 34.15px;
                        }';
}
