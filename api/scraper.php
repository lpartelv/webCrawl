<?php
class WebScraper {
    public function scrape($url) {
        // cURL kasutamine lehe sisu toomiseks
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return ['error' => 'Failed to retrieve content'];
        }

        // Lehe sisu analüüs
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        // Näide kategooriate kogumisest
        $categories = [];
        foreach ($xpath->query("//div[contains(@class, 'category')]") as $category) {
            $categories[] = trim($category->nodeValue);
        }

        return [
            'categories' => array_count_values($categories)
        ];
    }
}
