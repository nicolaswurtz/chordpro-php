<?php

namespace ChordPro;

class JSONFormatter implements FormatterInterface {

    private $french_chords;

    public function format(Song $song, array $options): string
    {
        if (isset($options['french']) and true === $options['french']) {
            $this->french_chords = true;
        }
        foreach ($song->lines as $line) {
            if (null === $line) {
                $json[] = null;
                continue;
            }

            $json[] = $this->getLineJSON($line);
        }
        return json_encode($json,JSON_PRETTY_PRINT);
    }


    private function getLineJSON(Line $line)
    {
        if ($line instanceof Metadata) {
            return $this->getMetadataJSON($line);
        }

        if ($line instanceof Lyrics) {
            return $this->getLyricsJSON($line);
        }
    }

    private function getMetadataJSON($metadata)
    {
        return (empty($metadata->getValue()) ? [$metadata->getName()] : [$metadata->getName() => $metadata->getValue()]);
    }
    private function getLyricsJSON($lyrics)
    {
        foreach ($lyrics->getBlocks() as $block) {
            $chord = (true === $this->french_chords) ? $block->getFrenchChord().' ' : $block->getChord().' ';
            $text = $block->getText();
            $return[] = array('chord' => trim($chord), 'text' => $text);
        }
        return $return;
    }
}
