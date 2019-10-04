<?php

use Phinx\Seed\AbstractSeed;
use Forgez\Helper\Sanitize;

class Url extends AbstractSeed
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

    $datas = [];

    for ($i=0; $i<$count; $i++) {
      $datas[] = [
        'domain_id'          => 1,
        'url_code'           => $code = $faker->unique ()->regexify ('[a-zA-Z0-9]{2,6}'),
        'short_url'          => 'wks/protype/project/wrinkle/public/' . $code,
        'original_url'       => $url = $faker->url,
        'url_unique_hash'    => md5 ($url),
        'enable_custom'      => random_int (0, 1),
        'custom_title'       => $faker->realText (50),
        'custom_description' => $faker->realText (120),
        'custom_image'       => $faker->imageUrl,
        'state'              => $faker->randomElement ([0, 1]),
        'createdate'         => date ('Y-m-d H:i:s', $faker->unixTime),
        'updatedate'         => date ('Y-m-d H:i:s', $faker->unixTime),
      ];
    }

    $this->table ('url')
      ->insert ($datas)
      ->save ();
  }
}
