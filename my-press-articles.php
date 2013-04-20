<?php
/*
Plugin Name: my press articles
Plugin URI: http://onmouseenter.com/category/my-press-articles-plugin/
Description: my press articles is a all in one wordpress plugin which includes insert related posts, sticky post widget, social media widget, google map, google analytics and many more.
Version: 1.9
Author: Gadgets Choose
Author URI: http://wordpress.org/support/view/plugin-reviews/my-press-articles/
License: GPLv2
*/

/* Copyright 2012 Gadgets-Code.Com (e-mail : morning131@hotmail.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, please visit <http://www.gnu.org/licenses/>.
*/

include_once('includes/my-press-articles-action-hooks.php');
include_once('includes/my-press-articles-filter.php');
include_once('includes/my-press-articles-settings.php');
include_once('includes/my-press-articles-sidebar-widgets.php');
include_once('includes/my-press-articles-related-post-loop.php');
include_once('includes/my-press-articles-short-codes.php');
include_once('includes/my-press-articles-register-tinymce-short-code-buttons.php');
include_once('includes/my-press-articles-show-note.php');

wp_register_style('myPressArticlesStyleSheet', plugins_url( 'css/my-press-articles-style.css' , __FILE__ ), array(), '130', 'all' );
wp_enqueue_style( 'myPressArticlesStyleSheet');
wp_enqueue_script( 'jquery');
?>