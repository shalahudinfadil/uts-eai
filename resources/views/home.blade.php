<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home</title>

        <!-- Fonts & Styles -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />

        <!-- Firebase -->
        <script src="https://www.gstatic.com/firebasejs/7.1.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-auth.js"></script>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    <body onload="checkSignIn()">
      <nav class="navbar navbar-dark bg-info">
        <a class="navbar-brand" href="/home">
          <i class="fa fa-line-chart" aria-hidden="true"></i>
          IEX Trading
        </a>
        <ul class="navbar nav ml-auto">
          <li class="nav-item dropdown">
           <a class="nav-link dropdown-toggle" href="#" id="dropdownUser" style="color:white;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             Profile
           </a>
           <div class="dropdown-menu" aria-labelledby="dropdownUser">
             <a class="dropdown-item" href="#" onclick="signOut()">
               <i class="fa fa-sign-out" aria-hidden="true"></i>
               Logout
             </a>
           </div>
         </li>
        </ul>
      </nav>
      <div class="container mt-4">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <p>Select Company</p>
            <select id="selectCompany" style="width:100%">

            </select>
          </div>
          <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Time Series</h5>
                <small>Last 20 Trading Days (including today)</small>
                <hr>
                <div id="chart_div" style="width: 900px; height: 500px;"></div>
              </div>
            </div>
          </div>
          <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Effective Spread</h5>
                <small>From 13 Listed Markets</small>
                <hr>
                <table class="table table-bordered" width="100%" id="es_table">
                  <thead>
                    <tr>
                      <th>Venue</th>
                      <th>Venue Name</th>
                      <th>Volume</th>
                      <th>Effective Spread</th>
                      <th>Effective Quoted</th>
                      <th>Price Improvement</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Venue</th>
                      <th>Venue Name</th>
                      <th>Volume</th>
                      <th>Effective Spread</th>
                      <th>Effective Quoted</th>
                      <th>Price Improvement</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Loading -->
      <div class="modal fade bd-example-modal-sm" id="loading_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body text-center">
              <i class="fa fa-circle-o-notch fa-spin align-middle" style="font-size:24px"></i> Please Wait
            </div>
          </div>
        </div>
      </div>

    </body>

    <script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
      apiKey: "AIzaSyCfps_86jSQcyTGr_u7KL_JzM8H5K83T5E",
      authDomain: "uts-eai.firebaseapp.com",
      databaseURL: "https://uts-eai.firebaseio.com",
      projectId: "uts-eai",
      storageBucket: "",
      messagingSenderId: "401907337958",
      appId: "1:401907337958:web:39e4c5fe178f5080584927"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    function checkSignIn() {
      firebase.auth().onAuthStateChanged(function(user) {
        if (user) {
          user.providerData.forEach(function (profile) {
            // console.log("Sign-in provider: " + profile.providerId);
            // console.log("  Provider-specific UID: " + profile.uid);
            // console.log("  Name: " + profile.displayName);
            // console.log("  Email: " + profile.email);
            // console.log("  Photo URL: " + profile.photoURL);
            var username = (profile.displayName) ? profile.displayName : profile.email;
            document.getElementById("dropdownUser").innerHTML= '<i class="fa fa-user" aria-hidden="true"></i> '+username+' ('+profile.providerId+')';
          });
        } else {
          window.location = "/";
        }
      });
    }

    function signOut() {
      firebase.auth().signOut().then(function() {
        window.location = "/";
      }).catch(function(error) {
      // An error happened.
      });
    }

      google.charts.load('current', {'packages':['corechart']});
      //google.charts.setOnLoadCallback(drawVisualization);

       function drawVisualization(datas) {
         // Some raw data (not necessarily accurate)
         var data = google.visualization.arrayToDataTable(datas, true);

       var options = {
        legend:'none',
        candlestick: {
              fallingColor: { strokeWidth: 0, fill: '#c21807' }, // red
              risingColor: { strokeWidth: 0, fill: '#0f9d58' }   // green
            }
          };

       var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));
       chart.draw(data, options);
     }

    $(document).ready(function() {
      <!-- Ajax Loading -->
      $("#loading_modal").modal('show');
      $.get('/symbols', function(resp) {
        $("#selectCompany").html(resp);
        $("#loading_modal").modal('hide');
      });

      <!-- Init JQuery Libs -->
      $("select").select2();

      var table = $("#es_table").DataTable({
        serverSide: false,
        processing: true,
        paging: true,
        language: {
            emptyTable: "Select a Company"
        },
        data: [],
        columns: [
          {data: 'venue'},
          {data: 'venueName'},
          {data: 'volume'},
          {data: 'es'},
          {data: 'eq'},
          {data: 'pi'},
        ]
      });

      <!-- Select Stuff -->
      $("#selectCompany").on('change', function() {
        var data = $(this).val();
        $("#loading_modal").modal('show');
        $.get('/time-series/'+data, function (resp) {
          drawVisualization(resp);
          $.get('/effective-spread/'+data, function(resp) {
            table.clear().draw();
            table.rows.add(resp).draw();
            $("#loading_modal").modal('hide');
          });
        });
      });

    });

    </script>
</html>
