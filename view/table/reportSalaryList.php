<?php
$worker = new Worker();
$order = new Order();
$orderListArr = $worker->getSalaryList(array());
if($orderListArr) {
    $totalWorkerPrice = 0;
    $totalOrderPrice = 0;
    $workerId = null;
    $orderId = null;
?>
<div id="accordion">
<?php
    foreach($orderListArr as $workerId => $workerArr) {
?>
    <div class="card mt-2">
        <div class="card-header" id="heading-worker-<?=$workerId?>">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse-worker-<?=$workerId?>" aria-expanded="false" aria-controls="collapse-worker-<?=$workerId?>">
                    <?=$worker->get($workerId)['name']?>
                </button>
            </h5>
        </div>
        <div id="collapse-worker-<?=$workerId?>" class="collapse" aria-labelledby="heading-worker-<?=$workerId?>" data-parent="#accordion">
            <div class="card-body">
                <div id="accordion-worker-<?=$workerId?>">
<?php
        foreach($workerArr as $orderId => $orderArr) {
            $orderInfo = $order->get($orderId);
?>
                    <div class="card mt-2">
                        <div class="card-header" id="heading-order-<?=$orderId?>">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse-order-<?=$orderId?>" aria-expanded="false" aria-controls="collapse-order-<?=$orderId?>">
                                    <?=$orderInfo['car_name'].' ['.$orderInfo['car_number'] . ']'?>
                                </button>
                            </h5>
                        </div>
                        <div id="collapse-order-<?=$orderId?>" class="collapse" aria-labelledby="heading-order-<?=$orderId?>" data-parent="#accordion-worker-<?=$workerId?>">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>    
                                        <tr>
                                            <th scope="col">{TITLE}</th>
                                            <th scope="col">{AMOUNT}</th>
                                            <th scope="col">{PRICE}</th>
                                            <th scope="col">{SUM}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
            foreach($orderArr as $taskArr) {
?>
                                        <tr>
                                            <td><?=$taskArr['title']?></td>
                                            <td><?=$taskArr['amount']?></td>
                                            <td><?=$taskArr['price']?></td>
                                            <td><?=$taskArr['sum']?>{UAH}</td>
                                        </tr>
<?php
                $totalOrderPrice += $taskArr['sum'];
                
            }
?>
                                        <tr>
                                            <td class="text-end" colspan="3">{TOTAL_ORDER_PRICE}: </td>
                                            <td><b><?=$totalOrderPrice?></b>{UAH}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<?php
            $totalWorkerPrice += $totalOrderPrice;
            $totalOrderPrice = 0;
        }
?>
                </div>
            </div>
        </div>
        <p class="text-end mr-5">{WORKER_SUM}: <?=$totalWorkerPrice?></p>
    </div>
<?php
    }
?>
</div>
<?php
}
?>