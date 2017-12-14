<?php

namespace Album\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
use Album\Model\AlbumTable;
 class AlbumController extends AbstractActionController
 {
     
     protected $albumTable;
     
      // module/Album/src/Album/Controller/AlbumController.php:
     
     /**
      * 
      * @return AlbumTable
      */
     public function getAlbumTable()
     {
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Album\Model\AlbumTable');
         }
         return $this->albumTable;
     }
     
     public function indexAction()
     {
         $fetchAll = $this->getAlbumTable()->fetchAll();
         return new ViewModel(array(
             'albums' => $fetchAll
         ));
         
     }

     public function addAction()
     {
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }
 }
