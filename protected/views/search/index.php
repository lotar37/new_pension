<script>
$(function() {
   console.log(134);
        $.ajax({
            url: './search/getModelAttributes',
            //async: true,
            type: 'GET',
            //data: {},
           // processData: true,
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            success: function (data) {
               // arr = $.parseJSON(data);
                console.log(111111111);
                data.each(function(model,index){
                    console.log(model);
                });
                //$("#content").html("121231231231");
            }
        });
});
</script>
<div id="content">4444444444444444444</div>
<?php

/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.11.2015
 * Time: 17:39
 */
