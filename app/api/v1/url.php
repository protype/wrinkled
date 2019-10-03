<?php


  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;
  use App\Helper\Shorty;


  /**
   *
   * List urls
   *
   */
  $router->get ('/api/v1/url', ['as' => 'api/v1/url/list', function (Request $request) use ($app) {

    // Count url
    $total = \Model::Factory ('Model\Url')
      ->count ('id');

    // Prepare limit and offset
    $cursor = strtolower ($request->query->get ('cursor', 'id'));
    $after = $request->query->get ('after', null);
    $before = $request->query->get ('before', null);
    $size = Min ($request->query->get ('size', 10), 100);
    $order = strtolower ($request->query->get ('order', 'desc'));

    if ($cursor != 'id')
      return response ()->json (['status' => 400, 'message' => "Cursor `$cursor` is not supported.", 'errors' => []], 400, [], JSON_UNESCAPED_UNICODE);

    //
    // Retrieve urls
    //
    $urls = Model::Factory ('Model\Url');

    if (! is_null ($after))
      $urls = $urls->where_gt ($cursor, $after);

    else if (! is_null ($before))
      $urls = $urls->where_lt ($cursor, $before);

    if ($order == 'asc')
      $urls = $urls->order_by_asc ($cursor);

    else
      $urls = $urls->order_by_desc ($cursor);

    $urls = $urls
      ->limit ($size)
      ->find_array ();

    $domains = Model::Factory ('Model\Domain')->find_array ();
    $domains = array_map ('Model\Domain::clean', $domains);

    $domains = keyi ($domains, 'id');

    foreach ($urls as $k => $url)
      $urls[$k]['domain'] = isset ($domains[$url['domain_id']]) ? $domains[$url['domain_id']] : [];

    $urls = array_map ('Model\Url::clean', $urls);

    return response ()->json ($urls, 200, ['totalItems' => $total], JSON_UNESCAPED_UNICODE);

  }]);


  /**
   *
   * Create url
   *
   */
  $router->post ('/api/v1/url', ['as' => 'api/v1/url/add', function (Request $request) use ($app) {

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
      $error = [
        'status' => 400,
        'message' => 'Shorten Url failed.',
        'errors' => $e->errors (),
      ];
    }

    $domain = Model::Factory ('Model\Domain')
      ->find_one ($data['domain_id']);

    if (! $domain)
      $error = [
        'status' => 400,
        'message' => 'Domain not exists.',
        'errors' => ['domain_id' => ['Domain not exists.']],
      ];


    // Make sure `code` is unique
    if (empty ($error) && isset ($data['url_code']) && $data['url_code'] != '') {

      $url = Model::Factory ('Model\Url')
        ->where ('code', $data['url_code'])
        ->find_one ();

      if ($url)
        $error = [
          'status' => 409,
          'message' => "The shorten code `{$data['url_code']}` has already existed.",
          'errors' => ['url_code' => ["The shorten URL code `{$data['url_code']}` has already existed."]],
        ];

      $code = $data['url_code'];
    }

    if (! empty ($error))
      return response ()->json ($error, $error['status'], [], JSON_UNESCAPED_UNICODE);

    // Create url data
    $url = Model::Factory ('Model\Url')->create ();
    $url->domain_id = $data['domain_id'];
    $url->url_code = $code;
    $url->short_url = "{$domain->host}{$domain->path}/$code";
    $url->original_url = $data['original_url'];
    $url->url_unique_hash = md5 ($data['original_url']);
    $url->enable_custom = array_get ($data, 'enable_custom', false);
    $url->custom_title = array_get ($data, 'custom_title', '');
    $url->custom_description = array_get ($data, 'custom_description', '');
    $url->custom_image = '';
    $url->save ();

    if ($url->url_code == '') {

      for ($i=0; $i<=100; $i++) {

        $code = Shorty::encode ($url->id + $domain->shorty_offset);

        $exist = Model::Factory ('Model\Url')
          ->where ('url_code', $code)
          ->find_one ();

        if (! $exist)
          break;

        $domain->shorty_offset++;
        $domain->save ();
      }

      $url->url_code = $code;
      $url->short_url = "{$domain->host}{$domain->path}/$code";
      $url->save ();
    }

    $data = $url->as_array ();

    // Remove protected field
    $data = Model\Url::clean ($data);

    return response ()->json ($data, 200, [], JSON_UNESCAPED_UNICODE);

  }]);


  /**
   *
   * Update url
   *
   */
  $router->put ('/api/v1/url/{id}', ['as' => 'api/v1/url/update', function (Request $request, $id) use ($app) {

    $data = $request->json ()->all ();
    $code = '';
    $error = [];

    if (! isset ($id)) {
      return response ()->json ([
        'status' => 400,
        'message' => 'URL not exists.',
        'errors' => [],
      ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    $url = Model::Factory ('Model\Url')->find_one ($id);

    if (! $url) {
      return response ()->json ([
        'status' => 400,
        'message' => 'URL not exists.',
        'errors' => [],
      ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    // Try to validate input data
    try {
      $this->validate ($request,
        Model\Url::$_rules,
        Model\Url::$_messages);
    }

    catch (ValidationException $e) {
      $error = [
        'status' => 400,
        'message' => 'URL update failed.',
        'errors' => $e->errors (),
      ];
    }

    $code = $data['url_code'];

    // Make sure `code` is unique
    if (empty ($error)) {

      $exist = Model::Factory ('Model\Url')
        ->where ('url_code', $code)
        ->find_one ();

      if ($exist && $exist->id != $url->id) {
        $error = [
          'status' => 400,
          'message' => "The shorten URL code `{$code}` has already existed.",
          'errors' => ['code' => "The shorten URL code `{$code}` has already existed."],
        ];
      }
    }

    $domain = Model::Factory ('Model\Domain')
      ->find_one ($data['domain_id']);

    if (! $domain)
      $error = [
        'status' => 400,
        'message' => 'Domain not exists.',
        'errors' => ['domain_id' => ['Domain not exists.']],
      ];

    if (! empty ($error))
      return response ()->json ($error, $error['status'], [], JSON_UNESCAPED_UNICODE);

    // Create url data
    $url->domain_id = $data['domain_id'];
    $url->url_code = $code;
    $url->short_url = "{$domain->host}{$domain->path}/$code";
    $url->original_url = $data['original_url'];
    $url->url_unique_hash = md5 ($data['original_url']);
    $url->enable_custom = array_get ($data, 'enable_custom', $url->enable_custom);
    $url->custom_title = array_get ($data, 'custom_title', '');
    $url->custom_description = array_get ($data, 'custom_description', '');
    $url->custom_image = '';
    $url->save ();

    $data = $url->as_array ();

    $domain = Model::Factory ('Model\Domain')->find_one ($data['domain_id']);
    $domains = array_map ('Model\Domain::clean', [$domain->as_array ()]);

    // Remove protected field
    $data = Model\Url::clean ($data);
    $data['domain'] = $domains[0];

    return response ()->json ($data, 200, [], JSON_UNESCAPED_UNICODE);

  }]);


  /**
   *
   * Retrieve url
   *
   */
  $router->get ('/api/v1/url/{id}', ['as' => 'api/v1/url/read', function (Request $request, $id) use ($app) {

    if (! isset ($id)) {
      return response ()->json ([
        'status' => 400,
        'message' => 'URL not exists.',
        'errors' => [],
      ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    $url = Model::Factory ('Model\Url')->find_one ($id);

    if (! $url) {
      return response ()->json ([
        'status' => 400,
        'message' => 'URL not exists.',
        'errors' => [],
      ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    $data = $url->as_array ();

    $domain = Model::Factory ('Model\Domain')->find_one ($data['domain_id']);
    $domains = array_map ('Model\Domain::clean', [$domain->as_array ()]);

    // Remove protected field
    $data = Model\Url::clean ($data);
    $data['domain'] = $domains[0];

    return response ()->json ($data, 200, [], JSON_UNESCAPED_UNICODE);

  }]);
