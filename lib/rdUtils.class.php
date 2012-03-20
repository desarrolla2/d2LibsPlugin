<?php

class rdUtils {

    static protected $zendAutoloader = false;

    static public function mysqlDateToTime($string_time) {
        $items = preg_split('#[\-\:\s]#', $string_time);
        if (count($items) != 6) {
            return false;
        }
        if (!checkdate($items[1], $items[2], $items[0])) {
            return false;
        }
        return mktime($items[3], $items[4], $items[5], $items[1], $items[2], $items[0]);

        //'2011-05-31 00:00:00'
    }

    /**
     * truncate int number to array
     * Example 125 => array(1,2,5);
     * 
     * @param int $int
     * @return array
     */
    static public function IdSplit($int) {
        return str_split((int) $int);
    }

    /**
     * Truncate decimals numbers if not valid
     * set ',' for decimal separator.
     * @param float $number
     * @return string $number 
     */
    static public function formatPrice($number) {
        $number = floatval($number);
        $decimals = self::getNumberOfDecimal($number);
        if ($decimals > 2) {
            $decimals = 2;
        }
        return number_format($number, $decimals, ',', '');
    }

    static public function getNumberOfDecimal($number) {
        return strlen(substr(strrchr($number, '.'), 1));
    }

    static public function cleanNonDigitsCharacters($string) {
        return preg_replace('#[\D]#', '', $string);
    }

    static public function cleanNonDigitsOrNetsCharacters($string) {
        return preg_replace('#[\D\.]#', '', $string);
    }

    static public function compare_dates($start, $end, $format = 'Y-m-d') {
        if (date_create_from_format($format, $start) > date_create_from_format($format, $end)) {
            throw new Exception(' La fecha final no puede ser mayor que la inicial.');
        }
        return true;
    }

    static public function getHash($length = 64, $hash = '') {
        $hash = sha1(uniqid(mt_rand(), true)) . $hash;
        if (strlen($hash) < $length) {
            $hash = rdUtils::getHash($length, $hash);
        }
        if (strlen($hash) > $length) {
            $hash = substr($hash, 0, $length);
        }
        return $hash;
    }

    static public function normalize($string) {
        $convert_from = array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
            'V', 'W', 'X', 'Y', 'Z', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï',
            'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж',
            'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ъ',
            'Ь', 'Э', 'Ю', 'Я', 'Ç'
        );
        $convert_to = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u',
            'v', 'w', 'x', 'y', 'z', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï',
            'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж',
            'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы',
            'ь', 'э', 'ю', 'я', 'ç'
        );
        return str_replace($convert_from, $convert_to, $string);
    }

    static public function replace_accents($string) {

        $string = htmlentities($string);

        $string = preg_replace(
                '/&([a-zA-Z])(uml|acute|grave|circ|tilde);/', '$1', $string);
        return html_entity_decode($string);
    }

    static public function ucwords($string) {

        if (strlen($string) > 0) {
            $first = $string[0];
            $convert_from = array(
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u',
                'v', 'w', 'x', 'y', 'z', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï',
                'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж',
                'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы',
                'ь', 'э', 'ю', 'я', 'ç'
            );
            $convert_to = array(
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
                'V', 'W', 'X', 'Y', 'Z', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï',
                'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж',
                'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ъ',
                'Ь', 'Э', 'Ю', 'Я', 'Ç'
            );

            $first = str_replace($convert_from, $convert_to, $first);
        }

        $string = $first . rdUtils::normalize(substr($string, 1));

        return $string;
    }

    static public function removeHTMLConversion($string) {

        $convert_from = array(
            '&#039;'
        );
        $convert_to = array(
            "'"
        );

        return str_replace($convert_from, $convert_to, $string);
    }

    /*
     * Modifies a string to remove al non ASCII characters and spaces.
     */

    static public function slugify($text, $spacing = false, $space_char='-', $empty_value = 'n-a') {
        $text = trim(strtolower($text));
        $text = str_replace('á', 'a', $text);
        $text = str_replace('é', 'e', $text);
        $text = str_replace('í', 'i', $text);
        $text = str_replace('ó', 'o', $text);
        $text = str_replace('ú', 'u', $text);
        $text = str_replace('ü', 'u', $text);
        $text = str_replace('ñ', 'n', $text);
        if ($spacing) {
            $text = preg_replace('/^(\w\s)/', $space_char, $text);
        } else {
            $text = preg_replace('/\W+/', $space_char, $text);
        }
        if (empty($text)) {
            return $empty_value;
        }
        return $text;
    }

    static public function getLatAndLngByCp($cp, $url = 'http://maps.google.es/maps/geo') {

        $cp = str_pad($cp, 5, '0', STR_PAD_LEFT);
        $xml = simplexml_load_file(
                $url . '?output=xml&q=' . $cp . ',Spain'
        );

        if (!$xml) {
            throw new Exception('Could not access the geocoding service: ' . $url);
        }
        $coordinates = $xml->Response->Placemark->Point->coordinates;
        $coordinates = explode(',', $coordinates);
        return array(
            'lat' => $coordinates[1],
            'lng' => $coordinates[0],
            'city' => $xml->Response->Placemark->AddressDetails->Country
            ->AdministrativeArea->SubAdministrativeArea->Locality->LocalityName,
        );
    }

    static public function getPriceRanges($min_price = null, $max_price = null, $max_ranges = null) {
        if (!$max_ranges) {
            $max_ranges = sfConfig::get('app_filter_price_ranges');
        }
        if (!$min_price || !$max_price || !$max_ranges) {
            return array();
        }
        $ranges = array();
        $diff_price = $max_price - $min_price;
        if ($diff_price >= $max_ranges) {
            $step = floor($diff_price / $max_ranges);
            $i = (float) $min_price;
            while ($i < $max_price) {
                $ranges[] = array(
                    'min' => $i,
                    'max' => $i + $step
                );
                $i += $step;
            }
        }
        return $ranges;
    }

    static public function getSortString($string, $length) {
        if (strlen($string) > $length) {
            return substr($string, 0, $length) . '...';
        } else {
            return $string;
        }
    }

    static public function createPassword($length) {
        /* Se valida la longitud proporcionada. Debe ser número y mayor de cero.
          Si es menor o igual a cero le asignamos la longitud por defecto.
          Si es mayor de 32 le asignamos 32.
         */
        if ((!is_numeric($length)) || ($length <= 0)) {
            $length = 8;
        }
        if ($length > 32) {
            $length = 32;
        }

        /* Asignamos el juego de caracteres al array $caracteres para generar la contraseña.
          Podemos añadir más caracteres para hacer más segura la contraseña.
         */
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        /* Introduce la semilla del generador de números aleatorios mejorado */
        mt_srand(microtime() * 1000000);

        $password = '';
        for ($i = 0; $i < $length; $i++) {
            /* Genera un valor aleatorio mejorado con mt_rand, entre 0 y el tamaño del array
              $caracteres menos 1. Posteríormente vamos concatenando en la cadena $password
              los caracteres que se van eligiendo aleatoriamente.
             */
            $key = mt_rand(0, strlen($chars) - 1);
            $password = $password . $chars{$key};
        }

        return $password;
    }

    static function add_folder_to_include_path($folder) {
        if (is_dir($folder)) {
            set_include_path(implode(PATH_SEPARATOR, array($folder, get_include_path())));
        } else {
            throw new Exception('this folder not exist ( ' . $folder . ') ');
        }
    }

    /**
     * Agrega el framework Zend a nuestra App 
     */
    static public function registerZend() {
        if (!self::$zendAutoloader) {
            rdUtils::add_folder_to_include_path(sfConfig::get('sf_plugins_dir') . '/rdLibsPlugin/lib/vendor');
            require_once 'Zend/Loader/Autoloader.php';
            self::$zendAutoloader = Zend_Loader_Autoloader::getInstance();
        }
        return self::$zendAutoloader;
    }

}

