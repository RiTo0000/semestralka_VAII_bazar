<div class="model" id="model">
    <div class="model-header">
        <div class="title" id="title"></div>
        <button data-close-button class="close-button">&times;</button>
    </div>
    <div class="model-body">
        <div id="kategoriaDetail"></div>
        <!--zaciatok obrazkovej galerie-->
        <div class="container" id="imageGalery">

            <!-- Full-width images with number text -->
            <div class="mySlides">
                <img class="image1" src="" style="width:100%">
            </div>

            <div class="mySlides">
                <img class="image2" src="" style="width:100%">
            </div>

            <div class="mySlides">
                <img class="image3" src="" style="width:100%">
            </div>

            <div class="mySlides">
                <img class="image4" src="" style="width:100%">
            </div>

            <div class="mySlides">
                <img class="image5" src="" style="width:100%">
            </div>


            <!-- Next and previous buttons -->
            <a class="prev arrow" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next arrow" onclick="plusSlides(1)">&#10095;</a>


            <!-- Thumbnail images -->
            <div class="row">
                <div class="column">
                    <img class="demo cursor image1" src="" style="width:100%" onclick="currentSlide(1)">
                </div>
                <div class="column">
                    <img class="demo cursor image2" src="" style="width:100%" onclick="currentSlide(2)">
                </div>
                <div class="column">
                    <img class="demo cursor image3" src="" style="width:100%" onclick="currentSlide(3)">
                </div>
                <div class="column">
                    <img class="demo cursor image4" src="" style="width:100%" onclick="currentSlide(4)">
                </div>
                <div class="column">
                    <img class="demo cursor image5" src="" style="width:100%" onclick="currentSlide(5)">
                </div>
            </div>
        </div>
        <!--koniec obrazkovej galerie-->
        <br>
<!--        <div id="popis"></div>-->
        <textarea readonly id="detailPopis"></textarea>
        <br>
        <div id="price"></div>
        <div id="mailAndComents"><div id="contactInfo">Kontaktný email: <a id="usrEmail" href=""></a></div><form enctype="multipart/form-data" method="post"><input id="noVisible" name="userTo"><button type="submit" name="coments" id="comentsBtn" class="btn btn-primary">Recenzie používateľa</button></form></div>
    </div>
</div>
<div id="overlay"></div>
