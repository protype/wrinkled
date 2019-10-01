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
     * Validation rules & error messages
     *
     */
    public static $_rules = [
      'url' => 'required|url',
      'code' => 'regex:/^[a-zA-Z0-9\-]+$/',
      'title' => 'string',
      'description' => 'string',
      'cover' => 'image',
    ];

    public static $_messages = [

      // Common messages
      'required' => 'A value for the `:attribute` field is required.',
      'filled' => 'The `:attribute` field must not be empty.',
      'string' => 'A value for the `:attribute` field must be string.',
      'image' => 'A file for the `:attribute` field must be an image (jpeg, png, bmp, gif, svg, or webp).',

      'url.url' => 'Invalid value for the `url` field.',
      'code.regex' => 'Invalid value for the `code` field.',
    ];
  }
