<?php
$worker = new Worker();
$workerListArr = $worker->getList();
?>
<div class="modal fade" id="dialogOrderAddTask" tabindex="-1" role="dialog" aria-labelledby="dialogOrderAddTaskLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogOrderAddTaskLabel">{TASK_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="orderAddTaskOrderId" value="<?=$params['order_id']?>">
                    <div class="input-group mb-3 ui-widget">
                        <label for="orderAddTaskTitle" class="input-group-text">{TASK_TITLE}:</label>
                        <input type="text" class="form-control" name="title" id="orderAddTaskTitle" placeholder="{TASK_TITLE}">
                    </div>
                    <div class="input-group mb-3 ui-widget">
                        <label for="orderAddTaskDescription" class="input-group-text">{DESCRIPTION}:</label>
                        <input type="text" class="form-control" name="description" id="orderAddTaskDescription" placeholder="{DESCRIPTION}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="orderAddTaskPrice" class="input-group-text">{PRICE}:</label>
                        <input type="text" class="form-control" name="price" id="orderAddTaskPrice" placeholder="{PRICE}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="orderAddTaskAmount" class="input-group-text">{AMOUNT}:</label>
                        <input type="text" class="form-control" name="amount" id="orderAddTaskAmount" placeholder="{AMOUNT}">
                    </div>
<?php 
if($workerListArr) {
?>
                    <div class="input-group mb-3">
                        <label for="orderAddTaskWorkerId" class="input-group-text">{WORKER}:</label>
                        <select class="custom-select" name="worker_id" id="orderAddTaskWorkerId">
<?php
    foreach($workerListArr as $workerArr) {
        var_dump($workerArr);
?>
                        <option value="<?=$workerArr['id']?>"><?=$workerArr['name']?></option>
<?php
    }
?>
                        </select>
                    </div>
<?php
}
?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary send-form" data-params='{"action": "orderAddTaskPattern"}'>{SAVE_AS_PATTERN}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{CLOSE}</button>
                    <button type="button" class="btn btn-outline-secondary send-form" data-params='{"action": "orderAddTask", "container": "taskListContainer", "content":"tableOrderTaskList"}' name="save">{SAVE}</button>
                </div>
            </form>
        </div>
    </div>
    <script>

$(function() {
    
    $("#orderAddTaskTitle").autocomplete({
        
        source: function( request, response ) {
            
            $.ajax({

                url: '/ajax',
                method: 'post',
                dataType: 'json',
                data: {'action': 'sendData', 'script': 'orderGetTaskPatternListByKeyword', 'keyword': request.term},
                success: function(result) {
                
                    alertShow(result['alert']);
                    
                    response($.map(result.result, function (item) {
                        
                        return {
                            value: item.title,

                            price: item.price,
                        }
                        
                    }));  

                },
                error: function(result){

                    console.log(JSON.stringify(result));

                }

            });
        
        },
        select: function (event, ui) {
            
            $("#orderAddTaskPrice").val(ui.item.price);
            
         }
      
    });
    
});
    </script>
</div>