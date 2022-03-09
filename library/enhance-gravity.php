<?php
function listing_metaboxes( array $meta_boxes ) {

// Start with an underscore to hide fields from custom fields list
$prefix = '_sitemeta_';

$meta_boxes[] = array(
'id'         => 'cat-meta', //ID of the metabox
'title'      => 'Cat Information', //Title that will appear in editor
'pages'      => array( 'cat'), // Custom post type
'context'    => 'normal', //Main column in the editor
'priority'   => 'high', //Priority..
'show_names' => true, // Show field names on the left
'fields'     => array(
array(
'name' => 'Cat colour',
'desc' => 'The colour of the cat',
'id' => $prefix . 'colour',
'type' => 'text_medium',
),
array(
'name' => 'Cat personality',
'desc' => 'Describe the cat\'s personality in detail',
'id' => $prefix . 'personality',
'type' => 'textarea',
),
array(
'name' => 'Cat smell',
'desc' => 'Cat\'s smell',
'id' => $prefix . 'smell',
'type' => 'text_medium',
),
)
);
return $meta_boxes;
}