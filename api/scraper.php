<?php
class WebScraper {
    public function scrape($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return ['error' => 'Failed to retrieve content'];
        }

        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $categories = [];
        $products = $xpath->query("//div[contains(@class, 'product-listing')]/div/div");
        foreach ($products as $product) {
            $nameNode = $xpath->query(".//p[contains(@class, 'product-name')]", $product);
            $name = $nameNode->length > 0 ? trim($nameNode->item(0)->nodeValue) : 'No name available';

            $priceNode = $xpath->query(".//span[contains(@class, 'price')]", $product);
            $price = $priceNode->length > 0 ? trim($priceNode->item(0)->nodeValue) : 'No price available';

            $discountPriceNode = $xpath->query(".//span[contains(@class, 'price-discount')]", $product);
            $discountPrice = $discountPriceNode->length > 0 ? trim($discountPriceNode->item(0)->nodeValue) : 'No discount available';

            $categories[] = [$name, $price, $discountPrice];
        }
        return $categories;
    }
}
