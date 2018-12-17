<?php

$txt = '{t:Ta bannière}
{st:Samuel Olivier}
{c:© 2011 Samuel Olivier}
{c:shir.fr 25/12/15 – ENC1109}
{key:C}
[C] Éternel trois fois saint,[Dm] l’étoile du matin,
[F] Seigneur de l’univers,[C] aveuglante lumière,
[C] Personne n’est comme toi,[Dm] parfaites sont tes voies,
[F] Dieu souverain et fort,[C] plus puissant que la mort.

[Am] Et quand j’en prends conscience,[Em] ta divine évidence
[F] S’impose à mon esprit ;[G] ta grâce me suffit.
[Am] Malgré mes idées noires,[Em] ma vie sous ton regard,
[F] Dieu, tu trouves en moi ton plaisir.

{soc}
[C] Seigneur, ta bannière s[G]ur moi, c’est l’amo[F]ur, c’est ton amo[C]ur. (× 2)
{eoc}

[C] Éternel trois fois saint,[Dm] l’étoile du matin,
[F] Seigneur de l’univers,[C] aveuglante lumière,
[C] Personne n’est comme toi,[Dm] parfaites sont tes voies,
[F] Tu consoles et restaures,[C] tu soignes et tu rends fort.

[Am] Et quand j’en prends conscience,[Em] ta divine évidence
[F] S’impose à mon esprit ;[G] ô Dieu, tu me suffis.
[Am] Ma vie sous ton regard,[Em] qu’elle chante ton histoire.
[F] Père, je trouve en toi mes délices.

{soc}
[C] Seigneur, ta bannière s[G]ur moi, c’est l’amo[F]ur, c’est ton amo[C]ur. (× 2)
[Am] Tu me couronnes de t[G/B]a joie, c’est l’amo[Dm]ur, c’est ton amo[C]ur.
[C] Seigneur, ta bannière s[G]ur moi, c’est l’amo[F]ur, c’est ton amo[C]ur.
{eoc}

{c:Pont}
[C] J’élève ta bannière,[Dm] j’élève ta bannière,
[F] J’élève ta bannière sur m[C]oi.
[C] Quand je suis perdu,[Dm] quand je n’y vois plus,
[F] J’élève ta bannière sur m[C]oi.
(× 2)

[Am] J’élève ta bannière,[Em] j’élève ta bannière,
[F] J’élève ta bannière sur m[C]oi.
[Am] Quand je suis perdu,[Em] quand je n’y vois plus,
[F] J’élève ta bannière sur m[C]oi.
(× 2)';

require __dir__ . '/chordprophp.class.php';
use chordprophp\chordpro;
$chordpro = new chordpro($txt);
$chordpro->options(array(
  'transpose' => -2,
  'french' => true
));
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
