<?php

class Plussia_Mail {

    private $adres = '';
    private $theme = '';
    private $text = '';
    private $from = 'plussia@yandex.ru';
    public $lastResult;

    public static function puckmail($view, $texts, $email, $viewparams = array()) {
        $texts = XML_Mail::factory($texts)->getMail();
        $mail = new Plussia_Mail();
        $view = View::factory('mails/'.$view);
        $view->text = $texts['text'];
        foreach ($viewparams as $param => $value) {
            $view->$param = $value;
        }
        $mail->setAdress($email)->setTheme($texts['title'])->addText($view->render())->send();
        return $mail->lastResult;
    }

    public function send() {
        $headers = '';
        $headers = "From: $this->from\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "Mime-Version: 1.0\r\n";

        if ($this->adres && $this->theme && $this->text) {
            $this->lastResult = mail($this->adres, $this->theme, $this->text, $headers);
        }
        return $this;
    }

    public function setAdress($adress) {
        if ($adress) {
            $this->adres = $adress;
        }
        return $this;
    }

    public function setTheme($theme) {
        if ($theme) {
            $this->theme = $theme;
        }
        return $this;
    }

    public function addParagraph($text) {
        if ($this->text) {
            $this->text .= '<br>';
        }
        $this->text .= $text;
        return $this;
    }

    public function addText($text) {
        $this->text .= $text;
        return $this;
    }

    public function clearText() {
        $this->text = '';
        return $this;
    }

}