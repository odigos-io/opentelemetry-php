<?php

namespace Odigos;

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;
/**
 * Initializes RBAC tables.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class m140506_102106_rbac_init extends \yii\db\Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }
    /**
     * @return bool
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }
    protected function isOracle()
    {
        return $this->db->driverName === 'oci' || $this->db->driverName === 'oci8';
    }
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($authManager->ruleTable, ['name' => $this->string(64)->notNull(), 'data' => $this->binary(), 'created_at' => $this->integer(), 'updated_at' => $this->integer(), 'PRIMARY KEY ([[name]])'], $tableOptions);
        $this->createTable($authManager->itemTable, ['name' => $this->string(64)->notNull(), 'type' => $this->smallInteger()->notNull(), 'description' => $this->text(), 'rule_name' => $this->string(64), 'data' => $this->binary(), 'created_at' => $this->integer(), 'updated_at' => $this->integer(), 'PRIMARY KEY ([[name]])', 'FOREIGN KEY ([[rule_name]]) REFERENCES ' . $authManager->ruleTable . ' ([[name]])' . $this->buildFkClause('ON DELETE SET NULL', 'ON UPDATE CASCADE')], $tableOptions);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');
        $this->createTable($authManager->itemChildTable, ['parent' => $this->string(64)->notNull(), 'child' => $this->string(64)->notNull(), 'PRIMARY KEY ([[parent]], [[child]])', 'FOREIGN KEY ([[parent]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'), 'FOREIGN KEY ([[child]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE')], $tableOptions);
        $this->createTable($authManager->assignmentTable, ['item_name' => $this->string(64)->notNull(), 'user_id' => $this->string(64)->notNull(), 'created_at' => $this->integer(), 'PRIMARY KEY ([[item_name]], [[user_id]])', 'FOREIGN KEY ([[item_name]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' . $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE')], $tableOptions);
        if ($this->isMSSQL()) {
            $this->execute("CREATE TRIGGER {$schema}.trigger_auth_item_child\n            ON {$schema}.{$authManager->itemTable}\n            INSTEAD OF DELETE, UPDATE\n            AS\n            DECLARE @old_name VARCHAR (64) = (SELECT name FROM deleted)\n            DECLARE @new_name VARCHAR (64) = (SELECT name FROM inserted)\n            BEGIN\n            IF COLUMNS_UPDATED() > 0\n                BEGIN\n                    IF @old_name <> @new_name\n                    BEGIN\n                        ALTER TABLE {$authManager->itemChildTable} NOCHECK CONSTRAINT FK__auth_item__child;\n                        UPDATE {$authManager->itemChildTable} SET child = @new_name WHERE child = @old_name;\n                    END\n                UPDATE {$authManager->itemTable}\n                SET name = (SELECT name FROM inserted),\n                type = (SELECT type FROM inserted),\n                description = (SELECT description FROM inserted),\n                rule_name = (SELECT rule_name FROM inserted),\n                data = (SELECT data FROM inserted),\n                created_at = (SELECT created_at FROM inserted),\n                updated_at = (SELECT updated_at FROM inserted)\n                WHERE name IN (SELECT name FROM deleted)\n                IF @old_name <> @new_name\n                    BEGIN\n                        ALTER TABLE {$authManager->itemChildTable} CHECK CONSTRAINT FK__auth_item__child;\n                    END\n                END\n                ELSE\n                    BEGIN\n                        DELETE FROM {$schema}.{$authManager->itemChildTable} WHERE parent IN (SELECT name FROM deleted) OR child IN (SELECT name FROM deleted);\n                        DELETE FROM {$schema}.{$authManager->itemTable} WHERE name IN (SELECT name FROM deleted);\n                    END\n            END;");
        }
    }
    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;
        if ($this->isMSSQL()) {
            $this->execute("DROP TRIGGER {$schema}.trigger_auth_item_child;");
        }
        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }
    protected function buildFkClause($delete = '', $update = '')
    {
        if ($this->isMSSQL()) {
            return '';
        }
        if ($this->isOracle()) {
            return ' ' . $delete;
        }
        return \implode(' ', ['', $delete, $update]);
    }
}
/**
 * Initializes RBAC tables.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
\class_alias('Odigos\m140506_102106_rbac_init', 'm140506_102106_rbac_init', \false);
