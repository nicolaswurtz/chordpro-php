<?php

$txt = "{t:Peuple fidèle (arr. Héritage)}
{st:John F. Wade}
{c:Adeste Fideles (O Come, All Ye Faithful) © 1743 Domaine public © 1790 Adaptation française Jean-François-Étienne Borderies © 2014 Arrangements Sebastian Demrey et Jimmy Lahaie}
{c:shir.fr 25/12/15 – HER1402}
{key:Ab}
[Ab][Fm7][Eb][Ab][Fm7]
Ô [Db]peuple fi[Eb]dèle, [Ab]Jésus vous appelle !
Ve[Fm]nez triom[Eb]phants, joyeux, venez [Bb/D]en ces [Eb]lieux.[Eb/Db]
[Ab/C]Ô peuple [Db]fidèle, [Bb]venez voir le [Eb]roi des cieux.

{soc}
Ô [Fm]venez, a[Eb/G]do[Ab]rez-le ; ô [Fm]venez, a[Eb/G]do[Ab]rez-le ;
Ô [Db]venez, ado[C7]rez [Fm]le[Db] [Ab/Eb]Christ, [Ebsus4]le Sei[Ab]gneur.
{eoc}

[Fm][Ab][Eb/G][Ab/C][Fm][Eb][Ab/C][Ab][Eb/G][Db][Ab/C]
Il [Db]vient sur la [Eb]terre [Ab]fléchir la colère
De [Fm]Dieu, notre [Eb/G]créateur, sau[Bb]ver [Bb/D]le pé[Eb/G]cheur.[Eb/Db]
[Ab/C]Il vient tel [Db]un frère, [Bb]votre puissant [Eb]rédempteur.

[Db][Eb][Db/F][Eb/G][Db][Eb][Fsus4][F]
[Bbm][C7][Db][Ab][Eb][Ab]
[Db]Peuple fi[Eb]dèle, [Ab]en ce jour de fête,
Pro[Fm]clame la [Eb]gloire de [Bb]ton Sei[Eb]gneur.[Eb/Db]
[Ab/C]Dieu se fait [Db]homme [Bb]pour montrer qu’il [Eb]t’aime.

{soc:Final}
Ô [Ab]venez, adorez-le ; ô [Fm7]venez, a[Eb/G]do[Ab]rez-le ;
Ô [Db]venez, ado[C7]rez [Fm]l[Db]e [Ab]Christ, [Eb]le Sei[Ab]gneur.[Fm7][Eb]
{eoc}
[Ab][Fm7][Ab]
";

require __dir__ . '/../vendor/autoload.php';

$parser = new ChordPro\Parser();
$formatter = new ChordPro\HtmlFormatter();
$monospace = new ChordPro\MonospaceFormatter();

$song = $parser->parse($txt);
$transposer = new ChordPro\Transposer();
$transposer->transpose($song,-1);

$options = array('french' => true);
$html = $formatter->format($song,$options);
$txt = $monospace->format($song,$options);

echo '<pre>'.$txt; exit;

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>ChordPro PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Test ChorPro">
    <meta name="author" content="Nicolas Wurtz">

    <link rel="stylesheet" href="chordpro.css" />
    <link rel="stylesheet" href="test.css" />
  </head>
  <body>
    <?php echo $html; ?>
  </body>
</html>
