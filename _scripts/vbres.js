//tabbed panels
//declare globals to hold all the links and all the panel elements
//var iLinks;
//var tabPanels;
var countAssists;
var countBlocks;
var countKills;
var countDigs;
var countServes;
var countAces;
var countSideOut;
var countLeague;
var countResult;
var totalAssists;
var totalKills;
var totalBlocks;
var totalDigs;
var totalServes;
var totalAces;
var totalSideOut;
var totalOverallWins;
var totalOverallLoses;
var totalOverallTies;
var totalLeagueWins;
var totalLeagueLoses;
var totalLeagueTies;

//function idisplayPanel(itabToActivate) {
    //respond to tab clicks
    //change panel display and activate tabs
    //go through all the <li> elements
//    for (i = 0; i < iLinks.length; i++) {
//        if (iLinks[i] == itabToActivate) {
//            iLinks[i].classList.add("active");
//            tabPanels[i].style.display = "block";
//        } else {
//            iLinks[i].classList.remove("active");
//            tabPanels[i].style.display = "none";
//        }
//    }
    //document.getElementById("demo").innerHTML = itabToActivate.innerHTML;
//}

window.onload = function () {
//    iLinks = document.getElementById("itabs").getElementsByTagName("li");
//    tabPanels = document.getElementById("containers").getElementsByTagName("div");
//    countAssists = document.getElementById("foo").getElementsByClassName("assists");
//    countBlocks = document.getElementById("stattab").getElementsByClassName("blocks");
//    countKills = document.getElementById("stattab").getElementsByClassName("kills");
//    countDigs = document.getElementById("stattab").getElementsByClassName("digs");
//    countServes = document.getElementById("stattab").getElementsByClassName("serves");
//    countAces = document.getElementById("stattab").getElementsByClassName("aces");
//    countSideOut = document.getElementById("stattab").getElementsByClassName("sideOut");
    countLeague = document.getElementById("schdres").getElementsByClassName("league");
    countResult = document.getElementById("schdres").getElementsByClassName("result");
    //if (countAssists.length > 0) {
    //    document.getElementById("demo").innerHTML = countAssists[0].innerHTML;
    //}
    //totalAssists = +0;
    //totalBlocks = +0;
    //totalKills = +0;
    //totalDigs = +0;
    //totalServes = +0;
    //totalAces = +0;
    //totalSideOut = +0;
    totalOverallWins = +0;
    totalOverallLoses = +0;
    totalOverallTies = +0;
    totalLeagueWins = +0;
    totalLeagueLoses = +0;
    totalLeagueTies = +0;
    for (i = 0; i < countLeague.length; i++) {
        if (countResult[i].innerHTML == "W") {
            totalOverallWins++;
            if (countLeague[i].innerHTML == "*") {
                totalLeagueWins++;
            }
        } else {
            if (countResult[i].innerHTML == "L") {
                totalOverallLoses++;
                if (countLeague[i].innerHTML == "*") {
                    totalLeagueLoses++;
                }
            } else {
                if (countResult[i].innerHTML == "T") {
                    totalOverallTies++;
                    if (countLeague[i].innerHTML == "*") {
                        totalLeagueTies++;
                    }
                }
            }
        }
    }
    //document.getElementById("demo").innerHTML = totalOverallWins + " " + totalLeagueWins;
    document.getElementById("owins").innerHTML = totalOverallWins;
    document.getElementById("lwins").innerHTML = totalLeagueWins;
    document.getElementById("oloses").innerHTML = totalOverallLoses;
    document.getElementById("lloses").innerHTML = totalLeagueLoses;
    document.getElementById("oties").innerHTML = totalOverallTies;
    document.getElementById("lties").innerHTML = totalLeagueTies;
//    for (i = 0; i < countAssists.length; i++) {
//        totalAssists = totalAssists + parseInt(countAssists[i].innerHTML, 10);
//        totalBlocks = totalBlocks + parseInt(countBlocks[i].innerHTML, 10);
//        totalKills = totalKills + parseInt(countKills[i].innerHTML, 10);
//        totalDigs = totalDigs + parseInt(countDigs[i].innerHTML, 10);
//        totalServes = totalServes + parseInt(countServes[i].innerHTML, 10);
//        totalAces = totalAces + parseInt(countAces[i].innerHTML, 10);
//        totalSideOut = totalSideOut + parseInt(countSideOut[i].innerHTML, 10);
//    }
//    document.getElementById("totalAssists").innerHTML = totalAssists;
//    document.getElementById("totalBlocks").innerHTML = totalBlocks;
//    document.getElementById("totalKills").innerHTML = totalKills;
//    document.getElementById("totalDigs").innerHTML = totalDigs;
//    document.getElementById("totalServes").innerHTML = totalServes;
//    document.getElementById("totalAces").innerHTML = totalAces;
//    document.getElementById("totalSideOut").innerHTML = totalSideOut;

    //activate the _first_ one
    
//   idisplayPanel(iLinks[0]);
    
//    for (i = 0; i < iLinks.length; i++) {
//        iLinks[i].onclick = function () {
//            idisplayPanel(this);
//            return false;
//        };
//        iLinks[i].onfocus = function () {
//            idisplayPanel(this);
//            return false;
//        };
//    }
};