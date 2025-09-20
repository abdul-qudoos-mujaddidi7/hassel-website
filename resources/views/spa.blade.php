<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- SEO Meta Tags -->
        <title>Mount Agro Microfinance Institution - Empowering Afghan Farmers</title>
        <meta name="description" content="Mount Agro Microfinance Institution provides innovative microfinance solutions, training programs, and agricultural support to farmers across Afghanistan. Building stronger, more resilient farming communities.">
        <meta name="keywords" content="Afghanistan microfinance, agricultural loans, farming support, rural development, microfinance institution, agricultural training, crop financing, livestock financing, Afghanistan agriculture">
        <meta name="author" content="Mount Agro Microfinance Institution">
        <meta name="robots" content="index, follow">
        <meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="Mount Agro Microfinance Institution - Empowering Afghan Farmers">
        <meta property="og:description" content="Providing innovative microfinance solutions and agricultural support to farmers across Afghanistan. Join us in building stronger farming communities.">
        <meta property="og:image" content="{{ asset('mountagro-logo.jpg') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:site_name" content="Mount Agro Microfinance Institution">
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
        
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="Mount Agro Microfinance Institution - Empowering Afghan Farmers">
        <meta property="twitter:description" content="Providing innovative microfinance solutions and agricultural support to farmers across Afghanistan.">
        <meta property="twitter:image" content="{{ asset('mountagro-logo.jpg') }}">
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mountagro-logo.jpg') }}">
        
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
            "@type" => "FinancialService",
            "name" => "Mount Agro Microfinance Institution",
            "description" => "Microfinance institution providing agricultural loans and support services to farmers in Afghanistan",
            "url" => url('/'),
            "logo" => asset('mountagro-logo.jpg'),
            "image" => asset('mountagro-logo.jpg'),
            "address" => [
                "@type" => "PostalAddress",
                "addressCountry" => "AF",
                "addressLocality" => "Afghanistan"
            ],
            "serviceType" => "Microfinance",
            "areaServed" => [
                "@type" => "Country",
                "name" => "Afghanistan"
            ],
            "hasOfferCatalog" => [
                "@type" => "OfferCatalog",
                "name" => "Financial Services",
                "itemListElement" => [
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "FinancialProduct",
                            "name" => "Agricultural Loans",
                            "description" => "Microfinance loans for crop production and agricultural equipment"
                        ]
                    ],
                    [
                        "@type" => "Offer", 
                        "itemOffered" => [
                            "@type" => "EducationalOccupationalProgram",
                            "name" => "Agricultural Training Programs",
                            "description" => "Comprehensive training programs for modern farming techniques"
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
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>
