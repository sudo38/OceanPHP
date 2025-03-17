<?php

   route_group(['prefix' => ADMIN], [
      # Dashboard
      get('dashboard',          'dashboard@index'),
      get('logout',             'dashboard@logout'),

      # Tags
      get('tags',               'tags@index'),
      get('tags/add',           'tags@add'),
      get('tags/{id}',          'tags@detail'),
      get('tags/edit/{id}',     'tags@edit'),
      post('tag/store',         'tags@store'),
      post('tags/update/{id}',  'tags@update'),
      post('tags/delete/{id}',  'tags@delete'),

      # Categories
      get('categories',         'categories@index'),
      get('categories/add',     'categories@add'),
      get('categories/view',    'categories@detail'),
      get('categories/edit',    'categories@edit'),
      post('categories/store',  'categories@store'),
      post('categories/update', 'categories@update'),
      post('categories/delete', 'categories@delete'),

      # Posts
      get('posts',              'posts@index'),
      get('posts/add',          'posts@add'),
      get('posts/view',         'posts@detail'),
      get('posts/edit',         'posts@edit'),
      post('posts/store',       'posts@store'),
      post('posts/update',      'posts@update'),
      post('posts/delete',      'posts@delete'),

      # Profile
      get('profile',            'profile@index'),
      post('profile/update',    'profile@update'),

      # Profile
      get('settings',           'settings@index'),
      post('settings/update',   'settings@update'),
   ]);