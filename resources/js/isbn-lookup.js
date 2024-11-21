// resources/js/isbn-lookup.js
function lookupIsbn(isbn) {
    fetch(`/api/books/lookup-isbn?isbn=${isbn}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Book not found');
                return;
            }
            
            document.getElementById('title').value = data.title;
            document.getElementById('author').value = data.author;
            document.getElementById('description').value = data.description;
            document.getElementById('total_pages').value = data.page_count;
        })
        .catch(error => console.error('Error:', error));
}