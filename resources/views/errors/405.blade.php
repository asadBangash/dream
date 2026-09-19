@extends('errors.master')

@section('title', 'Error Page 405')
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
        <h1 class="mt-30">{{ ___('error.405_method_not_allowed') }}</h1>
        <!-- Error text   -->
        <p class="mt-10">
        {{ ___('error.the_server_knows_the_request_method_but_the_target_resource_doesn_t_support_this_method') }}
        </p>
        <!-- Back to homepage button  -->
        <div class="btn-back-to-homepage mt-28">
            <a href="{{url('dashboard')}}" class="submit-button pv-16  btn ot-btn-primary">
            {{ ___('error.back_to_homepage') }}
            </a>
          </div>
      </div>
    </section>
  </main>
  @endsection