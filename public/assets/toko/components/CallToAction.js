function CallToAction() {
    try {
        const handleCreateBioLink = () => {
            alert('Fitur pembuatan bio link akan segera hadir! Hubungi kami untuk info lebih lanjut.');
        };

        return (
            <div 
                className="bg-gradient-to-r from-red-50 to-white py-16 px-4"
                data-name="call-to-action"
                data-file="components/CallToAction.js"
            >
                <div className="max-w-4xl mx-auto text-center">
                    <div className="mb-8">
                        <i className="fas fa-rocket text-6xl text-red-500 mb-6 pulse-animation"></i>
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                            Ingin Membuat Bio Link Seperti Ini?
                        </h2>
                        <p className="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                            Tingkatkan penjualan UMKM Anda dengan bio link produk yang menarik dan profesional. 
                            Mudah dibuat, mudah dibagikan, dan efektif untuk meningkatkan konversi.
                        </p>
                    </div>
                    <div className="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
                        <button
                            onClick={handleCreateBioLink}
                            className="btn-gradient text-white py-4 px-8 rounded-xl font-semibold text-lg w-full md:w-auto"
                        >
                            <i className="fas fa-plus mr-2"></i>
                            Buat Bio Link Gratis
                        </button>
                        <button className="bg-white text-red-600 border-2 border-red-600 py-4 px-8 rounded-xl font-semibold text-lg hover:bg-red-50 transition-colors w-full md:w-auto">
                            <i className="fas fa-info-circle mr-2"></i>
                            Pelajari Lebih Lanjut
                        </button>
                    </div>
                </div>
            </div>
        );
    } catch (error) {
        console.error('CallToAction component error:', error);
        reportError(error);
        return null;
    }
}
