<?php

$jsonData = '[]';
$data = json_decode($jsonData, true);
$products = [];
$allVariants = [];
function getIdFromPath($path ) : string {
    return substr($path, strrpos($path, '/' )+1);
}
// sort things in to 2 arrays while reducing source array until it has no values
while ($item = array_pop($data)) {
    if (isset($item['sku'])) {
        $allVariants[] = [
            'children_gid' => $item['id'],
            'price' => $item['price'],
            'sku' => $item['sku'],
            '__parentId' => $item['__parentId'],
        ];
    } else {
        $products[] = [
            'gid' => $item['id'],
            'title' => $item['title'],
            'options' => $item['options'],
            'handle' => $item['handle'],
            'external_created_at' => $item['createdAt'],
            'external_updated_at' => $item['updatedAt'],
            'product_variants' => [],
        ];
    }
}
// get id'ish records with indexes. Indexes will match the ones in parent array
$indexedIdValues = array_column($products, '__parentId');

while ($variant = array_pop($allVariants)) {
    // find index of the parent element in products array
    $indexInProduct = array_search($variant['__parentId'], $indexedIdValues, true);
    if ($indexInProduct === false) {
        // no sure if this needed, but it will hapen
        throw new Exception('Not parent product found for ' . json_encode($variant));
    } else {
        $products[$indexInProduct]['product_variants'][] = $variant;
    }

}

echo '<pre>';
print_r($products);
echo '</pre>';
