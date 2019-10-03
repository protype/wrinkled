<?php


  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;


  /**
   *
   * Panel home page
   *
   */
  $router->get ('/@/panel', ['as' => 'panel/home', function (Request $request) use ($app) {

    return 'Panel';

  }]);
