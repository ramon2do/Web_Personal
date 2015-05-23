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
        console.log('Init Method APP JS');
        _inputMask();
        _initDataTable();
        _setCompanyCode();
        _previewAvatar();
        _showModal();
        _paginationUl();
    }
    
    function change()
    {
        console.log('Change Method APP JS');
        _getCategory();
    }
    
    function _inputMask()
    {
        //Only String
        $('input.only-string').validField('abcdefghijklmnñopqrstuvwxyzáéíóú');
        //Only String With Space
        $('input.only-string-space').validField(' abcdefghijklmnñopqrstuvwxyzáéíóú');
        //Only Number
        $('input.only-number').validField('0123456789');
        //Only Number With Space
        $('input.only-number-space').validField(' 0123456789');
        
        
        //Personal Phone
        $('input.phone').inputmask({
            mask: '(0499) 9999999'
        });
        //Personal Phone
        $('input.telephone').inputmask({
            mask: '(0999) 9999999'
        });
    }
    
    function _paginationUl()
    {
        $("ul.products-list").quickPager({
            pageSize: 4,
        });
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
        $("#account-file").on('change', function(){
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
    
    function _getCategory()
    {
        var type = 'select#category-type_id';
        var category = 'select#subcategory-category_id';
        var subcategory = 'select#item-subcategory_id';
        $(document).on('change', type, function(){
            $('div#category').load('/category/list?typeId='+$(this).val()+' #category', function(response, status, xhr){
                if(status == "success"){$('div#category').show('slow');$('div#subcategory').hide('slow');}
            });
        });
        $(document).on('change', category, function(){
            $('div#subcategory').load('/subcategory/list?categoryId='+$(this).val()+' #subcategory', function(response, status, xhr){
                if(status == "success"){$('div#subcategory').show('slow');}
            });
        });
    }
    
    (function(a){a.fn.validField=function(b){a(this).on({keypress:function(a){var c=a.which,d=a.keyCode,e=String.fromCharCode(c).toLowerCase(),f=b;(-1!=f.indexOf(e)||9==d||37!=c&&37==d||39==d&&39!=c||8==d||46==d&&46!=c)&&161!=c||a.preventDefault()}})}})(jQuery);

    return {
        init: init,
        change: change,
    };
})();
