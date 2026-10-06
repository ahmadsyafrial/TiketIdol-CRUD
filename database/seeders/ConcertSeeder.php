<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Concert;
use App\Models\TicketCategory;
use App\Models\Promo;
use App\Models\Order;
use App\Models\OrderAttendee;
use Carbon\Carbon;

class ConcertSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BABYMONSTER
        $bm = Concert::create([
            'title' => 'BABYMONSTER 1ST WORLD TOUR <HELLO MONSTERS> IN JAKARTA',
            'slug' => 'babymonster-hello-monsters-jakarta-2026',
            'artist_name' => 'BABYMONSTER',
            'fandom_name' => 'MONSTIEZ',
            'venue_name' => 'ICE BSD City Hall 5-6',
            'city' => 'Tangerang / Jakarta',
            'concert_date' => Carbon::now()->addDays(45)->setHour(19)->setMinute(0)->setSecond(0),
            'gate_open_time' => '15:30 WIB (Soundcheck 16:30 WIB)',
            'poster_url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=800&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1600&q=80',
            'description' => "Ruka, Pharita, Asa, Ahyeon, Rami, Rora, dan Chiquita siap mengguncang Jakarta dalam tur dunia perdana mereka 'HELLO MONSTERS'! Bersiaplah untuk menyaksikan penampilan memukau dengan vokal live bertenaga dan koreografi spektakuler khas YG Entertainment. Tiket resmi hanya tersedia melalui platform tiket konser resmi ini.",
            'terms_conditions' => "1. Maksimal pembelian 4 tiket per akun / NIK KTP.\n2. Nama pemesan harus sesuai dengan kartu identitas resmi (KTP/Paspor/SIM).\n3. Penukaran wristband wajib membawa e-voucher dan kartu identitas asli.\n4. Kategori Standing (Festival) akan mendapatkan Nomor Antrian (Queue Number) secara otomatis.\n5. Kategori Seated akan mendapatkan Nomor Kursi (Seat Number) otomatis.\n6. Dilarang membawa kamera profesional, laser pointer, tripod, dan senjata tajam.",
            'promoter_name' => 'YG Entertainment x Live Nation Indonesia',
            'status' => 'active',
            'is_featured' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $bm->id,
            'name' => 'VIP SOUNDCHECK PACKAGE',
            'code' => 'VIP-SND',
            'type' => 'standing',
            'color_hex' => '#ec4899', // Bright Pink
            'price' => 3550000,
            'quota' => 300,
            'available_quota' => 84,
            'benefits' => "Akses Soundcheck Party Eksklusif\nVIP Fast Track Gate Entry\nOfficial Commemorative PVC Lanyard & Pass\nExclusive Merchandise Line Access\nStanding Festival Barisan Paling Depan",
            'entry_gate' => 'Gate VIP East',
            'seat_section' => 'Zone A - Stage Front',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $bm->id,
            'name' => 'CAT 1 - FESTIVAL (STANDING)',
            'code' => 'CAT1-STD',
            'type' => 'standing',
            'color_hex' => '#8b5cf6', // Purple
            'price' => 2650000,
            'quota' => 800,
            'available_quota' => 215,
            'benefits' => "Akses Festival Standing dekat Extended Stage\nQueue Number (Nomor Antrean) otomatis\nOfficial Souvenir Photocard Set",
            'entry_gate' => 'Gate 1 Hall 5',
            'seat_section' => 'Zone B - Center Festival',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $bm->id,
            'name' => 'CAT 2 - CENTER TRIBUNE (NUMBERED SEAT)',
            'code' => 'CAT2-SEAT',
            'type' => 'seated',
            'color_hex' => '#3b82f6', // Blue
            'price' => 2150000,
            'quota' => 600,
            'available_quota' => 140,
            'benefits' => "Tempat Duduk Bernomor (Numbered Seating)\nPandangan Tengah ke Panggung Utama\nOfficial Tour Souvenir Card",
            'entry_gate' => 'Gate 2 Hall 6',
            'seat_section' => 'Tribune Center Row A-P',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $bm->id,
            'name' => 'CAT 3 - TRIBUNE WING (NUMBERED SEAT)',
            'code' => 'CAT3-SEAT',
            'type' => 'seated',
            'color_hex' => '#10b981', // Emerald Green
            'price' => 1550000,
            'quota' => 500,
            'available_quota' => 95,
            'benefits' => "Tempat Duduk Bernomor (Wing Area)\nSuasana Konser Penuh Euforia\nE-Ticket Validated",
            'entry_gate' => 'Gate 3 Hall 6',
            'seat_section' => 'Tribune Wing Left & Right',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $bm->id,
            'name' => 'CAT 4 - UPPER TRIBUNE (NUMBERED SEAT)',
            'code' => 'CAT4-UPP',
            'type' => 'seated',
            'color_hex' => '#f59e0b', // Amber
            'price' => 1100000,
            'quota' => 400,
            'available_quota' => 48,
            'benefits' => "Pilihan Ramah Kantong\nTempat Duduk Bernomor\nSound System High Definition",
            'entry_gate' => 'Gate 4 Hall 6',
            'seat_section' => 'Upper Tribune',
            'is_active' => true,
        ]);

        // 2. AESPA
        $aespa = Concert::create([
            'title' => 'aespa LIVE TOUR 2026 – SYNK : PARALLEL LINE IN JAKARTA',
            'slug' => 'aespa-synk-parallel-line-jakarta-2026',
            'artist_name' => 'aespa',
            'fandom_name' => 'MY',
            'venue_name' => 'Indonesia Arena, GBK Senayan',
            'city' => 'Jakarta Pusat',
            'concert_date' => Carbon::now()->addDays(60)->setHour(18)->setMinute(30)->setSecond(0),
            'gate_open_time' => '15:00 WIB',
            'poster_url' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=800&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1429962714451-bb934ecdc4ec?auto=format&fit=crop&w=1600&q=80',
            'description' => "Karina, Giselle, Winter, dan Ningning kembali ke Jakarta membawa konsep multiverse futuristik SYNK: PARALLEL LINE! Nikmati penampilan lagu-lagu hits seperti Supernova, Armageddon, Drama, Next Level, dan penampilan solo masing-masing member.",
            'terms_conditions' => "1. Tiket tidak dapat dipindahtangankan tanpa surat kuasa bermaterai Rp 10.000.\n2. Pemegang tiket kategori standing di bawah usia 14 tahun wajib didampingi orang tua.\n3. Satu akun dapat memesan maksimal 4 tiket.",
            'promoter_name' => 'SM Entertainment x iMe Indonesia',
            'status' => 'active',
            'is_featured' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $aespa->id,
            'name' => 'VIP SOUNDCHECK + SEND-OFF',
            'code' => 'AES-VIP',
            'type' => 'standing',
            'color_hex' => '#a855f7',
            'price' => 3450000,
            'quota' => 250,
            'available_quota' => 60,
            'benefits' => "Soundcheck Party Pass\nSend-Off Event Exclusive Access\nSpecial Commemorative Lanyard\nDedicated Entrance",
            'entry_gate' => 'Gate VIP Main Arena',
            'seat_section' => 'VIP Floor Center',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $aespa->id,
            'name' => 'CAT 1 - FESTIVAL (STANDING)',
            'code' => 'AES-CAT1',
            'type' => 'standing',
            'color_hex' => '#06b6d4',
            'price' => 2550000,
            'quota' => 600,
            'available_quota' => 180,
            'benefits' => "Standing Area Dekat Panggung\nNomor Antrian Masuk Otomatis\nOfficial Tour Poster",
            'entry_gate' => 'Gate 1 Floor',
            'seat_section' => 'Festival Left & Right',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $aespa->id,
            'name' => 'CAT 2 - LOWER TRIBUNE (NUMBERED SEAT)',
            'code' => 'AES-CAT2',
            'type' => 'seated',
            'color_hex' => '#3b82f6',
            'price' => 2100000,
            'quota' => 700,
            'available_quota' => 230,
            'benefits' => "Kursi Bernomor Lantai 1 Indonesia Arena\nJarak Pandang Optimal ke Visual Panggung\nOfficial Postcard Set",
            'entry_gate' => 'Gate 2 Tribune',
            'seat_section' => 'Lower Tribune',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $aespa->id,
            'name' => 'CAT 3 - UPPER TRIBUNE (NUMBERED SEAT)',
            'code' => 'AES-CAT3',
            'type' => 'seated',
            'color_hex' => '#10b981',
            'price' => 1300000,
            'quota' => 500,
            'available_quota' => 110,
            'benefits' => "Kursi Bernomor Lantai 2\nPanoramic Stage & Lightstick View\nTiket Resmi",
            'entry_gate' => 'Gate 3 Tribune',
            'seat_section' => 'Upper Tribune',
            'is_active' => true,
        ]);

        // 3. NewJeans
        $nj = Concert::create([
            'title' => 'NewJeans <BUNNIES CAMP> SPECIAL EDITION IN JAKARTA',
            'slug' => 'newjeans-bunnies-camp-jakarta-2026',
            'artist_name' => 'NewJeans',
            'fandom_name' => 'Bunnies',
            'venue_name' => 'Beach City International Stadium (BCIS)',
            'city' => 'Ancol, Jakarta Utara',
            'concert_date' => Carbon::now()->addDays(75)->setHour(19)->setMinute(0)->setSecond(0),
            'gate_open_time' => '16:00 WIB',
            'poster_url' => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?auto=format&fit=crop&w=800&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1501386761578-eac5c94b800a?auto=format&fit=crop&w=1600&q=80',
            'description' => "Minji, Hanni, Danielle, Haerin, dan Hyein siap menyapa Bunnies Indonesia! Kemeriahan BUNNIES CAMP menghadirkan aransemen panggung festival bertema retro-pop nostalgia dengan lagu-lagu hits Hype Boy, Ditto, OMG, Super Shy, hingga How Sweet.",
            'terms_conditions' => "1. Pembelian dibatasi maksimal 4 tiket per identitas.\n2. E-voucher ber-barcode wajib ditukar menjadi gelang festival pada H-2 konser.\n3. Anak di bawah umur 12 tahun wajib bersama pendamping.",
            'promoter_name' => 'ADOR x Mecimapro',
            'status' => 'active',
            'is_featured' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $nj->id,
            'name' => 'BUNNIES VIP EXPERIENCE',
            'code' => 'NJ-VIP',
            'type' => 'standing',
            'color_hex' => '#38bdf8',
            'price' => 3350000,
            'quota' => 200,
            'available_quota' => 45,
            'benefits' => "Soundcheck Party Pass\nExclusive Bunnies Camp Camp Badge & Lanyard\nFast Track Gate & Dedicated Merchandise Lane",
            'entry_gate' => 'Gate VIP Ocean',
            'seat_section' => 'VIP Camp Zone Front',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $nj->id,
            'name' => 'CAT 1 - FESTIVAL (STANDING)',
            'code' => 'NJ-CAT1',
            'type' => 'standing',
            'color_hex' => '#f43f5e',
            'price' => 2450000,
            'quota' => 500,
            'available_quota' => 120,
            'benefits' => "Festival Standing Area\nNomor Antrian Masuk Resmi\nOfficial Special Photocard",
            'entry_gate' => 'Gate 1 Hall',
            'seat_section' => 'Festival Ground',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $nj->id,
            'name' => 'CAT 2 - TRIBUNE SEATED (NUMBERED)',
            'code' => 'NJ-CAT2',
            'type' => 'seated',
            'color_hex' => '#8b5cf6',
            'price' => 1850000,
            'quota' => 450,
            'available_quota' => 160,
            'benefits' => "Numbered Seated dengan pemandangan panggung penuh\nAC Dingin & Nyaman\nE-Ticket Digital",
            'entry_gate' => 'Gate 2 Balcony',
            'seat_section' => 'Tier 2 Seating',
            'is_active' => true,
        ]);

        // 4. IU
        $iu = Concert::create([
            'title' => '2026 IU HEREH WORLD TOUR CONCERT ENCORE IN JAKARTA',
            'slug' => 'iu-hereh-world-tour-encore-jakarta-2026',
            'artist_name' => 'IU (Lee Ji-eun)',
            'fandom_name' => 'UAENA',
            'venue_name' => 'Indonesia Convention Exhibition (ICE) BSD',
            'city' => 'Tangerang',
            'concert_date' => Carbon::now()->addDays(90)->setHour(19)->setMinute(0)->setSecond(0),
            'gate_open_time' => '16:00 WIB',
            'poster_url' => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?auto=format&fit=crop&w=800&q=80',
            'banner_url' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=1600&q=80',
            'description' => "Sang diva K-Pop IU kembali menyapa UAENA Indonesia dengan panggung megah konser encore HEREH World Tour. Saksikan vokal magis 3 oktaf live orchestra dalam durasi 3 jam lebih penuh kenangan tak terlupakan.",
            'terms_conditions' => "1. Seluruh kategori adalah SEATED (Tempat Duduk Bernomor).\n2. Dilarang merekam menggunakan kamera profesional.\n3. Maksimal 2 tiket per identitas.",
            'promoter_name' => 'EDAM Entertainment x CK Star Entertainment',
            'status' => 'active',
            'is_featured' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $iu->id,
            'name' => 'VIP PLATINUM (NUMBERED SEATING)',
            'code' => 'IU-VIP',
            'type' => 'seated',
            'color_hex' => '#e11d48',
            'price' => 3850000,
            'quota' => 300,
            'available_quota' => 50,
            'benefits' => "Best Center VIP Seating\nExclusive Soundcheck Session\nOfficial Tour MD Set & Souvenir Cushion",
            'entry_gate' => 'Gate Platinum VIP',
            'seat_section' => 'VIP Floor Rows A-L',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $iu->id,
            'name' => 'CAT 1 - GOLD (NUMBERED SEATING)',
            'code' => 'IU-CAT1',
            'type' => 'seated',
            'color_hex' => '#d97706',
            'price' => 2950000,
            'quota' => 500,
            'available_quota' => 140,
            'benefits' => "Lower Tribune Center Seating\nClear Unobstructed View\nSouvenir Photocard",
            'entry_gate' => 'Gate 1 Hall',
            'seat_section' => 'Gold Section',
            'is_active' => true,
        ]);

        TicketCategory::create([
            'concert_id' => $iu->id,
            'name' => 'CAT 2 - SILVER (NUMBERED SEATING)',
            'code' => 'IU-CAT2',
            'type' => 'seated',
            'color_hex' => '#2563eb',
            'price' => 2100000,
            'quota' => 600,
            'available_quota' => 200,
            'benefits' => "Wing Seating Tribune\nNumbered Seating\nDigital Ticket",
            'entry_gate' => 'Gate 2 Hall',
            'seat_section' => 'Silver Section',
            'is_active' => true,
        ]);

        // PROMOS
        Promo::create([
            'code' => 'BABYMONSTERID',
            'title' => 'Diskon Spesial Fans BABYMONSTER 10%',
            'discount_percentage' => 10,
            'discount_amount' => 0,
            'min_purchase' => 1000000,
            'max_discount' => 250000,
            'valid_until' => Carbon::now()->addMonths(3),
            'is_active' => true,
        ]);

        Promo::create([
            'code' => 'MONSTIEZVIP',
            'title' => 'Diskon Eksklusif MONSTIEZ Rp 100.000',
            'discount_percentage' => 0,
            'discount_amount' => 100000,
            'min_purchase' => 2000000,
            'max_discount' => 100000,
            'valid_until' => Carbon::now()->addMonths(3),
            'is_active' => true,
        ]);

        Promo::create([
            'code' => 'TIKETIDOL50',
            'title' => 'Potongan Langsung Rp 50.000 Semua Konser',
            'discount_percentage' => 0,
            'discount_amount' => 50000,
            'min_purchase' => 500000,
            'max_discount' => 50000,
            'valid_until' => Carbon::now()->addMonths(6),
            'is_active' => true,
        ]);

        // Sample Completed Order for testing Check Booking & E-Ticket
        $bmCategory = TicketCategory::where('concert_id', $bm->id)->where('code', 'VIP-SND')->first();
        $sampleOrder = Order::create([
            'order_code' => 'TK-BBM-2026-9824',
            'concert_id' => $bm->id,
            'ticket_category_id' => $bmCategory->id,
            'quantity' => 2,
            'customer_name' => 'Ahmad Syafrial Pratama',
            'customer_email' => 'ahmadsyafrial@gmail.com',
            'customer_phone' => '081298765432',
            'customer_nik' => '3276012809980003',
            'subtotal_price' => 7100000,
            'tax_fee' => 710000, // 10%
            'admin_fee' => 20000,
            'discount_amount' => 250000,
            'promo_code' => 'BABYMONSTERID',
            'total_price' => 7580000,
            'payment_method' => 'qris',
            'payment_status' => 'paid',
            'payment_deadline' => Carbon::now()->addHour(),
            'paid_at' => Carbon::now()->subMinutes(15),
            'notes' => 'Pesanan tiket konser BABYMONSTER via QRIS',
        ]);

        OrderAttendee::create([
            'order_id' => $sampleOrder->id,
            'ticket_number' => 'ETK-BBM-VIP-001',
            'attendee_name' => 'Ahmad Syafrial Pratama',
            'attendee_nik' => '3276012809980003',
            'attendee_email' => 'ahmadsyafrial@gmail.com',
            'seat_or_queue_number' => 'VIP-QN-0042',
            'barcode_code' => 'ETK9824001',
            'check_in_status' => 'pending',
        ]);

        OrderAttendee::create([
            'order_id' => $sampleOrder->id,
            'ticket_number' => 'ETK-BBM-VIP-002',
            'attendee_name' => 'Nurul Aini Lestari',
            'attendee_nik' => '3276014402990005',
            'attendee_email' => 'nurulaini@gmail.com',
            'seat_or_queue_number' => 'VIP-QN-0043',
            'barcode_code' => 'ETK9824002',
            'check_in_status' => 'pending',
        ]);
    }
}
