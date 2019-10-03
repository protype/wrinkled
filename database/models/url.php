<?php

  namespace Model;


  /**
   *
   * Url model
   *
   */
  class Url extends \Model {


    /**
     *
     * Config
     *
     */
    public static $_table = 'url';
    public static $_id_column = 'id';


    /**
     *
     * Validation rules
     *
     */
    public static $_rules = [
      'domain_id' => 'required',
      'original_url' => 'required|url',
      'url_code' => 'regex:/^[a-zA-Z0-9\-]+$/',
      'enable_custom' => 'boolean',
      'custom_title' => 'string',
      'custom_description' => 'string',
      'custom_image' => 'image',
    ];


    /**
     *
     * Error messages
     *
     */
    public static $_messages = [

      // Common messages
      'required' => 'A value for the `:attribute` field is required.',
      'filled' => 'The `:attribute` field must not be empty.',
      'string' => 'A value for the `:attribute` field must be string.',
      'image' => 'A file for the `:attribute` field must be an image (jpeg, png, bmp, gif, svg, or webp).',

      'original_url.url' => 'Invalid value for the `original_url` field.',
      'url_code.regex' => 'Invalid value for the `url_code` field.',
    ];


    /**
     *
     * Output filter
     *
     */
    public static function clean ($data) {

      //unset ($data['id']);
      //unset ($data['hash']);

      return $data;
    }
  }
