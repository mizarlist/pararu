$(document).ready(function() {
    if (jQuery.browser.safari && document.readyState != "complete"){
        setTimeout( arguments.callee, 100 );
        return;
    }

    if (document.getElementById("register_page")!=null) CreateRegisterPage();
    if (document.getElementById("index_reg_form")!=null) CreateIndexPage();
    if ((document.getElementById("why_we_are")!=null) || (document.getElementById("why_we_are_tour")!=null)) CreateWhyWeArePage();

    if (document.getElementById("big_reg_btn")!=null) CreateAuthPage();
    
    


    CreateLangSelector();
    
 //   TEST_BOX_RP2();
});

/*Создание страницы Why We Are*/
function CreateWhyWeArePage(){
	CreateRegFormInit();
}
/* Включение строки выбора языка */
function CreateLangSelector(){
	var hide_lang_timer;

    $('.lang_active, .lang_flag').bind({
        click: function() { $('.lang_menu').fadeIn(500); },        
	    mouseover: function() { SetHideTimer(); },
	    mouseout: function() { StopHideTimer(1000);}                
    }); 
    
    $('.lang_menu').bind({ 
    	mouseover: function() { SetHideTimer(); },
    	mouseout: function() { StopHideTimer(1000); }        
    });       
    
    function SetHideTimer(){ clearTimeout(hide_lang_timer);}
    function StopHideTimer(time_out){ hide_lang_timer = setTimeout("$('.lang_menu').fadeOut(500);", time_out);}
 
}

function CreateAuthPage(){
	CreateRegFormInit();
	
    $('#big_reg_btn').bind({
        click: function() {
            $.blockUI({
                message: $('#index_reg_form'),
                css: { height: '418px', top: '45%', marginTop: '-209px', border: 'none', background: 'none', cursor: 'default' }
            });
            return false;
        }
    }); 	
}

function CreateRegFormInit(){
    CreateCheckBox();
/* Создание всплывающих списков */
	window.easyCombo_1 = new easyCombo('#me_gender');
	window.easyCombo_2 = new easyCombo('#find_gender');
	window.easyCombo_3 = new easyCombo('#birth_month');
	window.easyCombo_4 = new easyCombo('#how_do_get');
	
	window.easyCombo_1.call_func = function(){ 
		if(this.combo_input.attr('value') == 'женщина')	$('#find_gender_1').click(); else $('#find_gender_0').click();
	}	
	
	window.ajaxCombo_2 = new ajaxCombo("#me_country",
	 "{ functional: 'get_arials', data: { arial_class: 'country', conditions: { str: self.combo_input.val()}} }" , "country");
	window.ajaxCombo_1 = new ajaxCombo("#me_city",
	 "{ functional: 'get_arials', data: { arial_class: 'city', conditions: { str: self.combo_input.val(), country_id: window.ajaxCombo_2.currentValueId}} }","city", "me_region");
/* Вывод формы регистрации */ 
    $('.get_in_now .get_in_btn').bind({
        click: function() {
            $.blockUI({
                message: $('#index_reg_form'),
                css: { height: '418px', top: '45%', marginTop: '-209px', border: 'none', background: 'none', cursor: 'default' }
            });
            return false;
        }
    });    

/* Вывод формы регистрации */ 
    $('.register_menu .reg_me_in').bind({
        click: function() {
            $.blockUI({
                message: $('#index_reg_form'),
                css: { height: '418px', top: '45%', marginTop: '-209px', border: 'none', background: 'none', cursor: 'default' }
            });
            return false;
        }
    });     
    
    
    $('.close_irf').bind({ click: function() { $.unblockUI(); }});    
    $('#index_reg_form  .agree_button').bind({ click: function() { $("#index_reg_form form").submit(); }});    
    
    
	/* Валидация формы регистрации */    
	SetNumsOnly('#index_reg_form input[name="birth_date"]');
	SetNumsOnly('#index_reg_form input[name="birth_year"]');
	
	var reg_form = $("#index_reg_form form");
	var reg_input = $('#index_reg_form form input');
	var reg_agree = $('#index_reg_form form .i_agree .p_checkbox');
	
	reg_form.validate({
	               rules : {
	                       me_name : {required : true, minlength: 2},
	                       me_country : "required",
	                       me_country : "required",
	                       password:{required : true, minlength: 5},           
	                       password_confirm:{required : true, equalTo: "#password"},                 
	                       me_mail: {required: true, email: true },
	                       birth_date: { required: true, digits: true, max: 31, min: 1},
	                       birth_year: { required: true, digits: true, max: 2008, min: 1900},
	                       i_agree:  { required: true}
	                       
	               },
				//	messages : window.index_valid_msg,
					invalidHandler: function() { $('.agree_button.good').removeClass('good');}

    });
    
	reg_agree.click (function (){  delay(function(){ CheckFormAndButton(); }, 100);	});    

	reg_input.blur(function (){CheckFormAndButton();});    
	reg_input.keyup(function (){CheckFormAndButton();});    

    
    function CheckFormAndButton(){
    	if($("#index_reg_form form").valid()) $('.agree_button').addClass('good');
    }
}

/* Создание страницы индекса */
function CreateIndexPage(){

 //   CreateCheckBox();
   	CreateRegFormInit();
   	
    $('#index_go_reg, .do_first_step').bind({
        click: function() {
            $.blockUI({
                message: $('#index_reg_form'),
                css: { height: '418px', top: '45%', marginTop: '-209px', border: 'none', background: 'none', cursor: 'default' }
            });
            return false;
        }
    });    	
   	
/*
	window.easyCombo_1 = new easyCombo('#me_gender');
	window.easyCombo_2 = new easyCombo('#find_gender');
	window.easyCombo_3 = new easyCombo('#birth_month');
	window.easyCombo_4 = new easyCombo('#how_do_get');
	
	window.easyCombo_1.call_func = function(){ 
		if(this.combo_input.attr('value') == 'женщина')	$('#find_gender_1').click(); else $('#find_gender_0').click();
	}
	
	
	window.ajaxCombo_2 = new ajaxCombo("#me_country",
	 "{ functional: 'get_arials', data: { arial_class: 'country', conditions: { str: self.combo_input.val()}} }" , "country");
	window.ajaxCombo_1 = new ajaxCombo("#me_city",
	 "{ functional: 'get_arials', data: { arial_class: 'city', conditions: { str: self.combo_input.val(), country_id: window.ajaxCombo_2.currentValueId}} }","city", "me_region");

    $('#index_go_reg, .do_first_step').bind({
        click: function() {
            $.blockUI({
                message: $('#index_reg_form'),
                css: { height: '418px', top: '45%', marginTop: '-209px', border: 'none', background: 'none', cursor: 'default' }
            });
            return false;
        }
    });    
    $('.close_irf').bind({ click: function() { $.unblockUI(); }});    
    $('#index_reg_form  .agree_button').bind({ click: function() { $("#index_reg_form form").submit(); }});    
    
    
  
	SetNumsOnly('#index_reg_form input[name="birth_date"]');
	SetNumsOnly('#index_reg_form input[name="birth_year"]');
	
	var reg_form = $("#index_reg_form form");
	var reg_input = $('#index_reg_form form input');
	var reg_agree = $('#index_reg_form form .i_agree .p_checkbox');
	
	reg_form.validate({
	               rules : {
	                       me_name : {required : true, minlength: 2},
	                       me_country : "required",
	                       me_country : "required",
	                       password:{required : true, minlength: 5},           
	                       password_confirm:{required : true, equalTo: "#password"},                 
	                       me_mail: {required: true, email: true },
	                       birth_date: { required: true, digits: true, max: 31, min: 1},
	                       birth_year: { required: true, digits: true, max: 2008, min: 1900},
	                       i_agree:  { required: true}
	                       
	               },
				//	messages : window.index_valid_msg,
					invalidHandler: function() { $('.agree_button.good').removeClass('good');}

    });
    
	reg_agree.click (function (){  delay(function(){ CheckFormAndButton(); }, 100);	});    

	reg_input.blur(function (){CheckFormAndButton();});    
	reg_input.keyup(function (){CheckFormAndButton();});    

    
    function CheckFormAndButton(){
    	if($("#index_reg_form form").valid()) $('.agree_button').addClass('good');
    }
    */
    function ActivateSlides(){
    	var current_slide = 1;
    	var $index_slides_pages = $(".index_slides_pages");
    	var change_slide_timer = 5000;
    	var max_slide = $(".index_slides_pages").find('.one_slide_page').length;
    	var auto_slide = true;
    	var timer = setTimeout(function(){ Change_by_timer(); 	}, change_slide_timer);
    	
    	
    	function Change_by_timer(){
    		new_slide = current_slide+1;
    		if(new_slide > max_slide) new_slide = 1;
    		ChangeSlide(new_slide);	
    		if(auto_slide != false){
    			timer = setTimeout(function(){ Change_by_timer(); 	}, change_slide_timer);			    	
    		}
	    	
    	}
    	
    	function ChangeSlide(slide){
    		$('.index_sildes_controls ul li').removeClass('active');
    		$('#slide'+slide).addClass('active');
    		current_slide = (slide);
    		new_left = parseInt(slide-1)*(-960);
    		$index_slides_pages.animate({left: new_left+"px"}, { duration: 800, queue: false});
    	}
    	
    	$('.index_sildes_controls ul li').bind({  click: function() {  
    		var new_slide = $(this).attr('id').substr(5);
    		ChangeSlide(new_slide);
    		clearTimeout(timer);
    		auto_slide = false;
    	}});
    	
    	
    	
    	/*
    	$('.one_slide_page').bind({  click: function() {  
    	document.location = $(this).find('.link').attr('href');  
    	}});
    	*/
    }
    ActivateSlides();
  //  $("#index_reg_form form .i_agree .p_checkbox input").change(function() {
  //  	console.log(123);
//    	
	//});
    
}


// Вызов функций на странице регистрации
function CreateRegisterPage(){
    window.my_regPie = new regPie('#register_pie');
    CreateRegStep1();
    
    
}

//Шаг 1 на странице регистрации
function CreateRegStep1(){
    //Включение первого шага пирога
    window.my_regPie.set_active(1);
    // Массив вариантов для тем
    // Увлечения в темах вида {i_like_sport : 'Спорт', i_like_sweem : 'Плавание'}
    var reg_step1_variants = window.reg_step1_variants;
    var selected_theme = 0;
    var save_button = $('.rs1_save');
    var var_list = $("#rs1_var_list");
	
   	$('#right_col_postload').html($('#right_col_load').html()).fadeIn(300);		
	
    $('.close_rs1_box').bind({
        click: function() {
            $.unblockUI();
        }
    });
    save_button.bind({
        click: function() {
            GoToNextRegSrep();
        }
    });
	
    $('#register_step1 .rs1_img').bind({
        click: function() {
            UpdateCheckForm((selected_theme = $(this).attr('id').substr(6)));
            $.blockUI({
                message: $('.rs1_box1'),
                css: {
                	top: '20%',
                    width: '428px',
                    border: 'none',
                    background: 'none',
                    cursor: 'default'
                }
            });
	
        }
    });
	
    function UpdateCheckForm(form_num){
        var new_var_list = "";
        for(var name in reg_step1_variants[form_num]) new_var_list += '<div class="p_checkbox" id="'+name+'">'+reg_step1_variants[form_num][name]+'</div>';
        var_list.html(new_var_list);
        CreateCheckBox();
        CheckActiveSels();
    }

    function CreateCheckBox(){
        $('.p_checkbox').bind({
            click: function() {
                if(GetActiveSelsCount() < 5) $(this).toggleClass('active');
                else $(this).removeClass('active');
                CheckActiveSels();
            }
        });
        
    }
	
    function CheckActiveSels(){
        var current_active = GetActiveSelsCount();
        if(current_active == 0) save_button.addClass('rs1_not_save').html(window.translation[0]);
        else
        if(current_active < 5)  save_button.removeClass('rs1_not_save').html(window.translation[1]+' '+current_active+' '+window.translation[2]+'<i></i>'); 
        	else save_button.removeClass('rs1_not_save').html(window.translation[3]+'<i></i>');
        if(current_active  >= 5) return false; else return true;
    }
	
    function GetActiveSelsCount(){
        var current_active = 0;
        $("#rs1_var_list .active").each( function() {
            current_active++;
        });
        return current_active;
    }


	function GoToNextRegSrep(){
        var current_active = 0;
        var current_select_data = '';
        $("#rs1_var_list .active").each( function() {
            current_active++;
            current_select_data += $(this).attr('id')+';';
        });
        if(current_active > 0) {
	        blockPage_msg();
			$.post("/registration", { current_step: "1", request_step: "2", data: { card_name: selected_theme, selected: current_select_data} },
            function(data) {
                if(data){
                    $('#left_reg_column_in').html(data);
                    CreateRegStep2();
                } else {
                    alert(window.emptyMsg);
                }
            }
            );
        }
	}
	    
//	SetRegProcess(window.translation[5], 4);	
}




function TEST_BOX_RP2(){
/*	window.translation = new Array();
	window.translation[0] = 'Увлечения не выбраны';
	window.translation[1] = 'Выбрано';
	window.translation[2] = 'из 5';
	window.translation[3] = 'Сохранить и продолжить';	
	window.translation[4] = 'Шаг 2: регистрация заполнена на 10%';	
	window.my_regPie = new regPie('#register_pie');
	CreateRegStep2();
*/
}



// Шаг 2 на странице регистрации
function CreateRegStep2(){
	// Включение второй вкладки
	SetRegActiveTab(2);
	// Включение второй дольки пирога	
	//window.my_regPie.set_active(2);
	// Изменение прогресса регистрации	
	SetRegProcess(window.translation[4], 10);

	$('#register_pie').fadeTo("slow", 0.33);
	// Включение стикеров выбора страницы
	var all_pages_count = $('#register_step2 .page_selector .pages_stiks').attr('id');	
	if(all_pages_count){
		all_pages_count = all_pages_count.substring(9);
	    window.page_stikers = new StickersGroup('.pages_stiks', 1, 1, all_pages_count, all_pages_count, 'quick_find_pages', ChangeRegStep2Find);	
	}
    // Добавление кнопки перехода к следующему шагу
    //$('.right_column').append('<div class="register_go_next1" id="register_go_next1">Продолжить анкетирование</div>');
    
    // Загрузка содержимого в правую колонку
   	$('#right_col_postload').html($('#right_col_load').html()).fadeIn(300);
	//Разблокирвка экрана
	$.unblockUI();
	
	$('a.zoom_in').colorbox();
	
	//Включение кнопок перехода к следующему шагу
	$('#register_go_next1, #register_go_next2').bind({  click: function() { GoToNextRegSrep(); }});
	

	
    function GoToNextRegSrep(){
	    	blockPage_msg();
			$.post("/registration", { current_step: "2", request_step: "3" },
            function(data) {
                if(data){
                    $('#left_reg_column_in').html(data);
                    CreateRegStep3();
                } else {
                    alert(window.emptyMsg);
                }
            }
            );
    }	
}
/*
$(document).ready(function() {

    if (jQuery.browser.safari && document.readyState != "complete"){
        setTimeout( arguments.callee, 100 );
        return;
    }

	TEST_BOX_RP3();

});

function TEST_BOX_RP3(){
	window.translation = new Array();
	window.translation[0] = 'Увлечения не выбраны';
	window.translation[1] = 'Выбрано';
	window.translation[2] = 'из 5';
	window.translation[3] = 'Сохранить и продолжить';	
	window.translation[4] = 'Шаг 2: регистрация заполнена на 10%';	
	window.my_regPie = new regPie('#register_pie');
	CreateRegStep3();

}

*/
// Шаг 3 на странице регистрации
function CreateRegStep3(){
	// Включение 3 вкладки
	SetRegActiveTab(3);
	$('#register_pie').fadeTo('slow',1);
	// Включение 2 дольки пирога	
	window.my_regPie.set_active(2);
	// Изменение прогресса регистрации	
	SetRegProcess(window.translation[5], 18);
    // Загрузка содержимого в правую колонку
   	$('#right_col_postload').html($('#right_col_load').html()).fadeIn(300);	
	//Разблокирвка экрана
	$.unblockUI();
	//Включение кнопок перехода к следующему шагу
	$('#register_go_next3').bind({  click: function() { GoToNextRegSrep(); }});	
	//Включение работы вкладок и прочей хрени шага 3
	CreateCheckBox();
	ActivatePersonalChecks();
	//Сбор данных для отправки
	function CollectData(){
		var collected = {};
		$(".reg3_pers_block.complete").each( function() { 
			block_name = $(this).attr('id');
			collected[block_name] = {};
			
			$(this).find('.active').each( function() { 
				collected[block_name][$(this).attr('id')] = 'true';
			});


		});
		
		return collected;
	}


    function GoToNextRegSrep(){ 
    
	    	blockPage_msg();
			$.post("/registration", { current_step: "3", request_step: "4", data: CollectData()  },	    	
            function(data) {
                if(data){
                    $('#left_reg_column_in').html(data);
                    CreateRegStep4();
                } else {
                    alert(window.emptyMsg);
                }
            }
            );
    }
	
}
/*
$(document).ready(function() {

    if (jQuery.browser.safari && document.readyState != "complete"){
        setTimeout( arguments.callee, 100 );
        return;
    }

	TEST_BOX_RP4();

});

function TEST_BOX_RP4(){
	window.translation = new Array();
	window.translation[0] = 'Увлечения не выбраны';
	window.translation[1] = 'Выбрано';
	window.translation[2] = 'из 5';
	window.translation[3] = 'Сохранить и продолжить';	
	window.translation[4] = 'Шаг 2: регистрация заполнена на 10%';	
	window.my_regPie = new regPie('#register_pie');
	CreateRegStep4();

}
*/

// Шаг 4 на странице регистрации
function CreateRegStep4(){
	// Включение 4 вкладки
	SetRegActiveTab(4);
	// Включение 3 дольки пирога	
	window.my_regPie.set_active(3);
	// Изменение прогресса регистрации	
	SetRegProcess(window.translation[6], 33);
	var next_step = 1;
	var complete_steps = [];
	window.current_quest_block = 0;
	
    // Загрузка содержимого в правую колонку
   	$('#right_col_postload').html($('#right_col_load').html()).fadeIn(300);		
	
	function InitStep4(){
		SetSelLiPositions();
		// Включение перематывалок
		$(".q_marks").each( function() { var tmp_mark = new qMarkControl($(this));});		
		//Включение  слайдеров
		$(".range_track").slider({ range: "min", value: 1, min: 1, max: 100, slide: function( event, ui ) {
			$(this).parent('.q_track').parent('.q_track_line').parent('.q_tracks').parent('.nic_question').addClass('completed');
			CheckQuestBlockComplete();			
		}});	
		//Включение ограничителя количества галочек CheckQuestBlockComplete
		createChecksLimit();
		//Закрыть блок вопросов
		$('.close_nic_question').bind({  click: function() {  $.colorbox.close();  }});
		//Закончить блок вопросов		
		$('.next_nic_question').bind({  click: function() {  CompleteCurrentStep();  }});
		//Выбор текущего шага		
		$('#register_step4 .nic_step_select ul li').bind({  click: function() {  OpenNicBlock($(this));  }});
		//Разблокирвка экрана
		$.unblockUI();		
		//Кнопка перехода к шагу 5
		$('#register_go_next5').bind({  click: function() {  GoToNextRegSrep();  }});

		
		//$( "#amount" ).val( "$" + $( "#slider-range-min" ).slider( "value" ) );
		
	}

	//Сбор данных для отправки
	function CollectData(){
		var collected = {};

		collected['set'] = {};
		
		$(".q_checks. .p_checkbox.active").each( function() { 
			check_name = $(this).attr('id');
			collected['set'][check_name] = 'true';				
		});

		$(".q_marks .q_mark_line .q_marks_ctrls .value").each( function() { 
			mark_name = $(this).attr('id');
			collected['set'][mark_name] = $(this).html();				
		});
		
		$(".range_track").each( function() { 
			track_name = $(this).attr('id');
			collected['set'][track_name] = $(this).slider("value");
		});		

		collected['order'] = complete_steps;
		
		return collected;
	}


    function GoToNextRegSrep(){ 
    //	console.log(CollectData());
    
	    	blockPage_msg();
			$.post("/registration", { current_step: "4", request_step: "5", data: CollectData()  },	    	
            function(data) {
                if(data){
                    $('#left_reg_column_in').html(data);
                    CreateRegStep5();
                } else {
                    alert(window.emptyMsg);
                }
            }
            );
    }	
	
	function CompleteCurrentStep(){
		$.scrollTo( '#register_page', { duration:700});
		$('#cboxContent').animate({
		    height: '20px'
		  }, 850, function() {
				CompleteNicLi($('#nic_sel_li'+window.current_quest_block));
				complete_steps.push(window.current_quest_block);
				$.colorbox.close();
				$('#select_text'+next_step).css('display', 'none');
				next_step_new = parseInt(next_step) + parseInt(1);
				//console.log('#select_text'+next_step);
				$('#select_text'+next_step_new).css('display', 'block');
		  });	
	
	
	}
	
	
	function OpenNicBlock(clicked_li){
		if(clicked_li.hasClass('new_li')){
			window.current_quest_block = clicked_li.attr('id').substr(10);
			$.colorbox({ inline:true, opacity: 0.75, href:"#nic_question_block"+window.current_quest_block});		
		}
	}
	

	
	function SetSelLiPositions(){
		$("#register_step4 .nic_step_select ul li.new_li").each( function() { 
			var temp_offset = $(this).position();
			$(this).css('left', temp_offset.left).css('top', temp_offset.top);			
		});	
	}
	
	function CompleteNicLi(clicked_li){
		new_offset = $('#nic_top_li'+next_step).position();
		clicked_li.css('position', 'absolute').removeClass('new_li');
		clicked_li.animate({
		    left: new_offset.left,
		    top: new_offset.top,
			width: '84px',
			height: '29px',
			fontSize: '10px',
			lineHeight: '27px',
		  }, 1000, function() {
			    SetSelLiPositions();
				next_step++;		    
		  });

	}
	
	function createChecksLimit(){
			
		$('.p_checkbox').bind({   click: function() { 
			q_checks_obj = $(this).parent('.q_checks');
			q_check_count = q_checks_obj.children('.active').length;			
			if(q_check_count < 3){
				$(this).toggleClass('active');
			}  else {
				if($(this).hasClass('active')) $(this).removeClass('active');
			}
			q_check_count = q_checks_obj.children('.active').length;
			if(q_check_count == 3) q_checks_obj.parent('.nic_question').addClass('completed'); else q_checks_obj.parent('.nic_question').removeClass('completed');
			CheckQuestBlockComplete();
		}});	
		
	}
	
	function fuck(){
		alert('fuck');
	}
	
	InitStep4();
}

function CheckQuestBlockComplete(){
	block_completed = true;
	$("#nic_question_block"+window.current_quest_block+" .nic_question").each( function() { 
		if(!$(this).hasClass('completed')) block_completed = false;
	});
	next_nic_question = $("#nic_question_block"+window.current_quest_block+" .next_nic_question");
	if(block_completed == true) {
		next_nic_question.fadeIn();
	} else {
		next_nic_question.fadeOut();
	}

}

function qMarkControl(q_mark_obj){

	var self = this;
	self.q_mark_obj = q_mark_obj;
	self.q_mark_obj_parent = self.q_mark_obj.parent('.nic_question');
	self.summ_obj = self.q_mark_obj.children('.q_mark_summ').children('.summ_in');
	self.marks_count = parseInt(self.summ_obj.html());
	self.max_count = self.marks_count;
	self.right_btns = self.q_mark_obj.children('.q_mark_line').children('.q_marks_ctrls').children('.set_right');
	self.left_btns = self.q_mark_obj.children('.q_mark_line').children('.q_marks_ctrls').children('.set_left');
	

	self.init = function(){  
		self.right_btns.bind({  click: function() {  self.MarkMinus($(this));  }});
		self.left_btns.bind({  click: function() {  self.MarkPlus($(this));  }});
	}

	self.MarkMinus = function(right_btn){
		if(self.marks_count > 0){
			var ctrl_obj = right_btn.parent('.q_marks_ctrls');
			var ctrl_val_obj = ctrl_obj.children('.value');		
			var ctrl_val = parseInt(ctrl_val_obj.html());
			
			ctrl_val++;
			ctrl_val_obj.html(ctrl_val);
			self.marks_count--;
			self.CheckButtonViews();
		}
		self.UpdateMarkView();
	}
	self.MarkPlus = function(left_btn){
		if(self.marks_count < self.max_count){
			var ctrl_obj = left_btn.parent('.q_marks_ctrls');
			var ctrl_val_obj = ctrl_obj.children('.value');		
			var ctrl_val = parseInt(ctrl_val_obj.html());
		//	console.log('before '+ctrl_val);
			if(ctrl_val > 0){
				//console.log('after '+ctrl_val);
				ctrl_val--;
				ctrl_val_obj.html(ctrl_val);
				self.marks_count++;
				self.CheckButtonViews();
			
			}
		
		}
		self.UpdateMarkView();	
	}
	self.CheckButtonViews = function(){

		self.q_mark_obj.children('.q_mark_line').children(".q_marks_ctrls").each( function() { 
			var tmp_l_btn = $(this).children('.set_left');
			var tmp_val = parseInt($(this).children('.value').html());
			//console.log(tmp_val);						
			if(self.marks_count < 1) self.right_btns.fadeOut(); else self.right_btns.fadeIn(); 			
			if(tmp_val > 0) tmp_l_btn.fadeIn(); else tmp_l_btn.fadeOut(); 
		});
	}
	
	self.UpdateMarkView = function(){ 
		self.summ_obj.html(self.marks_count);
		if(self.marks_count == 0) self.q_mark_obj_parent.addClass('completed'); else self.q_mark_obj_parent.removeClass('completed');
		CheckQuestBlockComplete();
	}
	
	self.init();
}


// Шаг 5 на странице регистрации
function CreateRegStep5(){
	// Включение 5 вкладки
	SetRegActiveTab(5);
	// Включение 4 дольки пирога	
	window.my_regPie.set_active(4);
	// Изменение прогресса регистрации	
	SetRegProcess(window.translation[7], 93);
    // Загрузка содержимого в правую колонку
   	$('#right_col_postload').html($('#right_col_load').html()).fadeIn(300);	
	//Разблокирвка экрана
	$.unblockUI();
	//Включение кнопок перехода к следующему шагу
	$('#register_go_next3').bind({  click: function() { GoToNextRegSrep(); }});	
	//Включение работы вкладок и прочей хрени шага 5
	CreateCheckBox();
	ActivatePersonalChecks();
	//Сбор данных для отправки
	function CollectData(){
		var collected = {};
		$(".reg3_pers_block.complete").each( function() { 
			block_name = $(this).attr('id');
			collected[block_name] = {};
			
			$(this).find('.active').each( function() { 
				collected[block_name][$(this).attr('id')] = 'true';
			});


		});
		
		return collected;
	}


    function GoToNextRegSrep(){ 
    
	    	blockPage_msg();
			$.post("/registration", { current_step: "5", request_step: "6", data: CollectData()  },	    	
            function(data) {
                if(data){
                    $('#left_reg_column_in').html(data);
                    CreateRegStep6();
                } else {
                    alert(window.emptyMsg);
                }
            }
            );
    }
	
}


// Шаг 6 на странице регистрации
function CreateRegStep6(){
	// Включение 6 вкладки
	SetRegActiveTab(6);
	// Включение 5 дольки пирога	
	window.my_regPie.set_active(5);
	// Изменение прогресса регистрации	
	SetRegProcess(window.translation[8], 100);
    // Загрузка содержимого в правую колонку
   	$('#right_col_postload').html($('#right_col_load').html()).fadeIn(300);	
	//Разблокирвка экрана
	$.unblockUI();
	//Включение кнопок перехода к следующему шагу
//	$('#register_go_next3').bind({  click: function() { GoToNextRegSrep(); }});	

	
}





// Включение работы заполения форм для третьего шага
function ActivatePersonalChecks(){
	if($('.reg3_pers_block').hasClass('needed')) $('#register_go_next3').css('display', 'none');
	InitClicks();
	
	function CheckAllNeeds(){
		all_ok = true;		
	
		$('.reg3_pers_block.needed').each( function() { 
			if(!$(this).hasClass('complete')) all_ok = false;
		});	
		
		return all_ok;
	}
	
	function InitClicks(){
		//Работа галочек
		$('.p_checkbox').bind({   click: function() { 		
			var parent_in = $(this).parent().parent().parent('.reg3_pers_block');//.parent('.reg3_pers_block');		
			if(parent_in.find('.active').length){
				parent_in.addClass('complete');
				OpenBlockFlap(parent_in.next());
				if(CheckAllNeeds() == false) $('#register_go_next3').fadeOut(300); else $('#register_go_next3').fadeIn(300);
			} else {
				parent_in.removeClass('complete');			
				if(CheckAllNeeds() == false) $('#register_go_next3').fadeOut(300); else $('#register_go_next3').fadeIn(300);
			}
		}});
		
		//Работа плюсиков и минусиков
		$('.reg3_pers_block_name').bind({  click: function() {  ToggleBlockFlap($(this).parent());  }});
	}
	
	
	function ToggleBlockFlap(jq_block){
		if(jq_block.hasClass('active')){
			jq_block.removeClass('active')
			jq_block.children('.reg3_pers_block_in').slideUp();
			jq_block.children('.reg3_pers_block_name').children('span').html('+');			
		} else {
			jq_block.addClass('active')
			jq_block.children('.reg3_pers_block_in').slideDown();
			jq_block.children('.reg3_pers_block_name').children('span').html('-');
	//		$.scrollTo(jq_block);	
		}
	}
	
	function OpenBlockFlap(jq_block){
			jq_block.addClass('active')
			jq_block.children('.reg3_pers_block_in').slideDown();
			jq_block.children('.reg3_pers_block_name').children('span').html('-');				
	}

}

// Включение CheckBox-а
function CreateCheckBox(){

	$(".p_checkbox").each( function() { 
		if($(this).children('input:checked').length){
			$(this).addClass('active');
			
		} 
	});

	$('.p_checkbox').bind({   click: function() { 
	
		parent_div = $(this).parent();
		if(parent_div.hasClass('radio_group')){
			if($(this).attr('id') != parent_div.children('.active').attr('id')){
				parent_div.children('.active').removeClass('active');
				$(this).addClass('active');
			} else {
				$(this).toggleClass('active');
			}
			
			
		
		} else {
			if($(this).children('input').length){
				$(this).toggleClass('active');
				if($(this).hasClass('active')) $(this).children('input').attr('checked', 'checked'); else
				$(this).children('input').removeAttr('checked');
			} else {
				$(this).toggleClass('active');
			}		
		}


		
	}});

/*
	$(".p_checkbox").each( function() { 
	
	
		if($(this).children('input').length){
		
			if($(this).children('input:checked').length) $('.p_checkbox').addClass('active'); 			
			
			$('.p_checkbox').bind({   click: function() { 
				console.log('clic');
				$(this).toggleClass('active');
				if($(this).hasClass('active')) $(this).children('input').attr('checked', true); else
				$(this).children('input').attr('checked', false);
			}});
			
		} else {
			$(this).bind({   click: function() {  $(this).toggleClass('active'); } });				
		}

	});
    */
}

function SetRegActiveTab(tab_id){
    $('.register_menu .active').removeClass('active');
    $('#rm_li'+tab_id).addClass('active');
}
//Прогресс заполнения на странице регистрации
function SetRegProcess(new_text, new_pos){
    register_progress = $('.register_progress');
    register_progress.children('.rp_text').html(new_text);
    register_progress.children('.rp_fill').css('width',new_pos+'%');
}

//Простая всплывалка
function easyCombo(combo_name){
	var self = this;
	self.combo_name = combo_name;
	self.combo_obj = $(combo_name);
	self.combo_input = self.combo_obj.children('input');
	self.one_combo = self.combo_obj.children('.combo_variants').children('.one_combo');
	self.combo_variants = self.combo_obj.children('.combo_variants')	
	self.show_state = false;
	self.hide_timer;
	self.call_func = function(){ };
	
	self.init = function(){
		self.combo_obj.children('.easy_mask').bind({  click: function() { if(!self.show_state) self.show_list();   }});
	    self.one_combo.bind({  click: function() { self.new_selection($(this)); }});	
		self.combo_obj.bind({
		    mouseover: function() {
				clearTimeout(self.hide_timer);
		    },
		    mouseout: function() {
		    	self.hide_timer = setTimeout(self.hide_list, 1200);
		    }
		});	
		self.one_combo.bind({
		    mouseover: function() {
				self.combo_variants.children('.one_combo').removeClass('hover');
				$(this).addClass('hover');
		    }
		});	    	
		self.combo_input.focusin(function(){
			self.show_list();	
		}).focusout(function(){
			self.hide_list();
		}).keydown(function(event){
			if(event.keyCode == 38) {

				if(!self.combo_variants.children('.one_combo').hasClass('hover')){
					self.combo_variants.children('.one_combo:last').addClass('hover')
				} else {
					self.combo_variants.children('.one_combo.hover').removeClass('hover').prev().addClass('hover');
					if(!self.combo_variants.children('.one_combo').hasClass('hover')) self.combo_variants.children('.one_combo:last').addClass('hover');
				}			

			} else if (event.keyCode == 40) {
				if(!self.combo_variants.children('.one_combo').hasClass('hover')){
					self.combo_variants.children('.one_combo:first').addClass('hover')
				} else {
					self.combo_variants.children('.one_combo.hover').removeClass('hover').next().addClass('hover');
					if(!self.combo_variants.children('.one_combo').hasClass('hover')) self.combo_variants.children('.one_combo:first').addClass('hover');
				}			
			} else if (event.keyCode == 13) {
				self.new_selection(self.combo_variants.children('.one_combo.hover'));			
			} else {
			}
		});
		
		self.new_selection(self.combo_obj.find('.one_combo.hover'));
	}
	
	self.show_list = function(){ self.combo_obj.children('.combo_variants').fadeIn(); self.show_state = true;}
	self.hide_list = function(){ self.combo_obj.children('.combo_variants').fadeOut(); self.show_state = false;}
	
	self.new_selection = function(clicked_obj){
		var clicked_id = '';
		clicked_id = clicked_obj.attr('id');

		combo_cut_name = self.combo_name.substring(1);
		clicked_name = clicked_obj.html();
		self.combo_input.val(clicked_name);
		clicked_id = clicked_id.substring(combo_cut_name.length+1);
		self.combo_obj.children('.easy_mask').html('<input type="hidden" name="'+combo_cut_name+'_id" value="'+clicked_id+'">');  
		self.hide_list();
		self.call_func();
	}
	
	self.init();
}


//Ajax-всплывалка
function ajaxCombo(combo_name, post_obj, id_modif, second_hide_input){
	var self = this;
	self.combo_name = combo_name;
	self.combo_obj = $(combo_name);
	self.combo_input = self.combo_obj.children('input.send_name');
	self.combo_input_id = self.combo_obj.children('input.send_id');
	self.combo_variants = self.combo_obj.children('.combo_variants')	

	self.show_state = false;
	self.hide_timer;
	self.currentValue = self.combo_input.val();
	self.currentValueId = self.combo_input_id.val();

	self.post_obj = post_obj || "{}";
	self.id_modif = id_modif || "ajax_comb";
	
	self.second_hide_input = second_hide_input || false; 
	if(self.second_hide_input != false) self.second_hide_val = 0; else self.second_hide_val = false;
 	
	self.init = function(){
		self.combo_input.bind({  click: function() { 
			$(this).val("");
			
			 delay(function(){
				self.update_combo();	
				self.show_list();	
		    }, 100);			
		}})
		.focusin(function(){
				self.combo_input.val("");
			 delay(function(){
				self.update_combo();	
				self.show_list();	
		    }, 100);			
		})

		.focusout(function(){
			$(this).val(self.currentValue);
			self.hide_list();
		})
		.keydown(function(event){
			if(event.keyCode == 38) {

				if(!self.combo_variants.children('.one_combo').hasClass('hover')){
					self.combo_variants.children('.one_combo:last').addClass('hover')
				} else {
					self.combo_variants.children('.one_combo.hover').removeClass('hover').prev().addClass('hover');
					if(!self.combo_variants.children('.one_combo').hasClass('hover')) self.combo_variants.children('.one_combo:last').addClass('hover');
				}			

			} else if (event.keyCode == 40) {
				if(!self.combo_variants.children('.one_combo').hasClass('hover')){
					self.combo_variants.children('.one_combo:first').addClass('hover')
				} else {
					self.combo_variants.children('.one_combo.hover').removeClass('hover').next().addClass('hover');
					if(!self.combo_variants.children('.one_combo').hasClass('hover')) self.combo_variants.children('.one_combo:first').addClass('hover');
				}			
			} else if (event.keyCode == 13) {
				self.new_selection(self.combo_variants.children('.one_combo.hover'));			
			} else {
//				console.log(event.keyCode);
				if((event.keyCode > 1039 && event.keyCode < 1106) || (event.keyCode > 63 && event.keyCode < 123) || (event.keyCode == 0) || (event.keyCode == 8)){
				 delay(function(){
					self.update_combo();
					clearTimeout(self.hide_timer);
			    }, 400);
			    }
			
			
			}
		});


		self.combo_obj.children('.easy_mask').bind({  click: function() { 
		
			self.update_combo();	
			self.show_list();	
		
		}});
		
			
	    	
		self.combo_obj.bind({
		    mouseover: function() {
				clearTimeout(self.hide_timer);
		    },
		    mouseout: function() {
		    	self.hide_timer = setTimeout(self.hide_list, 2500);
		    }
		});	    	
	}
	
		self.update_combo = function(){
			self.combo_variants.children('.one_combo.hover').removeClass('hover');			
			$.post("/", eval( "(" +self.post_obj+")"),
            function(data) {
                if(data){
					var new_data = data;
					new_data = eval(new_data);
					new_html = '';
					for (var i = 0, length = new_data.length; i < length; i++) {
					    if (i in new_data) {			  
 	
					    	if((new_data[i].region_name == undefined) || new_data[i].region_name == 'undefined')
						        new_html += '<div class="one_combo" id="'+self.id_modif+new_data[i].id+'">'+new_data[i].name+'</div>';
						    else {
			    			        new_html += '<div class="one_combo" id="'+self.id_modif+new_data[i].id+'">'+new_data[i].name+'<span>'+new_data[i].region_name+'</span></div>';														if(self.second_hide_input != false) self.second_hide_val = new_data[i].region_id;	
    			        	}

					    }
					}			
					self.combo_variants.html(new_html);
					self.combo_variants.children('.one_combo:first').addClass('hover');
					self.set_one_combo_click();


                } else {
                    alert('Error Reg Form');
                }
            }
            );			
			
		}		
	
	self.set_one_combo_click = function (){	
		self.combo_variants.children('.one_combo').bind({  click: function() { self.new_selection($(this)); },
			mouseover: function() {  self.combo_variants.children('.one_combo').removeClass('hover');
			$(this).addClass('hover');
			}		
		});
	}
	self.show_list = function(){ self.combo_obj.children('.combo_variants').fadeIn(); self.show_state = true;}
	self.hide_list = function(){ self.combo_obj.children('.combo_variants').fadeOut(); self.show_state = false;}
	
	self.new_selection = function(clicked_obj){
		self.currentValueId = clicked_obj.attr('id').substr(self.id_modif.length);
		clicked_name = clicked_obj.html();
		if(clicked_name.indexOf('<') > 0) clicked_name = clicked_name.substr(0,clicked_name.indexOf('<'));
		self.currentValue = clicked_name; 
		self.combo_input.val(clicked_name);
		self.combo_input_id.val(self.currentValueId);
		if(self.second_hide_input != false){
			self.combo_obj.children('.easy_mask').html('<input type="hidden" name="'+self.second_hide_input+'" value="'+self.second_hide_val+'">');  
		}		
		 
		self.hide_list();
	}
	
	self.init();
}

// «Пирог» на странице регистрации
function regPie(pie_name){
    var self = this;
    self.pie_name = pie_name;
    self.pie_obj = $(pie_name);
    var pie_positions = [
    {},
    { r:0, t:-5, a_r:-9, a_t:-17 },
    { r:-2,t:56, a_r:-11,a_t:59  },
    { r:33,t:72, a_r:33, a_t:82  },
    { r:76,t:56,a_r:87,a_t:60    },
    {r:75,t:-7,a_r:82,a_t:-18    }
    ];


	
    self.set_active = function(current_id){
    	if(self.de_active != 1) self.de_active(current_id-1);
        $('#rp_list'+current_id+' .rpl_off').fadeIn(900);
        $('#rp_list'+current_id+' .rpl_on').fadeOut(900);
        $('#rp_list'+current_id).animate({
            right: pie_positions[current_id].a_r,
            top: pie_positions[current_id].a_t
        }, {
            duration: 900,
            queue: false
        });
    }
    
    self.de_active = function(current_id){
        $('#rp_list'+current_id+' .rpl_onoff').fadeIn(900);
        $('#rp_list'+current_id+' .rpl_off').fadeOut(900);
        $('#rp_list'+current_id).animate({
            right: pie_positions[current_id].r,
            top: pie_positions[current_id].t
        }, {
            duration: 900,
            queue: false
        });
    }    
}

/* Функция, эмитирующая задержку с очередью в один элемент*/
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

/* Только числовой ввод (для полей) */	
function SetNumsOnly(obj_name){
	$(obj_name).keydown(function(event) { 

		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ) { 
		} else { 
		if (event.keyCode < 95) { 
			if (event.keyCode < 48 || event.keyCode > 57 ) { 
				event.preventDefault();	
			} 
		} else { 
			if (event.keyCode < 96 || event.keyCode > 105 ) { 
				event.preventDefault();	
		} 
		} 
	} 
	});	
}	
	
	
function ChangeRegStep2Find(){
	blockPage_msg();
	$.post("/registration", { current_step: "2", request_step: "2", page: this.new_page_num  },
    function(data) {
        if(data){
            $('#register_step2_cards').html(data);
            $.scrollTo( '#register_page', { duration:500});
            $.unblockUI();
            $('a.zoom_in').colorbox();
        } else {
            alert(window.emptyMsg);
        }
    }
    );




}


function StickersGroup(stik_parents, min, current, max, max_els, ids, callb_func){
	var self = this;
	self.stik_parents = stik_parents;
	self.stik_parents_ob = $(stik_parents);	
	self.max = max;
	self.current = current;
	self.min = min;
	self.ids = ids;
	self.ids_len = ids.length;
	self.callb_func = callb_func;
	self.max_els = max_els;

	
	self.init_stiks = function(){
		if(self.max == 0 && self.min == 0){
			$(self.stik_parents+' .stik').each( function() { 
				self.add_stik_funcs($(this));	
			});
		} else {		
			// ←
				self.stik_parents_ob.append('<div class="stik" id="'+self.ids+'p"/>');
				curr_stik_obj = $('#'+self.ids+'p');
				curr_stik_obj.html('←');		
				self.add_stik_funcs(curr_stik_obj, true);			

			// ...
				self.stik_parents_ob.append('<div class="stik" id="'+self.ids+'l"/>');
				curr_stik_obj = $('#'+self.ids+'l');
				curr_stik_obj.html('1…');	
				self.setFontSize(curr_stik_obj);	
				self.add_stik_funcs(curr_stik_obj, true);			


			
			for(i = self.min; i<=self.max; i++){
				self.stik_parents_ob.append('<div class="stik" id="'+self.ids+i+'"/>');
				curr_stik_obj = $('#'+self.ids+i);
				curr_stik_obj.html('<img src="/images/register/page_top.png" />'+i);		
				self.setFontSize(curr_stik_obj);
				self.add_stik_funcs(curr_stik_obj);	
			}
			
			// ...
				self.stik_parents_ob.append('<div class="stik wide_stik" id="'+self.ids+'m"/>');
				curr_stik_obj = $('#'+self.ids+'m');
				curr_stik_obj.html('<div class="wide_stik_l"/><div class="wide_stik_r"/>…'+self.max_els);	
				self.setFontSize(curr_stik_obj);	
				self.add_stik_funcs(curr_stik_obj, true);			

			// →
				self.stik_parents_ob.append('<div class="stik" id="'+self.ids+'n"/>');
				curr_stik_obj = $('#'+self.ids+'n');
				curr_stik_obj.html('→');		
				self.add_stik_funcs(curr_stik_obj, true);
				
				self.checkHelpBtn();			
			
		}	
		
		$('#'+self.ids+self.current).addClass('active');
				
	}
	
	self.checkHelpBtn = function(){
		if(self.min > 1) $('#'+self.ids+'p').css('display', 'block'); else $('#'+self.ids+'p').css('display', 'none');
		if((self.max+1) < self.max_els) $('#'+self.ids+'n').css('display', 'block'); else $('#'+self.ids+'n').css('display', 'none');		
		if((self.max) < self.max_els) $('#'+self.ids+'m').css('display', 'block'); else $('#'+self.ids+'m').css('display', 'none');				
		if(self.min != 1) $('#'+self.ids+'l').css('display', 'block'); else $('#'+self.ids+'l').css('display', 'none');						
	}
	
	self.setFontSize = function(stik_obj){/*
		stik_obj_txt = stik_obj.html();
		stik_obj_txt = stik_obj_txt.length;
		if(stik_obj_txt == 1) stik_obj.css('font-size', '14px');
		else if(stik_obj_txt == 2) stik_obj.css('font-size', '14px');
		else if(stik_obj_txt == 3) stik_obj.css('font-size', '13px');
		else if(stik_obj_txt == 4) stik_obj.css('font-size', '13px');
		else if(stik_obj_txt >4) stik_obj.css('font-size', '13px');
*/	
	}

		
	
	self.add_stik_funcs = function(stik_obj, is_pages){
		stik_obj.bind({
			click: function() {
				new_page_num = $(this).attr('id');
				new_page_num = new_page_num.substr(self.ids_len);    

				if(!is_pages){
					$(this).parent('div').children('.active').removeClass('active');
					$(this).addClass('active');				
					self.current = new_page_num;
					self.callb_func.call({new_page_num:new_page_num});
				} else {
					if(new_page_num == 'n') self.ShowNextPages();
					else if(new_page_num == 'p') self.ShowPrevPages();
					else if(new_page_num == 'm') self.ShowMaxPages();
					else if(new_page_num == 'l') self.ShowMinPages();
					
				}
						   
			}
		});	
	}
	
	self.ShowMaxPages = function(){
		click_count = Math.floor((self.max_els-self.min)/(self.max - self.min+1));
		self.ShowNextPages(click_count);
	}
	
	self.ShowMinPages = function(){
		click_count = Math.floor((self.min-1)/(self.max - self.min+1));
		self.ShowPrevPages(click_count);
	}	
	
	self.ShowNextPages = function(click_count){
		el_show_count = self.max - self.min+1;
		if(click_count) el_show_count = el_show_count * click_count;		
		
			for(i = self.min; i<=self.max; i++){
				if((i+el_show_count) > self.max_els) $('#'+self.ids+i).addClass('no_disp');
					curr_stik_obj = $('#'+self.ids+i);
					curr_stik_obj.html('<img src="/images/register/page_top.png" />'+parseInt(i+el_show_count));		
					self.setFontSize(curr_stik_obj);
					curr_stik_obj.attr('id', self.ids + (el_show_count + i + 0));
			
				
			}
			self.min = self.min + el_show_count; 
			self.max = self.max + el_show_count;
			
			$(self.stik_parents+' .stik').removeClass('active');
			$('#'+self.ids+self.current).addClass('active');	
			
			self.checkHelpBtn();		
				
	}
	
	self.ShowPrevPages = function(click_count){
		el_show_count = self.max - self.min+1;
		if(click_count) el_show_count = el_show_count * click_count;				
		
			for(i = self.min; i<=self.max; i++){
				if(i >= self.max_els) curr_stik_obj.removeClass('no_disp');				
					curr_stik_obj = $('#'+self.ids+i);
					curr_stik_obj.html(i-el_show_count);		
					self.setFontSize(curr_stik_obj);
					curr_stik_obj.attr('id', self.ids + (-el_show_count + i + 0));
				
			}
			self.min = self.min - el_show_count; 
			self.max = self.max - el_show_count;
			
			$(self.stik_parents+' .stik').removeClass('active');
			$('#'+self.ids+self.current).addClass('active');	
			
			self.checkHelpBtn();		
				
	}	
	
	self.init_stiks();
	/*




*/
}	

function blockPage_msg(){
    $.blockUI({ 
    message: '<img src="/images/ajax.gif" />',
    backgroundColor: 'none',
    overlayCSS:  { 
        backgroundColor: '#FFF', 
        opacity:         0.8 
    }, 
    css: { 
        border: 'none', 
        backgroundColor: 'none'
    }}); 
 
}

/* Переключалка страниц на странице регистрации (Шаг 2) */	
	
/*	window.translation[0] = Увлечения не выбраны
	window.translation[1] = Выбрано
	window.translation[2] = из 5
	window.translation[3] = Сохранить и продолжить	
	window.translation[4] = Шаг 2: регистрация заполнена на 10%	
*/
	
	
