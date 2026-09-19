@extends('errors.master')

@section('title', 'Error Page 400')
@section('main')


<main>
    <section
      class="error-wrapper p-0 m-0 text-center d-flex justify-content-center align-items-center flex-column"
    >
      <div
        class="error-content p-0 m-0 text-center d-flex justify-content-center align-items-center flex-column"
      >
        <!-- error 404 image  -->
        <img src="{{asset('backend')}}/assets/images/error/error500.png" alt="" />
        <!-- Head text  -->
        <h1 class="mt-30">{{ ___('error.400_database_connection_error') }}</h1>
        <!-- Error text   -->
        <p class="mt-10">
        {{ ___('error.please_check_database_connection_and_tables') }}
        </p>
        <!-- Back to homepage button  -->
        <div class="btn-back-to-homepage mt-28">
            <a href="{{url('dashboard')}}" class="submit-button pv-16  btn ot-btn-primary">
            {{ ___('error.back_to_homepage') }}
            </a>
            @if(env('APP_ENV')=="local")
            <a href="{{url('i-am-sure-to-reset-my-database')}}" class="submit-button pv-16  btn ot-btn-primary">
            {{ ___('error.reset_database') }}
            </a>
            @endif 
          </div>
      </div>
    </section>
  </main>
  @endsection