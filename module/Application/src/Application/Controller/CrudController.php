<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Crud;
use Zend\View\Model\JsonModel;



class CrudController extends AbstractActionController {
    protected $crudTable;

    public function indexAction() {
        return new ViewModel(array(
            'crud' => $this->getCrudTable()->fetchAll(),
        ));
    }

    public function insertAjaxAction(){
        /*Comprobamos si la petición es por AJAX
        y si no lo es nos redirige a otra pagina*/
        if($this->request->isXmlHttpRequest()) {
            $response = $this->getResponse();
            $data = $this->request->getPost();
            // $response->setContent(\Zend\Json\Json::encode('weg'));
            if (!$this->crudTable) {
                $CrudModel = new Crud();
                $CrudModel->exchangeArray($data);
                $ModelAdapter = $this->getCrudTable()->saveCrud($CrudModel);
            }
           return $response->setContent(\Zend\Json\Json::encode($ModelAdapter));


        }
    }

    public function deleteAjaxAction() {
        if($this->request->isXmlHttpRequest()) {
            $response = $this->getResponse();
            $data = $this->request->getPost();
            // $response->setContent(\Zend\Json\Json::encode('weg'));
            if (!$this->crudTable) {
                $CrudModel = new Crud();
                $CrudModel->exchangeArray($data);
                $ModelAdapter = $this->getCrudTable()->deleteCrud($CrudModel);
            }
            return $response->setContent(\Zend\Json\Json::encode($ModelAdapter));


        }

    }

    public function getCrudTable() {

        if (!$this->crudTable) {

            $sm = $this->getServiceLocator();

            $this->crudTable = $sm->get('Application\Model\CrudTable');
        }

        return $this->crudTable;
    }


}


