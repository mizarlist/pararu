<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script type="text/javascript" src="http://pararubversia.ru/js/jquery.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/photoalbums.css" media="screen" />
    </head>

    <style>
        .cancel_load_std
        {
            float:right;
            font-family: Arial;
            font-size: 12px;
            color:#3366CC;
            text-decoration: underline;
            margin-top: -30px;
            cursor:pointer;
        }
    </style>
    <body>
        <div align="center" style="display:none;width:492px;height:97px;">
            <div style="margin-top:35px;width:48px;height:48px;background-image: url('http://pararubversia.ru/images/ajax.gif')"></div>
            <div class="cancel_load_std" >Отмена</div>
        </div>
        <div align="center" style="width:492px;height:40px;background:white;">
            <form id="alt_form" method="POST" action="/upload" enctype="multipart/form-data"  style="margin-top:45px;" >
                <input type="file" accept="image/jpeg,image/gif" class="upl" name="upl1" width="194" height="30"/>
                <INPUT TYPE=HIDDEN NAME=id VALUE=<?php echo $id; ?> />
            </form>
        </div>

        <script type="text/javascript">
            $('.upl').change(function()
            {


                $(this).parent().parent().parent().children('div:eq(0)').css({display:'block'});
                $(this).parent().parent().parent().children('div:eq(1)').css({display:'none'});
                $(this).parent().submit();


            })

            $('.cancel_load_std').click(function()
            {
                document.location.href = document.location.href;
            });
        </script>
    </body>
</html>