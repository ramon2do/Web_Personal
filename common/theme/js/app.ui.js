/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Modulo encargado de interaccion en interfaz
 */
$APP.UI = (function() {

    function init()
    {
        console.log('Init APP JS');
        _initDataTable();
        _setCompanyCode();
        _previewAvatar();
        _showModal();
    }
    
    function _initDataTable()
    {
        var table = $("table#dataTable");
        if(table.find("div.empty").html() != 'No results found.')
        {
            table.dataTable();
        }
    }
    
    function _setCompanyCode()
    {
        var ambit = $('select#company_type-list_sector');
        var activity = $('select#company_type-list_activity');
        var geoambit = $('select#company_type-list_geoambit');
        var code = $('input#company-code');

        ambit.on('change', function(){
            var value_ambit = $(this).val();
            if(activity.val() != '' && geoambit.val() != '')
            {
                if(value_ambit != '')
                {code.val(value_ambit.toUpperCase()+'.'+code.val().slice(5));}else{code.val('   .'+code.val().slice(5));}
            }else
            {
                if(value_ambit != '')
                {code.val(value_ambit.toUpperCase()+'.'+code.val().slice(5));}else{code.val('');}
            }
        });
        
        activity.on('change', function(){
            var value_activity = $(this).val();
            if(ambit.val() != '')
            {
                if(value_activity != '')
                {code.val(code.val().slice(0,5)+value_activity.toUpperCase()+'.'+code.val().slice(10));}else{code.val(code.val().slice(0,5)+'');}
            }
            else{code.val(code.val().slice(0,5)+'');}
        });
        
        geoambit.on('change', function(){
            var value_geoambit = $(this).val();
            var value_number = $('input#company-code_number').val();
            if(ambit.val() != '' && activity.val() != '')
            {
                if(value_geoambit != '')
                {code.val(code.val().slice(0,10)+value_geoambit.toUpperCase()+'#'+value_number);}else{code.val(code.val().slice(0,10)+'');}
            }
            else{code.val(code.val().slice(0,10)+'');}
        });
    }
    
    function _previewAvatar() 
    {
        $("#account-file").change(function(){
            if (this.files && this.files[0]) 
            {
                var reader = new FileReader();
                reader.onload = function (e) {$('#preview_avatar').attr('src', e.target.result);}
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    function _showModal()
    {
        var modal = $('#modal');
        modal.find('#modalContent').html('');
        $('a.modal-show').bind('click', function(e){
            e.preventDefault();
            modal.modal('show').find('#modalContent').load($(this).attr('href'));
            return false;
        });
    }

    return {
        init: init
    };
})();

