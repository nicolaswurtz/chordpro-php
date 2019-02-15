<?php

namespace ChordPro;

class Song extends \ArrayObject {
    private $key;

    public function __construct($lines)
    {
        $this->lines = $lines;
        $this->key = $this->searchKey($lines);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey(string $key)
    {
        $this->key = $key;
    }

    // Get KEY at contruction of Song with metadata:key
    private function searchKey($lines)
    {
        foreach ($lines as $line) {
            if ($line instanceof Metadata and $line->getName() == 'key') {
                return $line->getValue();
            }
        }
    }
}
