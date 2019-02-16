<?php

namespace ChordPro;

class Formatter {
    protected $french_chords;
    protected $no_chords;

    public function setOptions(Song $song, array $options)
    {
        if (isset($options['french']) and true === $options['french']) {
            $this->french_chords = true;
        }
        if (isset($options['no_chords']) and true === $options['no_chords']) {
            $this->no_chords = true;
        }
    }
}
