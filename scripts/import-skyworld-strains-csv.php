<?php
/**
 * WP-CLI: Import Skyworld Strains CSV into ACF + SEO + Excerpts
 * Usage:
 *   wp eval-file import-skyworld-strains-csv.php /path/to/skyworld-strains-import.csv
 */
if ( ! defined('WP_CLI') && php_sapi_name() !== 'cli' ) { fwrite(STDERR, "Run via WP-CLI.\n"); exit(1); }
if ($argc < 2) { fwrite(STDERR, "Usage: wp eval-file import-skyworld-strains-csv.php <csv>\n"); exit(1); }
$csv = $argv[1];
if (!file_exists($csv)) { fwrite(STDERR, "File not found: $csv\n"); exit(1); }

function skyworld_upsert_post($post_type, $post_title, $excerpt = '') {
  $existing = get_page_by_title($post_title, OBJECT, $post_type);
  if ($existing) {
    $post_id = $existing->ID;
    if ($excerpt) { wp_update_post(['ID' => $post_id, 'post_excerpt' => $excerpt]); }
    return $post_id;
  }
  return wp_insert_post([
    'post_type'   => $post_type,
    'post_title'  => $post_title,
    'post_status' => 'publish',
    'post_excerpt'=> $excerpt,
  ]);
}
function skyworld_set_field($post_id, $field_name, $value) {
  if (function_exists('update_field')) { $ok = update_field($field_name, $value, $post_id); if ($ok) return; }
  update_post_meta($post_id, $field_name, $value);
}
function skyworld_set_seo_meta($post_id, $title, $desc) {
  if (!$title && !$desc) return;
  if (metadata_exists('post','_yoast_wpseo_title',$post_id) || defined('WPSEO_VERSION')) {
    if ($title) update_post_meta($post_id, '_yoast_wpseo_title', $title);
    if ($desc)  update_post_meta($post_id, '_yoast_wpseo_metadesc', $desc);
    return;
  }
  if (metadata_exists('post','_seopress_titles_title',$post_id) || defined('SEOPRESS_VERSION')) {
    if ($title) update_post_meta($post_id, '_seopress_titles_title', $title);
    if ($desc)  update_post_meta($post_id, '_seopress_titles_desc',  $desc);
    return;
  }
  if ($title) update_post_meta($post_id, 'meta_title', $title);
  if ($desc)  update_post_meta($post_id, 'meta_description', $desc);
}

$handle = fopen($csv, 'r');
$header = fgetcsv($handle);
$idx = array_flip($header);

while (($row = fgetcsv($handle)) !== false) {
  $post_type  = $row[$idx['post_type']] ?? 'strain';
  $post_title = $row[$idx['post_title']] ?? '';
  if (!$post_title) { echo "Skipping row with empty title\n"; continue; }
  $excerpt    = $row[$idx['excerpt']] ?? '';
  $post_id    = skyworld_upsert_post($post_type, $post_title, $excerpt);
  if (!$post_id || is_wp_error($post_id)) { echo "Failed to upsert: {$post_title}\n"; continue; }

  skyworld_set_seo_meta($post_id, $row[$idx['meta_title']] ?? '', $row[$idx['meta_description']] ?? '');

  // ACF / meta fields
  $map = ['genetics','breeder','breeder_source_url','flowering_time','yield','growing_difficulty','aroma_profile','flavor_profile'];
  foreach ($map as $key) {
    if (isset($idx[$key])) {
      $val = $row[$idx[$key]] ?? '';
      if ($val !== '') skyworld_set_field($post_id, $key, $val);
    }
  }

  // Terpenes JSON column (optional)
  if (isset($idx['terpene_profile_json'])) {
    $json = $row[$idx['terpene_profile_json']];
    $val  = json_decode($json, true);
    if (is_array($val)) {
      skyworld_set_field($post_id, 'terpene_profile', $val);
    }
  }

  echo "Updated: {$post_title} (post_id={$post_id})\n";
}
fclose($handle);
echo "Done.\n";