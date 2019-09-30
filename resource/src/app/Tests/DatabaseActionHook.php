<?php

  namespace App\Tests;

  use PHPUnit\Runner\BeforeFirstTestHook;
  use PHPUnit\Runner\AfterLastTestHook;
  use Phinx\Console\PhinxApplication;
  use Symfony\Component\Console\Input\StringInput;
  use Symfony\Component\Console\Output\StreamOutput;
  use Symfony\Component\Console\Output\NullOutput;


  /**
   *
   * Database action hook
   *
   */
  final class DatabaseActionHook implements BeforeFirstTestHook, AfterLastTestHook {


    /**
     *
     * Database PDO object
     *
     */
    protected $pdo;

    protected $stdout;


    /**
     *
     * Database action before test start
     *
     */
    public function executeBeforeFirstTest (): void {

      $stdout = new StreamOutput (fopen('php://stdout', 'w'));

      try {

        // Prepare database
        $adapter = $_ENV['DB_ADAPTER'];

        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $port = $_ENV['DB_PORT'];

        $database = $_ENV['DB_NAME'];
        $charset = $_ENV['DB_CHARSET'];
        $collation = $_ENV['DB_COLLATION'];

        $conn = "$adapter:host=$host;port=$port";

        $pdo = new \PDO ($conn, $user, $pass);
        $res = $pdo->exec ("CREATE DATABASE `$database` CHARACTER SET `$charset` COLLATE `$collation`;
          CREATE USER '$user'@'$host' IDENTIFIED BY '$pass';
          GRANT ALL ON `$database`.* TO '$user'@'$host';
          FLUSH PRIVILEGES;");

        if (! $res) {
          $error = $pdo->errorInfo ();
          $stdout->writeln ("<error>{$error[2]}</error>");
          exit;
        }

        $this->pdo = $pdo;
        $stdout->writeln ("<info>Testing database created successfully</info>");

      } catch (PDOException $e) {
        $stdout->writeln ("<error>Failed to prepare testing database: ". $e->getMessage () . '</error>');
        exit;
      }

      try {
        $input = new StringInput ('status -c ' . _ROOT . '/config/phinx.php');
        $mute = new NullOutput ();

        $phinx = new PhinxApplication ();
        $phinx->setAutoExit (false);
        $phinx->run ($input, $mute);

        $stdout->writeln ("<info>Database migration finished");

      } catch (PDOException $e) {
        $stdout->writeln ("<error>Failed to migrate database: ". $e->getMessage () . '</error>');
        exit;
      }

      $stdout->writeln ("");
      $this->stdout = $stdout;
    }


    /**
     *
     * Database action before test end
     *
     */
    public function executeAfterLastTest (): void {

      $pdo = $this->pdo;
      $stdout = $this->stdout;
      $database = $_ENV['DB_NAME'];

      $stdout->writeln ("");

      try {

        $res = $pdo->exec ("DROP DATABASE `$database`;");

        if (! $res) {
          $error = $pdo->errorInfo ();
          $stdout->writeln ("<error>{$error[2]}</error>");
          exit;
        }

        $this->pdo = $pdo;
        $stdout->writeln ("<info>Testing database droped successfully</info>");

      } catch (PDOException $e) {
        $stdout->writeln ("<error>Failed to drop testing database: ". $e->getMessage () . '</error>');
        exit;
      }
    }
  }
