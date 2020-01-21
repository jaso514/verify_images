<?php

$handle = openCsv();

download($handle);

/**
 * Need the csv result from VerifyImages
 */
function openCsv() {
    $handle = fopen('csv/imagesNotFound.csv', 'r');
    if ($handle===false) {
        echo "file not opened";
        exit(-1);
    }
    return $handle;
}


function download ($handle) {
    while (($data = fgetcsv($handle)) !== false) {
        if (!empty($data)) {
            $sku = $data[0];
            $image = $data[1];
            if ($image[0]!='/') {
                $image = '/' . $image;
            }
            downloadFile($image);
        }
    }
}

function downloadFile($img) {
    $filename = basename($img);
    // the url from live
    $path = "https://www.woodburnpress.com/pub/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9";
    $url = $path . $img;
    
    echo "> downloading: $url\n";
    try {
        createUri($img);
        $file = file_get_contents($path . $img);
        if ($file) {
            file_put_contents("image" . $img, $file);
        }
    } catch (\Throwable $th) { }
    }
    
function createUri($uri) {
    $info = pathinfo($uri);

    if (!is_dir("image/" . $info['dirname'])) {
        return mkdir("image/" . $info['dirname'], 0777, true);
    }

    return true;
}
