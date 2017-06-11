/**
 * Some helper functions to deal with rss feeds.
 * 
 * @author Cristiano Longo
 *
 * This file is part of rss-tools.
 *
 * Copyright 2017 Cristiano Longo
 *
 * 
 * @licstart  The following is the entire license notice for the 
 * JavaScript code in this page.
 * 
 * Copyright 2017 Cristiano Longo
 * 
 * The JavaScript code in this page is free software: you can
 * redistribute it and/or modify it under the terms  of the GNU Lesser General 
 * Public License as published by the Free Software Foundation, either version 
 * 3 of the License, or  (at your option) any later version. The code is distributed 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU GPL for more details.
 * 
 * As additional permission under GNU GPL version 3 section 7, you
 * may distribute non-source (e.g., minimized or compacted) forms of
 * that code without the copy of the GNU GPL normally required by
 * section 4, provided you include this license notice and a URL
 * through which recipients can access the Corresponding Source.   
 * 
 * @licend  The above is the entire license notice
 * for the JavaScript code in this page.
 */

/**
 * Get a ramdom entry of a rss feed and pass it to an handle.
 *  
 * @param feedUrl the url of the feed
 * @param handler a function which will receive an object with the following fields: feedTitle, description (item description) and link (item link)
 */
function openRSSFeed(feedURL, handler){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4){
		    if (this.status == 200) {
		    	var parser = new DOMParser();
		    	var itemObj = new Object();
		    	
		    	var feed = parser.parseFromString(xhttp.responseText,"text/xml");	
		    	var channel = feed.getElementsByTagName("channel")[0]; 
		    	itemObj.feedTitle = channel.getElementsByTagName("title")[0].textContent;
		    	
		    	//get a random item
		    	var items = channel.getElementsByTagName("item");
		    	var n = Math.floor(Math.random()*items.length);
		    	var item = items[n];
		    	itemObj.description=item.getElementsByTagName("description")[0].textContent;
		    	itemObj.link=item.getElementsByTagName("link")[0].textContent;
				handler(itemObj);
		    } else alert("error: " + xhttp.status + " "
					+ xhttp.responseText);
	    }
	}
	xhttp.open("GET", feedURL, true);
	xhttp.send(); 	
}

/**
 * Add a widget displaying the first entry of a rss feed to a page
 * 
 * @param feedURL
 * @param containerId id of the page element which will contains the entry
 * @returns
 */
function drawRssWitdget(feedURL, containerId){
	var handler = function(item){
		var text = document.createTextNode(item.feedTitle+" - "+item.description);
		var link = document.createElement("a");
		link.setAttribute("href", item.link);		
		link.appendChild(text);					
		var content = document.createElement("p");				
		content.appendChild(link);
		document.getElementById(containerId).appendChild(content);		
	}
	openRSSFeed(feedURL, handler);

}