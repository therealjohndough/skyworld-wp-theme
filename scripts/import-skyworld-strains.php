<?php
/**
 * WP-CLI: Import Skyworld Strains JSON into ACF + SEO + Excerpts
 * Usage:
 *   wp eval-file import-skyworld-strains.php /path/to/skyworld-strains-import.json
 *
 * Requirements: WooCommerce (for products if you map), ACF Pro (field names must exist),
 * Optional: Yoast or SEOPress (will auto-detect by meta keys).
 */

if ( ! defined('WP_CLI') && php_sapi_name() !== 'cli' ) {
  fwrite(STDERR, "Run via WP-CLI.\n");
  exit(1);
}

if ($argc < 2) {
  fwrite(STDERR, "Usage: wp eval-file import-skyworld-strains.php <json>\n");
  exit(1);
}

$json = $argv[1];
if (!file_exists($json)) {
  fwrite(STDERR, "File not found: $json\n");
  exit(1);
}

$data = json_decode(file_get_contents($json), true);
if (!is_array($data)) {
  fwrite(STDERR, "Invalid JSON\n");
  exit(1);
}

/**
 * Helper: upsert a post by post_type + post_title
 */
function skyworld_upsert_post($post_type, $post_title, $excerpt = '') {
  $existing = get_page_by_title($post_title, OBJECT, $post_type);
  if ($existing) {
    $post_id = $existing->ID;
    if ($excerpt) {
      wp_update_post(['ID' => $post_id, 'post_excerpt' => $excerpt]);
    }
    return $post_id;
  }
  $post_id = wp_insert_post([
    'post_type'   => $post_type,
    'post_title'  => $post_title,
    'post_status' => 'publish',
    'post_excerpt'=> $excerpt,
  ]);
  return $post_id;
}

/**
 * Helper: set ACF field by name (fallback to update_post_meta)
 */
function skyworld_set_field($post_id, $field_name, $value) {
  if (function_exists('update_field')) {
    $ok = update_field($field_name, $value, $post_id);
    if ($ok) return;
  }
  update_post_meta($post_id, $field_name, $value);
}

/**
 * Helper: detect SEO plugin and set meta
 */
function skyworld_set_seo_meta($post_id, $title, $desc) {
  if (!$title && !$desc) return;

  // Yoast
  if (metadata_exists('post', $post_id, '_yoast_wpseo_title') || defined('WPSEO_VERSION')) {
    if ($title) update_post_meta($post_id, '_yoast_wpseo_title', $title);
    if ($desc)  update_post_meta($post_id, '_yoast_wpseo_metadesc', $desc);
    return;
  }
  // SEOPress
  if (metadata_exists('post', $post_id, '_seopress_titles_title') || defined('SEOPRESS_VERSION')) {
    if ($title) update_post_meta($post_id, '_seopress_titles_title', $title);
    if ($desc)  update_post_meta($post_id, '_seopress_titles_desc',  $desc);
    return;
  }
  // Fallback: store to generic meta
  if ($title) update_post_meta($post_id, 'meta_title', $title);
  if ($desc)  update_post_meta($post_id, 'meta_description', $desc);
}

foreach ($data as $row) {
  $post_type  = isset($row['post_type']) ? $row['post_type'] : 'strain';
  $post_title = $row['post_title'] ?? '';
  if (!$post_title) { echo "Skipping row with empty title\n"; continue; }

  $excerpt    = $row['excerpt'] ?? '';
  $post_id    = skyworld_upsert_post($post_type, $post_title, $excerpt);
  if (!$post_id || is_wp_error($post_id)) { echo "Failed to upsert: {$post_title}\n"; continue; }

  // SEO meta
  $meta_title = $row['meta_title'] ?? '';
  $meta_desc  = $row['meta_description'] ?? '';
  skyworld_set_seo_meta($post_id, $meta_title, $meta_desc);

  // ACF fields
  $fields = $row['fields'] ?? [];
  foreach ($fields as $key => $val) {
    // Normalize terpene repeater: array of {terpene_name, terpene_percentage}
    if ($key === 'terpene_profile' && is_array($val)) {
      // If you have an ACF repeater named 'terpene_profile' with subfields 'terpene_name' and 'terpene_percentage'
      skyworld_set_field($post_id, 'terpene_profile', $val);
    } else {
      skyworld_set_field($post_id, $key, $val);
    }
  }

  echo "Updated: {$post_title} (post_id={$post_id})\n";
}

echo "Done.\n";