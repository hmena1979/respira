var base = location.protocol+'//'+location.host;
var route = document.getElementsByName('routeName')[0].getAttribute('content');

document.addEventListener('DOMContentLoaded',function(){
	if(route == 'producto_add'){
		var btn_search = document.getElementById('btn_search');
		var form_search = document.getElementById('form_search');
		if(btn_search){
			btn_search.addEventListener('click', function(e){
				e.preventDefault();
				if(form_search.style.display === 'block'){
					form_search.style.display = 'none';
				}else{
					form_search.style.display = 'block';
				}
			});
		}
		var btn_galeria = document.getElementById('btn_galeria');
		var img_galeria = document.getElementById('img_galeria');
		btn_galeria.addEventListener('click', function(){
			img_galeria.click();
		}, false);

		img_galeria.addEventListener('change', function(){
			document.getElementById('form_galeria').submit();
		});
	}
	route_active = document.getElementsByClassName('lk-'+route)[0].classList.add('active');
});

// $(document).ready(function(){
// 	editor_init('editor');
// })

// $(document).ready(function(){
// 	editor_init('editor1');
// })

function editor_init(field){	
	CKEDITOR.replace(field,{
		toolbar:[
		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', items: [ 'Scayt' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'EasyImageUpload', 'Table', 'HorizontalRule', 'SpecialChar' ] },
		{ name: 'tools', items: [ 'Maximize' ] },
		{ name: 'document', items: [ 'Source' ] },
		'/',
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Strike', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
		{ name: 'styles', items: [ 'Styles', 'Format' ] }
		]
	});
}

function NaNToCero(valor){
	if(isNaN(valor)){
		return 0.00;
	}else{
		return valor;
	}
}

function Redondea(valor, decimal){
	var resul = Math.round(valor*Math.pow(10,decimal))/Math.pow(10,decimal);
	return resul;
}

function sumarDias(pfecha,pdias){
	var dias = parseInt(pdias);
	var dia = String(parseInt(pfecha.substr(8,2)));
	var mes = pfecha.substr(5,2);
	var anio = pfecha.substr(0,4);
	var fecha = new Date(anio+'/'+mes+'/'+dia);

	var tmpfecha = new Date();
	tmpfecha.setDate(fecha.getDate() + dias);
	var nfecha = String(tmpfecha.getFullYear()) + '-' + (String(tmpfecha.getMonth() + 1)).padStart(2,0) + '-' + (String(tmpfecha.getDate())).padStart(2,0);
	return nfecha;
}

function hoy(){
	var tmpfecha = new Date();
	var nfecha = String(tmpfecha.getFullYear()) + '-' + (String(tmpfecha.getMonth() + 1)).padStart(2,0) + '-' + (String(tmpfecha.getDate())).padStart(2,0);
	return nfecha;
}