<?php
// Autoload dependencies via Composer
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use voku\helper\HtmlDomParser;

// Initialize Guzzle HTTP client
$client = new Client([
    'base_uri' => 'https://www.klick.ee',
    'timeout'  => 5.0,
]);

try {
    // Send GET request to the webpage
    $response = $client->request('GET', '/telefonid-ja-lisad/mobiiltelefonid/nutitelefonid');
    $htmlContent = $response->getBody()->getContents();
    
    // Parse HTML content
    $dom = HtmlDomParser::str_get_html($htmlContent);

    // Find product elements in HTML
    $products = $dom->find('.product-listing'); // Example CSS class


    foreach ($products as $product) {
        $title = $product->find('.product-name')->innertext;
        //$price = $product->find('.product-price', 0)->innertext;
        
        //echo "Title: " . $title . "\n";
        print_r($title);
       // echo "Price: " . $price . "\n";
    }

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
