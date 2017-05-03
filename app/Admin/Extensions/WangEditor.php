<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    protected $view = 'admin.wang-editor';

    protected static $css = [
        '/packages/wangEditor-2.1.23/dist/css/wangEditor.min.css',
    ];

    protected static $js = [
        '/packages/wangEditor-2.1.23/dist/js/wangEditor.min.js',
    ];

    public function render()
    {
        $token = csrf_token();

        $this->script = <<<EOT

var editor = new wangEditor('{$this->id}');

editor.config.uploadImgFileName = 'image';
editor.config.uploadImgUrl = '/admin/api/images';
editor.config.uploadParams = {
    _token: '$token'
};
editor.create();

EOT;
        return parent::render();
    }
}