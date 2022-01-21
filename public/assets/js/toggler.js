document.addEventListener('DOMContentLoaded', () => {
    let paypalBtn = document.getElementById('paypalBtn');

    let paypalContent = document.getElementById('paypalContent');


    let cardsBtn = document.getElementById('cardsBtn');

    let cardsContent = document.getElementById('cardsContent');



    function hideAll() {
        cardsContent.classList.remove('active');
        paypalContent.classList.remove('active');
        paypalBtn.classList.remove('active');
        cardsBtn.classList.remove('active');
    }

    cardsBtn.addEventListener('click', () => {
        hideAll();
        cardsBtn.classList.add('active');
        cardsContent.classList.add('active');
    })

    paypalBtn.addEventListener('click', () => {
        hideAll();
        paypalBtn.classList.add('active');
        paypalContent.classList.add('active');
    })

})