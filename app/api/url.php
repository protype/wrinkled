<?php


  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;


  /**
   *
   * List urls
   *
   */
  $router->get ('/@/api/url', ['as' => 'api/url/list', function (Request $request) use ($app) {

    $count = \Model::Factory ('Model\Url')
      ->count ('id');

    $limit = $request->query->get ('limit', 20);
    $offset = $request->query->get ('offset', 0);

    $limit = $limit < 1 ? 1 : ($limit > 100 ? 100 : $limit);
    $offset = $offset < 0 ? 0 : ($offset > $count ? $count : $offset);

    $urls = \Model::Factory ('Model\Url')
      ->order_by_desc ('id')
      ->limit ($limit)
      ->offset ($offset)
      ->find_array ();

    $resp = [
      'meta' => [
        'totalItems' => $count
      ],
      'data' => $urls,
    ];

    return response ()->json ($resp, 200, [], JSON_UNESCAPED_UNICODE);

  }]);


  /**
   *
   * Create url
   *
   */
  $router->post ('/api/url', ['as' => 'api/url/add', function (Request $request) use ($app) {

    $data = $request->json ()->all ();

    /*
    $count = \Model::Factory ('Model\Url')
      ->count ('id');

    $limit = $app->request->query->get ('limit', 20);
    $offset = $app->request->query->get ('offset', 0);

    $limit = $limit < 1 ? 1 : ($limit > 100 ? 100 : $limit);
    $offset = $offset < 0 ? 0 : ($offset > $count ? $count : $offset);

    $urls = \Model::Factory ('Model\Url')
      ->order_by_desc ('id')
      ->limit ($limit)
      ->offset ($offset)
      ->find_array ();

    $resp = [
      'meta' => [
        'totalItems' => $count
      ],
      'data' => $urls,
    ];
    */

    return response ()->json ($data, 200, [], JSON_UNESCAPED_UNICODE);

  }]);
