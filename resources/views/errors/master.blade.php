<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      content="Onest Multipurpose Admin &amp; Dashboard Template"
      name="description"
    />
    <meta content="Onest Tech" name="author" />
    <title>@yield('title')</title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{global_asset('backend')}}/assets/css/bootstrap.min.css" />
    <!-- style css -->
    <link rel="stylesheet" href="{{global_asset('backend')}}/assets/css/style.css" />
    <!-- Custom CSS  end -->
  </head>

  <body>
     <!-- main content start -->
    @yield('main')
    <!-- main content end -->
  </body>
</html>
