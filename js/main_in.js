$(document).ready(function() {
    if (jQuery.browser.safari && document.readyState != "complete"){
        setTimeout( arguments.callee, 100 );
        return;
    }

    CreateLangSelector();
    if (document.getElementById("center_top_menu")!=null) CreateProfilePage();
});

sendpost = function(functional, data, callback, error_callback) {
    $.post(document.location.href, {
        functional: functional,
        data:$.toJSON(data)
    }, function(ans) {
        ans = eval(ans);
        if($.isFunction(ans.substring) && ans.substring(0, 5)=='error'){
            $.isFunction(error_callback) && error_callback(ans.substring(6));
        } else {
            $.isFunction(callback) && callback(ans);
        }
    });
}

function popupFn() {
    var ppp = $('a.popup');
    ppp = ppp.length ? ppp : $('span.do_send_msg');
    ppp.length && ppp.click(function() {
        var popupid = $(this).attr('rel');
        $('#' + popupid).fadeIn();
        $('body').append('<div id="fade"></div>');
        $('#fade').css({
            'filter' : 'alpha(opacity=80)'
        }).fadeIn();
        var popuptopmargin = ($('#' + popupid).height() + 10) / 2;
        var popupleftmargin = ($('#' + popupid).width() + 10) / 2;
        $('#' + popupid).css({
            'margin-top' : -popuptopmargin,
            'margin-left' : -popupleftmargin
        });
    });
    var close_btn = $('.close_btn');
    close_btn.click(function() {
        $('#fade , #popuprel , #popuprel2 , #popuprel3, #popup2rel').fadeOut()
        return false;
    });
    $('.btn_cancel').children('a:eq(0)').click(function() {
        close_btn.click();
    });
    $('#delhist').click(function(){
        sendpost('message_deleteHistory', null, function() {
            close_btn.click();
            $('#b-msg-list').empty();
        });
    });
    $('#send_msg_action').unbind('click').click(function() {
        var text = $('textarea[name="message"]').val();
        if(text.length < 1){
            alert('Введите сообщение!');
            return;
        }
        sendpost('message_send_to', {
            sputnikid: $('#popup2rel').attr('sputnik_id'),
            text: text
        }, function() {
            close_btn.click();
        });
    });
}

function InitEngineTalk() {

    var sendTextPost = function(txt_id) {
        var text = $('textarea[name="message"]').val();
        if(text.length < 1){
            alert('Введите сообщение!');
            return;
        }
        sendpost('message_send', {
            text: text
        }, function(block){
            var ta_mess = $('textarea[name="message"]');
            ta_mess.val('');
            var targ = $('#b-msg-list');
            block = $(block).hide();
            targ.prepend(block).ready(function() {
                $('a.b-cls').unbind('click').click(delMsg);
            });
            block.show("slow");
        });
    }

    ////////////////////////////////////////////////////////////
    //Для отправки сообщений
    $('.btn_send').click(function(){
        sendTextPost();
    });
    var ta_mess = $('textarea[name="message"]');
    $.isFunction(ta_mess.keyboard) && ta_mess.keyboard('ctrl enter', sendTextPost);

    ////////////////////////////////////

    var delMsg = function(isadmin) {
        var iduser = $(this).attr('iduser');
        var idsputnik = $(this).attr('idsputnik');
        var idmessage = $(this).attr('idmessage');

        var t = this;
        sendpost(isadmin ? 'message_deleteAdminMessage' : 'message_deleteMessage',{
            iduser: iduser,
            idsputnik: idsputnik,
            idmessage: idmessage
        },
        function() {
            $(t).parents('.bl_msg').animate({
                opacity: 0,
                height:0
            }, 'slow');
        }
        );

        return false;
    }

    $('a.b-cls').click(delMsg);

    ///////////////////////////////////////////////////////////

    $('a.b-spam').click(function(){

        var iduser = $(this).next('.b-cls').attr('iduser');
        var idsputnik = $(this).next('.b-cls').attr('idsputnik');
        var idmessage = $(this).next('.b-cls').attr('idmessage');

        var admin_block = $(''+
            '<div class="bl_msg">'+
            '<div class="bl_msg_inner_blue">'+
            '<div class="bl-tl"></div>'+
            '<div class="bl-tr"></div>'+
            '<div class="b-msg-padd">'+
            '<div class="b-msg-padd-inner">'+
            '<h2 class="h-head"><a class="b-bluecol" href="">Администрация</a></h2>'+
            '<p>Подтвердите, что данное сообщение является спамом: <a class="b-spam" style="cursor:pointer;">это спам</a>, <a class="b-spam-cls" href="#">удалить сообщение</a>, <a class="b-restore" href="#">восстановить сообщение</a></p>'+
            '</div>'+
            '</div>'+
            '<div class="bl-bl"></div>'+
            '<div class="bl-br"></div>'+
            '</div>'+
            '<div class="cl"></div>'+
            '</div>'+
            '');

        $(admin_block).css('opacity','0');

        var spm = $(admin_block).find('.b-spam-cls');
        $(spm).attr('iduser', iduser);
        $(spm).attr('idsputnik', idsputnik);
        $(spm).attr('idmessage', idmessage);

        $(admin_block).find('.b-restore').click(function(){
            $(this).parents('.bl_msg').prev('.bl_msg').show('fast');
            $(this).parents('.bl_msg').remove();
            return false;
        });
        $(spm).click(function(){

            var iduser = $(this).attr('iduser');
            var idsputnik = $(this).attr('idsputnik');
            var idmessage = $(this).attr('idmessage');

            var t = this;
            sendpost('message_deleteMessage',{
                iduser: iduser,
                idsputnik: idsputnik,
                idmessage: idmessage
            },
            function() {
                $(t).parents('.bl_msg').prev('.bl_msg').animate({
                    opacity: 0,
                    height:0
                }, 'slow');
                $(t).parents('.bl_msg').remove();
            }
            );

            return false;
        });

        $(admin_block).find('.b-spam').click(function(){
            //это для кнопки Спам

            var t = this;
            sendpost('message_spam',{
                iduser: iduser,
                idsputnik: idsputnik,
                idmessage: idmessage
            },
            function() {
                $(t).parents('.bl_msg').prev('.bl_msg').animate({
                    opacity: 0,
                    height:0
                }, 'slow');
                $(t).parents('.bl_msg').remove();
            }
            );


            return false;
        });


        var obj = $(this).parents('.bl_msg');

        obj.hide('fast');
        obj.after(admin_block);
        var obj_adm = obj.next();
        obj_adm.animate({
            opacity: 1
        }, 'fast');

        return false;
    });

    popupFn();

}


/* Включение строки выбора языка */
function CreateLangSelector(){
    var hide_lang_timer;

    $('.lang_active, .lang_flag').bind({
        click: function() {
            $('.lang_menu').fadeIn(500);
        },
        mouseover: function() {
            SetHideTimer();
        },
        mouseout: function() {
            StopHideTimer(1000);
        }
    });

    $('.lang_menu').bind({
        mouseover: function() {
            SetHideTimer();
        },
        mouseout: function() {
            StopHideTimer(1000);
        }
    });

    function SetHideTimer(){
        clearTimeout(hide_lang_timer);
    }
    function StopHideTimer(time_out){
        hide_lang_timer = setTimeout("$('.lang_menu').fadeOut(500);", time_out);
    }

}

function Set_icon_buttons(){
	$('#top_btn1').bind({  click: function() {    
		document.location = '/profile';
	}});

	$('#top_btn2').bind({  click: function() {    
		document.location = '/profile/#spt_intrme';
	}});
	
	
	$('#top_btn3').bind({  click: function() {    
		document.location = '/actions';
	}});
	
	$('#top_btn4, #edit_user_name').bind({  click: function() {    
		document.location = '/account';
	}});

	$('#user_complete_help, #user_complete_help_block .close').bind({  click: function() {   
		if($('#user_complete_help_block').hasClass('show')){
			$('#user_complete_help_block').fadeOut().removeClass('show');
		} else {
			$('#user_complete_help_block').fadeIn().addClass('show');		
		}
		
	}});
	

}

/* Внутренний раздел */
function CreateProfilePage(){
	var $center_block = $('#center_block');
	Set_icon_buttons();
    //Страница спутника
    if($center_block.hasClass('center_sputnik_block')){
        window.top_profile_menu = new SetTopProfileMenu('sputnik_centerblock', '#center_top_menu', document.location.pathname, '#center_block', '#sputkin_r_menu');
        window.top_profile_menu.CallAfterLoad = function(){
            if(arguments.callee.caller.menu_link == 'ct_sput_comp'){
                new_percent = $('#show_top_percent_compare').html();
                $('#big_hell_comporator .plus_top').html(new_percent);
                LoadCompareFunctions();
            }
            if(arguments.callee.caller.menu_link == 'ct_sput_photo'){
                window.myphoto = new Sputnikalbums();
                window.myphoto.initStart();
            } else if(arguments.callee.caller.menu_link == 'ct_sput_page'){
                window.myphoto = new SputnikSomePhoto();
                window.myphoto.initStart();
            } else if(arguments.callee.caller.menu_link == 'ct_sput_talk'){
                InitEngineTalk();
                $('.form_mes textarea').limit('1000','.form_mes .b-time .num');
                $('#step_to').unbind('click').click(function() {
                    $('#ct_sput_dates').click();
                });
            }

            ActivateWanaBeTogether();
            
            
        }
        CreateleftSonic();
        CreateCheckBox();
        SetMainLeftMenu();
        SetMainRightMenu();
        ActivateWanaBeTogether();
        if($('#ct_sput_talk').attr('class')=='active'){
            InitEngineTalk();
            $('.form_mes textarea').limit('1000','.form_mes .b-time .num');
            $('#step_to').click(function() {
                $('#ct_sput_dates').click();
            });
        } else {
            window.myphoto = new SputnikSomePhoto();
            window.myphoto.initStart();
        }
        
        if(document.location.hash == '#sb_sput_comp'){
        	$('#sb_sput_comp').click();
        	window.scroll(0,0);
        };
		
		$('#user_menu1').after('<div class="menu_line sputs_profile active"><i class="ico"></i><span>Профиль спутника</span></div>');
		$('#user_menu1').removeClass('active');
		
    }
    if($center_block.hasClass('center_myfvorits_block')){
    	$('#top_btn1').addClass('active');
        //Страница со спутниками в профиле пользователя
        window.top_profile_menu = new SetTopProfileMenu('profile_centerblock', '#center_top_menu', '/profile', '#center_block','#left_block .user_menu');
        window.top_profile_menu.CallAfterLoad = function(){
            ActivateVizitkaControls();
        }
        CreateleftSonic();
        ActivateControls();
        ActivateVizitkaControls();
        SetMainLeftMenu();
        $('#user_menu1').addClass('active');
        
        if(document.location.hash == '#spt_intrme'){
        	$('#spt_intrme').click();
        	window.scroll(0,0);
        	$('#top_btn1').removeClass('active');
        	$('#top_btn2').addClass('active');        	
        };        
    }
    if($center_block.hasClass('center_account_block')){
        //Страница пользователя
        window.top_profile_menu = new SetTopProfileMenu('account_centerblock', '#center_top_menu', '/account');
        window.top_profile_menu.CallAfterLoad = function(){
            ActivateControls();
            SaveOptionsWork();
            if(arguments.callee.caller.menu_link == 'ct_help'){
                CreateHelpPage();
            }
        }
        CreateleftSonic();
        ActivateControls();
        SaveOptionsWork();
        SetMainLeftMenu();
        if($('#ct_help').attr('class')=='active'){
            CreateHelpPage();
        }
        
        $('#top_btn4').addClass('active');
    }
    if($center_block.hasClass('center_aboutme_block')){
        //Страница пользователя
        window.top_profile_menu = new SetTopProfileMenu('aboutme_centerblock', '#center_top_menu', '/aboutme');
        window.top_profile_menu.CallAfterLoad = function(){
            if(arguments.callee.caller.menu_link == 'ct_myphotos'){
                window.myphoto = new Photoalbums();
                window.myphoto.initStart();
            }
            if(arguments.callee.caller.menu_link == 'ct_aboutme'){
                window.myphoto = new MySomePhoto();
                window.myphoto.initStart();
            }

        }
        CreateleftSonic();
        ActivateControls();
        SetMainLeftMenu();
        window.myphoto = new MySomePhoto();
        window.myphoto.initStart();
    }
    if($center_block.hasClass('center_nic1_mode')){
        //Страница NIC
        window.top_profile_menu = new SetTopProfileMenu('nic_centerblock', '#center_top_menu', '/nic');
        window.top_profile_menu.CallAfterLoad = function(){
            if(arguments.callee.caller.menu_link == 'ct_nic1'){
                ActivateControls();
                SaveOptionsWork('/nic', 'nic_save_answers');
            }

            if(arguments.callee.caller.menu_link == 'ct_nic2'){
                GenerateNicPage2();
            }

            if(arguments.callee.caller.menu_link == 'ct_nic3'){
                $('#start_nic_test').bind({
                    click: function() {

                        blockPage_msg();
                        $.post('/nic', {
                            functional: 'get_nictest_test',
                            ahah: 'true'
                        },
                        function(data) {
                            if(data){
                                $('#sub_nic_page_in').html(data);
                                GenerateNicPage3();
                                $.unblockUI();
                            } else {
                                alert('Internal error #94201. Please, contact administrator.');
                            }
                        }
                        );

                    }
                });
            }

            if(arguments.callee.caller.menu_link == 'ct_nic4'){
                window.top_profile_menu = new SetTopProfileMenu('get_nictest_result', '#sub_nic_menu', '/nic', '#sub_nic_page_in');


            }
        }
        CreateleftSonic();
        ActivateControls();
        SaveOptionsWork('/nic', 'nic_save_answers');
        SetMainLeftMenu();

    }

    if($center_block.hasClass('center_actions_block')){
    	$('#top_btn3').addClass('active');
        //Страница пользователя
        window.top_profile_menu = new SetTopProfileMenu('actions_centerblock', '#center_top_menu', '/actions');
        window.top_profile_menu.CallAfterLoad = function(){
            if(arguments.callee.caller.menu_link == 'ct_contacts'){
                InitEngineTalk();
                $('.b-block').unbind('click').click(function() {
                    document.location.href = $(this).attr('link');
                });
            }
            if(arguments.callee.caller.menu_link == 'ct_admin'){
                InitEngineTalk();
            }
        }
        CreateleftSonic();
        ActivateControls();
        SetMainLeftMenu();
        InitEngineTalk();

        if($('#ct_contacts').attr('class')=='active'){
            $('.b-block').click(function() {
                document.location.href = $(this).attr('link');
            });
        }
    }
    
        
    
    if($center_block.hasClass('center_search_mode')){
    	 window.top_profile_menu = new SetTopProfileMenu('search_centerblock', '#center_top_menu', '/search');
    	 window.top_profile_menu.CallAfterLoad = function(){
    	 	ActivateSearchCombos();		
    	 	JustText();    	     	 
    	 	BindSearchButton();
    	 	
    	 	if(arguments.callee.caller.menu_link == 'ct_search2'){
				$('.reg3_pers_block_name').bind({  click: function() {  ToggleBlockFlap($(this).parent());  }});
				CreateCheckBox('#search_params .p_checkbox');
				InitClicks();
    	 	}
    	 }
    	 
   	 	ActivateSearchCombos();		
   	 	JustText();    	     	 
   	 	BindSearchButton();
    	     	     	
        CreateleftSonic();
        ActivateControls();
        SetMainLeftMenu();
        
		function ToggleBlockFlap(jq_block){
			if(jq_block.hasClass('active')){
				jq_block.removeClass('active');
				jq_block.animate({height: "17px"}, { duration: 500, queue: false });
				jq_block.children('.reg3_pers_block_name').children('span').html('+');			
			} else {
				var new_h = jq_block.children('.reg3_pers_block_in').height() + 22;
				jq_block.addClass('active');
				jq_block.animate({height: new_h+"px"}, { duration: 500, queue: false });
				jq_block.children('.reg3_pers_block_name').children('span').html('-');
			}
		}      
		
		function OpenBlockFlap(jq_block){
				var new_h = jq_block.children('.reg3_pers_block_in').height() + 22;
				jq_block.addClass('active');
				jq_block.animate({height: new_h+"px"}, { duration: 500, queue: false });
				jq_block.children('.reg3_pers_block_name').children('span').html('-');				
		}		
		
		function InitClicks(){
			//Работа галочек
			$('#search_params').find('.p_checkbox').bind({   click: function() { 		
				var parent_in = $(this).parent().parent().parent('.reg3_pers_block');//.parent('.reg3_pers_block');		
				if(parent_in.find('.active').length){
					parent_in.addClass('complete');
					OpenBlockFlap(parent_in.next());
				} else {
					parent_in.removeClass('complete');			
				}
			}});
			
		}		  
		    
    }

	function BindSearchButton(){
    	 $('#start_search').bind({  click: function() {  
				var send_functional = "search_fast";
				if(document.getElementById('search_params')!=null){
					send_functional = 'search_full';	
				}
		    	blockPage_msg();  
				$.post("/search", { functional: send_functional, data: CollectSearchData(), ahah: true  },
	            function(data) {
	                if(data){
	                    $('#search_results').html(data);
	                    $.unblockUI();
	                } else {
	                    alert('Internal error #725128. Please, contact administrator.');
	                }
	            }
	            );
	    
	    	 
	    }});	
	}
    
	function JustText(){
		$('input.just_text').each( function() { 
			SetNumsOnly($(this));
		});
	
	}
    
	function SetNumsOnly($obj_name){
		$obj_name.keydown(function(event) { 
			
			if ( event.keyCode == 46 || event.keyCode == 8 ) { 
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
	
	function CollectSearchData(){
		var $search_form = $('#search_form');
		var collected = {};

		collected['cheks'] = {};
		collected['inputs'] = {};
		
		$search_form.find(".one_line .p_checkbox.active").each( function() { 
			check_name = $(this).attr('id');
			collected['cheks'][check_name] = 'true';				
		});

		$search_form.find('input').each( function() { 
			input_name = $(this).attr('name');
			collected['inputs'][input_name] = $(this).val();				
		});	
		
		if(document.getElementById('search_params')!=null){
			collected['find_params'] = {};
			$(".reg3_pers_block.complete").each( function() { 
				block_name = $(this).attr('id');
				collected['find_params'][block_name] = {};
				
				$(this).find('.active').each( function() { 
					collected['find_params'][block_name][$(this).attr('id')] = 'true';
				});
	
	
			});			
		}
		
		return collected;
	}
	
	   
    function ActivateSearchCombos(){
		window.ajaxCombo_2 = new ajaxCombo("#find_country","{ functional: 'get_arials', data: { arial_class: 'country', conditions: { str: self.combo_input.val()}} }" , "country");
		window.ajaxCombo_1 = new ajaxCombo("#find_area",
		 "{ functional: 'get_arials', data: { arial_class: 'region', conditions: { str: self.combo_input.val(), country_id: window.ajaxCombo_2.currentValueId}} }", "region");    
		 
		window.ajaxCombo_3 = new ajaxCombo("#find_city",
		 "{ functional: 'get_arials', data: { arial_class: 'city', conditions: { str: self.combo_input.val(), region_id: window.ajaxCombo_1.currentValueId,  country_id: window.ajaxCombo_2.currentValueId}} }",
		  "city");    
    
    }




    // Включение функий при загрузке блока сравнения на странице спутника
    function LoadCompareFunctions(){
        window.compare_menu = new SetTopProfileMenu('compare_centerblock', '#compare_menu', document.location.pathname, '#compare_load');
        window.compare_menu.CallAfterLoad = function(){
            new_percent = $('#show_top_percent_compare').html();
            $('#big_hell_comporator .plus_top').html(new_percent);
            $('#big_hell_comporator').attr('class', 'active'+arguments.callee.caller.menu_link.substr(13));
            if(arguments.callee.caller.menu_link == 'compare_mode_2') ActivateComparePage2(document.location.pathname);
            ActivateWanaBeTogether();
        }
    }

}

// Генерация страницы NIC System, третья вкладка «Характер»
function GenerateNicPage3(){
    var thr_pages_count = 5;
    var thr_active = 1;
    var active_quest = 1;
    var quest_counts = [0];
    var go_next_btn = $('#next_thr_block');

    function Initiate(){
        ActivateThrPage(1);
        $(".thr_page_block").each( function() {
            var last_ques = $(this).find('.thr_block_in:last');
            quest_counts.push(parseInt(last_ques.attr('id').substr(13)));
        });

        // Включение перематывалок
        $(".q_marks").each( function() {
            var tmp_mark = new qMarkControl($(this));
        });
        //Включение  слайдеров
        $(".range_track").slider({
            range: "min",
            value: 1,
            min: 1,
            max: 100,
            slide: function( event, ui ) {
                $(this).parent('.q_track').parent('.q_track_line').parent('.q_tracks').parent('.nic_question').addClass('completed');
                CheckQuestBlockComplete();
            }
        });
        //Включение ограничителя количества галочек CheckQuestBlockComplete
        createChecksLimit();

        go_next_btn.bind({
            click: function() {
                if($(this).hasClass('active')){

                    if(quest_counts[thr_active] >= (1+active_quest)) {
                        ActivateThrPage_in(1+active_quest);
                        AnimateShowButton();
                    } else {
                        if(thr_pages_count >= (1+thr_active)) {
                            ActivateThrPage(1+thr_active);
                            AnimateShowButton();
                        } else {
                            //	console.log(CollectData());

                            blockPage_msg();
                            $.post("/nic", {
                                functional: "save_nictest_answers",
                                ahah: "true",
                                data: CollectData()
                            },
                            function(data) {
                                if(data){
                                    $('#sub_nic_page_in').html(data);
                                    $.unblockUI();
                                } else {
                                    alert('Error #63962');
                                }
                            }
                            );

                        }
                    }

                }


            }
        });
    }


    function ActivateThrPage(page_number){
        thr_active = page_number;
        $('.thr_page_block.active').removeClass('active');
        $('#thr_page_'+page_number).addClass('active');
        ActivateThrPage_in(1);
    //	console.log('PAGE'+thr_active);
    }

    function ActivateThrPage_in(page_number_in){
        active_quest = page_number_in;
        $('#thr_page_'+thr_active+' .thr_block_in.active').removeClass('active');
        $('#thr_page_'+thr_active+'_q_'+page_number_in).addClass('active');
    //	console.log('QUES'+active_quest);
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

        return collected;
    }

    function createChecksLimit(){

        $('.p_checkbox').bind({
            click: function() {
                q_checks_obj = $(this).parent('.q_checks');
                q_check_count = q_checks_obj.children('.active').length;
                if(q_check_count < 3){
                    $(this).toggleClass('active');
                } else {
                    if($(this).hasClass('active')) $(this).removeClass('active');
                }
                q_check_count = q_checks_obj.children('.active').length;
                if(q_check_count == 3){
                    q_checks_obj.parent('.nic_question').addClass('completed');
                    CheckQuestBlockComplete();
                } else {
                    q_checks_obj.parent('.nic_question').removeClass('completed');
                    CheckQuestBlockComplete();
                }
            //	CheckQuestBlockComplete();
            }
        });

    }

    function AnimateShowButton(){
        go_next_btn.animate({
            left: "565px"
        }, {
            duration: 500,
            queue: false,
            complete: function(){
                go_next_btn.css({
                    'display' : 'none',
                    'left' : '-300px'
                }).removeClass('active').css('display','block');
                go_next_btn.animate({
                    left: "265px"
                }, {
                    duration: 500,
                    queue: false
                });
            }
        });
    }

    function ShowNextButton(show_or_not){
        if(show_or_not == true){
            go_next_btn.addClass('active');
        } else {
            go_next_btn.removeClass('active');
        }
    }

    // Проверка заполненности текущего блока
    function CheckQuestBlockComplete(){
        if($('#thr_page_'+thr_active+'_q_'+active_quest).children('.nic_question').hasClass('completed')){
            ShowNextButton(true);
        } else {
            ShowNextButton(false);
        }

    }


    // Элемент управления qMarkControl
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
            self.right_btns.bind({
                click: function() {
                    self.MarkMinus($(this));
                }
            });
            self.left_btns.bind({
                click: function() {
                    self.MarkPlus($(this));
                }
            });
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


    Initiate();

}

// Генерация страницы NIC System, вторая вкладка
function GenerateNicPage2(){
    // Массив вариантов для тем
    // Увлечения в темах вида {i_like_sport : 'Спорт', i_like_sweem : 'Плавание'}
    var reg_step1_variants = window.reg_step1_variants;
    var selected_theme = 0;
    var save_button = $('.rs1_box.rs1_box1.rs1_new_box .rs1_save');
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

    $('#center_block .compare2_table .one_line_in .show_more').bind({
        click: function() {
            UpdateCheckForm((selected_theme = $(this).parent('.one_line_in').attr('id').substr(11)));
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
        var new_var_list = '';
        var is_checked = '';
        for(var name in reg_step1_variants[form_num]){
            is_checked = '';
            if(reg_step1_variants[form_num][name].checked == true) is_checked = ' active'
            new_var_list += '<div class="p_checkbox'+is_checked+'" id="'+name+'">'+reg_step1_variants[form_num][name].text+'</div>';
        }
        var_list.html(new_var_list).removeClass().addClass('form_num_'+form_num);
        CreateCheckBox();
        CheckActiveSels();
    }

    function CreateCheckBox(){
        $('.p_checkbox').bind({
            click: function() {
                if(GetActiveSelsCount() < 5) $(this).toggleClass('active');
                else $(this).removeClass('active');
                CheckActiveSels();
                form_num = var_list.attr('class').substr(9);
                check_num = $(this).attr('id');
                if($(this).hasClass('active')){
                    reg_step1_variants[form_num][check_num].checked = true;
                } else {
                    reg_step1_variants[form_num][check_num].checked = false;
                }
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
        var new_li_list = '';
        $("#rs1_var_list .active").each( function() {
            current_active++;
            current_select_data += $(this).attr('id')+';';
            new_li_list += '<li>'+$(this).html()+'</li>';
        });
        $.unblockUI();
        if(current_active > 0) {
            $.post("/nic", {
                functional: "nic_save_card",
                data: {
                    card_name: selected_theme,
                    selected: current_select_data,
                    ahah: 'true'
                }
            },
            function(data) {
                if(data){
                    var current_card = $('#card_rs_img'+selected_theme);
                    var click_line = current_card.children('.show_more');
                    var decr_ul = current_card.children('.descr').children('ul');
                    decr_ul.html(new_li_list);
                    try{
                        data = $.evalJSON(data);
                        if(data.substr(0,4) == 'txt_'){
                            click_line.html(data.substring(4)).addClass('saved');
                            setTimeout(function(){
                                click_line.html('Редактировать').removeClass('saved');
                            }, 2700);
                        } else if(data.substr(0,4) == 'msg_'){
                            blockPage_msg(data.substring(4));
                            setTimeout(function(){
                                $.unblockUI();
                            }, 2000);
                        }
                    } catch(e){
                        alert('Internal error #7722. Please, contact administrator.');
                    }

                } else {
                    alert('Internal error #7723. Please, contact administrator.');
                }
            }
            );
        }
    }

}

/*
Веключение нижнего блока управления взаимоотношениями пользователей
 */
function ActivateWanaBeTogether(){
    user_id = Get_id_OnUserPage();
    var waba_block = $('#wana_be_together');
    if (document.getElementById("wana_be_together")!=null){
        waba_block.children('.rs1_together_yes').bind({
            click: function() {
                SendControlData('interes', user_id);
                waba_block.fadeOut();
            }
        });
        waba_block.children('.rs1_together_mb').bind({
            click: function() {
                SendControlData('saved', user_id);
                waba_block.fadeOut();
            }
        });
        waba_block.children('.rs1_together_no').bind({
            click: function() {
                SendControlData('nosearch', user_id);
                $(this).fadeOut();
            }
        });
    }
}

/*
Получение ID пользователя на странице этого пользователя
 */
function Get_id_OnUserPage(){
    return $('#right_block .other_user_right').attr('id').substr(13);
}

/*
Управление взаимоотношениями пользователя
mode — send_data.as
user_id - id пользователя
reload_sputniks — обновлять ли блок страницы спутников. Актуально только для страницы спутников в профиле пользователя!

functional: 'save_user',
data: {as: <'saved' | 'interes' | 'ignor' | 'nosearch' | 'delete'>, user_id: <id сохраняемого пользователя>}
saved - в сохраненные
interes - в интересные
ignor - в игнорируемые
nosearch - больше не искать
delete - удаление взаимоотношений с пользователем


Да, я заинтересовался! interes
Решу позже saved
Нет, не заинтересовался nosearch

interes
ignor
 */
function SendControlData(mode, user_id, reload_sputniks){
    var send_data = {};
    var reload_sputniks = reload_sputniks || false;
    send_data.as = mode;
    send_data.user_id = user_id;

    if($('#center_block').hasClass('center_myfvorits_block')){
        send_data.table = $('#center_top_menu ul li.active').attr('id');
    }

    $.post("/profile", {
        functional: "save_user",
        data: send_data,
        ahah: 'true'
    },
    function(data) {
        do_not_unblock = false;
        UpdateInterstCounts();
        if(data.substring(0,10) == 'show_text_'){
            blockPage_msg(data.substr(10));
            setTimeout(function(){
                $.unblockUI();
            }, 2000);
            do_not_unblock = true;
        }
        if(reload_sputniks == true){
            $('#one_profile_user_'+user_id).fadeOut();
            select_page = 1;
            if($('.page_selector .stik.active').length) select_page = $('.page_selector .stik.active').attr('id').substr(8);
            ReloadSputniksPage(true, select_page, do_not_unblock);
        }

    /*	try{
	    	data = $.evalJSON(data);

		} catch(e){
            alert('Internal error #5422. Please, contact administrator.');
		}
         */
    }
    );
}



/*
	Включение меню в левой части страницы
 */
function SetMainLeftMenu(){
    var left_menu = $('#left_block .user_menu');
    left_menu.children('.menu_line').bind({
        click: function() {
            menu_id = $(this).attr('id');
            if(menu_id.substr(0,2) != 'sb'){
                left_menu.find('.active').removeClass('active');
                $(this).addClass('active');
                if(menu_id == 'user_menu1'){
                    document.location = '/profile';
                } else if(menu_id == 'user_menu2'){
                    document.location = '/actions';
                } else if(menu_id == 'user_menu3'){
                    document.location = '/nic';
                } else if(menu_id == 'user_menu4'){
                    document.location = '/aboutme';
                } else if(menu_id == 'user_menu5'){
                    //document.location = '/search';
                } else if(menu_id == 'user_menu6'){
                    alert('Страница «Управление счетом»');
                }
            }

        }
    });

}

/*
	Включение меню в правой части (страница спутника) — за исключением синхронизируемых пунктов
 */
function SetMainRightMenu(){
    var right_menu = $('#sputkin_r_menu');
    var current_sputnik_id = Get_id_OnUserPage();
    right_menu.children('.menu_line').bind({
        click: function() {
            menu_id = $(this).attr('id');
            if(menu_id.substr(0,2) != 'sb'){
                if(menu_id == 'user_menu8'){
                    alert('Страница «Подарить подарок»');
                    right_menu.find('.active').removeClass('active');
                    $(this).addClass('active');
                } else if(menu_id == 'user_menu9'){
                    SendControlData('interes',current_sputnik_id);
                    if (document.getElementById("wana_be_together")!=null) $('#wana_be_together').fadeOut();
                    $(this).fadeOut();
                } else if(menu_id == 'user_menu10'){
                    SendControlData('ignor',current_sputnik_id);
                    if (document.getElementById("wana_be_together")!=null) $('#wana_be_together').fadeOut();
                    $('#user_menu9').fadeOut();
                }
            }

        }
    });

}



/*
	Включение верхнего меню
	functional_type — выбор механизма обработки данных на сервере
	menu_block_id — идентефикатор активируемого меню
	functional_url — адрес отправки данных
	load_to_block — идентефикатор блока, в который загружаются данные
	sync_menu — синхронизируемое меню
	orig_prefix — префикс иденефикаторов пунктов основного меню, 2 символа
	sync_prefix — префикс иденефикаторов пунктов синхронизируемого меню (второго), 2 символа
 */
function SetTopProfileMenu(functional_type, menu_block_id, functional_url, load_to_block, sync_menu, orig_prefix, sync_prefix){
    var self = this;
    self.menu_block_id = menu_block_id || '#center_top_menu';
    self.functional_type = functional_type || 'account_centerblock';
    self.functional_url = functional_url || '/account';
    self.load_to_block = load_to_block || '#center_block';
    self.sync_menu = sync_menu || false;
    self.sync_prefix = sync_prefix || 'sb';
    self.orig_prefix = orig_prefix || 'ct';

    $(self.menu_block_id+' li').bind({
        click: function() {
            $(self.menu_block_id+' .active').removeClass('active');
            $(this).addClass('active');
            change_menu_id = $(this).attr('id');
            self.ChangePageFromeMenu(change_menu_id);

            if(self.sync_menu != false){
                if (document.getElementById(self.sync_prefix+'_'+change_menu_id.substr(3))!=null){
                    $(self.sync_menu+' .active').removeClass('active');
                    $('#'+self.sync_prefix+'_'+change_menu_id.substr(3)).addClass('active');

                }
            }
        }
    });

    if(self.sync_menu != false){
        $(self.sync_menu+' .menu_line').bind({
            click: function() {
                sync_id = $(this).attr('id');
                if(sync_id.substr(0,2) == self.sync_prefix){
                    $(self.sync_menu+' .active').removeClass('active');
                    $('#'+self.orig_prefix+'_'+sync_id.substr(3)).click();
                    $(this).addClass('active');
                }

            //	self.ChangePageFromeMenu($(this).attr('id'));
            }
        });
    }

    self.ChangePageFromeMenu = function(req_menu){
        blockPage_msg();
        $.post(self.functional_url, {
            functional: self.functional_type,
            data: req_menu,
            ahah: 'true'
        },
        function(data) {
            arguments.callee.menu_link = req_menu;
            if(data){
                $(self.load_to_block).html(data);
                self.CallAfterLoad();
                $.unblockUI();
            } else {
                alert('Internal error #5421. Please, contact administrator.');
            }
        }
        );
    }

    self.CallAfterLoad = function(){

    }

}

/*
	Активация элементов управления на странице со списком спутников текущего пользователя
 */
function ActivateVizitkaControls(full_activate){
    var full_activate = full_activate || 'yes';

    if(full_activate == 'yes'){

        // Включение стикеров выбора страницы
        var all_pages_count = $('#center_block .page_selector .pages_stiks').attr('id');
        if(all_pages_count){
            all_pages_count = all_pages_count.substring(9);
            current_active_page = 1;
            if (document.getElementById("current_page")!=null) current_active_page = $('#current_page').attr('class').substr(13);
            window.page_stikers = new StickersGroup('.pages_stiks', 1, current_active_page, all_pages_count, all_pages_count, 'viz_page', ReloadSputniksPage);
        }
    }

    $(".one_last_profile").each( function() {
        var this_profile = $(this);
        var this_user_id = this_profile.attr('id').substr(17);
        var this_user_url = parseInt(this_user_id)+1000000;
        this_user_url = (this_user_url+'').substr(1);

        $('.data .name, .photo .photo_in',this_profile).bind({
            click: function() {
                document.location = '/id'+this_user_url;
            }
        });
        $('.do_count',this_profile).bind({
            click: function() {
                document.location = '/id'+this_user_url+'#sb_sput_comp';
            }
        });
        $('.do_send_msg',this_profile).bind({
            click: function() {
                var id = this_user_id;
                $('#popup2rel').attr({
                    sputnik_id: id
                });
                $('#popup2rel .poptitle').children('span:eq(0)').html($('.data .name',this_profile).html());
            }
        });
        $('.do_save, .do_add_favor, .do_delete, .do_nosearch',this_profile).bind({
            click: function() {
                if($(this).hasClass('do_save')) send_mode = 'saved';
                else if($(this).hasClass('do_add_favor')) send_mode = 'interes';
                else if($(this).hasClass('do_delete')) send_mode = 'delete';
                else if($(this).hasClass('do_nosearch')) send_mode = 'nosearch';


                SendControlData(send_mode,this_user_id, true);
            }
        });
    });

    popupFn();
    $('#popup2rel textarea').limit('1000','#popup2rel .b-time .num');

}

/*
Обновлениче счетчиков «Новые спутники» и «Заинтересовались мной»
 */
function UpdateInterstCounts(){
    $.post('/profile', {
        functional: 'get_user_count',
        ahah: 'true'
    },
    function(data) {
        if(data){
            var split_arr = data.split(',');

            if(split_arr[0] != 0){
                if (document.getElementById("spt_new")!=null) $('#spt_new span').html('('+split_arr[0]+')').fadeIn();
                $('#user_menu1 .count_old, #top_btn1 .count span').html('<i></i>'+split_arr[0]).fadeIn();
            } else {
                $('#user_menu1 .count_old, #top_btn1 .count span').fadeOut();
                $('#spt_new span').fadeOut();
            }

            if(split_arr[1] != 0){
                if (document.getElementById("spt_new")!=null) $('#spt_intrme span').html('('+split_arr[1]+')').fadeIn();
                $('#user_menu1 .count_new, #top_btn2 .count span').html('<i></i>'+split_arr[1]).fadeIn();
            } else {
                $('#user_menu1 .count_new, #top_btn2 .count span').fadeOut();
                $('#spt_intrme span').fadeOut();
            }



        } else {
            alert('Internal error #6666. Please, contact administrator.');
        }
    }
    );

    if((right_favor = $('#right_block .right_favor')).length){
        $.post('/profile', {
            functional: 'get_interes_block',
            ahah: 'true'
        },
        function(data) {
            if(data){
                right_favor.html(data);
            } else {
                alert('Internal error #6667. Please, contact administrator.');
            }
        }
        );

    }

}

/*
	Перезагрузка страницы отношений пользователей
	//profile_centerblock
	//profile_usercards
 */
function ReloadSputniksPage(full_reload, load_page, do_not_unblock){
    var send_data = {};
    var load_page = load_page || 1;
    var do_not_unblock = do_not_unblock || false;
    var full_reload = full_reload || false;
    var send_functional = (full_reload == true ? 'profile_centerblock' : 'profile_usercards' );
    var load_to_block = (full_reload == true ? '#center_block' : '#one_last_profiles' );
    if(this.new_page_num != null) load_page = this.new_page_num;

    if(do_not_unblock == false) blockPage_msg();
    send_data.type = $('#center_top_menu .active').attr('id');
    send_data.page = load_page;
    $.post('/profile', {
        functional: send_functional,
        data: send_data,
        ahah: 'true'
    },
    function(data) {
        if(data){
            $(load_to_block).html(data);
            if(full_reload == true)  ActivateVizitkaControls('yes'); else ActivateVizitkaControls('no');
            if(do_not_unblock == false) $.unblockUI();
        } else {
            alert('Internal error #6421. Please, contact administrator.');
        }
    }
    );
}









// Расширитель функций и классов
function extend(Child, Parent) {
    var F = function() { }
    F.prototype = Parent.prototype
    Child.prototype = new F()
    Child.prototype.constructor = Child
    Child.superclass = Parent.prototype
}


// Активация второй страницы сравнения профилей — сранвние «Увлечения»
function ActivateComparePage2(functional_url){
    var functional_type = 'compare_usercard';
    var send_id = -1;

    $('#compare2_list .rs1_img, .compare2_table .one_line .one_line_in .show_more').bind({
        click: function() {
            if($(this).hasClass('rs1_img')){
                send_id = $(this).attr('id').substr(6);
            } else {
                send_id = $(this).parent('.one_line_in').attr('id').substr(11);
            }

            if(!$(this).hasClass('bw')){

                blockPage_msg();
                $.post(functional_url, {
                    functional: functional_type,
                    data: send_id,
                    ahah: 'true'
                },
                function(data) {
                    if(data){
                        $('#compare_load').html(data);
                        $.unblockUI();
                    } else {
                        alert('Internal error #5422. Please, contact administrator.');
                    }
                }
                );

            }



        }
    });


}

// Активация компонентов и кнопок на странице аккаунта
function ActivateControls(){
    SetFlipBlocksWork();
    CreateCheckBox();
    $("#center_block .flap_block .option_line .in_combo").each( function() {
        window.tmp_combo = new easyCombo('#'+$(this).attr('id'));
    });
}



// Включение разворачивающихся центральных блоков
function SetFlipBlocksWork(){
    $(".flap_block").each( function() {
        $(this).children('.p_title_1').bind({
            click: function() {
                ToggleBlockFlap($(this).parent('.flap_block'));
            }
        });
    });

    function ToggleBlockFlap(jq_block){


        jq_obj = jq_block;
        jq_flap = jq_obj.children('.flap_block_in');

        if(jq_obj.hasClass('opened')){
            jq_obj.removeClass('opened').addClass('closed');
            jq_obj.animate({
                height: "17px"
            }, {
                duration: 500,
                queue: false,
                complete: function(){

                }
            });

        } else if(jq_obj.hasClass('closed')){
            new_h = jq_flap.height() + 35;
            jq_obj.animate({
                height: new_h
            }, {
                duration: 500,
                queue: false,
                complete: function(){
                    jq_obj.removeClass('closed').addClass('opened');
                }
            });

        }


    }
}


function SaveOptionsWork(save_link, save_func){
    var save_link = save_link || '/account';
    var save_func = save_func || 'account_save_answers';

    $('.save_block_changes span').bind({
        click: function() {
            var this_flap = $(this).parent('.save_block_changes').parent('.flap_block_in').parent('.flap_block');
            var block_name = this_flap.attr('id');
            var collected = {};
            collected[block_name] = {};

            this_flap.find('.text_input').each( function() {
                collected[block_name][$(this).attr('id')] = $(this).attr('value');
            });

            this_flap.find('.in_combo').each( function() {
                collected[block_name][$(this).attr('id')] = $(this).attr('id') + '_' + $(this).find('.easy_mask input').attr('value');
            });

            this_flap.find('.p_checkbox.active').each( function() {
                collected[block_name][$(this).attr('id')] = 'true';
            });

            SendCollection(collected, $(this), save_link, save_func);

            if($('#center_block').hasClass('center_nic1_mode')){
                will_text = this_flap.find('.radio_group .p_checkbox.active').html();
                if(will_text.length > 30) will_text = will_text.substr(0, 30) + '...';
                this_flap.find('.p_title_add').html(will_text);
            }

        }
    });

    function SendCollection(collected, click_line, save_link, save_func){
        var save_link = save_link || '/account';
        var save_func = save_func || 'account_save_answers';

        $.post(save_link, {
            functional: save_func,
            data: collected
        },
        function(data) {

            try{
                data = $.evalJSON(data);
                if(data.substr(0,4) == 'txt_'){
                    click_line.html(data.substring(4)).addClass('saved');
                    setTimeout(function(){
                        click_line.html('сохранить изменения').removeClass('saved');
                    }, 2000);
                } else if(data.substr(0,4) == 'msg_'){
                    blockPage_msg(data.substring(4));
                    setTimeout(function(){
                        $.unblockUI();
                    }, 2000);
                }
            } catch(e){
                alert('Internal error #5422. Please, contact administrator.');
            }
        }
        );
    }



}
// Блокировка страницы
function blockPage_msg(msg_to_show){
    // Функция временно безработная
    // return false;

    /*	// Экран с вращающимся сердцем
	msg_to_show = msg_to_show || '<img src="/images/ajax.gif" />';
	if(msg_to_show != '<img src="/images/ajax.gif" />') msg_to_show = '<div class="msg_to_show"><br/><br/><br/>'+msg_to_show+'</div>';
    $.blockUI({
    message: msg_to_show,
    backgroundColor: 'none',
    overlayCSS:  {
        backgroundColor: '#FFF',
        opacity:         0.8
    },
    css: {
        border: 'none',
        backgroundColor: 'none'
    }});
     */

    // Экран с прозрачной лепниной, гарантирует ненажимабельность в интерфейсе
    msg_to_show = msg_to_show || '';

    css_bg_color = 'transparent';
    css_bg_op = 1;

    if(msg_to_show != ''){
        msg_to_show = '<div class="msg_to_show"><br/><br/><br/>'+msg_to_show+'</div>';
        css_bg_color = 'white';
        css_bg_op = 0.85;
    }
    $.blockUI({
        message: msg_to_show,
        backgroundColor: 'none',
        overlayCSS:  {
            backgroundColor: css_bg_color,
            opacity:         css_bg_op,
            cursor:    'default'
        },
        fadeIn:  0,
        fadeOut:  0,
        css: {
            border: 'none',
            backgroundColor: 'none',
            cursor:    'default'
        }
    });

}

// Включение CheckBox-а
function CreateCheckBox(custom_class){
	var custom_class = custom_class || '.p_checkbox';

    $(custom_class).each( function() {
        if($(this).children('input:checked').length) $(this).addClass('active');
    });

    $(custom_class).bind({
        click: function() {
            if(!$(this).hasClass('max5sonic') && !$(this).hasClass('disabled')){

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


            }
        }
    });

}

// Включение работы модуля Sonic в левой колонке
function CreateleftSonic(){
    $('.p_checkbox.max5sonic').bind({
        click: function() {
            //	        	console.log('click');
            if(GetActiveSelsCount() < 5) $(this).toggleClass('active');
            else $(this).removeClass('active');
        //  CheckActiveSels();
        }
    });


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
        $("#left_block_load .left_user_sonic .active").each( function() {
            current_active++;
        });
        return current_active;
    }


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

    self.init = function(){
        self.combo_obj.children('.easy_mask').bind({
            click: function() {
                if(!self.show_state) self.show_list();
            }
        });
        self.one_combo.bind({
            click: function() {
                self.new_selection($(this));
            }
        });
        self.combo_obj.bind({
            mouseover: function() {
                clearTimeout(self.hide_timer);
            },
            mouseout: function() {
                self.hide_timer = setTimeout(self.hide_list, 200);
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

    self.show_list = function(){
        self.combo_obj.children('.combo_variants').fadeIn();
        self.show_state = true;
    }
    self.hide_list = function(){
        self.combo_obj.children('.combo_variants').fadeOut();
        self.show_state = false;
    }

    self.new_selection = function(clicked_obj){
        var clicked_id = '';
        clicked_id = clicked_obj.attr('id');

        combo_cut_name = self.combo_name.substring(1);
        clicked_name = clicked_obj.html();
        self.combo_input.val(clicked_name);
        clicked_id = clicked_id.substring(combo_cut_name.length+1);
        self.combo_obj.children('.easy_mask').html('<input type="hidden" name="'+combo_cut_name+'_id" value="'+clicked_id+'">');
        self.hide_list();
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
                    self.callb_func.call({
                        new_page_num:new_page_num
                    });
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

}

/*
Активация страницы помощь в разделе профиля пользователя
 */
function CreateHelpPage(){
    $('#center_block .go_help').bind({
        click: function() {
            help_id = $(this).attr('id').substr(5);

            blockPage_msg();
            $.post(self.functional_url, {
                functional: 'help',
                data: help_id,
                ahah: 'true'
            },
            function(data) {
                if(data){
                    $('#center_block').html(data);
                    $.unblockUI();
                } else {
                    alert('Internal error #5427. Please, contact administrator.');
                }
            }
            );

        }
    });

    $('#ask_for_help .rs1_save').bind({
        click: function() {
            send_text = $('#ask_for_help textarea').attr('value');

            $.post(self.functional_url, {
                functional: 'help_add_question',
                data: send_text,
                ahah: 'true'
            },
            function(data) {
                if(data){
                    blockPage_msg(data.substring(4));
                    setTimeout(function(){
                        $.unblockUI();
                    }, 4500);
                } else {
                    alert('Internal error #5429. Please, contact administrator.');
                }
            }
            );

        }
    });


}