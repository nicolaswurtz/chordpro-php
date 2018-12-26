<?php

namespace ChordPro;

class HtmlFormatter implements FormatterInterface {

    private $diezeHTML = '&#9839;'; // ♯
    private $bemolHTML = '&#9837;'; // ♭
    private $french_chords;

    public function format(Song $song, array $options): string
    {
        if (isset($options['french']) and true === $options['french']) {
            $this->french_chords = true;
        }
        
        foreach ($song->lines as $line) {
            if (null === $line) {
                $html .= '<br />';
                continue;
            }

            $html .= $this->getLineHtml($line);
        }
        return $html;
    }

    private function getLineHtml(Line $line)
    {
        if ($line instanceof Metadata) {
            return $this->getMetadataHtml($line);
        }

        if ($line instanceof Lyrics) {
            return $this->getLyricsHtml($line);
        }
    }

    private function blankChars($text)
    {
        if (null === $text) {
            $text= '&nbsp;';
        }
        return str_replace(' ','&nbsp;',$text);
    }

    private function getMetadataHtml(Metadata $metadata)
    {
        switch($metadata->getName()) {
            case 'start_of_chorus':
                $content = (null !== $metadata->getValue()) ? '<div class="chordpro-chorus-comment">'.$metadata->getValue().'</div>' : '';
                return $content.'<div class="chordpro-chorus">';
                break;
            case 'end_of_chorus':
                return '</div>';
                break;
            default:
                return '<div class="chordpro-'.$metadata->getName().'">'.$metadata->getValue().'</div>';
        }
    }

    private function getLyricsHtml(Lyrics $lyrics)
    {
        $verse .= '<div class="chordpro-verse">';
        foreach ($lyrics->getBlocks() as $block) {

            $chord = (true === $this->french_chords) ? $block->getFrenchChord() : $block->getChord();
            $chord = $this->blankChars(str_replace(['#','b'],[$this->diezeHTML,$this->bemolHTML],$chord));
            $text = $this->blankChars($block->getText());

            $verse .= '<span class="chordpro-elem">
              <span class="chordpro-chord">'.$chord.'</span>
              <span class="chordpro-text">'.$text.'</span>
            </span>';
        }
        $verse .= '</div>';
        return $verse;
    }
}
