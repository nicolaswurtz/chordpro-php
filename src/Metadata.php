<?php

namespace ChordPro;

class Metadata extends Line {
    private $name;
    private $value;

    public function __construct(string $name, ?string $value)
    {
        $this->name = $this->setName($name);
        $this->value = $value;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    private function setName($name)
    {
        if ($name === 't') {
            return 'title';
        }
        if ($name === 'st') {
            return 'subtitle';
        }
        if ($name === 'c') {
            return 'comment';
        }
        if ($name === 'ci') {
            return 'comment_italic';
        }
        if ($name === 'cb') {
            return 'comment_box';
        }
        if ($name === 'soc') {
            return 'start_of_chorus';
        }
        if ($name === 'eoc') {
            return 'end_of_chorus';
        }

        return $name;
    }
}
