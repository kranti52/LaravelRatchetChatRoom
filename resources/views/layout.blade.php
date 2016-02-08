<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title><title>ChatRoom-@yield('title')</title></title>
  <link rel="stylesheet" href="css/all.css">

  
</head>

<body>
    @section('sidebar')
            This is the master sidebar.
    @show

        
            
    @yield('content')
      
  
    <script src="js/all.js"></script>
    @yield('script')
    <script>
       
        
    </script>
</body>
</html>