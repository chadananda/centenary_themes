<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php 
$x = check_plain($fields['field_pos_x_value']->raw);
$y = check_plain($fields['field_pos_y_value']->raw);
if (is_numeric($x) && is_numeric($y) && $x > 0 && $y > 0) { 

if (!($flag = check_plain($fields['field_map_flag_type_value']->raw))) $flag = 'map-pin-red';
if (!is_numeric($size = check_plain($fields['field_map_flag_size_value']->raw))) $size = '32';

$xoffset = round($size/4);
$yoffset = round($size/6);

?>


<div class="travelmap-city" style="top:<?php print $y; ?>px; left:<?php print $x; ?>px;">
  <div class="travelmap-city-marker" style="left:-<?php print $xoffset;?>px; bottom:-<?php print $yoffset;?>px;">
    <a href="<?php print $fields['path']->content;?>" class="travelmap-city-link">
      <img src="/sites/all/themes/centenary/images/<?php print $flag?>.png" height="<?php print $size?>" width="<?php print $size?>" alt="<?php print $fields['title']->content; ?>" />
    </a>
  </div>
  <div class="travelmap-city-assets">
    <?php print $fields['field_assets_nid']->content; ?>
  </div>
</div>

<?php } ?>

