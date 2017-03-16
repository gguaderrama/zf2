<?php

namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;

class Crud {

    protected $tableGateway;

    public $id;
    public $artist;
    public $title;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
    }





}
