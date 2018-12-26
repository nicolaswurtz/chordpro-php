<?php

namespace ChordPro;

class Parser
{
    public function parse(string $text): Song
    {
        $text = str_replace("\r\n","\n",$text);

        foreach (explode("\n",$text) as $line) {
            $line = trim($line);
            switch (substr($line,0,1)) {
                case "{":
                    $result[] = $this->parseMetadata($line);
                    break;
                case "":
                    $result[] = null;
                    break;
                default:
                    $result[] = $this->parseLyrics($line);
            }
        }

        return new Song($result);
    }

    private function parseMetadata(string $line): Metadata
    {
        $line = trim($line,"{}");
        $pos = strpos($line,":");

        if ($pos !== false) {
            $name = substr($line,0,$pos);
            $value = substr($line,$pos+1);
        }
        else {
            $name = $line;
            $value = null;
        }

        return new Metadata($name, $value);
    }

    private function parseLyrics(string $line)
    {
        $blocksObjs = array();
        $blocks = explode('[',$line);
        foreach($blocks as $num => $block) {
            if (!empty($block)) {
                $block = explode(']',$block);

                if (isset($block[1]) and empty($block[1]))
                    $block[1] = null;
                    
                // If first line begins with text and not a chord
                if ($num == 0 and count($block) == 1) {
                    $blocksObjs[] = new Block(null,$block[0]);
                }
                else if (substr($block[1],0,1) == " ") {
                    $blocksObjs[] = new Block($block[0],null);
                    $blocksObjs[] = new Block(null,$block[1]);
                }
                else {
                    $blocksObjs[] = new Block($block[0],$block[1]);
                }
            }
        }
        return new Lyrics($blocksObjs);
    }
}
