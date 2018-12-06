/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

jQuery(document).ready(function($){
	$('form').on('submit',function(e){
		e.preventDefault();
		var _plen = $(document).find("#plen").prop('value');
		var _in = $(document).find("#in").prop('checked') ? 1 : 0;
		var _ip = $(document).find("#ip").prop('checked') ? 1 : 0;
		var _imc = $(document).find("#imc").prop('checked') ? 1 : 0;
		$.post('index.php?page=apwdgen&nc=true', {'plen' : _plen, 'in' : _in, 'ip' : _ip, 'imc' : _imc}).done(function(data){
			$(document).find('#password').val($(data).find('#password').val());
			$(document).find('.form').html($(data).find('.form').html());
		});
    });
});