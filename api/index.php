<?php
require_once 'scraper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $scraper = new WebScraper();
    $url = "https://www.klick.ee/telefonid-ja-lisad/mobiiltelefonid/nutitelefonid";
    
    $result = $scraper->scrape($url);
    echo json_encode($result);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
