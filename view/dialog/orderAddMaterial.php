<?php
$storage = new Storage();
$storageArr = $storage->get();
$permittedStorageList = $storage->permittedList();
?>
<div class="modal fade" id="dialogOrderAddMaterial" tabindex="-1" role="dialog" aria-labelledby="dialogOrderAddMaterialLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogOrderAddMaterialLabel">{MATERIAL_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="orderAddMaterialOrderId" value="<?=$params['order_id']?>">
                    <input type="hidden" name="id" id="orderAddMaterialId">
                    <input type="hidden" name="unit" id="orderAddMaterialUnit">
                    <input type="hidden" name="price" id="orderAddMaterialPrice">
<?php 
if($storageArr) {
?>
                    <div class="dropdown ml-2">
                        <a class="nav-link dropdown-toggle text-secondary mb-2" data-toggle="dropdown" href="#"><?=$storageArr['title']?></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<?php
    if($permittedStorageList) {
        foreach($permittedStorageList as $storageArr) {
?>
                            <li><a class="dropdown-item dropdown-selected send-data" data-params='{"action":"storageSetId", "params": {"id": "<?=$storageArr['id']?>"}}' href="#"><?=$storageArr['title']?></a></li>
<?php
        }
    }
?>
                        </ul>
                    </div>
<?php
}
?>
                    <div class="input-group mb-3 ui-widget">
                        <label for="orderAddMaterialTitle" class="input-group-text">{MATERIAL_TITLE}:</label>
                        <input type="text" class="form-control" name="title" id="orderAddMaterialTitle" placeholder="{MATERIAL_TITLE}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="orderAddMaterialAmount" class="input-group-text">{AMOUNT}:</label>
                        <input type="text" class="form-control" name="amount" id="orderAddMaterialAmount" placeholder="{AMOUNT}">
                        <span class="input-group-text">{TOTAL}:&nbsp;<b class="cursor-pointer" title="{ADD_ALL}" id="orderAddMaterialTotalAmount"></b>&nbsp;<span id="orderAddMaterialUnitLabel"></span></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{CLOSE}</button>
                    <button type="button" class="btn btn-outline-secondary send-form load-container" data-params='{"action": "orderAddMaterial", "container": "MaterialListContainer", "content":"tableOrderMaterialList"}' type="button" name="save">{SAVE}</button>
                </div>
            </form>
        </div>
    </div>
    <script>
$(function() {
    
    $(document).on("click", "#orderAddMaterialTotalAmount", function() {
        
        $(this).closest(".input-group").children('input').val($(this).html());
        
    });
    
});

$(function() {
    
    $("#orderAddMaterialTitle").autocomplete({
        
        source: function( request, response ) {
            
            $.ajax({

                url: '/ajax',
                method: 'post',
                dataType: 'json',
                data: {'action': 'sendData', 'script': 'storageGetMaterialListByKeyword', 'keyword': request.term},
                success: function(result) {
                
                    alertShow(result['alert']);
                    
                    response($.map(result.result, function (item) {
                        
                        return {
                            value: item.title,

                            id: item.id,
                            unit: item.unit,
                            price: item.price,
                            amount: item.amount
                        }
                        
                    }));  

                },
                error: function(result){

                    console.log(JSON.stringify(result));

                }

            });
        
        },
        minLength: 1,
        select: function (event, ui) {
            
            $("#orderAddMaterialId").val(ui.item.id);
            $("#orderAddMaterialUnit").val(ui.item.unit);
            $("#orderAddMaterialPrice").val(ui.item.price);
            $("#orderAddMaterialTotalAmount").html(ui.item.amount);
            $("#orderAddMaterialUnitLabel").html(ui.item.unit);
            
         }
      
    });
    
});
    </script>
</div>