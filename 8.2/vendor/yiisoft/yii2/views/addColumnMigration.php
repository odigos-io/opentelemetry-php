<?php

namespace Odigos;

/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * The following variables are available in this view:
 *
 * @var \yii\web\View $this
 * @var string $className the new migration class name without namespace
 * @var string $namespace the new migration class namespace
 * @var string $table the name table
 * @var array $fields the fields
 * @var array $foreignKeys
 */
echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yii\db\Migration;

/**
 * Handles adding columns to table `<?php 
echo $table;
?>`.
<?php 
echo $this->render('_foreignTables', ['foreignKeys' => $foreignKeys]);
?>
 */
class <?php 
echo $className;
?> extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
<?php 
echo $this->render('_addColumns', ['table' => $table, 'fields' => $fields, 'foreignKeys' => $foreignKeys]);
?>
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
<?php 
echo $this->render('_dropColumns', ['table' => $table, 'fields' => $fields, 'foreignKeys' => $foreignKeys]);
?>
    }
}
<?php 
