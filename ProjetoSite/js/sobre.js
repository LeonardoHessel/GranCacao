$(document).ready(function(){
    $(() =>{
        $(window).scroll(function(){
            var widthScreen = window.screen.width; 
            var scroll = $(window).scrollTop();
            if (scroll > 200){
                $('#card1').addClass('animated bounceInRight');
                $('#card1').addClass('efeito_aparecer');
            } 
            if(scroll > 700){
                $('#card2').addClass('animated bounceInLeft');
                $('#card2').addClass('efeito_aparecer');
            }
        });	
    });
});