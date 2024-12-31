<x-app-layout>
    <head>
        {{-- Link Leaflet's CSS --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <!-- Link Swiper's CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <main class="flex justify-center items-center min-h-screen">
        <div class="p-6 max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <img alt="Sunset view of Borobudur temple" class="rounded-lg w-full" height="400" src="https://storage.googleapis.com/a1aa/image/n7fjZfgsT9peiJe1z9ZbFgTjX8JVTIy24LFyjYW436rmL8gPB.jpg" width="600"/>
             <div class="grid grid-cols-2 gap-2">
              <img alt="Borobudur temple with tourists" class="rounded-lg w-full" height="200" src="https://storage.googleapis.com/a1aa/image/AQbk3JuGYdaiBJ5BhTJBJoNI9N94vShl9DnjwfntErnfCP4TA.jpg" width="200"/>
              <img alt="Silhouette of Borobudur temple at sunrise" class="rounded-lg w-full" height="200" src="https://storage.googleapis.com/a1aa/image/agjJr9IcMKpPO1wUXnyXxf7FXIuHlZOVViZFu7LJTMWfCP4TA.jpg" width="200"/>
              <img alt="Elephant ride near Borobudur temple" class="rounded-lg w-full" height="200" src="https://storage.googleapis.com/a1aa/image/q6sf6zECA9zibamcdJ3cHRbcSJRO5p0IxWxS6l5EEIaeCP4TA.jpg" width="200"/>
              <img alt="Buddha statue at Borobudur temple" class="rounded-lg w-full" height="200" src="https://storage.googleapis.com/a1aa/image/HXLCKd1f2xWdbKX7Fruw6XT132fSNu0zaQkz75dD4wU7CP4TA.jpg" width="200"/>
             </div>
            </div>
            <div class="mt-6 p-6 bg-white rounded-lg shadow-lg">
             <div class="flex justify-between items-center">
              <h1 class="text-2xl font-bold"> Tur {{ $tripsubmissions->trip_name }} </h1>
             </div>
             <div class="mt-4">
              <div class="flex items-center space-x-2 text-gray-600">
               <i class="fas fa-calendar-alt">
               </i>
               <span>{{ $tripsubmissions->start_date }} - {{ $tripsubmissions->end_date }}</span>
              </div>
              <div class="flex items-center space-x-2 text-gray-600 mt-2">
               <i class="fas fa-map-marker-alt"></i>
               <span>{{ $tripsubmissions->address }}</span>
              </div>
              <div class="flex items-center space-x-2 text-gray-600 mt-2">
               <i class="fas fa-clock"></i>
               <span>2 DAY</span>
              </div>
              <div class="flex items-center space-x-2 text-gray-600 mt-2">
               <i class="fas fa-users"></i>
               <span>40/90</span>
              </div>
             </div>
             <div class="mt-6">
              <button class="w-full bg-red-600 text-white py-3 rounded-lg font-bold">Join Trip Now</button>
             </div>
            </div>
            <div class="mt-6 p-6 bg-white rounded-lg shadow-lg">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">About Destination</h1>
                </div>
                <div class="pt-4">
                    <p>{{ $tripsubmissions->description }}</p>
                </div>
            </div>
            <div class="mt-6 p-6 bg-white rounded-lg shadow-lg">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Review</h1>
                </div>
                
                <div class="space-y-6 pt-4">
                    <div>
                        <p class="font-semibold">Steven Anugrah</p>
                        <p class="text-sm text-gray-500">February 3, 2024 <i class="fas fa-quote-left text-yellow-500"></i></p>
                        <p class="mt-2">The trip to Borobudur Temple was absolutely incredible! The temple is so majestic, and the details of the carvings are amazing, telling stories of Buddhist history and teachings. The view from the top of the temple is beautiful. Our guide was extremely knowledgeable, explaining every part of the temple with enthusiasm and making the visit even more memorable. It was like walking through ancient history with a sense of wonder and awe. If you are thinking about it, Borobudur is a must-visit destination at least once in a lifetime!</p>
                    </div>
                    <div>
                        <p class="font-semibold">Ricky Alexander</p>
                        <p class="text-sm text-gray-500">February 3, 2024 <i class="fas fa-quote-left text-yellow-500"></i></p>
                        <p class="mt-2">The trip to Borobudur Temple was absolutely mesmerizing! The grandeur and majesty of this temple is overwhelming, making it one of the most inspiring places I have ever seen. Every corner is filled with stunning detail, depicting the teachings and wisdom of ancient Buddhist culture. Standing at the top of the temple, I could feel a sense of awe and peace, as if the whole universe was right there. Borobudur is not just a tourist destination, but also the embodiment of an unforgettable masterpiece!</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-center">
                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg">See More</button>
                </div>
            </div>
           </div>
           
    </main>
</x-app-layout>
