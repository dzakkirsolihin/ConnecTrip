<x-app-layout>
    <head>
        {{-- Link Leaflet's CSS --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <!-- Link Swiper's CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    </head>
    <main class="flex flex-col items-center mt-8">
        <h1 class="text-5xl font-bold">
            Your Trip Map
        </h1>
        <p class="text-gray-600 mt-2">
            Share Your Trip So Others Can Experience The Fun Too!
        </p>
        <!-- Map Section -->
        <div class="map d-flex justify-content-center align-items-center mx-auto mb-4  shadow-lg" style="width: 70%; height: 380px;">
            <div id="map" class="rounded-lg" style="width: 100%; height: 100%;"></div>
        </div>

        <!-- Swiper -->
        <div class="swiper">
            <div class="slide-container w-64 pt-8 pb-8 ml-60 mr-60">
                <div class="swiper-wrapper">
                    <!-- Kartu Wisata -->
                    <div class="swiper-slide bg-[#FFEDD5] rounded-lg shadow-lg overflow-hidden w-64 flex-none transform hover:scale-105 transition-transform duration-300" onclick="showLocation(1)">
                        <img alt="Wisnu Kencana statue" class="w-full h-36 object-cover" height="144" src="https://storage.googleapis.com/a1aa/image/ejZTkSR7NRxaGy3IHTHfSWarWKkEN4GJzcsKxidSAOtZv7zTA.jpg" width="256"/>
                        <div class="p-4">
                            <h2 class="text-xl font-bold">Wisnu Kencana</h2>
                            <p class="text-gray-600">Bali</p>
                            <p class="text-red-500 mt-2">16-17 Juli 2024</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-[#FFEDD5] rounded-lg shadow-lg overflow-hidden w-64 flex-none transform hover:scale-105 transition-transform duration-300" onclick="showLocation(2)">
                        <img alt="Raja Ampat islands" class="w-full h-36 object-cover" height="144" src="https://storage.googleapis.com/a1aa/image/BXyW1jLbRBKaHll7RNt5lu5ZZrR1dBjn6ZY57kfDlJqt395JA.jpg" width="256"/>
                        <div class="p-4">
                            <h2 class="text-xl font-bold">Raja Ampat</h2>
                            <p class="text-gray-600">Papua Barat</p>
                            <p class="text-red-500 mt-2">18-19 Juli 2024</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-[#FFEDD5] rounded-lg shadow-lg overflow-hidden w-64 flex-none transform hover:scale-105 transition-transform duration-300" onclick="showLocation(3)">
                        <img alt="Borobudur Temple at sunrise" class="w-full h-36 object-cover" height="144" src="https://storage.googleapis.com/a1aa/image/DJy4ITffeZLnwJWtjuz0QlzdfXwfmv0krEbv5XJZpk966df8E.jpg" width="256"/>
                        <div class="p-4">
                            <h2 class="text-xl font-bold">Borobudur</h2>
                            <p class="text-gray-600">Jawa Tengah</p>
                            <p class="text-red-500 mt-2">14-15 Juli 2024</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-[#FFEDD5] rounded-lg shadow-lg overflow-hidden w-64 flex-none transform hover:scale-105 transition-transform duration-300" onclick="showLocation(4)">
                        <img alt="Danau Toba" class="w-full h-36 object-cover" height="144" src="https://api2.kemenparekraf.go.id/storage/app/resources/PARIWISATA_STORYNOMICS_TOURISM_shutterstock_385096972_franshendrik_Tambunan_d03d3440db.jpg" width="256"/>
                        <div class="p-4">
                            <h2 class="text-xl font-bold">Danau Toba</h2>
                            <p class="text-gray-600">Sumatera Utara</p>
                            <p class="text-red-500 mt-2">20-21 Juli 2024</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-[#FFEDD5] rounded-lg shadow-lg overflow-hidden w-64 flex-none transform hover:scale-105 transition-transform duration-300" onclick="showLocation(5)">
                        <img alt="Pulau Komodo" class="w-full h-36 object-cover" height="144" src="https://asset.kompas.com/crops/vdZhnhd65omILwbPWGk6C_Vdsp0=/0x0:780x520/1200x800/data/photo/2019/09/26/5d8c64544d656.jpg" width="256"/>
                        <div class="p-4">
                            <h2 class="text-xl font-bold">Pulau Komodo</h2>
                            <p class="text-gray-600">Nusa Tenggara Timur</p>
                            <p class="text-red-500 mt-2">22-23 Juli 2024</p>
                        </div>
                    </div>
                    <div class="swiper-slide bg-[#FFEDD5] rounded-lg shadow-lg overflow-hidden w-64 flex-none transform hover:scale-105 transition-transform duration-300" onclick="showLocation(6)">
                        <img alt="Bromo Mountain" class="w-full h-36 object-cover" height="144" src="https://static.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/p1/1052/2024/02/16/IMG_20240216_075232-199804192.jpg" width="256"/>
                        <div class="p-4">
                            <h2 class="text-xl font-bold">Bromo</h2>
                            <p class="text-gray-600">Jawa Timur</p>
                            <p class="text-red-500 mt-2">24-25 Juli 2024</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </main>
    <!-- Tambahkan Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-2.5, 118.5], 5); // Koordinat awal Indonesia

        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Data tempat wisata
        var locations = [
            { id: 1, name: "Wisnu Kencana", coords: [-8.796944, 115.166667] },
            { id: 2, name: "Raja Ampat", coords: [-0.234890, 130.522779] },
            { id: 3, name: "Borobudur", coords: [-7.607874, 110.203751] },
            { id: 4, name: "Danau Toba", coords: [2.2285, 98.8009] },
            { id: 5, name: "Pulau Komodo", coords: [-8.5456, 119.4376] },
            { id: 6, name: "Bromo", coords: [-7.9422, 112.9536] }
        ];

        // Fungsi untuk menampilkan lokasi
        function showLocation(id) {
            // Hapus semua marker
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            // Temukan lokasi berdasarkan ID
            var location = locations.find(loc => loc.id === id);
            if (location) {
                // Tambahkan marker baru
                L.marker(location.coords).addTo(map)
                    .bindPopup(location.name)
                    .openPopup();

                // Pindahkan peta ke lokasi baru
                map.setView(location.coords, 12);
            }
        }

        // Tampilkan lokasi pertama secara default
        showLocation(1);

        // Initialize Swiper
        var swiper = new Swiper(".slide-container", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            loop: true,
            fade: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
        });
    </script>
</x-app-layout>