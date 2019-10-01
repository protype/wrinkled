<?php

  use Laravel\Lumen\Testing\DatabaseMigrations;
  use Laravel\Lumen\Testing\DatabaseTransactions;


  class UrlListAPITest extends TestCase {


    /**
     *
     *
     *
     */
    public function testMetaInformationIsCorrect () {

      $this->get ("/api/url");
      $resp = json_decode ($this->response->getContent (), true);

      $count = \Model::Factory ('Model\Url')
        ->count ('id');

      $this->assertEquals (
        $resp['meta']['totalItems'],
        $count);
    }


    /**
     *
     *
     *
     */
    public function testQueryLimitDoesWork () {

      // Limit in normal
      $limit = random_int (5, 10);
      $this->get ("/api/url?limit={$limit}");
      $resp = json_decode ($this->response->getContent (), true);
      $this->assertCount ($limit, $resp['data']);

      // Limit less equal to 0
      $this->get ("/api/url?limit=0");
      $resp = json_decode ($this->response->getContent (), true);
      $this->assertCount (1, $resp['data']);

      // Limit less than 0
      $this->get ("/api/url?limit=-2");
      $resp = json_decode ($this->response->getContent (), true);
      $this->assertCount (1, $resp['data']);

      // Limit large than 100
      $total = \Model::Factory ('Model\Url')
        ->count ('id');

      $this->get ("/api/url?limit=500");
      $resp = json_decode ($this->response->getContent (), true);

      $this->assertCount (
        Min (100, $total),
        $resp['data']);
    }


    /**
     *
     *
     *
     */
    public function testQueryOffsetDoesWork () {

      // Offset in normal
      $this->get ("/api/url");
      $respAll = json_decode ($this->response->getContent (), true);

      $offset = random_int (5, 10);
      $this->get ("/api/url?offset={$offset}");
      $respOffset = json_decode ($this->response->getContent (), true);

      $this->assertEquals (
        $respAll['data'][$offset]['id'],
        $respOffset['data'][0]['id']);

      // Offset less than 0
      $this->get ("/api/url?offset=-3");
      $respOffset = json_decode ($this->response->getContent (), true);

      $this->assertEquals (
        $respOffset['data'][0]['id'],
        $respAll['data'][0]['id']);

      // Offset more than total
      $totalItems = $respAll['meta']['totalItems'];
      $this->get ("/api/url?offset={$totalItems}");
      $respOffset = json_decode ($this->response->getContent (), true);

      $this->assertCount (0, $respOffset['data']);
    }
  }
