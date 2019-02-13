# chordproPHP

A simple tool to parse & format ChordPro songs.

It currently supports the following output formats :
- HTML
- JSON
- Plain text

## Install

Via composer :

``` bash
$ composer require nicolaswurtz/chordprophp
```

## Usage

_See example.php for demo._

``` php
<?php

require __DIR__ . '/vendor/autoload.php;

$txt = "[C]This is the [Dm]beautiful song
[F] I wroted in [G/B]Chordpro for[Am]mat [F/A]
Let's ring dingle and dong
It's easy to do that";

$parser = new ChordPro\Parser();

// Choose one (or all !) of those formatters following your needs
$html_formatter = new ChordPro\HtmlFormatter();
$monospace_formatter = new ChordPro\MonospaceFormatter();
$json_formatter = new ChordPro\JSONFormatter();

// Create song object after parsing txt
$song = $parser->parse($txt);

// You can tranpose your song, put how many semitones you want to transpose in second argument
$transposer = new ChordPro\Transposer();
$transposer->transpose($song,-5);

// Some options are waited
$options = []; //array('french' => true);

// Render !
$html = $html_formatter->format($song,$options);
$plaintext = $monospace_formatter->format($song,$options);
$json = $json_formatter->format($song,$options);
```

## CSS Class you can use with HTML Formatter
