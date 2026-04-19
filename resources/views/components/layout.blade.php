<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body>
    <x-form.nav/>
    {{ $slot }}
   
     @session('success')
<div class=" fixed z-50 bg-gradient-to-br from-emerald-500 to-emerald-900 px-4 py-3 bottom-4 right-4 rounded-lg" 
    x-data="{show:true}"
    x-init="setTimeout(()=>{$el.remove()},3000)"
    x-show="show"
    x-transition.opacity.duration.300ms
    >
       {{ $value }}
    </div>
    @endsession
</body>
</html>