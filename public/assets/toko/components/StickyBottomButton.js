function StickyBottomButton() {
    try {
        const [isVisible, setIsVisible] = React.useState(true);

        React.useEffect(() => {
            const handleScroll = () => {
                const footer = document.querySelector('footer');
                if (footer) {
                    const footerRect = footer.getBoundingClientRect();
                    const windowHeight = window.innerHeight;
                    
                    // Hide button when footer is visible
                    setIsVisible(footerRect.top > windowHeight);
                }
            };

            window.addEventListener('scroll', handleScroll);
            return () => window.removeEventListener('scroll', handleScroll);
        }, []);

        const handleCreateBioLink = () => {
            alert('Fitur pembuatan bio link akan segera hadir! Hubungi kami untuk info lebih lanjut.');
        };

        return (
            <div 
                className={`fixed bottom-0 left-0 right-0 z-40 p-4 bg-white border-t border-gray-200 shadow-lg md:hidden transition-transform duration-300 ${
                    isVisible ? 'translate-y-0' : 'translate-y-full'
                }`}
                data-name="sticky-bottom-button"
                data-file="components/StickyBottomButton.js"
            >
                <button
                    onClick={handleCreateBioLink}
                    className="w-full btn-gradient text-white py-3 px-4 rounded-lg font-semibold text-sm"
                >
                    <i className="fas fa-plus mr-2"></i>
                    Buat Bio Link Product Gratis
                </button>
            </div>
        );
    } catch (error) {
        console.error('StickyBottomButton component error:', error);
        reportError(error);
        return null;
    }
}
