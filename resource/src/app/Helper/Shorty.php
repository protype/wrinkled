<?php

  namespace App\Helper;


  /**
   *
   * Shorty: A simple URL shortener.
   *
   * @copyright Copyright (c) 2011, Mike Cao <mike@mikecao.com>
   *            Copyright (c) 2019, Wake Liu <wake.gs@gmail.com>
   * @license   MIT, http://www.opensource.org/licenses/mit-license.php
   *
   */
  class Shorty {


    /**
     *
     * Default characters
     *
     */
    private static $_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';


    /**
     *
     * Salt for id encoding.
     *
     *
     * @var string
     */
    private static $_salt = '';


    /**
     *
     * Length of number padding.
     *
     */
    private static $_padding = 0;


    /**
     *
     * Configure
     *
     */
    public static function config ($config = []) {

      if (isset ($config['chars']))
        static::chars ($config['chars']);

      if (isset ($config['salt']))
        static::salt ($config['salt']);

      if (isset ($config['padding']))
        static::padding ($config['padding']);
    }


    /**
     *
     * Get / set the character set for encoding.
     *
     */
    public static function chars ($chars = null) {

      if (is_null ($chars))
        return static::$_chars;

      if (! is_string ($chars) || strlen ($chars) == 0)
        throw new Exception ('Invalid set of characters');

      return static::$_chars = $chars;
    }


    /**
     *
     * Get / set the salt string for encoding.
     *
     */
    public static function salt ($salt = null) {

      if (is_null ($salt))
        return static::$_salt;

      if (! is_string ($salt) || strlen ($salt) == 0)
        throw new Exception ('Invalid salt value');

      return static::$_salt = $salt;
    }


    /**
     *
     * Get / set padding length.
     *
     */
    public static function padding ($padding = null) {

      if (is_null ($padding))
        return static::$_padding;

      if (! is_int ($padding))
        throw new Exception ('Invalid padding value');

      return static::$_padding = $padding;
    }


    /**
     *
     * Converts an id to an encoded string.
     *
     */
    public static function encode ($num) {

      $seed = 0;
      $padding = static::$_padding;
      $salt = static::$_salt;
      $chars = static::$_chars;

      if ($padding > 0 && ! empty ($salt)) {
        $seed = self::seed ($num, $salt, $padding);
        $num = (int) ($seed.$num);
      }

      return static::numToAlpha ($num, $chars);
    }


    /**
     *
     * Converts an encoded string into a number.
     *
     *
     */
    public static function decode ($str) {

      $chars = static::$_chars;
      $salt = static::$_salt;
      $padding = static::$_padding;

      $num = static::alphaToNum ($str, $chars);

      return (! empty ($salt)) ? substr ($num, $padding) : $num;
    }


    /**
     *
     * Get a number for padding based on a salt.
     *
     */
    public static function seed ($num, $salt, $padding) {

      $hash = md5 ($num.$salt);
      $dec = hexdec (substr ($hash, 0, $padding));
      $num = $dec % pow (10, $padding);

      if ($num == 0)
        $num = 1;

      $num = str_pad ($num, $padding, '0');

      return $num;
    }


    /**
     *
     * Converts a number to an alpha-numeric string.
     *
     */
    public static function numToAlpha ($num, $chars) {

      $len = strlen ($chars);
      $mod = $num % $len;

      if ($num - $mod == 0)
        return substr ($chars, $num, 1);

      $alpha = '';

      while ($mod > 0 || $num > 0) {
        $alpha = substr ($chars, $mod, 1) . $alpha;
        $num = ($num - $mod) / $len;
        $mod = $num % $len;
      }

      return $alpha;
    }


    /**
     *
     * Converts an alpha numeric string to a number.
     *
     */
    public static function alphaToNum ($alpha, $str) {

      $strLen = strlen ($str);
      $alphaLen = strlen ($alpha);

      $num = 0;

      for ($i=0; $i<$alphaLen; $i++) {
        $num += strpos ($str, substr ($alpha, $i, 1)) * pow ($strLen, $alphaLen - $i - 1);
      }

      return $num;
    }
  }
