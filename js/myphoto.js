
Photoalbums = function() {
    this.jcrop_api = "";
    this.masImage = [];
    this.masAlbums = [];
    this.numberAlbums_active = 0;
    this.activeAlbum = 0;
    this.kolLoad = 0;
    this.Coord = {};
    this.href = document.location.href;
    this.location = document.location.href;
    this.indexPhoto = 0;
    this.kol_error_img = 0;
    this.kod_url_prev = document.location.href;
    this.bl = 0;
    this.bl_cover = 0;
    this.bl_alb = 0;
    this.boundx = null;
    this.boundy = null;
    this.nophoto_img = '/resource/nophoto.jpg';
    this.addsphotos_img  = '/resource/addsphotos.png';

    this.post = function(functional, data, callback, error_callback) {
        var me = this;
        $.post(me.href, {
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

    this.numText = function(number, words) {
        number = Math.abs(number);
        if(!number) return words[2];
        var t1 = number % 10;
        var t2 = number % 100;
        return (t1 == 1 && t2 != 11 ? words[0] : (t1 >= 2 && t1 <= 4 && (t2 < 10 || t2 >= 20) ? words[1] : words[2]));
    }

    this.open_modal = function(num) {
        var me = this;
        $('.reveal-modal-bg').css('display','block');
        me.myModal[num].css('visibility','hidden');
        setTimeout(function() {
            var top_mod=(document.body.clientHeight-me.myModal[num].height())/2;
            if (top_mod<10) {
                top_mod=10;
            }
            me.myModal[num].css({
                'top':top_mod+'px',
                'z-index': 999
            });
            var m_l=me.myModal[num].width()/2*(-1);
            me.myModal[num].css({
                'margin-left':m_l+'px'
            });
            me.myModal[num].css('visibility','visible');
        },200);
        if(num===""){
            $(document).unbind('keyup');
            $(document).keyup(function(e) {
                if(e.which===27){
                    $('.close-reveal-modal').click()
                } else if(e.which===39){
                    $('#next_foto_modal2').click()
                } else if(e.which===37){
                    $('#prev_foto_modal2').click()
                }
            });
        }
    }

    this.changePrivilege = function(id1, id2) {
        var data={
            id1:id1,
            id2:id2
        };
        this.post("photoalbums_changePrivilege", data);
    }

    this.post_del_photo = function(id, callback) {
        var data={
            id:id
        }
        this.post("photoalbums_delPhoto", data, callback);
    }

    this.create_albums = function() {
        var me = this;

        var errorProcess = function(msg) {
            var text = msg;
            $('#myModalError_text').html(text);
            me.open_modal('Error');
        }

        this.post("photoalbums_creatAlbums", null, function(msg) {
            var l= me.masAlbums.length;
            me.numberAlbums_active=l;
            var el=msg;
            me.masAlbums[l]=el[0];
            me.masImage=[];
            me.load_albums(me.masAlbums);
            //$('.change_album_btn').click();
            me.location = "#get&id"+me.masAlbums[me.numberAlbums_active].id;
            me.prov_url();
        }, errorProcess);
    }

    this.setAlbumCover = function(img) {
        var me = this;
        var count = parseInt(me.masAlbums[me.numberAlbums_active].count_photo);
        var okonchanie= me.numText(count, ['фотография', 'фотографии', 'фотографий']);
        var text = '('+count+' '+okonchanie+')';
        if (me.albums_lenta.css('margin-left')=="0px") {
            img && me.albums_lenta.children('div:eq(0)').children('div:eq(0)').children('img:eq(0)').attr({
                src:img
            });
            me.albums_lenta.children('div:eq(0)').children('div:eq(1)').children('div:eq(1)').html(text);
        } else {
            img && me.albums_lenta.children('div:eq(1)').children('div:eq(0)').children('img:eq(0)').attr({
                src:img
            });
            me.albums_lenta.children('div:eq(1)').children('div:eq(1)').children('div:eq(1)').html(text);
        }
        img && me.albums_foto_change.attr({
            src:img
        });
    }

    this.set_cover = function(id) {
        var me = this;
        var data={
            x: me.Coord.x,
            y: me.Coord.y,
            w: me.Coord.w,
            h: me.Coord.h,
            id: id
        }
        this.post("photoalbums_setCover", data, function(msg) {
            me.masAlbums[me.numberAlbums_active].img=msg;
            if (me.albums_lenta.css('margin-left')=="0px") {
                me.albums_lenta.children('div:eq(0)').children('div:eq(0)').children('img:eq(0)').attr({
                    src:msg
                });
            } else {
                me.albums_lenta.children('div:eq(1)').children('div:eq(0)').children('img:eq(0)').attr({
                    src:msg
                });
            }
            me.albums_foto_change.attr({
                src:msg
            });
        });
    }

    this.del_albums = function() {
        var me = this;
        var data={
            id: me.masAlbums[me.numberAlbums_active].id
        }
        this.post("photoalbums_delAlbums", data, function(msg) {
            me.get_albums();
            $('#back_albums').click();
            $('.close-reveal-modal').click()
        });
    }

    this.set_mini_ava = function(id) {
        var me = this;
        var data={
            x: me.Coord.x,
            y: me.Coord.y,
            w: me.Coord.w,
            h: me.Coord.h,
            id:id
        }
        this.post("photoalbums_setMiniAva", data, function(msg) {
            $('#close_miniava').click();
        });
    }

    this.set_ava_succ = function(path) {
        var me = this;
        $('.user_photo_in img, #im_ava2, #preview_ava1, #preview_ava2, #preview_ava3').attr({
            src:path
        });
        if (me.jcrop_api) me.jcrop_api.destroy();
        $('.close-reveal-modal').click();
        var boundx, boundy;

        var updatePreview3 = function(c) {
            if (parseInt(c.w) > 0) {
                me.Coord.x=c.x;
                me.Coord.y=c.y;
                me.Coord.w=c.w;
                me.Coord.h=c.h;
                var rx = 100 / c.w;
                var ry = 100 / c.h;

                $('#preview_ava1').css({
                    width: Math.round(rx * boundx) + 'px',
                    height: Math.round(ry * boundy) + 'px',
                    marginLeft: '-' + Math.round(rx * c.x) + 'px',
                    marginTop: '-' + Math.round(ry * c.y) + 'px'
                });

                rx = 50 / c.w;
                ry = 50 / c.h;

                $('#preview_ava2').css({
                    width: Math.round(rx * boundx) + 'px',
                    height: Math.round(ry * boundy) + 'px',
                    marginLeft: '-' + Math.round(rx * c.x) + 'px',
                    marginTop: '-' + Math.round(ry * c.y) + 'px'
                });

                rx = 30 / c.w;
                ry = 30 / c.h;

                $('#preview_ava3').css({
                    width: Math.round(rx * boundx) + 'px',
                    height: Math.round(ry * boundy) + 'px',
                    marginLeft: '-' + Math.round(rx * c.x) + 'px',
                    marginTop: '-' + Math.round(ry * c.y) + 'px'
                });
            }
        };

        $('#im_ava2').Jcrop({
            aspectRatio:1,
            onSelect: updatePreview3,
            onChange: updatePreview3
        },function(){
            var bounds = this.getBounds();
            boundx = bounds[0];
            boundy = bounds[1];
            me.jcrop_api = this;
            me.jcrop_api.setOptions( {
                minSize: [ 100, 100 ]
            });
            me.jcrop_api.setSelect([0,0,800,800]);
            me.open_modal(5);
        });
    }

    this.set_ava = function(id) {
        var me = this;
        var data={
            x: me.Coord.x,
            y: me.Coord.y,
            w: me.Coord.w,
            h: me.Coord.h,
            id:id
        }
        this.post("photoalbums_setAva", data, function(msg) {
            me.set_ava_succ(msg);
        });
    }

    this.get_photo = function(id) {
        var me = this;
        var data= {
            id:id
        }
        this.post("photoalbums_getPhoto", data, function(msg) {
            me.load_image(msg);
        });
    }

    this.get_albums = function() {
        var me = this;
        this.post("photoalbums_getAlbums", null, function(msg) {
            var tmp=msg;
            me.load_albums(tmp);
            if (tmp.length>0) me.get_photo(tmp[0].id);
        });
    }

    this.rasp3 = function() {
        var me = this;
        if (me.masImage.length==3 || me.masImage.length==2) {
            var w = me.cont_photo.children('img:eq(0)').width();
            var w2 = me.cont_photo.children('img:eq(1)').width();
            var m_l1 = me.masImage.length==3 ? 150-w : 225-w;
            me.cont_photo.children('img:eq(0)').css({
                'marginLeft':m_l1+'px'
            });
        }
        m_l1=parseInt(me.cont_photo.children('img:eq('+(me.cont_photo.children().length-1)+')').css('marginLeft'));
        w=me.cont_photo.children('img:eq('+(me.cont_photo.children().length-1)+')').width();
        var m_l2=parseInt(me.cont_photo.children('img:eq(0)').css('marginLeft'));
        var smesh=(510-(m_l1-m_l2+w))/2;
        smesh-=m_l2;
        for (var i=0; i < me.masImage.length; i++) {
            var t=parseInt(me.cont_photo.children('img:eq('+i+')').css('marginLeft'));
            t+=smesh;
            var m_t=300-parseInt(me.cont_photo.children('img:eq('+i+')').height());
            m_t/=2;
            me.cont_photo.children('img:eq('+i+')').css({
                'marginLeft':t+'px',
                'marginTop':m_t+'px'
            });
        }
    }

    this.getImgOnLoadImage2 = function(mas, max, m_l, i) {
        return '<img onclick="myphoto.change_image2(this, 1)" src="'+mas[i].minimg+
        '" maxsrc="'+mas[i].img+'" com="'+mas[i].com+'" com2="'+mas[i].com2+'" id_ph="'+mas[i].id+
        '" style=max-width:'+max+'px;max-height:'+max+'px;padding:4px;margin-left:'+m_l+
        'px;position:absolute;z-index:'+(10-i)+';margin-top:0px;" alt="'+mas[i].txt+'"/>';
    }

    this.load_image2 = function(kol, mas) {
        var me = this;
        me.masImage=mas;
        kol = mas.length;
        me.prev_photo.unbind('click');
        me.next_photo.unbind('click');
        me.prev_photo.css({
            'display':'none'
        });
        me.next_photo.css({
            'display':'none'
        });
        var temp;
        if (kol==0) {
            temp='<img id="no_foto2" src="'+me.addsphotos_img+'" style="margin-left: 110px;" />';
            me.cont_photo.html(temp);
            if(me.addsphotos_img != '/resource/addsphotos.png'){
                $('#no_foto2').css({
                    cursor: 'auto'
                });
            }
            $('#no_foto2').unbind('click').click(function() {
                $('.add_image').click();
            });
            return;
        }
        temp="";
        var max, m_l, i, tt, m_t, pad;
        if (kol==1) {
            temp += me.getImgOnLoadImage2(mas, 300, 0, 0);
        }else if (kol==2){
            temp += me.getImgOnLoadImage2(mas, 255, 0, 0);
            temp += me.getImgOnLoadImage2(mas, 255, 255, 1);
        } else if (kol==3) {
            temp += me.getImgOnLoadImage2(mas, 150, 0, 0);
            temp += me.getImgOnLoadImage2(mas, 150, 175, 1);
            temp += me.getImgOnLoadImage2(mas, 150, 350, 2);
        } else if (kol>3 && kol<6) {
            tt=400/kol;
            for (i=0;i<kol;i++) {
                max=(160)-Math.random()*30;
                m_l=Math.random()*30+(tt*i);
                temp += me.getImgOnLoadImage2(mas, max, m_l, i);
            }
        } else if (kol>5) {
            tt=400/kol;
            for (i=0;i<kol;i++) {
                max=155-(kol-5)*12-Math.random()*50;
                m_l=Math.random()*28+(tt*i);
                m_t=Math.random()*(250-max);
                pad = kol<8 ? 3 : 4;
                temp+='<img onclick="myphoto.change_image2(this, 1)" src="'+mas[i].minimg+'" maxsrc="'+mas[i].img+'" com="'+mas[i].com+'" com2="'+mas[i].com2+'" id_ph="'+mas[i].id+'" style=max-width:'+max+'px;max-height:'+max+'px;margin-left:'+m_l+'px;position:absolute;z-index:'+(10-i)+';padding:'+pad+'px;margin-top:'+m_t+'px;" alt="'+mas[i].txt+'"/>';
            }
        }
        me.cont_photo.html(temp);
        me.next_foto_modal2.unbind('click').click(function() {
            if ((me.cont_photo.children().length-1)==me.indexPhoto) {
                me.indexPhoto=-1;
            }
            var t=me.cont_photo.children('img:eq('+(me.indexPhoto+1)+')');
            me.change_image2(t, 0);
        });
        me.prev_foto_modal2.unbind('click').click(function() {
            if (me.indexPhoto==0) {
                me.indexPhoto=me.cont_photo.children().length;
            }
            var t=me.cont_photo.children('img:eq('+(me.indexPhoto-1)+')');
            me.change_image2(t , 0);
        });
        me.kolLoad=0;
        me.cont_photo_img.load(function(){
            me.kolLoad++;
            if (me.kolLoad==me.masImage.length){
                me.masImage.length<4 ? me.rasp3() : me.rasp2();
            }
        });
        me.cont_photo_img.error(function(){
            me.kol_error_img++;
            me.kolLoad++;
            $(this).attr({
                src: 'resource/error_load.png'
            });
            if (me.kolLoad==me.masImage.length) {
                me.masImage.length<4 ? me.rasp3() : me.rasp2();
            }
        });
    }

    this.rasp2 = function(callback) {
        var me = this;
        var kol = me.masImage.length;
        var h, m_t, m_l, i;
        var setCountImgMargin = function(margin, m, i){
            var css = {};
            css['margin'+margin] = m+'px';
            me.cont_photo.children('img:eq('+(i)+')').css(css);
        }
        if (kol<6) {
            for (i=0; i < kol; i++) {
                h=me.cont_photo.children('img:eq('+i+')').height();
                m_t=Math.random()*(220-h);
                setCountImgMargin("Top", m_t, i);
            }
        }
        for (i=0;i<(kol-1);i++) {
            var w1=me.cont_photo.children('img:eq('+i+')').width();
            var w2=me.cont_photo.children('img:eq('+(i+1)+')').width();
            var h1=me.cont_photo.children('img:eq('+i+')').height();
            var h2=me.cont_photo.children('img:eq('+(i+1)+')').height();
            var m_t1=me.cont_photo.children('img:eq('+i+')').css('marginTop');
            var m_t2=me.cont_photo.children('img:eq('+(i+1)+')').css('marginTop');
            var m_l1=me.cont_photo.children('img:eq('+i+')').css('marginLeft');
            var m_l2=me.cont_photo.children('img:eq('+(i+1)+')').css('marginLeft');
            m_t1=parseInt(m_t1);
            m_t2=parseInt(m_t2);
            m_l1=parseInt(m_l1);
            m_l2=parseInt(m_l2);
            if ((m_l2-m_l1)>(0.85*w1)) {
                setCountImgMargin('Left', m_l1+0.85*w1, i+1);
            }
            if ((m_l1+w1-m_l2)>(0.3*w2)) {
                setCountImgMargin('Left', m_l1+w1-0.3*w2, i+1);
            }
            if ((m_l2-m_l1)<(0.8*w1)) {
                setCountImgMargin('Left', m_l1+0.8*w1, i+1);
            }
            if (Math.abs(m_t2-m_t1)>=h1) {
                if (m_t2>=m_t1) {
                    setCountImgMargin('Top', h1-(0.55*h2)+m_t1, i+1);
                } else {
                    setCountImgMargin('Top', m_t1-(0.45*h2), i+1);
                }
            }
        }
        var h_d;
        if (kol>5) {
            h_d=300-me.cont_photo.children('img:eq(0)').height();
            m_t1=parseInt(me.cont_photo.children('img:eq(1)').css('marginTop'));
            if ((h_d-m_t1)<(h_d/2)) {
                h=me.cont_photo.children('img:eq(0)').height()*0.7;
                m_t=m_t1-h;
                me.cont_photo.children('img:eq(0)').css({
                    'marginTop':m_t+'px'
                });
            } else {
                h=me.cont_photo.children('img:eq(1)').height()*0.7;
                m_t=m_t1+h;
                me.cont_photo.children('img:eq(0)').css({
                    'marginTop':m_t+'px'
                });
            }
            h_d=300-me.cont_photo.children('img:eq('+(me.cont_photo.children().length-1)+')').height();
            m_t1=parseInt(me.cont_photo.children('img:eq('+(me.cont_photo.children().length-2)+')').css('marginTop'));

            if ((h_d-m_t1)<(h_d/2)) {
                h=me.cont_photo.children('img:eq('+(me.cont_photo.children().length-1)+')').height()*0.7;
                setCountImgMargin("Top", m_t1-h, me.cont_photo.children().length-1);
            } else {
                h=me.cont_photo.children('img:eq('+(me.cont_photo.children().length-2)+')').height()*0.7;
                setCountImgMargin("Top", m_t1-h, me.cont_photo.children().length-1);
            }
        }
        m_l=parseInt(me.cont_photo.children('img:eq('+(me.cont_photo.children().length-1)+')').css('marginLeft'));
        var w=me.cont_photo.children('img:eq('+(me.cont_photo.children().length-1)+')').width();
        if ((m_l+w)>500) {
            setCountImgMargin("Left", 500-w, me.cont_photo.children().length-1);
        }
        m_l=parseInt(me.cont_photo.children('img:eq('+(me.cont_photo.children().length-2)+')').css('marginLeft'));
        w=me.cont_photo.children('img:eq('+(me.cont_photo.children().length-2)+')').width();
        if ((m_l+w)>500) {
            setCountImgMargin("Left", 500-w, me.cont_photo.children().length-2);
        }
        m_l1=parseInt(me.cont_photo.children('img:eq('+(me.cont_photo.children().length-1)+')').css('marginLeft'));
        w=me.cont_photo.children('img:eq('+(me.cont_photo.children().length-1)+')').width();
        m_l2=parseInt(me.cont_photo.children('img:eq(0)').css('marginLeft'));
        var smesh=(510-(m_l1-m_l2+w))/2;
        smesh-=m_l2;
        var t;
        for (i=0;i<kol;i++) {
            t=parseInt(me.cont_photo.children('img:eq('+i+')').css('marginLeft'));
            t+=smesh;
            setCountImgMargin("Left", t, i);
        }
        $.isFunction(callback) && callback();
    }

    this.load_image = function(mas) {
        var me = this;
        me.kol_error_img=0;
        if (mas.length<10) {
            me.load_image2(mas.length, mas);
            return;
        }
        me.prev_photo.css({
            'display':'block'
        });
        me.next_photo.css({
            'display':'block'
        });
        me.prev_photo.unbind('click').click(function(){
            me.prev_foto_fun(3);
        });
        me.next_photo.unbind('click').click(function(){
            me.next_foto_fun(5);
        });
        me.next_foto_modal2.unbind('click').click(function() {
            me.next_photo.click();
            me.change_image();
        });
        me.prev_foto_modal2.unbind('click').click(function() {
            me.prev_photo.click();
            me.change_image();
        });
        me.cont_photo.html('');
        me.masImage=mas;
        var temp= [];
        var l=mas.length;
        if (l==0) {
            me.cont_photo.html('<img src="'+me.nophoto_img+'" style="margin-top:80px;margin-left:140px;"/>');
            return;
        }
        me.cont_photo.children("img:eq(0)").empty();
        
        var tplFn = function(i, m_l) {
            return '<img src="'+mas[i].minimg+'" maxsrc="'+mas[i].img+'" com="'+mas[i].com+'" com2="'+mas[i].com2+
            '" id_ph="'+mas[i].id+'" style=max-width:75px;max-height:75px;margin-left:'+m_l+
            'px;position:absolute;margin-top:45px;" alt="'+mas[i].txt+'"/>';
        }
        temp[0] = jQuery(tplFn(0, Math.random()*20));
        temp[1] = jQuery(tplFn(1, Math.random()*20+600));
        temp[2] = jQuery(tplFn(2, Math.random()*20));
        m_l = Math.random()*20+600;
        temp[3] = jQuery(tplFn(3, m_l));
        temp[4] = jQuery(tplFn(4, m_l));
        temp[5] = jQuery(tplFn(5, Math.random()*20+367));
        temp[6] = jQuery(tplFn(6, Math.random()*20+250));
        temp[7] = jQuery(tplFn(7, Math.random()*20+367));
        temp[8] = jQuery(tplFn(8, Math.random()*20+250));

        for (i=9;i<l;i++) {
            temp[i] = jQuery('<img src="'+mas[i].minimg+'" maxsrc="'+mas[i].img+'" com="'+mas[i].com+'" com2="'+mas[i].com2+'" id_ph="'+mas[i].id+'"  style="display:none;" alt="'+mas[i].txt+'"/>');
        }

        var onAllLoad = function() {
            me.next_foto_fun(4);
        }

        var kolLoad = 0;
        var onLoad = function() {
            kolLoad++;
            if(kolLoad==9){
                onAllLoad();
            }
        }

        for(var k=0; k<temp.length; k++) {
            if(k<9){
                temp[k].load(onLoad);
            }
            me.cont_photo.append(temp[k]);
        }
    }

    this.rasp = function(callback) {
        var me = this;
        var cont_photo = me.cont_photo;
        var diapazon= new Array();
        var m_l= new Array();
        var m_r= new Array();
        var widthImage= new Array();
        widthImage[0]=cont_photo.children("img:eq(0)").width();
        diapazon[0]=125-widthImage[0];
        m_l[0]=Math.floor(Math.random()*diapazon[0]);
        m_r[0]=diapazon[0]-m_l[0];

        widthImage[5]=cont_photo.children("img:eq(5)").width();
        diapazon[5]=125-widthImage[5];
        m_l[5]=Math.floor(Math.random()*diapazon[5]);
        m_r[5]=diapazon[5]-m_l[5];

        for(var i=1; i<=8; i++){
            widthImage[i]=cont_photo.children("img:eq("+i+")").width();
        }
        var ind=1;
        for(i=0;i<6;i++) {
            if ((m_r[ind-1]+0.3*widthImage[ind-1])>widthImage[ind]) {
                m_l[ind]=0.7*widthImage[ind-1]+m_l[ind-1];
            } else {
                m_l[ind]=m_l[ind-1]+0.3*widthImage[ind-1]-widthImage[ind];
                if (m_l[ind]<0) {
                    if (m_r[ind-1]>m_l[ind-1]) {
                        m_l[ind]=125-widthImage[ind]
                    } else {
                        m_l[ind]=0;
                    }
                }
            }
            m_r[ind]=125-m_l[ind]-widthImage[ind];
            ind++;
            if (ind==4) ind=6;
        }
        for(i=0; i<=8; i++){
            if(i!=4){
                var css = {
                    'margin-left': m_l[i]+(i>4 ? 355 : 0)+'px'
                };
                if([1,3,6,8].indexOf(i)!=-1){
                    css.right = "auto";
                }
                cont_photo.children("img:eq("+i+")").css(css);
            }
        }

        var unandbind = function(id) {
            var child = cont_photo.children("img:eq("+id+")");
            child.unbind('click');
            if(id > 3) {
                child.click(function(){
                    me.next_foto_fun(id);
                });
            } else {
                child.click(function(){
                    me.prev_foto_fun(id);
                });
            }
        }

        var ids = [5,6,7,8,0,1,2,3];
        for(var ii=0; ii<ids.length; ii++){
            unandbind(ids[ii]);
        }
        cont_photo.children("img:eq(4)").unbind('click').click(function(){
            me.open_modal("");
            me.change_image();
        });
    }

    this.setChildrenPropCSS = function(id, mw, mh, d, v) {
        var me = this;
        me.cont_photo.children("img:eq("+id+")").css({
            'max-width': mw+'px',
            'max-height': mh +'px',
            'display':d,
            'visibility':v
        }) ;
    }

    this.animateChildren = function(id, l, t, w, h, p) {
        var me = this;
        me.cont_photo.children("img:eq("+id+")").animate({
            "margin-left": l+'px',
            "margin-top":t+"px",
            "max-width":w,
            'max-height':h,
            "padding":p+"px"
        },500);
    }

    this.next_foto_fun = function(num_click) {
        var me = this;
        var cont_photo = me.cont_photo;
        var temp=num_click%5;
        for (var i=0;i<temp;i++) {
            cont_photo.children("img:eq(0)").css({
                'display':'none'
            });
            cont_photo.children("img:eq(0)").detach().appendTo('#cont_photo');
            me.setChildrenPropCSS(8, 75, 75, 'block', 'hidden');
        }
        me.setChildrenPropCSS(9, 75, 75, 'block', 'hidden');

        var diapazon= new Array();
        var m_l= new Array();
        var m_r= new Array();
        var widthImage= new Array();
        widthImage[1]=cont_photo.children("img:eq(1)").width();
        if (num_click==8) {
            if (cont_photo.children("img:eq(1)").width()>cont_photo.children("img:eq(1)").height()) {
                widthImage[1]=75;
            } else {
                widthImage[1]=75*cont_photo.children("img:eq(1)").width()/cont_photo.children("img:eq(1)").height();
            }
        }

        diapazon[1]=125-widthImage[1];
        m_l[1]=Math.floor(Math.random()*diapazon[1]);
        m_r[1]=diapazon[0]-m_l[1];

        widthImage[6]=cont_photo.children("img:eq(6)").width();
        diapazon[6]=125-widthImage[6];
        m_l[6]=Math.floor(Math.random()*diapazon[6]);
        m_r[6]=diapazon[6]-m_l[6];

        widthImage[2]=cont_photo.children("img:eq(2)").width();
        widthImage[3]=cont_photo.children("img:eq(3)").width();
        if (cont_photo.children("img:eq(4)").width()>cont_photo.children("img:eq(4)").height()) {
            widthImage[4]=75;
        } else {
            var h=cont_photo.children("img:eq(4)").width()/cont_photo.children("img:eq(4)").height();
            widthImage[4]=75*h;
        }
        widthImage[7]=cont_photo.children("img:eq(7)").width();
        widthImage[8]=cont_photo.children("img:eq(8)").width();
        widthImage[9]=cont_photo.children("img:eq(9)").width();
        var ind=2;
        var w=0;

        if (cont_photo.children("img:eq("+(4-temp)+")").width()>cont_photo.children("img:eq("+(4-temp)+")").height()) {
            w=75;
        } else {
            w=75*cont_photo.children("img:eq("+(4-temp)+")").width()/cont_photo.children("img:eq("+(4-temp)+")").height();
        }
        widthImage[4-temp]=w;
        for(i=0;i<6;i++) {
            if ((m_r[ind-1]+0.3*widthImage[ind-1])>widthImage[ind]) {
                m_l[ind]=0.7*widthImage[ind-1]+m_l[ind-1];
            } else {
                m_l[ind]=m_l[ind-1]+0.3*widthImage[ind-1]-widthImage[ind];
                if (m_l[ind]<0) {
                    if (m_r[ind-1]>m_l[ind-1]) {
                        m_l[ind]=125-widthImage[ind]
                    } else {
                        m_l[ind]=0;
                    }
                }
            }
            m_r[ind]=125-m_l[ind]-widthImage[ind];
            ind++;
            if (ind==5) ind=7;
        }
        me.animateChildren(1, m_l[1], 45, 75, 75, 2);
        me.animateChildren(2, m_l[2], 90, 75, 75, 2);
        me.animateChildren(3, m_l[3], 135, 75, 75, 2);
        var m_t;
        if (cont_photo.children("img:eq(5)").width()>cont_photo.children("img:eq(5)").height()) {
            h=cont_photo.children("img:eq(5)").height()/cont_photo.children("img:eq(5)").width()*190;
            m_t=(280-h)/2;
        } else {
            m_t=20;
        }
        me.animateChildren(4, m_l[4], 180, 75, 75, 2);
        me.animateChildren(5, 140, m_t, 190, 290, 5);

        if (temp<3)  me.animateChildren(6, m_l[6]+355, 45, 75, 75, 2);
        if (temp<2)  me.animateChildren(7, m_l[7]+355, 90, 75, 75, 2);
        if (temp<1)  me.animateChildren(8, m_l[8]+355, 135, 75, 75, 2);

        cont_photo.children("img:eq(0)").css({
            'display':'none'
        });
        cont_photo.children("img:eq(9)").css({
            'display':'none',
            'visibility':'visible',
            'margin-left':m_l[9]+355+'px',
            'margin-top':'180px'
        });
        cont_photo.children("img:eq(9)").fadeIn();

        m_t=135;

        for (i=0;i<temp;i++) {
            cont_photo.children("img:eq("+(8-i)+")").clearQueue();
            cont_photo.children("img:eq("+(8-i)+")").css({
                'display':'block',
                'visibility':'visible',
                'margin-left':'400px',
                'margin-top':'265px'
            }) ;

            cont_photo.children("img:eq("+(8-i)+")").animate({
                "margin-left":m_l[8-i]+355+'px',
                'margin-top':m_t+'px'
            },500);
            m_t-=45;
        }
        
        me.cont_photo.children("img:eq(0)").detach().appendTo('#cont_photo');

        var unandbind = function(id) {
            var child = cont_photo.children("img:eq("+id+")");
            child.unbind('click');
            if(id > 3) {
                child.click(function(){
                    me.next_foto_fun(id);
                });
            } else {
                child.click(function(){
                    me.prev_foto_fun(id);
                });
            }
        }

        var ids = [5,6,7,8,0,1,2,3];
        for(var ii=0; ii<ids.length; ii++){
            unandbind(ids[ii]);
        }
        cont_photo.children("img:eq(4)").unbind('click').click(function(){
            me.open_modal("");
            me.change_image();
        });
    }

    this.prev_foto_fun = function(num_click) {
        var me = this;
        var cont_photo = me.cont_photo;
        var temp=3-num_click;
        var len;
        for (var i=0;i<temp;i++) {
            cont_photo.children("img:eq(9)").css({
                'display':'none'
            });
            len=cont_photo.children().length-1;
            cont_photo.children("img:eq("+len+")").detach().prependTo('#cont_photo');
            me.setChildrenPropCSS(0, 75, 75, 'block', 'hidden');
        }

        len=cont_photo.children().length-1;
        cont_photo.children("img:eq("+len+")").detach().prependTo('#cont_photo');
        me.setChildrenPropCSS(0, 75, 75, 'block', 'hidden');

        var diapazon= new Array();
        var m_l= new Array();
        var m_r= new Array();
        var widthImage= new Array();
        widthImage[0]=cont_photo.children("img:eq(0)").width();

        diapazon[0]=125-widthImage[0];
        m_l[0]=Math.floor(Math.random()*diapazon[0]);
        m_r[0]=diapazon[0]-m_l[0];

        widthImage[1]=cont_photo.children("img:eq(1)").width();
        widthImage[2]=cont_photo.children("img:eq(2)").width();
        widthImage[3]=cont_photo.children("img:eq(3)").width();

        widthImage[6]=cont_photo.children("img:eq(6)").width();
        widthImage[7]=cont_photo.children("img:eq(7)").width();
        widthImage[8]=cont_photo.children("img:eq(8)").width();
        var ind=1;
        var w=0;
        widthImage[5]=cont_photo.children("img:eq(5)").width();
        if (cont_photo.children("img:eq("+(8-num_click)+")").width()>cont_photo.children("img:eq("+(8-num_click)+")").height()) {
            w=75;
        } else {
            w=75*cont_photo.children("img:eq("+(8-num_click)+")").width()/cont_photo.children("img:eq("+(8-num_click)+")").height();
        }
        widthImage[8-num_click]=w;

        diapazon[5]=125-widthImage[5];
        m_l[5]=Math.floor(Math.random()*diapazon[5]);
        m_r[5]=diapazon[5]-m_l[5];
        for(i=0;i<6;i++) {
            if ((m_r[ind-1]+0.3*widthImage[ind-1])>widthImage[ind]) {
                m_l[ind]=0.7*widthImage[ind-1]+m_l[ind-1];
            } else {
                m_l[ind]=m_l[ind-1]+0.3*widthImage[ind-1]-widthImage[ind];
                if (m_l[ind]<0) {
                    if (m_r[ind-1]>m_l[ind-1]) {
                        m_l[ind]=125-widthImage[ind]
                    } else {
                        m_l[ind]=0;
                    }
                }
            }
            m_r[ind]=125-m_l[ind]-widthImage[ind];
            ind++;
            if (ind==4) ind=6;
        }

        if (num_click>2) me.animateChildren(1, m_l[1], 90, 75, 75, 2);
        if (num_click>1) me.animateChildren(2, m_l[2], 135, 75, 75, 2);
        if (num_click>0) me.animateChildren(3, m_l[3], 180, 75, 75, 2);
        var h, m_t;
        if (cont_photo.children("img:eq(4)").width()>cont_photo.children("img:eq(4)").height()) {
            h=cont_photo.children("img:eq(4)").height()/cont_photo.children("img:eq(4)").width()*190;
            m_t=(280-h)/2;
        } else {
            m_t=20;
        }
        me.animateChildren(5, m_l[5]+355, 45, 75, 75, 2);
        me.animateChildren(4, 140, m_t, 190, 290, 5);
        me.animateChildren(6, m_l[6]+355, 90, 75, 75, 2);
        me.animateChildren(7, m_l[7]+355, 135, 75, 75, 2);
        me.animateChildren(8, m_l[8]+355, 180, 75, 75, 2);

        cont_photo.children("img:eq(9)").css({
            'display':'none'
        });
        cont_photo.children("img:eq(0)").css({
            'display':'none',
            'visibility':'visible',
            'margin-left':m_l[0]+'px',
            'margin-top':'45px'
        }) ;
        cont_photo.children("img:eq(0)").fadeIn();

        m_t=90;

        for (i=0;i<(3-num_click);i++) {
            cont_photo.children("img:eq("+(i+1)+")").clearQueue();
            cont_photo.children("img:eq("+(i+1)+")").css({
                'display':'block',
                'visibility':'visible',
                'margin-left':'20px',
                'margin-top':'0px'
            }) ;
            cont_photo.children("img:eq("+(i+10)+")").css({
                'display':'none'
            });
            cont_photo.children("img:eq("+(i+1)+")").animate({
                "margin-left":m_l[i+1]+'px',
                'margin-top':m_t+'px'
            },500);
            m_t+=45;
        }

        var unandbind = function(id) {
            var child = cont_photo.children("img:eq("+id+")");
            child.unbind('click');
            if(id > 3) {
                child.click(function(){
                    me.next_foto_fun(id);
                });
            } else {
                child.click(function(){
                    me.prev_foto_fun(id);
                });
            }
        }

        var ids = [5,6,7,8,0,1,2,3];
        for(var ii=0; ii<ids.length; ii++){
            unandbind(ids[ii]);
        }

        cont_photo.children("img:eq(4)").unbind('click').click(function(){
            me.open_modal("");
            me.change_image();
        });
    }

    this.getAlbumTpl = function(mas) {
        var me = this;
        var temp='', okonchanie;
        var l = mas.length;
        for (var i=0;i<l;i++) {
            okonchanie= me.numText(parseInt(mas[i].count_photo), ['фотография', 'фотографии', 'фотографий']);

            if (mas[i].count_photo==0) {
                mas[i].img=me.nophoto_img;
            }

            var str_ram ='';
            if (mas[i].count_photo<=10) {
                str_ram='resource/frame_alb1.png'
            }   //зависимость рамки от количества фоток
            if (mas[i].count_photo>10) {
                str_ram='resource/frame_alb2.png'
            }
            if (mas[i].count_photo>20) {
                str_ram='resource/frame_alb3.png'
            }

            temp+='<div id="album" ><div class="ten_albums" style="background-image:url('+str_ram+')" >';
            temp+='<img class="albums_foto" src="'+mas[i].img+'" style="margin-left:21px;margin-top:18px;width:200px;height:135px;"/></div>';
            temp+='<div style="float:left;width:210px;height:170px;margin-left:20px;">';
            temp+='<div id="name_albums" >'+mas[i].name+'</div>';
            temp+='<div id="count_photo" >('+mas[i].count_photo+' '+okonchanie+')</div>';
            temp+='<div id="txt_albums" >'+mas[i].txt+'</div>';
            temp+='<div style="line-height:145%;margin-top:20px;font-family:Arial;font-size:10px;color:#B2B2B2;font-weight:normal;">';
            temp+='<font style="font-weight:bold">Создан </font>'+mas[i].date_create+' <br>';
            temp+='<font style="font-weight:bold">Обновлен </font>'+mas[i].date_update+'<br></div>';
            temp+='<div style="text-align:justify;line-height:145%;margin-top:10px;font-family:Arial;font-size:12px;color:#3366CC;font-weight:normal;">';
            temp+='<div class="change_album_btn" style="float:left;cursor:pointer;text-decoration:underline;">Редактировать</div> ';
            temp+='<div style="float:left;margin-left:18px;">|</div>';
            temp+='<a class="add_image" style="float:right;cursor:pointer;text-decoration:underline;">Добавить фото</a>';
            temp+='</div></div></div>';
        }

        return temp;
    }

    this.load_albums = function(mas) {
        var me = this;
        me.masAlbums=mas;
        var l=mas.length;
        if (l==0) {
            $('#noalbom').css({
                display:'block'
            });
            $('#albums').css({
                visibility:'hidden'
            });
        }
        if (l<2) {
            $('#next_albums, #prev_albums').css('visibility', 'hidden');
        } else {
            $('#next_albums, #prev_albums').css('visibility', 'visible')
        }
        var temp = me.getAlbumTpl(mas);

        me.albums_lenta.html(temp);
        $('#new_albums').unbind('click').click(function() {
            me.create_albums();
        });

        $('.change_album_btn').unbind('click').click(function(){
            me.location = "#set&id"+me.masAlbums[me.numberAlbums_active].id;
            //me.prov_url();
            var len = me.masImage.length;

            var path = me.masAlbums[me.numberAlbums_active].img;
            me.albums_foto_change.attr({
                src: path
            });
            $('#com_albums').html(me.masAlbums[me.numberAlbums_active].txt);
            $('#name_albums_change').attr({
                value: me.masAlbums[me.numberAlbums_active].name
            });
            var temp="";
            var t1;
            for (var i=0;i<len;i++) {
                t1='<div style="font-family:Arial;font-size: 12px;float:left;">Переместить&nbsp;&nbsp;<font onclick="myphoto.vniz(this)" style="color: #36C;font-family:Arial;font-size: 12px;cursor:pointer">вниз</font>&nbsp;&nbsp;&nbsp;<font>|</font>&nbsp;&nbsp;&nbsp;<font onclick="myphoto.vverh(this)" style="color: #36C;font-family:Arial;font-size: 12px;cursor:pointer">вверх</font></div>';
                if (i==0 && len!=1) {
                    t1='<div style="font-family:Arial;font-size: 12px;float:left;">Переместить&nbsp;&nbsp;<font onclick="myphoto.vniz(this)" style="color: #36C;font-family:Arial;font-size: 12px;cursor:pointer">вниз</font></div>';
                } else if (i==(len-1) && len!=1) {
                    t1='<div style="font-family:Arial;font-size: 12px;float:left;">Переместить&nbsp;&nbsp;<font onclick="myphoto.vverh(this)" style="color: #36C;font-family:Arial;font-size: 12px;cursor:pointer">вверх</font></div>';
                }else if (len==1) {
                    t1="";
                }
                temp+='<div id_ph="'+me.masImage[i].id+'" style="margin-top:20px;min-height:120px;overflow: hidden;">';
                temp+='<div align="center" style="min-height:100px;float:left;width:165px;">';
                temp+='';
                temp+='<img src="'+me.masImage[i].minimg+'" maxsrc="'+me.masImage[i].img+'" class="image_change_win" /></div>';
                temp+='<div style="margin-left:165px;color:#0082BE;text-family:Arial;font-weight:bold;font-size:14px;">Описание</div>';
                temp+='<div class="valid_input"></div>';
                temp+='<div style="margin-bottom:10px;margin-left:165px;margin-top:5px;">';
                temp+='<textarea class="coment_input" onkeyup="myphoto.valid_comment(this, '+i+')" onBlur="myphoto.auto_save('+i+', this.value)"  onFocus="myphoto.focus_input(this, '+i+')" maxlength="200" name="comment" cols="40" style="width:362px;height:45px;background-color:white;border:1px solid #BCCFDF;font-size:12px;color:#666666;font-family:Arial;padding:5px;">'+me.masImage[i].txt+'</textarea></div>';
                temp+='<div style="margin-left: 180px;">'+t1;
                temp+='<div onclick="myphoto.del_photo(this)" style="cursor:pointer;margin-left: 300px;color:#3366CC;text-family:Arial;font-size:12px;">Удалить</div><a></a>';
                temp+='</div>';
                temp+='<div style="margin-top:15px;height:1px;width:540px;background:#BCCFDF; float: left;"></div></div>';
            }
            me.cont_foto_change.html(temp);
            me.albums_change.css({
                display:'block'
            });
            $('#albums').css({
                display:'none'
            });
        });

        $('.add_image').unbind('click').click(function() {
            me.open_modal(2);
            var data={
                'id': me.masAlbums[me.numberAlbums_active].id,
                'type':'photo'
            };
            $("#button_load").uploadifySettings('scriptData' , data );
            $('#button_loadUploader').css({
                visibility:'visible'
            });
        });
    }

    this.imagechange = function(path, com, com2, id, txt) {
        var me = this;
        var loading = '<div style="width: '+me.im.width()+'px; height: '+me.im.height()+'px; padding-top: 240px;">';
        loading += '<img src = "/images/ajax.gif" alt="Загрузка" />';
        loading += '</div>';
        me.image_modal.html(loading);

        me.im.attr({
            src: path,
            id_ph:id
        });

        var t1="<font style='background-image:url(../resource/serdce.png);background-repeat:no-repeat;padding-left:15px;background-position: left 3px;margin-right:4px;font-weight: bold;'>Эта фотография понравилась "+com+" пользователям. Большенству понравилось: </font>";
        var temp=t1+com2;
        me.comment_users.html((com && com!='undefined'&& com!='0') ? temp : '');
        me.txt_image.html(txt);
        me.image_modal.html(me.im);

        me.im.load(function(){
            var m_t=(500- me.im.height())/2;
            me.im.css({
                'margin-top':m_t+'px'
            })
            var w=$('#myModal').width()/2*(-1);
            me.myModal[""].css({
                'margin-left':w+'px'
            });
            var m_obl=(screen.width-$('#myModal').width())/2 -9;
            m_t=parseInt($('#myModal').css('top'))*(-1);
            me.next_foto_modal2.css({
                'right':'-'+m_obl+'px',
                'width':m_obl+'px',
                'top':m_t+'px'
            })
            me.prev_foto_modal2.css({
                'left':'-'+m_obl+'px',
                'width':m_obl+'px',
                'top':m_t+'px'
            })
            var h=me.im.height();
            w=me.im.width();
            if (w<200 || h<300 || path=='resource/error_load.png') {
                me.jcrop_ava2.css({
                    display:'block'
                });
                me.jcrop_ava.css({
                    display:'none'
                });
            } else {
                me.jcrop_ava.css({
                    display:'block'
                });
                me.jcrop_ava2.css({
                    display:'none'
                });
            }

            if (w<200 || h<135 || path=='resource/error_load.png') {
                me.jcrop_albums2.css({
                    display:'block'
                });
                me.jcrop_albums.css({
                    display:'none'
                });
            } else {
                me.jcrop_albums.css({
                    display:'block'
                });
                me.jcrop_albums2.css({
                    display:'none'
                });
            }
        });
    }

    this.change_image = function() {
        var me = this;
        var path=me.cont_photo.children("img:eq(4)").attr("maxsrc");
        var com=me.cont_photo.children("img:eq(4)").attr("com");
        var com2=me.cont_photo.children("img:eq(4)").attr("com2");
        var id=me.cont_photo.children("img:eq(4)").attr("id_ph");
        var txt=me.cont_photo.children("img:eq(4)").attr("alt");

        me.imagechange(path, com, com2, id, txt);
    }

    this.change_image2 = function(el, flag) {
        var me = this;
        me.indexPhoto=$(el).index();
        var path=$(el).attr("maxsrc");
        var com=$(el).attr("com");
        var com2=$(el).attr("com2");
        var id=$(el).attr("id_ph");
        var txt=$(el).attr("alt");

        me.imagechange(path, com, com2, id, txt);
        if (flag==1){
            me.open_modal("");
        }
    }

    this.valid_comment = function(el, num){
        var me = this;
        var str=el.value;
        var len=200-str.length;
        if (len<100) {
            var remain= me.numText(parseInt(len), ['Остался ', 'Осталось ', 'Осталось ']);
            var sign= me.numText(parseInt(len), [' знак', ' знака', ' знаков']);
            var out_str=remain+len+sign;
            me.cont_foto_change.children('div:eq('+num+')').children('div:eq(2)').html(out_str);
        } else {
            me.cont_foto_change.children('div:eq('+num+')').children('div:eq(2)').html('');
        }
    }

    this.auto_save = function(num, txt) {
        var me = this;
        var id= me.cont_foto_change.children('div:eq('+num+')').attr('id_ph');
        var data={
            id:id,
            txt:txt
        };
        this.post("photoalbums_setDescription", data, function(msg) {
            me.cont_foto_change.children('div:eq('+num+')').children('div:eq(1)').html("Описание сохранено.");
            var num2=0;
            for (var i=0;i<num;i++) {
                if  (me.cont_foto_change.children("div:eq("+i+")").children("div:eq(0)").attr('act')!='dis') {
                    num2++;
                }
            }
            me.masImage[num2].txt=txt;
        });
    }

    this.focus_input = function(el, num) {
        var me = this;
        me.cont_foto_change.children('div:eq('+num+')').children('div:eq(1)').html("Описание редактируеться...");
        me.valid_comment(el, num);
    }

    this.valid_description = function(el){
        var me=this;
        var str=el.value;
        var len=100-str.length;
        if (len<50) {
            var remain= me.numText(parseInt(len), ['Остался ', 'Осталось ', 'Осталось ']);
            var sign= me.numText(parseInt(len), [' знак', ' знака', ' знаков']);
            var out_str=remain+len+sign;
            $('#val_description_alb_edit').html(out_str);
        } else {
            $('#val_description_alb_edit').html('');
        }
    }

    this.auto_save_description = function(num) {
        var me = this;
        var id= me.masAlbums[me.numberAlbums_active].id;
        var data={
            name:$('#name_albums_change').val(),
            txt:$('#com_albums').val(),
            id:id
        };
        this.post("photoalbums_setAttrAlb", data, function(msg) {
            $('#description_alb_edit').html("Описание альбома сохранено.");
            $('#val_description_alb_edit').html('');
            me.masAlbums[me.numberAlbums_active].txt=data.txt;
            me.masAlbums[me.numberAlbums_active].name=data.name;
        });
    }

    this.focus_input_decription = function(el) {
        var me = this;
        $('#description_alb_edit').html("Описание альбома");
        me.valid_description(el);
    }

    this.valid_name = function(el){
        var me = this;
        var str=el.value;
        var len=27-str.length;

        if (len<14) {
            var remain= me.numText(parseInt(len), ['Остался ', 'Осталось ', 'Осталось ']);
            var sign= me.numText(parseInt(len), [' знак', ' знака', ' знаков']);
            var out_str=remain+len+sign;
            $('#val_name_alb_edit').html(out_str);
        } else {
            $('#val_name_alb_edit').html('');
        }
    }

    this.auto_save_name = function(num) {
        var me = this;
        var id= me.masAlbums[me.numberAlbums_active].id;
        var data={
            name:$('#name_albums_change').val(),
            txt:$('#com_albums').val(),
            id:id
        };
        this.post("photoalbums_setAttrAlb", data, function(msg) {
            $('#name_alb_edit').html("Название сохранено.");
            $('#val_name_alb_edit').html('');
            me.masAlbums[me.numberAlbums_active].txt=data.txt;
            me.masAlbums[me.numberAlbums_active].name=data.name;
        });
    }

    this.focus_input_name = function(el) {
        var me = this;
        $('#name_alb_edit').html("Название");
        me.valid_name(el);
    }

    this.open_window_cover = function(el) {
        var me = this;
        if (me.jcrop_api) me.jcrop_api.destroy();
        var id=$(el).attr('id_ph');
        $('#im_alboms').attr({
            src:$(el).attr('maxsrc'),
            id_ph: id
        });
        $('#preview_alb').attr({
            src:$(el).attr('maxsrc')
        });
        $('#exit1').click();
        me.open_modal(4);

        var updatePreview2 = function(c) {
            me.Coord=c;
            if (parseInt(c.w) > 0) {
                var rx = 200 / c.w;
                var ry = 135 / c.h;
                $('#preview_alb').css({
                    width: Math.round(rx * me.boundx) + 'px',
                    height: Math.round(ry * me.boundy) + 'px',
                    marginLeft: '-' + Math.round(rx * c.x) + 'px',
                    marginTop: '-' + Math.round(ry * c.y) + 'px'
                });
            }
        };

        $('#im_alboms').Jcrop({
            aspectRatio:1.48,
            onSelect: updatePreview2,
            onChange: updatePreview2
        },function(){
            var bounds = this.getBounds();
            me.boundx = bounds[0];
            me.boundy = bounds[1];
            me.jcrop_api = this;
            me.jcrop_api.setSelect([0,0,800,800]);
            me.jcrop_api.setOptions( {
                minSize: [ 198, 133 ]
            });
        });
    }

    this.del_photo = function(el) {
        var me = this;
        var num=$(el).parent().parent().index();
        var id= $(el).parent().parent().attr('id_ph');
        var oldHtml = $(el).html();
        $(el).html('<div style="color:red;">Удаляем</div>');
        var callback = function() {
            var tmp='';
            tmp+='<div act="dis" style="text-align:center;margin-top: 10px;font-size:12px;font-family:Arial;color:#666666">Фотография удалена.</div><div style="margin-top:20px;height:1px;width:540px;background:#BCCFDF;"></div>';

            me.cont_foto_change.children("div:eq("+num+")").html(tmp);
            me.cont_foto_change.children("div:eq("+num+")").animate({
                "height":"51px",
                "min-height":"0px",
                "margin-top":"0px"
            },500);

            for (var i=0; i<me.masImage.length; i++) {
                if (me.masImage[i].id==id) {
                    me.masImage.splice(i, 1);
                    me.masAlbums[me.numberAlbums_active].count_photo--;
                    if (me.masImage.length==0) break;
                    var el2;
                    if (i==(me.masImage.length)) {
                        id= me.masImage[me.masImage.length-1].id;
                        for (var j=0; j<me.cont_foto_change.children().length; j++) {
                            var t=me.cont_foto_change.children('div:eq('+j+')').attr('id_ph')
                            if (t==id) {
                                el2=me.cont_foto_change.children('div:eq('+j+')')
                            }
                        }
                        el2.children('div:eq(4)').children('div:eq(0)').children('font:eq(0)').html('');
                        el2.children('div:eq(4)').children('div:eq(0)').children('font:eq(1)').html('');
                    }

                    if (i==0) {
                        id= me.masImage[0].id;
                        for (j=0;j<me.cont_foto_change.children().length;j++) {
                            t=me.cont_foto_change.children('div:eq('+j+')').attr('id_ph')
                            if (t==id) {
                                el2=me.cont_foto_change.children('div:eq('+j+')')
                            }
                        }
                        el2.children('div:eq(4)').children('div:eq(0)').children('font:eq(2)').html('');
                        el2.children('div:eq(4)').children('div:eq(0)').children('font:eq(1)').html('');
                    }

                    if (me.masImage.length==1) {
                        id= me.masImage[0].id;
                        for (j=0;j<me.cont_foto_change.children().length;j++) {
                            t=me.cont_foto_change.children('div:eq('+j+')').attr('id_ph')
                            if (t==id) {
                                el2=me.cont_foto_change.children('div:eq('+j+')')
                            }
                        }
                        el2.children('div:eq(4)').children('div:eq(0)').children('font:eq(2)').html('');
                        el2.children('div:eq(4)').children('div:eq(0)').children('font:eq(1)').html('');
                        el2.children('div:eq(4)').children('div:eq(0)').children('font:eq(0)').html('');
                    }
                }
            }

            if (me.masImage.length==0) {
                me.masAlbums[me.numberAlbums_active].img=me.nophoto;
                me.albums_foto_change.attr({
                    'src':me.nophoto
                });
                me.setAlbumCover(me.nophoto);
            } else {
                me.setAlbumCover();
            }
            me.load_image(me.masImage);
        }
        me.post_del_photo(id, callback);
    }

    this.prov_url = function() {
        var me = this;
        var temp=me.location;
        if (temp==me.kod_url_prev) return;
        me.kod_url_prev=temp;
        var i=temp.length;

        while (temp[i]!='#' && temp[i]!="/" ) {
            i--;
        }
        if (temp[i]=="/") {
            me.albums_change.css({
                display:'none'
            });
            $('#albums').css({
                display:'block'
            });
            me.load_image(me.masImage);
            window.scroll(0,0);
        }
        var id="";
        var action=temp[i+1]+temp[i+2]+temp[i+3];
        var j;
        var num=0;
        if (action=="get") {
            for(j=i+7;j<temp.length;j++) {
                id+=temp[j];
            }
            for(var k=0; k<me.masAlbums.length; k++) {
                if (me.masAlbums[k].id==id) num=k;
            }
            var len = me.masAlbums.length-1;
            for (k=0;k<(len-num+1);k++) {
                var tmp=me.masAlbums[len];
                me.masAlbums.pop();
                me.masAlbums.unshift(tmp);
            }
            me.albums_change.css({
                display:'none'
            });
            $('#albums').css({
                display:'block'
            });
            me.load_albums(me.masAlbums);
            me.numberAlbums_active=0;
            me.albums_lenta.css({
                'marginLeft':'0px'
            })
            me.load_image(me.masImage);
            window.scroll(0,0);
        } else if (action=="set") {
            for(j=i+7; j<temp.length; j++) {
                id+=temp[j];
            }
            for(k=0; k<me.masAlbums.length; k++) {
                if (me.masAlbums[k].id==id) num=k;
            }
            len= me.masAlbums.length-1;
            for (k=0;k<(len-num+1);k++) {
                tmp=me.masAlbums[len];
                me.masAlbums.pop();
                me.masAlbums.unshift(tmp);
            }
            me.load_albums(me.masAlbums);
            me.numberAlbums_active=0;
            $('.change_album_btn').click();
        }
    }

    this.vverh = function(el) {
        var me = this;
        var el1=$(el).parent().parent().parent();
        var id1=parseInt($(el).parent().parent().parent().attr('id_ph'));
        var id2="";
        var t;
        for (var i=0;i<me.masImage.length;i++) {
            if (me.masImage[i].id==id1) {
                id2=me.masImage[i-1].id;
                t=me.masImage[i];
                me.masImage[i]=me.masImage[i-1];
                me.masImage[i-1]=t;
                break;
            }
        }
        var el2;
        for (i=0;i<me.cont_foto_change.children().length;i++) {
            t=me.cont_foto_change.children('div:eq('+i+')').attr('id_ph')
            if (t==id2) {
                el2=me.cont_foto_change.children('div:eq('+i+')')
            }
        }
        t=el1.html();
        el1.html(el2.html());
        el2.html(t);
        t=el1.children('div:eq(4)').html();
        el1.children('div:eq(4)').html(el2.children('div:eq(4)').html());
        el2.children('div:eq(4)').html(t);
        el1.attr({
            'id_ph':id2
        });
        el2.attr({
            'id_ph':id1
        });
        me.changePrivilege(id1, id2);
    }

    this.vniz = function(el){
        var me = this;
        var el1=$(el).parent().parent().parent();
        var id1=parseInt($(el).parent().parent().parent().attr('id_ph'));
        var id2="";
        var t;
        for (var i=0;i<me.masImage.length;i++) {
            if (me.masImage[i].id==id1) {
                id2=me.masImage[i+1].id;
                t=me.masImage[i];
                me.masImage[i]=me.masImage[i+1];
                me.masImage[i+1]=t;
                break;
            }
        }
        var el2;
        for (i=0;i<me.cont_foto_change.children().length;i++) {
            t=me.cont_foto_change.children('div:eq('+i+')').attr('id_ph')
            if (t==id2) {
                el2=me.cont_foto_change.children('div:eq('+i+')')
            }
        }
        t=el1.html();
        el1.html(el2.html());
        el2.html(t);
        t=el1.children('div:eq(4)').html();
        el1.children('div:eq(4)').html(el2.children('div:eq(4)').html());
        el2.children('div:eq(4)').html(t);
        el1.attr({
            'id_ph':id2
        });
        el2.attr({
            'id_ph':id1
        });
        me.changePrivilege(id1, id2);
    }

    this.fr_del_photo = function(id, el) {
        var me = this;
        var data={
            id:id
        };
        this.post("photoalbums_delPhoto", data, function(msg) {
            el.location.href = '/frame?id='+me.masAlbums[me.numberAlbums_active].id;
            me.prov_url();
        });
    }

    this.fr_auto_save = function(el, num) {
        var me = this;
        var txt=el.$('.coment_input').val();
        var id=num;
        el.img.txt=txt;
        var data={
            id:id,
            txt:txt
        };
        this.post("photoalbums_setDescription", data, function(msg) {
            el.$('#label1').html("Описание сохранено.");
        });
    }

    this.fr_focus_input = function(el) {
        var me = this;
        el.$('#label1').html("Описание редактируеться...");
        me.fr_valid_comment(el)
    }

    this.fr_valid_comment = function(el){
        var me = this;
        var str=el.$('.coment_input').val();
        var len=200-str.length;
        if (len<100) {
            var remain= me.numText(parseInt(len), ['Остался ', 'Осталось ', 'Осталось ']);
            var sign= me.numText(parseInt(len), [' знак', ' знака', ' знаков']);
            var out_str=remain+len+sign;
            el.$('.valid_input').html(out_str);
        } else {
            el.$('.valid_input').html('');
        }
    }

    this.countPhotoUpdate = function() {
        var me = this;
        me.masAlbums[me.numberAlbums_active].count_photo = me.masImage.length;
        if(!me.masAlbums[me.numberAlbums_active].img || me.masAlbums[me.numberAlbums_active].img == me.nophoto){
            var firstImgAdr = me.masImage[0].img;
            var mass = firstImgAdr.split('/');
            var fmass = mass.splice(0, mass.length-1);
            var folder = fmass.join('/');
            me.masAlbums[me.numberAlbums_active].img = folder+'/'+me.masAlbums[me.numberAlbums_active].id+'.jpg?mt='+(new Date().getTime());
            me.setAlbumCover(me.masAlbums[me.numberAlbums_active].img);
        }
        me.setAlbumCover();
    }

    this.get_somephoto = function() {
        var me = this;
        this.post("photoalbums_getSomephoto", null, function(msg) {
            me.load_image(msg);
        });
    }

    this.initObjects = function() {
        var me = this;
        me.cont_photo = $('#cont_photo');
        me.albums_lenta = $('#albums_lenta');
        me.albums_foto_change = $('#albums_foto_change');
        me.prev_photo = $('#prev_photo');
        me.next_photo = $('#next_photo');
        me.image_modal = $('#image_modal');
        me.cont_photo_img = $('#cont_photo img');
        me.cont_foto_change = $('#cont_foto_change');
        me.next_foto_modal2 = $('#next_foto_modal2');
        me.prev_foto_modal2 = $('#prev_foto_modal2');
        me.jcrop_albums2 = $('#jcrop_albums2');
        me.jcrop_albums = $('#jcrop_albums');
        me.jcrop_ava = $('#jcrop_ava');
        me.jcrop_ava2 = $('#jcrop_ava2');
        me.albums_change = $('#albums_change');
        me.comment_users = $('#comment_users');
        me.txt_image = $('#txt_image');
        me.im = $('#im');

        me.myModal = [];
        me.myModal[""] = $('#myModal');
        me.myModal["Error"] = $('#myModalError');
        for(var i=0; i<13; i++){
            me.myModal[i] = $('#myModal'+i);
        }
    }

    this.initStart = function() {
        var me = this;
        me.initObjects();

        $('.close-reveal-modal ').click(function(){
            $('.close-reveal-modal ').parent().css('visibility','hidden');
            $('.reveal-modal-bg').css('display','none');
        });

        $('#back_albums').click(function(){
            me.location="#get&id"+me.masAlbums[me.numberAlbums_active].id;
            me.prov_url();
            me.albums_change.css({
                display:'none'
            });
            $('#albums').css({
                display:'block'
            });
            me.load_image(me.masImage);
            window.scroll(0,0);
        });

        $('#back_albums2').click(function(){
            $('#back_albums').click();
        })

        me.jcrop_ava.click(function(){
            var srcAva=me.im.attr('src');
            var id=me.im.attr('id_ph');
            $('#im_ava1').attr({
                src:srcAva,
                id_ph:id
            });
            $('#preview').attr({
                src:srcAva
            });
            if (me.jcrop_api) me.jcrop_api.destroy();
            $('#exit1').click();
            me.open_modal(3);

            var updatePreview = function(c) {
                me.Coord.x=c.x;
                me.Coord.y=c.y;
                me.Coord.w=c.w;
                me.Coord.h=c.h;
                if (parseInt(c.w) > 0) {
                    var rx = 200 / c.w;
                    var ry = 300 / c.h;

                    $('#preview').css({
                        width: Math.round(rx * me.boundx) + 'px',
                        height: Math.round(ry * me.boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * c.x) + 'px',
                        marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
                }
            };

            $('#im_ava1').Jcrop({
                aspectRatio:0.66,
                onSelect: updatePreview,
                onChange: updatePreview
            },function(){
                var bounds = this.getBounds();
                me.boundx = bounds[0];
                me.boundy = bounds[1];
                me.jcrop_api = this;
                me.jcrop_api.setSelect([0,0,800,800]);
                me.jcrop_api.setOptions( {
                    minSize: [ 198, 298 ]
                });
            });
        });

        me.jcrop_albums.click(function(src_enter){
            if (me.jcrop_api) me.jcrop_api.destroy();
            var srcAlb=me.im.attr('src');
            var id=me.im.attr('id_ph');
            $('#im_alboms').attr({
                src:srcAlb,
                id_ph:id
            });
            $('#preview_alb').attr({
                src:srcAlb
            });
            $('#exit1').click();
            me.open_modal(4);

            var updatePreview2 = function(c) {
                me.Coord.x=c.x;
                me.Coord.y=c.y;
                me.Coord.w=c.w;
                me.Coord.h=c.h;
                if (parseInt(c.w) > 0) {
                    var rx = 200 / c.w;
                    var ry = 135 / c.h;

                    $('#preview_alb').css({
                        width: Math.round(rx * me.boundx) + 'px',
                        height: Math.round(ry * me.boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * c.x) + 'px',
                        marginTop: '-' + Math.round(ry * c.y) + 'px'
                    });
                }
            };

            $('#im_alboms').Jcrop({
                aspectRatio:1.48,
                onSelect: updatePreview2,
                onChange: updatePreview2
            },function(){
                var bounds = this.getBounds();
                me.boundx = bounds[0];
                me.boundy = bounds[1];
                me.jcrop_api = this;
                me.jcrop_api.setSelect([0,0,800,800]);
                me.jcrop_api.setOptions( {
                    minSize: [ 198, 133 ]
                });
            });
        });

        $('#save_ava').click(function(){
            me.set_ava($('#im_ava1').attr('id_ph'));
        });

        $('.close-reveal-modal').click(function() {
            $('#button_loadUploader').css({
                visibility:'hidden'
            });
            $('#button_load2Uploader').css({
                visibility:'hidden'
            });
            $(document).unbind('keyup');
        });

        $('#myModal').children("img:eq(0)").click(function(){
            $('#next_foto_modal').click();
        });

        var totalError = [];

        var loadErrorProcess = function() {
            var errors = {
                type: 0,
                size: 0,
                limit: 0
            };
            for(var i=0; i<totalError.length; i++){
                errors[totalError[i]]++;
            }
            var all = errors.type + errors.size + errors.limit;
            var one = (errors.type ? 1:0) + (errors.size ? 1:0) + (errors.limit ? 1:0);
            var f = me.numText(all, [' файл', ' файла', ' файлов']);
            var text = 'Не удалось загрузить '+all + f;
            if(one==1){
                text += errors.type ? ' из-за неверного типа' : 
                (errors.size ? ' из-за превышения максимального размера' :
                    ' из-за ограничения вместимости альбома');
            } else {
                text += ': </br><ul>';
                if(errors.type){
                    text += '<li>'+errors.type+' из-за неверного типа</li>'
                }
                if(errors.size){
                    text += '<li>'+errors.size+' из-за превышения максимального размера</li>'
                }
                if(errors.limit){
                    text += '<li>'+errors.limit+' из-за ограничения вместимости альбома</li>'
                }
                text += '</ul>';
            }
            $('#myModalError_text').html(text);
            me.open_modal('Error');
        }

        $("#button_load").uploadify({
            'uploader'       : 'plugins/uploadify/uploadify.swf',
            'script'         : '/upload?'+document.cookie.match(/session=[^;]+/),
            'cancelImg'      : 'cancel.png',
            'queueID'        : 'fileQueue',
            'auto'           : true,
            'multi'          : true,
            'fileDesc'       : '.jpg , gif',
            'fileExt'        : '*.jpg; *.gif; ',
            'simUploadLimit' : 1,
            'buttonText'     : 'File',
            'buttonImg'      : 'resource/button_load.png',
            'width' : 194,
            'height' : 30,
            onSelect: function(event, queueID, fileObj) {
                $('#close_window_load_img').click();
                me.open_modal(6);
                $("#count_load").html('0');
                $("#count_load_label").html(' фотографий');
                $("#count_load_label2").html("Загружено");
            },
            onComplete: function(event, queueID, fileObj, response, data) {
                if(response.substring(0, 5)=='error'){
                    totalError.push(response.substring(6));
                } else {
                    var  tmp= eval('(' + (response + '') + ')');
                    var cl = $("#count_load");
                    var kol=parseInt(cl.html())+1;
                    cl.html(kol);
                    var label1 = me.numText(parseInt(kol), ['Загружена', 'Загружено', 'Загружено']);
                    var okonchanie = me.numText(parseInt(kol), ['фотография.', 'фотографии.', 'фотографий.']);

                    $("#count_load_label").html(' '+okonchanie);
                    $("#count_load_label2").html(label1);
                    me.masImage.unshift(tmp);
                }
            },
            onAllComplete:function(event, queueID, fileObj, response, data){
                var active = me.numberAlbums_active;
                $('#close_load_image').click();
                me.load_image(me.masImage);
                me.numberAlbums_active = active;
                me.countPhotoUpdate();
                $('.change_album_btn').click();
                totalError.length && loadErrorProcess();
                totalError = [];
            }
        });

        $('#next_albums').click(function() {
            if (me.bl_alb>0) return;
            me.bl_alb++;
            me.numberAlbums_active++;
            if (me.numberAlbums_active>=me.masAlbums.length) me.numberAlbums_active-=me.masAlbums.length;
            if (me.albums_lenta.children().length<2) return;
            var m_l=parseInt(me.albums_lenta.css('marginLeft'));
            if (m_l<0) {
                me.albums_lenta.children("div:eq(0)").detach().appendTo('#albums_lenta');
                me.albums_lenta.css({
                    'marginLeft':'0px'
                });
            }

            me.albums_lenta.animate({
                'margin-left':'-=473px'
            }, 500);

            me.get_photo(me.masAlbums[me.numberAlbums_active].id);
            var timeout_id = window.setTimeout(function(){
                me.bl_alb--;
            },500)
        });

        $('#prev_albums').click(function() {
            if (me.bl_alb>0) return;
            me.bl_alb++;
            me.numberAlbums_active--;
            if (me.numberAlbums_active<0) me.numberAlbums_active+=me.masAlbums.length;
            var l=me.albums_lenta.children().length-1;
            if (l<1) return;
            if (me.albums_lenta.css('margin-left')=='0px') {
                me.albums_lenta.children("div:eq("+l+")").detach().prependTo('#albums_lenta');
                me.albums_lenta.css({
                    'marginLeft':'-473px'
                });
                me.albums_lenta.animate({
                    'margin-left':'+=473px'
                }, 500);
            } else {
                me.albums_lenta.animate({
                    'margin-left':'+=473px'
                }, 500);
            }

            me.get_photo(me.masAlbums[me.numberAlbums_active].id);
            var timeout_id = window.setTimeout(function(){
                me.bl_alb--;
            },500);
        });

        $('#close_btn_ava').click(function() {
            $('#exit2').click();
        });

        $('#close_btn_alb').click(function() {
            $('#close_alb').click();
        });

        $('#image_modal').click(function() {
            me.next_foto_modal2.click();
        });

        $('#btn_close_mini_ava').click(function() {
            $('#close_miniava').click();
        });

        $('#save_btn_mini_ava').click(function() {
            me.set_mini_ava();
        });

        $('#save_btn_album').click(function() {
            me.set_cover($('#im_alboms').attr('id_ph'));
            $('#close_alb').click();
        });

        $('#btn_del_alb').click(function() {
            me.open_modal(7);
            //var len=me.cont_foto_change.children().length;
            var len = me.masImage.length;
            $('#kol_photo').html(len);
            if (len<=10) $('#alb_del_ram').css({
                backgroundImage:'url(resource/frame_alb1.png)'
            });
            if (len>10) $('#alb_del_ram').css({
                backgroundImage:'url(resource/frame_alb2.png)'
            });
            if (len>20) $('#alb_del_ram').css({
                backgroundImage:'url(resource/frame_alb3.png)'
            });
            var name=document.getElementById('name_albums_change').value;
            $('#name_del').html('«'+name+'»');
            var srcAlb=me.albums_foto_change.attr('src');
            $('#alb_del_img').attr({
                src:srcAlb
            });
            $('#cancel_del').unbind('click');
            $('#cancel_del').click(function(){
                $('#close_del_alb').click();
            });
            $('#del_btn_mod').unbind('click');
            $('#del_btn_mod').click(function(){
                me.del_albums();
            });
        });

        $('#add_photo_p2').click(function() {
            me.open_modal(2);
            var data={
                'id':me.masAlbums[me.numberAlbums_active].id,
                'type':'photo'
            };
            $("#button_load").uploadifySettings('scriptData' ,data);
            $('#button_loadUploader').css({
                visibility:'visible'
            });
        });

        $('#change_cover').click(function(){
            me.open_modal(10);
            var len=me.masImage.length;
            if(len<4){
                $('#prev_cover_modal2').hide();
                $('#next_cover_modal2').hide();
                $('#prev_cover_modal').hide();
                $('#next_cover_modal').hide();
            } else {
                $('#prev_cover_modal2').show();
                $('#next_cover_modal2').show();
                $('#prev_cover_modal').show();
                $('#next_cover_modal').show();
            }
            var temp="";
            for (var i=0;i<len;i++) {
                temp+="<div style='width:200px;height:200px;float:left;'>" +
                "<img onclick=\"myphoto.open_window_cover(this)\" src="+me.masImage[i].minimg+" maxsrc="+me.masImage[i].img+" id_ph='"+me.masImage[i].id+"' style='margin-left:10px;cursor:pointer;padding:4px;border: 1px solid #999;-webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;box-shadow: 0px 0px 5px #CCC;' /></div>"
            }
            $('#cont_cover').html(temp);
            i=0;
            var flag = len<6 ? 1 : 2;
            for (var j=0; j<flag; j++) {
                var w, h, m_t;
                while(i<len) {
                    h=$('#cont_cover').children('div:eq('+i+')').children('img:eq(0)').height();
                    w=$('#cont_cover').children('div:eq('+i+')').children('img:eq(0)').width();
                    if (w<198 || h<133) {
                        $('#cont_cover').children('div:eq('+i+')').detach();
                        i--;
                        len--;
                    } else {
                        $('#cont_cover').children('div:eq('+i+')').children('img:eq(0)').css({
                            maxWidth:'170px'
                        });
                        $('#cont_cover').children('div:eq('+i+')').children('img:eq(0)').css({
                            maxHeight:'170px'
                        });
                        h=$('#cont_cover').children('div:eq('+i+')').children('img:eq(0)').height();
                        m_t=170-h;
                        m_t/=2;
                        $('#cont_cover').children('div:eq('+i+')').children('img:eq(0)').css({
                            'margin-top':m_t+'px'
                        });
                    }
                    i++;
                }
            }
            var m_obl=(screen.width-660)/2;
            m_obl-=9;
            m_t=parseInt($('#myModal10').css('top'))*(-1);
            $('#next_cover_modal2').css({
                'right':'-'+m_obl+'px',
                'width':m_obl+'px',
                'top':m_t+'px'
            });
            $('#prev_cover_modal2').css({
                'left':'-'+m_obl+'px',
                'width':m_obl+'px',
                'top':m_t+'px'
            });
        });

        $('#altern_down').click(function(){
            $('#close_window_load_img').click();
            me.open_modal(9);
            $('#frame1').attr({
                'src':'/frame?id='+me.masAlbums[me.numberAlbums_active].id
            });
            $('#frame2').attr({
                'src':'/frame?id='+me.masAlbums[me.numberAlbums_active].id
            });
            $('#frame3').attr({
                'src':'/frame?id='+me.masAlbums[me.numberAlbums_active].id
            });
            $('#frame4').attr({
                'src':'/frame?id='+me.masAlbums[me.numberAlbums_active].id
            });

            $('#alter_down2').click(function(){
                $('#close_window_load_img_st').click();
                $('.add_image').click();
            });
        });

        $('#photoalbums').click(function() {
            $('#back_albums').click();
        });

        $('#close_window_load_img_st').click(function() {
            var check = frame1.img || frame2.img || frame3.img || frame4.img;
            if(check) {
                if (frame1.img!=null) {
                    me.masImage.unshift(frame1.img)
                }
                if (frame2.img!=null) {
                    me.masImage.unshift(frame2.img)
                }
                if (frame3.img!=null) {
                    me.masImage.unshift(frame3.img)
                }
                if (frame4.img!=null) {
                    me.masImage.unshift(frame4.img)
                }
                $('.change_album_btn').click();
                $('#frame1').attr({
                    'src':'/frame'
                });
                $('#frame2').attr({
                    'src':'/frame'
                });
                $('#frame3').attr({
                    'src':'/frame'
                });
                $('#frame4').attr({
                    'src':'/frame'
                });
                me.countPhotoUpdate();
            }
        });

        $('#modal9_save').click(function() {
            $('#close_window_load_img_st').click();
        });

        $('#next_cover_modal2').click(function() {
            if (me.bl_cover>0) return;
            me.bl_cover++;

            var l = $('#cont_cover').children().length;
            if (l<4) return;
            var m_l=parseInt($('#cont_cover').css('left'));

            if (-(m_l-1200) >= l*200) {
                $('#cont_cover').children("div:eq(0)").detach().appendTo('#cont_cover');
                $('#cont_cover').children("div:eq(0)").detach().appendTo('#cont_cover');
                $('#cont_cover').children("div:eq(0)").detach().appendTo('#cont_cover');
                $('#cont_cover').animate({
                    'left':'+=600px'
                }, 0);
            }

            $('#cont_cover').animate({
                'left':'-=600px'
            }, 500);
            var timeout_id = window.setTimeout(function(){
                me.bl_cover--;
            },500)
        });

        $('#prev_cover_modal2').click(function() {
            if (me.bl_cover>0) return;
            me.bl_cover++;

            var l=$('#cont_cover').children().length-1;
            if (l<3) return;
            var m_l=parseInt($('#cont_cover').css('left'));
            if (m_l==0) {
                $('#cont_cover').children("div:eq("+l+")").detach().prependTo('#cont_cover');
                $('#cont_cover').children("div:eq("+l+")").detach().prependTo('#cont_cover');
                $('#cont_cover').children("div:eq("+l+")").detach().prependTo('#cont_cover');
                $('#cont_cover').css({
                    'left':'-600px'
                });
                $('#cont_cover').animate({
                    'left':'+=600px'
                }, 500);
            } else {
                $('#cont_cover').animate({
                    'left':'+=600px'
                }, 500);
            }
            var timeout_id = window.setTimeout(function(){
                me.bl_cover--;
            },500);
        });

        $('#cancel_cover').click(function() {
            $('#close_window_create_cover').click();
        });
        $('#prev_cover_modal').click(function() {
            $('#prev_cover_modal2').click()
        });
        $('#next_cover_modal').click(function() {
            $('#next_cover_modal2').click()
        });
        $('#prev_foto_modal').click(function() {
            me.prev_foto_modal2.click()
        });
        $('#next_foto_modal').click(function() {
            me.next_foto_modal2.click()
        });

        $('#noalbom').click(function() {
            $('#new_albums').click();
            $('#noalbom').css({
                display:'none'
            });
            $('#albums').css({
                visibility:'visible'
            });
        });
        $('#cancel_error').click(function() {
            $('#close_load_image_error_number').click();
        });
        $('#button_loadUploader').css({
            visibility:'hidden'
        });
        me.init();
    }

    this.init = function() {
        var me = this;
        me.get_albums();
    }
}

Sputnikalbums = function() {
    var pa = new Photoalbums();
    for(var f in pa) {
        this[f] = pa[f];
    }
    //this[this.__proto__ ? '__proto__' : 'prototype'] = new Photoalbums();

    this.nophoto_img = '/resource/nophoto_1.jpg';
    this.addsphotos_img  = '/resource/addsphotos_1.png';

    this.getAlbumTpl = function(mas) {
        var me = this;
        var temp='', okonchanie;
        var l = mas.length;
        for (var i=0;i<l;i++) {
            okonchanie= me.numText(parseInt(mas[i].count_photo), ['фотография', 'фотографии', 'фотографий']);

            if (mas[i].count_photo==0) {
                mas[i].img=me.nophoto;
            }

            var str_ram ='';
            if (mas[i].count_photo<=10) {
                str_ram='resource/frame_alb1.png'
            }   //зависимость рамки от количества фоток
            if (mas[i].count_photo>10) {
                str_ram='resource/frame_alb2.png'
            }
            if (mas[i].count_photo>20) {
                str_ram='resource/frame_alb3.png'
            }

            temp+='<div id="album" ><div class="ten_albums" style="background-image:url('+str_ram+')" >';
            temp+='<img class="albums_foto" src="'+mas[i].img+'" style="margin-left:21px;margin-top:18px;width:200px;height:135px;"/></div>';
            temp+='<div style="float:left;width:210px;height:170px;margin-left:20px;">';
            temp+='<div id="name_albums" >'+mas[i].name+'</div>';
            temp+='<div id="count_photo" >('+mas[i].count_photo+' '+okonchanie+')</div>';
            temp+='<div id="txt_albums" >'+mas[i].txt+'</div>';
            temp+='<div style="line-height:145%;margin-top:20px;font-family:Arial;font-size:10px;color:#B2B2B2;font-weight:normal;">';
            temp+='<font style="font-weight:bold">Создан </font>'+mas[i].date_create+' <br>';
            temp+='<font style="font-weight:bold">Обновлен </font>'+mas[i].date_update+'<br></div>';
            temp+='</div></div>';
        }

        return temp;
    }

    this.initStart = function() {
        var me = this;
        me.initObjects();

        $('#ponravilos').click(function(){
            if ($('#spisok_ponravilos').height()==0) {
                $('#spisok_ponravilos').animate({
                    "height":"160px"
                },500);
                $('#spisok_ponravilos').css({
                    border:'1px solid #999999'
                });
                $('#spisok_ponravilos').css({
                    borderTop :'0px solid #999999'
                });
            } else {
                $('#spisok_ponravilos').animate({
                    "height":"0px"
                },500);
                var t = setTimeout(function(){
                    $('#spisok_ponravilos').css({
                        border:'0px solid #999999'
                    });
                }, 500);
            }
        });

        $('.ponravilos_btn').click(function(){
            var temp=$(this).html();
            var t1="<font style='background-image:url(../resource/serdce.png);background-repeat:no-repeat;padding-left:15px;background-position: left 3px;margin-right:4px;font-weight: bold;'>Вам нравиться:</font>";
            temp=t1+temp;

            me.comment_users.html(temp);
            var id=$('#im').attr('id_ph');
            var data=new Object();
            data.id=id;
            data.com=temp;

            me.post('photoalbums_changePrivilege', data);
            $('#ponravilos').click();
        });

        $('#myModal').children("img:eq(0)").click(function(){
            $('#next_foto_modal').click();
        });

        $('#next_albums').click(function() {
            if (me.bl_alb>0) return;
            me.bl_alb++;
            me.numberAlbums_active++;
            if (me.numberAlbums_active>=me.masAlbums.length) me.numberAlbums_active-=me.masAlbums.length;
            if (me.albums_lenta.children().length<2) return;
            var m_l=parseInt(me.albums_lenta.css('marginLeft'));
            if (m_l<0) {
                me.albums_lenta.children("div:eq(0)").detach().appendTo('#albums_lenta');
                me.albums_lenta.css({
                    'marginLeft':'0px'
                });
            }

            me.albums_lenta.animate({
                'margin-left':'-=473px'
            }, 500);

            me.get_photo(me.masAlbums[me.numberAlbums_active].id);
            var timeout_id = window.setTimeout(function(){
                me.bl_alb--;
            },500)
        });

        $('#prev_albums').click(function() {
            if (me.bl_alb>0) return;
            me.bl_alb++;
            me.numberAlbums_active--;
            if (me.numberAlbums_active<0) me.numberAlbums_active+=me.masAlbums.length;
            var l=me.albums_lenta.children().length-1;
            if (l<1) return;
            if (me.albums_lenta.css('margin-left')=='0px') {
                me.albums_lenta.children("div:eq("+l+")").detach().prependTo('#albums_lenta');
                me.albums_lenta.css({
                    'marginLeft':'-473px'
                });
                me.albums_lenta.animate({
                    'margin-left':'+=473px'
                }, 500);
            } else {
                me.albums_lenta.animate({
                    'margin-left':'+=473px'
                }, 500);
            }

            me.get_photo(me.masAlbums[me.numberAlbums_active].id);
            var timeout_id = window.setTimeout(function(){
                me.bl_alb--;
            },500);
        });

        $('#button_loadUploader').css({
            visibility:'hidden'
        });
        $('#image_modal').click(function() {
            $('#next_foto_modal2').click();
        })
        $('#photoalbums').click(function() {
            $('#back_albums').click();
        });
        $('#prev_foto_modal').click(function() {
            $('#prev_foto_modal2').click()
        });
        $('#cancel_error').click(function() {
            $('#close_load_image_error_number').click();
        });
        $('.close-reveal-modal ').click(function(){
            $('.close-reveal-modal ').parent().css('visibility','hidden');
            $('.reveal-modal-bg').css('display','none');
        });
        $('.close-reveal-modal').click(function() {
            $(document).unbind('keyup');
        });

        me.init();
    }

    this.init = function() {
        var me = this;
        me.get_albums();
    }
}

MySomePhoto = function() {
    var pa = new Photoalbums();
    for(var f in pa) {
        this[f] = pa[f];
    }

    this.nophoto_img = '/resource/nophoto_2.jpg';

    this.initStart = function() {
        var me = this;
        me.initObjects();

        $('.close-reveal-modal ').click(function(){
            $('.close-reveal-modal ').parent().css('visibility','hidden');
            $('.reveal-modal-bg').css('display','none');
        });

        $('.close-reveal-modal').click(function() {
            $(document).unbind('keyup');
        });

        $('#myModal').children("img:eq(0)").click(function(){
            $('#next_foto_modal').click();
        });

        $('#image_modal').click(function() {
            me.next_foto_modal2.click();
        });

        $('#photoalbums').click(function() {
            $('#back_albums').click();
        });

        $('#prev_foto_modal').click(function() {
            me.prev_foto_modal2.click()
        });
        $('#next_foto_modal').click(function() {
            me.next_foto_modal2.click()
        });

        $('#cancel_error').click(function() {
            $('#close_load_image_error_number').click();
        });
        me.init();
    }

    this.init = function() {
        var me = this;
        me.get_somephoto();
    }
}

SputnikSomePhoto = function() {
    var pa = new Sputnikalbums();
    for(var f in pa) {
        this[f] = pa[f];
    }

    this.initStart = function() {
        var me = this;
        me.initObjects();

        $('#ponravilos').click(function(){
            if ($('#spisok_ponravilos').height()==0) {
                $('#spisok_ponravilos').animate({
                    "height":"160px"
                },500);
                $('#spisok_ponravilos').css({
                    border:'1px solid #999999'
                });
                $('#spisok_ponravilos').css({
                    borderTop :'0px solid #999999'
                });
            } else {
                $('#spisok_ponravilos').animate({
                    "height":"0px"
                },500);
                var t = setTimeout(function(){
                    $('#spisok_ponravilos').css({
                        border:'0px solid #999999'
                    });
                }, 500);
            }
        });

        $('.ponravilos_btn').click(function(){
            var temp=$(this).html();
            var t1="<font style='background-image:url(../resource/serdce.png);background-repeat:no-repeat;padding-left:15px;background-position: left 3px;margin-right:4px;font-weight: bold;'>Вам нравиться:</font>";
            temp=t1+temp;

            me.comment_users.html(temp);
            var id=$('#im').attr('id_ph');
            var data=new Object();
            data.id=id;
            data.com=temp;

            me.post('photoalbums_changePrivilege', data);
            $('#ponravilos').click();
        });

        $('#myModal').children("img:eq(0)").click(function(){
            $('#next_foto_modal').click();
        });

        $('#image_modal').click(function() {
            $('#next_foto_modal2').click();
        })

        $('#prev_foto_modal').click(function() {
            $('#prev_foto_modal2').click()
        });

        $('#cancel_error').click(function() {
            $('#close_load_image_error_number').click();
        });

        $('.close-reveal-modal ').click(function(){
            $('.close-reveal-modal ').parent().css('visibility','hidden');
            $('.reveal-modal-bg').css('display','none');
        });
        $('.close-reveal-modal').click(function() {
            $(document).unbind('keyup');
        });

        me.init();
    }

    this.init = function() {
        var me = this;
        me.get_somephoto();
    }
}
