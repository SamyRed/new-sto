<nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <button type="button" class="nav-link btn btn-outline-secondary load-container" data-params='{"container":"dialogContainer","content":"dialogOrderAdd"}'>{ADD_ORDER}</button>
            </li>
          </ul>
      </div>
</nav>
<div id="orderListContainer">
<?php
    include ROOT . '/view/table/orderList.php';
?>
</div>