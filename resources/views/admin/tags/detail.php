<!-- Page title -->
@title('OceanPHP | {{ $tag["name"] }}')

<!-- Section content -->
@start('content')
<h2 class="display-5 link-body-emphasis mb-1">{{ $tag['name'] }}</h2>
<hr>
<p>{{ $tag['desc'] }}</p>
@end('content')

<!-- Extends detail component -->
@extends('components.admin.detail')