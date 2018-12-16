<?php

namespace chordprophp;

/**
 * Transform chordpro plaintext into pure html components, ready to be stylised with CSS
 */
class chordpro
{
  private $_html; // HTML output
  private $_text; // Plain text output

  function __construct($chordpro)
  {
    $chordpro = str_replace("\r\n","\n",$chordpro);
    foreach (explode("\n",$chordpro) as $line) {
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

  private function transpose($chord)
  {
    return $chord;
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
          $chord = $this->transpose($block[0]);
          $content .= '<span class="chordpro-elem"><span class="chordpro-chord">'.$chord.'</span><span class="chordpro-text">&nbsp;</span></span>';
          $chord = '';
          $text = $this->blank_chars($block[1]);
        }
        else {
          $chord = $this->transpose($block[0]);
          $text = $this->blank_chars($block[1]);
        }

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

  public function getHtml()
  {
    return implode($this->_html);
  }
}
