<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateUrlTable extends AbstractMigration {

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

    // Url

    $this->table ('url', ['id' => FALSE, 'primary_key' => 'id', 'comment' => 'Url'])
      ->addColumn ('id', 'integer', ['limit' => MysqlAdapter::INT_BIG, 'signed' => FALSE, 'identity' => TRUE])

      // Foreign key
      ->addColumn ('domain_id', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'signed' => FALSE])

      // Basic fields
      ->addColumn ('url_code', 'char', ['limit' => 32])
      ->addColumn ('short_url', 'char', ['limit' => 255])
      ->addColumn ('original_url', 'text')
      ->addColumn ('url_unique_hash', 'char', ['limit' => 32])
      ->addColumn ('enable_custom', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => FALSE, 'default' => 0])
      ->addColumn ('custom_title', 'char', ['limit' => 255, 'default' => ''])
      ->addColumn ('custom_description', 'text')
      ->addColumn ('custom_image', 'char', ['limit' => 255, 'default' => ''])
      ->addColumn ('state', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => FALSE, 'default' => 1])

      // Timestamp
      ->addColumn ('createdate', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
      ->addColumn ('updatedate', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])

      // Keys
      ->addIndex (['domain_id', 'url_code'], ['unique' => true])
      ->addIndex (['short_url'], ['unique' => true])
      ->addIndex (['short_url', 'state'])
      ->addIndex (['url_unique_hash'])
      ->create ();

  }
}
