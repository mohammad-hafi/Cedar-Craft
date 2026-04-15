@props(['label','name','type'=>'text'])
<div class="space-y-2">
    <label for="{{ $name }}" class="label block font-semibold text-gray-800 mb-2">{{$label}}</label>
    <input type="{{ $type }}" class="input w-full rounded-lg border-2 border-gray-200 px-4 py-3 focus:outline-none focus:border-emerald-900" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" {{ $attributes }}/>
@error($name)
    <p class="text-sm text-red-500">{{$message}}</p>
@enderror
</div>