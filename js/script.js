function showAlert(msg) {
    alert(msg);
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


function setModal(id) {
    const xhttpAd = new XMLHttpRequest();
    xhttpAd.onload = function() {
        var test = this.response;
        var ad = JSON.parse(test);
        setSlides(ad["pocetObrazkov"]);
        document.getElementById("title").innerHTML = ad["title"];
        document.getElementById("kategoria").innerHTML = ad["kategoria"];
        document.getElementById("imageGalery").style.display = "none";
        if (numImages > 0) {
            document.getElementById("imageGalery").style.display = "block";
        }
        document.getElementById("popis").innerHTML = ad["popis"];
        document.getElementById("usrEmail").innerHTML = ad["userEmail"];
        document.getElementById("usrEmail").href = "mailto:" + ad["userEmail"];
        document.getElementById("noVisible").value = ad["userEmail"];
        document.getElementById("price").innerHTML = "Cena: " + ad["cena"];
    }
    xhttpAd.open("GET", "AjaxController.php?action=readAd&id="+id);
    xhttpAd.send();

    const xhttpImages = new XMLHttpRequest();
    xhttpImages.onload = function() {
        var test = this.response;
        var images = JSON.parse(test);
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
        var test = this.response;
        var ad = JSON.parse(test);
        document.getElementById("idUpdate").setAttribute('value', ad["id"]);
        document.getElementById("titleUpdate").innerHTML = "Uprava inzeratu: " + ad["title"];
        document.getElementById("nadpisUpdate").setAttribute('value', ad["title"]);
        document.getElementById("popisUpdate").innerHTML = ad["popis"];
        document.getElementById("cenaUpdate").setAttribute('value', ad["cena"]);
    }
    xhttpAd.open("GET", "AjaxController.php?action=readAd&id="+id);
    xhttpAd.send();

    // document.getElementById("idUpdate").setAttribute('value', parseInt(id));
    // document.getElementById("titleUpdate").innerHTML = "Uprava inzeratu: " + title;
    // document.getElementById("nadpisUpdate").setAttribute('value', title);
    // document.getElementById("popisUpdate").innerHTML = popis;
    // document.getElementById("cenaUpdate").setAttribute('value', parseFloat(price));
}

//obrazkova galeria
var slideIndex = 1;
var numImages = 0;
function setSlides(pNumImages) {
    var i;
    var dots = document.getElementsByClassName("demo");
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
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
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
    var tableRows = document.getElementsByClassName("tableRows");
    var input;
    var str1;
    var str2;
    var search;
    var count = 0;
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
    var price;
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



