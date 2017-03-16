<?php

namespace Application\Model;
use Zend\Db\TableGateway\TableGateway;

class CrudTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }


    public function getInfo(){
        return 'wegewg';
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function saveCrud(Crud $crud)
    {
       $data = array(
            'artist' => $crud->artist,
            'title'  => $crud->title,
        );

       if($data['artist'] == null && $data['title'] == null){
              $response = array('code'=>'500', 'message' => 'Ha enviado valores nulos');
       }
        $id = (int) $crud->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $response = array('code'=>'200', 'message' => 'Ha sido insertado con Exito');
        } else {
            if ($this->getCrud($id)) {
                $this->tableGateway->update($data, array('id' => $id));
                $response = array('code'=>'200', 'message' => 'Ha sido actualizado con Exito');
            } else {
                throw new \Exception('Album id does not exist');
            }
        }

             return  $response;

    }


    public function deleteCrud(Crud $crud)
    {
        $data = array(
            'id' => $crud->id,
        );
        if($data['artist'] == null && $data['title'] == null){
            $response = array('code'=>'500', 'message' => 'Ha enviado valores nulos');
        }
        $id = (int) $crud->id;
        if ($id >= 1) {
            if ($this->getCrud($id)) {
                $this->tableGateway->delete($data, array('id' => $id));
                $response = array('code'=>'200', 'message' => 'Ha sido actualizado con Exito');
            } else {
                throw new \Exception('Album id does not exist');
            }
        }

        return  $response;

    }


    public function getCrud($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

}

