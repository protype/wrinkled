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

  $uri = rtrim (str_replace (array_get ($_SERVER, 'QUERY_STRING', ''), '', $uri), '?');


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
  //$info = parse_url ();
  $base = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname ($_SERVER['SCRIPT_NAME']);
  $title = htmlspecialchars ($url->custom_title, ENT_QUOTES | ENT_HTML401);
  $desc  = htmlspecialchars ($url->custom_description, ENT_QUOTES | ENT_HTML401);
  $image = $base . $url->custom_image;

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $desc ?>" />
<meta name="image" content="<?php echo $image ?>" />
<link rel="image_src" href="<?php echo $image ?>" />

<meta property="og:image" content="<?php echo $image ?>" />
<meta property="og:title" content="<?php echo $title ?>" />
<meta property="og:description" content="<?php echo $desc ?>" />

<meta name="twitter:image:src" content="<?php echo $image ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $title ?>">
<meta name="twitter:description" content="<?php echo $desc ?>">

<meta itemprop="name" content="<?php echo $title ?>">
<meta itemprop="image" content="<?php echo $image ?>">
<meta itemprop="description" content="<?php echo $desc ?>">

<title><?php echo $title ?></title>

<body>
  <h1><?php echo $title ?></h1>
  <a href="<?php echo $ourl ?>"><img title="<?php echo $title ?>" src="<?php echo $image ?>" alt="<?php echo $title ?>" border=0 ></a>
  <p><?php echo $desc ?></p>
</body>
