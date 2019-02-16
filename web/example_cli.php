<?php

require __dir__ . '/../vendor/autoload.php';

$parser = new ChordPro\Parser();
$monospace = new ChordPro\MonospaceFormatter();
$guess = new ChordPro\GuessKey();

$fichiers = scandir('/home/elow/Téléchargements/chordpro');
foreach ($fichiers as $nom_fichier) {
    if ($nom_fichier != '.' and $nom_fichier != '..') {

        $song = $parser->parse(file_get_contents('/home/elow/Téléchargements/chordpro/'.$nom_fichier));
        $result = $guess->guessKey($song);
        echo str_replace('.chordpro','',$nom_fichier).' : '.$song->getKey([]).' — '.implode(' / ',array_keys($result))."\n";
    }
}

exit;

$transposer = new ChordPro\Transposer();
$transposer->transpose($song,'Dm');

$options = array('french' => true, 'no_chords' => false);
$txt_html = $html->format($song,$options);
$txt = $monospace->format($song,$options);
$txt_json = $json->format($song,$options);
