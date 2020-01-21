<?php

$handle = openCsv();
process($handle);
die;


function process($handle) {
    $header = [];
    // $images = [];

    $row = 1;
    $dest = fopen('csv/images.csv', 'w');
    while (($data = fgetcsv($handle)) !== false) {
        if (empty($data)) {
            continue;
        }
    
        if (1===$row++) {
            $header = getHeader($data);
            continue;
        }
    
        $images = getImages($header, $data);
        putImages($dest, $data[0], $images);
    }
    
    fclose($handle);
    fclose($dest);
    
    echo $row . " Processed\n";
}

function openCsv() {
    $handle = fopen('csv/products.csv', 'r');
    if ($handle===false) {
        echo "file not opened";
        exit(-1);
    }
    return $handle;
}

function getHeader($data) {
    $cols = [
        'base_image',
        'small_image',
        'thumbnail_image',
        'swatch_image',
        'additional_images',
        'hide_from_product_page'
    ];
    
    $ret = [];
    foreach ($data as $key => $value) {
        if (in_array($value, $cols)) {
            $ret[$value] = $key;
        }
    }
    
    return $ret;
}

function getImages($header, $data) {
    $images = [];
    foreach ($header as $col => $i) {
        if (!empty($data[$i])) {
            $img = processImages($data[$i]);
            if (!empty($img)) {
                $images = array_merge($images, $img);
            }
        }
    }
    
    return $images;
}

function processImages($str) {
    if (empty($str)) {
        return [];
    }
    
    if (strpos(',', $str)>=0) {
        return explode(',', $str);
    } else {
        return [$str];
    }
}

function putImages($dest, $sku, $images) {
    if (!empty($images)) {
        fputcsv($dest, array_merge( [$sku], $images));
    }
}