<?php

$txt = "{t:Nous t’adorons}
{st:Corinne Lafitte}
{c:© 1991 Corinne Lafitte}
{c:shir.fr 25/12/15 – JEM463}
{key:Dm}
Nous t’ado[Dm]rons, ô [A/E]Père, dans ton [Dm/F]tem[D/F#]ple.
Nous t’ado[Gm]rons en esprit [A7]et en véri[Dm]té.
Tu ha[Bb]bites [C]nos lou[A/C#]an[Dm]ges,
Nous t’ado[Gm]rons en esprit [A7]et en véri[Dm]té.

{soc}
Car [C/E]un [F]jour près de toi vaut [C]mieux que mille ail[A/C#]leurs,
Je dé[Dm]sire habi[Bb]ter dans ton [A4]tem[A]ple.
Car un [F]jour près de toi vaut [C]mieux que mille ail[A/C#]leurs,
Je dé[Dm]sire habi[Bb]ter dans ta [A7]maison Sei[Dm]gneur.
{eoc}

{c:Final}
Je dé[Bb]sire habi[Gm]ter dans ta [A7]maison, Sei[Dm]gneur,
Je dé[Bb]sire habi[Gm]ter dans ta [A7]maison, Sei[Dm]gneur.
";

require __dir__ . '/../vendor/autoload.php';

$parser = new ChordPro\Parser();
$html = new ChordPro\HtmlFormatter();
$monospace = new ChordPro\MonospaceFormatter();
$json = new ChordPro\JSONFormatter();

$song = $parser->parse($txt);

$guess = new ChordPro\GuessKey();
echo '<pre>'; print_r($guess->guessKey($song)); exit;

$transposer = new ChordPro\Transposer();
$transposer->transpose($song,'Dm');

$options = array('french' => true, 'no_chords' => false);
$txt_html = $html->format($song,$options);
$txt = $monospace->format($song,$options);
$txt_json = $json->format($song,$options);


//echo '<pre>'.$txt; exit;

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>ChordPro PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Test ChordPro">
    <meta name="author" content="Nicolas Wurtz">

    <link rel="stylesheet" href="chordpro.css" />
    <link rel="stylesheet" href="example.css" />
  </head>
  <body>
    <?php echo '<h2>'.$song->getKey(['french' => true]).'</h2>'.$txt_html; ?>
  </body>
</html>
