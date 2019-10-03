<?php

  namespace Model;


  /**
   *
   * Domain model
   *
   */
  class Domain extends \Model {


    /**
     *
     * Config
     *
     */
    public static $_table = 'domain';
    public static $_id_column = 'id';


    /**
     *
     * Validation rules
     *
     */
    public static $_rules = [
    ];


    /**
     *
     * Error messages
     *
     */
    public static $_messages = [
    ];


    /**
     *
     * Output filter
     *
     */
    public static function clean ($data) {
      return $data;
    }
  }
