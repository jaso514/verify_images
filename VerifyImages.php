<?php 
/**
 * Create the imagesNotFound.csv with all the not found images
 * in the file directory
 */

$handle = openCsv();

process($handle);

function openCsv() {
    $handle = fopen('csv/images.csv', 'r');
    if ($handle===false) {
        echo "file not opened";
        exit(-1);
    }
    return $handle;
}

function process($handle) {
    $destH = fopen('csv/imagesNotFound.csv', 'w');
    $row = 1;
    while (($data = fgetcsv($handle)) !== false) {
        if (!empty($data)) {
            verifyRowImages($data, $destH);
        }
        $row++;
        echo ".";
    }
    echo "\nProcess finished. Total: $row rows\n";
}

function verifyRowImages ($data, $dest) {
    $putInFile = [];
    $sku = "";
    foreach ($data as $i => $img) {
        if (empty($img)) {
            continue;
        }

        if ($i==0) {
            $sku = $img;
            continue;
        }

        $found = searchImage($img);
        if (!$found && !in_array($img, $putInFile)) {
            $putInFile[] = $img;
            putImages ($dest, $sku, $img);
        }
    }

}

function searchImage($img) {
    //$uri = "media/catalog/product";
    $uri = "/home/jaso/projs/woodburn/repo/pub/media/catalog/product";
    if ($img[0]!='/') {
        $img = '/' . $img;
    }
    return file_exists ($uri . $img);
}

function putImages ($dest, $row, $image) {
    if (!empty($image)) {
        fputcsv($dest, [
                $row,
                $image
            ]);
    }
}