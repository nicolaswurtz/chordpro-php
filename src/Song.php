<?php

namespace ChordPro;

class Song extends \ArrayObject {

    private $key;
    private $french_chords_list = array(
        'A' => 'La',
        'B' => 'Si',
        'C' => 'Do',
        'D' => 'Ré',
        'E' => 'Mi',
        'F' => 'Fa',
        'G' => 'Sol'
    );

    public function __construct($lines)
    {
        $this->lines = $lines;
    }

    public function getOriginalKey()
    {
        foreach ($this->lines as $line) {
            if ($line instanceof Metadata and $line->getName() == 'key') {
                return $line->getValue();
            }
        }
    }
    public function getKey($options)
    {
        $key = (empty($this->key)) ? $this->getOriginalKey() : $this->key;
        return (isset($options['french']) and true === $options['french']) ? $this->toFrench($key) : $key;
    }
    public function setKey($value)
    {
        $this->key = $value;
    }

    private function toFrench($key)
    {
        return (null !== $key) ? $this->french_chords_list[substr($key,0,1)].substr($key,1) : $key;
    }
}
