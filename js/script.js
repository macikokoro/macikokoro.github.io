$(window).load(function initIso(){

    var $container = $('#container');

    $container.isotope({
        itemSelector : '.element'
    });


    var $optionSets = $('#options .option-set'),
        $optionLinks = $optionSets.find('a');

    $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
            return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');

        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
            // changes in layout modes need extra logic
            changeLayoutMode( $this, options )
        } else {
            // otherwise, apply new options
            $container.isotope( options );
        }

        return false;
    });


});

function debouncer( func , timeout ) {
    var timeoutID , timeout = timeout || 200;
    return function () {
        var scope = this , args = arguments;
        clearTimeout( timeoutID );
        timeoutID = setTimeout( function () {
            func.apply( scope , Array.prototype.slice.call( args ) );
        } , timeout );
    }
}


 $(document).ready(function() {
    "use strict";




/*---------------------------------------------------------------- One Page Navigation -------------------*/
	$('.nav').onePageNav({
	filter: ':not(.external)',
	scrollThreshold: 0.25,
	scrollOffset: 60,
	});


/*---------------------------------------------------------------- Fixed menu ----------------------------
	$('header').scrollToFixed();
*/

/*---------------------------------------------------------------- Slider --------------------------------*/
	$('.carousel').carousel({
      interval: 2000
    });


/*-------------------------------------------------------------------------- Tooltip----------------------*/
	if( $.fn.tooltip() ) {
		$('[class="tooltip_hover"]').tooltip();
	}


/*-------------------------------------------------------------- Responsive Video plugin -----------------*/
     jQuery(".video").fitVids();


/*------------------------------------------------------------------------ ToTop -------------------------*/
     var screen = $(document).height();
	 $(window).scroll(function(){
		 if ($(this).scrollTop() > screen - 600) {
			 $('#scroll_up').fadeIn();
		 } else {
			 $('#scroll_up').fadeOut();
		 }
	 });

	 $('#scroll_up').click(function(){
		 $("html, body").animate({ scrollTop: 0 }, 600);
		 return false;
	 });

/*----------------------------------------------------- Newssleter and contact Form -------------------------*/
    $("#newsletter, #contact, #request").submit(function() {
        var elem = $(this);
        var urlTarget = $(this).attr("action");
        $.ajax({
            type : "POST",
            url : urlTarget,
            dataType : "html",
            data : $(this).serialize(),
            beforeSend : function() {
                elem.prepend("<div class='loading alert'>" + "<a class='close' data-dismiss='alert'>×</a>" + "Loading" + "</div>");
                //elem.find(".loading").show();
            },
            success : function(response) {
                elem.prepend(response);
                //elem.find(".response").html(response);
                elem.find(".loading").hide();
                elem.find("input[type='text'],input[type='email'],textarea").val("");
            }
        });
        return false;
    });


/*----------------------------------------------------- login from -------------------------*/
/*----------------------------------------------------- moreinformation -------------------------*/
     $(".moreinformation").click(function(){
         if (getCookie('session_id') == null || getCookie('session_id') =="" ){
             var xmlHttp = new XMLHttpRequest();
             xmlHttp.open("GET","http://api.seattletechinterviews.com/api/v1/SessionRest");
             xmlHttp.send(null);

             if(xmlHttp.response['session_id'] != null){
                 setCookie(xmlHttp.response['session_id']);
             }
         }else{
             alert(getCookie('session_id'));
         }

     });

     function setCookie(cname, cvalue, exdays) {
         var d = new Date();
         d.setTime(d.getTime() + (exdays*24*60*60*1000));
         var expires = "expires="+d.toUTCString();
         document.cookie = cname + "=" + cvalue + "; " + expires;
     }

     function getCookie(cname) {
         var name = cname + "=";
         var ca = document.cookie.split(';');
         for(var i=0; i<ca.length; i++) {
             var c = ca[i];
             while (c.charAt(0)==' ') c = c.substring(1);
             if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
         }
         return "";
     }


 });
