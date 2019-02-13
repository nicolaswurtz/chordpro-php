<?php

$txt = "{t:Tu es venu jusqu’à nous}
{st:Graham Kendrick}
{c:From Heaven You Came © 1983 Make Way Music / Kingsway Thankyou Music / LTC}
{c:shir.fr 25/12/15 – JEM553}
{key:Cm}
[Cm]Tu es ve[G/B]nu jusqu’à [AbM7]nous,
[Bb/Ab]Quittant la [Eb/G]gloire [Ab/C]de [Eb/Bb]ton [Bb]ciel.
[Cm]Tu es ve[G/B]nu nous ser[AbM7]vir,
[Bb/Ab]Donnant ta [Eb/G]vie pour [Ab/C]nous [Eb/Bb]sau[Bb]ver.

{soc}
Dieu tout puis[Eb]sant[Bb], roi servi[Cm]teur,[Cm/Bb]
Tu nous ap[Ab]pelles tous [Bb]à te [Eb]sui[Bb]vre
Et à t’of[Eb]frir nos [Eb/Db]corps en sacri[Ab/C]fice.[D]
À toi l’hon[Eb]neur[Bb], roi servi[Eb]teur.
{eoc}

[G7][Cm]Dans le jar[G/B]din de dou[AbM7]leur,
[Bb/Ab]Où mon far[Eb/G]deau bri[Ab/C]sa [Eb/Bb]ton [Bb]cœur,
[Cm]Tu dis à [G/B]Dieu, dans ta [AbM7]peine :
[Bb/Ab]Ta volon[Eb/G]té et [Ab/C]non [Eb/Bb]la [Bb]mienne.

[G7][Cm]Voyez ses [G/B]mains et ses [AbM7]pieds,
[Bb/Ab]Pour nous, té[Eb/G]moins du [Ab/C]sa[Eb/Bb]cri[Bb]fice.
[Cm]Les mains qui [G/B]tenaient la [AbM7]terre
[Bb/Ab]Se livrent aux [Eb/G]clous de [Ab/C]la [Eb/Bb]co[Bb]lère.

[G7][Cm]Apprenons [G/B]donc à ser[AbM7]vir
[Bb/Ab]En laissant [Eb/G]Christ ré[Ab/C]gner [Eb/Bb]en [Bb]nous.
[Cm]Car en ai[G/B]mant nos pro[AbM7]chains,
[Bb/Ab]C’est Jésus-[Eb/G]Christ que [Ab/C]nous [Eb/Bb]ser[Bb]vons.
";

require __dir__ . '/../vendor/autoload.php';

$parser = new ChordPro\Parser();
$html = new ChordPro\HtmlFormatter();
$monospace = new ChordPro\MonospaceFormatter();
$json = new ChordPro\JSONFormatter();

$song = $parser->parse($txt);
$transposer = new ChordPro\Transposer();
$transposer->transpose($song,-5);

$options = []; //array('french' => true);
$txt_html = $html->format($song,$options);
//$txt = $monospace->format($song,$options);
//$txt_json = $json->format($song,$options);

//echo '<pre>'.$txt_json; exit;

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
    <?php echo $txt_html; ?>
  </body>
</html>
