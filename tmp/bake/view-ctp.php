<?php
use Cake\Utility\Inflector;

$associations += ['BelongsTo' => [], 'HasOne' => [], 'HasMany' => [], 'BelongsToMany' => []];
$immediateAssociations = $associations['BelongsTo'] + $associations['HasOne'];
$associationFields = collection($fields)
->map(function($field) use ($immediateAssociations) {
    foreach ($immediateAssociations as $alias => $details) {
        if ($field === $details['foreignKey']) {
            return [$field => $details];
        }
    }
})
->filter()
->reduce(function($fields, $value) {
    return $fields + $value;
}, []);

$groupedFields = collection($fields)
->filter(function($field) use ($schema) {
    return $schema->columnType($field) !== 'binary';
})
->groupBy(function($field) use ($schema, $associationFields) {
    $type = $schema->columnType($field);
    if (isset($associationFields[$field])) {
        return 'string';
    }
    if (in_array($type, ['integer', 'float', 'decimal', 'biginteger'])) {
        return 'number';
    }
    if (in_array($type, ['date', 'time', 'datetime', 'timestamp'])) {
        return 'date';
    }
    return in_array($type, ['text', 'boolean']) ? $type : 'string';
})
->toArray();

$groupedFields += ['number' => [], 'string' => [], 'boolean' => [], 'date' => [], 'text' => []];
$pk = "\$$singularVar->{$primaryKey[0]}";
?>

<div class="row" >
    <div class="col-sm-12 view">
        <div class="box">
            <h3><CakePHPBakeOpenTag= h($<?= $singularVar ?>-><?= $displayField ?>) CakePHPBakeCloseTag></h3>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><CakePHPBakeOpenTag= $this->Html->link(__('Editar <?= $singularHumanName ?>'), ['action' => 'edit', <?= $pk ?>]) CakePHPBakeCloseTag> </li>
                    <li><CakePHPBakeOpenTag= $this->Form->postLink(__('Deletar <?= $singularHumanName ?>'), ['action' => 'delete', <?= $pk ?>], ['class'=>'text-danger','confirm' => __('Tem certeza que deseja deletar # {0}? Essa ação não pode ser desfeita.', <?= $pk ?>)]) CakePHPBakeCloseTag> </li>
                    <?php
                    $done = [];
                    foreach ($associations as $type => $data) {
                        foreach ($data as $alias => $details) {
                            if ($details['controller'] !== $this->name && !in_array($details['controller'], $done)) {
                                ?>
                                <li><CakePHPBakeOpenTag= $this->Html->link(__('Listar <?= $this->_pluralHumanName($alias) ?>'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'index']) CakePHPBakeCloseTag> </li>
                                <li><CakePHPBakeOpenTag= $this->Html->link(__('Novo <?= Inflector::humanize(Inflector::singularize(Inflector::underscore($alias))) ?>'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'add']) CakePHPBakeCloseTag> </li>
                                <?php
                                $done[] = $details['controller'];
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
            <table class="table table-striped" >
                <?php if ($groupedFields['string']) : ?>
                <!-- <div class="col-md-5 col-sm-5"> -->
                <?php foreach ($groupedFields['string'] as $field) : ?>
                <tr>
                    <?php if (isset($associationFields[$field])) :
                        $details = $associationFields[$field];
                        ?>
                        <th><CakePHPBakeOpenTag= __('<?= Inflector::humanize($details['property']) ?>') CakePHPBakeCloseTag></th>
                        <td><CakePHPBakeOpenTag= $<?= $singularVar ?>->has('<?= $details['property'] ?>') ? $this->Html->link($<?= $singularVar ?>-><?= $details['property'] ?>-><?= $details['displayField'] ?>, ['controller' => '<?= $details['controller'] ?>', 'action' => 'view', $<?= $singularVar ?>-><?= $details['property'] ?>-><?= $details['primaryKey'][0] ?>]) : '' CakePHPBakeCloseTag></td>
                        <?php else : ?>
                        <th><CakePHPBakeOpenTag= __($PT_LABELS['<?= $field ?>']) CakePHPBakeCloseTag></th>
                        <td><CakePHPBakeOpenTag= h($<?= $singularVar ?>-><?= $field ?>) CakePHPBakeCloseTag></td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                    <!-- </div> -->
                    <?php endif; ?>
                    <?php if ($groupedFields['number']) : ?>
                    <?php foreach ($groupedFields['number'] as $field) : ?>
                    <tr>
                        <th><CakePHPBakeOpenTag= __($PT_LABELS['<?= $field ?>']) CakePHPBakeCloseTag></th>
                        <td><CakePHPBakeOpenTag= $this->Number->format($<?= $singularVar ?>-><?= $field ?>) CakePHPBakeCloseTag></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($groupedFields['date']) : ?>
                    <?php foreach ($groupedFields['date'] as $field) : ?>
                    <tr>
                        <th><?= "<?= __('" . Inflector::humanize($field) . "') ?>" ?></th>
                        <td><CakePHPBakeOpenTag= h($<?= $singularVar ?>-><?= $field ?>) CakePHPBakeCloseTag></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($groupedFields['boolean']) : ?>
                    <?php foreach ($groupedFields['boolean'] as $field) : ?>
                    <tr>
                        <th><CakePHPBakeOpenTag= __($PT_LABELS['<?= $field ?>']) CakePHPBakeCloseTag></th>
                        <td><CakePHPBakeOpenTag= $<?= $singularVar ?>-><?= $field ?> ? __('Yes') : __('No'); CakePHPBakeCloseTag></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($groupedFields['text']) : ?>
                    <?php foreach ($groupedFields['text'] as $field) : ?>    
                    <tr>
                        <th><CakePHPBakeOpenTag= __($PT_LABELS['<?= $field ?>']) CakePHPBakeCloseTag></th>
                        <td><CakePHPBakeOpenTag= $this->Text->autoParagraph(h($<?= $singularVar ?>-><?= $field ?>)) CakePHPBakeCloseTag></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- <div class="<?= $pluralVar ?> view col-md-12 col-sm-12"> -->
    
    <?php
    $relations = $associations['HasMany'] + $associations['BelongsToMany'];
    foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize(Inflector::underscore($details['controller']));
    ?>
    <div class="related row">
        <div class="col-sm-12">
            <div class="box">
                <h4 class="subheader"><CakePHPBakeOpenTag= __('<?= $otherPluralHumanName ?> relacionados') CakePHPBakeCloseTag></h4>
                <CakePHPBakeOpenTagphp if (!empty($<?= $singularVar ?>-><?= $details['property'] ?>)): CakePHPBakeCloseTag>
                    <table class="table table-striped">
                        <tr>
                            <?php foreach ($details['fields'] as $field): ?>
                            <th><CakePHPBakeOpenTag= __($PT_LABELS['<?= $field ?>']) CakePHPBakeCloseTag></th>
                            <?php endforeach; ?>
                            <th class="actions"><CakePHPBakeOpenTag= __('Ações') CakePHPBakeCloseTag></th>
                        </tr>
                        <CakePHPBakeOpenTagphp foreach ($<?= $singularVar ?>-><?= $details['property'] ?> as $<?= $otherSingularVar ?>): CakePHPBakeCloseTag>
                            <tr>
<?php foreach ($details['fields'] as $field): ?>
                                <td><CakePHPBakeOpenTag= h($<?= $otherSingularVar ?>-><?= $field ?>) CakePHPBakeCloseTag></td>
<?php endforeach; ?>

<?php $otherPk = "\${$otherSingularVar}->{$details['primaryKey'][0]}"; ?>
                                <td class="actions">
                                    <CakePHPBakeOpenTag= $this->Html->link(__('Ver'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'view', <?= $otherPk ?>]) ?>

                                    <CakePHPBakeOpenTag= $this->Html->link(__('Editar'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'edit', <?= $otherPk ?>]) ?>

                                    <CakePHPBakeOpenTag= $this->Form->postLink(__('Deletar'), ['controller' => '<?= $details['controller'] ?>', 'action' => 'delete', <?= $otherPk ?>], ['confirm' => __('Tem certeza que deseja deletar # {0}? Essa ação não pode ser desfeita.', <?= $otherPk ?>)]) ?>

                                </td>
                            </tr>

                        <CakePHPBakeOpenTagphp endforeach; CakePHPBakeCloseTag>
                    </table>
                <CakePHPBakeOpenTagphp endif; CakePHPBakeCloseTag>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
