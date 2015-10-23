<?php
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    });
?>

<div class="row <?= $pluralVar ?> form ">
    <div class="col-md-12">
    <CakePHPBakeOpenTag= $this->Form->create($<?= $singularVar ?>,['class'=>'box']) CakePHPBakeCloseTag>
    <fieldset>
        <legend><CakePHPBakeOpenTag= __('<?= Inflector::humanize($action) ?> <?= $singularHumanName ?>') CakePHPBakeCloseTag></legend>
        <CakePHPBakeOpenTagphp
<?php
        foreach ($fields as $field) {

            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
?>
            echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>, 'empty' => true,'class'=>'form-control','label'=> $PT_LABELS['<?= $field ?>']]);
<?php
                } else {
?>
            echo $this->Form->input('<?= $field ?>', ['options' => $<?= $keyFields[$field] ?>,'class'=>'form-control','label'=> $PT_LABELS['<?= $field ?>']]);
<?php
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
?>
            echo $this->Form->input('<?= $field ?>', ['empty' => true, 'default' => '','class'=>'form-control','label'=> $PT_LABELS['<?= $field ?>']]);
<?php
                } else {
?>
            echo $this->Form->input('<?= $field ?>',['class'=>'form-control','label'=> $PT_LABELS['<?= $field ?>']]);
<?php
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
?>
            echo $this->Form->input('<?= $assocData['property'] ?>._ids', ['options' => $<?= $assocData['variable'] ?>,'class'=>'form-control']);
<?php
            }
        }
?>
        CakePHPBakeCloseTag>
    </fieldset>
    <CakePHPBakeOpenTag= $this->Form->button(__('Enviar')) CakePHPBakeCloseTag>
    <CakePHPBakeOpenTag= $this->Form->end() CakePHPBakeCloseTag>
    </div>
</div>
