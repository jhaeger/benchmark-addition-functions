<?php 
/*
Plugin Name: Benchmark Functions Plugin
Plugin URI: https://github.com/BenchmarkMortgage/benchmark-custom-functions
Description: This plugin contains additional functions.
Version: 1.0
Author: Jason Haeger
Author URI: http://greyleafmedia.com
*/
function add_async_attribute($tag, $handle) {
   // add script handles to the array below
   $scripts_to_async = array('contact-form-7', 'jquery-form', 'jquery-ui-datepicker', 'jquery-ui-spinner', 'cffscripts', 'foobox-free-min', 'thsp-sticky-header-plugin-script', 'corporateHide', 'magnific', 'benchmark.mfp', 'load-lo-search', 'wow', 'applyUI', 'indeed-click-tracking', 'wp-spamshield');
   
   foreach($scripts_to_async as $async_script) {
      if ($async_script === $handle) {
         return str_replace(' src', ' async="async" src', $tag);
      }
   }
   return $tag;
}
add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

//Defer scripts function
function add_defer_attribute($tag, $handle) {
   // add script handles to the array below
   $scripts_to_defer = array('jquery-migrate');
   
   foreach($scripts_to_defer as $defer_script) {
      if ($defer_script === $handle) {
         return str_replace(' src', ' defer="defer" src', $tag);
      }
   }
   return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);


/******
Clean Up the home page for faster rendering. Better for SEO, and initial impressions. */

//Dequeue JavaScripts
function clean_home_page() {
    if (is_page('home-page')) {
        wp_dequeue_script( 'foobox-free-min' );
    }
    elseif (!is_page('make-a-payment')) {
        wp_dequeue_script( 'magnific' );
        wp_dequeue_script( 'benchmark.mfp' );
    }
    elseif (!is_page('careers-2')) {
        wp_deregister_script( 'indeed-click-tracking' );
    }
}
add_action( 'wp_print_scripts', 'clean_home_page', 100);

//Dequeue Stylesheets
function clean_home_page_styles() {
    if (is_page('home-page')) {
        wp_dequeue_style( 'foobox-free-min' );
        wp_deregister_style( 'foobox-free-min' );
        wp_dequeue_style( 'bcct_style-css' );
        wp_deregister_style( 'bcct-style-css' );
        wp_dequeue_style( 'wp-job-manager-frontend' );
        wp_deregister_style( 'wp-job-manager-frontent' );
        wp_dequeue_style( 'job-manager-career-builder' );
        wp_deregister_style( 'job-manager-career-builder' );
        wp_dequeue_style( 'job-manager-indeed' );
        wp_deregister_style( 'job-manager-indeed' );
        wp_dequeue_style( 'wp-job-manager-frontend' );
        wp_deregister_style( 'wp-job-manager-frontend' );
        wp_dequeue_style( 'wp-mapstyle-frontend' );
        wp_deregister_style( 'wp-mapstyle-frontent' );
    }
    elseif (!is_page('benchmark-branches')) {
        wp_dequeue_style( 'wp-mapstyle-frontend' );
        wp_deregister_style( 'wp-mapstyle-frontent' );
    }
    elseif (!is_page('careers-2')) {
        wp_dequeue_style( 'job-manager-career-builder' );
        wp_deregister_style( 'job-manager-career-builder' );
        wp_dequeue_style( 'job-manager-indeed' );
        wp_deregister_style( 'job-manager-indeed' );
        wp_dequeue_style( 'wp-job-manager-frontend' );
        wp_deregister_style( 'wp-job-manager-frontend' );
    }
}
add_action ( 'wp_enqueue_scripts', 'clean_home_page_styles', 9999);
add_action ( 'wp_head', 'clean_home_page_styles', 9999);



function parallelize_hostnames($url, $id) {
	$hostname = par_get_hostname($url); //call supplemental function
	$url =  str_replace(parse_url(get_bloginfo('url'), PHP_URL_HOST), $hostname, $url);
	return $url;
}
/**function par_get_hostname($name) {
	$subdomains = array('media1.benchmark.us','media2.benchmark.us', 'media3.benchmark.us'); //add your subdomains here, as many as you want.
	$host = abs(crc32(basename($name)) % count($subdomains));
	$hostname = $subdomains[$host];
	return $hostname;
}
add_filter('wp_get_attachment_url', 'parallelize_hostnames', 10, 2);**/