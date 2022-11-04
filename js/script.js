/**
 * Render alerts
 */
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

/**
 * Close alert if click on it
 */
$(function() {
    
    $(document).on("click", "#alertContainer > div", (function() {
        
        $(this).remove();
        
    }));
    
});

/*
 * Send form data to handler script
 */
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
            data: {'action': 'sendData', 'script': action, 'formData': params},
            success: function(result){
                
                alertShow(result['alert']);
                
                if(result.hasOwnProperty('reload')) {
        
                    var uri = window.location.pathname.substring(1);
        
                    $.ajax({

                        url: '/route',
                        method: 'post',
                        dataType: 'json',
                        data: {'action': 'route', 'uri': uri},
                        success: function(result){

                            alertShow(result['alert']);

                            window.history.replaceState('', '', (window.location.origin + '/' + uri));
                            var newDoc = document.open("text/html", "replace");
                            newDoc.write(result.html);
                            newDoc.close();

                        },
                        error: function(result){

                            console.log(JSON.stringify(result));

                        }

                    });
    
                }
                
                if (typeof container !== 'undefined') {
                
                    $.ajax({

                        url: '/ajax',
                        method: 'post',
                        dataType: 'json',
                        data: {'action': 'loadView', 'content': content},
                        success: function(result){

                            alertShow(result['alert']);
                            $('#' + container).html(result.html);

                            $('#' + content).modal('show');

                        },
                        error: function(result){

                            console.log(JSON.stringify(result));

                        }

                    });
                    
                }
                
            },
            error: function(result){
                
                console.log(JSON.stringify(result));
                
            }
            
        });
        
    }));
    
});

/**
 * Load content to container
 */
$(function() {
    $(document).on("click", ".load-container", (function() {
        
        var dataParams = $(this).data('params');
        
        if(dataParams.hasOwnProperty('container')) {

            var container = dataParams.container;

        }
        
        var content = dataParams.content;
        
        $.ajax({
            url: '/ajax',
            method: 'post',
            dataType: 'json',
            data: {'action': 'loadView', 'content': content},
            success: function(result){
                
                alertShow(result['alert']);
                
                if(dataParams.hasOwnProperty('setURI')) {
                
                    window.history.replaceState('', '', (window.location.origin + '/' + dataParams.setURI));
                
                }
                
                if (typeof container !== 'undefined') {
                
                    $('#' + container).html(result.html);
                
                }
                
                $('#' + content).modal('show');
                
            },
            error: function(result){
                
                console.log(JSON.stringify(result));
                
            }
            
        });
        
    }));
    
});

/**
 * Change page without reload
 */
$(function() {
    $(document).on("click", ".load-page", (function() {
        
        var dataParams = $(this).data('params');
        var uri = dataParams.uri;
        
        $.ajax({
            
            url: '/route',
            method: 'post',
            dataType: 'json',
            data: {'action': 'route', 'uri': uri},
            success: function(result){
                
                alertShow(result['alert']);
                
                window.history.replaceState('', '', (window.location.origin + '/' + uri));
                var newDoc = document.open("text/html", "replace");
                newDoc.write(result.html);
                newDoc.close();
                
            },
            error: function(result){
                
                console.log(JSON.stringify(result));
                
            }
            
        });
        
    }));
    
});

/**
 * Send data to script
 */
$(function() {
    
    $(document).on("click", ".send-data", (function() {
        
        var dataParams = $(this).data('params');
        var script = dataParams.action;
        var params = dataParams.params;
        
        $.ajax({
            
            url: '/ajax',
            method: 'post',
            dataType: 'json',
            data: {'action': 'sendData', 'script': script, 'params': params},
            success: function(result){
                
                alertShow(result['alert']);
                
                if(result.hasOwnProperty('reload')) {
        
                    var uri = window.location.pathname.substring(1);
        
                    $.ajax({

                        url: '/route',
                        method: 'post',
                        dataType: 'json',
                        data: {'action': 'route', 'uri': uri},
                        success: function(result){

                            alertShow(result['alert']);

                            window.history.replaceState('', '', (window.location.origin + '/' + uri));
                            var newDoc = document.open("text/html", "replace");
                            newDoc.write(result.html);
                            newDoc.close();

                        },
                        error: function(result){

                            console.log(JSON.stringify(result));

                        }

                    });
                    
                }
                
            },
            error: function(result){
                
                console.log(JSON.stringify(result));
                
            }
            
        });
        
    }));
    
});