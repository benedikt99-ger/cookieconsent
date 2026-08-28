document.addEventListener("DOMContentLoaded",function(){
	
	
	checkCookieSet();
	
	var ccButtons = document.querySelectorAll(".cc-btn");
	
    [].forEach.call(ccButtons, function (currentButton) {
		
		currentButton.addEventListener("click",function(){
            // Variable, die je nach Button-Typ die gewählten Cookie-Kategorien aufnimmt
            var selectedCategories;
			document.cookie="cc-set=1; max-age=31536000; path=/;"; // Grundsätzlichen Zustimmungs-Cookie setzen.

           if (this.classList.contains("cc-save")) {
                // Fall: Button "Auswahl speichern" Alle aktuell angehakten (":checked") Kategorie-Checkboxen auslesen
                var checkedCheckboxes = document.querySelectorAll(".cc-category:checked");

                // NodeList in ein echtes Array umwandeln und daraus nur die "value"-Attribute extrahieren
                selectedCategories = Array.prototype.slice
                    .call(checkedCheckboxes, 0)
                    .map(function (checkbox) {
                        return checkbox.value;
                    });
                // Ausgewählte Kategorien als JSON-String im Cookie speichern
                document.cookie =
                    "cc-categories=" + JSON.stringify(selectedCategories) + "; max-age=31536000; path=/;";

            } else if (this.classList.contains("cc-allow-only")) {
                // Fall: Button "Nur bestimmte Kategorie(n) erlauben" Die erlaubten Kategorien stehen als Datenattribut direkt am Button (data-cc-categories="...")
                selectedCategories = currentButton.getAttribute("data-cc-categories");
                document.cookie = "cc-categories=" + JSON.stringify(selectedCategories) + "; max-age=31536000; path=/;";

            } else if (this.classList.contains("cc-allow-all")) {
                // Fall: Button "Alle erlauben" Die erste gefundene Kategorie-Checkbox wird angehakt (vermutlich stellvertretend für "alle")
                document.querySelector(".cc-category").checked = true;
                document.cookie = "cc-categories=ALL; max-age=31536000; path=/;";// Spezieller Wert "ALL" wird im Cookie gespeichert
            } else if (this.classList.contains("cc-disallow-all")) {
                // Fall: Button "Alle ablehnen" Checkbox wird deaktiviert
                document.querySelector(".cc-category").checked = false;
                document.cookie = "cc-categories=NONE; max-age=31536000; path=/;";// Spezieller Wert "NONE" wird im Cookie gespeichert
            }		
			
			document.querySelector(".cc-window").style.display="none"; // Das Cookie-Consent-Fenster ausblenden
			
			return false;
        });
    });
});

var ccWindow = document.querySelector('.cc-window');
var ccLink=document.querySelector(".cc-link");
ccLink.addEventListener("click",function(event){
	document.querySelector(".cc-window").style.display = "inherit";
	return false;
});

const showBtn = document.getElementById("show");
const output = document.getElementById("cookie-value");
showBtn.addEventListener("click", () => {
  displayCookies();
});

function checkCookieSet() {
  const cookies = document.cookie.split(';').map(c => c.trim());
  const isSet = cookies.some(c => c.startsWith('cc-set='));

  if (isSet) {
    console.log('Cookie "cc-set" ist gesetzt.');
  } else {
    console.log('Cookie "cc-set" ist NICHT gesetzt.');
	document.querySelector(".cc-window").style.display="inherit"; // Das Cookie-Consent-Fenster ausblenden
  }

  return isSet;
}

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function displayCookies() {
var ccSet=getCookie("cc-set");
if (ccSet==null) {ccSet="null";}
ccSet="ccSet="+ccSet;

var ccCategories=getCookie("cc-categories");
if (ccCategories==null) {ccCategories="";}
if (ccCategories!="") {ccCategories="ccCategories="+ccCategories;}

output.textContent = ccSet + " " + ccCategories;
}
