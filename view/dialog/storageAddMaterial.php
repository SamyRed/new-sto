<div class="modal fade" id="dialogStorageAddMaterial" tabindex="-1" role="dialog" aria-labelledby="dialogStorageAddMaterialLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dialogStorageAddMaterialLabel">{MATERIAL_ADDING}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <input type="hidden" name="id" id="storageAddMaterialId">
                    <div class="input-group mb-3 ui-widget">
                        <label for="storageAddMaterialTitle" class="input-group-text">{TITLE}:</label>
                        <input type="text" class="form-control" name="title" id="storageAddMaterialTitle" placeholder="{TITLE}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="storageAddMaterialAmount" class="input-group-text">{AMOUNT}:</label>
                        <input type="text" class="form-control" name="amount" id="storageAddMaterialAmount" placeholder="{AMOUNT}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="storageAddMaterialUnit" class="input-group-text">{UNIT}:</label>
                        <input type="text" class="form-control" name="unit" id="storageAddMaterialUnit" placeholder="{UNIT}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="storageAddMaterialPrice" class="input-group-text">{PRICE}:</label>
                        <input type="text" class="form-control" name="price" id="storageAddMaterialPrice" placeholder="{PRICE}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="storageAddMaterialTareWeight" class="input-group-text">{TARE_WEIGHT}:</label>
                        <input type="text" class="form-control" name="tare_weight" id="storageAddMaterialTareWeight" placeholder="{TARE_WEIGHT}">
                    </div>
                    <div class="input-group mb-3">
                        <label for="storageAddMaterialMinResidue" class="input-group-text">{MIN_RESIDUE}:</label>
                        <input type="text" class="form-control" name="min_residue" id="storageAddMaterialMinResidue" placeholder="{MIN_RESIDUE}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{CLOSE}</button>
                    <button type="button" class="btn btn-outline-secondary send-form" data-params='{"action": "storageAddMaterial"}' type="button" name="save">{ADD}</button>
                </div>
            </form>
        </div>
    </div>
    <script>
$( function() {
    $( "#storageAddMaterialTitle" ).autocomplete({
        
        source: function( request, response ) {
            
            $.ajax({

                url: '/ajax',
                method: 'post',
                dataType: 'json',
                data: {'action': 'sendData', 'script': 'storageGetMaterialListJSON', 'keyword': request.term},
                success: function(result) {
                
                    alertShow(result['alert']);
                    
                    response($.map(result.result, function (item) {
                        return {
                            value: item.title,

                            id: item.id,
                            unit: item.unit,
                            price: item.price,
                            tareWeight: item.tare_weight,
                            minResidue: item.min_residue
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
            
            $("#storageAddMaterialId").val(ui.item.id);
            $("#storageAddMaterialUnit").val(ui.item.unit);
            $("#storageAddMaterialPrice").val(ui.item.price);
            $("#storageAddMaterialTareWeight").val(ui.item.tareWeight);
            $("#storageAddMaterialMinResidue").val(ui.item.minResidue);
            
         }
      
    });
    
} );
    </script>
</div>