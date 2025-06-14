function ProductCard({ product, index }) {
    try {
        const formatPrice = (price) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(price);
        };

        const handleBuyClick = () => {
            const message = `Halo, saya tertarik dengan produk ${product.name}. Bisa info lebih lanjut?`;
            const whatsappUrl = `https://wa.me/6281234567890?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        };

        return (
            <div 
                className="bg-white rounded-lg md:rounded-xl shadow-lg card-hover fade-in overflow-hidden"
                style={{ animationDelay: `${index * 0.1}s` }}
                data-name="product-card"
                data-file="components/ProductCard.js"
            >
                <div className="relative overflow-hidden">
                    <img
                        src={product.image}
                        alt={product.name}
                        className="w-full h-32 md:h-48 object-cover transition-transform duration-300 hover:scale-110"
                    />
                    <div className="absolute top-2 right-2 bg-red-500 text-white px-1.5 py-0.5 md:px-2 md:py-1 rounded-full text-xs font-semibold">
                        Hot
                    </div>
                </div>
                <div className="p-2 md:p-4">
                    <h3 className="font-semibold text-sm md:text-lg text-gray-800 mb-1 md:mb-2 line-clamp-2">
                        {product.name}
                    </h3>
                    <div className="flex items-center mb-2 md:mb-3">
                        {[...Array(5)].map((_, i) => (
                            <i key={i} className="fas fa-star star-rating text-xs md:text-sm"></i>
                        ))}
                        <span className="text-gray-600 text-xs md:text-sm ml-1 md:ml-2">(5.0)</span>
                    </div>
                    <div className="text-lg md:text-2xl font-bold text-red-600 mb-2 md:mb-4">
                        {formatPrice(product.price)}
                    </div>
                    <button
                        onClick={handleBuyClick}
                        className="w-full btn-gradient text-white py-2 md:py-3 px-2 md:px-4 rounded-lg font-semibold text-xs md:text-sm"
                    >
                        <i className="fab fa-whatsapp mr-1 md:mr-2"></i>
                        Beli Sekarang
                    </button>
                </div>
            </div>
        );
    } catch (error) {
        console.error('ProductCard component error:', error);
        reportError(error);
        return null;
    }
}
