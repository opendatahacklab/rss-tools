<?php 
/**
 * Extract a random entry from a custom feed. Generate an RSS 2 feed with this 
 * singe entry. This code is based on rss-php (https://github.com/dg/rss-php).
 * 
 * @author Cristiano Longo
 * 
 * This file is part of rss-tools.
 * 
 * Copyright 2017 Cristiano Longo
 *
 * rss-tools is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * rss-tools is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'rss-php/Feed.php';
require_once 'RSSFeedItem.php';
require_once 'RSSFeedGenerator.php';

/**
 * Generate a feed with the same metadata of the original one but with a 
 * single entry, extracted randomly from the original one.
 * 
 * @param string $originalFeedUrl
 * @param string $pubURL the url where the new feed will be published
 */
function getRandomFeedEntry($originalFeedUrl, $pubURL){
	$feed = Feed::load($originalFeedUrl);
	
	if (count($feed->entry)>0)
		$entries = $feed->entry;
	else if (count($feed->item)>0)
		$entries = $feed->item;
	else{
		echo "No entries";
		return false;
	}

	$description= (isset($feed->description) ? "$feed->description - A random entry" :
			'A random entry from the original feed.');
	
	//generate the feed
	$newFeed = new RSSFeedGenerator($feed->title, $description, $feed->link, $pubURL, false);
	
	$totalEntries=count($entries);
	$selectedEntryNumber=rand(0,$totalEntries);
	$originalEntry=$entries[$selectedEntryNumber];
	
	$newEntry=new RSSFeedItem();
	
	$newEntry->title=$originalEntry->title;
	if (isset($originalEntry->description))
		$newEntry->description=$originalEntry->description;
	$newEntry->link=$originalEntry->link;
	$newEntry->guid = (isset($newEntry->guid) ? $newEntry->guid : $newEntry->link);

	if (isset($originalEntry->timestamp)){
		$date=new DateTime();
		$date->setTimestamp((int) $originalEntry->timestamp);
		$newEntry->pubDate=$date;
	}
	
	$newFeed->addItemObject($newEntry);
	return $newFeed->getFeed();
}

/**
 * Send HTTP headers related to php (locale is set to Italian)
 */
function sendRSSHeaders(){
	// output
	header ('Content-type: application/rss+xml; charset=UTF-8');
	header ('Access-Control-Allow-Origin: *');
	/*
	 * Impostazioni locali in italiano, utilizzato per la stampa di data e ora
	 * (il server deve avere il locale italiano installato
	 */
	setlocale ( LC_TIME, 'it_IT' );
	//AccessLogUtils::logAccess();
}

/**
 * Output a feed with a single entry extracted randomly from a origin feed
 * @param unknown $originalFeedUrl
 * @param unknown $pubURL
 */
function outputRandomFeedEntry($originalFeedUrl, $pubURL){
	sendRSSHeaders();
	echo getRandomFeedEntry($originalFeedUrl, $pubURL);
}
?>