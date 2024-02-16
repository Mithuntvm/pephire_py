<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

<link rel="preconnect" href="https://fonts.gstatic.com"> 
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;600;700;800&display=swap" rel="stylesheet">



<div class="card_container">
  <div class="stat_card_dashboard">
    <div class="card_content">
      <div class="content_section">
        <p class="title">Users<p>
        <p class="value">{{$userCount}}</p>
      </div>
    </div>
    <div class="icon_space">
      <span class="fa fa-user-circle icon"></span>
    </div>
    
  </div>

      <div class="stat_card_dashboard">
    <div class="card_content">
      <div class="content_section">
        <p class="title">Transactions<p>
        <p id="transaction_count" class="value"></p>
      </div>
    <div class="stat_card_footer">
        <p class="stat_total">Total : 500</p>
        <p class="stat_average">Average: 100</p>
      </div>
    </div>
    <div class="icon_space">
      <span class="fas fa-money-bill icon-green"></span>
    </div>
    
    
  </div>

    <div class="stat_card_dashboard">
    <div class="card_content">
      <div class="content_section">
        <p class="title">WhatsApp Responses<p>
        <p id="whatsApp" class="value"></p>
      </div>
    </div>
    <div class="icon_space">
      <span class="fa fa-user-circle icon"></span>
    </div>
    
  </div>


</div>

@push('styles')
<style>
    .stat_card_dashboard{
  background-color: snow;
  width: 270px;
  height: 85px;
  padding: 5px;
  padding-top: 10px;
  display: flex;
  flex-direction: row;
  border-radius:5px;
  
}
.stat_total{
  color: blue;
}
.stat_average{
  margin-left: 7px;
  color: green;
}
.stat_card_footer{
  font-size: 11px;
  color: gray;

  display: inline-flex;
  width: 100%;
  margin-top: 0px;
  font-weight: 300;
  font-family: 'Poppins', sans-serif;
}

.card_content{
  width: 80%;
  height: 100%;
  padding-left: 20px;

  
}
.icon_space{
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 30%;
  height: 100%
}
.icon{
  font-size: 40px;
  color: red;
}
.icon-green{
  font-size: 40px;
  color: green;   
}
.title{
  font-size: 13px;
  color: gray;

  margin-top: 0px;
  font-weight: 300;
  font-family: 'Poppins', sans-serif;
  
}
.content_section{
  height:50px;
  width: fit-content;
  
}
.value{
  font-size: 30px;
  color: black;
  margin-top: -20px;
  font-weight: 600;

  font-family: 'Poppins', sans-serif;
}
body{
  background-color: grey;
}
.card_container{
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
  align-items: center;
  width: 100%;
  height: 160px;
}

</style>
    
@endpush

@push('scripts')
<script>
        var invoiceRaw = {!! $invoice->toJson() !!}
        var whatsappCountRaw = {!! $whatsappCount->toJson() !!}
        var whatsappCount = whatsappCountRaw.map(w => w["data_completed"]).reduce((a,b) => a + b )
        var invoice_copy = invoiceRaw.map(d => {
          return {
            x: d["created_at"],
            y: Number(d["amount"])
          }
        })
        
        function avgTransactionValue(){
          return totalTransactionValue()/invoiceRaw.length;
        }

        function totalTransactionValue(){
          return invoice_copy.map(d => d.y).reduce((a,b) => a + b)
        }
        

        $("#transaction_average").html(avgTransactionValue());
        $("#transaction_count").html(invoiceRaw.length);
        $("#transaction_total").html(totalTransactionValue());
        $("#whatsApp").html(whatsappCount);
        
</script>
    
@endpush