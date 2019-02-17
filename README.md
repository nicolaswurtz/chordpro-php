# chordpro-php

A simple tool to parse, transpose & format [ChordPro](https://www.chordpro.org) songs with lyrics & chords.

It currently supports the following output formats :
- HTML (verses contain blocks with embricated `span` for alignement of chords with lyrics)
- JSON (verses are array of arrays of chords and lyrics for alignement purpose)
- Plain text (chords are aligned with monospace text thanks to whitespaces)

And provides some extra functionnalities :
- Tranpose chords (can be very clever if original key is known)
- Display french chords
- Guess tonality key of a song

_I'm french, so there's probably a lot of mistakes, my english is not always accurate — je fais ce que je peux hein :P_

## Install

Via composer :

``` bash
$ composer require nicolaswurtz/chordpro-php
```

## Usage

See `web/example.php` for demo with CSS styling.

``` php
<?php

require __DIR__ . '/vendor/autoload.php';

$txt = "{t:ChordpropPHP Song}
{st:Nicolas Wurtz}
{c:GPL3 2019 Nicolas Wurtz}
{key:C}
[C]This is the [Dm]beautiful [Em]song
I [Dm]wroted in [F/G]Chordpro for[C]mat [Dm/F]
Let's singing a[C/E]long
[Bb] It's ea[Dm]sy to do [F]that [C]

{soc}
[F] [G] [C]This is the refrain
[F] [G] [C]We could sing it twice
{eoc}

{c:Final}
[Em/D]This is the [Bb]end.";

$parser = new ChordPro\Parser();

// Choose one (or all !) of those formatters following your needs
$html_formatter = new ChordPro\HtmlFormatter();
$monospace_formatter = new ChordPro\MonospaceFormatter();
$json_formatter = new ChordPro\JSONFormatter();

// Create song object after parsing txt
$song = $parser->parse($txt);

// You can tranpose your song, put how many semitones you want to transpose in second argument OR desired key (only if metadata "key" is defined)
$transposer = new ChordPro\Transposer();
$transposer->transpose($song,-5); // Simple transpose, but could produce some musical errors (sharp instead of flat)
//$transposer->transpose($song,'Abm');

// Some options are mandatory, you could use en empty array if none
$options = array(
    'french' => true,
    'no_chords' => true
);

// Render !
$html = $html_formatter->format($song,$options);
$plaintext = $monospace_formatter->format($song,$options);
$json = $json_formatter->format($song,$options);
```

## Formatting options
Simply give an array with values at true or false for each key/option.
``` php
array(
    'french' => true, // to display french chords (Do, Ré, Mi, Fa, Sol, La, Si, Do), including Song Key.
    'no_chords' => true // to only get text (it removes "block" system for chords alignements)
);
```

## Specific methods

### Song
- `$song->getKey([])` to obtain key of song, **with transposition**, you can alter langage english by default, or French ```$song->getKey(['french' => true]);```, options array is mandatory, you could use en empty array if none
- `$song->getOriginalKey()` to obtain key of song, as defined in metadata's field "key"

### Guess key of a song
This fonctionnality is experimental and not reliable (20% of mistakes, tested with ~1000 songs), but can be very useful.
Usage is very simple (you have to parse a song before as described before):
``` php
$guess = new ChordPro\GuessKey();
$key = $guess->guessKey($song);
```

## CSS Classes you can use with _HTML_ Formatter

### Verses
_Verses_ are one line composed by blocks of text + chords, chord with class `chordpro-chord` and text with class `chordpro-text`.

A typical `div` will be like this :
``` html
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
```

### Chorus
The _chorus_ (`soc`/`start_of_chorus`) will be contained inside ```<div class="chordpro-chorus"></div>```.

### Metadata
By default, all _metadatas_ are placed inside ```<div class="chordpro-metadataname"></div>```.
For example, the _title_ will be
``` html
<div class="chordpro-title">It's a great title !</div>
```
_ChordproPHP doesn't care about the metadata names, it just puts it after `chordpro-` :)_
> Metatada's names are always converted to their long form (`c` will be recorded as `comment`) when using short names from [official directives](https://www.chordpro.org/chordpro/ChordPro-Directives.html)
