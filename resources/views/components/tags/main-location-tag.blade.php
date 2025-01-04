@props(['tag'])

<div class="inline-flex bg-white rounded-md pl-2 pr-2 py-1 text-sm border border-primary-blue">
    <div class="flex items-center mr-1">
        <img src="{{ asset('app-icons/star-outline.svg') }}" alt="Main" class="w-4 h-4">
    </div>
    <div class="mt-0.5">
        <span class="text-gray-700">{{ $tag->name }}</span>
    </div>
</div>
