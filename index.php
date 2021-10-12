<!DOCTYPE html>
<!--
Script Name: yawarDUP ;
Author: Eng. yawar ;
Author URI: https://yawar.ir ;
Version: 4
-->
<?php
/*
    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:login.php'); die();
    }
*/
?>
<html>

    <head>
        <title>YawarDup | Direct Upload Script</title>       
		<link rel="stylesheet" href="asset/dropzone.css">
        <link rel="stylesheet" type="text/css" href="asset/style.css">
        <script type="text/javascript" src="asset/jquery.js"></script>
        <script src="asset/dropzone.js"></script>
        <script src="asset/custom.js"></script>
    </head>
<body>
<div class="master">
<div id="stitle"><h1 style="color: #ffffff51">YawarDUP</h1> 
<h2 class="ff-vazir">لذت آپلود آسان و سریع را تجربه کنید</h2>
</div>

 <!-- Tabs -->
 <div id="tabs-container">
 <!-- Tab links -->
<div class="tab ff-vazir">
    <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">آپلود مستقیم</button>
    <button class="tablinks" onclick="openCity(event, 'birjand')">آپلود مستقیم به FTP</button>
    <button class="tablinks" onclick="openCity(event, 'Paris')">آپلود مستقیم گروهی</button>
    <button class="tablinks" onclick="openCity(event, 'tehran')">آپلود از آپارات و یوتیوب</button>
    <button class="tablinks" onclick="openCity(event, 'Tokyo')">آپلود از کامپیوتر</button>
</div>

<!-- Tab content -->
<div id="London" class="tabcontent">
  <p>لینک مستقیم فایل را وارد کنید و دکمه آپلود را بزنید.</p>
<!-- start Single Direct Upload -->
<div id="inputwrap">
<fieldset class="formholder" dir="ltr">
<input data-act="directfile" class="Singleurl" type="text" placeholder="Ex: https://site.ir/dl/file.zip" name="url" id='url'>
<input class="submitbtn" type="submit" id='submit' value="Upload" name="submit" onclick='uploadfile("directfile")'>
</fieldset>
</div>
</div>
     
<div id="birjand" class="tabcontent">
  <p>براحتی درون هر هاست دیگری آپلود کنید</p>
<!-- start Single Direct Upload -->
<div id="inputwrap">
<fieldset class="formholder" dir="ltr">
<table class="ftptable">
  <tr>
    <td>
ftp Host:<br>
<input class="" type="text" placeholder="Yawar.IR" id='host'>
    </td>
    <td>
ftp User:<br>
<input class="" type="text" placeholder="ftpuser" id='user'>
    </td>
    <td>
ftp Pass:<br>
<input class="" type="text" placeholder="***" id='pass'>
    </td>
    <td>
ftp Directory:<br>
<input class="" type="text" placeholder="myfolder" id='dir'>
    </td>
  </tr>
</table>
<input class="Singleurl" type="text" placeholder="Ex: https://site.ir/dl/file.zip" name="url" id='ftpurl'>
<input class="submitbtn" type="submit" id='submit' value="Upload" name="submit" onclick='uploadfile("directftp")'>
</fieldset>
<div class="pnote">
<p>دقت کنید که آدرس پوشه public_html بصورت خودکار به آدرس Ftp اضافه خواهد شد</p>
<p>فقط اگر پوشه ای درون public_html مد نظر شماست در بخش ftp Directory وارد کنید</p>
</div>
</div>
</div>
     
<div id="Paris" class="tabcontent">
  <p>پس از وارد کردن هر لینک یک اینتر بزنید و سپس لینک بعدی را قرار دهید.</p>
<!-- start Multi Direct Upload -->
<div id="inputwrap">
<fieldset class="multifile" dir="ltr">
<textarea type="text" name="murl" id="murl" placeholder="insert Link and press Enter" data-id="fdescription" class="" rows="4" ></textarea>
<input class="submitbtn" type="submit" id='multisubmit' value="Upload All" name="multisubmit" onclick='multiuploadfile()'>
</fieldset>
</div>
</div>

<div id="tehran" class="tabcontent">
<p>لینک صفحه ویدئو در آپارات یا یوتیوب را وارد کنید .</p>
<!-- start Multi Direct Upload -->
<div id="inputwrap">
<fieldset class="formholder" dir="ltr">
<input class="Singleurl" type="text" placeholder="Ex: https://www.youtube.com/watch?v=HptpYc5aLwg" name="ayurl" id='ayurl'>
<input class="submitbtn" type="submit" id='aysubmit' name="aysubmit" value="Upload video" onclick='uploadapatube()'>
</fieldset>
<div class="pnote">
<p>زمان انتظار معمولا باید حداکثر 2 دقیقه باشد</p>
<p>آپلود از یوتیوب فقط بر روی هاست دانلودهای خارج میسر است</p>
</div>
</div>
</div>

<div id="Tokyo" class="tabcontent">
  <p>فایلها را از کامپیوتر خود انتخاب کرده و آپلود نمایید.</p>
<!-- start Local Upload -->
<form class="dropzone" action="uploadLocal.php" method="post" enctype="multipart/form-data">
</form>
</div> 
</div> <!-- END TABS --> 
<br/>

<div id='gifloader'><img src='asset/ajax-loader.gif'></div>
<div class="disp" align='center'>
</div>
<br>
</div>
<footer>
    <div class="note">
    <small>
        <a href="https://yawar.ir/?p=5537" target="_blank" title="Click here for More information about this script">Need Help ?</a>
    </small>
    </div>
    <div id="dumdiv">
    <a href="https://yawar.ir" id="dum">&copy;yawar</a>
    </div>
</footer>
</body>
</html>
