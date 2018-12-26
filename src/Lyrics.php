<?php

namespace ChordPro;

class Lyrics extends Line {

    private $blocks;

    public function __construct(array $blocks)
    {
        $this->blocks = $blocks;
    }

    public function getBlocks()
    {
        return $this->blocks;
    }
}
