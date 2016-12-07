<?php

use Mindy\Form\Fields\Field;
use Mindy\Utils\RenderTrait;

class FilesField extends Field
{
    use RenderTrait;
    public $relatedFileField = 'file';
    public $uploadUrl;
    public $template = "files/fields/files.twig";

    public function getUploadUrl(){
        if (!$this->uploadUrl)
            $this->uploadUrl = Mindy::app()->createUrl('files.files_upload');
        return $this->uploadUrl;
    }

    public function getData($encoded = true){
        $model = $this->form->getInstance();
        $data = [
            'uploadUrl' => $this->getUploadUrl(),
            'listId' => $this->getListId(),
            'flowData' => [
                'pk' => $model->pk,
                'name' => $this->getName(),
                'class' => $model::className(),
                'fileField' => $this->relatedFileField
            ]
        ];
        return ($encoded) ? CJavaScript::encode(($data)) : $data;
    }

    public function getQuerySet(){
        return $this->getValue()->getQuerySet();
    }

    public function render()
    {
        $items = $this->getQuerySet()->all();

        echo $this->renderTemplate($this->template, [
            'items' => $items,
            'data' => $this->getData(true),
            'id' => $this->getId(),
            'filesId' => $this->getListId(),
            'fileField' => $this->relatedFileField
        ]);
    }

    public function getListId(){
        return $this->getId() . '_files';
    }
}