<?php
function yawar_DUP($getfileurl='',$urltype='',$vid='', $conn=""){
ini_set('max_execution_time', 550);
$line = $getfileurl;
$file = fopen($line,"rb");
    $directory = "upload/";
    $valid_exts = array("JPEG","jpeg","jpg","gif","png","PNG","bmp","svg","doc","docx","ppt","pdf","pptx","html","xml","zip","rar","mp3","mp4","mkv","exe");
    $ext = end(explode(".",strtolower(basename($line))));
    if(in_array($ext,$valid_exts)||$urltype=='youtube')
    {
      switch ($urltype) {
              case 'youtube':
                $name = 'youtubeVideo'.date("Ymdhis").'.mp4';
                break;
              case 'aparat':
                $name = 'AparatVideo_'.$vid.'.mp4';
                break;
              default:
                $name = basename($line);
                break;
            }    
        $prefix = 'DUP'.date("Ymdhis").'_';
        $filename = $prefix.$name;
        //$sanitized_filename = remove_accents( $filename ); // Convert to ASCII
        // Standard replacements
        $invalid = array(' '=> '-', '%20' => '-', '_'   => '-',);
        $filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $filename );

        $newfile = fopen($directory . $filename, "wb");
        if($newfile)
        {
            while(!feof($file))
            {
                fwrite($newfile,fread($file,1024 * 800),1024 * 160000);
            }
            $finalmsg= 'File <a href="./upload/'.$filename.'" target="_blank">'.$filename.'</a> uploaded successfully .';
        }
        else
        {
            $finalmsg= 'File does not exists';
        }
    }
    else{$finalmsg= 'Invalid URL';}
return $finalmsg;
}

function yawar_DUP_ftp($fileurl='',$urltype='',$vid='',$conn=''){
ini_set('max_execution_time', 550);
$file = fopen($fileurl,"rb");
    $directory = "upload/";
    $valid_exts = array("JPEG","jpeg","jpg","gif","png","PNG","bmp","svg","doc","docx","ppt","pdf","pptx","html","xml","zip","rar","mp3","mp4","mkv","exe");
    $ext = end(explode(".",strtolower(basename($fileurl))));
    if(in_array($ext,$valid_exts)||$urltype=='youtube')
    {
      switch ($urltype) {
              case 'youtube':
                $name = 'youtubeVideo'.date("Ymdhis").'.mp4';
                break;
              case 'aparat':
                $name = 'AparatVideo_'.$vid.'.mp4';
                break;
              default:
                $name = basename($fileurl);
                break;
            }    
        $prefix = 'DUP'.date("ymd").'_';
        $filename = $prefix.$name;
        $invalid = array(' '=> '-', '%20' => '-', '_'   => '-',);
        $filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $filename );
$godup=ftp_upload_data_files($conn,$fileurl,$filename);
if (is_array($godup)) {
  $finalmsg= 'File <a href="'.$godup['link'].'" target="_blank">'.$godup['name'].'</a> uploaded successfully .';
}
else
    {
        $finalmsg= 'Error : FTP connection not stablished!';
    }
/*
        $newfile = fopen($directory . $filename, "wb");
     if($newfile)
        {
            while(!feof($file))
            {
                fwrite($newfile,fread($file,1024 * 800),1024 * 160000);
            }
            $finalmsg= 'File <a href="./upload/'.$filename.'" target="_blank">'.$filename.'</a> uploaded successfully .';
          
        }
        else
        {
            $finalmsg= 'File does not exists';
        }
        */
   }
    else{$finalmsg= 'Invalid URL';}
return $finalmsg;
}

function ftp_upload_data_files($conn='',$desfile,$filename)
{
  $ftphost= $conn["host"];
  if(substr($ftphost , 0, 4) === "ftp.") {$ftphost=substr($ftphost , 4);} 
  
    $ftp_server = 'ftp://'.$ftphost.'/public_html/'.$conn["dir"];//(FTP_CONNECTION_TYPE == "test") ? FTP_CONNECTION_FTP_SERVER_TEST : FTP_CONNECTION_FTP_SERVER_LIVE;
    $http_server= 'http://'.$ftphost.'/'.$conn["dir"];
    $FTP_CONNECTION_PORT= $conn["port"];
    $FTP_CONNECTION_USERNAME= $conn["user"];
    $FTP_CONNECTION_PASS= $conn["pass"];
    $ch = curl_init();
    $fp = fopen($desfile, 'rb');
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ch, CURLOPT_URL, $ftp_server.$filename);
    curl_setopt($ch, CURLOPT_USERPWD, $FTP_CONNECTION_USERNAME.":".$FTP_CONNECTION_PASS);
    curl_setopt($ch, CURLOPT_UPLOAD, 1);
    curl_setopt($ch, CURLOPT_INFILE, $fp);
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($desfile));
    curl_exec ($ch);
    $error_no = curl_errno($ch);
    curl_close ($ch);
        if ($error_no == 0 || $error_no == 18) {
            $callback = array('link'=>$http_server.$filename , 'name'=> $filename);
        } else {
            $callback = $error_no;
        }
return $callback;
}

function ftp_get_file_names()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "ftp://$ftp_server/");
    curl_setopt($ch, CURLOPT_PORT, $FTP_CONNECTION_PORT);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $FTP_CONNECTION_USERNAME.":".$FTP_CONNECTION_PASS);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_DIRLISTONLY, TRUE);
    $files_list = curl_exec($ch);
    curl_close($ch);

    // The list of all files names on folder
    $file_names_array= explode("\n", $files_list);
    // Filter and exclude array elements not valid
    foreach ($file_names_array as $file_name)
    {
        if (preg_match('#^'.FILES_PREFIX.'#', $file_name) === 1) {
            $file_names[] = $file_name;
        }
    }
    return $file_names;
}

function yawar_get_aparat_videos($aparatkey,$keytype='',$vnumber='') {
if(!is_array($aparatkey)){
$aparatkey= (strpos($aparatkey, 'https://www.aparat.com/') !== false) ? after_last('/', $aparatkey ) : $aparatkey;
}
if ($keytype==='channel'||empty($keytype)) {
  $aurl = 'https://www.aparat.com/etc/api/videoByUser/username/'.$aparatkey.'/perpage/'.$vnumber;
  $chvid= yawar_get_json_data($aurl);
  $loopvids= $chvid->videobyuser;
  $fetchtype= (!empty($loopvids)) ? 'videobyuser' : 'videobytag' ;
}
if ($keytype==='MULTIVIDEO'){
  foreach ($aparatkey as $key => $videokey) {
    $msvids[$key]= array('uid' => $videokey);
  }
  $loopvids = $msvids;
  $loopvids = array_map(function($loopvids){return (object)$loopvids;}, $loopvids);
}
if ($fetchtype=='videobytag') {
  $aurl='https://www.aparat.com/etc/api/videobytag/text/'.$aparatkey;
  $chvid= yawar_get_json_data($aurl);
  $loopvids= $chvid->videobytag;
}
if ($keytype==='singlevideo'||empty($loopvids)) {
  $loopvids = array(array('uid'=>$aparatkey));
  $loopvids = array_map(function($loopvids){return (object)$loopvids;}, $loopvids);
}

foreach ($loopvids as $item) {
  //https://www.aparat.com//video/video/config/videohash/$aparatkey/watchtype/site
  //https://www.aparat.com/etc/api/video/videohash/$aparatkey
  $svdata= yawar_get_json_data('https://www.aparat.com//video/video/config/videohash/'.$item->uid.'/watchtype/site'); 
  $svxml = (simplexml_load_file("https://www.aparat.com//video/video/config/videohash/".$item->uid."/watchtype/site","SimpleXMLElement", LIBXML_NOERROR |  LIBXML_ERR_NONE)) ? simplexml_load_file("https://www.aparat.com//video/video/config/videohash/".$item->uid."/watchtype/site") : "";
  if(empty($svxml)){echo '<p class="ltr text-left f-nim grey-text text-center"><i class="fas fa-exclamation-triangle pr-1 align-text-top amber-text"></i>Aparat Error: failed to fetch this video id: '.$item->uid.', So im ignored it</p>' ; continue;}
  $vurl = before_last('__', $svxml->file );
  $viQuality = between_last('-','p', $vurl);
if (!empty($viQuality)) {
    switch ($viQuality) { //increase video Quality.
      case '720':
        $avaiqu= array('720p','480p','360p');
        break;
      case '480':
        $avaiqu= array('720p','480p','360p');
        break;
      case '360':
        $avaiqu= array('480p','360p','240p');
        break;
      case '270':
        $avaiqu= array('360p','270p','240p');
        break;
      case '240':
        $avaiqu= array('360p','270p','240p');
        break;
      case '144':
        $avaiqu= array('240p','144p');
        break;
      default:
        $avaiqu= array($viQuality.'p');
        break;
    }
  $x=0;
  foreach ($avaiqu as $value) {
  $thisvurl= before_last('-', $vurl).'-'.$value.'.mp4';
  $file_headers = @get_headers($thisvurl);
    if (strpos($file_headers[0], '200') !== false) {
      $Avurl[$x]=$thisvurl;
      $x++;
    }
  }
}else{$Avurl[0]=$vurl.'.mp4';}
  $Avfile=$Avurl;
  $Avposter= $svdata->video->big_poster;
  $Avtitle= $svdata->video->title;
  $Avdescription= $svdata->video->description;
  $Avuid= $item->uid;
  $Avuserid= $svdata->video->username;
  $Avusername= $svdata->video->sender_name;
  $Avuserpage= 'https://www.aparat.com/'.$Avuserid;
  $Avlink= 'https://www.aparat.com/v/'.$Avuid;
  $Avuserlogo= $svdata->video->profilePhoto;
  $Avvisits= 0+$svdata->video->visit_cnt;
  $Avlikes= 0+$svdata->video->like_cnt;
  $Avcat= $svdata->video->cat_name;
  $Avtags= $svdata->video->tags; foreach ($Avtags as $key => $tag) {$Avtags[$key] = $tag->name;}
  $Avdate= $svdata->video->create_date;  
  $Aisofficial= $svdata->video->official;

  $videodata[]=array('data'=> array('from'=>'aparat', 'vid'=>$Avuid, 'title'=>$Avtitle, 'description'=>$Avdescription, 'video'=>$Avfile, 'poster'=>$Avposter,'alink'=>$Avlink, 'userid'=>$Avuserid, 'username'=>$Avusername, 'userlink'=>$Avuserpage, 'userlogo'=> $Avuserlogo, 'official'=> $Aisofficial, 'adate'=>$Avdate,'tags'=> $Avtags, 'cat'=>$Avcat , 'likes'=>$Avlikes, 'views'=>$Avvisits, 'quality'=>$avaiqu));
  $c++;  if ($c==$vnumber) {break;}
} //end foreach.
return $videodata;
}//end func.

/**
 * Youtube Fetch System.
 **/
function yawar_get_youtubevideos($youtubeurl){
  $youtubekey= (strpos($youtubeurl, 'https://www.youtube.com/') !== false) ? after_last('/watch?v=', $youtubeurl ) : $youtubeurl;
  $videosrc= yawar_get_youtubevideo_info($youtubekey);
  return $videosrc;
}

function yawar_get_youtubevideo_info($video_id) {
  $vinfo = 'https://www.youtube.com/get_video_info?video_id='.$video_id; 
  $video_data= file_get_contents($vinfo);
  $wm_string = iconv("windows-1251", "utf-8", $video_data);
  parse_str(urldecode($wm_string), $result);
  $json = json_encode($result);
  $end= json_decode($json,true);
  $video= after('url=',$end['url_encoded_fmt_stream_map']);
  return $video;
  /*echo '<div class="col-10 mx-auto position-relative">
      <div class="video p-1">
       <video class="video-fluid w-100" poster="" controls>
      <source src="'.$video.'" type="video/mp4">
          Your browser does not support the video tag.
      </video>
      </div>
  <hr>';
  echo '</div>'; */
}

function yawar_get_json_data($jsonURL){
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $jsonURL);
$result = curl_exec($ch);
curl_close($ch);
$pdata= json_decode($result);
return $pdata;
}

    function after ($thisvar, $inthat)
    {
        if (!is_bool(strpos($inthat, $thisvar)))
        return substr($inthat, strpos($inthat,$thisvar)+strlen($thisvar));
    };

    function after_last ($thisvar, $inthat)
    {
        if (!is_bool(strrevpos($inthat, $thisvar)))
        return substr($inthat, strrevpos($inthat, $thisvar)+strlen($thisvar));
    };

    function before ($thisvar, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $thisvar));
    };

    function before_last ($thisvar, $inthat)
    {
        return substr($inthat, 0, strrevpos($inthat, $thisvar));
    };

    function between ($thisvar, $that, $inthat)
    {
        return before ($that, after($thisvar, $inthat));
    };

    function between_last ($thisvar, $that, $inthat)
    {
     return after_last($thisvar, before_last($that, $inthat));
    };
// use strrevpos function in case your php version does not include it
function strrevpos($instr, $needle)
{
    $rev_pos = strpos (strrev($instr), strrev($needle));
    if ($rev_pos===false) return false;
    else return strlen($instr) - $rev_pos - strlen($needle);
};

?>