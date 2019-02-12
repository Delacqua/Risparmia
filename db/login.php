<script type="text/javascript"></script>

<div ng-controller="LoginDB">

<div data-ng-init="log('!!!!')"> {{user.login}} </div>
<div data-ng-init="consultaDB()"> {{user.login}} </div>

</div>

<div>{{user | json}} </div>