<?php
$file = 'public/rss_feed.xml';
$search = 'xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom"';

// Citeste continutul fisierului
$content = file_get_contents($file);

// Cauta stringul de sters
if (strpos($content, $search) !== false) {
    // Sterge stringul din continut
    $content = str_replace($search, '', $content);

    // Salveaza continutul actualizat in fisier
    file_put_contents($file, $content);

    echo "Stringul '$search' a fost sters din fisier.\n";
} else {
    echo "Stringul '$search' nu a fost gasit in fisier.\n";
}