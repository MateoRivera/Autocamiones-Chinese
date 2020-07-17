// JavaScript Document
$(document).ready(function(){
	$('#focusInmediato').popover('show')
	
	/*if($('#focusInmediato').is(':focus')){
		
			$('#focusInmediato').popover('show')
			
		}
	
	$('#focusInmediato').blur(function(){
		$('#focusInmediato').popover('show')
	})
	$('#focusInmediato').focus(function(){
		$('#focusInmediato').popover('show')
	})
	*/
	
	
	if(localStorage.getItem("fondoPreferidoAutocamiones")!=null){
		$("#fondoHome").css("background-image", localStorage.getItem("fondoPreferidoAutocamiones")) 
	}	
	
	
	
})