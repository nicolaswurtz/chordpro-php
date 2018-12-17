<?php

namespace chordprophp;

/**
 * Transform chordpro plaintext into pure html components, ready to be stylised with CSS
 */
class chordpro
{
  private $_chordpro; // Source
  private $_html; // HTML output
  private $_text; // Plain text output
  private $_transpose; // Positive or negative numeric value for transposing

  private $_dieze = '&#9839;'; // ♯
  private $_bemol = '&#9837;'; // ♭

  private $_french_chords = array(
    'A' => 'La',
    'B' => 'Si',
    'C' => 'Do',
    'D' => 'Ré',
    'E' => 'Mi',
    'F' => 'Fa',
    'G' => 'Sol'
  );

  private $_simple_transpose = array(
    'C'   => 0,
    'C#'  => 1,
    'Db'  => 1,
    'D'   => 2,
    'Eb'  => 3,
    'D#'  => 3,
    'E'   => 4,
    'F'   => 5,
    'F#'  => 6,
    'Gb'  => 6,
    'G'   => 7,
    'Ab'  => 8,
    'G#'  => 8,
    'A'   => 9,
    'Bb'  => 10,
    'A#'  => 10,
    'B'   => 11,
  );

  function __construct($chordpro)
  {
    $this->_chordpro = str_replace("\r\n","\n",$chordpro);
  }

  private function parser()
  {
    foreach (explode("\n",$this->_chordpro) as $line) {
      $line = trim($line);
      switch (substr($line,0,1)) {
        case "{":
          $this->meta_data($line);
          break;
        case "":
          $this->_html[] = '<br>';
          $this->_text[] = "\n";
          break;
        default:
          $this->lyrics_chords($line);
      }
    }
  }

  private function format_chord($chords)
  {
    $chords = explode('/',$chords);
    foreach ($chords as $chord) {
      $pos = (in_array(substr($chord,1,1),['b','#'])) ? 2 : 1;
      $chord = [substr($chord,0,$pos),substr($chord,$pos)];

      if (!empty($this->_transpose) and $this->_transpose < 12 and $this->_transpose > -12) {
        $key = $this->_simple_transpose[$chord[0]];
        $new_key = ($key + $this->_transpose < 0) ? 12 + ($key + $this->_transpose) : ($key + $this->_transpose) % 12;
        $chord[0] = array_search($new_key,$this->_simple_transpose);
      }

      if ($this->_french === true) {
        $chord[0] = $this->_french_chords[substr($chord[0],0,1)].substr($chord[0],1);
      }

      $chord[0] = str_replace(['#','b'],[$this->_dieze,$this->_bemol],$chord[0]);

      $formatted[] = implode($chord);
    }
    return implode('/',$formatted);
  }

  private function blank_chars($text)
  {
    return str_replace(' ','&nbsp;',ltrim($text));
  }

  private function lyrics_chords($line)
  {
    $this->_text[] = preg_replace('/\[.*?\]/','',$line);

    $blocks = explode('[',$line);
    foreach($blocks as $num => $block) {
      if (!empty($block)) {
        $block = explode(']',$block);

        // If first line begins with text and not a chord
        if ($num == 0 and count($block) == 1) {
          $chord = '';
          $text = $this->blank_chars($block[0]);
        }
        else if (substr($block[1],0,1) == " ") {
          $chord = $this->format_chord($block[0]);
          $content .= '<span class="chordpro-elem"><span class="chordpro-chord">'.$chord.'</span><span class="chordpro-text">&nbsp;</span></span>';
          $chord = '';
          $text = $this->blank_chars($block[1]);
        }
        else {
          $chord = $this->format_chord($block[0]);
          $text = $this->blank_chars($block[1]);
        }

        if (empty($text))
          $text = "&nbsp;";

        $content .= '<span class="chordpro-elem">
          <span class="chordpro-chord">'.$chord.'</span>
          <span class="chordpro-text">'.$text.'</span>
        </span>';
      }
    }

    $this->_html[] = '<div class="chordpro-verse">'.$content.'</div>';
  }

  private function meta_data($line)
  {
    $line = trim($line,"{}");
    $pos = strpos($line,":");

    if ($pos !== false) {
      $type = substr($line,0,$pos);
      $content = substr($line,$pos+1);
    }
    else {
      $type = $line;
      $content = null;
    }

    switch ($type) {
      // Meta-data directives
      case "t":
      case "title":
        $this->_html[] = '<div>'.$type.' | '.$content.'</div>';
        break;

      // Formatting directives

      // Environment directives
      case "soc":
        $this->_html[] = '<div class="chordpro-chorus">';
        break;
      case "eoc":
        $this->_html[] = '</div>';
        break;

      default:
        $this->_html[] = '<div>'.$type.' | '.$content.'</div>';
        break;
    }
  }

  public function options($options)
  {
    if (isset($options['transpose']) and is_numeric($options['transpose']))
      $this->_transpose = $options['transpose'];

    if (isset($options['french']) and $options['french'] === true)
      $this->_french = true;
  }

  public function getHtml()
  {
    $this->parser();
    return implode($this->_html);
  }
}
