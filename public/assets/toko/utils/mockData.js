const mockSellerInfo = {};
const mockProducts = [];

fetch("http://127.0.0.1:8000/t/dsaf/mock")
    .then(response => response.json())
    .then(result => {
        Object.assign(mockSellerInfo, {
            name: result.seller.name,
            description: result.seller.description,
            location: result.seller.location,
            avatar: result.seller.avatar
        });

        mockProducts.push(...result.products);

        console.log(mockSellerInfo);
        console.log(mockProducts);
    })
    .catch(error => {
        console.error(error);
    });
