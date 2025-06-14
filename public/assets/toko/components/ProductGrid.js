function ProductGrid({ products }) {
    try {
        return (
            <div 
                className="max-w-6xl mx-auto px-4 py-8"
                data-name="product-grid"
                data-file="components/ProductGrid.js"
            >
                <div className="text-center mb-8">
                    <h2 className="text-2xl md:text-3xl font-bold text-gray-800 mb-3">
                        Produk Unggulan Kami
                    </h2>
                    <p className="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">
                        Temukan koleksi produk berkualitas tinggi dengan harga terjangkau. 
                        Semua produk telah terjamin kualitasnya dan siap dikirim ke seluruh Indonesia.
                    </p>
                </div>
                
                {products.length === 0 ? (
                    <div className="text-center py-12">
                        <i className="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <p className="text-gray-500">Produk tidak ditemukan</p>
                    </div>
                ) : (
                    <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
                        {products.map((product, index) => (
                            <ProductCard 
                                key={product.id} 
                                product={product} 
                                index={index}
                            />
                        ))}
                    </div>
                )}
            </div>
        );
    } catch (error) {
        console.error('ProductGrid component error:', error);
        reportError(error);
        return null;
    }
}
