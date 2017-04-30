<?php
/**
 * Generate a feed with a single entry randomly extracted from the university of catania 
 * notice board 
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
require_once '../rss-php/Feed.php';
require_once '../RSSFeedItem.php';
require_once '../RSSFeedGenerator.php';
require_once '../get-random-feed-entry.php';

outputRandomFeedEntry ( 'http://dev.opendatasicilia.it/albopop/unict/unict2RSS.php',
		'http://www.opendatahacklab.org/rss-tools/php/albopop/randomunict.php' );

?>