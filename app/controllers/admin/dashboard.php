<?php

   function index() {

      return view('admin.dashboard');
   }


   function logout() {
      session_forget(ADMIN);

      return redirect('login');
   }