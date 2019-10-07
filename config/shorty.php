<?php


  /**
   *
   * Shorty config
   *
   */
  App\Helper\Shorty::config ([
    'salt'    => $_ENV['APP_KEY'],
    'padding' => 1,
  ]);
