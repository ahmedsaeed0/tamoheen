@extends('layouts.admin.master')

@section('title')

Home

@endsection

@section('admin-additional-css')



@endsection

@section('content')

<div class="content">

	<div class="container-fluid">

		




	  	<div class="row">

		  	@role('partner')

			  <div class="col-lg-3 col-md-6 col-sm-6">

				<div class="card card-stats ">

					<div class="card-header card-header-warning card-header-icon">

						<div class="card-icon">

							<i class="material-icons">content_copy</i>

						</div>

						<p class="text-center text-dark">@lang('admin-dashboard.total_amount')</p>

						<h3 class="card-title text-center">{{ $partner_amount }}</h3>

					</div>

					<div class="card-footer"></div>

				</div>

			</div>

		    <div class="col-lg-3 col-md-6 col-sm-6">

		      <div class="card card-stats">

		        <div class="card-header card-header-success card-header-icon">

		          <div class="card-icon">

		            <i class="material-icons">content_copy</i>

		          </div>

		          <p class="card-category">@lang('admin-dashboard.total_trip')</p>

		          <h3 class="card-title">{{ $total_trip }}

		          </h3>

		        </div>

		        <div class="card-footer">

		        </div>

		      </div>

		    </div>

		    @else

			    <div class="col-lg-3 col-md-6 col-sm-6">

			      <div class="card card-stats">

			        <div class="card-header card-header-warning card-header-icon">

			          <div class="card-icon">

			            <i class="material-icons">content_copy</i>

			          </div>

			          <p class="card-category">@lang('admin-dashboard.total_user')</p>

			          <h3 class="card-title">{{ $total_user }}

			          </h3>

			        </div>

			        <div class="card-footer">

			        </div>

			      </div>

			    </div>

		    @endrole



		    @role('partner')

			    <!--<div class="col-lg-3 col-md-6 col-sm-6">-->

			    <!--  <div class="card card-stats">-->

			    <!--    <div class="card-header card-header-success card-header-icon">-->

			    <!--      <div class="card-icon">-->

			    <!--        <i class="material-icons">store</i>-->

			    <!--      </div>-->

			    <!--      <p class="card-category">@lang('admin-dashboard.total_sale')</p>-->

			    <!--      <h3 class="card-title">{{ $total_sales }}</h3>-->

			    <!--    </div>-->

			    <!--    <div class="card-footer">-->

			    <!--    </div>-->

			    <!--  </div>-->

			    <!--</div>-->

		    @else

		    	<div class="col-lg-3 col-md-6 col-sm-6">

			      <div class="card card-stats">

			        <div class="card-header card-header-success card-header-icon">

			          <div class="card-icon">

			            <i class="material-icons">store</i>

			          </div>

			          <p class="card-category">@lang('admin-dashboard.total_partner')</p>

			          <h3 class="card-title">{{ $total_partner }}</h3>

			        </div>

			        <div class="card-footer">

			        </div>

			      </div>

			    </div>

		    @endrole

		    <div class="col-lg-3 col-md-6 col-sm-6">

		      <div class="card card-stats">

		        <div class="card-header card-header-danger card-header-icon">

		          <div class="card-icon">

		            <i class="material-icons">info_outline</i>

		          </div>

		          <p class="card-category">@lang('admin-dashboard.trip_booking')</p>

		          <h3 class="card-title">{{ $trip_booking }}</h3>

		        </div>

		        <div class="card-footer">

		        </div>

		      </div>

		    </div>

		    <!--<div class="col-lg-3 col-md-6 col-sm-6">-->

		    <!--  <div class="card card-stats">-->

		    <!--    <div class="card-header card-header-info card-header-icon">-->

		    <!--      <div class="card-icon">-->

		    <!--        <i class="fa fa-twitter"></i>-->

		    <!--      </div>-->

		    <!--      <p class="card-category">@lang('admin-dashboard.ship_booking')</p>-->

		    <!--      <h3 class="card-title">{{ $ship_booking }}</h3>-->

		    <!--    </div>-->

		    <!--    <div class="card-footer">-->

		    <!--    </div>-->

		    <!--  </div>-->

		    <!--</div>-->

	  	</div>

	  	<div class="row">

		  	@role('admin')

		    <!-- <div class="col-md-6">

		      <div class="card card-chart">

		        <div class="card-header card-header-success">

		          <div class="ct-chart" id="dailySalesChart"></div>

		        </div>

		        <div class="card-body">

		          <h4 class="card-title">@lang('admin-dashboard.product_sales')</h4>

		        </div>

		        <div class="card-footer">

		        </div>

		      </div>

		    </div> -->

		    @endrole

		    <div class="col-md-12">

		      <div class="card card-chart">

		        <div class="card-header card-header-warning">

		          <div class="ct-chart" id="websiteViewsChart"></div>

		        </div>

		        <div class="card-body">

		          <h4 class="card-title">@lang('admin-dashboard.trip_sales')</h4>

		        </div>

		        <div class="card-footer">

		        </div>

		      </div>

		    </div>

		    <!--<div class="col-md-4">-->

		    <!--  <div class="card card-chart">-->

		    <!--    <div class="card-header card-header-danger">-->

		    <!--      <div class="ct-chart" id="completedTasksChart"></div>-->

		    <!--    </div>-->

		    <!--    <div class="card-body">-->

		    <!--      <h4 class="card-title">@lang('admin-dashboard.shipment_sales')</h4>-->

		    <!--    </div>-->

		    <!--    <div class="card-footer">-->

		    <!--    </div>-->

		    <!--  </div>-->

		    <!--</div>-->

	  	</div>

	</div>

</div>

@endsection

@section('admin-additional-js')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="text/javascript">

 if ($('#dailySalesChart').length != 0) {

      /* ----------==========     Daily Sales Chart initialization For Documentation    ==========---------- */



      	<?php

      		$labels = [];

      		$series = [];

      		$max_val = 0;

      	foreach($total_product_sales as $key => $value){

      		$val = (int)($value);

      		if($val > $max_val){

      			$max_val = $val;

      		}

      		array_push($labels, \Carbon\Carbon::parse($key)->format('m:d'));

      		array_push($series, $val);

      	}





      	?>

      	var series = <?php echo json_encode($series); ?>;

      	var labels = <?php echo json_encode($labels); ?>;

      	console.log(series, labels);

      dataDailySalesChart = {

        labels: labels,

        series: [

          series

        ]

      };



      optionsDailySalesChart = {

        lineSmooth: Chartist.Interpolation.cardinal({

          tension: 0

        }),

        low: 0,

        high: <?php echo $max_val+500; ?>, // creative tim: we recommend you to set the high sa the biggest value + something for a better look

        chartPadding: {

          top: 0,

          right: 0,

          bottom: 0,

          left: 0

        },

      }



      var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

    }

    

  	<?php

  		$labels = [];

  		$series = [];

  		$max_val = 0;

  	    foreach($dbData as $key => $value){

      		$val = (int)($value);

            $dateObj   = DateTime::createFromFormat('!m', $value['month']);

            $monthName = $dateObj->format('F');

  		array_push($labels, $monthName);

  		array_push($series, $value['price']);

  	}

    ?>

    var series = <?php echo json_encode($series); ?>;

  	var labels = <?php echo json_encode($labels); ?>;

  	console.log(series, labels);

     var options = {

          series: [ {

          name: 'Total Sales',

          data: series

        }],

          chart: {

          type: 'bar',

          height: 300,

          toolbar: {

              show:false

          },

          foreColor: '#000000',

        },

        

        plotOptions: {

          bar: {

            horizontal: false,

            columnWidth: '30%',

            endingShape: 'rounded'

          },

        },

        dataLabels: {

          enabled: true

        },

       

        stroke: {

          show: false,

          width: 3,

          colors: ['transparent']

        },

        xaxis: {

          categories: labels,

        },

        yaxis: {

          title: {

            text: '$ (thousands)'

          }

        },

        fill: {

          opacity: 1

        },

        tooltip: {

          y: {

            formatter: function (val) {

              return "$ " + val + " thousands"

            }

          }

        }

        };



        var chart = new ApexCharts(document.querySelector("#websiteViewsChart"), options);

        chart.render();

</script>

@endsection

