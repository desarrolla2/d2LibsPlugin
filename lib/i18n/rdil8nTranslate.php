<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rdil8nTranslate
 *
 * @author raul
 */
class rdil8nTranslate {

    //put your code here

    /*
     * Traduce la fraseorigen $source del idioma $lang_source al idioma $lang_target
     */

    static public function get($text, $from = '', $to = 'ca') {

        $url = 'http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=' . rawurlencode($text) . '&langpair=' . rawurlencode($from . '|' . $to);
        $response = file_get_contents(
                $url, null, stream_context_create(
                        array(
                            'http' => array(
                                'method' => "GET",
                                'header' => "Referer: http://.www.example.com./\r\n"
                            )
                        )
                )
        );
        if (preg_match("/{\"translatedText\":\"([^\"]+)\"/i", $response, $matches)) {
            return self::_unescapeUTF8EscapeSeq($matches[1]);
        }
        return false;
    }

    /**
     * Convert UTF-8 Escape sequences in a string to UTF-8 Bytes. Old version.
     * @return UTF-8 String
     * @param $str String
     */
    function __unescapeUTF8EscapeSeq($str) {
        return preg_replace_callback("/\\\u([0-9a-f]{4})/i", create_function('$matches', 'return html_entity_decode(\'&#x\'.$matches[1].\';\', ENT_NOQUOTES, \'UTF-8\');'), $str);
    }

    /**
     * Convert UTF-8 Escape sequences in a string to UTF-8 Bytes
     * @return UTF-8 String
     * @param $str String
     */
    function _unescapeUTF8EscapeSeq($str) {
        return preg_replace_callback("/\\\u([0-9a-f]{4})/i", create_function('$matches', 'return rdil8nTranslate::_bin2utf8(hexdec($matches[1]));'), $str);
    }

    /**
     * Convert binary character code to UTF-8 byte sequence
     * @return String
     * @param $bin Mixed Interger or Hex code of character
     */
    function _bin2utf8($bin) {
        if ($bin <= 0x7F) {
            return chr($bin);
        } else if ($bin >= 0x80 && $bin <= 0x7FF) {
            return pack("C*", 0xC0 | $bin >> 6, 0x80 | $bin & 0x3F);
        } else if ($bin >= 0x800 && $bin <= 0xFFF) {
            return pack("C*", 0xE0 | $bin >> 11, 0x80 | $bin >> 6 & 0x3F, 0x80 | $bin & 0x3F);
        } else if ($bin >= 0x10000 && $bin <= 0x10FFFF) {
            return pack("C*", 0xE0 | $bin >> 17, 0x80 | $bin >> 12 & 0x3F, 0x80 | $bin >> 6 & 0x3F, 0x80 | $bin & 0x3F);
        }
    }

}