<!-- Include header layout -->
@include('admin.layouts.header')

<!-- Include navbar layout -->
@include('admin.layouts.navbar')

<div class="container my-3">
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
      <h1 class="h2">
         <!-- Section title -->
         @section('title')
      </h1>
   </div>
   <!-- Section form -->
   @section('form')
   
   @php
      session_forget('old');
      session_forget('validations');
   @endphp
</div>

<!-- Include footer layout -->
@include('admin.layouts.footer')
