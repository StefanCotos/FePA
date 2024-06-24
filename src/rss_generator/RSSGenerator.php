<?php

namespace rss_generator;

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

// Creează feed-ul RSS
$feed = new Feed();

// Creează canalul RSS
$channel = new Channel();
$channel
    ->title("Titlul canalului")
    ->description("Descrierea canalului")
    ->url("http://exemplu.com")
    ->language("en-US")
    ->pubDate(strtotime('today'))
    ->lastBuildDate(strtotime('today'))
    ->appendTo($feed);

// Creează un item RSS
$item = new Item();
$item
    ->title("Titlul articolului")
    ->description("Descrierea articolului")
    ->url("http://exemplu.com/articol")
    ->author("Autorul Articolului")
    ->pubDate(strtotime('today'))
    ->enclosure('https://res.cloudinary.com/hf0egkogn/image/upload/v1719072653/25.jpg', 'image/jpg') // Adaugă imaginea la articol
    ->appendTo($channel);


$xmlContent = $feed->render();

// Numele fișierului XML în care vom salva feed-ul
$xmlFilePath = 'rss_feed.xml';

// Începe să scrii în fișierul XML
$file = fopen($xmlFilePath, 'w');
if ($file) {
    fwrite($file, $xmlContent);
    fclose($file);
    echo "Feed-ul RSS a fost salvat în $xmlFilePath";
} else {
    echo "Nu am putut deschide $xmlFilePath pentru scriere.";
}

class RSSGenerator
{

}