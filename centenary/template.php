<?php
/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to centenary_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: centenary_breadcrumb()
 *
 *   where centenary is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/**
 * Implementation of HOOK_theme().
 */
function centenary_theme(&$existing, $type, $theme, $path) {
  $hooks = zen_theme($existing, $type, $theme, $path);
  // Add your theme hooks like this:
  /*
  $hooks['hook_name_here'] = array( // Details go here );
  */
  // @TODO: Needs detailed comments. Patches welcome!
  return $hooks;
}





/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function centenary_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */


function centenary_preprocess_html(&$vars) {
  //if ($vars['title']) $vars['title'] = check_markup($vars['title']);
  //$vars['title'] = "preprocess_html";
}



/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function centenary_preprocess_page(&$vars, $hook) {
 
  if ($vars['is_front']) {
    $vars['logo'] = str_replace('centenary_logo.png', 'centenary-front_logo.png', $vars['logo']);
  }
  // run node titles through filter
  if (module_exists('cg')) $vars['title'] = cg_clean_bahai_title($vars['title']); 
  //strip_tags(check_markup($vars['title'], 2));  

  //$vars['classes'] = implode(' ', $vars['classes_array']);
  if (is_object($vars['node'])) {
    $vars['node_class'] = $vars['node']->type;
    if ($sh = variable_get("cg_superhead_{$vars['node']->type}", '')) {
      $vars['node_super_head'] = "<div class='node-super-head {$vars['node']->type}'>$sh</div>";
    }
  }
}
// */

/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
function centenary_preprocess_node(&$vars, $hook) {

  // Optionally, run node-type-specific preprocess functions, like
  // centenary_preprocess_node_page() or centenary_preprocess_node_story().
 
  if (module_exists('token') && $vars['teaser']) {
    $vars['teaser_header'] = token_replace(variable_get("cg_teaserheader_{$vars['node']->type}", variable_get('cg_teaserheaders', '[type-name]: [title]')), 'node', $vars['node']);
  }
  if (is_array($vars['classes_array']) && count($vars['classes_array'])) {
    $vars['classes'] = implode($vars['classes_array'], ' ');
  }
  if (in_array($vars['node']->type, array('additional_resource', 'city', 'comm_event', 'encounter', 'image', 'clip', 'talk', 'theme_overview', 'vignette'))) {
    $vars['likelinks_top'] = <<< EOT
    <div class="likelinks top">
      <div class="fb-buttons">
        <div class="fb-like" data-send="true" data-layout="button_count" data-width="150" data-show-faces="false"></div>
      </div>
      <div class="t-buttons">
        <a href="https://twitter.com/share" class="twitter-share-button" data-hashtags="centenary,bahai">Tweet</a>
      </div>
      <div class="g-buttons">
        <g:plusone size="medium"></g:plusone>
      </div>
    </div>
EOT;
    $vars['likelinks_bottom'] = <<< EOT
    <div class="likelinks">
      <h2 class="title">Share This!</h2>
      <div class="t-buttons">
        <a href="https://twitter.com/share" data-size="large" class="twitter-share-button" data-hashtags="centenary,bahai">Tweet</a>
      </div>
      <div class="g-buttons">
        <g:plusone></g:plusone>
      </div>
      <div class="fb-buttons">
        <div class="fb-like" data-send="true" data-width="320" data-show-faces="true"></div>
      </div>
    </div>
EOT;
  }
  if ($vars['node']->type == 'theme_overview') {
    $search = array(
      'imagecache/page-main-image/main_image/abdulbaha-overview-small_0.jpg',
      'imagecache/page-main-image/main_image/Abdu%27l-Baha-True-Color.png',
    );
    $replace = array(
      'imagecache/theme-image/main_image/abdulbaha-overview-small_0.jpg',
      'imagecache/theme-image/main_image/Abdu%27l-Baha-True-Color.png'
    );
    $count = 0;
    $vars['content'] = str_replace($search, $replace, $vars['content'], $count);
    if ($count) {
      $vars['content'] = str_replace('width="264" height="222"', '', $vars['content']);
    }
  }
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function centenary_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function centenary_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

function centenary_date_all_day_label() { return ''; }

