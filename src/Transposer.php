<?php

namespace ChordPro;

class Transposer
{

    private $transpose_table = array(
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

    public function transpose(Song $song, int $value)
    {
        foreach ($song->lines as $line) {
            if ($line instanceof Lyrics) {
                foreach ($line->getBlocks() as $block) {
                    if (null !== $block->getChord()) {
                        $block->setChord($this->transposing($block->getChord(),$value));
                    }
                }
            }
        }
    }

    private function transposing(string $chords, int $value)
    {
        $chords = explode('/',$chords);
        foreach ($chords as $chord) {
            $pos = (in_array(substr($chord,1,1),['b','#'])) ? 2 : 1;
            $chord = [substr($chord,0,$pos),substr($chord,$pos)];

            if (!empty($value) and $value < 12 and $value > -12) {
                $key = $this->transpose_table[$chord[0]];
                $new_key = ($key + $value < 0) ? 12 + ($key + $value) : ($key + $value) % 12;
                $chord[0] = array_search($new_key,$this->transpose_table);
            }

            $formatted[] = implode($chord);
        }
        return implode('/',$formatted);
    }
}
