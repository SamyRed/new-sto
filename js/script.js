function alertShow(alertList) {
    
    for (let key in alertList) {
        let elem = alertList[key];
        $("#alerts").show();
        
        $(elem).appendTo('#alertContainer')
            .delay(3000)
            .queue(function() {
                $(this).remove();
            });
            
    }
    
}

$(function() {
    $(document).on("click", "#alertContainer > div", (function() {
        $(this).remove();
    }));
});

$(function() {
    $(document).on("click", ".send-form", (function() {
        var container = $(this).data('params').container;
        var content = $(this).data('params').content;
        var action = $(this).data('params').action;
        var params = [];
        var form = $(this).closest('form');
        var formdata = form.serializeArray();
        
        $(formdata).each(function(index, obj){
            
            if(obj.name.endsWith('[]')) {
                
                obj.name = obj.name.slice(0, -2);
                
                if(typeof params[obj.name] === 'undefined') {
                    
                    params[obj.name] = [obj.value];
                    
                } else {
                    
                    params[obj.name].push(obj.value);
                    
                }
                
            } else {
                
                params[obj.name] = obj.value;
                
            }
            
        });

        params = JSON.stringify(Object.assign({}, params));
        params = JSON.parse(params);
        
        $.ajax({
            
            url: '/ajax',
            method: 'post',
            dataType: 'json',
            data: {'action': 'sendForm', 'script': action, 'formData': params},
            success: function(result){
                console.log(result);
                alertShow(result['alert']);
                
                $.ajax({
                    url: '/ajax',
                    method: 'post',
                    dataType: 'json',
                    data: {'action': 'loadContainer', 'content': content},
                    success: function(result){
                        
                        console.log(result, container);
                        alertShow(result['alert']);
                        $('#' + container).html(result.html);

                        $('#' + content).modal('show');
                        
                    },
                    error: function(result){
                        
                        console.log(JSON.stringify(result));
                        
                    }
                });
                
            },
            error: function(result){
                
                console.log(JSON.stringify(result));
                
            }
            
        });
    }));
});

$(function() {
    $(document).on("click", ".load-container", (function() {
        var dataParams = $(this).data('params');
        var container = dataParams.container;
        var content = dataParams.content;
        
        $.ajax({
            url: '/ajax',
            method: 'post',
            dataType: 'json',
            data: {'action': 'loadContainer', 'content': content},
            success: function(result){
                alertShow(result['alert']);
                console.log(result);
                if(dataParams.hasOwnProperty('setURI')) {
                
                    window.history.replaceState('', '', (window.location.origin + '/' + dataParams.setURI));
                
                }
                
                $('#' + container).html(result.html);
                
                $('#' + content).modal('show');
            },
            error: function(result){
                console.log(JSON.stringify(result));
            }
        });
    }));
});