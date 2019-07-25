<?php

namespace ChordPro;

class HtmlFormatter extends Formatter implements FormatterInterface {

    private $sharp_symbol = '&#9839;'; // ♯
    private $natural_symbol = '&#9838;'; // ♮
    private $flat_symbol = '&#9837;'; //

    public function format(Song $song, array $options): string
    {
        $this->setOptions($song,$options);

        $html = '';
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
            return (true === $this->no_chords) ? $this->getLyricsOnlyHtml($line) : $this->getLyricsHtml($line);
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
                $content = (null !== $metadata->getValue()) ? '<div class="chordpro-chorus-comment">'
                    .$metadata->getValue().'</div>' : '';
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
        $verse = '<div class="chordpro-verse">';
        foreach ($lyrics->getBlocks() as $block) {

            $chords = [];

            $sliced_chords = (true === $this->french_chords) ? $block->getFrenchChord() : $block->getChord();
            if (is_array($sliced_chords)) {
                foreach ($sliced_chords as $sliced_chord) {
                    // Test if minor/major presence before slice chord with exposant part
                    if (strtolower(substr($sliced_chord[1],0,1)) == 'm') { // in first position (without alteration)
                        $chords[] = $sliced_chord[0].substr($sliced_chord[1],0,1).'<sup>'.substr($sliced_chord[1],1)
                            .'</sup>';
                    }
                    else if (strtolower(substr($sliced_chord[1],1,1)) == 'm') { // in second position (with alteration)
                        $chords[] = $sliced_chord[0].'<sup>'.substr($sliced_chord[1],0,1).'</sup>'
                            .substr($sliced_chord[1],1,1).'<sup>'.substr($sliced_chord[1],2).'</sup>';
                    }
                    else {
                        $chords[] = $sliced_chord[0].'<sup>'.substr($sliced_chord[1],0).'</sup>';
                    }
                }
            }

            $chord = implode('/',$chords);

            $chord = $this->blankChars(str_replace(
                ['#','b','K'],
                [$this->sharp_symbol,$this->flat_symbol,$this->natural_symbol],
                $chord
                ));
            $text = $this->blankChars($block->getText());

            $verse .= '<span class="chordpro-elem">
              <span class="chordpro-chord">'.$chord.'</span>
              <span class="chordpro-text">'.$text.'</span>
            </span>';
        }
        $verse .= '</div>';
        return $verse;
    }

    private function getLyricsOnlyHtml(Lyrics $lyrics)
    {
        $verse = '<div class="chordpro-verse">';
        foreach ($lyrics->getBlocks() as $block) {
            $verse .= ltrim($block->getText());
        }
        $verse .= '</div>';
        return $verse;
    }
}
