function showNews(xml) {
    let xmlDoc = xml.responseXML;
    let items = xmlDoc.getElementsByTagName("item");
    let newsHTML = "";

    for (let i = 0; i < items.length; i++) {
        let title = items[i].getElementsByTagName("title")[0].childNodes[0].nodeValue;
        let description = items[i].getElementsByTagName("description")[0].childNodes[0].nodeValue;
        let image = items[i].getElementsByTagName("image")[0].childNodes[0].nodeValue;

        newsHTML += "<a class='no-link-style' id='news-item'><strong>" + "Type: " + title +
                    "</strong><br>" + "<img src='assets/Logo.png' id='news-logo' alt='logo'>" + "<img src='"+ image + "' id='news-image' alt='animals'><strong>" +
                    "<div id='news-description'>" + "Details: " + "</strong><br>" +description + "<br>..." + "</div></a>";
    }
    document.getElementById("news").innerHTML = newsHTML;
}

let XMLHttp = new XMLHttpRequest();
XMLHttp.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        showNews(this);
    }
};
XMLHttp.open("GET", "feed.xml", true);
XMLHttp.send();