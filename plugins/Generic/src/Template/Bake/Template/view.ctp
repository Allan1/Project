<%
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
%>

<div class="row" >
    <div class="col-sm-12 view">
        <div class="box">
            <h3><?= h($<%= $singularVar %>-><%= $displayField %>) ?></h3>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ações <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><?= $this->Html->link(__('Editar <%= $singularHumanName %>'), ['action' => 'edit', <%= $pk %>]) ?> </li>
                    <li><?= $this->Form->postLink(__('Deletar <%= $singularHumanName %>'), ['action' => 'delete', <%= $pk %>], ['class'=>'text-danger','confirm' => __('Tem certeza que deseja deletar # {0}? Essa ação não pode ser desfeita.', <%= $pk %>)]) ?> </li>
                    <%
                    $done = [];
                    foreach ($associations as $type => $data) {
                        foreach ($data as $alias => $details) {
                            if ($details['controller'] !== $this->name && !in_array($details['controller'], $done)) {
                                %>
                                <li><?= $this->Html->link(__('Listar <%= $this->_pluralHumanName($alias) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'index']) ?> </li>
                                <li><?= $this->Html->link(__('Novo <%= Inflector::humanize(Inflector::singularize(Inflector::underscore($alias))) %>'), ['controller' => '<%= $details['controller'] %>', 'action' => 'add']) ?> </li>
                                <%
                                $done[] = $details['controller'];
                            }
                        }
                    }
                    %>
                </ul>
            </div>
            <table class="table table-striped" >
                <% if ($groupedFields['string']) : %>
                <!-- <div class="col-md-5 col-sm-5"> -->
                <% foreach ($groupedFields['string'] as $field) : %>
                <tr>
                    <% if (isset($associationFields[$field])) :
                        $details = $associationFields[$field];
                        %>
                        <th><?= __('<%= Inflector::humanize($details['property']) %>') ?></th>
                        <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
                        <% else : %>
                        <th><?= __($PT_LABELS['<%= $field %>']) ?></th>
                        <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
                        <% endif; %>
                    </tr>
                    <% endforeach; %>
                    <!-- </div> -->
                    <% endif; %>
                    <% if ($groupedFields['number']) : %>
                    <% foreach ($groupedFields['number'] as $field) : %>
                    <tr>
                        <th><?= __($PT_LABELS['<%= $field %>']) ?></th>
                        <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
                    </tr>
                    <% endforeach; %>
                    <% endif; %>
                    <% if ($groupedFields['date']) : %>
                    <% foreach ($groupedFields['date'] as $field) : %>
                    <tr>
                        <th><%= "<%= __('" . Inflector::humanize($field) . "') %>" %></th>
                        <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
                    </tr>
                    <% endforeach; %>
                    <% endif; %>
                    <% if ($groupedFields['boolean']) : %>
                    <% foreach ($groupedFields['boolean'] as $field) : %>
                    <tr>
                        <th><?= __($PT_LABELS['<%= $field %>']) ?></th>
                        <td><?= $<%= $singularVar %>-><%= $field %> ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <% endforeach; %>
                    <% endif; %>
                    <% if ($groupedFields['text']) : %>
                    <% foreach ($groupedFields['text'] as $field) : %>    
                    <tr>
                        <th><?= __($PT_LABELS['<%= $field %>']) ?></th>
                        <td><?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)) ?></td>
                    </tr>
                    <% endforeach; %>
                    <% endif; %>
                </table>
            </div>
        </div>
    </div>

    <!-- <div class="<%= $pluralVar %> view col-md-12 col-sm-12"> -->
    
    <%
    $relations = $associations['HasMany'] + $associations['BelongsToMany'];
    foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize(Inflector::underscore($details['controller']));
    %>
    <div class="related row">
        <div class="col-sm-12">
            <div class="box">
                <h4 class="subheader"><?= __('<%= $otherPluralHumanName %> relacionados') ?></h4>
                <?php if (!empty($<%= $singularVar %>-><%= $details['property'] %>)): ?>
                    <table class="table table-striped">
                        <tr>
                            <% foreach ($details['fields'] as $field): %>
                            <th><?= __($PT_LABELS['<%= $field %>']) ?></th>
                            <% endforeach; %>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($<%= $singularVar %>-><%= $details['property'] %> as $<%= $otherSingularVar %>): ?>
                            <tr>
                                <%- foreach ($details['fields'] as $field): %>
                                <td><?= h($<%= $otherSingularVar %>-><%= $field %>) ?></td>
                                <%- endforeach; %>

                                <%- $otherPk = "\${$otherSingularVar}->{$details['primaryKey'][0]}"; %>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => '<%= $details['controller'] %>', 'action' => 'view', <%= $otherPk %>]) %>
                                    <?= $this->Html->link(__('Editar'), ['controller' => '<%= $details['controller'] %>', 'action' => 'edit', <%= $otherPk %>]) %>
                                    <?= $this->Form->postLink(__('Deletar'), ['controller' => '<%= $details['controller'] %>', 'action' => 'delete', <%= $otherPk %>], ['confirm' => __('Tem certeza que deseja deletar # {0}? Essa ação não pode ser desfeita.', <%= $otherPk %>)]) %>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <% endforeach; %>
