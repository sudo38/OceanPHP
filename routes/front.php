<?php

   route_get('/',               'front.home@index');
   route_get('blog',            'front.blog@index');
   route_get('tags/{id}',       'front.tag@index');
   route_get('users/{id}',      'front.user@index');
   route_get('posts/{slug}',    'front.post@index');
   route_get('categories/{id}', 'front.category@index');