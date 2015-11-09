<script>
    $.ajax({
        url : './search/getModelAttributes',
        async : true,
        type : 'GET',
        data : {
        },
        processData : true,
        contentType : 'application/x-www-form-urlencoded',
        dataType : 'json',
        success: function (data, textStatus) {
            console.log(data);
        }
    });

</script>

<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 09.11.2015
 * Time: 17:39
 */
