function showAlert(msg) {
    alert(msg);
}

function confirmAction(msg) {
    return confirm(msg);
}

function notValidForm(){
    window.history.back();
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
        document.getElementById("popisUpdate").innerHTML = ad["popis"];
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

function filter() {
    let tableRows = document.getElementsByClassName("tableRows");
    let input;
    let str1;
    let str2;
    let search;
    let count = 0;
    for (let i = 0; i < tableRows.length; i++) {
        input = tableRows[i].cells.item(1).innerHTML;
        str1 = input.substring(input.indexOf("('")+2, input.indexOf("',"));
        str2 = input.substring(input.indexOf("',", input.indexOf("',") + 1) + 4, input.indexOf("',", input.indexOf("',", input.indexOf("',") + 1) + 1));
        search = str1 + ' ' + str2;

        if (search.toLowerCase().includes(((document.getElementById("search").value).toLowerCase()).trim())) {
            if (filterPrice(tableRows[i].cells.item(2).innerHTML)) {
                tableRows[i].removeAttribute("hidden");
                count++;
            }
            else {
                tableRows[i].setAttribute("hidden", "hidden");
            }
        }
        else {
            tableRows[i].setAttribute("hidden", "hidden");
        }
    }
    if (count === 0) {
        document.getElementById("noListings").style.display = "initial";
    }
    else {
        document.getElementById("noListings").style.display = "none";
    }

}

function filterPrice(pPrice) { //return true ked ma byt zobrazeny a false ak ma byt schovany
    let price;
    price = pPrice.substring(0, pPrice.indexOf("€"));

    if (document.getElementById("priceFrom").value.trim().length === 0 && document.getElementById("priceTo").value.trim().length === 0) {
        return true;
    }
    else if (document.getElementById("priceFrom").value.trim().length === 0) {
        if (parseFloat(price) <= document.getElementById("priceTo").value) {
            return true;
        }
        else {
            return false;
        }
    }
    else if (document.getElementById("priceTo").value.trim().length === 0) {
        if (parseFloat(price) >= document.getElementById("priceFrom").value) {
            return true;
        }
        else {
            return false;
        }
    }
    else {
        if (parseFloat(price) >= document.getElementById("priceFrom").value && parseFloat(price) <= document.getElementById("priceTo").value) {
            return true;
        }
        else {
            return false;
        }
    }
}

//pagination
var pageNumber;
var totalPages;

function goToPage(pageNum) {
    if (pageNum != pageNumber) {
        pageNumber = pageNum;
        for (let x = 1; x <= totalPages; x++){
            document.getElementById("page"+x).classList.remove("active");
        }
        document.getElementById("page"+pageNumber).classList.add("active");
        if (pageNum == 1){
            document.getElementById("prev").classList.add("disabled");
        }
        else {
            document.getElementById("prev").classList.remove("disabled");
        }
        if (pageNum == totalPages){
            document.getElementById("next").classList.add("disabled");
        }
        else {
            document.getElementById("next").classList.remove("disabled");
        }
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
        xhttpAds.open("GET", "listings.php?pageNum="+pageNum);
        xhttpAds.send();
    }
}

function plusPages(plusNum) {
    let newPageNum = pageNumber + plusNum;
    goToPage(newPageNum);
}

function initPages(pages) {
    totalPages = pages;
}



