@extends('layout')
@section('content')
@include('partials._hero')
@include('partials._search')
{{-- @include('components.listing-card') --}}

<div class="bg-gray-50 border border-gray-200 rounded p-6">
    @if(count($listings) == 0)
    <p>No Listing is Found</p>
    @endif
    @foreach ($listings as $listing)
    <div class="bg-gray-50 border border-gray-200 rounded p-6">
        <div class="flex">
            <img
                class="hidden w-48 mr-6 md:block"
                src="{{$listing->logo ? asset('/storage/' . $listing->logo) : asset('images/no-image.png') }}"
                alt=""
            />
            
            <div>
                <h3 class="text-2xl">
                    <a href="/listings/{{$listing['id']}}">{{$listing->title}}</a>
                </h3>
                <div class="text-xl font-bold mb-4">{{$listing->company}}</div>
                <ul class="flex">
                    @php
                        $csvFiles = $listing['tags']; 
                        $tags = explode(',', $csvFiles);
                    @endphp
                    @foreach ($tags as $tag)
                    <li
                    class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
                    >
                    <a href="/?tag={{$tag}}">{{$tag}}</a>
                </li>
                @endforeach
                    
                </ul>
                <div class="text-lg mt-4">
                    <i class="fa-solid fa-location-dot"></i>
                    {{$listing->location}}
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="mt-6 p-4">
        {{$listings->links()}}
      </div>
</div>
@endsection

