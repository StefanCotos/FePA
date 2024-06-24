<?php

namespace rss_generator;

use mysql_xdevapi\Exception;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class RSSGenerator
{
    private $feed;
    private $channel;
    private $xmlFilePath;

    public function __construct($xmlFilePath)
    {
        $this->feed = new Feed();
        $this->xmlFilePath = $xmlFilePath;
        $this->channel = new Channel();
        $this->channel
            ->title("Animals reports")
            ->description("Here you can see all the reports that have been made")
            ->url("https://fepa-app-73d25d1a00ff.herokuapp.com/see_reports.html")
            ->language("en-US")
            ->pubDate(strtotime('today'))
            ->appendTo($this->feed);
    }


    public function createItem($title, $description, $url)
    {
        $item = new Item();
        $item
            ->title($title)
            ->description($description)
            ->url($url)
            ->pubDate(strtotime('today'))
            ->preferCdata(true)
            ->appendTo($this->channel);
    }

    public function generate()
    {
        $xmlContent = $this->feed->render();

        $file = fopen($this->xmlFilePath, 'w');
        if ($file) {
            fwrite($file, $xmlContent);
            fclose($file);
        } else {
            throw new Exception("Not written in file");
        }

        $this->deleteUnnecessary('<?xml version="1.0" encoding="UTF-8"?>');
        $this->deleteUnnecessary('xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom"');
    }

    private function deleteUnnecessary($toDelete)
    {
        $content = file_get_contents($this->xmlFilePath);

        if (strpos($content, $toDelete) !== false) {
            $content = str_replace($toDelete, '', $content);
            file_put_contents($this->xmlFilePath, $content);
        }
    }

}