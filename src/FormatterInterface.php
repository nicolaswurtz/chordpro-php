<?php

namespace ChordPro;

interface FormatterInterface {
    public function format(Song $song, array $options): string;
}
