/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

jQuery(document).ready(function($){
	$('#js_alert').remove();
	$('#browser-table').find('#browser').text(getBrowserName());
	$('#browser-table').find('#os').text(getOSName());
	$('#browser-table').find('#screen_size').text(screen.width + 'x' + screen.height);
	$('#browser-table').find('#window_size').text($(window).width() + 'x' + $(window).height());
	if(navigator.cookieEnabled){
		$('#browser-table').find('#cookies').text('true');
		$('#browser-table').find('#cookies').attr('class', 'out-success');
	}else{
		$('#browser-table').find('#cookies').text('false');
		$('#browser-table').find('#cookies').attr('class', 'out-error');
	}
	$('#browser-table').find('#js_enabled').text('true');
	$('#browser-table').find('#js_enabled').attr('class', 'out-success');
});

function getBrowserName(){
	if(window.navigator.userAgent.indexOf('Edge') != -1) return 'Edge';
	if(window.navigator.userAgent.indexOf('Chrome') != -1) return 'Chrome';
	if(window.navigator.userAgent.indexOf('Firefox') != -1) return 'Mozilla Firefox';
	if(window.navigator.userAgent.indexOf('MSIE') != -1) return 'Internet Explorer';
	if(window.navigator.userAgent.indexOf('Opera') != -1) return 'Opera';
	if(window.navigator.userAgent.indexOf('Safari') != -1) return 'Safari';
	return 'Unknown';
}

function getOSName(){
	if(window.navigator.userAgent.indexOf('Windows NT 10.0') != -1) return 'Windows 10';
	if(window.navigator.userAgent.indexOf('Windows NT 6.2') != -1) return 'Windows 8';
	if(window.navigator.userAgent.indexOf('Windows NT 6.1') != -1) return 'Windows 7';
	if(window.navigator.userAgent.indexOf('Windows NT 6.0') != -1) return 'Windows Vista';
	if(window.navigator.userAgent.indexOf('Windows NT 5.1') != -1) return 'Windows XP';
	if(window.navigator.userAgent.indexOf('Windows NT 5.0') != -1) return 'Windows 2000';
	if(window.navigator.userAgent.indexOf('Mac') != -1) return 'Mac/iOS';
	if(window.navigator.userAgent.indexOf('X11') != -1) return 'UNIX';
	if(window.navigator.userAgent.indexOf('Linux') != -1) return 'Linux';
	return 'Unknown';
}