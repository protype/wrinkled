<?php


  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;


  /**
   *
   * Panel home page
   *
   */
  $router->get ('/@/api/v1', ['as' => 'main', function (Request $request) use ($app) {

    header ("HTTP/1.1 404 Not Found");
    die;

  }]);
