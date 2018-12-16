<?php

$txt = '{t:Sola Gratia (Ta grâce seule)}
{st:Sébastien Corn – David Morin}
{c:© 2013 Productions ENV Media}
{c:shir.fr 25/12/15 – IMP1303}
{key:C#m}
[C#m][A][E][G#m]

[C#m][A][E][G#m]
[C#m] Amour p[A]arfait, tu t’es d[E]onné à la cr[G#m]oix pour tout effac[C#m]er.
 De mes p[A]échés tu t’es ch[E]argé sur le b[B]ois.

{soc}
C’est par [A]ta grâce, ta grâce [C#m]seule que je suis par[B]donné.
C’est par [A]ta grâce, ta grâce [C#m]seule que tu m’as ra[B]cheté.

O[A]h,[E] [B]merci pour la croix, ton [F#m]amour pour moi.
O[A]h,[E] ta [C#m]grâce ne faillit p[B]as.
{eoc}

[C#m][A][E][G#m]
[C#m] Rien ne p[A]ourrait me just[E]ifier, ton pard[G#m]on est immérit[C#m]é.
 Tous mes e[A]fforts ne suff[E]iraient à me sauv[B]er.

{c:Pont}
[A] Ta grâce justifie,[E] ta grâce m’affranchit,
[B] Ta grâce purifie,[F#m] ta grâce m’offre la vie.
[A] Ta grâce m’a sauvé,[E] ta grâce a pardonné,
[B] Ta grâce m’a comblé,[F#m] ta grâce m’a libéré.
(× 3)[C#m]

{c:Final}
[C#m]';

require __dir__ . '/chordprophp.class.php';
use chordprophp\chordpro;
$chordpro = new chordpro($txt);

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>CalOPEE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Test ChorPro">
    <meta name="author" content="Nicolas Wurtz">

    <link rel="stylesheet" href="chordpro.css" />
    <link rel="stylesheet" href="test.css" />
  </head>
  <body>
    <?php echo $chordpro->getHtml(); ?>
  </body>
</html>
