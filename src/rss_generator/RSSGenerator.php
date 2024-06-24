<?php

namespace rss_generator;

use mysql_xdevapi\Exception;
use Laminas\Feed\Writer\Feed;


class RSSGenerator
{
    private $feed;
    private $xmlFilePath;

    public function __construct($xmlFilePath)
    {
        $this->xmlFilePath = $xmlFilePath;
        $this->feed = new Feed();
        $this->feed
            ->setTitle('Animals reports')
            ->setDescription('Here you can see all the reports that have been made')
            ->setLink('https://fepa-app-73d25d1a00ff.herokuapp.com/see_reports.html')
            ->setDateModified(time());
    }


    public function createItem($title, $description, $url)
    {
        $entry = $this->feed->createEntry();
        $entry
            ->setTitle($title)
            ->setDescription($description)
            ->setLink($url)
            ->setDateCreated(time());

        $this->feed->addEntry($entry);
    }

    public function generate()
    {
        $xmlContent = $this->feed->export('rss');
        file_put_contents($this->xmlFilePath, $xmlContent);

        $this->deleteUnnecessary('<?xml version="1.0" encoding="UTF-8"?>');
//        $this->deleteUnnecessary('xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom"');
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