
(function($){
	
	$.fn.uniqueField = function(options) {  

		var defaults = {
			url: "ajax.php", //required
			baseId: '', // required
			availableClass: "availableValue", //optional
			unavailableClass: "unavailableValue", //optional
			availableLabel: "Disponible", //optional
			unavailableLabel: "EXISTE", //optional
			baseClass: "availability", //optional
			location: 1 // 1 == after, else == before
		}; 
		var options = $.extend(defaults, options);
		
		var resultStyle = new Array();
		var resultText  = new Array();
		      
		return this.each(function() { 
			var obj = $(this);

	 		$(obj).unbind().keyup(function() {
					
				testUnique($(this).val(), $(this).attr('name'));

				$(this).ajaxComplete(function(){
					if(options.location === 1) {
						$(this).next("#" + options.baseId).remove();
						$(this).after("<span id=\""+options.baseId+"\" class=\""+options.baseClass+"\"><span></span></span>");
						$(this).next("#" + options.baseId).addClass(resultStyle[options.baseId]).find("span");
					} else {
						$(this).prev("#" + options.baseId).remove();
						$(this).before("<span id=\""+options.baseId+"\" class=\""+options.baseClass+"\"><span></span></span>");
						$(this).prev("#" + options.baseId).addClass(resultStyle[options.baseId]).find("span");
					}
				});
	 		});

	 		// Private function
			function testUnique(value, field){
			 	$.ajax({
			 		type: 'POST',
			 		url: options.url, 
			 		data: {value: value, field: field}, 
			 		success: function(response){
				 		if (response == '1'){
			 			 	resultStyle[options.baseId] = options.availableClass;
			 			 	resultText[options.baseId]  = value + ' ' + options.availableLabel;
					 	} else {
					 		resultStyle[options.baseId] = options.unavailableClass;
					 		resultText[options.baseId]  = value + ' ' + options.unavailableLabel;
					 	}
			 		}
			 	});
			 	return false;
			};

		});
	};
})(jQuery);