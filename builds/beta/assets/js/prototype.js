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