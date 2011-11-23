<?php


class XML_Mail extends XML_Texts {

    protected $folder = 'mails/';

    public function getMail() {
        $texts = $this->getAssoc();
        $title = $this->root->getElementsByTagName('title')->item(0)->textContent;
        return array('text' => $texts, 'title' => $title);
    }

}