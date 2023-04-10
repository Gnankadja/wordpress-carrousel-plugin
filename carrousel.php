<?php
/*
Plugin Name: Flickr Carrousel 
Plugin URI: https://github.com/Gnankadja/wordpress-carrousel-plugin.git
Description: A wordpress plugin that displays an image carousel from Flickr.
Version: 1.0
Author: NathanDev
Author URI: https://github.com/Gnankadja
License: GPLv2
*/

// Add Shortcode that will use to insert caroussel on site
add_shortcode('flickr_carrousel', 'flickr_carrousel_shortcode');


// Shortcode fucntion
function flickr_carrousel_shortcode()
{
    // Carrousel Photo array
    $photos = [];

    // Query params
    $params = array(
        'api_key' => 'f12373b3043508a517277becdab9b47a',
        'method' => 'flickr.photos.getRecent',
        'tags' => "paysage",
        'per_page' => '5',
        'format' => 'json'
    );

    $encoded_params = array();

    foreach ($params as $key => $val) {
        $encoded_params[] = urlencode($key) . '=' . urlencode($val);
    }

    // Call API and decode response
    $url = "https://api.flickr.com/services/rest/?" . implode('&', $encoded_params);

    $response = file_get_contents($url);

    $json_start = strpos($response, '{');
    $json_end = strrpos($response, '}');
    $json_string = substr($response, $json_start, $json_end - $json_start + 1);

    $json_data = json_decode($json_string);

    if ($json_data) {

        if ($json_data->stat === "fail") {
            return $json_data->message;
        } else {
            // Read photos array to fetch each photo url
            foreach ($json_data->photos->photo as $photo) {

                $photos[] = array(
                    'title' => $photo->title,
                    'url' => "https://farm{$photo->farm}.staticflickr.com/{$photo->server}/{$photo->id}_{$photo->secret}.jpg"
                );
            }
        }
    }

    // Prepare html output
    if (!empty($photos)) {
        $output = '<div class="flickr-carrousel">';

        // Read photos array and get url
        foreach ($photos as $index => $photo) {
            if ($index == 0)
                $output .= "<img src='" . $photo['url'] . "' class='active' title='" . $photo['title'] . "'>";
            else
                $output .= "<img src='" . $photo['url'] . "' title='" . $photo['title'] . "'>";
        }

        $output .= '</div>';

        // Add Carrousel control
        $output .= "<button class='flickr_carrousel_prev'>Précédent</button>
                    <button class='flickr_carrousel_next'>Suivant</button>";

        return $output;

    }
}

// Set header to add style and script files
add_action('wp_head', 'flickr_carrousel_header');


function flickr_carrousel_header()
{
    echo "<link rel='stylesheet' href='" . plugins_url("assets/css/style.css", __FILE__) . "'>";
    echo "<script src='" . plugins_url('assets/js/jquery-3.6.4.min.js', __FILE__) . "'></script>";
    echo "<script src='" . plugins_url('assets/js/flickr-carrousel-script.js', __FILE__) . "'></script>";
}