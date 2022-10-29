Order - list
<nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link btn btn-outline-secondary load-container" data-params='{"container":"dialogContainer","content":"dialogAddOrder"}' href="#">{ADD_ORDER}</a>
            </li>
          </ul>
      </div>
</nav>
<div id="orderListContainer">
<?=include ROOT . '/view/table/orderList.php'?>
</div>