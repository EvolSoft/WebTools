/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

jQuery(document).ready(function($){
	$('form').on('submit',function(e){
		e.preventDefault();
		$.get('index.php', {'page' : 'spwdgen', 'nc' : 'true'}).done(function(data){
			$(document).find('#password').val($(data).find('#password').val());
		});
    });
});