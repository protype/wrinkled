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


  /**
   *
   * Fetch shortened url data
   *
   */
  $url = Model::Factory ('Model\Url')
    ->where ('short_url', "{$host}{$uri}")
    ->find_one ();

  if (! $url) {
    header ("HTTP/1.0 404 Not Found");
    exit;
  }


  /**
   *
   * Redirect directly
   *
   */
  if ($url->enable_custom == 0) {
    header ("Location: {$url->original_url}", true, 302);
    exit;
  }


  /**
   *
   * Check if client is a browser or crawler
   *
   */
  $browser = new Browser ();

  if ($browser->getBrowser () != Browser::BROWSER_UNKNOWN) {
    header ("Location: {$url->original_url}", true, 302);
    exit;
  }


  /**
   *
   * Display HTML for crawler
   *
   */
  $ourl  = $url->original_url;
  $title = htmlspecialchars ($url->title, ENT_QUOTES | ENT_HTML401);
  $desc  = htmlspecialchars ($url->description, ENT_QUOTES | ENT_HTML401);
  $image = $url->image;

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php= $desc ?>" />
<meta name="image" content="<?php= $image ?>" />
<link rel="image_src" href="<?php= $image ?>" />

<meta property="og:image" content="<?php= $image ?>" />
<meta property="og:title" content="<?php= $title ?>" />
<meta property="og:description" content="<?php= $desc ?>" />

<meta name="twitter:image:src" content="<?php= $image ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php= $title ?>">
<meta name="twitter:description" content="<?php= $desc ?>">

<meta itemprop="name" content="<?php= $title ?>">
<meta itemprop="image" content="<?php= $image ?>">
<meta itemprop="description" content="<?php= desc ?>">

<title><?php= $title ?></title>

<body>
  <h1><?php= $title ?></h1>
  <a href="<?php= $ourl ?>"><img title="<?php= $title ?>" src="<?php= $image ?>" alt="<?php= $title ?>" border=0 ></a>
  <p><?php= $desc ?></p>
</body>
