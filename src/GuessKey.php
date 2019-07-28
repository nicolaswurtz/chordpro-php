<?php

/*
*
* Try to guess the tonality key of a song, with the chords it contains.
* It uses a table with major scales and chords frequently found inside those scales, and takes the most representated scale.
* Finally, it tests between Major and minor relative key which one is the most found in chords.
* A bit brutal, but works most of the time !
*
*/

namespace ChordPro;

class GuessKey {
    private $scales = array(
        'A'  => ['A','Bm','C#m','D','E','F#m','G#'],
        'A#' => ['A#','B#m','Dm','D#','E#','Gm','A'],
        'Bb' => ['Bb','Cm','Dm','Eb','F','Gm','A'],
        'B'  => ['B','C#m','D#m','E','F#','G#m','A#'],
        'Cb' => ['Cb','Dbm','Ebm','Fb','Gb','Abm','Bb'],
        'B#' => ['B#','Dm','Em','E#','G','Am','B'],
        'C'  => ['C','Dm','Em','F','G','Am','B'],
        'C#' => ['C#','D#m','E#m','F#','G#','A#m','B#'],
        'Db' => ['Db','Ebm','Fm','Gb','Ab','Bbm','C'],
        'D'  => ['D','Em','F#m','G','A','Bm','C#'],
        'D#' => ['D#','E#m','Gm','G#','A#','Cm','D'],
        'Eb' => ['Eb','Fm','Gm','Ab','Bb','Cm','D'],
        'E'  => ['E','F#m','G#m','A','B','C#m','D#'],
        'E#' => ['E#','Gm','Am','A#','B#','Dm','E'],
        'Fb' => ['Fb','Gbm','Abm','A','Cb','Dbm','Eb'],
        'F'  => ['F','Gm','Am','Bb','C','Dm','E'],
        'F#' => ['F#','G#m','A#m','B','C#','D#m','E#'],
        'Gb' => ['Gb','Abm','Bbm','Cb','Db','Ebm','F'],
        'G'  => ['G','Am','Bm','C','D','Em','F#'],
        'G#' => ['G#','A#m','B#m','C#','D#','E#m','G'],
        'Ab' => ['Ab','Bbm','Cm','Db','Eb','Fm','G']
    );

    private $distanceChords = array(
        'C'   => 0,
        'C#'  => 1,
        'Db'  => 1,
        'D'   => 2,
        'Eb'  => 3,
        'D#'  => 3,
        'E'   => 4,
        'F'   => 5,
        'F#'  => 6,
        'Gb'  => 6,
        'G'   => 7,
        'Ab'  => 8,
        'G#'  => 8,
        'A'   => 9,
        'Bb'  => 10,
        'A#'  => 10,
        'B'   => 11,
    );

    private function nearChords($chord) // I don't know how to call this exactly in english ? « Tons voisin » in french.
    {
        $distance = ($this->distanceChords[$chord] - 3 < 0) ? ($this->distanceChords[$chord] - 3) + 12 : $this->distanceChords[$chord] - 3;
        $found = array_keys($this->distanceChords,$distance);
        return $found;
    }

    public function guessKey($song)
    {
        // List all chords of a song
        $chords = [];
        foreach ($song->lines as $line) {
            if (null !== $line and $line instanceof Lyrics) {
                foreach ($line->getBlocks() as $block) {
                    $chord = $block->getChord();
                    if (!empty($chord[0])) {
                        $minor = (false !== strpos($chord[0][1],'m')) ? 'm' : '';
                        $chord = (in_array(substr($chord[0][1],0,1),['b','#','X','K'])) ? $chord[0][0].substr($chord[0][1],0,1) : $chord[0][0];
                        $chords[] = $chord.$minor;
                    }
                }
            }
        }

        // Order key by occurences in a scale
        $list_keys = [];
        foreach ($this->scales as $key => $scale) {
            $list_keys[$key] = 0;
            foreach ($chords as $chord) {
                if (in_array($chord, $scale)) {
                    $list_keys[$key]++;
                }
            }
        }
        arsort($list_keys);
        $list_keys = array_keys($list_keys);
        $major_key = $list_keys[0]; // Take the first one
        $minor_keys = $this->nearChords($major_key); // Find minors keys near major key

        // Count occurences of minor & major keys to determinate the most plausible key
        $result[$major_key] = count(array_keys($chords,$major_key));
        foreach ($minor_keys as $key) {
            $key = $key.'m';
            $count = count(array_keys($chords,$key));
            if ($count > 0) {
                $result[$key] = $count;
            }
        }
        arsort($result);
        $result = array_keys($result);
        return $result[0];
    }
}
