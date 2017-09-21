<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>{$TITLE} </title>
          <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="content-language" content="pt, pt-br" />
        <meta http-equiv="cache-control" content="public" />
        <meta http-equiv="imagetoolbar" content="no" />

        <meta name="DC.title" content="{$TITLE}" />
        <meta name="DC.creator" content="Marcio Bigolin" />
        <meta name="DC.creator.address" content="marcio.bigolinn@gmail.com" />
        <meta name="DC.description" content="{$DESCRIPTION}" />
        <meta name="author" content="Marcio Bigolin" />
        <meta name="language" content="pt-br" />
        <meta name="classification" content="Internet" />
        <meta name="robots" content="index, follow" />
        <meta name="rating" content="general" />
        <meta name="copyright" content="Marcio Bigolin, 2015" />
        <meta name="doc-rights" content="Public" />
        <meta name="geo.region" content="RS"/>
        <meta name="geo.placename" content="Canoas" />
        <meta name="distribution" content="Local" />
        <meta name="revisit-after" content="none" />
        <meta name="keywords" content="{$KEYWORDS}" />
        <meta name="description" content="{$DESCRIPTION}" />

        {foreach $CDN->getCSS() as $src}
        <link rel="stylesheet" type="text/css" href="{$src}"/>
        {/foreach}
        {foreach $filesCSS as $file}
        <link rel="stylesheet" type="text/css" href="{$BASE_URL}/css/{$file}.css"/>
        {/foreach}
    </head>
    <body>
    