<?php

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
[Em/D]This is the [Bb]end.
";

require __dir__ . '/../vendor/autoload.php';

$parser = new ChordPro\Parser();
$html = new ChordPro\HtmlFormatter();
$monospace = new ChordPro\MonospaceFormatter();
$json = new ChordPro\JSONFormatter();

$song = $parser->parse($txt);

//$guess = new ChordPro\GuessKey();
//echo '<pre>'; print_r($guess->guessKey($song)); exit;

$transposer = new ChordPro\Transposer();
//$transposer->transpose($song,'Dm');

$options = array('french' => false, 'no_chords' => false);
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
    <meta name="description" content="Test ChordProPHP">
    <meta name="author" content="Nicolas Wurtz">
    <link rel="stylesheet" href="example.css" />
  </head>
  <body>
    <?php echo $txt_html; ?>
  </body>
</html>
