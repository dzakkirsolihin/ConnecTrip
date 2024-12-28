<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Trip') }}
        </h2>
    </x-slot>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>My Trips</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-['Roboto'] m-0 p-0 bg-[#f8f1e4]">

    <!-- Hero Section -->
    <div class="relative text-center text-white">
        <img src="https://storage.googleapis.com/a1aa/image/IjsL1vO5HpaqAlgi9xhziFMjKSevpZZDVA8ZGuJldGlbZofTA.jpg" 
             alt="Beautiful landscape with a temple and mountains" 
             class="w-full h-auto"/>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-5xl font-bold">
            My Trips
        </div>
    </div>

    <!-- Tabs -->
    <div class="flex justify-center bg-[#f8e8d4] py-2.5">
        <div class="mx-5 px-5 py-2.5 cursor-pointer font-bold border-b-2 border-black">Visited</div>
        <div class="mx-5 px-5 py-2.5 cursor-pointer font-bold">Being Visited</div>
        <div class="mx-5 px-5 py-2.5 cursor-pointer font-bold">Will be Visited</div>
    </div>

    <!-- Trip Cards -->
    <div class="flex justify-center p-5">
        <!-- Raja Ampat Card -->
        <div class="bg-white rounded-lg shadow-lg mx-2.5 overflow-hidden w-[300px]">
            <img src="https://storage.googleapis.com/a1aa/image/XUQ10KijbLL0KpjaIwLZwVJcMurWkptCiUxZEVWJtRUuM0fJA.jpg" 
                 alt="Raja Ampat, Papua Barat" 
                 class="w-full h-auto"/>
            <div class="p-5">
                <h3 class="m-0 text-2xl">Raja Ampat</h3>
                <p class="my-1.5 text-gray-500">Papua Barat</p>
                <p class="text-[#ff5a5f] font-bold">18-19 Juli 2024</p>
            </div>
        </div>

        <!-- Pulau Weh Card -->
        <div class="bg-white rounded-lg shadow-lg mx-2.5 overflow-hidden w-[300px]">
            <img src="https://storage.googleapis.com/a1aa/image/6vd34lDMuvqLFZeJ97C8KhCKouq59HOyQsa2ReZKXC36yQfnA.jpg" 
                 alt="Pulau Weh, Aceh" 
                 class="w-full h-auto"/>
            <div class="p-5">
                <h3 class="m-0 text-2xl">Pulau Weh</h3>
                <p class="my-1.5 text-gray-500">Aceh</p>
                <p class="text-[#ff5a5f] font-bold">20-21 Juli 2024</p>
            </div>
        </div>

        <!-- Borobudur Card -->
        <div class="bg-white rounded-lg shadow-lg mx-2.5 overflow-hidden w-[300px]">
            <img src="https://storage.googleapis.com/a1aa/image/wUoijC2R2NJWL9s9tPGyUSd2c6KCBNQb3XbDfpQXa2paZofTA.jpg" 
                 alt="Borobudur, Jawa Tengah" 
                 class="w-full h-auto"/>
            <div class="p-5">
                <h3 class="m-0 text-2xl">Borobudur</h3>
                <p class="my-1.5 text-gray-500">Jawa Tengah</p>
                <p class="text-[#ff5a5f] font-bold">14-15 Juli 2024</p>
            </div>
        </div>
    </div>
</body>
</html>


</x-app-layout>
