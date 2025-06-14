function Header({ sellerInfo, onSearch }) {
    try {
        const [searchTerm, setSearchTerm] = React.useState('');

        const handleSearchChange = (e) => {
            const value = e.target.value;
            setSearchTerm(value);
            onSearch(value);
        };

        return (
            <div 
                className="sticky top-0 z-50 bg-white shadow-lg border-b border-gray-200"
                data-name="header"
                data-file="components/Header.js"
            >
                <div className="max-w-6xl mx-auto px-4 py-3">
                    <div className="flex items-center justify-between gap-4">
                        <div className="flex items-center gap-3">
                            <img
                                src={sellerInfo.avatar}
                                alt={sellerInfo.name}
                                className="w-10 h-10 rounded-lg object-cover shadow-md"
                            />
                            <div className="hidden sm:block">
                                <h1 className="text-lg font-bold text-gray-800">
                                    {sellerInfo.name}
                                </h1>
                                <p className="text-xs text-gray-600">
                                    {sellerInfo.location}
                                </p>
                            </div>
                        </div>
                        
                        <div className="flex-1 max-w-md">
                            <div className="relative">
                                <input
                                    type="text"
                                    placeholder="Cari produk..."
                                    value={searchTerm}
                                    onChange={handleSearchChange}
                                    className="w-full px-4 py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                />
                                <i className="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    } catch (error) {
        console.error('Header component error:', error);
        reportError(error);
        return null;
    }
}
