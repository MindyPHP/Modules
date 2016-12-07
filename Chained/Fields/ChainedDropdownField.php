<?php
/**
 * Created by PhpStorm.
 * User: antonokulov
 * Date: 18/09/14
 * Time: 06:59
 */

namespace Modules\Chained\Fields;

use Exception;
use Mindy\Base\Mindy;
use Mindy\Form\Fields\DropDownField;
use Mindy\Form\ModelForm;
use Mindy\Helper\JavaScript;

class ChainedDropdownField extends DropDownField
{
    // Поле в этой же форме, от которого зависит данное поле
    public $chainsFrom = null;

    // Поле в связанной модели, по которому будет производиться фильтрация
    public $relatedBy = null;

    // Отключать поле, если значение поля chainsFrom, от которого зависит данное поле пустое (0, '' ...)
    public $lockField = false;

    // Сообщение при отключенном поле
    public $lockMessage = null;

    //order в querySet
    public $order;

    public $ownerClass;

    protected $modelClass;

    public function init()
    {

        if (!$this->chainsFrom) {
            throw new Exception("Property chains from must be defined");
        }
        if (!$this->relatedBy) {
            $this->relatedBy = $this->chainsFrom;
        }
        parent::init();
    }


    public function renderInput()
    {
        return parent::renderInput() . $this->getStatic();
    }

    public function getChainsId()
    {
        return $this->getHtmlPrefix() . $this->chainsFrom;
    }

    public function getStatic()
    {
        $url = Mindy::app()->urlManager->reverse('chained:feed');
        $id = $this->getHtmlId();
        $chainsId = $this->getChainsId();
        $options = [
            'relatedBy' => $this->relatedBy,
            'modelClass' => $this->modelClass
        ];
        $minimalValues = 0;
        $lock = $this->lockField;
        $lockMessage = is_null($this->lockMessage) ? $this->empty : $this->lockMessage;

        if ($this->empty) {
            $options['empty'] = $this->empty;
            $minimalValues = 1;
        }
        if ($this->order){
            $options['order'] = $this->order;
        }

        $opts = JavaScript::encode($options);
        $js = "
        <script type='text/javascript'>
            $(function(){
                var updateChained = function(){
                    var opts = {$opts};
                    var value = $('#{$chainsId}').val();
                    var select = $('#{$id}');
                    if (value == '0') {
                        value = 0;
                    }
                    if ({$lock} && !value) {
                        select.html('');
                        select.append($('<option/>').attr('value', 0).text('{$lockMessage}'));
                        select.attr('disabled', 'disabled');
                        select.change();
                    } else {
                        opts['value'] = value;
                        $.ajax({
                            'url': '{$url}',
                            'data': opts,
                            'type': 'get',
                            'cache': false,
                            'dataType': 'json',
                            'success': function(data){
                                if (select.length) {
                                    select.html('');
                                    select.removeAttr('disabled');
                                    $.each(data, function(index, item){
                                        var pk = item.pk,
                                            value = item.value;
                                            select.append($('<option/>').attr('value', pk).text(value));
                                    });
                                    select.change();
                                }
                            }
                        });
                    }
                };
                $(document).on('change', '#{$chainsId}', updateChained);
                if ($('#{$id}').find('option').length <= {$minimalValues}) {
                    updateChained();
                }
            });
        </script>
        ";
        return $js;
    }

    public function getInputHtml()
    {
        $data = [];
        $selected = [];
        $model = $this->ownerClass ? new $this->ownerClass() : null;
        $model = $model ? $model : $this->form->model;

        if($model && $model->hasField($this->name) && $model->hasField($this->chainsFrom)) {
            $field = $model->getField($this->name);
            $chainsField = $model->getField($this->chainsFrom);

            $modelClass = $field->modelClass;
            $chainsModelClass = $chainsField->modelClass;

            $relatedPk = $this->form->{$this->name}->getValue();
            $relatedPk = is_object($relatedPk) ? $relatedPk->id : $relatedPk;
            $related = null;
            if ($relatedPk) {
                $related = $modelClass::objects()->filter(['pk' => $relatedPk])->get();
            }

            $chainsPk = $this->form->{$this->chainsFrom}->getValue();
            $chainsPk = is_object($chainsPk) ? $chainsPk->id : $chainsPk;
            $chains = null;
            if ($chainsPk) {
                $chains = $chainsModelClass::objects()->filter(['pk' => $chainsPk])->get();
            }

            if (is_a($field, $model::$foreignField)) {
                $this->modelClass = $modelClass;

                if ($chains && $chains->pk) {
                    $qs = $modelClass::objects()->filter([$this->relatedBy => $chains->pk]);
                }else{
                    $qs = null;
                }

                if($related) {
                    $selected[] = $related->pk;
                }

                if ($this->empty) {
                    $data[''] = $this->empty;
                }

                if ($qs) {
                    foreach($qs->all() as $model) {
                        $data[$model->pk] = (string) $model;
                    }
                }

                return $this->valueToHtml($data, $selected);
            }else {
                throw new Exception("Field must be a ForeignField instance");
            }
        }else{
            throw new Exception("Form must be a ModelForm instance or ownerClass must not be empty");
        }
    }

}