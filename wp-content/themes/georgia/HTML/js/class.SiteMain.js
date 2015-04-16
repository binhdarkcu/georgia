// JavaScript Document
var SiteMain = (function() {
	function init(){
		createRadio();
	}
	
	function createRadio(){
		$('input.iCheckRadio').iCheck();
	}
	
	function openPopup(idDiv){
		$('.result_question').css('display','none')
		$(idDiv).css('display','block');	
	}
	function closePopup(idDiv){
		$(idDiv).css('display','none');
	}
	return {
		init:init,
		openPopup:openPopup,
		closePopup:closePopup
	}
	
})();		

$(document).ready( function() {
	SiteMain.init();
});

