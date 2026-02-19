<?php

namespace Odigos;

/**
 * @var \yii\web\View $this
 * @var array $fields
 * @var string $table
 * @var array $foreignKeys
 */
foreach ($fields as $field) {
    ?>
        $this->addColumn('<?php 
    echo $table;
    ?>', '<?php 
    echo $field['property'];
    ?>', $this-><?php 
    echo $field['decorators'];
    ?>);
<?php 
}
echo $this->render('_addForeignKeys', ['table' => $table, 'foreignKeys' => $foreignKeys]);
