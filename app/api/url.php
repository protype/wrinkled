<?php


  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;
  use App\Helper\Shorty;


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

    $urls = Model::Factory ('Model\Url')
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
  $router->post ('/@/api/url', ['as' => 'api/url/add', function (Request $request) use ($app) {

    $data = $request->json ()->all ();
    $code = '';
    $error = [];

    try {
      $this->validate ($request,
        Model\Url::$_rules,
        Model\Url::$_messages);
    }

    catch (ValidationException $e) {
      $errors = current ($e->errors ());
      $error = [
        'status' => 400,
        'title' => $errors[0]
      ];
    }

    if (empty ($error) && isset ($data['code']) && $data['code'] != '') {

      $url = Model::Factory ('Model\Url')
        ->where ('code', $data['code'])
        ->find_one ();

      if ($url)
        $error = [
          'status' => 409,
          'title' => "The shorten code `{$data['code']}` has already existed."
        ];

      $code = $data['code'];
    }

    if (! empty ($error))
      return response ()->json (['errors' => [$error]], $error['status'], [], JSON_UNESCAPED_UNICODE);

    $url = Model::Factory ('Model\Url')->create ();
    $url->code = $code;
    $url->url = $data['url'];
    $url->title = array_get ($data, 'title', null);
    $url->description = array_get ($data, 'description', null);
    $url->save ();

    if ($url->code == '') {
      $url->code = Shorty::encode ($url->id);
      $url->save ();
    }

    $resp = [
      'data' => $url->as_array (),
    ];

    return response ()->json ($resp, 200, [], JSON_UNESCAPED_UNICODE);

  }]);
