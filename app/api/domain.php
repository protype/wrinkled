<?php


  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;
  use App\Helper\Shorty;


  /**
   *
   * List domains
   *
   */
  $router->get ('/@/api/domain', ['as' => 'api/domain/list', function (Request $request) use ($app) {

    // Count domain
    $total = \Model::Factory ('Model\Domain')
      ->count ('id');

    // Retrieve domains
    $domains = Model::Factory ('Model\Domain')
      ->order_by_asc ('id')
      ->find_array ();

    $domains = array_map ('Model\Domain::clean', $domains);

    return response ()->json ($domains, 200, ['totalItems' => $total], JSON_UNESCAPED_UNICODE);

  }]);
