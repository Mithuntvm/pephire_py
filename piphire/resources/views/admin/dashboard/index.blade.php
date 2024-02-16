@extends('layouts.backend')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
@section('header')
  @include('partials.backend.header')
@endsection

@section('content')
  

@section('sidebar')
  @include('partials.backend.sidebar')
@endsection

@include('admin.dashboard.plans')

<div class="app-content d-flex flex-column align-items-center content">

    @include('admin.dashboard.statcard')
    
    @include('admin.dashboard.sunburst')
  
  {{-- <div class="w-100 d-flex flex-row justify-content-center align-items-center">
      <div class="w-25 d-flex flex-row justify-content-around align-items-center">
        <button onclick="switchGraph(event)" id="userTrend" class="btn btn-primary">User Trend</button>
        <button onclick="switchGraph(event)" id="transactionTrend" class="btn btn-primary">Transaction Trends</button>
      </div>
  </div>
       --}}

      {{-- <div class="w-50 infoSection d-flex flex-row flex-wrap">
      <div class="w-50 h-50 card_1"></div>
      <div class="w-50 h-50 card_2"></div>
      <div class="w-50 h-50 card_3"></div>
      <div class="w-50 h-50 card_4"></div>
    </div>--}}
    <div class="w-100 d-flex flex-row">
      @include('admin.dashboard.tabs')
      <div  id="chart_container"></div> 
    </div>
    
  </div>
  

  @push("styles")
    <style>
      .card_section{
        background-color: rgb(255, 168, 117)
      }
      .stat_value{
        color:snow;
        font-size: 60px;
        font-weight: 900;

      }
      .stat_footer{
        color: rgb(255, 255, 255);
        font-size: 15px;
        font-weight: 500;

      }
      .card_1{
        
        border-right: 1px solid grey;
        border-bottom: 1px solid grey;
      }
      .card_2{
        border-bottom: 1px solid grey;
      }
      .card_3{
        border-right: 1px solid grey;
      }
      .card_4{
      
      }
      .infoSection{
        height: 300px;
      }
      .stat_card{
        height: 120px;
        width: 150px;
      }
      .stat_card_3x{
        height: 120px;
        /* width: 460px; */
      }
      #chart_container{
        display: flex;
        flex-direction: row;
     
        width: 100%;
        height: fit-content;
      }
      .bar{
        fill: url(#mainGradient) ;
      }
      .stopBottom{
        stop-color: darkblue;
      }
      .stopTop{
        stop-color: rgb(130, 156, 165);
      }
      .node {
  cursor: pointer;
}

.node:hover {
  stroke: #000;
  stroke-width: 1.5px;
}

.node--leaf {
  fill: white;
}
.heavy { font: bold 30px sans-serif; }
.label {
  font: 15px "Helvetica Neue", Helvetica, Arial, sans-serif;
  text-anchor: middle;
  text-shadow: 0 1px 0 #fff, 1px 0 0 #fff, -1px 0 0 #fff, 0 -1px 0 #fff;
}

.label,
.node--root,
.node--leaf {
  pointer-events: none;
}


    </style>
  @endpush
  
  @push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  {{-- <script src="https://d3js.org/d3.v4.min.js"></script> --}}
   <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/6.5.0/d3.min.js" integrity="sha512-0XfwGD1nxplHpehcSVI7lY+m/5L37PNHDt+DOc7aLFckwPXjnjeA1oeNbru7YeI4VLs9i+ADnnHEhP69C9CqTA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous"></script>
      <script type="text/javascript">


        var userJoinDataRaw = {!! $users->toJson() !!};
        var userJoinData = userJoinDataRaw.map(d => {
          return {x: moment(d["created_at"]), y: 1}
        })
        var invoiceRaw = {!! $invoice->toJson() !!}
        var invoice = invoiceRaw.map(d => {
          return {
            x: moment(d["created_at"]),
            y: Number(d["amount"])
          }
        })
        var plans = {!! $plans->toJson() !!};
        var planType = {!! $planType->toJson() !!};
        // console.log(preparePlanData())
        var planData = preparePlanData();
        

        function switchGraph(event){
          $("#chart_container").empty();
          if (event.target.id == "userTrend"){
            createDateGraph(userJoinData,1150,400,120,100,"Dates", "No. of Users Joined");
          } else if (event.target.id == "transactionTrend"){
            createDateGraph(invoice,1150,400,100,120, "Dates", "No. of Transactions");
          } else if (event.target.id == "plans"){
            createSunBurst();
          }
        }

        

        function avgTransactionValue(){
          return totalTransactionValue()/invoiceRaw.length;
        }

        function totalTransactionValue(){
          return invoice.map(d => d.y).reduce((a,b) => a + b)
        }
        $("#transaction_average").html(avgTransactionValue());
        $("#transaction_count").html(invoiceRaw.length);
        $("#transaction_total").html(totalTransactionValue());
        

        function prepareTimeSeriesData(obj){
            var min = obj.map(o => o.x).reduce((a,b) => a < b ? a : b)
            var itr = min.clone().subtract(1, "months").subtract(min.date() - 1, "days").set({hour:0,minute:0,second:0,millisecond:0})
            var graph_max = moment()
            var dates = []
            while(itr <= graph_max){
              dates.push(itr.clone());
              itr.add(1, "months")
            }
            var newObj = []
            for (var i = 0; i < dates.length; i++){

              var filtered = obj.filter(d => dates[i].month() == d.x.month()  &&  dates[i].year() == d.x.year())
              var count = 0
              if (filtered.length >= 1){
                count +=  filtered.map(d => d.y).reduce( (a,b) => a + b);
              }
              
     
              
              newObj.push({
                x: dates[i],
                y: count
              })
            }
            return newObj
        }





        function createDateGraph(data, width = 600, height = 600, margin_left = 250, margin_bottom  = 200, xLabel="Date", yLabel="Count"){
          // Set the data for the graph
          var data = prepareTimeSeriesData(data);
          // Appends an svg with the given width and height into element with chart container id.
          var svg = d3.select("#chart_container").append("svg").attr("width", width).attr("height", height);
          
          //Create gradient
          var svgDefs = svg.append("defs");
          var mainGradient = svgDefs.append("linearGradient").attr("id", "mainGradient")
          mainGradient.append("stop").attr("class", "stopTop").attr("offset", "0");
          mainGradient.append("stop").attr("class", "stopBottom").attr("offset","1");

          //Width and Height are then updated to reflect the margins
          width = svg.attr("width") - margin_left
          height = svg.attr("height") - margin_bottom
          //Define the scaling functions
          var x_scale = d3.scaleTime().range([0, width])
          var y_scale = d3.scaleLinear().range([height, 0]) 
          // Create a g to which the axes will be appended
          var g = svg.append("g").attr('transform', `translate(${margin_left/2},${margin_bottom/2})` )
    
          g.append("text").attr('transform', `translate(${- margin_left/3},${height/1.5})rotate(-90)`).text(yLabel).attr("font-size", 11).attr("fill", "gray").attr('font-family', `'Poppins', sans-serif`)
          g.append("text").attr('transform', `translate(${ width/2},${height + margin_bottom/2.5})`).text(xLabel).attr("font-size", 11).attr("fill", "gray").attr('font-family', `'Poppins', sans-serif`)
          // Find the min and max for the dates
          var min = data.map(d=>d.x).reduce((a,b) => a < b ? a : b)
          var max = data.map(d=>d.x).reduce((a,b) => a > b ? a : b);
          // Defining the Domains for x and y axis
          x_scale.domain([min, max])
          y_scale.domain([0, d3.max(data.map(d => d.y))])
          // Appending axes to the g element defined above
          g.append("g")
            .attr("transform", `translate(0,${height})`)
            .call(d3.axisBottom(x_scale)
                    .tickFormat(d3.timeFormat("%b, %y"))
                    .ticks(6)).call(g => g.select(".domain").remove());
          g.append("g")
            .call(d3.axisLeft(y_scale)
                    .tickFormat(d => d)
                    .ticks(5)).call(g => g.select(".domain").remove())

          g.selectAll(".bar")
            .data(data)
            .enter().append("rect")
            .attr("class", "bar")
            .attr("x", d => x_scale(d.x))
            .attr("y", d => y_scale(d.y) )
            .attr("width",  (width/data.length))
            .attr("height", d => height - y_scale(d.y))
          
          
        }
        // createDateGraph(invoice,500,400,100,100)
        // createDateGraph(userJoinData,500,400,100,100);



      

        function preparePlanData(){
          var data = [];
          
          for (var j = 0; j < planType.length; j++){
            var obj = {name: planType[j]["name"], children: []}

            for (var i = 0; i < plans.length;i++){
              if (planType[j]["id"] === plans[i]["plantype_id"]){
                obj.children.push({name: plans[i]["name"], size: 30})
              }
            }
            data.push(obj);
          }
          return {name: "PlanType", children: data}
        }


        

        function createZoomableChart(root, width = 600, height = 600){
          console.log(root)
          $("#chart_container").empty();
          var svg = d3.select("#chart_container")
                      .append("svg")
                      .attr("width", width)
                      .attr("height", height)
          var margin = 20;
          var diameter = Math.min(svg.attr("width"), svg.attr("height"))
          var g = svg.append("g")
                     .attr("transform", `translate(${diameter/2},${diameter/2})`)
          var color = d3.scaleLinear()
                        .domain([-1,3])
                        .range(["hsl(230,37.5%,96.9%)", "hsl(228,30%,40%)"])
                        .interpolate(d3.interpolateHcl);
          var pack = d3.pack()
                       .size([diameter - margin, diameter - margin])
                       .padding(5)
          

          root = d3.hierarchy(root)
              .sum(function(d) { return d.size; })
              .sort(function(a, b) { return b.value - a.value; });

          var focus = root;
          var nodes = pack(root).descendants();
          var view;

          var circle = g.selectAll("circle")
            .data(nodes)
            .enter().append("circle")
              .attr("class", function(d) { return d.parent ? d.children ? "node" : "node node--leaf" : "node node--root"; })
              .style("fill", function(d) { return d.children ? color(d.depth) : null; })
              .on("click", function(d) { if (focus !== d) zoom(d), d3.event.stopPropagation(); });

          console.log(nodes)

          // var rect = g.selectAll("rect")
          //             .data(nodes)
          //             .enter()
          //             .append("rect")
          //             .style("display", function(d) { return d.parent === root ? "inline" : "none"; })
          //             .attr("width" , 20)
          //             .attr("height", 20)
          //             .attr("fill","red")
                      

          var text = g.selectAll("text")
            .data(nodes)
            .enter().append("text")
              .attr("class", "label")
              .attr("y", d =>  `${ - d.r * 3/5}`)
              .style("fill-opacity", function(d) { return d.parent === root ? 1 : 0; })
              .style("display", function(d) { return d.parent === root ? "inline" : "none"; })
              .text(function(d) { return d.data.name; })

              ;
 
          var node = g.selectAll("circle,text");

          svg.style("background", color(-1))
              .on("click", function() { zoom(root); });

          zoomTo([root.x, root.y, root.r * 2 , root.r * 2 + margin]);

          function zoom(d) {
            var focus0 = focus; focus = d;

            var transition = d3.transition()
                .duration(d3.event.altKey ? 7500 : 750)
                .tween("zoom", function(d) {
                  var i = d3.interpolateZoom(view, [focus.x, focus.y, focus.r * 2 + margin]);
                  return function(t) { zoomTo(i(t)); };
                });

            transition.selectAll("text")
                      .filter(function(d) { return d.parent === focus || this.style.display === "inline"; })
                      
                      .style("fill-opacity", function(d) { return d.parent === focus ? 1 : 0; })
                      .on("start", function(d) { if (d.parent === focus) this.style.display = "inline"; })
                      .on("end", function(d) { if (d.parent !== focus) this.style.display = "none"; });
          }

            function zoomTo(v) {
              var k = diameter / v[2]; view = v;
              node.attr("transform", function(d) { return "translate(" + (d.x - v[0]) * k + "," + (d.y - v[1]) * k + ")"; });
              circle.attr("r", function(d) { return d.r * k; });
            }


          
        }

        var plans = {"name":"Plans", "children": [{"name": "Plan A", "children" : [{name: "Plan A1", size: 40}, {name: "Plan A2", size: 40}] }, {"name": "Plan D", "children" : [{name: "Plan D1", size: 40}, {name: "Plan D2", size: 40}] },{"name": "Plan B", "children" : [{name: "Plan B1", size: 40}, {name: "Plan B2", size: 40}] },{"name": "Plan C", "children" : [{name: "Plan C1", size: 40}, {name: "Plan C2", size: 40}] } ]}

        var p = {"name":"Plans","children":{"name":"PlanType","children":[{"name":"Prepaid Plan","children":[{"name":"Free Plan","size":30}]},{"name":"Freelance Plan","children":[{"name":"Freelance Basic","size":30},{"name":"Freelance Optimal","size":30}]},{"name":"Small Business Plan","children":[{"name":"Small Biz Basic","size":30},{"name":"Small Biz Heavy Plan","size":30},{"name":"optimal for small business single user","size":30}]},{"name":"Corporate Plan","children":[{"name":"Corporate Basic","size":30},{"name":"Corporate Optimal","size":30}]}]}}
        var flare = {"name":"variants","children":[{"name":"2","children":[{"name":"p23.3","children":[{"name":"IFT172","children":[{"name":"undefined","size":28},{"name":"aaaacxi7gjs3gascvqjaabaaaq","size":3},{"name":"aaaacxi7gjs3eascvqjaabaaci","size":6},{"name":"aaaacxi7gjs3gascvqjaabaabe","size":6},{"name":"aaaacxi7gjs3gascvqjaabaacm","size":1},{"name":"aaaacxi7gjs3eascvqjaabaaca","size":8},{"name":"aaaacxi7gjs3gascvqjaabaace","size":7},{"name":"aaaacxi7gjs3eascvqjaabaab4","size":5},{"name":"aaaacxi7gjs3gascvqjaabaaae","size":3},{"name":"aaaacxi7gjs3eascvqjaabaace","size":9},{"name":"aaaacxi7gjs3eascvqjaabaacq","size":9},{"name":"aaaacxi7gjs3gascvqjaabaaa4","size":4},{"name":"aaaacxi7gjs3eascvqjaabaaau","size":13},{"name":"aaaacxi7gjs3gascvqjaabaaay","size":5},{"name":"aaaacxi7gjs3eascvqjaabaaby","size":6},{"name":"aaaacxi7gjs3eascvqjaabaabq","size":5},{"name":"aaaacxi7gjs3gascvqjaabaaam","size":6},{"name":"aaaacxi7gjs3iascvqjaabaaaq","size":6},{"name":"aaaacxi7gjs3eascvqjaabaabi","size":5},{"name":"aaaacxi7gjs3iascvqjaabaaae","size":3},{"name":"aaaacxi7gjs3gascvqjaabaacu","size":2},{"name":"aaaacxi7gjs3eascvqjaabaabm","size":3},{"name":"aaaacxi7gjs3gascvqjaabaabu","size":3},{"name":"aaaacxi7gjs3iascvqjaabaaai","size":7},{"name":"aaaacxi7gjs3gascvqjaabaac4","size":3},{"name":"aaaacxi7gjs3gascvqjaabaabq","size":4},{"name":"aaaacxi7gjs3eascvqjaabaaay","size":6},{"name":"aaaacxi7gjs3gascvqjaabaabm","size":2},{"name":"aaaacxi7gjs3iascvqjaabaaa4","size":5},{"name":"aaaacxi7gjs3iascvqjaabaaau","size":7},{"name":"aaaacxi7gjs3gascvqjaabaabi","size":5},{"name":"aaaacxi7gjs3iascvqjaabaaba","size":12},{"name":"aaaacxi7gjs3iascvqjaabaaay","size":4},{"name":"aaaacxi7gjs3gascvqjaabaaca","size":6},{"name":"aaaacxi7gjs3gascvqjaabaacq","size":4},{"name":"aaaacxi7gjs3eascvqjaabaaa4","size":4},{"name":"aaaacxi7gjs3iascvqjaabaabi","size":5},{"name":"aaaacxi7gjs3iascvqjaabaabe","size":1},{"name":"aaaacxi7gjs3gascvqjaabaaci","size":4},{"name":"aaaacxi7gjs3gascvqjaabaaai","size":4},{"name":"aaaacxi7gjs3gascvqjaabaaba","size":2},{"name":"aaaacxi7gjs3gascvqjaabaada","size":1},{"name":"aaaacxi7gjs3eascvqjaabaabe","size":2},{"name":"aaaacxi7gjs3eascvqjaabaacm","size":5},{"name":"aaaacxi7gjs3gascvqjaabaaau","size":2},{"name":"aaaacxi7gjs3iascvqjaabaaam","size":1},{"name":"aaaacxi7gjs3eascvqjaabaaba","size":1},{"name":"aaaacxi7gjs3gascvqjaabaab4","size":3}]}]}]},{"name":"3","children":[{"name":"p21.31","children":[{"name":"CACNA2D2","children":[{"name":"aaaacxi7gjufoascvqjaabaafi","size":2},{"name":"undefined","size":1},{"name":"aaaacxi7gjufqascvqjaabaaae","size":2},{"name":"aaaacxi7gjufqascvqjaabaadu","size":1},{"name":"aaaacxi7gjufqascvqjaabaaee","size":2},{"name":"aaaacxi7gjufqascvqjaabaace","size":1},{"name":"aaaacxi7gjufqascvqjaabaaca","size":2},{"name":"aaaacxi7gjufqascvqjaabaad4","size":2}]},{"name":"LARS2","children":[{"name":"aaaacxi7gj6pmascvqjaabaag4","size":30},{"name":"aaaacxi7gj6pmascvqjaabaagy","size":9},{"name":"aaaacxi7gj6pmascvqjaabaaga","size":16},{"name":"aaaacxi7gj6pmascvqjaabaagq","size":8},{"name":"aaaacxi7gj6pmascvqjaabaahi","size":11},{"name":"aaaacxi7gj6pmascvqjaabaagm","size":14},{"name":"aaaacxi7gj6pmascvqjaabaage","size":1},{"name":"undefined","size":10},{"name":"aaaacxi7gj6pmascvqjaabaaia","size":12},{"name":"aaaacxi7gj6pmascvqjaabaahy","size":15},{"name":"aaaacxi7gj6pmascvqjaabaafq","size":8},{"name":"aaaacxi7gj6pmascvqjaabaaha","size":10},{"name":"aaaacxi7gj6pmascvqjaabaagu","size":12},{"name":"aaaacxi7gj6pmascvqjaabaaf4","size":10},{"name":"aaaacxi7gj6pmascvqjaabaahq","size":10}]}]}]},{"name":"7","children":[{"name":"q22.1","children":[{"name":"TFR2","children":[{"name":"aaaacxi7gjz4wascvqjaabaadq","size":2},{"name":"aaaacxi7gjz4yascvqjaabaaaq","size":1},{"name":"undefined","size":24},{"name":"aaaacxi7gjz4wascvqjaabaacq","size":4},{"name":"aaaacxi7gjz4yascvqjaabaaay","size":1},{"name":"aaaacxi7gjz4wascvqjaabaadm","size":1},{"name":"aaaacxi7gjz4wascvqjaabaacy","size":2},{"name":"aaaacxi7gjz4yascvqjaabaabi","size":2},{"name":"aaaacxi7gjz4yascvqjaabaaau","size":6}]}]}]},{"name":"9","children":[{"name":"q22.2","children":[{"name":"SECISBP2","children":[{"name":"undefined","size":30},{"name":"aaaacxi7gkabkascvqjaabaaea","size":9},{"name":"aaaacxi7gkabkascvqjaabaae4","size":6},{"name":"aaaacxi7gkabkascvqjaabaaf4","size":6},{"name":"aaaacxi7gkabkascvqjaabaaey","size":7},{"name":"aaaacxi7gkabkascvqjaabaafq","size":10}]}]}]},{"name":"12","children":[{"name":"q15","children":[{"name":"NUP107","children":[{"name":"undefined","size":16},{"name":"aaaacxi7gj74sascvqjaabaaby","size":10},{"name":"aaaacxi7gj74sascvqjaabaade","size":7},{"name":"aaaacxi7gj74sascvqjaabaadq","size":9},{"name":"aaaacxi7gj74sascvqjaabaab4","size":7},{"name":"aaaacxi7gj74sascvqjaabaacu","size":9},{"name":"aaaacxi7gj74sascvqjaabaaem","size":7},{"name":"aaaacxi7gj74sascvqjaabaaa4","size":3},{"name":"aaaacxi7gj74sascvqjaabaace","size":8},{"name":"aaaacxi7gj74sascvqjaabaaee","size":7},{"name":"aaaacxi7gj74sascvqjaabaady","size":3},{"name":"aaaacxi7gj74sascvqjaabaabq","size":6},{"name":"aaaacxi7gj74sascvqjaabaaca","size":8},{"name":"aaaacxi7gj74sascvqjaabaabi","size":10},{"name":"aaaacxi7gj74sascvqjaabaabm","size":5},{"name":"aaaacxi7gj74sascvqjaabaacy","size":4},{"name":"aaaacxi7gj74sascvqjaabaada","size":10},{"name":"aaaacxi7gj74sascvqjaabaac4","size":6},{"name":"aaaacxi7gj74sascvqjaabaabu","size":9},{"name":"aaaacxi7gj74sascvqjaabaacm","size":7},{"name":"aaaacxi7gj74sascvqjaabaacq","size":3},{"name":"aaaacxi7gj74sascvqjaabaadu","size":3},{"name":"aaaacxi7gj74sascvqjaabaad4","size":1},{"name":"aaaacxi7gj74sascvqjaabaadi","size":4}]}]}]},{"name":"17","children":[{"name":"p13.1","children":[{"name":"SCO1","children":[{"name":"aaaacxi7gjwlyascvqjaabaacu","size":25},{"name":"aaaacxi7gjwlyascvqjaabaace","size":39}]}]}]},{"name":"19","children":[{"name":"q13.2","children":[{"name":"SPINT2","children":[{"name":"aaaacxi7gjuvmascvqjaabaadm","size":1},{"name":"undefined","size":5},{"name":"aaaacxi7gjuvmascvqjaabaadi","size":3},{"name":"aaaacxi7gjuvmascvqjaabaade","size":6},{"name":"aaaacxi7gjuvmascvqjaabaac4","size":6},{"name":"aaaacxi7gjuvmascvqjaabaada","size":4},{"name":"aaaacxi7gjuvmascvqjaabaadu","size":2},{"name":"aaaacxi7gjuvmascvqjaabaadq","size":1}]}]},{"name":"p13.12","children":[{"name":"PRKACA","children":[{"name":"aaaacxi7gkb32ascvqjaabaagi","size":9}]}]}]},{"name":"22","children":[{"name":"q13.33","children":[{"name":"SCO2","children":[{"name":"undefined","size":32},{"name":"aaaacxi7gka5qascvqjaabaaai","size":35},{"name":"aaaacxi7gka5oascvqjaabaacq","size":7},{"name":"aaaacxi7gka5qascvqjaabaaay","size":21},{"name":"aaaacxi7gj4eqascvqjaabaab4","size":115},{"name":"aaaacxi7gka5oascvqjaabaacm","size":5}]}]}]}]}
        // createZoomableChart(planData,1300,600);
        createSunBurst();
        
      

 
      </script>
  @endpush
</div>





@endsection

@section('footer')
  @include('partials.backend.footer')
@endsection  