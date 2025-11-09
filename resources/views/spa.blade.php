<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>Mount Agro Agricultural Services</title>
    <meta name="description" content="Mount Agro Agricultural Services provides innovative agricultural solutions, training programs, and support to Afghan farmers. Empowering agriculture through sustainability, innovation, and community development.">
    <meta name="keywords" content="Afghanistan agriculture, agricultural services, farming support, rural development, sustainable agriculture, agricultural training, crop management, livestock support, farm innovation, Mount Agro">
    <meta name="author" content="Mount Agro Agricultural Services">
    <meta name="robots" content="index, follow">
    <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="theme-color" content="#2f855a">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/mountagro-logo.jpg" >
    <link rel="apple-touch-icon" sizes="180x180" href="/mountagro-logo.jpg" >

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Mount Agro Agricultural Services - Empowering Afghan Farmers">
    <meta property="og:description" content="Mount Agro Agricultural Services provides innovative agricultural solutions, training programs, and support to farmers across Afghanistan.">
    <meta property="og:image" content="{{ asset('mountagro-logo.jpg') }}">
    <meta property="og:image:alt" content="Mount Agro Agricultural Services Logo">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Mount Agro Agricultural Services">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Mount Agro Agricultural Services - Empowering Afghan Farmers">
    <meta name="twitter:description" content="Providing innovative agricultural services and training programs for Afghan farmers.">
    <meta name="twitter:image" content="{{ asset('mountagro-logo.jpg') }}">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    @php
    echo json_encode([
        "@context" => "https://schema.org",
        "@type" => "Organization",
        "name" => "Mount Agro Agricultural Services",
        "description" => "Mount Agro Agricultural Services provides innovative agricultural solutions, training programs, and community support to farmers in Afghanistan.",
        "url" => url('/'),
        "logo" => asset('mountagro-logo.jpg'),
        "image" => asset('mountagro-logo.jpg'),
        "address" => [
            "@type" => "PostalAddress",
            "addressCountry" => "AF",
            "addressLocality" => "Afghanistan"
        ],
        "areaServed" => [
            "@type" => "Country",
            "name" => "Afghanistan"
        ],
        "hasOfferCatalog" => [
            "@type" => "OfferCatalog",
            "name" => "Agricultural Services",
            "itemListElement" => [
                [
                    "@type" => "Offer",
                    "itemOffered" => [
                        "@type" => "Service",
                        "name" => "Agricultural Support & Consultation",
                        "description" => "Professional consulting and technical assistance to improve farming productivity and sustainability."
                    ]
                ],
                [
                    "@type" => "Offer", 
                    "itemOffered" => [
                        "@type" => "EducationalOccupationalProgram",
                        "name" => "Agricultural Training Programs",
                        "description" => "Comprehensive training for modern farming, irrigation, and crop management techniques."
                    ]
                ],
                [
                    "@type" => "Offer", 
                    "itemOffered" => [
                        "@type" => "Service",
                        "name" => "Farm Equipment & Resource Access",
                        "description" => "Providing access to essential farming equipment and agricultural resources."
                    ]
                ]
            ]
        ],
        "sameAs" => [
            "https://www.facebook.com/mountagro",
            "https://www.linkedin.com/company/mountagro"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    @endphp
    </script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app"></div>

    <noscript>
        <strong>We're sorry, but Mount Agro Agricultural Services' website requires JavaScript to function properly. Please enable JavaScript to continue.</strong>
    </noscript>
</body>
</html>
