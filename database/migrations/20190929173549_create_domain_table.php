<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateDomainTable extends AbstractMigration {

  /**
   * Change Method.
   *
   * Write your reversible migrations using this method.
   *
   * More information on writing migrations is available here:
   * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
   *
   * The following commands can be used in this method and Phinx will
   * automatically reverse them when rolling back:
   *
   *    createTable
   *    renameTable
   *    addColumn
   *    addCustomColumn
   *    renameColumn
   *    addIndex
   *    addForeignKey
   *
   * Any other destructive changes will result in an error when trying to
   * rollback the migration.
   *
   * Remember to call "create()" or "update()" and NOT "save()" when working
   * with the Table class.
   */
  public function change () {

    // Domain

    $this->table ('domain', ['id' => FALSE, 'primary_key' => 'id', 'comment' => 'Url'])
      ->addColumn ('id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => FALSE, 'identity' => TRUE])

      // Basic fields
      ->addColumn ('scheme', 'char', ['limit' => 16])
      ->addColumn ('host', 'char', ['limit' => 32])
      ->addColumn ('path', 'char', ['limit' => 32, 'default' => ''])
      ->addColumn ('shorty_characters', 'char', ['limit' => 255, 'null' => TRUE])
      ->addColumn ('shorty_offset', 'integer', ['limit' => MysqlAdapter::INT_REGULAR, 'signed' => FALSE, 'default' => 0])
      ->addColumn ('state', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => FALSE, 'default' => 1])

      // Timestamp
      ->addColumn ('createdate', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
      ->addColumn ('updatedate', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])

      // Keys
      ->addIndex (['host', 'path'], ['unique' => true])
      ->addIndex (['state'])
      ->create ();

  }
}
