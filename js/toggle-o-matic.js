var toggleOmatic = function() {
	var toggleAll = $(document.body).getElements('[class$=_toggle]'); 
	toggleAll.each(function(item){
		item.setStyle('cursor', 'pointer');
		var toggleAllClass = item.getProperty('class');
		toggleAllClass = toggleAllClass.replace("_toggle", "");
        var slideAllClass = toggleAllClass + "_slide";
		var slideAll = $(document.body).getElements('.' + slideAllClass);
		slideAll.slide('hide');
		$(item).addEvent('click', function(){
				if (item.get('html') == 'Hide more information...') {
                    item.set('html', "Show more information...");
                } else {
                    item.set('html', "Hide more information...");
                }
                slideAll.slide();
		});	   
	});
} 
 
window.addEvent('domready', function() { 
    toggleOmatic();
});




