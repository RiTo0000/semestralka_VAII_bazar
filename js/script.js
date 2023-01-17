function confirmAction(msg) {
    return confirm(msg);
}

const openModalButtons = document.querySelectorAll('[data-modal-target]')
const closeModalButtons = document.querySelectorAll('[data-close-button]')
const overlay = document.getElementById('overlay')

openModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = document.querySelector(button.dataset.modalTarget)
        openModal(modal)
    })
})

overlay.addEventListener('click', () => {
    const modals = document.querySelectorAll('.model.active')
    modals.forEach(modal => {
        closeModal(modal)
    })
})

closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.model')
        closeModal(modal)
    })
})

function openModal(modal) {
    if (modal == null) return
    modal.classList.add('active')
    overlay.classList.add('active')
}

function closeModal(modal) {
    if (modal == null) return
    modal.classList.remove('active')
    overlay.classList.remove('active')
}

function setCategory(category) { //nastavovanie kategorie po chybe pri odoslani formulara pre vytvorenie inzeratu
    const kategoria = document.querySelector('#kategoria');
    kategoria.value = category;
}


function setModal(id) {
    const xhttpAd = new XMLHttpRequest();
    xhttpAd.onload = function() {
        let response = this.response;
        let ad = JSON.parse(response);
        setSlides(ad["pocetObrazkov"]);
        document.getElementById("title").innerHTML = ad["title"];
        document.getElementById("kategoria").innerHTML = ad["kategoria"];
        document.getElementById("imageGalery").style.display = "none";
        if (numImages > 0) {
            document.getElementById("imageGalery").style.display = "block";
        }
        let detailPopis = document.getElementById("detailPopis");
        detailPopis.innerHTML = ad["popis"];
        detailPopis.style.height = "1px";
        detailPopis.style.height = (25+detailPopis.scrollHeight)+"px";
        document.getElementById("usrEmail").innerHTML = ad["userEmail"];
        document.getElementById("usrEmail").href = "mailto:" + ad["userEmail"];
        document.getElementById("noVisible").value = ad["userEmail"];
        document.getElementById("price").innerHTML = "Cena: " + ad["cena"];
    }
    xhttpAd.open("GET", "AjaxController.php?action=readAd&id="+id);
    xhttpAd.send();

    const xhttpImages = new XMLHttpRequest();
    xhttpImages.onload = function() {
        let response = this.response;
        let images = JSON.parse(response);
        for (let imagesKey in images) {
            let classNum = parseInt(imagesKey)+1;
            document.getElementsByClassName("image"+classNum)[0].src = images[imagesKey]["imgPath"];
            document.getElementsByClassName("image"+classNum)[1].src = images[imagesKey]["imgPath"];
        }
    }
    xhttpImages.open("GET", "AjaxController.php?action=readAllImages&id="+id);
    xhttpImages.send();
}
function edit(id) {
    const xhttpAd = new XMLHttpRequest();
    xhttpAd.onload = function() {
        let response = this.response;
        let ad = JSON.parse(response);
        document.getElementById("idUpdate").setAttribute('value', ad["id"]);
        document.getElementById("titleUpdate").innerHTML = "Úprava inzerátu: " + ad["title"];
        document.getElementById("nadpisUpdate").setAttribute('value', ad["title"]);
        let editPopis = document.getElementById("popisUpdate");
        editPopis.innerHTML = ad["popis"];
        editPopis.style.height = "1px";
        editPopis.style.height = (25+editPopis.scrollHeight)+"px";
        document.getElementById("cenaUpdate").setAttribute('value', ad["cena"]);
    }
    xhttpAd.open("GET", "AjaxController.php?action=readAd&id="+id);
    xhttpAd.send();
}

//obrazkova galeria
var slideIndex = 1;
var numImages = 0;
function setSlides(pNumImages) {
    let i;
    let dots = document.getElementsByClassName("demo");
    slideIndex = 1;
    numImages = pNumImages;
    if (numImages < 2) {
        document.getElementsByClassName("arrow")[0].style.display = "none";
        document.getElementsByClassName("arrow")[1].style.display = "none";
    }
    else {
        document.getElementsByClassName("arrow")[0].style.display = "block";
        document.getElementsByClassName("arrow")[1].style.display = "block";
    }
    for (i = 0; i < dots.length; i++) {
        if (i < numImages) {dots[i].style.display = "block";}
        else {dots[i].style.display = "none";}
    }
    showSlides(slideIndex);
}

// sipky kontrola dalsi predchadzajuci
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// male obrazky dole kontrola
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("demo");
    if (n > numImages) {slideIndex = 1}
    if (n < 1) {slideIndex = parseInt(numImages)}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
}

var filterTxt = "";
var filterMinPrice = "";
var filterMaxPrice = "";

function filter() {
    pageNumber = 1;
    filterTxt = document.getElementById("search").value;
    filterMinPrice = document.getElementById("priceFrom").value;
    filterMaxPrice = document.getElementById("priceTo").value;
    loadListingsPage();
    loadPaginationNav();
}

//pagination
var pageNumber = 1;
var totalPages;

function goToPage(pageNum) {
    if (pageNum !== pageNumber) {
        pageNumber = pageNum;
        stylePaginationNav();
        loadListingsPage();
    }
}

function loadListingsPage() { //nacitanie jednej strany inzeratov podla page number
    const xhttpAds = new XMLHttpRequest();
    xhttpAds.onload = function() {
        let listingsTable = this.response;

        document.getElementById("listings").innerHTML = listingsTable;

        const openModalButtons = document.querySelectorAll('[data-modal-target]')

        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.querySelector(button.dataset.modalTarget)
                openModal(modal)
            })
        })
    }
    xhttpAds.open("GET", "listings.inc.php?pageNum="+pageNumber+"&filterTxt="+filterTxt+"&filterMinPrice="+filterMinPrice+"&filterMaxPrice="+filterMaxPrice);
    xhttpAds.send();

}

function stylePaginationNav() {
    for (let x = 1; x <= totalPages; x++){
        document.getElementById("page"+x).classList.remove("active");
    }
    document.getElementById("page"+pageNumber).classList.add("active");
    if (pageNumber === 1){
        document.getElementById("prev").classList.add("disabled");
    }
    else {
        document.getElementById("prev").classList.remove("disabled");
    }
    if (pageNumber === totalPages){
        document.getElementById("next").classList.add("disabled");
    }
    else {
        document.getElementById("next").classList.remove("disabled");
    }
}

function loadPaginationNav() { //nacitanie navigacie pre pagination
    const xhttpPagNav = new XMLHttpRequest();
    xhttpPagNav.onload = function() {
        let response = this.responseText;
        let cutIndex = response.indexOf(';');
        totalPages = parseInt(response.substring(0, cutIndex));
        if (totalPages !== 0) {
            document.getElementById("noListings").style.display = "none";
        }
        cutIndex++;
        let paginationNav = response.substring(cutIndex);

        document.getElementById("paginationNav").innerHTML = paginationNav;

        stylePaginationNav(); //nastajlovanie pagination navigacie podla toho na akej strane som a co vyhladavam
    }
    xhttpPagNav.open("GET", "pagination.inc.php?filterTxt="+filterTxt+"&filterMinPrice="+filterMinPrice+"&filterMaxPrice="+filterMaxPrice);
    xhttpPagNav.send();
}

function plusPages(plusNum) { //sice pise ze sa nikde nepouziva ale pouziva sa v subore pagination.inc.php
    let newPageNum = pageNumber + plusNum;
    goToPage(newPageNum);
}





