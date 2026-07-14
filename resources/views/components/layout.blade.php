<!doctype html>
<html x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'ImmoView') }}</title>


<!-- Styles Flatpickr -->
<link rel="stylesheet" href="{{asset('css/flatpickr.min.css')}}">

<!-- Script Flatpickr + Traduction en Français -->
<script src="{{ asset('js/flatpickr.js') }}"></script>
<script src="{{ asset('js/fr.js') }}"></script>


<!-- Alpine Plugins -->
<script defer src="{{ asset('js/cdn.min.js') }}"></script>
 
<!-- Alpine Core -->
<!-- <script defer src="{{ asset('js/alpin3cdn.min.js') }}"></script> -->

<!-- Alpine Plugins -->
<script defer src="{{ asset('js/maskcdn.min.js') }}"></script>

  <script src="{{config('app.url')}}/js/init-alpine.js"></script>

<link rel="icon" 
      type="image/png" 
      href="{{asset('favicon-16x16.png')}}">

  <!-- Fonts -->
  <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

  <!-- Styles -->
<script
  src="{{ asset('js/alpine.min.js')}}"
  defer
  ></script> 


    <link
      rel="stylesheet"
      href="{{ asset('css/Chart.min.css')}}"
    />
    

    
  <!--<link href="css/tailwind.output.css" rel="stylesheet"> -->
  <link href="{{config('app.url')}}/css/app.css" rel="stylesheet">




  <style type="text/css">
@media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-not-to-print {
    display: none;
  }  
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}

      /*Toast open/load animation*/
  .alert-toast {
    -webkit-animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
  }

  /*Toast close animation*/
  .alert-toast input:checked ~ * {
    -webkit-animation: fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        animation: fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
  }

  /* -------------------------------------------------------------
   * Animations generated using Animista * w: http://animista.net, 
   * ---------------------------------------------------------- */

  @-webkit-keyframes slide-in-top{0%{-webkit-transform:translateY(-1000px);transform:translateY(-1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@keyframes slide-in-top{0%{-webkit-transform:translateY(-1000px);transform:translateY(-1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@-webkit-keyframes slide-out-top{0%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}100%{-webkit-transform:translateY(-1000px);transform:translateY(-1000px);opacity:0}}@keyframes slide-out-top{0%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}100%{-webkit-transform:translateY(-1000px);transform:translateY(-1000px);opacity:0}}@-webkit-keyframes slide-in-bottom{0%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@keyframes slide-in-bottom{0%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}100%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}}@-webkit-keyframes slide-out-bottom{0%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}100%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}}@keyframes slide-out-bottom{0%{-webkit-transform:translateY(0);transform:translateY(0);opacity:1}100%{-webkit-transform:translateY(1000px);transform:translateY(1000px);opacity:0}}@-webkit-keyframes slide-in-right{0%{-webkit-transform:translateX(1000px);transform:translateX(1000px);opacity:0}100%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}}@keyframes slide-in-right{0%{-webkit-transform:translateX(1000px);transform:translateX(1000px);opacity:0}100%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}}@-webkit-keyframes fade-out-right{0%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}100%{-webkit-transform:translateX(50px);transform:translateX(50px);opacity:0}}@keyframes fade-out-right{0%{-webkit-transform:translateX(0);transform:translateX(0);opacity:1}100%{-webkit-transform:translateX(50px);transform:translateX(50px);opacity:0}}


        /* Some basic styling for select with search */
        .custom-select-container {
            position: relative;
        /* width: 200px;*/
        }

        .custom-select {
        /*  width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px*/;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            width: 100%;
        }

        .dropdown-content a {
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            cursor: pointer;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
  </style>
  


</head>
<body>


{{ $slot }}


</body>


<script>
        // JavaScript code to handle projects selection
        const input = document.querySelector('.custom-select');
        const dropdownContent = document.querySelector('.dropdown-content');

        input.addEventListener('focus', function() {
            dropdownContent.style.display = 'block';
        });

        input.addEventListener('blur', function() {
            setTimeout(() => {
                dropdownContent.style.display = 'none';
            }, 200); // Delay closing to allow click on dropdown options
        });

        dropdownContent.addEventListener('click', function(event) {
            if (event.target.tagName === 'A') {
                input.value = event.target.textContent;
                dropdownContent.style.display = 'none';
            }
        });

        input.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const options = dropdownContent.querySelectorAll('a');

            options.forEach(option => {
                const optionText = option.textContent.toLowerCase();
                if (optionText.includes(searchText)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });
    </script>
</html>
