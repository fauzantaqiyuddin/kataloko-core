function App() {
    const [products, setProducts] = React.useState([]);
    const [filteredProducts, setFilteredProducts] = React.useState([]);
    const [sellerInfo, setSellerInfo] = React.useState({
        name: "",
        description: "",
        location: "",
        avatar: ""
    });

    // Fetch data dari backend
    React.useEffect(() => {
        const pathSegments = window.location.pathname.split("/");
        const slug = pathSegments[2];

        fetch(`http://127.0.0.1:8000/t/${slug}/mock`)
            .then((response) => response.json())
            .then((result) => {
                setSellerInfo(result.seller);
                setProducts(result.products);
                setFilteredProducts(result.products);
            })
            .catch((error) => {
                console.error("Fetch error:", error);
            });
    }, []);

    // Update title kalau sellerInfo berubah
    React.useEffect(() => {
        if (sellerInfo.name) {
            document.title = `${sellerInfo.name} - Bio Link Product`;
        }
    }, [sellerInfo]);

    const handleSearch = (searchTerm) => {
        if (!searchTerm.trim()) {
            setFilteredProducts(products);
        } else {
            const filtered = products.filter((product) =>
                product.name.toLowerCase().includes(searchTerm.toLowerCase())
            );
            setFilteredProducts(filtered);
        }
    };

    return (
        <div className="min-h-screen bg-gray-50">
            <Header sellerInfo={sellerInfo} onSearch={handleSearch} />
            <ProductGrid products={filteredProducts} />
            <CallToAction />
            <footer className="bg-gray-800 text-white py-8 px-4 text-center">
                <div className="max-w-4xl mx-auto">
                    <p className="text-sm opacity-80">
                        © 2024 {sellerInfo.name}. Semua hak dilindungi.
                    </p>
                    <div className="mt-4 space-x-4">
                        <a href="#" className="text-red-400 hover:text-red-300 transition-colors">
                            <i className="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" className="text-red-400 hover:text-red-300 transition-colors">
                            <i className="fab fa-whatsapp text-xl"></i>
                        </a>
                        <a href="#" className="text-red-400 hover:text-red-300 transition-colors">
                            <i className="fab fa-facebook text-xl"></i>
                        </a>
                    </div>
                </div>
            </footer>
            <StickyBottomButton />
        </div>
    );
}

ReactDOM.render(<App />, document.getElementById("root"));
