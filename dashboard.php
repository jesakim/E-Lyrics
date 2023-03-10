<?php

include('signin.php');

if(!isset($_SESSION['user'])){
  header('Location: index.php');
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
    <link rel="stylesheet" href="sidebarstyle.css">
    <title>dashboard</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel=" stylesheet">
	<!--Replace with your tailwind.css once created-->


	<!--Regular Datatables CSS-->
	<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
	<!--Responsive Extension Datatables CSS-->
	<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

	<style>
		/*Overrides for Tailwind CSS */
  
		/*Form fields*/
		.dataTables_wrapper select,
		.dataTables_wrapper .dataTables_filter input {
			color: #4a5568;
			/*text-gray-700*/
			padding-left: 1rem;
			/*pl-4*/
			padding-right: 1rem;
			/*pl-4*/
			padding-top: .5rem;
			/*pl-2*/
			padding-bottom: .5rem;
			/*pl-2*/
			line-height: 1.25;
			/*leading-tight*/
			border-width: 2px;
			/*border-2*/
			border-radius: .25rem;
			border-color: #edf2f7;
			/*border-gray-200*/
			background-color: #edf2f7;
			/*bg-gray-200*/
		}

		/*Row Hover*/
		table.dataTable.hover tbody tr:hover,
		table.dataTable.display tbody tr:hover {
			background-color: #ebf4ff;
			/*bg-indigo-100*/
		}

		/*Pagination Buttons*/
		.dataTables_wrapper .dataTables_paginate .paginate_button {
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Pagination Buttons - Current selected */
		.dataTables_wrapper .dataTables_paginate .paginate_button.current {
			color: #fff !important;
			/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
			/*shadow*/
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			background: #667eea !important;
			/*bg-indigo-500*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Pagination Buttons - Hover */
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
			color: #fff !important;
			/*text-white*/
			box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
			/*shadow*/
			font-weight: 700;
			/*font-bold*/
			border-radius: .25rem;
			/*rounded*/
			background: #667eea !important;
			/*bg-indigo-500*/
			border: 1px solid transparent;
			/*border border-transparent*/
		}

		/*Add padding to bottom border */
		table.dataTable.no-footer {
			border-bottom: 1px solid #e2e8f0;
			/*border-b-1 border-gray-300*/
			margin-top: 0.75em;
			margin-bottom: 0.75em;
		}

		/*Change colour of responsive icon*/
		table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
		table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
			background-color: #667eea !important;
			/*bg-indigo-500*/
		}
	</style>
</head>
<body>
    <nav class="sidebar">
        <i class="arrow fa-solid fa-angles-right"></i>
        <div class="navitem fnav active" onclick="fnav(this)" >
            <i class="fa-solid fa-chart-line"></i>
             <span>Dashboard</span> 
        </div>
        <div class="navitem snav" onclick="snav(this)">
            <i class="fa-solid fa-table-cells-large"></i>
             <span>Songs</span> 
        </div>
        <div class="navitem" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-plus"></i>
             <span>Add Songs</span> 
        </div>
        <form action="" method="post"><input type="submit" class="d-none" value="" name="logout" id="logoutbtn"></form>
        <div class="navitem" onclick="getElementById('logoutbtn').click()">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
             <span>Logout</span> 
        </div>
      
    </nav>
    <nav class="navbar">
        <div style="font-family: Orbitron;" id="MyClockDisplay" class="clock">hhhhhhhhhhhhhhhhh</div>
    </nav>

    <nav class="phonesidebar">
    <div class="navitem fnav active"  onclick="fnav(this)">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div class="navitem snav"  onclick="snav(this)">
            <i class="fa-solid fa-table-cells-large"></i>
        </div>
        <div class="navitem" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-plus"></i>
        </div>
        <form action="" method="post"><input type="submit" class="d-none" value="" name="logout" id="logoutbtn"></form>
        <div class="navitem" onclick="getElementById('logoutbtn').click()">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </div>
    </nav>
    
    <div class="cotainer">
        <button style="background-color: #0f0;color:#333;outline:none;" class="btn rounded-pill fw-bold m-1 outline-none" data-bs-toggle="modal" data-bs-target="#exampleModal">add song</button>
        <div class="infomsg" ><i class="fa-solid fa-triangle-exclamation"></i> <div class="msg text-break">gvrefzezferegreggrgrgverzgerzgergreergfregergergregre erg ergerg erg  r vgergegerge</div></div>
        <div class="row w-100 m-0" id="statistics">
        <div class="p-1 col-12 col-md-6">
            <div class="card">
            <div class="card-body">
              <h5 class="card-title">Songs</h5>
              <div class="d-flex align-items-center">
                <div style="background-color: #0f0;height: 80px;width: 80px;color:#333;" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-music fs-3"></i>
                </div>
                <div class="ps-4">
                  <h3 id="songscount">2</h3>
                </div>
              </div>
            </div>
            </div>
            </div>
            <div class="p-1 col-12 col-md-6">
                <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Albums</h5>
                  <div class="d-flex align-items-center">
                    <div style="background-color: #0f0;height: 80px;width: 80px;color:#333;" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-compact-disc fs-3"></i>
                    </div>
                    <div class="ps-4">
                      <h3 id="albumscount">2</h3>
                    </div>
                  </div>
                </div>
                </div>
                </div>
                <div class="p-1 col-12 col-md-6">
                    <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Singers</h5>
                      <div class="d-flex align-items-center">
                        <div style="background-color: #0f0;height: 80px;width: 80px;color:#333;" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-podcast fs-3"></i>
                        </div>
                        <div class="ps-4">
                          <h3 id="singerscount">2</h3>
                        </div>
                      </div>
                    </div>
                    </div>
                    </div>
                    <div class="p-1 col-12 col-md-6">
                        <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Admins</h5>
                          <div class="d-flex align-items-center">
                            <div style="background-color: #0f0;height: 80px;width: 80px;color:#333;" class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-user fs-3"></i>
                            </div>
                            <div class="ps-4">
                              <h3 id="usercount">2</h3>
                            </div>
                          </div>
                        </div>
                        </div>
                        </div>
        </div>
          <div id='recipients' class="p-2 mt-2 rounded shadow bg-white d-none overflow-auto">


			<table id="txmpl" class="stripe hover " style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
				<thead>
					<tr>
						<th data-priority="1">Song Name</th>
						<th data-priority="2">Singer Name</th>
						<th data-priority="3">Album Name</th>
						<th data-priority="4">Created At</th>
						<th data-priority="5">Actions</th>
					</tr>
				</thead>
				<tbody id="tablebody">

				</tbody>

			</table>


		</div>
		<!--/Card-->
</div>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="popuphide()"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-floating mb-1 col-12">
                    <input type="text" class="form-control" id="name0" placeholder="name@example.com">
                    <label for="floatingInput">Song Name</label>
                  </div>
                  <div class="form-floating col-6">
                    <input type="text" class="form-control" id="singer0" placeholder="Password">
                    <label for="floatingPassword">Singer Name</label>
                  </div>
                  <div class="form-floating col-6">
                    <input type="text" class="form-control" id="album0" placeholder="name@example.com">
                    <label for="floatingInput">Album Name</label>
                  </div>
                  <div class="form-floating col-12 mt-1">
                    <textarea class="form-control" placeholder="Leave a comment here" id="lyrics0"></textarea>
                    <label for="floatingTextarea">lyrics</label>
                  </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-between align-items-center">
            <div class="m-0 p-0 d-flex flex-column align-items-center">
                <button class="btn bg-transparent" onclick="addorremoveform(-1)"><i class="fa-solid fa-minus"></i></button>
                <span id="counter">1</span>
                <button class="btn bg-transparent" onclick="addorremoveform(1)"><i class="fa-solid fa-plus"></i></button>
            </div>
          <button type="button" class="btn btn-primary" onclick="addsongs()">Add Songs</button>
        </div>
      </div>
    </div>
  </div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="lyricsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Song Lyrics</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="lyricscontent" contenteditable class="lh-base text-wrap text-center border p-3 border-primary border-3 m-1"></p>
      </div>
    </div>
  </div>
</div>

  <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
  <script src="script.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

	<!--Datatables -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
</body>
</html>