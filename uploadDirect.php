<?php
error_reporting(0);
date_default_timezone_set('Europe/Amsterdam');
include('yawardup_functions.php');
$url_type = $_POST['urltype'];
$get_urls = $_POST["murl"];
if ($url_type=='apatube') {
    $url_type= (strpos($get_urls, 'https://www.aparat.com/') !== false) ? 'aparat' : 'youtube';
}
$lines = explode("\n", $get_urls); // or use PHP PHP_EOL constant
if ( !empty($lines) ) {
echo '<ul class="multiuped">';

    switch ($url_type) {
        case 'directfile':
            foreach ( $lines as $line ) {
                echo '<li>';
                echo yawar_DUP($line);
                echo '</li>';
                } //End Foreach
            break;
        case 'directftp':
            $conn= array(
            'host' => $_POST["host"],
            'dir' => (!empty($_POST["dir"])) ? $_POST["dir"]."/" : "",
            'port' => '21',
            'user' => $_POST["user"],
            'pass' => $_POST["pass"],
            );
            foreach ( $lines as $line ) {
                echo '<li>';
                echo yawar_DUP_ftp($line,'','',$conn);
                echo '</li>';
                } //End Foreach
            break;
        case 'aparat':
                $Varray= yawar_get_aparat_videos($get_urls,'','3');
                foreach ($Varray as $video) {
                    $avfile= $video['data']['video'][0];
                    $vid = $video['data']['vid'];
                    echo '<li>';
                    echo yawar_DUP($avfile,$url_type,$vid);
                    echo '</li>';
                }
            break;
        case 'youtube':
                $ytVfile= yawar_get_youtubevideos($get_urls);
            echo '<li>';
                echo $ytVfile;//yawar_DUP($ytVfile,$url_type);
            echo '</li>';
            break;
    }

echo '</ul>';
}

else{ echo 'Please enter the URL'; }
?>