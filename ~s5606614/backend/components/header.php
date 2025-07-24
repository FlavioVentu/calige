<?php

$title = title();
$page_name = basename($_SERVER['PHP_SELF'], ".php");

echo <<< FOOTER
<!DOCTYPE html>
<html lang="it">

<head>

    <!-- METADATI -->
    <title>CALIge | $title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF8">
    <meta name="description" content="Sito del CALIge">
    <meta name="keywords" content="parchi, calisthenics, Genova, allenamento, condivisione">
    <meta name="author" content="Umeshan Panchabalasingham">



    <!-- PARTE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"
        defer></script>

    <!-- CSS -->
    <link href="/~s5606614/frontend/css/util.css" rel="stylesheet">
    
    <!-- JS -->
    <script src="/~s5606614/frontend/js/util.js" defer></script>
    <script src="/~s5606614/frontend/js/{$page_name}.js" defer></script>

    <!-- ICON -->
    <link rel="shortcut icon" href="/~s5606614/frontend/images/favicon.ico" type="image/x-icon">
</head>
FOOTER;
