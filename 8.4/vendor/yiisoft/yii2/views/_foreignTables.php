<?php

namespace Odigos;

/**
 * Creates a call for the method `yii\db\Migration::createTable()`.
 *
 * @var array $foreignKeys the foreign keys
 */
if (!empty($foreignKeys)) {
    ?>
 * Has foreign keys to the tables:
 *
<?php 
    foreach ($foreignKeys as $fkData) {
        ?>
 * - `<?php 
        echo $fkData['relatedTable'];
        ?>`
<?php 
    }
}
