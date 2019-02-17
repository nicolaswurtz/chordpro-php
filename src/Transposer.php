<?php

/*
* Two use-cases :
*
* - knowing original key of song, it transposes with table to ensure musicaly matching chords
* - without original key, simple mathematical transpose (with errors !)
*
*
*/

namespace ChordPro;

class Transposer
{
    private $simple_transpose_table = array(
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

    private $transpose_chords = array(
        'Fb' => 0,
        'Cb' => 1,
        'Gb' => 2,
        'Db' => 3,
        'Ab' => 4,
        'Eb' => 5,
        'Bb' => 6,
        'F' => 7,
        'C' => 8,
        'G' => 9,
        'D' => 10,
        'A' => 11,
        'E' => 12,
        'B' => 13,
        'F#' => 14,
        'C#' => 15,
        'G#' => 16,
        'Dbm' => 0,
        'Abm' => 1,
        'Ebm' => 2,
        'Bbm' => 3,
        'Fm' => 4,
        'Cm' => 5,
        'Gm' => 6,
        'Dm' => 7,
        'Am' => 8,
        'Em' => 9,
        'Bm' => 10,
        'F#m' => 11,
        'C#m' => 12,
        'G#m' => 13,
        'D#m' => 14,
        'A#m' => 15,
        'E#m' => 16
    );

    // K for natural, X for ##, bb for bb :)
    private $transpose_table = [
        ['Fb','F','Gbb','Gb','G','Abb','Ab','A','Bbb','Bb','Cbb','Cb','C','Dbb','Db','D','Ebb','Eb'],
        ['Cb','C','Dbb','Db','D','Ebb','Eb','E','Fb','F','Gbb','Gb','G','Abb','Ab','A','Bbb','Bb'],
        ['Gb','G','Abb','Ab','A','Bbb','Bb','B','Cb','C','Dbb','Db','D','Ebb','Eb','E','Fb','F'],
        ['Db','D','Ebb','Eb','E','Fb','F','F#','Gb','G','Abb','Ab','A','Bbb','Bb','B','Cb','C'],
        ['Ab','A','Bbb','Bb','B','Cb','C','C#','Db','D','Ebb','Eb','E','Fb','F','F#','Gb','G'],
        ['Eb','E','Fb','F','F#','Gb','G','G#','Ab','A','Bbb','Bb','B','Cb','C','C#','Db','D'],
        ['Bb','B','Cb','C','C#','Db','D','D#','Eb','E','Fb','F','F#','Gb','G','G#','Ab','A'],
        ['F','F#','Gb','G','G#','Ab','A','A#','Bb','B','Cb','C','C#','Db','D','D#','Eb','E'],
        ['C','C#','Db','D','D#','Eb','E','E#','F','F#','Gb','G','G#','Ab','A','A#','Bb','B'],
        ['G','G#','Ab','A','A#','Bb','B','B#','C','C#','Db','D','D#','Eb','E','E#','F','F#'],
        ['D','D#','Eb','E','E#','F','F#','FX','G','G#','Ab','A','A#','Bb','B','B#','C','C#'],
        ['A','A#','Bb','B','B#','C','C#','CX','D','D#','Eb','E','E#','F','F#','FX','G','G#'],
        ['E','E#','F','F#','FX','G','G#','GX','A','A#','Bb','B','B#','C','C#','CX','D','D#'],
        ['B','B#','C','C#','CX','D','D#','DX','E','E#','F','F#','FX','G','G#','GX','A','A#'],
        ['F#','FX','G','G#','GX','A','A#','AX','B','B#','C','C#','CX','D','D#','DX','E','E#'],
        ['C#','CX','D','D#','DX','E','E#','EX','F#','FX','G','G#','GX','A','A#','AX','B','B#'],
        ['G#','GX','A','A#','AX','B','B#','BX','C#','CX','D','D#','DX','E','E#','EX','F#','FX']
    ];

    public function transpose(Song $song, string $value)
    {
        foreach ($song->lines as $line) {
            if ($line instanceof Lyrics) {
                foreach ($line->getBlocks() as $block) {
                    if (null !== $block->getChord()) {
                        if (is_numeric($value)) {
                            $block->setChord($this->simple_transpose($block->getChord(),$value));
                        }
                        else {
                            $block->setChord($this->complete_transpose($block->getChord(),$song->getOriginalKey(),$value));
                            $song->setKey($value);
                        }
                    }
                }
            }
        }
    }

    private function simple_transpose(array $chords, int $value)
    {
        foreach ($chords as $chord) {
            if (in_array(substr($chord[1],0,1),['b','#','X','K'])) {
                $chord = [$chord[0].substr($chord[1],0,1),substr($chord[1],1)];
            }

            if (!empty($value) and $value < 12 and $value > -12) {
                $key = $this->simple_transpose_table[$chord[0]];
                $new_key = ($key + $value < 0) ? 12 + ($key + $value) : ($key + $value) % 12;
                $chord[0] = array_search($new_key,$this->simple_transpose_table);
            }

            $transposed[] = implode($chord);
        }
        return implode('/',$transposed);
    }

    private function complete_transpose(array $chords, string $from_key, string $to_key)
    {
        foreach ($chords as $chord) {
            if (in_array(substr($chord[1],0,1),['b','#','X','K'])) {
                $chord = [$chord[0].substr($chord[1],0,1),substr($chord[1],1)];
            }

            $rank = array_search($chord[0],$this->transpose_table[$this->transpose_chords[$from_key]]);
            $chord[0] = $this->transpose_table[$this->transpose_chords[$to_key]][$rank];

            $transposed[] = implode($chord);
        }
        return implode('/',$transposed);
    }
}
