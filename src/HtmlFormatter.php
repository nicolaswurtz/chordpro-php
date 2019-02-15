<?php

namespace ChordPro;

class HtmlFormatter implements FormatterInterface {

    private $sharp_symbol = '&#9839;'; // ♯
    private $natural_symbol = '&#9838;'; // ♮
    private $flat_symbol = '&#9837;'; // ♭
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

            $chords = [];
            $chord = (true === $this->french_chords) ? $block->getFrenchChord() : $block->getChord();

            $sliced_chords = explode('/',$chord);
            foreach ($sliced_chords as $sliced_chord) {
                // Test if minor/major presence before slice chord with exposant part
                if (strtolower(substr($sliced_chord,1,1)) == 'm') { // in first position (without alteration)
                    $chords[] = substr($sliced_chord,0,2).'<sup>'.substr($sliced_chord,2).'</sup>';
                }
                else if (strtolower(substr($sliced_chord,2,1)) == 'm') { // in second position (with alteration)
                    $chords[] = substr($sliced_chord,0,1).'<sup>'.substr($sliced_chord,1,1).'</sup>'.substr($sliced_chord,2,1).'<sup>'.substr($sliced_chord,3).'</sup>';
                }
                else {
                    $chords[] = substr($sliced_chord,0,1).'<sup>'.substr($sliced_chord,1).'</sup>';
                }
            }
            $chord = implode('/',$chords);

            $chord = $this->blankChars(str_replace(['#','b','K'],[$this->sharp_symbol,$this->flat_symbol,$this->natural_symbol],$chord));
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
