//tabbed panels
//declare globals to hold all the links and all the panel elements
var iLinks;
var tabPanels;

function idisplayPanel(itabToActivate) {
    //respond to tab clicks
    //change panel display and activate tabs
    //go through all the <li> elements
    for (i = 0; i < iLinks.length; i++) {
        if (iLinks[i] == itabToActivate) {
            iLinks[i].classList.add("active");
            tabPanels[i].style.display = "block";
        } else {
            iLinks[i].classList.remove("active");
            tabPanels[i].style.display = "none";
        }
    }
    //document.getElementById("demo").innerHTML = itabToActivate.innerHTML;
}

window.onload = function () {
    iLinks = document.getElementById("itabs").getElementsByTagName("li");
    tabPanels = document.getElementById("containers").getElementsByTagName("div");
    
    //activate the _first_ one
    
    idisplayPanel(iLinks[0]);
    
    for (i = 0; i < iLinks.length; i++) {
        iLinks[i].onclick = function () {
            idisplayPanel(this);
            return false;
        };
        iLinks[i].onfocus = function () {
            idisplayPanel(this);
            return false;
        };
    }
};