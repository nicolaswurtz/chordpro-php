<?php

namespace ChordPro;

class MonospaceFormatter implements FormatterInterface {

    private $french_chords;

    public function format(Song $song, array $options): string
    {
        if (isset($options['french']) and true === $options['french']) {
            $this->french_chords = true;
        }

        foreach ($song->lines as $line) {
            if (null === $line) {
                $monospace .= "\n";
                continue;
            }

            $monospace .= $this->getLineMonospace($line);
        }
        return $monospace;
    }

    private function getLineMonospace(Line $line)
    {
        if ($line instanceof Metadata) {
            return $this->getMetadataMonospace($line);
        }

        if ($line instanceof Lyrics) {
            return $this->getLyricsMonospace($line);
        }
    }

    private function getMetadataMonospace(Metadata $metadata)
    {
        switch($metadata->getName()) {
            case 'start_of_chorus':
                $content = (null !== $metadata->getValue()) ? $metadata->getValue()."\n" : "CHORUS\n";
                return $content;
                break;
            case 'end_of_chorus':
                return "\n";
                break;
            default:
                return $metadata->getValue()."\n";
        }
    }

    private function genBlank($count)
    {
        $i = 1;
        $blank = '';
        if ($count >= 1) {
            while ($i <= $count) {
                $blank .= ' ';
                $i++;
            }
        }
        return $blank;
    }

    private function getLyricsMonospace(Lyrics $lyrics)
    {
        foreach ($lyrics->getBlocks() as $block) {

            $chord = (true === $this->french_chords) ? $block->getFrenchChord().' ' : $block->getChord().' ';
            $text = $block->getText();

            if (mb_strlen($text) < mb_strlen($chord)) {
                $text = $text.$this->genBlank(mb_strlen($chord) - mb_strlen($text));
            }

            $chords .= $chord.$this->genBlank(mb_strlen($text) - mb_strlen($chord));
            $texts .= $text;
        }
        return $chords."\n".$texts."\n";
    }
}
