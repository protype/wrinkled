<?php


if (! function_exists ('snackCaseToCamelCase')) {


  /**
   * Convert snake_case to camelCase
   *
   * @return string
   */
  function snackCaseToCamelCase ($str) {
    return lcfirst (str_replace ('_', '', ucwords ($str, '_')));
  }


  /**
   * Alias of snackCaseToCamelCase and support array keys converting
   *
   * @return string
   */
  function scTOcc ($input) {

    if (is_string ($input))
      return snackCaseToCamelCase ($input);

    else if (is_array ($input) == 'array') {

      $output = [];

      foreach ($input as $k => $v) {
        $k = scTOcc ($k);
        $v = scTOcc ($v);
        $output[$k] = $v;
      }

      return $output;
    }
  }
}


if (! function_exists ('camelCaseToSnackCase')) {


  /**
   * Convert camelCase to snake_case
   *
   * @return string
   */
  function camelCaseToSnackCase ($str) {
    return ltrim (strtolower (preg_replace ('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $str)), '_');
  }


  /**
   * Alias of camelCaseToSnackCase and support array keys converting
   *
   * @return string
   */
  function ccTOsc ($input) {

    if (is_string ($input))
      return camelCaseToSnackCase ($input);

    else if (is_array ($input) == 'array') {

      $output = [];

      foreach ($input as $k => $v) {
        $k = ccTOsc ($k);
        $v = ccTOsc ($v);
        $output[$k] = $v;
      }

      return $output;
    }
  }
}


if (! function_exists ('config_path')) {


  /**
   * Get the configuration path.
   *
   * @param  string $path
   * @return string
   */
  function config_path ($path = '') {
    return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
  }
}


if (! function_exists ('sess')) {


  /**
   * Get session instance.
   *
   * @return object
   */
  function sess () {
    return app ('session');
  }
}
