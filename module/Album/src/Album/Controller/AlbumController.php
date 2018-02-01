<?php

namespace Album\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
use Album\Model\AlbumTable;
use Album\Form\AlbumForm;
use Album\Model\Album;

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
          $form = new AlbumForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $album = new Album();
             $form->setInputFilter($album->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $album->exchangeArray($form->getData());
                 $this->getAlbumTable()->saveAlbum($album);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('album');
             }
         }
         return array('form' => $form);
     }


     public function editAction()
     {
         return array();
     }

     public function deleteAction()
     {
     }
 }
