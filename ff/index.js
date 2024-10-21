const title = "Flavour Finds..!"; // Your website title
let index = 0;

function typeTitle() {
    if (index < title.length) {
        document.getElementById("website-title").innerHTML += title.charAt(index);
        index++;
        setTimeout(typeTitle, 100); // Adjust typing speed (in milliseconds)
    }
}

// Start the typing effect when the page loads
window.onload = typeTitle;
