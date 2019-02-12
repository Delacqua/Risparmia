	<!--div ng-include="'login.php'"></div-->
	
<div class="col-sm-6" ng-controller="Login">

	login: {{login}}

	<form>
		<div class="input-group rowSpace">
		    <span class="input-group-addon" id="basic-addon1">Login: </span>
		    <input type="text" class="form-control" aria-describedby="basic-addon1" ng-model="user.login">
		</div>

		<div class="input-group rowSpace">
		    <span class="input-group-addon" id="basic-addon1">Password:</span>
		    <input type="password" class="form-control" aria-describedby="basic-addon1" ng-model="user.password">
		</div>

		<button class="btn btn-primary rowSpace" type="submit" ng-click="logIn()">----LogIn----</button>

	</form>

	</br>

	<button class="btn btn-warning" ng-click="logOut()">----LogOut----</button></br>

	<button class="btn btn-warning" ng-click="aggiorna()">----Aggiorna----</button></br>
	
	<!--div ng-include='template'> </div-->

	<!--div ng-init="teste='<?=$teste1; ?>'"> </div-->

</div>

	<!--div ng-include="'login.php'"></div-->