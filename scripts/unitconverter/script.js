/*
 * EvolSoft WebTools
 * Developer: Flavius12
 * Copyright (C) 2018 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/WebTools/blob/master/LICENSE)
 */

var angle = [];
angle[0] = 'Angle';
angle[1] = ['Degree [°]', '1*v', '1*v'];
angle[2] = ['Radians [rad]', '57.295779513*v', '0.01745329252*v'];
angle[3] = ['Grad', '0.9*v', '1.111111111*v'];
var area = [];
area[0] = 'Area';
area[1] = ['Square millimeter [mm&#178;]', 'v/1000000', '1000000*v'];
area[2] = ['Square centimeter [cm&#178;]', 'v/10000', '10000*v'];
area[3] = ['Square meter [m&#178;]', '1*v', '1*v'];
area[4] = ['Square kilometer [km&#178;]', '1000000*v', 'v/1000000'];
area[5] = ['Square inch [in&#178;]', 'v/1550.003100', '1550.003100*v'];
area[6] = ['Square foot [ft&#178;]', 'v/10.763910', '10.763910*v'];
area[7] = ['Square yard [yd&#178;]', 'v/1.19599', '1.19599*v'];
area[8] = ['Are [a]', 'v/0.01', '0.01*v'];
area[9] = ['Hectare [ha]', 'v/0.0001', '0.0001*v'];
area[10] = ['Acre [acre]', 'v/0.0002471053814672', '0.0002471053814672*v'];
var data = [];
data[0] = 'Data';
data[1] = ['Bit', '1*v', '1*v'];
data[2] = ['Byte', '8*v', 'v/8'];
data[3] = ['Kilobit [Kb]', '1024*v', 'v/1024'];
data[4] = ['Kilobyte [KB]', '8192*v', 'v/8192'];
data[5] = ['Megabit [Mb]', '1048576*v', 'v/1048576'];
data[6] = ['Megabyte [MB]', '8388608*v', 'v/8388608'];
data[7] = ['Gigabit [Gb]', '1073741824*v', 'v/1073741824'];
data[8] = ['Gigabyte [GB]', '8589934592*v', 'v/8589934592'];
data[9] = ['Terabit [Tb]', '1099511627776*v', 'v/1099511627776'];
data[10] = ['Terabyte [TB]', '8796093022208*v', 'v/8796093022208'];
data[11] = ['Petabit [Pb]', '1125899906842624*v', 'v/1125899906842624'];
data[12] = ['Petabyte [PB]', '9007199254740992*v', 'v/9007199254740992'];
data[13] = ['Exabit [Eb]', '1152921504606846976*v', 'v/1152921504606846976'];
data[14] = ['Exabyte [EB]', '9223372036854775808*v', 'v/9223372036854775808'];
var energy = [];
energy[0] = 'Energy';
energy[1] = ['Joule [j]', '1*v', '1*v'];
energy[2] = ['Calories [cal]', '4.184*v', 'v/4.184'];
energy[3] = ['Kilocalories [kcal]', '4184*v', 'v/4184'];
energy[4] = ['Watt-hour [Wh]', '3600*v', 'v/3600'];
energy[5] = ['Kilowatt-hour [kWh]', '3600000*v', 'v/3600000'];
energy[6] = ['BTU [BTU]', '1055.05585262*v', 'v/1055.05585262'];
energy[7] = ['Electronvolts [eV]', '1.602176565*Math.pow(10,-19)*v', 'v/(1.602176565*Math.pow(10,-19))'];
var force = [];
force[0] = 'Force';
force[1] = ['Newton [N]', '1*v', '1*v'];
force[2] = ['Kilonewton [kN]', '1000*v', 'v/1000'];
force[3] = ['Dyne [dyn]', 'v/100000', '100000*v'];
force[4] = ['Pound-Force [lbF]', 'v/0.224809', '0.224809*v'];
force[5] = ['Poundal [dl]', 'v/7.23301', '7.23301*v'];
var frequency = [];
frequency[0] = 'Frequency';
frequency[1] = ['Hertz [Hz]', '1*v', '1*v'];
frequency[2] = ['Kilohertz [kHz]', '1000*v', 'v/1000'];
frequency[3] = ['Megahertz [MHz]', '1000000*v', 'v/1000000'];
frequency[4] = ['Gigahertz [GHz]', '1000000000*v', 'v/1000000000'];
var length = [];
length[0] = 'Length';
length[1] = ['Ångström [Å]', 'v/10000000000', '10000000000*v'];
length[2] = ['Millimeter [mm]', 'v/1000', '1000*v'];
length[3] = ['Centimeter [cm]', 'v/100', '100*v'];
length[4] = ['Decimeter [dm]', 'v/10', '10*v'];
length[5] = ['Meter [m]', '1*v', '1*v'];
length[6] = ['Kilometer [km]', '1000*v', 'v/1000'];
length[7] = ['Inch [in]', '0.0254*v', 'v/0.0254'];
length[8] = ['Foot [ft]', '0.3048*v', 'v/0.3048'];
length[9] = ['Yard [yd]', '0.9144*v', 'v/0.9144'];
length[10] = ['Miles [mi]', '1609.344*v', 'v/1609.344'];
length[11] = ['Light year [ly]', '9460528405000000*v', 'v/9460528405000000'];
var mass = [];
mass[0] = 'Mass';
mass[1] = ['Milligram [mg]', 'v/1000', '1000*v'];
mass[2] = ['Gram [g]', '1*v', '1*v'];
mass[3] = ['Hectogram [hg]', '100*v', 'v/100'];
mass[4] = ['Kilogram [kg]', '1000*v', 'v/1000'];
mass[5] = ['Ounce [oz]', '28.34952*v', 'v/28.34952'];
mass[6] = ['Pound [lb]', '453.59237*v', 'v/453.59237'];
mass[7] = ['Ton [t]', '1000000*v', 'v/1000000'];
var pressure = [];
pressure[0] = 'Pressure';
pressure[1] = ['Bar [bar]', '1*v', '1*v'];
pressure[2] = ['Pascal [Pa]', 'v/100000', 'v*100000'];
pressure[3] = ['Hectopascal [hPa]', 'v/1000', 'v*1000'];
pressure[4] = ['Atmosphere [atm]', '1.01325*v', 'v/1.01325'];
pressure[5] = ['Torr [torr]', 'v/750.0637556', '750.0637556*v'];
var speed = [];
speed[0] = 'Speed';
speed[1] = ['Meter/second [m/s]', '1*v', '1*v'];
speed[2] = ['Meter/minute', 'v/60', '60*v'];
speed[3] = ['Kilometer/second', '1000*v', 'v/1000'];
speed[4] = ['Kilometer/hour [km/h]', 'v/3.6', '3.6*v'];
speed[5] = ['Mile/hour [mph]', '0.44704*v', 'v/0.44704'];
speed[6] = ['Knot [kn]', '0.51444444444*v', 'v/0.51444444444'];
var temperature = [];
temperature[0] = 'Temperature';
temperature[1] = ['Kelvin [K]', ' 1*v', '1*v'];
temperature[2] = ['Celsius [°C]', '273.15+1*v', '-273.15+v'];
temperature[3] = ['Fahrenheit [°F]', '255.3722222222+0.5555555556*v', '-459.67+1.8*v'];
temperature[4] = ['Rankine [°R]', 'v/1.8', '1.8*v'];
temperature[5] = ['Réaumur [°Ré]', '273.15+1.25*v', '-218.52+0.8*v'];
var time = [];
time[0] = 'Time';
time[1] = ['Nanosecond [ns]', 'Math.pow(10,-9)*v', 'v/(Math.pow(10,-9))'];
time[2] = ['Microsecond [μs]', 'Math.pow(10,-6)*v', 'v/(Math.pow(10,-6))'];
time[3] = ['Millisecond [ms]', 'v/1000', '1000*v'];
time[4] = ['Second [s]', '1*v', '1*v'];
time[5] = ['Minute [min]', '60*v', 'v/60'];
time[6] = ['Hour [h]', '3600*v', 'v/3600'];
time[7] = ['Day [d]', '86400*v', 'v/86400'];
time[8] = ['Week [wk]', '604800*v', 'v/604800'];
time[9] = ['Month [mth]', '2628000.03*v', 'v/2628000.03'];
time[10] = ['Year [yr]', '31536000*v', 'v/31536000'];
time[11] = ['Century', '3153600000*v', 'v/3153600000'];
time[12] = ['Millennium', '31536000000*v', 'v/31536000000'];
var volume = [];
volume[0] = 'Volume';
volume[1] = ['Milliliter [ml]', 'v/1000000', '1000000*v'];
volume[2] = ['Cubic centimeter [cm&#179;]', 'v/1000000', '1000000*v'];
volume[3] = ['Cubic decimeter [dm&#179;]', 'v/1000', '1000*v'];
volume[4] = ['Cubic meter [m&#179;]', '1*v', '1*v'];
volume[5] = ['Liter [L]', 'v/1000', '1000*v'];
volume[6] = ['Cubic inch [in&#179;]', 'v/61023.7441', '61023.7441*v'];
volume[7] = ['Cubic foot [ft&#179;]', 'v/35.3146667', '35.3146667*v'];
volume[8] = ['Cubic yard [yd&#179;]', 'v/1.30795062', '1.30795062*v'];
volume[9] = ['Barrel [bbl]', 'v/6.2898105697751', '6.2898105697751*v'];
volume[10] = ['Tablespoon', 'v/66666.666666667', '66666.666666667*v'];
volume[11] = ['Teaspoon', 'v/200000', '200000*v'];
var units = [angle, area, data, energy, force, frequency, length, mass, pressure, speed, temperature, time, volume];
var fs = 1;
var ts = 1;
var cur = 0;
jQuery(document).ready(function($){
	$('#js_alert').remove();
	$('#unit_converter').css('display', '');
	updateForm();
	$('#units').click(function(e){
		var element = $(e.target);
		if(element.attr('class').localeCompare('list-group-item') == 0){
			element = $(e.target).parent();
		}
		cur = element.attr('id');
		updateForm();
	});
	$('#exchange').click(function(){
		var from = $('#subunit_from').val();
		fs = $('#subunit_from').val($('#subunit_to').val()).val();
		ts = $('#subunit_to').val(from).val();
		updateText();
		
	});
	$('#subunit_from').change(function(e){
	    fs = $(e.target.options[e.target.selectedIndex]).val();
	    updateText();
	});
	$('#subunit_to').change(function(e){
	    ts = $(e.target.options[e.target.selectedIndex]).val();
	    updateText();
	});
	$('#from').on('input', function(){
		if(isNaN($('#from').val())){
			$('#from').attr('class', 'input input-error');
			$('#to').val('NaN');
		}else{
			$('#from').attr('class', 'input');
			updateText();
		}
	});
});

function updateForm(){
	$('#units').empty();
	$('#subunit_from').empty();
	$('#subunit_to').empty();
	$('#from').val('');
	$('#to').val('');
	fs = 1;
	ts = 1;
	for(i = 0; i < units.length; i++){
		if(i == cur){
			$('#units').append('<div class="list-item active" style="cursor: pointer" id="' + i + '"><a class="list-group-item">' + units[i][0] + '</a></div>');
			for(l = 1; l < units[i].length; l++){
				$('#subunit_from').append('<option value="' + l + '">' + units[i][l][0] + '</option>');
				$('#subunit_to').append('<option value="' + l + '">' + units[i][l][0] + '</option>');
				if(l == 2){
					ts = l;
					$('#subunit_to').val(l);
				}
			}
		}else{
			$('#units').append('<div class="list-item" style="cursor: pointer" id="' + i + '"><a class="list-group-item">' + units[i][0] + '</a></div>');
		}
	}
	fillTable(1);
}

function updateText(){
	var res = convert($('#from').val(), units[cur][fs], units[cur][ts]);
	var from = $('#from').val() ? $('#from').val() : 0;
	$('#to').val(res);
	fillTable(from);
}

function fillTable(val){
	$('#unit_table').find('tbody').empty();
	$('#unit_table').find('tbody').append('<tr><th scope="row">Unit</th><th>Value</th></tr>');
	for(i = 1; i < units[cur].length; i++){
		if(i == fs){
			$('#unit_table').find('tbody').append('<tr><td><b>' + units[cur][i][0] + '</b></td><td><b>' + convert(val, units[cur][fs], units[cur][i]) + '</b></td></tr>');
		}else{
			$('#unit_table').find('tbody').append('<tr><td>' + units[cur][i][0] + '</td><td>' + convert(val, units[cur][fs], units[cur][i]) + '</td></tr>');
		}
	}
}

function convert(val, from, to){
	var v = val;
	var round;
	if(from == to){
		return v;
	}
	v = eval(from[1]);
	v = eval(to[2]);
	if(!Number.isInteger(v)){
		v = v.toFixed(6);
		round = Math.abs(v * 1000) - Math.floor(Math.abs(v * 1000));
		if(round == 0 || round == 1){
			if(v == Math.floor(v)){
				return Math.floor(v);
			}else if($('#from').val().indexOf('.') != -1){
				return parseFloat(v).toFixed(Math.max($('#from').val().split('.')[1].length, 2));
			}
		}
	}
	return parseFloat(v);
}