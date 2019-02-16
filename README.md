# chordproPHP

A simple tool to parse & format ChordPro songs.

It currently supports the following output formats :
- HTML (verses contain blocks with embricated `span` for alignement of chords with lyrics)
- JSON (verses are array of arrays of chords and lyrics for alignement purpose)
- Plain text (chords are aligned with monospace text thanks to whitespaces)

## Install

Via composer :

``` bash
$ composer require nicolaswurtz/chordprophp
```

## Usage

_See example.php for demo._

``` php
<?php

require __DIR__ . '/vendor/autoload.php';

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

## Formatting options
Simply give an array with values at true or false for each key/option.
- `french` to display french chords (Do, Ré, Mi, Fa, Sol, La, Si, Do), including Song Key.
- `no_chords` to only get text (it removes "block" system for chords alignements)

## Specific methods

### Song
- `getKey` to obtain key of song, **with transposition**, you can alter langage english by default, or French ```$song->getKey(['french' => true]);```
- `getOriginalKey` to obtain key of song, as defined in metadata's field "key"

## CSS Classes you can use with **HTML** Formatter

### Verses
_Verses_ are one line composed by blocks of text + chords, chord with class `chordpro-chord` and text with class `chordpro-text`.

A typical `div` will be like this :
```
<div class="chordpro-verse">
    <span class="chordpro-elem">
        <span class="chordpro-chord">C</span>
        <span class="chordpro-text">This is the </span>
    </span>
    <span class="chordpro-elem">
        <span class="chordpro-chord">Dm</span>
        <span class="chordpro-text">beautiful song</span>
    </span>
</div>
<div class="chordpro-verse">
    <span class="chordpro-elem">
        <span class="chordpro-chord">F</span>
        <span class="chordpro-text"></span>
    </span>
    <span class="chordpro-elem">
        <span class="chordpro-chord"></span>
        <span class="chordpro-text">I wroted in </span>
    </span>
    <span class="chordpro-elem">
        <span class="chordpro-chord">G/B</span>
        <span class="chordpro-text">Chordpro for</span>
    </span>
    <span class="chordpro-elem">
        <span class="chordpro-chord">Am</span>
        <span class="chordpro-text">mat </span>
    </span>
    <span class="chordpro-elem">
        <span class="chordpro-chord">F/A</span>
        <span class="chordpro-text"></span>
    </span>
</div>
```

### Chorus
The _chorus_ (`soc`,`start_of_chorus`) is encapsuled inside a `<div>` with class `chordpro-chorus`.

### Metadata
By default, all _metadatas_ are placed inside a `<div>` with class `chordpro-metadataname`. For example, the _title_ will be
```<div class="chordpro-title">It's a great title !</div>```
