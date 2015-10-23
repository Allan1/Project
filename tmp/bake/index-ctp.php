<?php
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return !in_array($schema->columnType($field), ['binary', 'text']);
    })
    ->take(7);
?>
<div class="<?= $pluralVar ?> index table-responsive box">
    <h2 class="sub-header"><?= $singularHumanName ?></h2>
    <CakePHPBakeOpenTag= $this->Html->link('Adicionar', ['action'=>'add'],['class'=>'btn btn-primary']);CakePHPBakeCloseTag>
    <table class="table table-striped">
    <thead>
        <tr>
    <?php foreach ($fields as $field): ?>
        <th><CakePHPBakeOpenTag= $this->Paginator->sort('<?= $field ?>',$PT_LABELS['<?= $field ?>']) CakePHPBakeCloseTag></th>
    <?php endforeach; ?>
        <th class="actions"><CakePHPBakeOpenTag= __('Ações') CakePHPBakeCloseTag></th>
        </tr>
    </thead>
    <tbody>
    <CakePHPBakeOpenTagphp foreach ($<?= $pluralVar ?> as $<?= $singularVar ?>): CakePHPBakeCloseTag>
        <tr>
<?php        foreach ($fields as $field) {
            $isKey = false;
            if (!empty($associations['BelongsTo'])) {
                foreach ($associations['BelongsTo'] as $alias => $details) {
                    if ($field === $details['foreignKey']) {
                        $isKey = true;
?>
            <td>
                <CakePHPBakeOpenTag= $<?= $singularVar ?>->has('<?= $details['property'] ?>') ? $this->Html->link($<?= $singularVar ?>-><?= $details['property'] ?>-><?= $details['displayField'] ?>, ['controller' => '<?= $details['controller'] ?>', 'action' => 'view', $<?= $singularVar ?>-><?= $details['property'] ?>-><?= $details['primaryKey'][0] ?>]) : '' CakePHPBakeCloseTag>
            </td>
<?php
                        break;
                    }
                }
            }
            if ($isKey !== true) {
                if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
?>
            <td><CakePHPBakeOpenTag= h($<?= $singularVar ?>-><?= $field ?>) CakePHPBakeCloseTag></td>
<?php
                } else {
?>
            <td><CakePHPBakeOpenTag= $this->Number->format($<?= $singularVar ?>-><?= $field ?>) CakePHPBakeCloseTag></td>
<?php
                }
            }
        }

        $pk = '$' . $singularVar . '->' . $primaryKey[0];
?>
            <td class="actions">
                <CakePHPBakeOpenTag= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['action' => 'view', <?= $pk ?>],['class'=>' btn btn-default','escape'=>false,'title'=>'Ver']) CakePHPBakeCloseTag>
                <CakePHPBakeOpenTag= $this->Html->link(__('<i class="fa fa-pencil"></i>'), ['action' => 'edit', <?= $pk ?>],['class'=>' btn btn-default','escape'=>false,'title'=>'Editar']) CakePHPBakeCloseTag>
                <CakePHPBakeOpenTag= $this->Form->postLink(__('<i class="fa fa-remove"></i>'), ['action' => 'delete', <?= $pk ?>], ['confirm' => __('Tem certeza que deseja apagar # {0}?', <?= $pk ?>),'class'=>' btn btn-danger btn-outline','escape'=>false,'title'=>'Apagar']) CakePHPBakeCloseTag>
            </td>
        </tr>

    <CakePHPBakeOpenTagphp endforeach; CakePHPBakeCloseTag>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <CakePHPBakeOpenTag= $this->Paginator->prev('< ' . __('anterior')) CakePHPBakeCloseTag>
            <CakePHPBakeOpenTag= $this->Paginator->numbers() CakePHPBakeCloseTag>
            <CakePHPBakeOpenTag= $this->Paginator->next(__('próxima') . ' >') CakePHPBakeCloseTag>
        </ul>
        <p><CakePHPBakeOpenTag= $this->Paginator->counter() CakePHPBakeCloseTag></p>
    </div>
</div>
