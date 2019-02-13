<?php

namespace ChordPro;

class Block {
    private $chord;
    private $text;

    private $french_chords = array(
        'A' => 'La',
        'B' => 'Si',
        'C' => 'Do',
        'D' => 'Ré',
        'E' => 'Mi',
        'F' => 'Fa',
        'G' => 'Sol'
    );

    private function englishNotation($chord)
    {
        if (in_array(substr(strtolower($chord),0,2),['la','si','do','ré','re','mi','fa','so'])) {
            return str_replace(['la','si','do','ré','re','mi','fa','sol'],['A','B','C','D','D','E','F','G'],strtolower($chord));
        }
        else {
            return $chord;
        }
    }

    public function __construct($chord,$text)
    {
        $this->chord = $chord;
        $this->text = $text;
    }


    public function getFrenchChord()
    {
        $chords = explode('/',$this->chord);
        foreach ($chords as $chord) {
            $result[] = $this->french_chords[substr($chord,0,1)].substr($chord,1);
        }
        return $this->englishNotation(implode('/',$result));
    }
    public function getChord()
    {
        return $this->englishNotation($this->chord);
    }
    public function getText()
    {
        return $this->text;
    }

    public function setChord($newchord)
    {
        $this->chord = $newchord;
    }
}
