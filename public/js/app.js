/* -----------------------------------------------
/* How to use? : Check the GitHub README
/* ----------------------------------------------- */

/* To load a config file (particles.json) you need to host this demo (MAMP/WAMP/local)... */
/*
particlesJS.load('particles-js', 'particles.json', function() {
  console.log('particles.js loaded - callback');
});
*/

/* Otherwise just put the config content (json): */

particlesJS('particles-js',
  
  {
    "particles": {
      "number": {
        "value": 80,
        "density": {
          "enable": true,
          "value_area": 800
        }
      },
      "color": {
        "value": "#ffffff"
      },
      "shape": {
        "type": "circle",
        "stroke": {
          "width": 0,
          "color": "#000000"
        },
        "polygon": {
          "nb_sides": 5
        },
        "image": {
          "src": "img/github.svg",
          "width": 100,
          "height": 100
        }
      },
      "opacity": {
        "value": 0.5,
        "random": false,
        "anim": {
          "enable": false,
          "speed": 1,
          "opacity_min": 0.1,
          "sync": false
        }
      },
      "size": {
        "value": 5,
        "random": true,
        "anim": {
          "enable": false,
          "speed": 40,
          "size_min": 0.1,
          "sync": false
        }
      },
      "line_linked": {
        "enable": true,
        "distance": 150,
        "color": "#ffffff",
        "opacity": 0.4,
        "width": 1
      },
      "move": {
        "enable": true,
        "speed": 6,
        "direction": "none",
        "random": false,
        "straight": false,
        "out_mode": "out",
        "attract": {
          "enable": false,
          "rotateX": 600,
          "rotateY": 1200
        }
      }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": {
          "enable": true,
          "mode": "repulse"
        },
        "onclick": {
          "enable": true,
          "mode": "push"
        },
        "resize": true
      },
      "modes": {
        "grab": {
          "distance": 400,
          "line_linked": {
            "opacity": 1
          }
        },
        "bubble": {
          "distance": 400,
          "size": 40,
          "duration": 2,
          "opacity": 8,
          "speed": 3
        },
        "repulse": {
          "distance": 200
        },
        "push": {
          "particles_nb": 4
        },
        "remove": {
          "particles_nb": 2
        }
      }
    },
    "retina_detect": true,
    "config_demo": {
      "hide_card": false,
      "background_color": "#b61924",
      "background_image": "",
      "background_position": "50% 50%",
      "background_repeat": "no-repeat",
      "background_size": "cover"
    }
  }

);

var urlParams = new URLSearchParams(location.search); 

$('.datepicker.statusdate').datetimepicker({
  maxDate: moment(),
  date:startDate,
  useCurrent: false,
  format: 'YYYY-MM-DD',
  // format:"YYYY-MM-DDTHH:MM:SS.SSSZ"
  // clearBtn:true,
  // endDate:"0d",
  //autoclose:true,
  // defaultViewDate: "today",
  // todayHighlight: true,
  // orientation:"bottom"
});

$('.datepicker.statusdate').on('dp.change', function(e) {
  urlParams.set("serverStatus",e.date.format('YYYY-MM-DD'))
  var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + urlParams.toString();
  window.location = newUrl;
});




var startDate = urlParams.get('startDate');
if (startDate!= null) {  
  startDate = moment(startDate);
} else{
  startDate = ''
} 

var endDate = urlParams.get('endDate');
if (endDate!= null) {  
  endDate = moment(endDate);
} else{
  endDate = ''
} 

$('.datepicker.start-date').datetimepicker({
  maxDate: moment(),
  date:startDate,
  useCurrent: false,
  // format:"YYYY-MM-DDTHH:MM:SS.SSSZ"
  // clearBtn:true,
  // endDate:"0d",
   //autoclose:true,
  // defaultViewDate: "today",
  // todayHighlight: true,
  // orientation:"bottom"
});

$('.datepicker.end-date').datetimepicker({
  maxDate: moment(),
  date:endDate,
  useCurrent: false,
  // format:"YYYY-MM-DDTHH:MM:SS.Z",
  // format: 'yyyy-mm-dd',
  // clearBtn:true,
  // endDate:"0d",
  //autoclose:true,
  // defaultViewDate: "today",
  // todayHighlight: true,
  // orientation:"bottom"
});

$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){   
    $('.dropdown-submenu ul').hide();
    $(this).next('ul').show();
    e.stopPropagation();
    e.preventDefault();
  });

  $(document).click(function(){
    $(".dropdown-submenu ul").hide();
  });

  $('[data-toggle="tooltip"]').tooltip();
 
  var urlParams = new URLSearchParams(location.search);
  var name = urlParams.getAll('name[]');


  $('#multi-select-demo').multiselect({
    buttonWidth: 200,
    enableFiltering: true,
    enableCaseInsensitiveFiltering:true
  }); 

  name.forEach(function(item) {
    $('#multi-select-demo').multiselect('select', item);
  });

  $('.multiselect.dropdown-toggle').tooltip({
    placement: 'top',
    container: 'body'  
  }).attr('data-original-title', name != '' ? name.join(',') : 'Please select server');

  var main_container_height = $(".main-content").height();
  $("ul#serverList").css('max-height', main_container_height+'px');
 
});