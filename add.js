document.getElementById('addParagraphButton').addEventListener('click', function() {
    // Create a new paragraph element
    const newParagraph = document.createElement('p');
    
    // Set the text content of the new paragraph
    newParagraph.textContent = 'This is a new paragraph added to the content area.';
    
    // Append the new paragraph to the content div
    document.getElementById('content').appendChild(newParagraph);
});
document.getElementById('changeColorButton').addEventListener('click', function() {
    const styledDiv = document.getElementById('styledDiv');
    
    // Change the background color of the div
    styledDiv.style.backgroundColor = styledDiv.style.backgroundColor === 'lightblue' ? 'lightcoral' : 'lightblue';
});
