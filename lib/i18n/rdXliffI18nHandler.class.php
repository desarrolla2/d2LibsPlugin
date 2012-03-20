<?php

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package     : sinersis
 * @author      : daniel.gonzalez@freelancemadrid.es
 * @version     : SVN: $Id: rdXliffI18nHandler.class 1.0  24-ago-2010 15:40:04
 *
 * @file        : rdXliffI18nHandler , UTF-8
 * @date        : 27-May-2011
 */

/**
 * rdXliffI18nHandler class
 *
 */
class rdXliffI18nHandler {

    private $counter = 0;
    private $debug = false;
    private $nodes = array();
    private $node = array();
    private $tab = "    ";

    public function setFileName($file_name) {

        if (!is_file($file_name)) {
            throw new Exception('Cant find file : ' . $file_name);
        }

        $this->file_name = $file_name;
    }

    private function renderHead() {
        return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<!DOCTYPE xliff PUBLIC "-//XLIFF//DTD XLIFF//EN" "http://www.oasis-open.org/committees/xliff/documents/xliff.dtd">' . PHP_EOL .
                '<xliff version="1.0">' . PHP_EOL .
                '<file source-language="EN" target-language="es" datatype="plaintext" original="messages"  product-name="messages">' . PHP_EOL .
                $this->tab . '<header/> ' . PHP_EOL .
                $this->tab . '<body>' . PHP_EOL;
    }

    private function renderFoot() {
        return $this->tab . '</body>' . PHP_EOL . '</file>' . PHP_EOL . '</xliff>';
    }

    public function addNode($node = array()) {
        if (is_array($node)) {
            if (isset($node['source']) && isset($node['target'])) {
                array_push($this->nodes, array(
                    'source' => $node['source'],
                    'target' => $node['target']
                ));
            }
        }
    }

    public function i18n($source = 'es', $target= 'ca') {
        for ($i = 0; $i < count($this->nodes); $i++) {
            $this->nodes[$i]['target'] = rdil8nTranslate::get($this->nodes[$i]['target'], $source, $target);
        }
    }

    private function sortNodes() {
        $temp = array();
        for ($i = 0; $i < count($this->nodes); $i++) {
            for ($j = $i + 1; $j < count($this->nodes); $j++) {
                if ($this->nodes[$i] > $this->nodes[$j]) {
                    $temp = $this->nodes[$i];
                    $this->nodes[$i] = $this->nodes[$j];
                    $this->nodes[$j] = $temp;
                }
            }
        }
        return $this->nodes;
    }

    private function getCounter() {
        return $this->counter++;
    }

    private function reset() {
        $this->counter = 0;
    }

    private function renderBody() {
        $this->sortNodes();
        $this->reset();
        $text = '';
        foreach ($this->nodes as $this->node) {
            $text .= $this->tab . $this->tab . '<trans-unit id="' . $this->getCounter() . '">' . PHP_EOL .
                    $this->tab . $this->tab . $this->tab . '<source>' . $this->node['source'] . '</source>' . PHP_EOL .
                    $this->tab . $this->tab . $this->tab . '<target>' . $this->node['target'] . '</target>' . PHP_EOL .
                    $this->tab . $this->tab . '</trans-unit>' . PHP_EOL;
            if ($this->debug){
                echo $this->node['source'] . ' => ' . $this->node['target'] . PHP_EOL;
            }
        }
        return $text;
    }

    public function render() {
        return $this->renderHead() .
                $this->renderBody() .
                $this->renderFoot();
    }

    public function save($file_name, $debug = false) {
        $this->debug = $debug;
        file_put_contents($file_name, $this->render());
    }

}