<?php

namespace ChordPro;

class Song extends \ArrayObject {
    public function __construct($lines)
    {
        $this->lines = $lines;
    }
}
