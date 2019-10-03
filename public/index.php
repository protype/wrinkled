<?php


  /**
   *
   * Root
   *
   */
  define ('_ROOT', dirname (__DIR__));


  /**
   *
   * Vendors
   *
   */
  require_once _ROOT . '/vendor/autoload.php';


  /**
   *
   * Environments
   *
   */
  try {
    Dotenv\Dotenv::create (_ROOT)->load ();
  }

  catch (Dotenv\Exception\InvalidPathException $e) {
  }


  /**
   *
   * Initial DB connection & model
   *
   */
  require_once _ROOT . '/config/database.php';
  require_once _ROOT . '/database/models/url.php';


  /**
   *
   * Prepare
   *
   */
  $host = array_get ($_SERVER, 'HTTP_HOST', null);
  $uri = array_get ($_SERVER, 'REQUEST_URI', null);

  if (is_null ($host) || is_null ($uri)) {
    header ("HTTP/1.0 404 Not Found");
    exit;
  }

  $url = Model::Factory ('Model\Url')
    ->where ('short_url', "{$host}{$uri}")
    ->find_one ();

  if (! $url) {
    header ("HTTP/1.0 404 Not Found");
    exit;
  }

  header ("Location: {$url->original_url}", true, 302);
  exit;
