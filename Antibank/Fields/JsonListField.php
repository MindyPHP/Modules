<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 19/09/14
 * Time: 14:52
 */

namespace Modules\Antibank\Fields;


use Mindy\Form\Fields\TextAreaField;

class JsonListField extends TextAreaField
{
    public $delimiter = '';
    public $appenderTemplate = '<span class="button" id="{id}">{text}</span>';
    public $appenderText = 'Append';

    public function renderSingleInput($value = '', $position = 0)
    {
        return strtr($this->template, [
            '{type}' => $this->type,
            '{id}' => $this->getId() . '_' . $position,
            '{name}' => $this->getName() . "[{$position}]",
            '{value}' => $value,
            '{html}' => $this->getHtmlAttributes()
        ]);
    }

    public function renderInput()
    {
        $values = $this->value;
        if (!is_array($values)) {
            $values = [$values];
        };
        $inputs = [];
        $position = 0;

        $append =  strtr($this->appenderTemplate, [
            '{id}' => $this->getIdAppend(),
            '{text}' => $this->appenderText
        ]);

        foreach($values as $value) {
            $inputs[] = $this->renderSingleInput($value, $position);
            $position++;
        }

        return implode($this->delimiter, $inputs) . $append . $this->getStatic();
    }

    public function getIdAppend()
    {
        return $this->getId() . '_append_button';
    }

    public function getStatic()
    {
        $idAppend = $this->getIdAppend();
        $id = $this->getId();

        $replaceText = '#number';
        $single = $this->renderSingleInput('', $replaceText);
        $single = str_replace("'", '"', $single);
        $js = "
        <script type='text/javascript'>
            $(function(){
                var replace = '{$replaceText}';
                var single = '{$single}';
                var re = new RegExp(replace, 'g');

                $('#{$idAppend}').on('click', function(e){
                    e.preventDefault();
                    var count = $('textarea[id^=\"{$id}\"]').length;
                    var rendered = single.replace(re, count.toString());
                    $(this).before(rendered);
                    return false;
                });
            });
        </script>
        ";
        return $js;

    }
} 