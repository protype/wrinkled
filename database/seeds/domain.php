<?php

use Phinx\Seed\AbstractSeed;
use Forgez\Helper\Sanitize;

class Domain extends AbstractSeed
{
  /**
   * Run Method.
   *
   * Write your database seeder using this method.
   *
   * More information on writing seeders is available here:
   * http://docs.phinx.org/en/latest/seeding.html
   */
  public function run () {

    $faker = Faker\Factory::create ('zh_TW');
    $count = random_int (30, 40);

    $datas = [
      [
        'scheme' => 'http',
        'host' => 'wks',
        'path' => '/protype/project/wrinkle/public',
      ]
    ];

    $this->table ('domain')
      ->insert ($datas)
      ->save ();
  }
}
