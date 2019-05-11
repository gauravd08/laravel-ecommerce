<meta name="title" content="<?= isset($meta_info['meta_title']) ? $meta_info['meta_title']  : ''; ?>">
<meta name="description" content="<?= isset($meta_info['meta_description']) ? $meta_info['meta_description']  : ''; ?>">
<meta name="keywords" content="<?= isset($meta_info['meta_keywords']) ? $meta_info['meta_keywords']  : '' ?>">

<title>Divisima | eCommerce Template con</title>
<meta charset="UTF-8">
<meta name="description" content=" Divisima | eCommerce Template">
<meta name="keywords" content="divisima, eCommerce, creative, html">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--common X-XSRF-TOKEN -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Favicon -->
<link href="img/favicon.ico" rel="shortcut icon"/>  

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,300i,400,400i,700,700i" rel="stylesheet">

<!-- Stylesheets -->
<link rel="stylesheet" href="/assets/frontend/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/assets/frontend/css/font-awesome.min.css"/>
<link rel="stylesheet" href="/assets/frontend/css/flaticon.css"/>
<link rel="stylesheet" href="/assets/frontend/css/slicknav.min.css"/>
<link rel="stylesheet" href="/assets/frontend/css/jquery-ui.min.css"/>
<link rel="stylesheet" href="/assets/frontend/css/owl.carousel.min.css"/>
<link rel="stylesheet" href="/assets/frontend/css/animate.css"/>
<link rel="stylesheet" href="/assets/frontend/css/style.css"/>

<!-- fanybox -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.css" rel="stylesheet" type="text/css" />

<!-- custom css -->
<link href="/assets/frontend/css/custom.css" rel="stylesheet" type="text/css"/>

@stack('styles')