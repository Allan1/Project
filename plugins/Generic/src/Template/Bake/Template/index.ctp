<%
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function($field) use ($schema) {
        return !in_array($schema->columnType($field), ['binary', 'text']);
    })
    ->take(7);
%>
<div class="<%= $pluralVar %> index table-responsive box">
    <h2 class="sub-header"><%= $singularHumanName %></h2>
    <?= $this->Html->link('Adicionar', ['action'=>'add'],['class'=>'btn btn-primary']);?>
    <table class="table table-striped">
    <thead>
        <tr>
    <% foreach ($fields as $field): %>
        <th><?= $this->Paginator->sort('<%= $field %>',$PT_LABELS['<%= $field %>']) ?></th>
    <% endforeach; %>
        <th class="actions"><?= __('Ações') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($<%= $pluralVar %> as $<%= $singularVar %>): ?>
        <tr>
<%        foreach ($fields as $field) {
            $isKey = false;
            if (!empty($associations['BelongsTo'])) {
                foreach ($associations['BelongsTo'] as $alias => $details) {
                    if ($field === $details['foreignKey']) {
                        $isKey = true;
%>
            <td>
                <?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?>
            </td>
<%
                        break;
                    }
                }
            }
            if ($isKey !== true) {
                if (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float'])) {
%>
            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                } else {
%>
            <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
<%
                }
            }
        }

        $pk = '$' . $singularVar . '->' . $primaryKey[0];
%>
            <td class="actions">
                <?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['action' => 'view', <%= $pk %>],['class'=>' btn btn-default','escape'=>false,'title'=>'Ver']) ?>
                <?= $this->Html->link(__('<i class="fa fa-pencil"></i>'), ['action' => 'edit', <%= $pk %>],['class'=>' btn btn-default','escape'=>false,'title'=>'Editar']) ?>
                <?= $this->Form->postLink(__('<i class="fa fa-remove"></i>'), ['action' => 'delete', <%= $pk %>], ['confirm' => __('Tem certeza que deseja apagar # {0}?', <%= $pk %>),'class'=>' btn btn-danger btn-outline','escape'=>false,'title'=>'Apagar']) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próxima') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
