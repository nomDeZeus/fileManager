<?php
/**
 * Created by PhpStorm.
 * User: rgrisot
 * Date: 25/01/17
 * Time: 16:09
 */
$data = json_decode(file_get_contents('./uploader.json'), true);
$uploadDir = $data['upload_dir'];
$MAX_SIZE = $data['max_upload_size'];