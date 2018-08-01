//Обрезка длинных названий
function truncate(str, maxlength){
    if (str.length > maxlength){
        return str.slice(0, maxlength-3) + '...';
    }
    return str;
}

//Инициализация анимации кружка в слайдере
function roundSliderCall(slideNum){

    $('.circle'+slideNum).circleProgress({
        value: 1.0,
        size: 44,
        startAngle:0,
        fill: {
            color: ["#586D62"]
        },
        emptyFill:"#82928A",
        animation: {
            duration: 4000,
            easing: 'circleProgressEasing'
        }
    });
}

//Инициализация анимации смены слайда(главная)
function roundSliderCallRotate(){//alert(slideNumer);
    if ($('.roundSlider li').length == slideNumer){
        $('.slideWrapp ul').animate({left:0},500);
    }else{
        var slideWidth = $('.slideWrapp li').css('width').slice(0, -2);
        $('.slideWrapp ul').animate({left: -(slideWidth*(slideNumer))+'px'},500);
    }

    if($('.roundSlider li').length == slideNumer){
        slideNumer = 1;
    }else{
        slideNumer++;
    }

    roundSliderCall(slideNumer);
}
//Инициализация анимации смены слайда(категория)
function roundSlCallRotateCateg(){
    if ($('.roundSlideWrapp li').length == slideNumRound){
        $('.roundSlideWrapp ul').animate({left:0},500);
    }else{
        var slideWidth = $('.roundSlideWrapp li').css('width').slice(0, -2);
        slideWidth = +slideWidth + 2;
        $('.roundSlideWrapp ul').animate({left: -(slideWidth*(slideNumRound))+'px'},500);
    }

    if($('.roundSlideWrapp li').length == slideNumRound){
        slideNumRound =1;
    }else{
        slideNumRound++;
    }

    roundSliderCall(slideNumRound);
}

// плавное скрытие блока информационного сообщения при нажатии на Х
function close_notice(id){
	$("#notice_warn").slideUp();
	$.cookie('notice_warn', id, {path: '/', expires: 3 });
}
// скрытие блока подписки на рассылку
function closeX(){
    $('.hideInfo').hide();
}
//отправка главы
function sendchapter(bookid) {
	$(".takePartWrap button").after('<div id="loadingInfo"><div class="spinner"><div class="spinner-icon"></div></div></div>').hide();
	$.ajax({
		type: "POST",
		url: "/ajax/send_chapter.php",
		data: {email: $("#chapter-email").val(), book: bookid}
	}).done(function( strResult ) {
            if (strResult == 'ok')
				$(".takePartWrap").html("<span style='color:#00abb8;font-size:20px; font-family: \'Walshein_regular\';'>Глава отправлена</span>");
        });
};
$(document).ready(function(){
	//Отправка главы
	$("#chapter-email").keydown(function(event){
		if(event.keyCode == 13) {
		  event.preventDefault();
		  $(this).siblings("button").click();
		  return false;
		}
	});

	$(".element_item_img").hover(
	  function() {
		$(this).find('img').css({'filter':'grayscale(0.7)', '-webkit-filter':'grayscale(0.7)', '-moz-filter':'grayscale(0.7)', '-o-filter':'grayscale(0.7)', '-ms-filter':'grayscale(0.7)'});
		$('.bookPreviewButton').css('display','block');
	  }, function() {
		$(this).find('img').css({'filter':'none', '-webkit-filter':'none', '-moz-filter':'none', '-o-filter':'none', '-ms-filter':'none'});
		$('.bookPreviewButton').css('display','none');
	  }
	);
    //скрывание попапа при клике по фону
    if($('.layout2').length > 0){
        $('.layout2').click(function(){
            $('.layout2').hide();
            $('.contacsFormMessage').hide();
        })
    }
    //скрытие текста в карточке товара
    if($('.showAllWrapp').length > 0){
		var descHeight = parseInt($('.showAllWrapp').css('height').slice(0,-2));
		var leftBlockHeight = parseInt($('.elementDescriptWrap .leftColumn').css('height').slice(0,-2));

		if ($("div").is('.videoWrapp'))
			var videoHeight = 321;
		else
			var videoHeight = 0;

        if(descHeight > leftBlockHeight) {
            $('.showAllWrapp').append('<p class="readMore"><span>Читать далее...</span></p>');
            $('.showAllWrapp').css('height',leftBlockHeight - videoHeight - 300 +'px');
        }

        $('.readMore').click(function(){
            $('.showAllWrapp').css('height','auto');
            $('.readMore').hide();
        })
    }
    //Плавающая шапка на странице профиля
    $(window).on('scroll', function(){
        if($(window).scrollTop() > 210) {
            $('.top-section__edit-acc').addClass('slidingTop');
        };
        if($(window).scrollTop() < 210) {
            $('.top-section__edit-acc').removeClass('slidingTop');
        };
    })



    //скролящееся меню на странице оплата
    if($('.delivMenuWrapp').length > 0){
        heightFromElement = $(".delivMenuWrapp").offset().top;
        $(window).scroll(function(){
            console.log(!($('.delivMenuWrapp').hasClass('slidingDelivMenu')) && ($(window).scrollTop() > $(".delivMenuWrapp").offset().top));
			var scrollBottom = $(window).scrollTop() + $(window).height();
            if(!($('.delivMenuWrapp').hasClass('slidingDelivMenu')) && ($(window).scrollTop() > $(".delivMenuWrapp").offset().top)){
                $('.delivMenuWrapp').addClass('slidingDelivMenu');
            }
            if(($('.delivMenuWrapp').hasClass('slidingDelivMenu')) && (($(window).scrollTop() < heightFromElement) || scrollBottom > 3000)){
                $('.delivMenuWrapp').removeClass('slidingDelivMenu');
				//alert($('footer').height());
            }
        })
        /*
        window.onscroll = function(heightFromElement){
        alert(!($('.delivMenuWrapp').hasClass('slidingDelivMenu')) && ($(window).scrollTop() > heightFromElement));
        if(!($('.delivMenuWrapp').hasClass('slidingDelivMenu')) && ($(window).scrollTop() > heightFromElement)){

        }*/
        /*else{
        console.log(2);
        $('.delivMenuWrapp').addClass('slidingDelivMenu');
        }*/

        /*}*/

    }



    if($('.wishlist_info').length > 0){
        $('.layout').click(function(){
            if($('.wishlist_info').css('display') == 'block'){
                $(this).hide();
                $('.wishlist_info').hide();
            }
        })
    }



    if($('.videoWrapp').length > 0){
        $('.videoWrapp iframe:nth-child(1)').show();
    }
    if($('.productSelectTitle').length > 0){
        $('.productSelectTitle').click(function(){
            $('.videoWrapp iframe').show();
            return false;
        })
    }

    if($(".some_info").length > 0){
        $('.layout').click(function(){
            $('.some_info').hide();
            $(this).hide();
        })
    }

    if($(".certificate_popup").length > 0){
        $('.layout').click(function(){
            $('.certificate_popup').hide();
            $(this).hide();
        })
    }

    if($(".subscr_result").length > 0){
        $('.layout').click(function(){
            $('.subscr_result').hide();
            $(this).hide();
        })
    }

    // скрывать блок списка купивших в дар книгу при нажатии на свободном месте окна браузера
    if($(".gifted_books_buyers_list").length > 0){
        $('.layout').click(function(){
            $('.gifted_books_buyers_list').hide();
            $(this).hide();
        })
    }


    // функционал "Где мой заказ"

    $("#check-order").click(function(){
        $("#info-order").slideUp();
        $.ajax({
            type: "POST",
            url: "/ajax/whereOrder.php",
            data: { orderID: $("#order-id").val() }
        }).done(function( strResult ) {
            var obj = jQuery.parseJSON(strResult);
            if(obj[0]=="error") {
                $(".error_message").html("Заказ №"+$("#order-id").val()+" не найден.");
                $(".error_message").slideDown();

            } else if (obj[0] == "error_auth") {
                $(".error_message").html("Пожалуйста, авторизуйтесь для использования функционала 'Где мой заказ?'");
                $(".error_message").slideDown();
            } else {
                $(".error_message").slideUp();
                $("#status-value").html(obj[0]);
                $("#change-value").html(obj[1]);
                $("#info-order").slideDown();
            }
        });
    })

   if($('.basketItems').length > 0){
        var GetArr = parseGetParams();
        if(GetArr.liked == "yes"){
            $('.cartMenuWrap .basketItems').removeClass('active');
            $('.cartMenuWrap .basketItems:nth-child(2)').addClass('active');
            $('#cardBlock1').hide();
            $('#cardBlock2').show();

        }
    }

    // функционал "Книга в подарок"
    /*$(".giftWrap input[type=button]").click(function(){
    $.post("/ajax/request_add.php", {email: $(".giftWrap input[type=text]").val()}, function(data){
    $(".layout").show();
    $(".some_info").show();
    $(".some_info").html(data);
    })
    });*/

    $(".giftWrap input[type=button]").click(function(){

        CheckRequestFields();
    });

    // скрывать всплывайки при нажатии на любом свободном месте
    $(".some_info").click(function(){
        $(".some_info").hide();
        $(".layout").hide();
    });

    // скрывать стрелки слайдера, если элементов меньше 6
    if ($(".saleSlider ul li").size() < 6) {
        $(".saleSlider .left").hide();
        $(".saleSlider .right").hide();
    }

    if ($(".otherEasySlider ul li").size() < 6) {
        $(".otherEasySlider .left").hide();
        $(".otherEasySlider .rigth").hide();
    }

    // если блок "Мероприятия товара" отображается - поправить вёрстку страницы автора

    if ($(".autorInfo .events").css("display") == "block") {
        $(".content").css("min-height", "840px");
    }

    if ($(".autorInfo .textWrap").height() > 300) {
        $(".content .catalogWrapper").css("height", $(".autorInfo .textWrap").height() + 100 + "px");
    }

    //позиционирование всплывающего блока купивших в дар данную книгу

    if($('.ask_form_for_gift').length > 0){
        $('.ask_form_for_gift').click(function(e){
            e.preventDefault();
            $('.layout').show();

            var window_width = $(window).width();
            var block_top_coordinate = window.pageYOffset + (window.innerHeight / 2);
            var block_left_coordinate = window_width / 2 - ($('.gift_popup_form').width() / 2);
            $('.gift_popup_form').css({
                "top" : block_top_coordinate,
                "left": block_left_coordinate
            });
            $(".item_id").attr("value", $(this).find(".giftBook").attr("data-id"));
            $('.gift_popup_form').show();
        })
    }

    // вызов функции оформления заказа и вызова формы оплаты на данную книгу, покупаемую в дар
    $(".gift_button").on("click", function(){
        var item_id = $(".item_id").attr("value");
        console.log(isEmail($(".gift_email").val()));
        if (isEmail($(".gift_email").val()) != false) {
            add_giftbook($(".buyer_name").val(), item_id, $(".gift_quantity").val(), $(".gift_email").val());
        }
    })

    // позиционирование всплывающего блока формы ввода пользовательских полей для покупки книги в дар
    if($('.gift_popup_form').length > 0){
        $('.layout').click(function(){
            if($('.gift_popup_form').css('display') == 'block'){
                $(this).hide();
                $('.gift_popup_form').hide();
            }
        })
    }

    if($('#authorisationPopup').length > 0){
        $('#authorisationPopup').click(function(e){
            e.preventDefault();
            $('.layout').show();

            var winH = $(window).height();
            var winW = $(window).width();
            var blokT = winH / 2 - ($('.authorisationWrapper').height() / 2);
            var blokL = winW / 2 - ($('.authorisationWrapper').width() / 2);
            $('.authorisationWrapper').css({
                "top" : blokT,
                "left": blokL
            });

            $('.authorisationWrapper').show();
        })
    }

    if($('#authorisationClose').length > 0){
        $('#authorisationClose, .layout').click(function(){
            $('.layout').hide();
            $('.authorisationWrapper').hide();
        })
    }
    if($('.signinWrapper').length > 0){
        $('.registrationLink').click(function(){
            $(this).addClass('active');
            $('.signinLink').removeClass('active');
            $('.signinBlock').hide();
            $('.registrationBlock').show();
        });
        $('.signinLink').click(function(){
            $(this).addClass('active');
            $('.registrationLink').removeClass('active');
            $('.signinBlock').show();
            $('.registrationBlock').hide();
        })
    }

    if ($('.hidingBasketRight').length > 0 || $('#basket_container').length > 0 ) {
        update_quant();
    }

    if ($(".hidingBasketRight .basketBooks .basketBook").length == 0) {
        $(".BasketQuant").css("display", "none");
    }
    //плавающий блок в карточке товара
    /*if(('.productElementWrapp').length >0){
    if ($(window).scrollTop() > $('.productAction').offset().top + $('.productAction').height() ){
    $('.priceBasketWrap').css({'position':'fixed', 'top':'20px', 'left':'20px'})
    };
    }*/
    //картока товара. Раскрытие торговых предложений
    if ($('.elementDescriptWrap .otherTypes').length > 0){
        $('.elementDescriptWrap .otherTypes').click(function(){
            var wrapBlockHeight = $('.typesOfProduct').height();
            var countType = $('.productType').length;
            var BLOCKSINLINE = 3;//это так по дизайну
            var lines = Math.ceil(countType/BLOCKSINLINE);
            if ($('.typesOfProduct').height() < 180)
            {
                $('.typesOfProduct').height(wrapBlockHeight*lines);
            }
        });
    };

    //купон в корзине
    if ($('.promocode').length > 0){
        $('.promocode').click(function(){
            $('#couponInp').toggle();
        })
    };

    //авторы скролл по алфавиту
    if ($('.alphabet').length > 0){
        $('.alphabet span').click(function(){
            $(window).scrollTop($('#letterBlock'+$(this).attr("data-id")).offset().top);
        });
    };


    //смена блоков в корзине
    if($('.cartMenuWrap .basketItems').length > 0){
        $('.cartMenuWrap .basketItems').click(function(){
            $('.cartMenuWrap .basketItems').removeClass("active");
            $(this).addClass("active");
            $('.yourBooks').hide();
            $('#cardBlock'+$(this).attr('data-id')).show();
        })
    }

	//Открываем вкладку об авторах
	$(".productAutor span").click(function() {
		$('#prodBlock1, #prodBlock2, #prodBlock3, #prodBlock4, #prodBlock5').hide();
		$('.productsMenu li').removeClass('active');
		$(".productsMenu li:nth-child(2)").addClass("active");
		$('#prodBlock4').show();
	});

    //смена блоков на детальной карточке
    if($('.productElementWrapp').length >0){
        $('.productsMenu li').click(function(){
            $('.productsMenu li').removeClass('active');
            $(this).addClass('active');
            $('#prodBlock1, #prodBlock2, #prodBlock3, #prodBlock4, #prodBlock5').hide();
            $('#prodBlock'+$(this).attr('data-id')).show();
            if (!$(".productsMenu li:first-child").hasClass("active"))
            {
                //$(".productsMenu li:first-child").css("width", "90px");
            }
            else
            {
               // $(".productsMenu li:first-child").css("width", "110px");
            }
            if ($(".productsMenu li:nth-child(2)").hasClass("active"))
            {
                //$(".productsMenu li:nth-child(2)").css("width", "105px");
            }
            else
            {

            }
            $(".productsMenu li:not(:first-child, :nth-child(2))").each(function(){
                if (!$(this).hasClass("active"))
                {
                   // $(this).css("width", "80px");
                }
                else
                {
                  //  $(this).css("width", "91px");
                }
            });
            if ($("#prodBlock3").css("display") == "block") {
                $("#prodBlock3").css("height", $(".ReviewsFormWrap").height() + 90);
            }

            //пишем ссылку в урл
            if ($(this).find("a").attr("href") != "") {
                history.pushState(null, null, $(this).find("a").attr("href"));
            }

        })
    }




    //в категориях смена болоков
    $('.filterParams p').click(function(){
        $('.filterParams li').removeClass("active");
        $(this).parent('li').addClass("active");
        $('.otherBooks').hide();
        $('#block'+ $(this).attr("data-id")).show();

    })


    //история заказов(переключение заказов)

    $('.historyBodywrap .ordTitle').click(function(){
        $('.historyBodywrap .orderNumbLine').removeClass("active");
        $(".hiddenOrderInf").hide();
        $(this).parent('div').addClass('active');
        var idOrder = $(this).attr('data-id');
        $(".hidOrdInfo"+idOrder).show();
    })

    //Вызываем слайдер на странице поиск(Те что искали, купили)
    if($('.bookEasySlider').length > 0){
        easySlider('.bookEasySlider', 6);
    }
    //слайдер на странице категории(снизу(вам также может быть интересно))
    if($('.otherEasySlider').length > 0){
        easySlider('.otherEasySlider',6);
    }
    if($('.authorBoolSlider').length >0){
        easySlider('.authorBoolSlider',6);
    }

    if($('.uLookSlider').length > 0){
        easySlider('.uLookSlider',6);
    }

    if($('.bestSlider').length > 0){
        easySlider('.bestSlider', 5);
    }

    if ($(".bestSlider ul li").size() < 6) {
        $(".bestSlider .left").hide();
        $(".bestSlider .rigth").hide();

    }

    if ($(".authorBoolSlider ul li").size() < 6) {
        $(".authorBoolSlider .left").hide();
        $(".authorBoolSlider .rigth").hide();

    }
    // отображение блоков на странице регистрации/авторизации

    if ($(".signinLink").hasClass("active")) {
        $(".registrationBlock").hide();
        $(".signinBlock").show();
    }

    //плагин кастомизации селектов в оформлении заказа
    if($('.userCountry').length > 0){
        $('.userCountry').selectric();
    }
    if($('.userCity').length > 0){
        $('.userCity').selectric();
    }



    //плагин кастомизации селектов в оформлении заказа
    if($('.userCountry').length > 0){
        $('.userCountry').selectric();
    }
    if($('.userCity').length > 0){
        $('.userCity').selectric();
    }

    //Проверяем наличие слайера на странице(с анимированными кругамин а главной)
    if($('.slideWrapp ul').length >0){
        //номер слайда(с анимированными кругами)
        slideNumer = 1;
        roundSliderCall(slideNumer);
        //Вызов смены слайда
        interval = setInterval(roundSliderCallRotate, 4000);
    }
    //Измение слайда по клику(слайдер с анимированными кружками)
    $('.slideWrapp .buttons').click(function(e){
        e.preventDefault();
        clearInterval(interval);
        slideNumer = $(this).attr('data-number');
        roundSliderCall(slideNumer);
        interval = setInterval(roundSliderCallRotate, 4000);
        var slideWidth = $('.slideWrapp li').css('width').slice(0, -2);
        $('.slideWrapp ul').animate({left: -(slideWidth*(slideNumer-1))+'px'},500);
    })

    //Проверка и подключение слайдера с кругами на странице категории
    if($('.roundSlideWrapp ul').length > 0){
        slideNumRound = 1;
        roundSliderCall(slideNumRound);
        interval = setInterval(roundSlCallRotateCateg, 4000);
    }
    //Измение слайда по клику(слайдер с анимированными кружками страница категории)
    $('.roundSlideWrapp .buttons').click(function(e){
        e.preventDefault();
        clearInterval(interval);
        slideNumRound = $(this).attr('data-number');
        roundSliderCall(slideNumRound);
        interval = setInterval(roundSlCallRotateCateg, 4000);
        var slideWidth = $('.roundSlideWrapp li').css('width').slice(0, -2);
        $('.roundSlideWrapp ul').animate({left: -(slideWidth*(slideNumRound-1))+'px'},500);
    })








    //меню на странице категории(левое)
    $('.categoryWrapper .leftMenu .firstLevel>li>a').click(function(){
        if ($(this).find("p").hasClass('activeListName')) {
            $('.categoryWrapper .leftMenu li ul').hide();
            $(this).find("p").removeClass('activeListName');
        }else{
            $('.categoryWrapper .leftMenu>ul>li>p').removeClass('activeListName');
            $(this).find("p").addClass('activeListName')
            $('.categoryWrapper .leftMenu li ul').hide();
            $(this).parent('li').find('ul').show();
        }
    })

    $('.hidingCatalogLeft .firstLevel>li>a').click(function(){
        if ($(this).find("p").hasClass('activeListName')) {
            $('.hidingCatalogLeft li ul').hide();
            $(this).find("p").removeClass('activeListName');
        }else{
            $('.hidingCatalogLeft .leftMenu>ul>li>p').removeClass('activeListName');
            $(this).find("p").addClass('activeListName')
            $('.hidingCatalogLeft li ul').hide();
            $(this).parent('li').find('ul').show();
        }
    })


    var basketOpenFlag = false;
    //Открытие всплывающего каталога
    $('.catalogIcon, .headCatalog, .ContentcatalogIcon, .howToCatalogWrapper').click(function(){
        $('.hidingCatalogLeft, .layout').toggle();
    })
    //Лткрытие всплывающей корзины
    $('.basketIcon, .ContentbasketIcon, .howToBasketWrapper').click(function(basketOpenFlag){
        $('.hidingBasketRight, .layout, .windowClose').toggle();

        if($('.hidingBasketRight, .layout, .windowClose').css('display') == 'block'){
            $('html').css('overflow','hidden');
        }else{
            $('html').css('overflow','auto');
        }

    })

    //закртытие боковых меню
    $('.windowClose').on('click', function(){
        $(this).closest(".hidingBasketRight").hide();
        $(".hidingCatalogLeft").hide();
        $('.layout').hide();
        $('.windowClose').hide();
        $('html').css('overflow','auto');
    })

    $('.layout').on('click', function(){
        if ($(".hidingBasketRight").css("display") == "block")
        {
            $(".hidingBasketRight").hide();
            $('.windowClose').hide();
            $('html').css('overflow','auto');
        }
        if ($(".hidingCatalogLeft").css("display") == "block")
        {
            $(".hidingCatalogLeft").hide();
        }
        $('.layout').hide();
    })

    //Верхнее меню на главной
    $(window).scroll(function(){
        $('.slidingTopMenu').show();
        /*$(".footer_search_form").html($(".searchWrap .catalogWrapper").html());
        $(".searchWrap .catalogWrapper").html("");
        $(".headFind").each(function(){
        $(this).removeClass("headFind");
        $(this).addClass("headFindCatalog");
        });*/
        if($(window).scrollTop() == 0){
            $('.slidingTopMenu').hide();
            /*$(".searchWrap .catalogWrapper").html($(".footer_search_form").html());
            $(".footer_search_form").html("");
            $(".headFindCatalog").each(function(){
            $(this).removeClass("headFindCatalog");
            $(this).addClass("headFind");
            });*/

        }
    })

    $(".bookName").each(function()
        {
            if($(this).length > 0)
            {
                $(this).html(truncate($(this).html(), 32));
            }
        }
    );





    $('.slideWrapp li').css('width',$(window).width()+'px');



    var widthOfSlide = '196px';
    var intwidthOfSlide = 196;
    var countLi = $('.saleWrapp ul li').size();
    if (countLi < 6) {
        $(".saleWrapp .left").hide();
        $(".saleWrapp .right").hide();
    }
    //alert(attrLeft[0]);
    $(".saleWrapp .right").on("click", function(){
        attrLeft = $(".saleWrapp ul").css("left").split("px");
        if (attrLeft[0] <= -(countLi-7)*intwidthOfSlide)
        {
            $('.saleWrapp .right').hide();
        }
    });

    $(".otherEasySlider .right").on("click", function(){
        attrLeft = $(".otherEasySlider ul").css("left").split("px");
        if (attrLeft[0] <= -(countLi-7)*intwidthOfSlide)
        {
            $('.otherEasySlider .rigth').hide();
        }
    });

     $(".authorBoolSlider .rigth").on("click", function(){
        $(".authorBoolSlider .left").show();
        attrLeft = $(".authorBoolSlider ul").css("left").split("px");
        if (attrLeft[0] <= -(countLi-7)*intwidthOfSlide)
        {
            $('.authorBoolSlider .rigth').hide();
        }
    });

    $(".authorBoolSlider .left").on("click", function(){
        $(".authorBoolSlider .rigth").show();
        if ($(".authorBoolSlider ul").css("left") == '-'+widthOfSlide)
        {
            $('.authorBoolSlider .left').hide();
        }
    });

    var ulWidth = (countLi-7) * widthOfSlide.slice(0, -2);

    $('.saleWrapp .left').click(function(){
        $('.saleWrapp ul').animate({left:'+='+ widthOfSlide},500);
        $('.saleWrapp .right').show();

        if($('.saleWrapp ul').css('left') == '-'+widthOfSlide){
            $('.saleWrapp .left').hide();
        }
    })

    $('.otherEasySlider .left').click(function(){
        $('.otherEasySlider ul').animate({left:'+='+ widthOfSlide},500);
        $('.otherEasySlider .rigth').show();

        if($('.otherEasySlider ul').css('left') == '-'+widthOfSlide){
            $('.otherEasySlider .left').hide();
        }
    })

    $('.saleWrapp .right').click(function(){
        $('.saleWrapp ul').animate({left:'-='+ widthOfSlide},500);
        $('.saleWrapp .left').show();

        if($('.saleWrapp ul').css('left') == '-'+ulWidth+'px'){
            $('.saleWrapp .right').hide();
        }
    })
    if($('.saleWrapp ul').css('left') == '0px'){
        $('.saleWrapp .left').hide();
    }

    var widthOfSlideReccomend = '196px';
    var intwidthOfSlideReccomend = 196;
    var countLiRec = $('.recomendation ul li').size();
    if (countLiRec < 7) {
        $(".recomendation .left").hide();
        $(".recomendation .right").hide();
    }
    var ulWidthRec = (countLi-7) * widthOfSlideReccomend.slice(0, -2);
    $(".recomendation .right").on("click", function(){
        attrLeft = $(this).closest(".recomendation").find("ul").css("left").split("px");
        if (attrLeft[0] <= -(countLi-7)*intwidthOfSlideReccomend)
        {
            $(this).hide();
        }
    });
    $('.recomendation .left').click(function(){
        $(this).closest(".recomendation").find("ul").animate({left:'+='+ widthOfSlideReccomend},500);
        $(this).closest(".recomendation").find(".right").show();

        if($(this).closest(".recomendation").find("ul").css('left') == '-'+widthOfSlideReccomend){
            $(this).closest(".recomendation").find(".left").hide();
        }
    })
    $('.recomendation .right').click(function(){
        $(this).closest(".recomendation").find("ul").animate({left:'-='+ widthOfSlideReccomend},500);
        $(this).closest(".recomendation").find(".left").show();

        if($(this).closest(".recomendation").find("ul").css('left') == '-'+ulWidthRec+'px'){
            $(this).closest(".recomendation").find(".right").hide();
        }
    })
    $(".recomendation").each(function(){
        if($(this).find('ul').css('left') == '0px'){
            $(this).find('.left').hide();
        }
    });


    //Слайдер отзывы
    /*var widthOfSlideReview = '389px';
    var countLiReview = $('.bigSlider ul li').size();
    var ulWidthRewiew = (countLiReview-3)*widthOfSlideReview.slice(0,-2);
    $('#left').click(function(){
    if ($('.bigSlider ul').css('left') == '0px') {
    $('.bigSlider ul').animate({left:'-'+ulWidthRewiew+'px'},500);
    }else{
    $('.bigSlider ul').animate({left:'+='+ widthOfSlideReview},500);
    }
    })
    $('#right').click(function(){
    if (($('.bigSlider ul').css('left') == '-'+ulWidthRewiew+'px') || ($('.bigSlider ul').css('left') == ulWidthRewiew+'px') || (countLiReview < 4)) {
    $('.bigSlider ul').animate({left:0},500);
    }else{
    $('.bigSlider ul').animate({left:'-='+ widthOfSlideReview},500);
    }
    })*/

    // слайдер отзывов на главной
    if (typeof fxSlider == 'function'){
        fxSlider('bigSlider','left','right', false, 500,3);
    }

    /*var quantityOfReview = $('.bigSlider ul li').length;
    var nowSlide = 1;//номер первого видимого слайда
    var reviewSlideWidth = $('.bigSlider ul li').outerWidth(true);
    var sliderEnd = (quantityOfReview-3)*reviewSlideWidth;
    $('#left').click(function(){

    if(nowSlide == 1){
    $('.bigSlider ul').animate({left:'-'+sliderEnd+'px'},500);
    nowSlide = quantityOfReview-2;
    }else{
    $('.bigSlider ul').animate({left:'+='+reviewSlideWidth+'px'});
    nowSlide--;
    }
    })
    $('#right').click(function(){
    if(nowSlide == (quantityOfReview-2)){
    $('.bigSlider ul').animate({left:0},500);
    nowSlide = 1;
    }else{
    $('.bigSlider ul').animate({left:'-='+reviewSlideWidth+'px'});
    nowSlide++;
    }
    })    */


    //убираем placeholder поиск вверху главной
    $('#title-search-input-top').focus(function(){
        $(this).data('placeholder',$(this).attr('placeholder'))
        $(this).attr('placeholder','');
    });
    $('#title-search-input-top').blur(function(){
        $(this).attr('placeholder',$(this).data('placeholder'));
    });



    //Блоки на главном начальном слайде
    var BlocksChangingFunc;
    $('.books > ul span').mouseover(function(){
        var $this = $(this);
        BlocksChangingFunc = setTimeout(function(){
            if (!$this.hasClass("active"))
            {
                //$('.book').css('display','none');
                $('.book').stop(true, true).fadeOut();
                switch ($this.attr('data-id')){
                    case "1":
                        //$('.bookNew').css('display','block');
                        $('.bookNew').delay(500).fadeIn();
                        break
                    case "2":
                        //$('.bookBest').css('display','block');
                        $('.bookBest').delay(500).fadeIn();
                        break
                    case "3":
                        //$('.bookSoon').css('display','block');
                        $('.bookSoon').delay(500).fadeIn();
                        break
                    case "4":
                        //$('.bookMust').css('display','block');
                        $('.bookChildren').delay(500).fadeIn();
                        break
                    case "5":
                        //$('.bookMust').css('display','block');
                        $('.bookMust').delay(500).fadeIn();
                        break
                };
                $('.books > ul li').removeClass('first');
                $this.parent().addClass('first');
                $('.books > ul span').removeClass('active');
                $this.addClass('active');
				$this.click(function() {
					return false;
				});
				function stopReturn() {
					setTimeout(function(){
					$this.unbind('click')}, 600 );
				}
				stopReturn();
            }
            }, 200);

    });
    $(".books > ul span").mouseout(function(){
        clearTimeout(BlocksChangingFunc);
    })

	//Progress Bar START
	$('a:not(.ajax_link, #digitalversion)').click(function() {
		var link = $(this).attr("href");
		var target = $(this).attr("target");
		if (!$(this).parents().hasClass('leftMenu') && !$(this).parents().hasClass('hidingCatalogLeft')) {
			if (!link.match(/([\#\(\)]|pdf|freedigitalbooks|\/personal\/cart\/|info\_popup|ADD2BASKET)/) && target != "_blank") {
				NProgress.start();
			};
		}
	});
	NProgress.set(0.6);
	setTimeout(function() { NProgress.done();}, 200);
	//Progress Bar END

    $('body').on('click', '#altasib_geobase_btn', function(){
        altasib_geobase.sc_onclk();
    })

	$(".stopProp").click(function(e){
		e.stopPropagation();
	});

	$(".catalogIcon").html("<span>Каталог</span>");
	$(".basketIcon").html("<span>Корзина</span>");
});


function update_quant(sign, e) {
    //изменение кол-ва в выезжающей корзине
    /*$('.hidingBasketRight .plus').on('click', function(){
    var numbOfBooks = parseInt($(this).parent().children('p').html());
    var new_count = numbOfBooks+1;
    $(this).parent().children('p').html(new_count);
    update_basket($(this), "plus");
    })
    $('.hidingBasketRight .minus').on('click', function(){
    var numbOfBooks = $(this).parent().children('p').html();
    if (numbOfBooks > '1'){
    $(this).parent().children('p').html(numbOfBooks-1);
    }
    update_basket($(this), "minus");
    })*/
    var numbOfBooks = parseInt($(e).parent().children('p').html());
    var quantity = numbOfBooks;
    switch (sign) {
        case "plus":
            quantity = numbOfBooks+1;
            //$(e).parent().children('p').html(new_count);
            break;
        case "minus":
            if (numbOfBooks > 1)
            {
                quantity = numbOfBooks-1;
            }
            break;
    }
    //var quantity = $(e).closest(".countMenu").find(".countOfBook").html();
    var id = $(e).closest(".basketBook").attr("basket-id");
    var product = $(e).closest(".basketBook").attr("product-id");
    var delay = $(e).closest(".basketBook").attr("basket-delay");
    $.post("/ajax/ajax_add2basket.php", {quantity: quantity, id: id, product: product, delay: delay, action: 'update'}, function(data){
        $(".hidingBasketRight").html(data);
        var total_quant = parseInt($(".hidingBasketRight p.count").text().replace(/\D/g, ""));
        $(".BasketQuant").html(total_quant);
    });
    //update_basket(e);
}

function update_basket(e)
{
    var quantity = $(e).closest(".countMenu").find(".countOfBook").html();
    var id = $(e).closest(".basketBook").attr("basket-id");
    var product = $(e).closest(".basketBook").attr("product-id");
    var delay = $(e).closest(".basketBook").attr("basket-delay");
    $.post("/ajax/ajax_add2basket.php", {quantity: quantity, id: id, product: product, delay: delay, action: 'update'}, function(data){
        $(".hidingBasketRight").html(data);
        var total_quant = parseInt($(".hidingBasketRight p.count").text().replace(/\D/g, ""));
        $(".BasketQuant").html(total_quant);
    });
}
function delete_href(id){
    setTimeout(function() {
        $('.product'+id).attr('href', '')
    }, 150);
}

function addToCartTracking(productid, name, product_status) {
    //Функция нужна чтобы не вызывать ошибок там где она объявлена, подробностей не знаю
}

function addtocart(productid, name, product_status) {
    //product_status 22-нет в наличии;
    if(window.block_add_to_cart) {
        return false;
    }
    window.block_add_to_cart = true;

    quantity = $(".transparent_input").val();

	$(".inBasket").hide();
	$("#loadingInfo").show();

	$("a.product"+productid).find(".basketBook").css("background-color", "#A9A9A9");
    $("a.product"+productid).removeAttr("onclick");

    $.post('/ajax/ajax_add2basket.php', {action: "add", productid: productid, quantity:quantity, product_status:product_status}, function(data)
        {
			$("#loadingInfo").hide();
			$(".inBasket").show();
            $(".inBasket").css("background-color", "#A9A9A9");
            $(".inBasket").html("В корзине");

            $("#wishItem_"+productid+" a").css("background-color", "#A9A9A9");
            $("#wishItem_"+productid+" a").css("color", "white");
            $("#wishItem_"+productid+" a").html("В корзине");

            $(".inBasket").closest("a").attr("href", "/personal/cart/");
            $(".inBasket").closest("a").attr("title", "Перейти в корзину");
            $("#wishItem_"+productid+" a").attr("href", "/personal/cart");
            $("#wishItem_"+productid+" a").attr("title", "Перейти в корзину");
            $(".inBasket").closest("a").removeAttr("onclick");

            if ($("a.product"+productid).length > 0)
            {
                // для раздела каталога и карточки товара
                $("a.product"+productid).find(".basketBook").css("background-color", "#A9A9A9");
                $("a.product"+productid).find(".basketBook").html("Оформить");

                // для странциы результатов поиска
                $("a.product"+productid).find(".basket").css("background-color", "#A9A9A9");
                $("a.product"+productid).find(".basket").html("Оформить");
                $("a.product"+productid + " p").css('color', '#fff');

                $("a.product"+productid).attr("href", "/personal/cart/");
                $("a.product"+productid).attr("onclick", "");

            }
            $(".BasketQuant").css("display", "block");
            $(".hidingBasketRight").html(data);
            var total_quant = parseInt($(".hidingBasketRight p.count").text().replace(/\D/g, ""));
            $(".BasketQuant").html(total_quant);
            // обновляем блок с ценой и описанием до следующей скидки
            //$(".wrap_prise_top").load(window.location.href + " .wrap_prise_top > *");
			$('.busket_senk').show();
			setTimeout(function(){$('.busket_senk').fadeOut('fast')},2000);
            window.block_add_to_cart = false;
            return false;
    })
}

function addtocart_fromwishlist (productid, name, product_status) {
	$(".loadingInfo_"+productid).show();
	$(".wishlistBlock").find("a#wishItem_"+productid).hide();
    $.post('/ajax/ajax_add2basketfromwishlist.php', {action: "add", productid: productid, product_status: product_status}, function(data)
        {
            $(".wishlistBlock").find("a#wishItem_"+productid).css("background-color", "#A9A9A9");
            $(".wishlistBlock").find("a#wishItem_"+productid).css("color", "white");
            $(".wishlistBlock").find("a#wishItem_"+productid).html("В корзине");
            $(".wishlistBlock").find("a#wishItem_"+productid).attr("title", "Перейти в корзину");
            $(".wishlistBlock").find("a#wishItem_"+productid).addClass("goToCart");
            $("#basket_container").html(data);
            // $("#cardBlock2").html(data[1]);
            update_wishlist();
			$(".loadingInfo_"+productid).hide();
			$(".wishlistBlock").find("a#wishItem_"+productid).show();
    })
}

/***********
*
*  добавление в корзину и автоматическое оформление заказа на книгу, покупаемую в дар
*
* @param name - название подвешенного товара
* @param productid - ID подвешенного товара в инфоблоке товаров
* @param quantity - количество подвешенного товара, добавленного в заказ
* @return data :
* в случае успешного создания заказа - ID созданного заказа с подвешенным товаром
* в противном случае передаётся строка "err" и прерывается работа функции
*
*/
function add_giftbook (name, productid, quantity, email) {
    $.post('/ajax/ajax_addgiftbook.php', {name: name, productid: productid, quantity: quantity, email: email}, function(data) {
        if (data != "err") {
            if ($("a.product" + productid).length > 0) {
                document.location.href = "/personal/order/payment/?ORDER_ID=" + data;
            }
        }
    })
}

/********
* формирование списка купивших данный подвешенный товар
*
* @param item_id - ID подвешенного товара
* @return data - HTML-код таблицы с форматированным списком купивших товар и
* соответствующее кол-во купленного товара
* @var total_buyers_count - общее купленное кол-во подвешенного товара
*
*/
function makeGiftBuyersList (item_id) {
    $.post('/ajax/making_buyers_list.php', {item_id: item_id}, function(data) {
        if (data != "") {
            $(".layout").show();
            var winW = $(window).width(),
            blokT = window.pageYOffset + ($('.gifted_books_buyers_list').width() / 2),
            blokL = winW / 2 - ($('.gifted_books_buyers_list').width() / 2),
            total_buyers_count = 0;
            $('.gifted_books_buyers_list').css({
                "top" : blokT,
                "left": blokL
            });
            $(".gifted_books_buyers_list").show();
            $(".buyers_list").html(data);
            $(".buyers_list table tr:not(:first-child)").each(function(){
                total_buyers_count += parseInt($(this).find(".rounded_number").html());
            });
            $(".rounded_summary_number").html(total_buyers_count);
        }
    })
}
function update_wishlist () {
    $.post('/ajax/upd_wishlist.php', {}, function(data)
        {
            $('.cartMenuWrap .basketItems').removeClass("active");
            $(".cartMenuWrap .basketItems:nth-child(2)").addClass("active");
            $("#cardBlock1").hide();
            $("#cardBlock2").html(data);
            $("#cardBlock2").show();
            $(".cartMenuWrap .basketItems:nth-child(2) p span").html("<span>(" + $(".wishlistBlock .wishElement").size() + ")</span>");
            if($('.cartMenuWrap .basketItems').length > 0){
                $('.cartMenuWrap .basketItems').click(function(){
                    $('.cartMenuWrap .basketItems').removeClass("active");
                    $(this).addClass("active");
                    $('.yourBooks').hide();
                    $('#cardBlock'+$(this).attr('data-id')).show();
                })
            }

    });
}
function update_sect_page(sort, direction, sect_code) {
    $.post('/ajax/update_sect_page.php', {sort: sort, direction: direction, sect_code: sect_code}, function(data)
        {
            $(".cat_block").html(data);
            if($('.bestSlider').length > 0){
                easySlider('.bestSlider', 5);
            }

            if ($(".bestSlider ul li").size() < 6)
            {
                $(".bestSlider .left").hide();
                $(".bestSlider .rigth").hide();

            }
            $(".filterParams li").removeClass("active");
            switch (sort) {
                case "popularity":
                    $(".filterParams li:first-child").addClass("active");
                    break;
                case "date":
                    $(".filterParams li:nth-child(2)").addClass("active");
                    break;
                case "price":
                    $(".filterParams li:nth-child(3)").addClass("active");
                    break;
            }
            if (sort != "popularity" && direction == "desc") {
                $(".filterParams li.active").addClass("dir_desc");
            }
            $(".filterParams li.active").on("click", function(){
                if (direction == "asc")
                {
                    update_sect_page (sort, "desc", sect_code);
                }
                else if (sort != "popularity")
                {
                    update_sect_page (sort, "asc", sect_code);
                }
            })

            if (($(".filterParams li:nth-child(2)").hasClass("active")) && (direction == "desc"))
            {
                $(".filterParams li:nth-child(2)").css("width", "153px");
            }

            $('.categoryWrapper .leftMenu .firstLevel>li>a').click(function(){
                if ($(this).find("p").hasClass('activeListName')) {
                    $('.categoryWrapper .leftMenu li ul').hide();
                    $(this).find("p").removeClass('activeListName');
                }else{
                    $('.categoryWrapper .leftMenu>ul>li>p').removeClass('activeListName');
                    $(this).find("p").addClass('activeListName')
                    $('.categoryWrapper .leftMenu li ul').hide();
                    $(this).parent('li').find('ul').show();
                }
            })
    });
}

function delete_basket_item(productid) {

    $.post('/ajax/ajax_deletefrombasket.php', {productid: productid}, function(data)
        {
            $(".hidingBasketRight").html(data);
            var total_quant = parseInt($(".hidingBasketRight p.count").text().replace(/\D/g, ""));
            $(".BasketQuant").html(total_quant);
    })
}

function delete_wishlist_item(id) {

    $.post("/ajax/ajax_deletefromwishlist.php", {id: id}, function(data){
        if ($("#cardBlock2").size() > 0)
        {
            $("#cardBlock2").html(data);
            $(".cartMenuWrap .basketItems:last-child span").html("(" + $(".wishlistBlock .wishElement").size() + ")");
        }
        else
        {
            $(".wishlistWrapp").html(data);
            $(".wishBookDescription").each(function()
                {
                    if($(this).length > 0)
                    {
                        $(this).html(truncate($(this).html(), 250));
                    }
            });
        }
    });
}

function parseGetParams() {
    var $_GET = {};
    var __GET = window.location.search.substring(1).split("&");
    for(var i=0; i<__GET.length; i++) {
        var getVar = __GET[i].split("=");
        $_GET[getVar[0]] = typeof(getVar[1])=="undefined" ? "" : getVar[1];
    }
    return $_GET;
}



function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
function isTelephone(telephone){
    //var regex = /^((8|\+7)[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{5,10}$/;
var regex = /^((\+[0-9]{1})[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{5,10}$/;
    return regex.test(telephone);
}


/*function CheckingExistingEmail() {
$.post('/ajax/CheckingExistingEmail.php', {email: $("#ORDER_PROP_6").val()}, function(data)
{
//$("#hidden_email").html($("#ORDER_PROP_6").html());
$("#ORDER_PROP_6").attr("value", data);
chekingFields("Y");
})
} */

function chekingFields(parametr){
    var flag = true;
    /*$('input.clientInfo').each(function(){
    if($(this).val() == ""){
    flag = false;
    $(this).parent("div").children(".warningMessage").show();
    }else{
    $(this).parent("div").children(".warningMessage").hide();
    }
    })*/

    if($('#ORDER_PROP_7').val() == ''){
        flag = false;
        $('#ORDER_PROP_7').parent("div").children(".warningMessage").show();
        // сперва получаем позицию элемента относительно документа
        var scrollTop = $('#ORDER_PROP_7').offset().top;
        $(document).scrollTop(scrollTop);
        document.getElementById("ORDER_PROP_7").focus();
    }

    if(isEmail($('#ORDER_PROP_6').val()) == false){
        flag = false;
        $('#ORDER_PROP_6').parent("div").children(".warningMessage").html('Некорректно введен e-mail');
        $('#ORDER_PROP_6').parent("div").children(".warningMessage").show();
        var scrollTop = $('#ORDER_PROP_6').offset().top;
        $(document).scrollTop(scrollTop);
        document.getElementById("ORDER_PROP_6").focus();
    }

    if(isTelephone($('#ORDER_PROP_24').val()) == false){
        flag = false;
        $('#ORDER_PROP_24').parent("div").children(".warningMessage").show();
        var scrollTop = $('#ORDER_PROP_24').offset().top;
        $(document).scrollTop(scrollTop);
        document.getElementById("ORDER_PROP_24").focus();
    }
    var deliveryFlag= false;
    $('input[name=DELIVERY_ID]').each(function(){
        if($(this).prop("checked")){
            deliveryFlag = true;
        }
    })
    if(deliveryFlag == false){
        flag = false;
        $('.deliveriWarming').show();
    }

    if($('#ORDER_PROP_7').val() == false){
        flag = false;
        $('#ORDER_PROP_7').parent("div").children(".warningMessage").show();
    }


    if(flag){
        submitForm(parametr);
    }

    return false;
}

function updateSearchPage() {

    $('.showMore').hide();

    $(".bookName").each(function() {
        if($(this).length > 0) {
            $(this).html(truncate($(this).html(), 20));
        }
    });

    /*$(".descrWrap .bookNames").each(function() {
    if($(this).length > 0) {
    $(this).html(truncate($(this).html(), 50));
    }
    });*/
    $(".descrWrap .description").each(function() {
            if($(this).length > 0) {
                $(this).html(truncate($(this).html(), 120));
            }
    });
    if($('.bookEasySlider').length > 0) {
        easySlider('.bookEasySlider', 6);
    }
}

//book subscribe (in product card)
function newSubFunction(submitButton){
    var book_id = submitButton.previousElementSibling.dataset.book_id;
    var sub_mail = submitButton.previousElementSibling.value;
    var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(re.test(sub_mail)){
        $.post("/ajax/book_subscribe.php", {
            book_id : book_id,
            sub_mail : sub_mail
            }, function(data) {
                if(data.match(/exist/)){
                    $(".subscr_result").html("Вы уже подписаны на появление данной книги в продаже");
                    $(".layout").show();
                    $(".subscr_result").show();
                    //alert("Вы уже подписаны на появление данной книги в продаже.");
                }else if(data.match(/success/)){
                    (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() { rrApi.setEmail(sub_mail);});                    
                    $(".subscr_result").html("Мы сообщим Вам о появлении книги");
                    $(".layout").show();
                    $(".subscr_result").show();
                    //alert("Мы сообщим Вам о появлении книги.");
                }
        });
    } else {
        $(".subscr_result").html("Введите корректный e-mail адрес.");
        $(".subscr_result").show();
        $(".layout").show();
    }
}

function CheckRequestFields() {
    var emailAddres = $('.giftWrap input[type=text]').val();
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (regex.test(emailAddres)) {
        $.post("/ajax/request_add.php", {email: $(".giftWrap input[type=text]").val()}, function(data){
            $(".layout").show();
            $(".some_info").show();
            $(".some_info").html(data);
            (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() { rrApi.setEmail(emailAddres);});
        })
    }
    else {
        $(".layout").show();
        $(".some_info").show();
        $(".some_info").html('Кажется, вы ошиблись в написании своего адреса');
    }
}

function SubmitRequest(e){
    if (e.keyCode == 13) {
        CheckRequestFields();
    }
    return false;
}

$(function() {
	$('body').append('<div style="width:64px;background:#85959a; height:64px; border-radius:80px;text-align:center; position:fixed; bottom:10px; right:10px; cursor:pointer; display:none; color:#fff; font-family:\'Walshein_black\'; font-size:40px;" id="toTop" class="no-mobile">↑</div>');
	$(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});
	$('#toTop').click(function() {
		$('body,html').animate({scrollTop:0},800);
	});
});

//Переключение между вкладками элетронных книги и бумажных в карточке товара
function selectversion(cl,id) {
	if (cl == "passive") {
		$("#diffversions").find(".passive").removeClass("passive").addClass("temp");
		$("#diffversions").find(".active").removeClass("active").addClass("passive");
		$("#diffversions").find(".temp").addClass("active").removeClass("temp");
	}
	if (id == "paperversion") {
		$(".paperVersionWrap, .digitalBookMark, .typesOfProduct, .shippings, .buyLater, .epubHide").show();
		$(".digitalVersionWrap, .epub").hide();
	} else {
		$(".paperVersionWrap, .digitalBookMark, .typesOfProduct, .shippings, .buyLater, .epubHide").hide();
		$(".digitalVersionWrap, .epub").show();
	}
	var bookName = $(".productName").text();
	dataLayer.push({'event' : 'selectVersion', 'action' : id+' '+cl, 'label': bookName});
	return false;
}

function docReadyComponent(id) {
    function buy_certificate_popup(){
        $('body').find('.layout').show();
        $('body').find('.certificate_popup').show();
    }
    function create_certificate_order(){
        var form_valid = true;
        var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
        // просматриваем все поля на предмет заполненности
        $(".active_certificate_block input").each(function(){
            if (!$(this).val()) {
                form_valid = false;
                $(this).css("border-color", "red");
            } else {
                if ($(this).attr("name") == 'natural_email' || $(this).attr("name") == 'legal_email') {
                    if (!(pattern.test($(this).val()))) {
                        form_valid = false;
                        $(this).css("border-color", "red");
                    } else {
                        $(this).css("border-color", "#f0f0f0");
                    }
                }
            }
        });
        // если все ок, то сабмитим
        if (form_valid) {
            var natural_person_email = $("#natural_email").val(),
            selected_tab = $(".certificate_tab_active").data("popup-block");
            $("input[name='certificate_quantity']").val($(".transparent_input").val());
            var certificate_price = parseInt($("input[name='certificate_price']").val());
            var certificate_quantity = parseInt($(".transparent_input").val());
            $.ajax({
                url: '/ajax/ajax_create_certificate_order.php',
                type: "POST",
                data: {
                    data: $("#certificate_form").serialize(),
                    person_type: selected_tab
                }
            }).done(function(result) {
                var certificate_result = JSON.parse(result);
                if (certificate_result.status == "success") {
                    order_id = certificate_result.data;
                    $("#certificate_form").remove();
                    if (selected_tab == "natural_person") {
                        // физ. лицо
                        var success_message = "<?= GetMessage('NATURAL_SUCCESS_MESSAGE') ?>";
                        $(".submit_rfi").attr("data-email", natural_person_email);
                        $(".submit_rfi").attr("data-comment", "CERT_" + order_id);
                        $(".submit_rfi").attr("data-orderid", "CERT_" + order_id);
                        $(".submit_rfi").attr("data-cost", certificate_price * certificate_quantity);
                        $(".submit_rfi").click();
                        $("<span>" + success_message.replace("#NUM#", order_id) + "</span>").insertBefore(".certificate_popup_close");
                    } else {
                        // юр. лицо
                        var success_message = "<?= GetMessage('LEGAL_SUCCESS_MESSAGE') ?>";
                        $("<span>" + success_message.replace("#NUM#", order_id) + "</span>").insertBefore(".certificate_popup_close");
                    }
                } else {
                    console.error(certificate_result.data);
                }
            });
        }
    }
    // переключение табов в попапе
    $(".certificate_buy_type li").click(function() {
        if(!$(this).hasClass("certificate_tab_active")) {
            $(".certificate_buy_type li").removeClass("certificate_tab_active");
            $(this).addClass("certificate_tab_active");
            $(".popup_form_data > div").removeClass("active_certificate_block");
            $("div[class='" + $(this).data("popup-block") + "']").addClass("active_certificate_block");
        }
    });
    // закрытие попапа
    $(".certificate_popup_close").click(function(){
        $(".certificate_popup").hide();
        $('.layout').hide();
    })

	$(".element_item_img").hover(
	  function() {
		$(this).find('img').css({'filter':'grayscale(0.7)', '-webkit-filter':'grayscale(0.7)', '-moz-filter':'grayscale(0.7)', '-o-filter':'grayscale(0.7)', '-ms-filter':'grayscale(0.7)'});
		$('.bookPreviewButton').css('display','block');
	  }, function() {
		$(this).find('img').css({'filter':'none', '-webkit-filter':'none', '-moz-filter':'none', '-o-filter':'none', '-ms-filter':'none'});
		$('.bookPreviewButton').css('display','none');
	  }
	);

	//скрытие текста в карточке товара
    if($('.showAllWrapp').length > 0){
		var descHeight = parseInt($('.showAllWrapp').css('height').slice(0,-2));
		var leftBlockHeight = parseInt($('.elementDescriptWrap .leftColumn').css('height').slice(0,-2));

		if ($("div").is('.videoWrapp'))
			var videoHeight = 321;
		else
			var videoHeight = 0;

        if(descHeight > leftBlockHeight) {
            $('.showAllWrapp').append('<p class="readMore"><span>Читать далее...</span></p>');
            $('.showAllWrapp').css('height',leftBlockHeight - videoHeight - 300 +'px');
        }

        $('.readMore').click(function(){
            $('.showAllWrapp').css('height','auto');
            $('.readMore').hide();
        })
    }

	if($('.wishlist_info').length > 0){
		$('.layout').click(function(){
			if($('.wishlist_info').css('display') == 'block'){
				$(this).hide();
				$('.wishlist_info').hide();
			}
		})
	}



	if($('.videoWrapp').length > 0){
		$('.videoWrapp iframe:nth-child(1)').show();
	}
	if($('.productSelectTitle').length > 0){
		$('.productSelectTitle').click(function(){
			$('.videoWrapp iframe').show();
			return false;
		})
	}

	if($(".some_info").length > 0){
		$('.layout').click(function(){
			$('.some_info').hide();
			$(this).hide();
		})
	}

	if($(".subscr_result").length > 0){
		$('.layout').click(function(){
			$('.subscr_result').hide();
			$(this).hide();
		})
	}

	$(".giftWrap input[type=button]").click(function(){

		CheckRequestFields();
	});

	// скрывать всплывайки при нажатии на любом свободном месте
	$(".some_info").click(function(){
		$(".some_info").hide();
		$(".layout").hide();
	});

	// скрывать стрелки слайдера, если элементов меньше 6
	if ($(".saleSlider ul li").size() < 6) {
		$(".saleSlider .left").hide();
		$(".saleSlider .right").hide();
	}

	if ($(".otherEasySlider ul li").size() < 6) {
		$(".otherEasySlider .left").hide();
		$(".otherEasySlider .rigth").hide();
	}

	// если блок "Мероприятия товара" отображается - поправить вёрстку страницы автора

	if ($(".autorInfo .events").css("display") == "block") {
		$(".content").css("min-height", "840px");
	}

	if ($(".autorInfo .textWrap").height() > 300) {
		$(".content .catalogWrapper").css("height", $(".autorInfo .textWrap").height() + 100 + "px");
	}

	if($('#authorisationPopup').length > 0){
		$('#authorisationPopup').click(function(e){
			e.preventDefault();
			$('.layout').show();

			var winH = $(window).height();
			var winW = $(window).width();
			var blokT = winH / 2 - ($('.authorisationWrapper').height() / 2);
			var blokL = winW / 2 - ($('.authorisationWrapper').width() / 2);
			$('.authorisationWrapper').css({
				"top" : blokT,
				"left": blokL
			});

			$('.authorisationWrapper').show();
		})
	}

	if($('#authorisationClose').length > 0){
		$('#authorisationClose, .layout').click(function(){
			$('.layout').hide();
			$('.authorisationWrapper').hide();
		})
	}
	if($('.signinWrapper').length > 0){
		$('.registrationLink').click(function(){
			$(this).addClass('active');
			$('.signinLink').removeClass('active');
			$('.signinBlock').hide();
			$('.registrationBlock').show();
		});
		$('.signinLink').click(function(){
			$(this).addClass('active');
			$('.registrationLink').removeClass('active');
			$('.signinBlock').show();
			$('.registrationBlock').hide();
		})
	}

    //Если возникнут проблемы с корзиной нужно вернуть
	//update_quant();


	if ($(".hidingBasketRight .basketBooks .basketBook").length == 0) {
		$(".BasketQuant").css("display", "none");
	}
	//плавающий блок в карточке товара
	/*if(('.productElementWrapp').length >0){
	if ($(window).scrollTop() > $('.productAction').offset().top + $('.productAction').height() ){
	$('.priceBasketWrap').css({'position':'fixed', 'top':'20px', 'left':'20px'})
	};
	}*/
	//картока товара. Раскрытие торговых предложений
	if ($('.elementDescriptWrap .otherTypes').length > 0){
		$('.elementDescriptWrap .otherTypes').click(function(){
			var wrapBlockHeight = $('.typesOfProduct').height();
			var countType = $('.productType').length;
			var BLOCKSINLINE = 3;//это так по дизайну
			var lines = Math.ceil(countType/BLOCKSINLINE);
			if ($('.typesOfProduct').height() < 180)
			{
				$('.typesOfProduct').height(wrapBlockHeight*lines);
			}
		});
	};

	//смена блоков на детальной карточке
	if($('.productElementWrapp').length >0){
		$('.productsMenu li').click(function(){
			$('.productsMenu li').removeClass('active');
			$(this).addClass('active');
			$('#prodBlock1, #prodBlock2, #prodBlock3, #prodBlock4, #prodBlock5').hide();
			$('#prodBlock'+$(this).attr('data-id')).show();
			if (!$(".productsMenu li:first-child").hasClass("active"))
			{
				//$(".productsMenu li:first-child").css("width", "90px");
			}
			else
			{
			   // $(".productsMenu li:first-child").css("width", "110px");
			}
			if ($(".productsMenu li:nth-child(2)").hasClass("active"))
			{
				//$(".productsMenu li:nth-child(2)").css("width", "105px");
			}
			else
			{

			}
			$(".productsMenu li:not(:first-child, :nth-child(2))").each(function(){
				if (!$(this).hasClass("active"))
				{
				   // $(this).css("width", "80px");
				}
				else
				{
				  //  $(this).css("width", "91px");
				}
			});
			if ($("#prodBlock3").css("display") == "block") {
				$("#prodBlock3").css("height", $(".ReviewsFormWrap").height() + 90);
			}
		})
	}


	//Верхнее меню на главной
	$(window).scroll(function(){
		$('.slidingTopMenu').show();
		/*$(".footer_search_form").html($(".searchWrap .catalogWrapper").html());
		$(".searchWrap .catalogWrapper").html("");
		$(".headFind").each(function(){
		$(this).removeClass("headFind");
		$(this).addClass("headFindCatalog");
		});*/
		if($(window).scrollTop() == 0){
			$('.slidingTopMenu').hide();
			/*$(".searchWrap .catalogWrapper").html($(".footer_search_form").html());
			$(".footer_search_form").html("");
			$(".headFindCatalog").each(function(){
			$(this).removeClass("headFindCatalog");
			$(this).addClass("headFind");
			});*/

		}
	})

	$(".bookName").each(function()
		{
			if($(this).length > 0)
			{
				$(this).html(truncate($(this).html(), 32));
			}
		}
	);





	$('.slideWrapp li').css('width',$(window).width()+'px');



	var widthOfSlide = '196px';
	var intwidthOfSlide = 196;
	var countLi = $('.saleWrapp ul li').size();
	if (countLi < 6) {
		$(".saleWrapp .left").hide();
		$(".saleWrapp .right").hide();
	}
	//alert(attrLeft[0]);
	$(".saleWrapp .right").on("click", function(){
		attrLeft = $(".saleWrapp ul").css("left").split("px");
		if (attrLeft[0] <= -(countLi-7)*intwidthOfSlide)
		{
			$('.saleWrapp .right').hide();
		}
	});

	$(".otherEasySlider .right").on("click", function(){
		attrLeft = $(".otherEasySlider ul").css("left").split("px");
		if (attrLeft[0] <= -(countLi-7)*intwidthOfSlide)
		{
			$('.otherEasySlider .rigth').hide();
		}
	});

	 $(".authorBoolSlider .rigth").on("click", function(){
		$(".authorBoolSlider .left").show();
		attrLeft = $(".authorBoolSlider ul").css("left").split("px");
		if (attrLeft[0] <= -(countLi-7)*intwidthOfSlide)
		{
			$('.authorBoolSlider .rigth').hide();
		}
	});

	$(".authorBoolSlider .left").on("click", function(){
		$(".authorBoolSlider .rigth").show();
		if ($(".authorBoolSlider ul").css("left") == '-'+widthOfSlide)
		{
			$('.authorBoolSlider .left').hide();
		}
	});

	var ulWidth = (countLi-7) * widthOfSlide.slice(0, -2);

	$('.saleWrapp .left').click(function(){
		$('.saleWrapp ul').animate({left:'+='+ widthOfSlide},500);
		$('.saleWrapp .right').show();

		if($('.saleWrapp ul').css('left') == '-'+widthOfSlide){
			$('.saleWrapp .left').hide();
		}
	})

	$('.otherEasySlider .left').click(function(){
		$('.otherEasySlider ul').animate({left:'+='+ widthOfSlide},500);
		$('.otherEasySlider .rigth').show();

		if($('.otherEasySlider ul').css('left') == '-'+widthOfSlide){
			$('.otherEasySlider .left').hide();
		}
	})

	$('.saleWrapp .right').click(function(){
		$('.saleWrapp ul').animate({left:'-='+ widthOfSlide},500);
		$('.saleWrapp .left').show();

		if($('.saleWrapp ul').css('left') == '-'+ulWidth+'px'){
			$('.saleWrapp .right').hide();
		}
	})
	if($('.saleWrapp ul').css('left') == '0px'){
		$('.saleWrapp .left').hide();
	}

	var widthOfSlideReccomend = '196px';
	var intwidthOfSlideReccomend = 196;
	var countLiRec = $('.recomendation ul li').size();
	if (countLiRec < 7) {
		$(".recomendation .left").hide();
		$(".recomendation .right").hide();
	}
	var ulWidthRec = (countLi-7) * widthOfSlideReccomend.slice(0, -2);
	$(".recomendation .right").on("click", function(){
		attrLeft = $(this).closest(".recomendation").find("ul").css("left").split("px");
		if (attrLeft[0] <= -(countLi-7)*intwidthOfSlideReccomend)
		{
			$(this).hide();
		}
	});
	$('.recomendation .left').click(function(){
		$(this).closest(".recomendation").find("ul").animate({left:'+='+ widthOfSlideReccomend},500);
		$(this).closest(".recomendation").find(".right").show();

		if($(this).closest(".recomendation").find("ul").css('left') == '-'+widthOfSlideReccomend){
			$(this).closest(".recomendation").find(".left").hide();
		}
	})
	$('.recomendation .right').click(function(){
		$(this).closest(".recomendation").find("ul").animate({left:'-='+ widthOfSlideReccomend},500);
		$(this).closest(".recomendation").find(".left").show();

		if($(this).closest(".recomendation").find("ul").css('left') == '-'+ulWidthRec+'px'){
			$(this).closest(".recomendation").find(".right").hide();
		}
	})
	$(".recomendation").each(function(){
		if($(this).find('ul').css('left') == '0px'){
			$(this).find('.left').hide();
		}
	});


	// слайдер отзывов на главной
	if (typeof fxSlider == 'function'){
		fxSlider('bigSlider','left','right', false, 500,3);
	}



	//убираем placeholder поиск вверху главной
	$('#title-search-input-top').focus(function(){
		$(this).data('placeholder',$(this).attr('placeholder'))
		$(this).attr('placeholder','');
	});
	$('#title-search-input-top').blur(function(){
		$(this).attr('placeholder',$(this).data('placeholder'));
	});

	$(".books > ul span").mouseout(function(){
		clearTimeout(BlocksChangingFunc);
	})

	//Progress Bar START
	$('a:not(.ajax_link, #digitalversion)').click(function() {
		var link = $(this).attr("href");
		var target = $(this).attr("target");
		if (!$(this).parents().hasClass('leftMenu') && !$(this).parents().hasClass('hidingCatalogLeft')) {
			if (!link.match(/([\#\(\)]|pdf|freedigitalbooks|\/personal\/cart\/|\/personal\/profile\/|info\_popup|ADD2BASKET)|\/personal\/profile\//) && target != "_blank") {
				NProgress.start();
			};
		}
	});
	NProgress.set(0.6);
	setTimeout(function() { NProgress.done();}, 200);
	//Progress Bar END

	$(".stopProp").click(function(e){
		e.stopPropagation();
	});

	$(".catalogIcon").html("<span>Каталог</span>");
	$(".basketIcon").html("<span>Корзина</span>");
}

/*
jquery-circle-progress - jQuery Plugin to draw animated circular progress bars

URL: http://kottenator.github.io/jquery-circle-progress/
Author: Rostyslav Bryzgunov <kottenator@gmail.com>
Version: 1.1.3
License: MIT
*/
(function($) {
    function CircleProgress(config) {
        this.init(config);
    }

    CircleProgress.prototype = {
        //----------------------------------------------- public options -----------------------------------------------
        /**
         * This is the only required option. It should be from 0.0 to 1.0
         * @type {number}
         */
        value: 0.0,

        /**
         * Size of the circle / canvas in pixels
         * @type {number}
         */
        size: 100.0,

        /**
         * Initial angle for 0.0 value in radians
         * @type {number}
         */
        startAngle: -Math.PI,

        /**
         * Width of the arc. By default it's auto-calculated as 1/14 of size, but you may set it explicitly in pixels
         * @type {number|string}
         */
        thickness: 'auto',

        /**
         * Fill of the arc. You may set it to:
         *   - solid color:
         *     - { color: '#3aeabb' }
         *     - { color: 'rgba(255, 255, 255, .3)' }
         *   - linear gradient (left to right):
         *     - { gradient: ['#3aeabb', '#fdd250'], gradientAngle: Math.PI / 4 }
         *     - { gradient: ['red', 'green', 'blue'], gradientDirection: [x0, y0, x1, y1] }
         *   - image:
         *     - { image: 'http://i.imgur.com/pT0i89v.png' }
         *     - { image: imageObject }
         *     - { color: 'lime', image: 'http://i.imgur.com/pT0i89v.png' } - color displayed until the image is loaded
         */
        fill: {
            gradient: ['#3aeabb', '#fdd250']
        },

        /**
         * Color of the "empty" arc. Only a color fill supported by now
         * @type {string}
         */
        emptyFill: 'rgba(0, 0, 0, .1)',

        /**
         * Animation config (see jQuery animations: http://api.jquery.com/animate/)
         */
        animation: {
            duration: 1200,
            easing: 'circleProgressEasing'
        },

        /**
         * Default animation starts at 0.0 and ends at specified `value`. Let's call this direct animation.
         * If you want to make reversed animation then you should set `animationStartValue` to 1.0.
         * Also you may specify any other value from 0.0 to 1.0
         * @type {number}
         */
        animationStartValue: 0.0,

        /**
         * Reverse animation and arc draw
         * @type {boolean}
         */
        reverse: false,

        /**
         * Arc line cap ('butt', 'round' or 'square')
         * Read more: https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D.lineCap
         * @type {string}
         */
        lineCap: 'butt',

        //-------------------------------------- protected properties and methods --------------------------------------
        /**
         * @protected
         */
        constructor: CircleProgress,

        /**
         * Container element. Should be passed into constructor config
         * @protected
         * @type {jQuery}
         */
        el: null,

        /**
         * Canvas element. Automatically generated and prepended to the {@link CircleProgress.el container}
         * @protected
         * @type {HTMLCanvasElement}
         */
        canvas: null,

        /**
         * 2D-context of the {@link CircleProgress.canvas canvas}
         * @protected
         * @type {CanvasRenderingContext2D}
         */
        ctx: null,

        /**
         * Radius of the outer circle. Automatically calculated as {@link CircleProgress.size} / 2
         * @protected
         * @type {number}
         */
        radius: 0.0,

        /**
         * Fill of the main arc. Automatically calculated, depending on {@link CircleProgress.fill} option
         * @protected
         * @type {string|CanvasGradient|CanvasPattern}
         */
        arcFill: null,

        /**
         * Last rendered frame value
         * @protected
         * @type {number}
         */
        lastFrameValue: 0.0,

        /**
         * Init/re-init the widget
         * @param {object} config - Config
         */
        init: function(config) {
            $.extend(this, config);
            this.radius = this.size / 2;
            this.initWidget();
            this.initFill();
            this.draw();
        },

        /**
         * @protected
         */
        initWidget: function() {
            var canvas = this.canvas = this.canvas || $('<canvas>').prependTo(this.el)[0];
            canvas.width = this.size;
            canvas.height = this.size;
            this.ctx = canvas.getContext('2d');
        },

        /**
         * This method sets {@link CircleProgress.arcFill}
         * It could do this async (on image load)
         * @protected
         */
        initFill: function() {
            var self = this,
                fill = this.fill,
                ctx = this.ctx,
                size = this.size;

            if (!fill)
                throw Error("The fill is not specified!");

            if (fill.color)
                this.arcFill = fill.color;

            if (fill.gradient) {
                var gr = fill.gradient;

                if (gr.length == 1) {
                    this.arcFill = gr[0];
                } else if (gr.length > 1) {
                    var ga = fill.gradientAngle || 0, // gradient direction angle; 0 by default
                        gd = fill.gradientDirection || [
                            size / 2 * (1 - Math.cos(ga)), // x0
                            size / 2 * (1 + Math.sin(ga)), // y0
                            size / 2 * (1 + Math.cos(ga)), // x1
                            size / 2 * (1 - Math.sin(ga))  // y1
                        ];

                    var lg = ctx.createLinearGradient.apply(ctx, gd);

                    for (var i = 0; i < gr.length; i++) {
                        var color = gr[i],
                            pos = i / (gr.length - 1);

                        if ($.isArray(color)) {
                            pos = color[1];
                            color = color[0];
                        }

                        lg.addColorStop(pos, color);
                    }

                    this.arcFill = lg;
                }
            }

            if (fill.image) {
                var img;

                if (fill.image instanceof Image) {
                    img = fill.image;
                } else {
                    img = new Image();
                    img.src = fill.image;
                }

                if (img.complete)
                    setImageFill();
                else
                    img.onload = setImageFill;
            }

            function setImageFill() {
                var bg = $('<canvas>')[0];
                bg.width = self.size;
                bg.height = self.size;
                bg.getContext('2d').drawImage(img, 0, 0, size, size);
                self.arcFill = self.ctx.createPattern(bg, 'no-repeat');
                self.drawFrame(self.lastFrameValue);
            }
        },

        draw: function() {
            if (this.animation)
                this.drawAnimated(this.value);
            else
                this.drawFrame(this.value);
        },

        /**
         * @protected
         * @param {number} v - Frame value
         */
        drawFrame: function(v) {
            this.lastFrameValue = v;
            this.ctx.clearRect(0, 0, this.size, this.size);
            this.drawEmptyArc(v);
            this.drawArc(v);
        },

        /**
         * @protected
         * @param {number} v - Frame value
         */
        drawArc: function(v) {
            var ctx = this.ctx,
                r = this.radius,
                t = this.getThickness(),
                a = this.startAngle;

            ctx.save();
            ctx.beginPath();

            if (!this.reverse) {
                ctx.arc(r, r, r - t / 2, a, a + Math.PI * 2 * v);
            } else {
                ctx.arc(r, r, r - t / 2, a - Math.PI * 2 * v, a);
            }

            ctx.lineWidth = t;
            ctx.lineCap = this.lineCap;
            ctx.strokeStyle = this.arcFill;
            ctx.stroke();
            ctx.restore();
        },

        /**
         * @protected
         * @param {number} v - Frame value
         */
        drawEmptyArc: function(v) {
            var ctx = this.ctx,
                r = this.radius,
                t = this.getThickness(),
                a = this.startAngle;

            if (v < 1) {
                ctx.save();
                ctx.beginPath();

                if (v <= 0) {
                    ctx.arc(r, r, r - t / 2, 0, Math.PI * 2);
                } else {
                    if (!this.reverse) {
                        ctx.arc(r, r, r - t / 2, a + Math.PI * 2 * v, a);
                    } else {
                        ctx.arc(r, r, r - t / 2, a, a - Math.PI * 2 * v);
                    }
                }

                ctx.lineWidth = t;
                ctx.strokeStyle = this.emptyFill;
                ctx.stroke();
                ctx.restore();
            }
        },

        /**
         * @protected
         * @param {number} v - Value
         */
        drawAnimated: function(v) {
            var self = this,
                el = this.el,
                canvas = $(this.canvas);

            // stop previous animation before new "start" event is triggered
            canvas.stop(true, false);
            el.trigger('circle-animation-start');

            canvas
                .css({ animationProgress: 0 })
                .animate({ animationProgress: 1 }, $.extend({}, this.animation, {
                    step: function (animationProgress) {
                        var stepValue = self.animationStartValue * (1 - animationProgress) + v * animationProgress;
                        self.drawFrame(stepValue);
                        el.trigger('circle-animation-progress', [animationProgress, stepValue]);
                    }
                }))
                .promise()
                .always(function() {
                    // trigger on both successful & failure animation end
                    el.trigger('circle-animation-end');
                });
        },

        /**
         * @protected
         * @returns {number}
         */
        getThickness: function() {
            return $.isNumeric(this.thickness) ? this.thickness : this.size / 14;
        },

        getValue: function() {
            return this.value;
        },

        setValue: function(newValue) {
            if (this.animation)
                this.animationStartValue = this.lastFrameValue;
            this.value = newValue;
            this.draw();
        }
    };

    //-------------------------------------------- Initiating jQuery plugin --------------------------------------------
    $.circleProgress = {
        // Default options (you may override them)
        defaults: CircleProgress.prototype
    };

    // ease-in-out-cubic
    $.easing.circleProgressEasing = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1)
            return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    };

    /**
     * Draw animated circular progress bar.
     *
     * Appends <canvas> to the element or updates already appended one.
     *
     * If animated, throws 3 events:
     *
     *   - circle-animation-start(jqEvent)
     *   - circle-animation-progress(jqEvent, animationProgress, stepValue) - multiple event;
     *                                                                        animationProgress: from 0.0 to 1.0;
     *                                                                        stepValue: from 0.0 to value
     *   - circle-animation-end(jqEvent)
     *
     * @param configOrCommand - Config object or command name
     *     Example: { value: 0.75, size: 50, animation: false };
     *     you may set any public property (see above);
     *     `animation` may be set to false;
     *     you may use .circleProgress('widget') to get the canvas
     *     you may use .circleProgress('value', newValue) to dynamically update the value
     *
     * @param commandArgument - Some commands (like 'value') may require an argument
     */
    $.fn.circleProgress = function(configOrCommand, commandArgument) {
        var dataName = 'circle-progress',
            firstInstance = this.data(dataName);

        if (configOrCommand == 'widget') {
            if (!firstInstance)
                throw Error('Calling "widget" method on not initialized instance is forbidden');
            return firstInstance.canvas;
        }

        if (configOrCommand == 'value') {
            if (!firstInstance)
                throw Error('Calling "value" method on not initialized instance is forbidden');
            if (typeof commandArgument == 'undefined') {
                return firstInstance.getValue();
            } else {
                var newValue = arguments[1];
                return this.each(function() {
                    $(this).data(dataName).setValue(newValue);
                });
            }
        }

        return this.each(function() {
            var el = $(this),
                instance = el.data(dataName),
                config = $.isPlainObject(configOrCommand) ? configOrCommand : {};

            if (instance) {
                instance.init(config);
            } else {
                var initialConfig = $.extend({}, el.data());
                if (typeof initialConfig.fill == 'string')
                    initialConfig.fill = JSON.parse(initialConfig.fill);
                if (typeof initialConfig.animation == 'string')
                    initialConfig.animation = JSON.parse(initialConfig.animation);
                config = $.extend(initialConfig, config);
                config.el = el;
                instance = new CircleProgress(config);
                el.data(dataName, instance);
            }
        });
    };
})(jQuery);

//Обратный отсчет для акций
function updater(d, h, m, s) {
	var baseTime = new Date();
	baseTime.setTime(baseTime.getTime() + 1000*60*60*24);
	var baseTime = new Date(2017, 8, 4);

	// Период сброса — 3 дня
	var period = 3*24*60*60*1000;

	function update() {
		var cur = new Date();
		// сколько осталось миллисекунд
		//var diff = period - (cur - baseTime) % period;
		var diff = baseTime - cur;
		// сколько миллисекунд до конца секунды
		var millis = diff % 1000;
		diff = Math.floor(diff/1000);
		// сколько секунд до конца минуты
		var sec = diff % 60;
		if(sec < 10) sec = "0"+sec;
		diff = Math.floor(diff/60);
		// сколько минут до конца часа
		var min = diff % 60;
		if(min < 10) min = "0"+min;
		diff = Math.floor(diff/60);
		// сколько часов до конца дня
		var hours = diff % 24;
		if(hours < 10) hours = "0"+hours;
		var days = Math.floor(diff / 24);

		d.innerHTML = days;
		h.innerHTML = hours;
		m.innerHTML = min;
		s.innerHTML = sec;

		// следующий раз вызываем себя, когда закончится текущая секунда
		setTimeout(update, millis);
	}

	setTimeout(update, 0);
}
//updater(document.getElementById("days"),document.getElementById("hours"), document.getElementById("minutes"),document.getElementById("seconds"));

/**
 * jquery.mask.js
 * @version: v1.7.7
 * @author: Igor Escobar
 *
 * Created by Igor Escobar on 2012-03-10. Please report any bug at http://blog.igorescobar.com
 *
 * Copyright (c) 2012 Igor Escobar http://blog.igorescobar.com
 *
 * The MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */
/*jshint laxbreak: true */
/* global define */

// UMD (Universal Module Definition) patterns for JavaScript modules that work everywhere.
// https://github.com/umdjs/umd/blob/master/jqueryPlugin.js
(function (factory) {
    if (typeof define === "function" && define.amd) {
        // AMD. Register as an anonymous module.
        define(["jquery"], factory);
    } else {
        // Browser globals
        factory(window.jQuery || window.Zepto);
    }
}(function ($) {
    "use strict";
    var Mask = function (el, mask, options) {
        var jMask = this, old_value, regexMask;
        el = $(el);

        mask = typeof mask === "function" ? mask(el.val(), undefined, el,  options) : mask;

        var p = {
            getCaret: function () {
                try {
                    var sel,
                        pos = 0,
                        ctrl = el.get(0),
                        dSel = document.selection,
                        cSelStart = ctrl.selectionStart;

                    // IE Support
                    if (dSel && !~navigator.appVersion.indexOf("MSIE 10")) {
                        sel = dSel.createRange();
                        sel.moveStart('character', el.is("input") ? -el.val().length : -el.text().length);
                        pos = sel.text.length;
                    }
                    // Firefox support
                    else if (cSelStart || cSelStart === '0') {
                        pos = cSelStart;
                    }

                    return pos;
                } catch (e) {}
            },
            setCaret: function(pos) {
                try {
                    if (el.is(":focus")) {
                        var range, ctrl = el.get(0);

                        if (ctrl.setSelectionRange) {
                            ctrl.setSelectionRange(pos,pos);
                        } else if (ctrl.createTextRange) {
                            range = ctrl.createTextRange();
                            range.collapse(true);
                            range.moveEnd('character', pos);
                            range.moveStart('character', pos);
                            range.select();
                        }
                    }
                } catch (e) {}
            },
            events: function() {
                el
                .on('keydown.mask', function() {
                    old_value = p.val();
                })
                .on('keyup.mask', p.behaviour)
                .on("paste.mask drop.mask", function() {
                    setTimeout(function() {
                        el.keydown().keyup();
                    }, 100);
                })
                .on("change.mask", function() {
                    el.data("changed", true);
                })
                .on("blur.mask", function(){
                    if (old_value !== el.val() && !el.data("changed")) {
                        el.trigger("change");
                    }
                    el.data("changed", false);
                })
                // clear the value if it not complete the mask
                .on("focusout.mask", function() {
                    if (options.clearIfNotMatch && !regexMask.test(p.val())) {
                       p.val('');
                   }
                });
            },
            getRegexMask: function() {
                var maskChunks = [], translation, pattern, optional, recursive, oRecursive, r;

                for (var i = 0; i < mask.length; i++) {
                    translation = jMask.translation[mask[i]];

                    if (translation) {

                        pattern = translation.pattern.toString().replace(/.{1}$|^.{1}/g, "");
                        optional = translation.optional;
                        recursive = translation.recursive;

                        if (recursive) {
                            maskChunks.push(mask[i]);
                            oRecursive = {digit: mask[i], pattern: pattern};
                        } else {
                            maskChunks.push(!optional && !recursive ? pattern : (pattern + "?"));
                        }

                    } else {
                        maskChunks.push(mask[i].replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'));
                    }
                }

                r = maskChunks.join("");

                if (oRecursive) {
                    r = r.replace(new RegExp("(" + oRecursive.digit + "(.*" + oRecursive.digit + ")?)"), "($1)?")
                         .replace(new RegExp(oRecursive.digit, "g"), oRecursive.pattern);
                }

                return new RegExp(r);
            },
            destroyEvents: function() {
                el.off(['keydown', 'keyup', 'paste', 'drop', 'change', 'blur', 'focusout', 'DOMNodeInserted', ''].join('.mask '))
                .removeData("changeCalled");
            },
            val: function(v) {
                var isInput = el.is('input');
                return arguments.length > 0
                    ? (isInput ? el.val(v) : el.text(v))
                    : (isInput ? el.val() : el.text());
            },
            getMCharsBeforeCount: function(index, onCleanVal) {
                for (var count = 0, i = 0, maskL = mask.length; i < maskL && i < index; i++) {
                    if (!jMask.translation[mask.charAt(i)]) {
                        index = onCleanVal ? index + 1 : index;
                        count++;
                    }
                }
                return count;
            },
            caretPos: function (originalCaretPos, oldLength, newLength, maskDif) {
                var translation = jMask.translation[mask.charAt(Math.min(originalCaretPos - 1, mask.length - 1))];

                return !translation ? p.caretPos(originalCaretPos + 1, oldLength, newLength, maskDif)
                                    : Math.min(originalCaretPos + newLength - oldLength - maskDif, newLength);
            },
            behaviour: function(e) {
                e = e || window.event;
                var keyCode = e.keyCode || e.which;
                if ($.inArray(keyCode, jMask.byPassKeys) === -1) {

                    var caretPos = p.getCaret(),
                        currVal = p.val(),
                        currValL = currVal.length,
                        changeCaret = caretPos < currValL,
                        newVal = p.getMasked(),
                        newValL = newVal.length,
                        maskDif = p.getMCharsBeforeCount(newValL - 1) - p.getMCharsBeforeCount(currValL - 1);

                    if (newVal !== currVal) {
                        p.val(newVal);
                    }

                    // change caret but avoid CTRL+A
                    if (changeCaret && !(keyCode === 65 && e.ctrlKey)) {
                        // Avoid adjusting caret on backspace or delete
                        if (!(keyCode === 8 || keyCode === 46)) {
                            caretPos = p.caretPos(caretPos, currValL, newValL, maskDif);
                        }
                        p.setCaret(caretPos);
                    }

                    return p.callbacks(e);
                }
            },
            getMasked: function (skipMaskChars) {
                var buf = [],
                    value = p.val(),
                    m = 0, maskLen = mask.length,
                    v = 0, valLen = value.length,
                    offset = 1, addMethod = "push",
                    resetPos = -1,
                    lastMaskChar,
                    check;

                if (options.reverse) {
                    addMethod = "unshift";
                    offset = -1;
                    lastMaskChar = 0;
                    m = maskLen - 1;
                    v = valLen - 1;
                    check = function () {
                        return m > -1 && v > -1;
                    };
                } else {
                    lastMaskChar = maskLen - 1;
                    check = function () {
                        return m < maskLen && v < valLen;
                    };
                }

                while (check()) {
                    var maskDigit = mask.charAt(m),
                        valDigit = value.charAt(v),
                        translation = jMask.translation[maskDigit];

                    if (translation) {
                        if (valDigit.match(translation.pattern)) {
                            buf[addMethod](valDigit);
                             if (translation.recursive) {
                                if (resetPos === -1) {
                                    resetPos = m;
                                } else if (m === lastMaskChar) {
                                    m = resetPos - offset;
                                }

                                if (lastMaskChar === resetPos) {
                                    m -= offset;
                                }
                            }
                            m += offset;
                        } else if (translation.optional) {
                            m += offset;
                            v -= offset;
                        }
                        v += offset;
                    } else {
                        if (!skipMaskChars) {
                            buf[addMethod](maskDigit);
                        }

                        if (valDigit === maskDigit) {
                            v += offset;
                        }

                        m += offset;
                    }
                }

                var lastMaskCharDigit = mask.charAt(lastMaskChar);
                if (maskLen === valLen + 1 && !jMask.translation[lastMaskCharDigit]) {
                    buf.push(lastMaskCharDigit);
                }

                return buf.join("");
            },
            callbacks: function (e) {
                var val = p.val(),
                    changed = val !== old_value;
                if (changed === true) {
                    if (typeof options.onChange === "function") {
                        options.onChange(val, e, el, options);
                    }
                }

                if (changed === true && typeof options.onKeyPress === "function") {
                    options.onKeyPress(val, e, el, options);
                }

                if (typeof options.onComplete === "function" && val.length === mask.length) {
                    options.onComplete(val, e, el, options);
                }
            }
        };


        // public methods
        jMask.mask = mask;
        jMask.options = options;
        jMask.remove = function() {
            var caret;
            p.destroyEvents();
            p.val(jMask.getCleanVal()).removeAttr('maxlength');

            caret = p.getCaret();
            p.setCaret(caret - p.getMCharsBeforeCount(caret));
            return el;
        };

        // get value without mask
        jMask.getCleanVal = function() {
           return p.getMasked(true);
        };

       jMask.init = function() {
            options = options || {};

            jMask.byPassKeys = [9, 16, 17, 18, 36, 37, 38, 39, 40, 91];
            jMask.translation = {
                '0': {pattern: /\d/},
                '9': {pattern: /\d/, optional: true},
				'T': {pattern: /[0-9-+()]/, optional: true},
                '#': {pattern: /\d/, recursive: true},
                'A': {pattern: /[a-zA-Z0-9]/},
                'S': {pattern: /[a-zA-Z]/}
            };

            jMask.translation = $.extend({}, jMask.translation, options.translation);
            jMask = $.extend(true, {}, jMask, options);

            regexMask = p.getRegexMask();

            if (options.maxlength !== false) {
                el.attr('maxlength', mask.length);
            }

            if (options.placeholder) {
                el.attr('placeholder' , options.placeholder);
            }

            el.attr('autocomplete', 'off');
            p.destroyEvents();
            p.events();

            var caret = p.getCaret();

            p.val(p.getMasked());
            p.setCaret(caret + p.getMCharsBeforeCount(caret, true));

        }();

    };

    var watchers = {},
        live = 'DOMNodeInserted.mask',
        HTMLAttributes = function () {
            var input = $(this),
                options = {},
                prefix = "data-mask-";

            if (input.attr(prefix + 'reverse')) {
                options.reverse = true;
            }

            if (input.attr(prefix + 'maxlength') === 'false') {
                options.maxlength = false;
            }

            if (input.attr(prefix + 'clearifnotmatch')) {
                options.clearIfNotMatch = true;
            }

            input.mask(input.attr('data-mask'), options);
        };

    $.fn.mask = function(mask, options) {
        var selector = this.selector,
            maskFunction = function() {
                var maskObject = $(this).data('mask'),
                    stringify = JSON.stringify;

                if (typeof maskObject !== "object" || stringify(maskObject.options) !== stringify(options) || maskObject.mask !== mask) {
                    return $(this).data('mask', new Mask(this, mask, options));
                }
            };

        this.each(maskFunction);

        if (selector && !watchers[selector]) {
            // dynamically added elements.
            watchers[selector] = true;
            setTimeout(function(){
                $(document).on(live, selector, maskFunction);
            }, 500);
        }
    };

    $.fn.unmask = function() {
        try {
            return this.each(function() {
                $(this).data('mask').remove().removeData('mask');
            });
        } catch(e) {};
    };

    $.fn.cleanVal = function() {
        return this.data('mask').getCleanVal();
    };

    // looking for inputs with data-mask attribute
    $('*[data-mask]').each(HTMLAttributes);

    // dynamically added elements with data-mask html notation.
    $(document).on(live, '*[data-mask]', HTMLAttributes);

}));



//функция получает имя класа слайдера и количество слайдов в карусели на странице
function easySlider(className, PageQuantitySlides){

    var slidesQuant = $(className+' li').length;
    var nowSlideNum = 1;
    $(className).css('position', 'relative');
    $(className+">div").addClass('sliderContainer')
    if (PageQuantitySlides == '5'){
        $(className+" li").addClass('sliderElementMin');
        var sliderElClass = '.sliderElementMin';
    }else{
        $(className+" li").addClass('sliderElement');
        var sliderElClass = '.sliderElement';
    }

    $(className+" ul").addClass('sliderUl');
    var widthOfSlide = $(sliderElClass).width()*4;
    var quantityOfElements = $(className +' '+sliderElClass).size();
    var VisibleUlWidth = PageQuantitySlides * widthOfSlide;

    //
    $(className+" .left").click(function(){
        nowSlideNum--;
        if(nowSlideNum == 1){
            $(className+" .left").hide();
            $(className+' .sliderUl').animate({left:'+='+ widthOfSlide},500);
        } else {
            $(className+' .sliderUl').animate({left:'+='+ widthOfSlide},500);
            $(className+" .rigth").show();
        }
    });

    $(className+" .rigth").click(function(){
        nowSlideNum++;
        if(nowSlideNum == slidesQuant-(PageQuantitySlides-1)){
            $(className+" .rigth").hide();
            $(className+' .sliderUl').animate({left:'-='+ widthOfSlide},500);
        } else {
            $(className+' .sliderUl').animate({left:'-='+ widthOfSlide},500);
            $(className+" .left").show();
        }
    });

    if ($(className+' .sliderUl').position().left == 0) {
        $(className+" .left").hide();
    };
}

//PROGRESSBAR
(function(a,b){if(typeof define==="function"&&define.amd){define(b)}else{if(typeof exports==="object"){module.exports=b()}else{a.NProgress=b()}}})(this,function(){var e={};e.version="0.2.0";var b=e.settings={minimum:0.08,easing:"linear",positionUsing:"",speed:200,trickle:true,trickleSpeed:200,showSpinner:true,barSelector:'[role="bar"]',spinnerSelector:'[role="spinner"]',parent:"body",template:'<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>'};e.configure=function(m){var n,o;for(n in m){o=m[n];if(o!==undefined&&m.hasOwnProperty(n)){b[n]=o}}return this};e.status=null;e.set=function(s){var m=e.isStarted();s=g(s,b.minimum,1);e.status=(s===1?null:s);var o=e.render(!m),p=o.querySelector(b.barSelector),q=b.speed,r=b.easing;o.offsetWidth;i(function(n){if(b.positionUsing===""){b.positionUsing=e.getPositioningCSS()}h(p,a(s,q,r));if(s===1){h(o,{transition:"none",opacity:1});o.offsetWidth;setTimeout(function(){h(o,{transition:"all "+q+"ms linear",opacity:0});setTimeout(function(){e.remove();n()},q)},q)}else{setTimeout(n,q)}});return this};e.isStarted=function(){return typeof e.status==="number"};e.start=function(){if(!e.status){e.set(0)}var m=function(){setTimeout(function(){if(!e.status){return}e.trickle();m()},b.trickleSpeed)};if(b.trickle){m()}return this};e.done=function(m){if(!m&&!e.status){return this}return e.inc(0.3+0.5*Math.random()).set(1)};e.inc=function(m){var o=e.status;if(!o){return e.start()}else{if(o>1){return}else{if(typeof m!=="number"){if(o>=0&&o<0.2){m=0.1}else{if(o>=0.2&&o<0.5){m=0.04}else{if(o>=0.5&&o<0.8){m=0.02}else{if(o>=0.8&&o<0.99){m=0.005}else{m=0}}}}}o=g(o+m,0,0.994);return e.set(o)}}};e.trickle=function(){return e.inc()};(function(){var m=0,n=0;e.promise=function(o){if(!o||o.state()==="resolved"){return this}if(n===0){e.start()}m++;n++;o.always(function(){n--;if(n===0){m=0;e.done()}else{e.set((m-n)/m)}});return this}})();e.render=function(m){if(e.isRendered()){return document.getElementById("nprogress")}j(document.documentElement,"nprogress-busy");var n=document.createElement("div");n.id="nprogress";n.innerHTML=b.template;var q=n.querySelector(b.barSelector),o=m?"-100":c(e.status||0),p=document.querySelector(b.parent),r;h(q,{transition:"all 0 linear",transform:"translate3d("+o+"%,0,0)"});if(!b.showSpinner){r=n.querySelector(b.spinnerSelector);r&&k(r)}if(p!=document.body){j(p,"nprogress-custom-parent")}p.appendChild(n);return n};e.remove=function(){l(document.documentElement,"nprogress-busy");l(document.querySelector(b.parent),"nprogress-custom-parent");var m=document.getElementById("nprogress");m&&k(m)};e.isRendered=function(){return !!document.getElementById("nprogress")};e.getPositioningCSS=function(){var m=document.body.style;var n=("WebkitTransform" in m)?"Webkit":("MozTransform" in m)?"Moz":("msTransform" in m)?"ms":("OTransform" in m)?"O":"";if(n+"Perspective" in m){return"translate3d"}else{if(n+"Transform" in m){return"translate"}else{return"margin"}}};function g(p,o,m){if(p<o){return o}if(p>m){return m}return p}function c(m){return(-1+m)*100}function a(q,o,p){var m;if(b.positionUsing==="translate3d"){m={transform:"translate3d("+c(q)+"%,0,0)"}}else{if(b.positionUsing==="translate"){m={transform:"translate("+c(q)+"%,0)"}}else{m={"margin-left":c(q)+"%"}}}m.transition="all "+o+"ms "+p;return m}var i=(function(){var n=[];function m(){var o=n.shift();if(o){o(m)}}return function(o){n.push(o);if(n.length==1){m()}}})();var h=(function(){var m=["Webkit","O","Moz","ms"],r={};function o(s){return s.replace(/^-ms-/,"ms-").replace(/-([\da-z])/gi,function(t,u){return u.toUpperCase()})}function q(s){var u=document.body.style;if(s in u){return s}var t=m.length,w=s.charAt(0).toUpperCase()+s.slice(1),v;while(t--){v=m[t]+w;if(v in u){return v}}return s}function p(s){s=o(s);return r[s]||(r[s]=q(s))}function n(s,u,t){u=p(u);s.style[u]=t}return function(u,t){var s=arguments,w,v;if(s.length==2){for(w in t){v=t[w];if(v!==undefined&&t.hasOwnProperty(w)){n(u,w,v)}}}else{n(u,s[1],s[2])}}})();function f(n,m){var o=typeof n=="string"?n:d(n);return o.indexOf(" "+m+" ")>=0}function j(n,m){var p=d(n),o=p+m;if(f(p,m)){return}n.className=o.substring(1)}function l(n,m){var p=d(n),o;if(!f(n,m)){return}o=p.replace(" "+m+" "," ");n.className=o.substring(1,o.length-1)}function d(m){return(" "+(m&&m.className||"")+" ").replace(/\s+/gi," ")}function k(m){m&&m.parentNode&&m.parentNode.removeChild(m)}return e});

/*
 * jQuery appear plugin
 *
 * Copyright (c) 2012 Andrey Sidorov
 * licensed under MIT license.
 *
 * https://github.com/morr/jquery.appear/
 *
 * Version: 0.3.6
 */
(function($) {
  var selectors = [];

  var check_binded = false;
  var check_lock = false;
  var defaults = {
    interval: 250,
    force_process: false
  };
  var $window = $(window);

  var $prior_appeared = [];

  function process() {
    check_lock = false;
    for (var index = 0, selectorsLength = selectors.length; index < selectorsLength; index++) {
      var $appeared = $(selectors[index]).filter(function() {
        return $(this).is(':appeared');
      });

      $appeared.trigger('appear', [$appeared]);

      if ($prior_appeared[index]) {
        var $disappeared = $prior_appeared[index].not($appeared);
        $disappeared.trigger('disappear', [$disappeared]);
      }
      $prior_appeared[index] = $appeared;
    }
  };

  function add_selector(selector) {
    selectors.push(selector);
    $prior_appeared.push();
  }

  // "appeared" custom filter
  $.expr[':']['appeared'] = function(element) {
    var $element = $(element);
    if (!$element.is(':visible')) {
      return false;
    }

    var window_left = $window.scrollLeft();
    var window_top = $window.scrollTop();
    var offset = $element.offset();
    var left = offset.left;
    var top = offset.top;

    if (top + $element.height() >= window_top &&
        top - ($element.data('appear-top-offset') || 0) <= window_top + $window.height() &&
        left + $element.width() >= window_left &&
        left - ($element.data('appear-left-offset') || 0) <= window_left + $window.width()) {
      return true;
    } else {
      return false;
    }
  };

  $.fn.extend({
    // watching for element's appearance in browser viewport
    appear: function(options) {
      var opts = $.extend({}, defaults, options || {});
      var selector = this.selector || this;
      if (!check_binded) {
        var on_check = function() {
          if (check_lock) {
            return;
          }
          check_lock = true;

          setTimeout(process, opts.interval);
        };

        $(window).scroll(on_check).resize(on_check);
        check_binded = true;
      }

      if (opts.force_process) {
        setTimeout(process, opts.interval);
      }
      add_selector(selector);
      return $(selector);
    }
  });

  $.extend({
    // force elements's appearance check
    force_appear: function() {
      if (check_binded) {
        process();
        return true;
      }
      return false;
    }
  });
})(function() {
  if (typeof module !== 'undefined') {
    // Node
    return require('jquery');
  } else {
    return jQuery;
  }
}());

function setAbandonedInfo(userId,basketid) {
	$.ajax({
		type: "POST",
		url: "/ajax/abandoned_carts.php",
		data: {
			userid: userId,
			basketid: basketid
		}
	}).done(function(strResult) {
		if (strResult == 'ok') {
			console.log("userid:"+userId);
			console.log("basketid:"+basketid);
		}
	});
}

function readCookie(name) {
	var nameEQ = encodeURIComponent(name) + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) === ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
	}
	return null;
}

function subscribePopup() {
	$.post("/ajax/subscribe_pop.php", {id: 1}, function(data){
		$(data).appendTo("body").fadeIn();
	});
}

function subscribePopupChildren() {
	$.post("/ajax/subscribe_pop_children.php", {id: 1}, function(data){
		$(data).appendTo("body").fadeIn();
	});
}

function getsubbook(){
	$.post("/ajax/request_add.php",{email:$("#subpop input[type=email]").val()},function(data){$(".errorinfo").html(data);})
}

function closeX(){
	$('.hideInfo').hide();
}
function getInfo(id) {
    $.ajax({
        type: "POST",
        url: "/ajax/info_popup.php",
        data: {info: id}
    }).done(function(strResult) {
        $("#ajaxBlock").append(strResult);
        $("body").css('overflow','hidden');
    });
}
function closeInfo() {
    $('#ajaxBlock').empty();
    $("body").css('overflow','auto');
}
// попап окно при загрузке страницы
$(document).ready(function() {
    $(".stopProp").click(function(e) { e.stopPropagation(); });
    $(".subscribeForm input[type=email]").keydown(function(event){
        if(event.keyCode == 13) {
          var email = $(".subscribeForm input[type=email]").val();
          (window["rrApiOnReady"] = window["rrApiOnReady"] || []).push(function() { rrApi.setEmail(email); });
          event.preventDefault();
          $(this).siblings("input[type=button]").click();
          return false;
        }
    });
});
function subscribe() {var emailAddres = $(".subscribeForm input[type=email]").val();var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;if (regex.test(emailAddres)){$.post("/ajax/request_add.php", {email: $(".subscribeForm input[type=email]").val()}, function(data){$(".errorinfo").hide();$("#subpop form").html(data);})}else{$(".errorinfo").show();$(".errorinfo").html("Кажется, вы ошиблись в написании своего адреса");}}
function setCloseCookie() {$.post("/ajax/request_add.php", {close: "y"}, function(data){closeX();})}


//instafeed
(function(){var e;e=function(){function e(e,t){var n,r;this.options={target:"instafeed",get:"popular",resolution:"thumbnail",sortBy:"none",links:!0,mock:!1,useHttp:!1};if(typeof e=="object")for(n in e)r=e[n],this.options[n]=r;this.context=t!=null?t:this,this.unique=this._genKey()}return e.prototype.hasNext=function(){return typeof this.context.nextUrl=="string"&&this.context.nextUrl.length>0},e.prototype.next=function(){return this.hasNext()?this.run(this.context.nextUrl):!1},e.prototype.run=function(t){var n,r,i;if(typeof this.options.clientId!="string"&&typeof this.options.accessToken!="string")throw new Error("Missing clientId or accessToken.");if(typeof this.options.accessToken!="string"&&typeof this.options.clientId!="string")throw new Error("Missing clientId or accessToken.");return this.options.before!=null&&typeof this.options.before=="function"&&this.options.before.call(this),typeof document!="undefined"&&document!==null&&(i=document.createElement("script"),i.id="instafeed-fetcher",i.src=t||this._buildUrl(),n=document.getElementsByTagName("head"),n[0].appendChild(i),r="instafeedCache"+this.unique,window[r]=new e(this.options,this),window[r].unique=this.unique),!0},e.prototype.parse=function(e){var t,n,r,i,s,o,u,a,f,l,c,h,p,d,v,m,g,y,b,w,E,S,x,T,N,C,k,L,A,O,M,_,D;if(typeof e!="object"){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"Invalid JSON data"),!1;throw new Error("Invalid JSON response")}if(e.meta.code!==200){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,e.meta.error_message),!1;throw new Error("Error from Instagram: "+e.meta.error_message)}if(e.data.length===0){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"No images were returned from Instagram"),!1;throw new Error("No images were returned from Instagram")}this.options.success!=null&&typeof this.options.success=="function"&&this.options.success.call(this,e),this.context.nextUrl="",e.pagination!=null&&(this.context.nextUrl=e.pagination.next_url);if(this.options.sortBy!=="none"){this.options.sortBy==="random"?M=["","random"]:M=this.options.sortBy.split("-"),O=M[0]==="least"?!0:!1;switch(M[1]){case"random":e.data.sort(function(){return.5-Math.random()});break;case"recent":e.data=this._sortBy(e.data,"created_time",O);break;case"liked":e.data=this._sortBy(e.data,"likes.count",O);break;case"commented":e.data=this._sortBy(e.data,"comments.count",O);break;default:throw new Error("Invalid option for sortBy: '"+this.options.sortBy+"'.")}}if(typeof document!="undefined"&&document!==null&&this.options.mock===!1){m=e.data,A=parseInt(this.options.limit,10),this.options.limit!=null&&m.length>A&&(m=m.slice(0,A)),u=document.createDocumentFragment(),this.options.filter!=null&&typeof this.options.filter=="function"&&(m=this._filter(m,this.options.filter));if(this.options.template!=null&&typeof this.options.template=="string"){f="",d="",w="",D=document.createElement("div");for(c=0,N=m.length;c<N;c++){h=m[c],p=h.images[this.options.resolution];if(typeof p!="object")throw o="No image found for resolution: "+this.options.resolution+".",new Error(o);E=p.width,y=p.height,b="square",E>y&&(b="landscape"),E<y&&(b="portrait"),v=p.url,l=window.location.protocol.indexOf("http")>=0,l&&!this.options.useHttp&&(v=v.replace(/https?:\/\//,"//")),d=this._makeTemplate(this.options.template,{model:h,id:h.id,link:h.link,type:h.type,image:v,width:E,height:y,orientation:b,caption:this._getObjectProperty(h,"caption.text"),likes:h.likes.count,comments:h.comments.count,location:this._getObjectProperty(h,"location.name")}),f+=d}D.innerHTML=f,i=[],r=0,n=D.childNodes.length;while(r<n)i.push(D.childNodes[r]),r+=1;for(x=0,C=i.length;x<C;x++)L=i[x],u.appendChild(L)}else for(T=0,k=m.length;T<k;T++){h=m[T],g=document.createElement("img"),p=h.images[this.options.resolution];if(typeof p!="object")throw o="No image found for resolution: "+this.options.resolution+".",new Error(o);v=p.url,l=window.location.protocol.indexOf("http")>=0,l&&!this.options.useHttp&&(v=v.replace(/https?:\/\//,"//")),g.src=v,this.options.links===!0?(t=document.createElement("a"),t.href=h.link,t.appendChild(g),u.appendChild(t)):u.appendChild(g)}_=this.options.target,typeof _=="string"&&(_=document.getElementById(_));if(_==null)throw o='No element with id="'+this.options.target+'" on page.',new Error(o);_.appendChild(u),a=document.getElementsByTagName("head")[0],a.removeChild(document.getElementById("instafeed-fetcher")),S="instafeedCache"+this.unique,window[S]=void 0;try{delete window[S]}catch(P){s=P}}return this.options.after!=null&&typeof this.options.after=="function"&&this.options.after.call(this),!0},e.prototype._buildUrl=function(){var e,t,n;e="https://api.instagram.com/v1";switch(this.options.get){case"popular":t="media/popular";break;case"tagged":if(!this.options.tagName)throw new Error("No tag name specified. Use the 'tagName' option.");t="tags/"+this.options.tagName+"/media/recent";break;case"location":if(!this.options.locationId)throw new Error("No location specified. Use the 'locationId' option.");t="locations/"+this.options.locationId+"/media/recent";break;case"user":if(!this.options.userId)throw new Error("No user specified. Use the 'userId' option.");t="users/"+this.options.userId+"/media/recent";break;default:throw new Error("Invalid option for get: '"+this.options.get+"'.")}return n=e+"/"+t,this.options.accessToken!=null?n+="?access_token="+this.options.accessToken:n+="?client_id="+this.options.clientId,this.options.limit!=null&&(n+="&count="+this.options.limit),n+="&callback=instafeedCache"+this.unique+".parse",n},e.prototype._genKey=function(){var e;return e=function(){return((1+Math.random())*65536|0).toString(16).substring(1)},""+e()+e()+e()+e()},e.prototype._makeTemplate=function(e,t){var n,r,i,s,o;r=/(?:\{{2})([\w\[\]\.]+)(?:\}{2})/,n=e;while(r.test(n))s=n.match(r)[1],o=(i=this._getObjectProperty(t,s))!=null?i:"",n=n.replace(r,function(){return""+o});return n},e.prototype._getObjectProperty=function(e,t){var n,r;t=t.replace(/\[(\w+)\]/g,".$1"),r=t.split(".");while(r.length){n=r.shift();if(!(e!=null&&n in e))return null;e=e[n]}return e},e.prototype._sortBy=function(e,t,n){var r;return r=function(e,r){var i,s;return i=this._getObjectProperty(e,t),s=this._getObjectProperty(r,t),n?i>s?1:-1:i<s?1:-1},e.sort(r.bind(this)),e},e.prototype._filter=function(e,t){var n,r,i,s,o;n=[],r=function(e){if(t(e))return n.push(e)};for(i=0,o=e.length;i<o;i++)s=e[i],r(s);return n},e}(),function(e,t){return typeof define=="function"&&define.amd?define([],t):typeof module=="object"&&module.exports?module.exports=t():e.Instafeed=t()}(this,function(){return e})}).call(this);
function changeFeed(e){switch($("#instafeed").empty(),e){case"ap":default:userId=234788880,accessToken="234788880.1677ed0.b4707b411f044b99985f95f1b044d7e7",$(".fs-wrapper").show(),$("#instafeed").hide();break;case"anf":userId=526445861,accessToken="526445861.1677ed0.83228ef97e3f46859b97e833e93b0ba9",$("#instafeed").show(),$(".fs-wrapper").hide();break;case"ad":userId=3089843803,accessToken="3089843803.1677ed0.84b6545b2f6e474397dbbd59bc78c6f2",$("#instafeed").show(),$(".fs-wrapper").hide()}$(".instafeed div").removeClass("active"),new Instafeed({get:"user",userId:userId,accessToken:accessToken,limit:14,resolution:"low_resolution",mock:!1,useHttp:!1,template:'<a class="lazy" style="display:block;float:left;background-position: center center;background-repeat: no-repeat;-ms-background-size: cover;-webkit-background-size: cover;-o-background-size: cover;-moz-background-size: cover;background-size: cover; background-image:url({{image}});" href="{{link}}" target="_blank"><span class="instagram-{{type}}"></span><div class="hover-layer"><span class="likes"><img src="/include/instagram/likes.svg" /> &nbsp;{{likes}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img style="width:20px; height:auto" src="/include/instagram/comment.svg" /> &nbsp;{{comments}}</span></div></a>',after:function(){"use strict";$(".lazy").show(),$("."+e).addClass("active")}}).run()}$(document).ready(function(){changeFeed("ap")});
