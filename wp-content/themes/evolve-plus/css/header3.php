<?php
$evolve_css_data = '';

/* header2.php style */

$evolve_top_menu_back_color = mb_substr($evolve_top_menu_back_color, 1);
$evolve_social_color = evolve_get_option('evl_social_color_scheme', '#999999');
$evolve_css_data .= '
	
.new-top-menu,
.new-top-menu ul.nav-menu li.nav-hover ul,
.new-top-menu form.top-searchform { 
	background: #' . $evolve_top_menu_back_color . '!important; 
}
li.cart a > span{
display:none;
}
.new-top-menu ul.nav-menu ul li:hover > a, 
.new-top-menu ul.nav-menu li.current-menu-item > a, 
.new-top-menu ul.nav-menu li.current-menu-ancestor > a  {
	border-top-color:#' . $evolve_top_menu_back_color . '!important;
}

.new-top-menu ul.nav-menu li.current-menu-ancestor li.current-menu-item > a, 
.new-top-menu ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a {
	border-top-color:#' . $evolve_top_menu_back_color . '; 
}

.new-top-menu ul.nav-menu ul {
	border: 1px solid ' . evolve_hexDarker($evolve_top_menu_back_color) . '; 
	border-bottom:0;
}

.new-top-menu ul.nav-menu li {
	border-left-color: ' . evolve_hexDarker($evolve_top_menu_back_color) . ';
	border-right-color:  #' . $evolve_top_menu_back_color . ';
}



#wrapper .new-top-menu .dd-options {
	background:#' . $evolve_top_menu_back_color . ';
}

.new-top-menu ul.nav-menu li.current-menu-item, 
.new-top-menu ul.nav-menu li.current-menu-ancestor, 
.new-top-menu ul.nav-menu li:hover {
	border-right-color:#' . $evolve_top_menu_back_color . '!important;
}

.new-top-menu ul.nav-menu ul, 
.new-top-menu ul.nav-menu li li, 
.new-top-menu ul.nav-menu li li li, 
.new-top-menu ul.nav-menu li li li li,
#wrapper .new-top-menu .dd-options li,
#wrapper .new-top-menu .dd-options {
	border-color:#'.evolve_hexDarker($evolve_top_menu_back_color).'!important;
}	

#wrapper .new-top-menu .dd-container .dd-selected-text,
#wrapper .new-top-menu .dd-options li a:hover, 
#wrapper .new-top-menu .dd-options li.dd-option-selected a {
	background:#'.evolve_hexDarker($evolve_top_menu_back_color).'!important; 
}
';


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
    margin-top: 0px;
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

.sc_menu a.tipsytext:hover{
        color: '.$evolve_top_menu_hover_font_color.' !important;
}

.woocommerce-menu .my-account> a:hover {
     border:1px solid '. $evolve_top_menu_hover_font_color .' !important;  
     color:'. $evolve_top_menu_hover_font_color .' !important;
}

.woocommerce-menu .cart > a:before {
    font-family: icomoon;
    content: "\e90c";
    margin-right:0px;
}

.woocommerce-menu .my-account> a:before {
    font-family: icomoon;
    content: "\e914";
    margin-right:0px;
}

.woocommerce-menu .my-account> a {
  border: 1px solid #ffffff;
  border-radius: 3px;
  color: #ffffff;
  display: block;
  font-size: 0 !important;  
  padding: 4px !important;
  text-align: center;
  width: 40px;
}
.woocommerce-menu .cart > a,.woocommerce-menu .my-account > a{
color: ' . $evolve_social_color . ' !important;
border-color: ' . $evolve_social_color . ';
height: 35px;
}
#search-text-top,#search-text-box #search_label_top::after{
color: ' . $evolve_social_color . ' !important;
border-color: ' . $evolve_social_color . ' !important;
}

.woocommerce-menu .my-account> a::before {
  font-size: 18px;
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

div#search-text-box {
	margin-right: 0;
}
#search-text-box #search_label_top {   
    color: #888
}

#social {
	float: right;
}

.title-container #logo {
    float: none;
}

.searchform {
    float: right;
    clear: none;
}

.title-container #logo a {
    padding: 0px;
}
.woocommerce-menu {
	margin-right: 0px;
        float: left;
}
.menu-header .menu-item {
	text-transform: uppercase;
}

ul.nav-menu{
       padding: 0px;
}

ul.nav-menu li:hover .sf-with-ul:before{
   height: 0px;
}

ul.nav-menu ul.sub-menu li:hover .sf-with-ul:before, ul.nav-menu ul.sub-menu li ul.sub-menu li:hover .sf-with-ul:before,
ul.nav-menu ul.sub-menu li ul.sub-menu li ul.sub-menu li:hover .sf-with-ul:before{
   height: 0px;
}

ul.nav-menu li:hover{
    background: none;
}

div#search-text-box {
	margin-right: 0;
}
#search-text-box #search_label_top {   
    color: #888
}

.title-container #logo {
    float: none;
}

.sticky-header ul.nav-menu li {
    float: left;  
    display: block;
}

.new_menu_class ul {
    text-align:center;
}

.new_menu_class ul li {
    padding: 15px;
	display: inline-block;
}

ul.nav-menu {
   	padding:0px;
}

.container-menu {
    padding-bottom: 0px !important;
    z-index: 1;
    float: right;
}
#search-text-box #search_label_top::after {
  border-radius: 3px;
  color: #fff;
  content: "\e91e";
  cursor: pointer;
  font-family: icomoon;
  font-size: 18px !important;
  font-weight: normal;
  position: absolute;
  right:33px;
  text-align: center;
  top:5px;
}
.my-account-link i:hover {
  border: 1px solid #0bb697;
  color: #0bb697;}
  
.my-account-link i {
  border: 1px solid #fff;
  border-radius: 3px;
  color: #fff;
  display: block;
  font-size: 20px;
  padding: 7px !important;
  text-align: center;
  width: 40px;
}
.cart > a:hover{
    border: 1px solid '.$evolve_top_menu_hover_font_color.';
    color: '. $evolve_top_menu_hover_font_color .' !important;
}

.cart > a {
  border: 1px solid #fff;
  border-radius: 3px;
  color: #fff;
  display: block;
  font-size: 18px !important;
  padding: 3px !important;
  text-align: center;
  width: 40px;
  margin-bottom: 1px;
}

.my-account-link {
    font-size: 0 !important;
    margin-bottom: 1px;
}
#search-text-box #search_label_top{
    top:0;
}
form.top-searchform{
    margin:15px 0;
}

#search-text-top {
  border: 1px solid #fff;
  
}
.sc_menu{
    float:left;
}
.woocommerce-menu-holder{
        float: right;
        margin: 15px 0;
}
.woocommerce-menu .my-cart-link > span.amount{
    display:none;
}
.sc_menu li {
    float: none;
}

#social {
    float: none;
    margin-top:30px;
}

.stuckMenu.isStuck {
    padding-top:32px;
}

#wrapper  .dd-options li {
    line-height: 12px;   
}

#wrapper  .dd-options {
    overflow-y: hidden;
}
.woocommerce-menu .my-account a{
    font-size: 12px;
}

/*responsive*/
@media (max-width: 991px) {
    .search-container-hv2 {
          clear:both;
          display: block;
    }
    #search-text-box  {   
       float:none;
        text-align:center;
        /*padding-top: 10px;*/
    }
    #search-text-box #search_label_top {
       float: right;
   }
}

@media screen and (-webkit-min-device-pixel-ratio:0) {
    ul.nav-menu ul {}
}
@media only screen and (min-width: 769px) {
    #search-text-top {        
        width: 40px;
    }
    .woocommerce-menu .cart > a .amount{
        display: none;
    }
    .woocommerce-menu .cart{
        margin: 0 20px 0 10px;
    }
}
@media only screen and (max-width: 768px) {
    .header .col-md-2 {
            clear: both;
    }
    .searchform {
            clear: both;
            float: none; 
    }
    #search-text-box {
            float: none;
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
    #search_label_top::after {
            right: 18px !important;
            top:5px !important;
            content: url("'.$template_url.'/library/media/images/search-arrow.png");
    }
    .dd-options li a {
            text-align: left;
    }
    .header .container .col-md-1 {
            clear: both;
    }
    #tagline {
            margin-left: 0;
    }
    .title-container #logo a {
        padding: 0px;
    }
    .woocommerce-menu-holder{
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
    .container-menu {
        float: none;
    }
    .sc_menu{
        float: none;
        text-align: center;
    }
}

@media only screen and (min-width: 769px) and (max-width: 992px) {

    .header .title-container #tagline{
            padding: 20px 0px;
    }
}
';