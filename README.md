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

// You can tranpose your song, put how many semitones you want to transpose in second argument OR desired key (only if metadata "key" is defined)
$transposer = new ChordPro\Transposer();
$transposer->transpose($song,-5);
//$transposer->transpose($song,'Abm');

// Some options are waited
$options = []; //array('french' => true, 'no_chords' => true);

// Render !
$html = $html_formatter->format($song,$options);
$plaintext = $monospace_formatter->format($song,$options);
$json = $json_formatter->format($song,$options);
```

## Methods
### Song
- getKey to obtain key of song, **with transposition**, you can alter langage english by default, or French `$song->getKey(['french' => true]);`
- getOriginalKey to obtain key of song, as defined in metadata's field "key"

## CSS Classes you can use with HTML Formatter
