<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Model;

// Add these import statements
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Description of Album
 *
 * @author simonebracaloni
 */
class Album implements InputFilterAwareInterface {

    public $id;
    public $artist;
    public $title;
    protected $inputFilter;

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
    }

    public function getInputFilter(): InputFilterInterface {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'artist',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter): InputFilterAwareInterface {
        throw new \Exception("Not used");
    }

    public function getArrayCopy() {
        return array(
            'id' => $this->id,
            'artist' => $this->artist,
            'title' => $this->title,
        );
    }

}
