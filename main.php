<?php 
	include('server/connection.php');
	if(!isset($_SESSION['username'])){
		header('location: index.php');
	}
	$noimg = isset($_Get['noimg']);
	$added = isset($_GET['added']);
	$error = isset($_GET['error']);
	$undelete = isset($_GET['undelete']);
	$updated = '';
	$deleted = '';
	$failure = isset($_GET['failure']);
	
	$query 	= "SELECT * FROM `customer`";
	$show	= mysqli_query($db,$query);
	if(isset($_SESSION['username'])){
		$user = $_SESSION['username'];
		$sql = "SELECT position FROM users WHERE username='$user'";
		$result	= mysqli_query($db, $sql);
		if (mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
?>
<!DOCTYPE html>
<html>
<head>
	<?php include('templates/head.php'); ?>
	<style>
	
		#container{
			display: flex;
			flex-direction: column;
			height: 100%;
		}
		#header{
				height: 100%;
			}
			.mainCon{
			display: flex;
    width: 100%;
    justify-content: center;
    height: 70%;
    margin-top: 50px;
		}
		@media only screen and (min-width: 500px){
			#header{
				height: 100px;
			}
			#container{
				height: 550px;
			}
			#content{
				height: 100%;
			}
			/* #price_column{
				height: 100%;
			} */
			#time{
				color:#fff;
			}.dateTime{
				margin-top: 20px;
			}
	
		}
		@media  only screen and (max-width: 1000px) {
			.img-fluid{
				height: 100px;
			}
			/* #container{
				
			}
			 */
			
			#content{
				height: 300px;
			}
			#price_column{
				height: 220px;
			}
			#time{
				color:red;
			}
			.dateTime{
				margin-top: 5px;
			}
	
		}
	</style>
</head>
<body id="body">
	<div class="h-100 bg-dark" id="container">
		<div id="header" style="display: flex; width:100%;">
			<?php include('alert.php'); ?>
			<div>
				<img class="img-fluid m-2 w-100" src="images/logo1.jpg" style="width: 200px;"/>
			</div>
			<div class="text-white mt-0 ml-5">
				<table class="table-responsive-sm">
					<tbody>
						<tr>
							<td valign="baseline"><small>User:</small></td>
							<td valign="baseline"><small><p class="pt-3 ml-5"><i class="fas fa-user-shield"></i> <?php echo $row['position'];}}}?></p></small></td>
						</tr>
						<!-- <tr>
							<td valign="baseline"><small class="pb-1">Date:</small></td>
							<td valign="baseline"><small><p class="p-0 ml-5"><i class="fas fa-calendar-alt">&nbsp</i><span id='time'></span></p></small></td>
						</tr> -->
						<tr>
							<td valign="baseline"><small class="mt-5">Customer Name:</small></td>
							<td valign="baseline"><small><div class="content p-0 ml-5"><input type="text" class="form-control form-control-sm customer_search" autocomplete="off" data-provide="typeahead" id="customer_search" placeholder="Customer Search" name="customer"/></small></div>
							</td>
							<td valign="baseline"><button class="btn-sm btn-info border ml-2" data-toggle="modal" data-target=".bd-example-modal-md" style="padding-top: 1px; padding-bottom: 2px;"><span class="badge badge-info"><i class="fas fa-user-plus"></i> New</span></button></td>
						</tr>
					</tbody>
				</table>
				<small><p class="p-0 ml-5 dateTime"><i class="fas fa-calendar-alt">&nbsp</i><span id='time'></span></p></small>
			</div>
			<div class="header_price border p-0" style="margin: 5px !important;width: 30%">
				<h5 style="padding-left:5px;">Grand Total</h5>
				<p class="pb-0 mr-2" style="float: right; font-size: 40px;" id="totalValue">৳ 0.00</p>
			</div>
		</div>
		<div class="mainCon">
			<div id="content" class="mr-2" style="width: 50%;">
			<div id="price_column" class="m-2 table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar-a">
				<form method="POST" action="">
				<table class="table-striped w-100 font-weight-bold" style="cursor: pointer;" id="table2">
					<thead>
						<tr class='text-center'>
							<th>Barcode</th>
							<th>Description</th>
							<th>Price</th>
							<th>Unit</th>
							<th>Qty</th>
							<th>Sub.Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tableData">
					</tbody>
				</table>
				</form>
			</div>
			<div id="table_buttons" style="display: flex; width:100%">
				<button id="buttons" style="width: 50%;" type="button" name='enter' class="Enter btn btn-secondary border ml-2"><i class="fas fa-handshake"></i> Finish</button>
				<div class="" style="width: 50%; padding:0px 0px 0px 50px">
				<small>
					<ul class="text-white justify-content-center">
						<li class="d-flex mb-0">Total (৳): <p id="totalValue1" class="mb-0 ml-5 pl-3">0.00</p></li>
						<li class="mb-0 mt-0">Discount (<big>৳</big>) %: <input style="width: 100px" class="text-right form-control-sm" type="number" name="discount" value="0" min="0" placeholder="Enter Discount %" id="discount" ></li>
					</ul>
				</small>
				</div>
			</div>
		</div>
		<div id="sidebar" style="width: 50%;">
			<div class="mt-1 ">
			<div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span></div>
   				<input class="form-control" type="text" placeholder="Product Search" aria-label="Search" id="search" name="search" onkeyup="loadproducts();"/>
   			</div></div>
			<div id="product_area" style="padding:5px;padding: 5px;
    height: 98%;
    margin-top: 10px !important;
    border-radius: 5px;" class="table-responsive-sm mt-2 table-wrapper-scroll-y my-custom-scrollbar" >
				<table class="w-100 table-striped font-weight-bold" style="cursor: pointer;" id="table1">
					<thead>
						<tr claclass='text-center'><b>
							<td>Barcode</td>
							<td>Product Name</td>
							<td>Price</td>
							<td>Unit</td>
							<td>Stocks</td>
							<td>Location</td>
						</tr></b>
						<tbody id="products">
							
						</tbody>
					</thead>
				</table>
			</div>
			<div class="w-100 mt-2" id="enter_area" style="display: flex; justify-content:center; align-items:center">
				<button id="buttons" type="button" class="cancel btn btn-secondary border" style="width: 50%"><i class="fas fa-ban"></i> Cancel</button>
				<button id="btnPrint" onclick="printPage()" type="button" style="    width: 50%;
    height: 50px;" class="cancel btn btn-secondary border"><i class="fas fa-print"></i> Print Token</button>
			</div>
		</div>
		</div>
			<div id="kutta" style="display:none;">
			Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab, cupiditate. Velit iste modi obcaecati dolore in nihil vero, excepturi, quam officia illo placeat ullam.
		</div>
		<div id="footer" class="w-100" style="display: flex; width:100%">
			<button id="buttons" style="flex-grow: 1;" onclick="window.location.href='user/user.php'" class="btn btn-secondary border mr-2 ml-2"><i class="fas fa-users"></i> User</button>
			<button id="buttons" style="flex-grow: 1;" onclick="window.location.href='products/products.php'" class="btn btn-secondary border mr-2"><i class="fas fa-box-open"></i> Product</button>
			<button id="buttons" style="flex-grow: 1;" onclick="window.location.href='supplier/supplier.php'" class="btn btn-secondary border mr-2"><i class="fas fa-user-tie"></i> Supplier</button>
			<button id="buttons" style="flex-grow: 1;" onclick="window.location.href='customer/customer.php'" class="btn btn-secondary border mr-2"><i class="fas fa-user-friends"></i> Customer</button>
			<button id="buttons" style="flex-grow: 1;" onclick="window.location.href='logs/logs.php'" class="btn btn-secondary border mr-2"><i class="fas fa-globe"></i> Logs</button>
			<button id="buttons" style="flex-grow: 1;" onclick="window.location.href='cashflow/cashflow.php'" class="btn btn-secondary border mr-2"><i class="fas fa-money-bill-wave"></i> Cash-Flow</button>
			<button id="buttons" style="flex-grow: 1;" onclick="window.location.href='sales/sales.php'" class="btn btn-secondary border mr-2"><i class="fas fa-shopping-cart"></i> Sales</button>
			<button id="buttons" style="flex-grow: 1;" onclick="window.location.href='delivery/delivery.php'" class="btn btn-secondary border mr-2"><i class="fas fa-truck"></i>Delivery</button>
			<button id="buttons" style="flex-grow: 1;" name="logout" type="button" onclick="out();" class="logout btn btn-danger border mr-2"><i class="fas fa-sign-out-alt"></i> Logout</button> 
		</div>
	
	</div>
	<?php include('add.php');?>
	<?php include('templates/js_popper.php');?>
	<script type="text/javascript" src="script.js"></script>
	<script src="bootstrap4/js/time.js"></script>

</body>
<script>
	function printPage(){
		let body = document.getElementById("body").innerHTML;
		let data = document.getElementById("kutta").innerHTML;
		
		document.getElementById("body").innerHTML = data;
		window.print();
		document.getElementById("body").innerHTML = body;

	}
</script>
</html>

