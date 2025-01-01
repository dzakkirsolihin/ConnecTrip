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
        <style>
            .underline-animation {
                position: relative;
            }
            .underline-animation::after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 50%;
                width: 0;
                height: 2px;
                background-color: black;
                transition: width 0.3s ease, left 0.3s ease;
            }
            .underline-animation.active::after {
                width: 100%;
                left: 0;
            }
    
            /* Animation for cards */
            .card {
                opacity: 0;
                transform: translateY(10px);
                animation: fadeInUp 0.5s ease forwards;
            }
    
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <body class="font-['Roboto'] m-0 p-0 bg-[#f8f1e4]">
    
        <!-- Hero Section -->
        <div class="relative text-center text-white">
            <img src="https://static.thehoneycombers.com/wp-content/uploads/sites/4/2024/09/Best-things-to-do-in-Bali-Indonesia-tours-and-attractions-1.jpeg" 
                 alt="Beautiful landscape with a temple and mountains" 
                 class="w-full h-[400px] object-cover"/>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-5xl font-bold font-['Playfair_Display']">
                My Trips
            </div>
        </div>
    
        <!-- Tabs -->
        <div class="flex justify-center bg-[#f8e8d4] py-2.5">
            <button onclick="showCategory('visited', this)" class="mx-5 px-5 py-2.5 cursor-pointer font-bold underline-animation active">Visited</button>
            <button onclick="showCategory('beingVisited', this)" class="mx-5 px-5 py-2.5 cursor-pointer font-bold underline-animation">Being Visited</button>
            <button onclick="showCategory('willBeVisited', this)" class="mx-5 px-5 py-2.5 cursor-pointer font-bold underline-animation">Will be Visited</button>
        </div>
    
        <!-- Trip Cards -->
        <div id="card-container" class="flex justify-center flex-wrap p-10">
            <!-- Cards will be dynamically loaded here -->
        </div>
    
        <script>
            // Data for each category
            const trips = {
                visited: [
                    { img: 'https://storage.googleapis.com/a1aa/image/XUQ10KijbLL0KpjaIwLZwVJcMurWkptCiUxZEVWJtRUuM0fJA.jpg', name: 'Raja Ampat', location: 'Papua Barat', date: '18-19 Juli 2024' },
                    { img: 'https://storage.googleapis.com/a1aa/image/6vd34lDMuvqLFZeJ97C8KhCKouq59HOyQsa2ReZKXC36yQfnA.jpg', name: 'Pulau Weh', location: 'Aceh', date: '20-21 Juli 2024' },
                    { img: 'https://storage.googleapis.com/a1aa/image/wUoijC2R2NJWL9s9tPGyUSd2c6KCBNQb3XbDfpQXa2paZofTA.jpg', name: 'Borobudur', location: 'Jawa Tengah', date: '14-15 Juli 2024' },
                ],
                beingVisited: [
                    { img: 'https://via.placeholder.com/300x200', name: 'Mount Rinjani', location: 'Lombok', date: '01-02 Agustus 2024' },
                ],
                willBeVisited: [
                    { img: 'https://via.placeholder.com/300x200', name: 'Komodo Island', location: 'Nusa Tenggara Timur', date: '15-16 Agustus 2024' },
                    { img: 'https://via.placeholder.com/300x200', name: 'Lake Toba', location: 'Sumatera Utara', date: '17-18 Agustus 2024' },
                    { img: 'https://via.placeholder.com/300x200', name: 'Yogyakarta', location: 'DIY', date: '19-20 Agustus 2024' },
                ],
            };
    
            // Function to display cards based on category
            function showCategory(category, button) {
                const cardContainer = document.getElementById('card-container');
                cardContainer.innerHTML = ''; // Clear existing cards
    
                // Add cards dynamically with animation class
                trips[category].forEach(trip => {
                    const card = `
                        <div class="bg-white rounded-lg shadow-lg mx-2.5 overflow-hidden w-[300px] card">
                            <img src="${trip.img}" alt="${trip.name}, ${trip.location}" class="w-full h-auto"/>
                            <div class="p-5">
                                <h3 class="m-0 text-2xl">${trip.name}</h3>
                                <p class="my-1.5 text-gray-500">${trip.location}</p>
                                <p class="text-[#ff5a5f] font-bold">${trip.date}</p>
                            </div>
                        </div>`;
                    cardContainer.innerHTML += card;
                });
    
                // Update active tab styling
                document.querySelectorAll('.underline-animation').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            }
    
            // Default category on load
            document.addEventListener('DOMContentLoaded', () => showCategory('visited', document.querySelector('.underline-animation.active')));
        </script>
    
    </body>
    </html>
    
    
    

</x-app-layout>
