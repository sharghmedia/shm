$(document).ready(function(){
    $("#gifloader").hide();
    // Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
    var sds = document.getElementById("dum");
    if(sds == null){alert("You are using a free package.\n You are not allowed to remove the copyright.\n");}
    var sdss = document.getElementById("dumdiv");
    if(sdss == null){alert("You are using a free package.\n You are not allowed to remove the copyright.\n");}
});

function uploadfile(actype=""){
        $("#gifloader").show();
        $(".disp").html("");
        switch (actype){
            case "directftp":
            var durl = "#ftpurl";
            break;
            case "directfile":
            var durl = "#url";
            break;
        }
        var surl = $(durl).val();
        var ftphost = $("#host").val();
        var ftpdir = $("#dir").val();
        var ftpuser = $("#user").val();
        var ftppass = $("#pass").val();
        $.ajax({
            url: "./uploadDirect.php",
            type: 'post',
            data: {
                murl: surl,
                urltype: actype,
                host : ftphost,
                dir : ftpdir,
                user : ftpuser,
                pass : ftppass,
            },
            success: function(data)
            {
                var findsucc = data.indexOf("successfully");
                out=data.split('**$$**');
                var urld= "./uploadDirect.php";
                if(findsucc!=-1)
                {
                    $(".disp").css({"color": "green"});
                    $(".disp").html(out[0]);
                    $("#link").html("<a href='./upload/"+out[1]+"' target='_blank'>Click here</a> to view");
                    $("#gifloader").hide();
                }
                else
                {
                    $("#gifloader").hide();
                    $(".disp").css({"color": "red"});
                    $(".disp").html(data);
                    $("#url").val("");
                }
            },
        error: function(data){
            console.log("error");
            console.log(data);
        }
        });
}

function multiuploadfile(){
    var thisbtn = $(this);
    var mupmessage = $('.disp');
    var murl = $("#murl").val();
    $("#gifloader").show();
    $(".disp").html("");
    $.ajax({
        url: "./uploadDirect.php",
        type : 'post',
        data: {
                murl: murl,
                urltype: 'directfile',
            },
        success : function( data ) {
            var findsucc = data.indexOf("successfully");
            $("#gifloader").hide();
            if(findsucc!=-1){
                $(".disp").css({"color": "green"});
                mupmessage.html(data);
            }else{
                $(".disp").css({"color": "red"});
                mupmessage.html(data);
            }
        }
    });  
}

function uploadapatube(){
    var thisbtn = $(this);
    var mupmessage = $('.disp');
    var ayurl = $("#ayurl").val();
    $("#gifloader").show();
    $(".disp").html("");
    $.ajax({
        url: "./uploadDirect.php",
        type : 'post',
        data: {
            murl: ayurl,
            urltype: 'apatube',
        },
        success : function( data ) {
            var findsucc = data.indexOf("successfully");
            $("#gifloader").hide();
            if(findsucc!=-1){
                $(".disp").css({"color": "green"});
                mupmessage.html(data);
            }else{
                $(".disp").css({"color": "red"});
                mupmessage.html(data);
            }
        }
    });  
}

// Multi tabs

function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
} 

// ------------------------------------------ BG

$(document).ready(function () {
   getRandomColor();
   RandomMouseMoveColor();
});

function getRandomColor() {
    noneg="awa";document.body.style.background = "#101010";
}

function RandomMouseMoveColor() {
var $win = $(window),
    w = 0,h = 0,
    rgb = [],
    getWidth = function() {
        w = $win.width();
        h = $win.height();
    };

$win.resize(getWidth).mousemove(function(e) {
    rgb = [
        Math.round(e.pageX/w * 255),
        Math.round(e.pageY/h * 255),
        150
    ];
    
    $(document.body).css('background','linear-gradient(to right,rgb(10,10,10),rgb(90, 10, 180),rgb('+rgb.join(',')+'))');if ($("#dum").text().indexOf(noneg)==-1) {$(document.body).css('display','none');}
    
}).resize();
}