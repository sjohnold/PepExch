const minRange = document.querySelector('.min-range');
const maxRange = document.querySelector('.max-range');
const minPriceInput = document.getElementById('min_price');
const maxPriceInput = document.getElementById('max_price');
const minValSpan = document.getElementById('minVal');
const maxValSpan = document.getElementById('maxVal');

function syncPriceInputs() {
    if (minPriceInput) minPriceInput.value = minRange.value;
    if (maxPriceInput) maxPriceInput.value = maxRange.value;
    if (minValSpan) minValSpan.textContent = minRange.value;
    if (maxValSpan) maxValSpan.textContent = maxRange.value;
}

// Only add event listeners if elements exist
if (minRange) minRange.addEventListener('input', syncPriceInputs);
if (maxRange) maxRange.addEventListener('input', syncPriceInputs);

// Initialize on page load if elements exist
if (minRange && maxRange) syncPriceInputs();

document.addEventListener('DOMContentLoaded', function () {
    let btn = document.getElementById('loadMoreLocations'); 
    let items = document.querySelectorAll('#collapseLocation .location-item');

    if (btn && items.length > 0) {
        let visible = 15;

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            let next = visible + 15;
            for (let i = visible; i < next && i < items.length; i++) {
                items[i].style.display = 'block';
            }
            visible += 15;

            if (visible >= items.length) {
                btn.style.display = 'none';
            }
        });
    }
});




// product load more

document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('loadMoreProducts');
    if (!btn) return;

    const items = document.querySelectorAll('#productGrid .grid-item');
    let visible = 15;

    btn.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent page refresh
        const next = visible + 15; // show next 15 items
        for (let i = visible; i < next && i < items.length; i++) {
            items[i].style.display = 'block';
        }
        visible += 15;

        if (visible >= items.length) {
            btn.style.display = 'none'; // hide button when all items are visible
        }
    });
});






