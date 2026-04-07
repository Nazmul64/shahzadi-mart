{{-- resources/views/frontend/pages/category.blade.php --}}
<aside class="sidebar" id="sidebar">

    <div class="sb-head">
        <i class="bi bi-grid-fill"></i>
        <span>All Categories</span>
    </div>

    @php
    $categories = [
        ['icon'=>'bi-house-fill',        'label'=>'Brand Stores',
         'subs'=>[
            ['label'=>'Apple Store',   'children'=>['iPhone','MacBook','iPad','Apple Watch','AirPods']],
            ['label'=>'Samsung Store', 'children'=>['Galaxy Phones','Galaxy Tabs','Smart TVs','Home Appliances']],
            ['label'=>'Nike Store',    'children'=>['Running Shoes','Sportswear','Bags & Backpacks']],
            ['label'=>'Adidas Store',  'children'=>['Sneakers','Training Wear','Accessories']],
            ['label'=>'Sony Store',    'children'=>['Cameras','Headphones','PlayStation','TVs']],
        ]],
        ['icon'=>'bi-phone-fill',         'label'=>'Phones & Tablets',
         'subs'=>[
            ['label'=>'Smartphones',  'children'=>['Android Phones','iPhones','Budget Phones','Flagship Phones','Refurbished']],
            ['label'=>'Tablets',      'children'=>['Android Tablets','iPads','Kids Tablets','Drawing Tablets']],
            ['label'=>'Accessories',  'children'=>['Cases & Covers','Screen Protectors','Chargers & Cables','Power Banks','Earphones']],
            ['label'=>'SIM & Plans',  'children'=>['Prepaid SIMs','Data Bundles','Airtime Top-up']],
        ]],
        ['icon'=>'bi-laptop-fill',        'label'=>'Computing',
         'subs'=>[
            ['label'=>'Laptops',      'children'=>['Gaming Laptops','Business Laptops','Ultrabooks','Chromebooks','2-in-1 Laptops']],
            ['label'=>'Desktops',     'children'=>['All-in-One PCs','Gaming Desktops','Mini PCs','Workstations']],
            ['label'=>'Monitors',     'children'=>['Gaming Monitors','4K Monitors','Curved Monitors','Portable Monitors']],
            ['label'=>'Storage',      'children'=>['External Hard Drives','SSDs','USB Flash Drives','Memory Cards','NAS Devices']],
            ['label'=>'Networking',   'children'=>['Routers','Switches','Network Cards','Modems']],
            ['label'=>'Printers',     'children'=>['Inkjet Printers','Laser Printers','All-in-One Printers','Ink & Toner']],
            ['label'=>'Accessories',  'children'=>['Keyboards','Mice','Webcams','USB Hubs','Laptop Bags']],
        ]],
        ['icon'=>'bi-tv-fill',            'label'=>'TVs & Audio',
         'subs'=>[
            ['label'=>'Televisions',  'children'=>['Smart TVs','OLED TVs','4K UHD TVs','LED TVs','Portable TVs']],
            ['label'=>'Headphones',   'children'=>['Over-Ear','In-Ear Earphones','True Wireless (TWS)','Noise Cancelling','Sports Earphones']],
            ['label'=>'Speakers',     'children'=>['Bluetooth Speakers','Soundbars','Home Theatre','Party Speakers','Studio Monitors']],
            ['label'=>'Hi-Fi Audio',  'children'=>['Amplifiers','Turntables','Receivers','Subwoofers']],
            ['label'=>'Accessories',  'children'=>['Remote Controls','HDMI Cables','Mounts & Brackets','Audio Cables']],
        ]],
        ['icon'=>'bi-camera-fill',        'label'=>'Cameras & Photography',
         'subs'=>[
            ['label'=>'Cameras',      'children'=>['DSLR Cameras','Mirrorless Cameras','Point & Shoot','Action Cameras','Instant Cameras']],
            ['label'=>'Lenses',       'children'=>['Prime Lenses','Zoom Lenses','Macro Lenses','Wide-Angle','Telephoto']],
            ['label'=>'Drones',       'children'=>['Consumer Drones','Professional Drones','FPV Drones','Drone Accessories']],
            ['label'=>'Accessories',  'children'=>['Tripods & Stands','Camera Bags','Lighting','Memory Cards','Filters']],
        ]],
        ['icon'=>'bi-house-heart-fill',   'label'=>'Home Appliances',
         'subs'=>[
            ['label'=>'Cooling',             'children'=>['Air Conditioners','Fans','Air Purifiers','Dehumidifiers']],
            ['label'=>'Refrigerators',       'children'=>['Single Door','Double Door','Side-by-Side','Mini Fridges','Chest Freezers']],
            ['label'=>'Washing',             'children'=>['Front Load Washers','Top Load Washers','Washer Dryers','Dryers','Irons']],
            ['label'=>'Kitchen Appliances',  'children'=>['Microwaves','Ovens','Blenders','Juicers','Electric Kettles','Coffee Makers','Air Fryers']],
            ['label'=>'Cleaning',            'children'=>['Vacuum Cleaners','Robotic Vacuums','Mops','Pressure Washers']],
            ['label'=>'Water & Heating',     'children'=>['Water Dispensers','Water Heaters','Electric Showers','Solar Systems']],
        ]],
        ['icon'=>'bi-controller',         'label'=>'Gaming',
         'subs'=>[
            ['label'=>'Consoles',         'children'=>['PlayStation 5','Xbox Series X/S','Nintendo Switch','Retro Consoles']],
            ['label'=>'Games',            'children'=>['Action & Adventure','Sports Games','RPG','Simulation','Fighting']],
            ['label'=>'PC Gaming',        'children'=>['Gaming Desktops','Gaming Laptops','Gaming Monitors','GPU & CPU']],
            ['label'=>'Peripherals',      'children'=>['Gaming Keyboards','Gaming Mice','Controllers','Gaming Headsets','Mouse Pads']],
            ['label'=>'Gaming Furniture', 'children'=>['Gaming Chairs','Gaming Desks','Controller Stands','Cable Management']],
        ]],
        ['icon'=>'bi-bag-heart-fill',     'label'=>'Fashion',
         'subs'=>[
            ['label'=>"Men's Fashion",   'children'=>["T-Shirts & Polos","Shirts","Trousers & Jeans","Suits & Blazers","Shorts","Underwear & Socks"]],
            ['label'=>"Women's Fashion", 'children'=>["Dresses","Tops & Blouses","Skirts","Jeans & Trousers","Jackets & Coats","Lingerie & Nightwear"]],
            ['label'=>'Kids Fashion',    'children'=>['Boys Clothing','Girls Clothing','Baby Clothing','School Uniforms']],
            ['label'=>'Shoes',           'children'=>["Men's Shoes","Women's Shoes","Kids' Shoes","Sports Shoes","Boots","Sandals"]],
            ['label'=>'Bags & Luggage',  'children'=>['Handbags','Backpacks','Wallets','Suitcases','Travel Bags']],
            ['label'=>'Accessories',     'children'=>['Sunglasses','Belts','Hats & Caps','Scarves','Jewellery','Watches']],
        ]],
        ['icon'=>'bi-heart-pulse-fill',   'label'=>'Health & Beauty',
         'subs'=>[
            ['label'=>'Skincare',          'children'=>['Face Wash','Moisturisers','Sunscreen','Serums & Oils','Masks & Peels']],
            ['label'=>'Makeup',            'children'=>['Foundation & Concealer','Lipstick & Gloss','Eyeshadow','Mascara','Makeup Brushes']],
            ['label'=>'Hair Care',         'children'=>['Shampoo & Conditioner','Hair Oils','Hair Color','Hair Extensions','Hair Tools']],
            ['label'=>'Fragrances',        'children'=>["Men's Perfumes","Women's Perfumes","Body Sprays","Oud & Attar"]],
            ['label'=>'Personal Care',     'children'=>['Dental Care','Deodorants','Shaving','Feminine Hygiene','Cotton & Wipes']],
            ['label'=>'Health & Wellness', 'children'=>['Vitamins & Supplements','Medical Devices','First Aid','Fitness Nutrition','Eye Care']],
        ]],
        ['icon'=>'bi-building-fill',      'label'=>'Home & Office',
         'subs'=>[
            ['label'=>'Furniture',        'children'=>['Sofas & Couches','Beds & Mattresses','Dining Tables','Office Desks','Shelves & Racks','Wardrobes']],
            ['label'=>'Home Decor',       'children'=>['Wall Art & Clocks','Curtains & Blinds','Rugs & Carpets','Cushions & Throws','Vases & Plants']],
            ['label'=>'Bedding & Bath',   'children'=>['Bedsheets','Duvets & Pillows','Towels','Bath Accessories','Mattress Protectors']],
            ['label'=>'Kitchen & Dining', 'children'=>['Cookware','Cutlery','Dinnerware','Glassware','Food Storage','Kitchen Organizers']],
            ['label'=>'Lighting',         'children'=>['Ceiling Lights','Floor Lamps','Desk Lamps','Outdoor Lighting','Smart Lights','LED Strips']],
            ['label'=>'Office Supplies',  'children'=>['Stationery','Printers & Ink','Filing & Storage','Whiteboards','Office Furniture']],
            ['label'=>'Tools & Hardware', 'children'=>['Power Tools','Hand Tools','Safety Equipment','Measuring Tools','Painting Supplies']],
        ]],
        ['icon'=>'bi-emoji-smile-fill',   'label'=>'Baby Products',
         'subs'=>[
            ['label'=>'Feeding',         'children'=>['Baby Formula','Bottles & Nipples','High Chairs','Bibs','Breast Pumps','Baby Food']],
            ['label'=>'Diapering',       'children'=>['Diapers','Baby Wipes','Nappy Bags','Changing Mats']],
            ['label'=>'Baby Clothing',   'children'=>['0-3 Months','3-12 Months','1-3 Years','Baby Shoes','Sleep Suits']],
            ['label'=>'Nursery',         'children'=>['Cribs & Cots','Baby Monitors','Baby Carriers','Bouncers & Swings','Baby Blankets']],
            ['label'=>'Toys & Learning', 'children'=>['Rattles & Teethers','Soft Toys','Educational Toys','Building Blocks','Outdoor Toys']],
            ['label'=>'Travel & Gear',   'children'=>['Prams & Strollers','Car Seats','Baby Bags','Travel Cots']],
        ]],
        ['icon'=>'bi-trophy-fill',        'label'=>'Sporting Goods',
         'subs'=>[
            ['label'=>'Fitness',             'children'=>['Treadmills','Exercise Bikes','Dumbbells & Barbells','Resistance Bands','Yoga Mats','Jump Ropes']],
            ['label'=>'Team Sports',         'children'=>['Football','Basketball','Rugby','Cricket','Volleyball','Hockey']],
            ['label'=>'Outdoor & Adventure', 'children'=>['Hiking Gear','Camping','Cycling','Swimming','Rock Climbing','Fishing']],
            ['label'=>'Combat Sports',       'children'=>['Boxing','MMA & Martial Arts','Wrestling','Punching Bags']],
            ['label'=>'Sportswear',          'children'=>["Men's Sportswear","Women's Sportswear","Running Shoes","Sports Socks","Compression Wear"]],
            ['label'=>'Racket Sports',       'children'=>['Tennis','Badminton','Squash','Table Tennis']],
        ]],
        ['icon'=>'bi-cart4',              'label'=>'Supermarket',
         'subs'=>[
            ['label'=>'Food & Staples', 'children'=>['Rice & Grains','Flour & Baking','Oils & Fats','Spices & Condiments','Pasta & Noodles']],
            ['label'=>'Beverages',      'children'=>['Water & Juices','Soft Drinks','Tea & Coffee','Energy Drinks','Milk & Dairy Drinks']],
            ['label'=>'Snacks',         'children'=>['Chips & Crisps','Biscuits & Cookies','Chocolates & Candy','Nuts & Dried Fruits']],
            ['label'=>'Dairy & Eggs',   'children'=>['Milk','Cheese','Yoghurt','Butter','Eggs']],
            ['label'=>'Household',      'children'=>['Laundry Detergent','Cleaning Liquids','Toilet Paper','Trash Bags','Insect Repellents']],
            ['label'=>'Fresh Produce',  'children'=>['Fruits','Vegetables','Meat & Poultry','Fish & Seafood']],
        ]],
        ['icon'=>'bi-car-front-fill',     'label'=>'Automotive',
         'subs'=>[
            ['label'=>'Car Electronics', 'children'=>['Car Radios & Stereos','GPS & Navigation','Dash Cameras','Reverse Cameras']],
            ['label'=>'Car Accessories', 'children'=>['Seat Covers','Car Mats','Steering Covers','Car Fresheners','Organizers']],
            ['label'=>'Tyres & Wheels',  'children'=>['Car Tyres','Motorcycle Tyres','Alloy Wheels','Wheel Covers']],
            ['label'=>'Car Care',        'children'=>['Car Wash & Wax','Engine Oil','Tyre Polish','Car Covers','Jump Starters']],
            ['label'=>'Motorcycles',     'children'=>['Motorcycle Helmets','Riding Gear','Motorcycle Parts','Motorcycle Accessories']],
        ]],
        ['icon'=>'bi-book-fill',          'label'=>'Books, Music & Movies',
         'subs'=>[
            ['label'=>'Books',       'children'=>['Fiction','Non-Fiction','Academic & Textbooks',"Children's Books",'Comics & Manga','Business & Finance']],
            ['label'=>'Music',       'children'=>['CDs & Vinyl','Musical Instruments','Sheet Music','DJ Equipment','Studio Equipment']],
            ['label'=>'Movies & TV', 'children'=>['DVDs & Blu-ray','Streaming Devices','Projectors','Streaming Subscriptions']],
            ['label'=>'Stationery',  'children'=>['Pens & Pencils','Notebooks','Art Supplies','Craft Supplies']],
        ]],
        ['icon'=>'bi-gear-fill',          'label'=>'Industrial & Scientific',
         'subs'=>[
            ['label'=>'Safety & Security', 'children'=>['CCTV Cameras','Door Locks & Safes','Fire Safety','Safety Helmets','Reflective Gear']],
            ['label'=>'Office Machines',   'children'=>['Shredders','Laminators','Scanners','Label Printers','Cash Registers']],
            ['label'=>'Agriculture',       'children'=>['Pesticides','Fertilisers','Garden Tools','Irrigation','Seeds']],
            ['label'=>'Lab & Science',     'children'=>['Microscopes','Lab Equipment','Measurement Tools','Chemistry Supplies']],
            ['label'=>'Electrical',        'children'=>['Cables & Wires','Sockets & Switches','Circuit Breakers','Solar & Inverters']],
        ]],
    ];
    @endphp

    @foreach($categories as $ci => $cat)
    <div class="cat-row" onclick="toggleCat(this)" data-ci="{{ $ci }}">
        <div class="cat-row__left">
            <div class="cat-icon"><i class="bi {{ $cat['icon'] }}"></i></div>
            <span class="cat-row__label">{{ $cat['label'] }}</span>
        </div>
        <i class="bi bi-chevron-down cat-arrow"></i>
    </div>

    <div class="sub-menu" id="sub-{{ $ci }}">
        @foreach($cat['subs'] as $si => $sub)
        <div class="sub-row" onclick="toggleSub(this,event)" data-si="{{ $ci }}-{{ $si }}">
            <span class="sub-row__label">{{ $sub['label'] }}</span>
            @if(!empty($sub['children']))
            <i class="bi bi-chevron-right sub-arrow"></i>
            @endif
        </div>
        @if(!empty($sub['children']))
        <div class="child-menu" id="child-{{ $ci }}-{{ $si }}">
            @foreach($sub['children'] as $child)
            <a href="#" class="child-item">{{ $child }}</a>
            @endforeach
        </div>
        @endif
        @endforeach
    </div>
    @endforeach

</aside>

<script>
function toggleCat(row) {
    const ci = row.dataset.ci, isOpen = row.classList.contains('open');
    document.querySelectorAll('.cat-row.open').forEach(r => {
        r.classList.remove('open');
        const sm = document.getElementById('sub-' + r.dataset.ci);
        if (sm) { sm.classList.remove('open');
            sm.querySelectorAll('.sub-row.open').forEach(sr => {
                sr.classList.remove('open');
                const cm = document.getElementById('child-' + sr.dataset.si);
                if (cm) cm.classList.remove('open');
            });
        }
    });
    if (!isOpen) { row.classList.add('open'); document.getElementById('sub-'+ci)?.classList.add('open'); }
}

function toggleSub(row, e) {
    e.stopPropagation();
    const si = row.dataset.si, childMenu = document.getElementById('child-'+si);
    if (!childMenu) return;
    const isOpen = row.classList.contains('open');
    row.closest('.sub-menu')?.querySelectorAll('.sub-row.open').forEach(sr => {
        sr.classList.remove('open');
        document.getElementById('child-'+sr.dataset.si)?.classList.remove('open');
    });
    if (!isOpen) { row.classList.add('open'); childMenu.classList.add('open'); }
}
</script>
