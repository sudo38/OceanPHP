<!-- Page title -->
@title('OceanPHP | {{ $category["name"] }}')

<!-- Section content -->
@start('content')
<h2 class="display-5 link-body-emphasis mb-1">{{ $category['name'] }}</h2>
<hr>
<p>{{ $category['desc'] }}</p>
@end('content')

<!-- Extends detail component -->
@extends('components.admin.detail')