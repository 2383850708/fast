<?php

return array (
  'autoload' => false,
  'hooks' => 
  array (
    'response_send' => 
    array (
      0 => 'loginvideo',
    ),
    'upload_after' => 
    array (
      0 => 'thumb',
    ),
  ),
  'route' => 
  array (
    '/third$' => 'third/index/index',
    '/third/connect/[:platform]' => 'third/index/connect',
    '/third/callback/[:platform]' => 'third/index/callback',
  ),
);