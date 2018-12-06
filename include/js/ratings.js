/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

var last = 1;
var entered = false;
var sstatus = [];
jQuery(document).ready(function($){
	storeStars();
	$('#stars').mouseleave(function(e){
		if(entered){
			for(i = 1; i <= 5; i++){
				$('#stars').find('[name=' + i + ']').css('color', '');
				$('#stars').find('[name=' + i + ']').attr('class', sstatus[i]);
			}
			entered = false;
		}
	});
	$('#stars').mouseenter(function(e){
		entered = true;
	});
	$('#stars').find('span').mouseover(function(e){
		var l = $(e.target).attr('name');
		if(jQuery.isNumeric(l) && l <= 5){
			for(i = 1; i <= l; i++){
				$(e.target).parent().find('[name=' + i + ']').attr('class', 'fa fa-star fa-lg');
				$(e.target).parent().find('[name=' + i + ']').css('color', '#e3a002');
			}
			l++;
			for(i = l; i <= 5; i++){
				$(e.target).parent().find('[name=' + i + ']').css('color', '');
				$(e.target).parent().find('[name=' + i + ']').attr('class', sstatus[i]);
			}
			last = l - 1;
		}
	});
	$('#stars').click(function(e){
		$.post('index.php?page=ratings', {'rating_id' : getURLParam('page'), 'rating_rating' : last}, function(data){
			var status = 3;
			var tot_ratings = 0;
			var average = 0;
			if(data.hasOwnProperty('status') && data.hasOwnProperty('tot_ratings') && data.hasOwnProperty('average')){
				status = data['status'];
				tot_ratings = data['tot_ratings'];
				average = data['average'];
			}
			switch(status){
				case 0:
					var updtext;
					if(tot_ratings){
						var vtext = 'vote';
						if(tot_ratings != 1){
							vtext = 'votes';
						}
						average = average.toFixed(1);
						if(average == Math.floor(average)){
							average = Math.floor(average);
					    }
						for(i = 1; i <= Math.floor(average); i++){
							$('#stars').find('[name=' + i + ']').attr('class', 'fa fa-star fa-lg');
		    			}
		    			if(average - Math.floor(average) > 0){
		    				$('#stars').find('[name=' + i + ']').attr('class', 'fa fa-star-half-o fa-lg');
		    			    i++;
		    			}
		    			for(l = i; l <= 5; l++){
		    				$('#stars').find('[name=' + l + ']').attr('class', 'fa fa-star-o fa-lg');
		    			}
						storeStars();
						updtext = '<b>' + average + '</b>/5 stars (' + tot_ratings + ' ' + vtext + ')';
		    		}else{
		    			updtext = 'This script has not been rated yet.';
		    		}
					printStatus('Thank you for your vote!', 'out-success', updtext);
					break;
				default:
				case 1:
					printStatus('An error has occurred.', 'out-error');
					break;
				case 2:
					printStatus('MySQL error.', 'out-error');
					break;
				case 3:
					printStatus('Invalid data.', 'out-error');
					break;
				case 4:
					printStatus('You already rated this script.', 'out-error');
					break;
			}
		}, 'json');
	});
});

var pstatus = false;
function printStatus(text, cls, updtext = null){
	var curtext = $('#ratings_text').html();
	if(!pstatus){
		pstatus = true;
		$('#ratings_text').fadeOut('fast', function(){
			$('#ratings_text').text(text);
			$('#ratings_text').attr('class', cls);
			$('#ratings_text').fadeIn('fast');
			$('#ratings_text').delay(1500).fadeOut('fast', function(){
				if(updtext){
					$('#ratings_text').html(updtext);
				}else{
					$('#ratings_text').html(curtext);
				}
				$('#ratings_text').attr('class', 'out-gray');
				$('#ratings_text').fadeIn('fast');
				pstatus = false;
			});
		});
	}
}

function storeStars(){
	for(i = 1; i <= 5; i++){
		sstatus[i] = $('#stars').find('[name=' + i + ']').attr('class');
	}
}

function getURLParam(key){
	var kpos = window.location.search.indexOf(key + '=');
	if(kpos == -1){
		return null;
	}
	if((ppos = window.location.search.indexOf('&', kpos + key.length + 1)) != -1){
		return window.location.search.substr(kpos + key.length + 1, ppos - kpos - key.length - 1);
	}
	return window.location.search.substr(kpos + key.length + 1);
}