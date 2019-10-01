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

    // Count url
    $total = \Model::Factory ('Model\Url')
      ->count ('id');

    // Prepare limit and offset
    $limit = $request->query->get ('limit', 20);
    $offset = $request->query->get ('offset', 0);

    $limit = $limit < 1 ? 1 : ($limit > 100 ? 100 : $limit);
    $offset = $offset < 0 ? 0 : ($offset > $total ? $total : $offset);

    // Retrieve urls
    $urls = Model::Factory ('Model\Url')
      ->order_by_desc ('id')
      ->limit ($limit)
      ->offset ($offset)
      ->find_array ();

    // Combine response data
    $resp = [
      'meta' => [
        'totalItems' => $total
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

    // Try to validate input data
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

    // Make sure `code` is unique
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

    // Create url data
    $url = Model::Factory ('Model\Url')->create ();
    $url->code = $code;
    $url->url = $data['url'];
    $url->hash = md5 ($data['url']);
    $url->title = array_get ($data, 'title', NULL);
    $url->description = array_get ($data, 'description', NULL);
    $url->cover = NULL;
    $url->save ();

    if ($url->code == '') {
      $url->code = Shorty::encode ($url->id);
      $url->save ();
    }

    $data = $url->as_array ();

    // Remove protected field
    unset ($data['id']);
    unset ($data['hash']);

    return response ()->json (['data' => $data], 200, [], JSON_UNESCAPED_UNICODE);

  }]);
