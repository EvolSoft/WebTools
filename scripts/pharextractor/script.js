/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

jQuery(document).ready(function($){
	$('#cmd').after('<h4>Command:</h4><code class="code-box"><span class="cls">phartools </span><span class="attr">-p2a </span><span class="str" id="fname">&lt;phar_file&gt;</span><span id="otype" class="attr"> -ozip</span></code>');
	$('#finput').change(function(e){
        $('#fname').text(e.target.files[0].name);
    });
	$('#output[value="zip"]').change(function(){
		$('#otype').text(' -ozip');
	});
	$('#output[value="tar"]').change(function(){
		$('#otype').text(' -otar');
	});
});