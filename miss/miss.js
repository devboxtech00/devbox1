$(window).scroll(function() {
    if ($(this).scrollTop() > 20) {
        $('.fixedhead').addClass('stickytop');
    } else {
        $('.fixedhead').removeClass('stickytop');
    }
});
$('.dropdown-menu a').on('click', function() {
    var getValue = $(this).text();
    $('.dropSelect').text(getValue);
});

var owl = $("#owl");

owl.owlCarousel({
    loop: false,
    margin: 20,
    nav: true,
    dots: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 5
        }
    }
});


$("<span class='dropdown_arrow dektop_arw'></span>").insertAfter(".navbar-nav li.menu-item-has-children > a");


$('.navbar-nav li .dektop_arw').click(function (e) {
  e.preventDefault();
  var $this = $(this);

  if ($this.next().hasClass('show')) {
    $this.next().removeClass('show');
    $this.removeClass('toggled');
    $this.parent().removeClass('active');
    console.log("if");
  } else {
    $this.parent().parent().find('.sub-menu').removeClass('show');
    $this.parent().parent().find('.toggled').removeClass('toggled');
    $this.parent().parent().find('.active').removeClass('active');
    $this.next().toggleClass('show');
    $this.toggleClass('toggled');
    $this.parent().addClass('active');
    console.log("else");
  }
});

$(".navbar-nav li.menu-col-2").attr("data-aos", "fade-right");
$(".navbar-nav li.menu-col-1").attr("data-aos", "fade-right");



//api fetch
var site_url = '<?php echo home_url(); ?>';
async function  fetchbuisness(pram1,type,page) {

      pram1 = pram1 ? pram1 : ''; 
      type = type ? type : ''; 
      page = page ? page : '1';
      jQuery("#buisnes_sech_api").html("");
      jQuery("#allbizsearch").html('<div class="mydata_api"><span class="loader"></span></div>');
      
    const fetchbuisnessAPI = await fetch(site_url+"/wp-json/customapi/v1/myapi/page/"+page+"/?type="+type+"&pram1="+pram1, {
      method: 'GET',
      headers: {
          "Accept": "application/json;charset=UTF-8",
          "Content-Type": "application/json;charset=UTF-8",
          "Cache-Control": "no-cache",
      },
      });
  
      var responseresults = await fetchbuisnessAPI.json();
      var mydata = ""; 
   
     
      //console.log(responseresults.data[0].mypost_title);

      //console.log(total+" ",total_page+" ",currentPage);
      if(responseresults.data.length > 0){
      for (var i = 0; i < responseresults.data.length; i++) {

          var mypostID = responseresults.data[i].mypost_id;
          var mypostTitle = responseresults.data[i].mypost_title;
          var mypostUrl = responseresults.data[i].mypost_url;
          var mypostAddress = responseresults.data[i].mypost_address;
          var mypostDescription = responseresults.data[i].mypost_descriptions;
          var mypostbadges = responseresults.data[i].badges;
          var mypost_img_url = responseresults.data[i].img_url;
          var mypostRatings = responseresults.data[i].rating_biz;

          mydata += '<div class="search-listing-box"><div class="search-list-item"><div class="search-img-box"><img src="'+mypost_img_url +'" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="'+mypostTitle +'"></div><div class="search-content-box"><div class="search-content-heading"><h3>'+mypostTitle+'</h3><ul>';
          showstars(parseInt(mypostRatings),"filled");
          showstars(5-parseInt(mypostRatings),"empty");
       
           function showstars(value,type) {
           if(value > 0){
            if(type == "empty"){
                mydata += '<li><i class="fa-solid fa-star"></i></li>';
            }else if(type == "filled"){
                mydata += '<li class="active"><i class="fa-solid fa-star"></i></li>';
           }
            value = value-1;
            showstars(value,type);
            } else {
            return null;
           }
          }
          mydata = mydata.concat('</ul></div><p><span>Address:</span>'+mypostAddress +'</p>');
          mypostbadges.forEach(showbadges);
          function showbadges(value, index, array) {
            mydata += '<div class="search-content-subheading"><img src="'+site_url+'/wp-content/themes/fcr/images/right-circle.png" alt=""<h3>'+value+'</h3></div>'; 
          }
          mydata += mypostDescription+' <div class="search-report-heading"><h3>Fair Commerce Reports Score:</h3><p class="badge-no green-color">'+businesFcrScore +'</p></div></div></div></div>';
      }
      jQuery("#mydata").html(mydata);
     
      window.scrollTo(xCoord, yCoord);

      if(responseresults.paged != null){
        jQuery("#mydata_api").html(responseresults.paged);

        jQuery("#mydata_api .page-numbers li a").on("click", function(e){
        e.preventDefault();
        var pageLink = jQuery(this).attr("href");
        pageLink = pageLink.split('?')[0]
        var pageNo = pageLink.slice(-2);
        var pageNo = pageLink.slice(-2);
        pageNo = pageNo.substring(0,pageNo.length-1);
        //console.log(pageNo);
        fetchbuisness("","","",pageNo);
        // window.scrollTo(xCoord, yCoord);
        window.scrollTo({ top: 0, behavior: 'smooth' });
      })
      } else {
        jQuery("#mydata_api").html("");
      }

      
    } else{
      myposts = "<h2>No Result Found</h2>"
      jQuery("#mydata_api").html(myposts);
      jQuery("#mydata_api").html("");
    }
      
    //  if(resultfound == 0 || resultfound == 1){
    //   jQuery("#resultfound").html(resultfound+" Result");
    //   } else {
    //     jQuery("#resultfound").html(resultfound+" Results");
    //   }

      // if(total_page>currentPage){
      //   jQuery(".scroll_hits a").css("display","flex");
      //   console.log("1");
      // }else{
      //   jQuery(".scroll_hits a").css("display","none");
      //   console.log("2");
      // }
  
   //console.log(myposts);
        // if(requestType == "default"){
        //     jQuery("#new_list").html(myposts);
        // }else if(requestType == "filters"){
        //     jQuery("#new_list").html(myposts);
        // } else if(requestType == "loadmore"){
        //     jQuery("#new_list").append(myposts);
        //   if (jQuery(".headingMonth").hasClass("col-md-12")) {
        //     jQuery('.headingMonth').each(function() {
        //     var classM=jQuery(this).attr('class').split(' ')[2];
        //     jQuery('.'+classM+':not(:first)').hide();
        // });
  
        // }
      //   jQuery(".loader_wraper").css('display','none');
      //   }
      //   jQuery(".loader_wraper").css('display','none');
      // jQuery(".scroll_hits").show();
      // console.log("updated");
     //console.log(JSON.parse(responseresults));
  //     } else {
  //       jQuery(".loader_wraper").css('display','none');
  //           jQuery("#new_list").html("<h2>No mypost Found !!</h2>");
  //           jQuery("#resultfound").html("0 Result");
  //     }
  // };
}

// api fetch 2

const loginFrom = document.getElementById('apiloginFrom');
const container = document.getElementById('all_vancy');

loginFrom.addEventListener('submit', function (e){
    e.preventDefault();
    const formData = new FormData(this);
    container.innerHTML = '<span class="loader"></span>';
    
    fetch('../wp-content/themes/child/inc/login.php',{
     method: 'post',
     body: formData
    }).then(function (response){
     console.log("logedin");
     return response.text();

    }).then(function (text) {
     return fetch('../wp-content/themes/child/inc/data_search.php',{
     method: 'post',
     headers: {
     "Content-Type": "application/json"
     },
     body: text,
    }).then(function (vresponse){
     return vresponse.text();
    }).then(function (data) {
     console.log(data);
     
   jQuery("#all_vancy").load(location.href + " #all_vancy");
    });
    }).catch(function(error){
     console.log(error);
    })

});


jQuery(document).ready(function($){ 
    $('#mytable').paging({limit:15}); 

    $(".paging-nav a[data-page=0]").click();
});


//ajax
$.ajax({
    url: siteurl+'/wp-admin/admin-ajax.php',
    
    data: {'action':'actioname',
           'data':data
          },
    type:'post',
    // beforeSend:function(xhr){
    //            
    //           },
    success: function(result){
     console.log("sucess52");
     
    },
    error:function(result){
      console.warn(result);
     // location.reload();
  
    }
  })

// timer 


function custoomCountDown($countDownDate,$now, $destination){
    var x = setInterval(function() {
    $now = $now + 1000;
    // Find the distance between now an the count down date
    var distance = $countDownDate - $now;
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // Output the result in an element with id="demo"
    if(days > 1){
    document.getElementById($destination).innerHTML =days +" Days "+hours+ " Hrs "+ minutes + " Min " + seconds + " Sec";
    } else if(days >= 0){
        document.getElementById($destination).innerHTML =days +" Day "+hours+ " Hrs "+ minutes + " Min " + seconds + " Sec";  
    }
    // If the count down is over, write some text 
    if (distance < 0) {
    clearInterval(x);
    document.getElementsById($destination).innerHTML = "EXPIRED";
    location.reload();
    }
    }, 1000);
}

// swipe menue
$(function() {
    // prob a better way
    $('.mymenue .nav').each(function(e) {
      var snapper = new Snap({
          element: this,
          maxPosition: 150,
          minPosition: -150,
        
      });
    });
   
    $('.delete').on('click', function(e){
      $(this).parent().slideToggle(100);
    });  
  });




  // google auto complete

  // banner form


  google.maps.event.addDomListener(window, "load", function () {
    var places = new google.maps.places.Autocomplete(
      document.getElementById("serchinput"),
    { componentRestrictions: {country: 'IN'}});
    google.maps.event.addListener(places, "place_changed", function () {
      var place = places.getPlace();
      console.log(place)
      var latitude = place.geometry.location.lat();
      var longitude = place.geometry.location.lng();
      var latlng = new google.maps.LatLng(latitude, longitude);
      var geocoder = (geocoder = new google.maps.Geocoder());
      geocoder.geocode({ latLng: latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            var pin =
              results[0].address_components[
                results[0].address_components.length - 1
              ].long_name;

            var city =
              results[0].address_components[
                results[0].address_components.length - 4
              ].long_name;

              $("#city").val(city);
              $("#pin").val(pin);	
          }
        }
      });
    });
  });


  