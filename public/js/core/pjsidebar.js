// Get the Sidebar
var mySidebar = document.getElementById("sbPJ");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (document.getElementById('sbPJ').style.display === 'block') {
        document.getElementById('sbPJ').style.display = 'none';
        document.getElementById("myOverlay").style.display = "none";
    } else {
        document.getElementById('sbPJ').style.display = 'block';
        document.getElementById("myOverlay").style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    document.getElementById('sbPJ').style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

function openTab(evt, tabName) {
  var i, x, tablinks, button;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  button = document.getElementById("addButton");
  for (i = 0; i < x.length; i++) {
     tablinks[i].className = tablinks[i].className.replace(" w3-border-green", "");
     tablinks[i].className = tablinks[i].className.replace(" w3-border-yellow", "");
     tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
  }
  document.getElementById(tabName).style.display = "block";
  switch(tabName){
    case "Ativos":
      evt.currentTarget.firstElementChild.className += " w3-border-green";
      break;
    case "Pos":
      evt.currentTarget.firstElementChild.className += " w3-border-yellow";
      break;
    case "Demitidos":
      evt.currentTarget.firstElementChild.className += " w3-border-red";
      break;
  }


}
