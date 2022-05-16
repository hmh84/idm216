function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    $(".sidenav").css({
        "box-shadow": "1px 10px 20px 7px rgba(0,0,0,0.15)"
    })
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  $(".sidenav").css({
      "box-shadow": "none"
  })
}

//google map stuff
//using this api : https://developers.google.com/maps/documentation/javascript/overview

let map;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: {
      lat: 39.9526,
      lng: -75.1652
    },
    zoom: 15,
    disableDefaultUI: true
  });
}

// If the page is year at glance, check if May or $16-20 is missing from charts, if so fix them

// if (page_title == 'Year at Glance') {

//   function insertAfter(el, referenceNode) {
//     referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
//   }

//   function checkCharts() {

//     // Setup tags for checks
    
//     document.querySelectorAll('text').forEach(text => {
//       text.dataset.innerhtml = text.innerHTML;
//     });

//     // Check Month Chart

//     if (!document.querySelector('text[data-innerhtml="May"]')) {
//       var ref_node = document.querySelector('text[data-innerhtml="Apr"]');
//       var new_html = 'May';
//       var new_x = '151.67721519';
//       var new_dx = '-11.310546875px';

//       fixCharts(ref_node, new_html, new_x, new_dx);
//     }

//     // Check Price Range Chart

//     if (!document.querySelector('text[data-innerhtml="$16-20"]')) {
//       var ref_node = document.querySelector('text[data-innerhtml="$11-15"]');
//       var new_html = '$16-20';
//       var new_x = '185.989795918';
//       var new_dx = '-16.5009765625px';

//       fixCharts(ref_node, new_html, new_x, new_dx);
//     }

//     // Perform Fix

//     function fixCharts(ref_node, new_html, new_x, new_dx) {
//       var new_node = ref_node.cloneNode(true);
//       new_node.innerHTML = new_html;
//       new_node.setAttribute('x', new_x);
//       new_node.setAttribute('dx', new_dx);
    
//       insertAfter(new_node, ref_node);
//     }

//   }

//   // Wait until chart loads, then call the function after .75 secs just to be sure
//   var checkExist = setInterval(function() {
//     if ($('text[data-innerhtml="Jun"]')) {
//       setTimeout(function() {
//         checkCharts();
//       }, 750);
//       clearInterval(checkExist);
//     }
//   }, 100);
// }