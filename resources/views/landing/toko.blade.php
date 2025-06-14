<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bio Link Product - UMKM Digital Store</title>
    <meta name="description" content="Tampilkan produk UMKM Anda dengan bio link yang menarik dan profesional">
    <meta name="keywords" content="bio link, UMKM, produk, toko online, digital store">
    <meta property="og:title" content="Bio Link Product - UMKM Digital Store">
    <meta property="og:description" content="Tampilkan produk UMKM Anda dengan bio link yang menarik dan profesional">
    <meta name="twitter:title" content="Bio Link Product - UMKM Digital Store">
    <meta name="twitter:description" content="Tampilkan produk UMKM Anda dengan bio link yang menarik dan profesional">

    <script src="{{ asset('assets/toko/assets/js/react.js') }}"></script>
    <script src="{{ asset('assets/toko/assets/js/react-dom.js') }}"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/toko/styles.css') }}" rel="stylesheet">
</head>

<body>
    <div id="root"></div>
    <script type="text/babel" src="{{asset('assets/toko/components/Header.js')}}"></script>
    <script type="text/babel" src="{{asset('assets/toko/components/ProductCard.js')}}"></script>
    <script type="text/babel" src="{{asset('assets/toko/components/ProductGrid.js')}}"></script>
    <script type="text/babel" src="{{asset('assets/toko/components/CallToAction.js')}}"></script>
    <script type="text/babel" src="{{asset('assets/toko/components/StickyBottomButton.js')}}"></script>
    <script type="text/babel" src="{{asset('assets/toko/utils/mockData.js')}}"></script>
    <script type="text/babel" src="{{asset('assets/toko/app.js')}}"></script>
</body>

</html>
