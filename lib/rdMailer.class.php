<?php

/**
 * This file is part of the desarrolla2 proyect.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author      : daniel.gonzalez@freelancemadrid.es
 *
 * @file        : rdMailer.class.php , UTF-8
 * @date        : 4-nov-2010 , 13:08:44
 */
/*
 * rdMailer manager class for mailer actions
 * UPDATE `sinersis_local`.`communiquies` SET `communiquies_state_id` = '2' WHERE `communiquies`.`id` =12;
 */
class rdMontenevadoMailer extends rdMailer {
    
    public function setDefaultOptions() {
        $this->options = array(
            'app_name' => 'montenevado',
            'home_page' => 'http://montenevado.com/',
            'from_name' => 'Montenevado',
            'from_mail' => 'no-reply@montenevado.com',
            'layout_name' => 'layout',
        );
        
        if (sfContext::hasInstance()) {
            $this->setOption('home_page', sfContext::getInstance()->getRouting()->generate('homepage', array(), true));
            $this->setOption('from_name', sfConfig::get('app_no_reply_name'));
            $this->setOption('from_mail', sfConfig::get('app_no_reply_mail'));
        }
                
        $this->setOption('app_name', $this->options['app_name']);
        $this->setOption('layout_name', $this->options['layout_name']);
        $this->setOption('app_dir', sfConfig::get('sf_apps_dir') . '/' . $this->getOption('app_name') . '/');
        $this->setOption('template_dir', $this->getOption('app_dir') . 'templates/mail/');
        $this->setOption('template_file', $this->getOption('template_dir') . 'mail.php.html');
    }
}

class rdMailer {

    private $mailer = null;
    private $failure = null;
    private $failures = array();
    private $message = null;
    private $options = array();
    
    public function setDefaultOptions() {
        $this->options = array(
            'app_name' => 'sinersis',
            'home_page' => 'http://sinersis.radmas.com/',
            'from_name' => 'SINERSIS',
            'from_mail' => 'no-reply@sinersis.es',
            'layout_name' => 'layout',
        );

        if (sfContext::hasInstance()) {
            $this->setOption('home_page', sfContext::getInstance()->getRouting()->generate('homepage', array(), true));
            $this->setOption('from_name', sfConfig::get('app_no_reply_name'));
            $this->setOption('from_email', sfConfig::get('app_no_reply_mail'));
        }
        $this->setOption('app_dir', sfConfig::get('sf_apps_dir') . '/' . $this->getOption('app_name') . '/');
        $this->setOption('template_dir', $this->getOption('app_dir') . 'templates/mail/');
        $this->setOption('template_file', $this->getOption('template_dir') . 'mail.php.html');
    }

    public function setBrand(Brands $brand) {
        $this->setOption('app_name', $brand->getSlug());
        $this->setOption('home_page', $brand->getUrl());
        $this->setOption('from_name', $brand->getName());
        $this->setOption('from_mail', $brand->getNoreplyEmail());
        $this->setOption('app_dir', sfConfig::get('sf_apps_dir') . '/' . $this->getOption('app_name') . '/');
        $this->setOption('template_dir', $this->getOption('app_dir') . 'templates/mail/');
        $this->setOption('template_file', $this->getOption('template_dir') . 'mail.php.html');
        $this->setOption('factories_file', $this->getOption('app_dir') . 'config/factories.yml');

        $this->factories_yml = sfYaml::load($this->getOption('factories_file'));
        $this->mailer->getTransport()->setUsername($this->getTransportOption('username'));
        $this->mailer->getTransport()->setPassword($this->getTransportOption('password'));
        $this->mailer->getTransport()->setHost($this->getTransportOption('host'));
        $this->mailer->getTransport()->setPort($this->getTransportOption('port'));
    }

    public function getTransportOption($key) {
        if (isset($this->factories_yml['all']['mailer']['param']['transport']['param'][$key])) {
            return $this->factories_yml['all']['mailer']['param']['transport']['param'][$key];
        } else {
            throw new Exception('Transport Option (' . $key . ') not exist');
        }
    }

    public function setOption($key, $value) {
        $this->options[$key] = $value;
    }

    public function getOption($key) {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        } else {
            throw new Exception('Option (' . $key . ') not exist');
            return false;
        }
    }

    /**
     * Contruct and initialize rdMailer
     * 
     * @param sfMailer $mailer 
     */
    public function __construct(sfMailer $mailer = null, $options = array()) {

        $this->setDefaultOptions();

        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }

        if ($mailer) {
            $this->mailer = $mailer;
        } else {
            if (sfContext::hasInstance()) {
                $this->mailer = sfContext::getInstance()->getMailer();
            } else {
                throw new Exception('requierd sfContext instance or sfMailer parametter');
            }
        }
        $this->message = $this->mailer->compose();
    }

    public function setTo($addresses, $name = null) {
        return $this->message->setTo($addresses, $name);
    }

    public function setBcc($addresses, $name = null) {
        return $this->message->setBcc($addresses, $name);
    }

    public function addTo($addresses, $name = null) {
        return $this->message->addTo($addresses, $name);
    }

    public function getTo() {
        return $this->message->getTo();
    }

    /**
     * Merge array $parameters and $options
     * 
     * @param array $parameters rendered in template
     * @return array $parameters merged with option
     */
    private function mergeParametters($parameters = array()) {
        foreach ($this->options as $key => $value) {
            if (!isset($parameters[$key])) {
                $parameters[$key] = $value;
            }
        }
        return $parameters;
    }

    protected function renderParametters($body = '', $parameters= array()) {
        if ($parameters) {
            foreach ($parameters as $key => $value) {
                $body = str_replace('{' . $key . '}', $value, $body);
            }
            foreach ($parameters as $key => $value) {
                if ($n = strpos($body, '{' . $key . '}')) {
                    $body = $this->renderParametters($body, $parameters);
                }
            }
        }
        return $body;
    }

    private function renderTemplate($template_name, $parameters = array()) {
        $parameters = $this->mergeParametters($parameters);

        if (!$template_name) {
            throw new Exception('$template_name is required!');
        }
        $this->setOption('layout_file', $this->getOption('template_dir') . $this->getOption('layout_name') . '.php.html');
        $this->setOption('template_file', $this->getOption('template_dir') . $template_name . '.php.html');

        if (!file_exists($this->getOption('template_file'))) {
            throw new Exception(' Template file (' . $this->getOption('template_file') .
                    ') not exist in (' . $this->getOption('template_dir') . ')');
        }
        if (!file_exists($this->getOption('layout_file'))) {
            throw new Exception(' Layout file (' . $this->getOption('layout_file') .
                    ') not exist in (' . $this->getOption('template_dir') . ')');
        }
        $layout = file_get_contents($this->getOption('layout_file'));
        $template = file_get_contents($this->getOption('template_file'));
        $template = $template = str_replace('{body}', $template, $layout);
        $template = $this->renderParametters($template, $parameters);
        return $template;
    }

    public function setBody($template = null, $parameters = array()) {
        $this->message->setBody($this->renderTemplate($template, $parameters));
    }

    public function getBody($template = null, $parameters = array()) {
        return $this->renderTemplate($template, $parameters);
    }

    public function setSubject($subject) {
        $this->message->setSubject($subject);
    }

    public function send() {
        $failure = null;
        $this->message->setContentType('text/html');
        $this->message->setFrom($this->getOption('from_mail'), $this->getOption('from_name'));
        try {            
            $n = $this->mailer->send($this->message, $failure);
            if ($failure) {
                $this->setFailure($failure);
            }
            return $n;
        } catch (Exception $e) {
            $failure = $e->getMessage();
            $this->setFailure($failure);
        }
        return false;
    }

    public function batchSend() {
        $failure = null;
        $this->message->setContentType('text/html');
        $this->message->setFrom($this->getOption('from_mail'), $this->getOption('from_name'));
        try {            
            $n = $this->mailer->batchSend($this->message, $failure);
            if ($failure) {
                $this->setFailure($failure);
            }
            return $n;
        } catch (Exception $e) {
            $failure = $e->getMessage();
            $this->setFailure($failure);
        }
        return false;
    }

    private function setFailure($failure) {
        array_push($this->failures, $failure);
        $this->failure = $failure;
    }

    public function getFailures() {
        return $this->failures;
    }

}