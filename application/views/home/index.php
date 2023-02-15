 <!-- Main Content -->
          <div class="row mt-3">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 card-primary">
                <div class="card-icon bg-primary">
                  <i class="fas fa-credit-card"></i>
                </div>
                <div class="card-wrap">
                  <div style="line-height:15px;" class="card-header pr-0">
                    <b>Piutang <br>Jatuh Tempo</b>
                  </div>
                  <div class="card-body pb-2 font-weight-light text-right pt-5" style="font-size:15px;">
                     Rp.<span class="money"><?=$tot_piutang?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 card-danger">
                <div class="card-icon bg-danger">
                  <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="card-wrap">
                  <div style="line-height:15px;" class="card-header pr-0">
                    <b>Hutang <br> Jatuh tempo</b>
                  </div>
                   <div class="card-body pb-2 font-weight-light text-right pt-5" style="font-size:15px;">
                      Rp.<span class="money"><?=$tot_hutang?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 card-warning">
                <div class="card-icon bg-warning h3">
                  <i class="fas fa-cubes"></i>
                </div>
                <div class="card-wrap">
                  <div style="line-height:15px;" class="card-header pr-0">
                    <b>Stok <br> Minimum</b>
                  </div>
                   <div class="card-body pb-2 font-weight-light text-right pt-5" style="font-size:15px;">
                      <?=$tot_stockMin?> Item
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1 card-success">
                <div class="card-icon bg-success text-light h4">
                  <i class="fa fa-download"></i>
                </div>
                <div class="card-wrap">
                  <div style="line-height:15px;" class="card-header pr-0">
                    <b>Omset <br> Hari Ini</b>
                  </div>
                   <div class="card-body pb-2 font-weight-light text-right pt-5" style="font-size:15px;">
                   Rp.<span class="money"><?=$tot_penj?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h4>Penjualan Perbulan</h4>
                  <div class="card-header-action">
                    <div class="btn-group">
                      <a href="#" class="btn btn-primary"><?=date("Y")?></a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart" height="182"></canvas>
                </div>
                <div class="card-footer">
                    <h6 class="text-primary">Total : <span class="total-penj text-dark"></span><h6>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card card-primary">
                <div class="card-header pb-0">
                  <h4>Memo</h4>
                </div>
                <div class="card-body pt-0">
                  <div class="text-center pt-1 pb-3">
                    <div class="input-group">
                      <input class="form-control" type="text" name="memo" id="isi_chat" placeholder="Tulis Pesan di sini" value="" autocomplete="off">
                      <div class="input-group-append">
                        <button class="btn btn-success" type="button" id="btn_chat"><i class="fa fa-paper-plane"></i></button>
                      </div>
                    </div>
                  </div>
                  <ul class="list-unstyled list-unstyled-border" style="max-height:320px; overflow: auto;" id="formChat">
                   
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
              <div class="card card-danger">
                <div class="card-header">
                  <h4 class="text-danger">Omset Penjualan</h4>
                  <div class="card-header-action">
                    <div class="form-inline">
                      <select class="form-control" id="setPerkiraan">
                      <?php
                        $g = 0;
                        foreach ($akunPend as $key => $value) { 
                         echo '<option value="'.$value->akun.'">'.$value->nama.'</option>';
                      } ?>
                      </select>
                      <div class="btn-group ml-3">
                        <a href="#" class="btn btn-danger"><?=date("Y")?></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body" id="tabChart">
                    <canvas id="myChart1" height="182"></canvas>
                </div>
                <div class="card-footer">
                    <h6 class="text-danger">Total : <span class="total-all text-dark"></span><h6>
                </div>
              </div>
            </div>
          </div>

      

<script src="<?=base_url('assets/libs/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?=base_url('assets/libs/jquery/dist/jquery-dateformat.js'); ?>"></script>
<script src="<?=base_url('assets/libs/chart.js/dist/Chart.min.js');?>"></script>

<script>
  function loadChat() {
    $.getJSON("<?=site_url('Home/getChating')?>", function(json){
      var html = "";
        for(i=0; i<json.length; i++){
          var waktu = new Date(json[i].waktu);
           html += '<li class="media">'+
              '<img class="mr-3 rounded-circle" width="50" src="<?=base_url()?>assets/images/avatar-1.png" alt="avatar">'+
              '<div class="media-body">'+
                '<div class="float-right text-primary"><small>'+waktu.format("dd-mmm-yy | HH:MM")+'</small></div>'+
                '<div class="media-title">'+json[i].n_user+'</div>'+
                '<span class="text-small text-muted">'+json[i].chat+'</span>'+
              '</div>'+
            '</li>';
        }
        $('#formChat').html(html)
    });  
  }
  $('#btn_chat').click(function() {
    var chat = $('#isi_chat').val();
    $.getJSON("<?=site_url('Home/addChat?i_chat=')?>"+chat , function(json){
      loadChat();
      $('#isi_chat').val('')
    });
  });
  $(document).ready(function() {
    setStatistic($("#setPerkiraan option:first").val(),[]);
    loadChat();
  });
  var inter = setInterval(function () {
      loadChat();
  },10000); 

  number_format = function (number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }
  $(".money").each(function(){
    $(this).text(number_format(parseFloat($(this).text()),2,'.',','));
  });
var statistics_chart = document.getElementById("myChart").getContext('2d');
var dataTotal = [];
var totalPenj = 0;
$.getJSON("<?=site_url('Home/getPenjualan')?>", function(json){
  // console.log(json);
  for(i=0; i<json.length; i++){
    dataTotal.push(json[i].total);
    totalPenj += parseFloat(json[i].total);
  };
  var maxVal = Math.max.apply(Math,dataTotal);
  var lMaxVal = Math.pow(10,maxVal.toString().length); 
  var myChart = new Chart(statistics_chart, {
    type: 'line',
    data: {
      labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli","Agustus","September","Oktober","November","Desember"],
      datasets: [{
        label: 'Statistics',
        data: dataTotal,
        borderWidth: 2,
        backgroundColor: 'rgba(63,82,227,.8)',
        borderWidth: 0,
        borderColor: 'transparent',
        pointBorderWidth: 0,
        pointRadius: 3.5,
        pointBackgroundColor: 'rgba(254,86,83,.8)',
        pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
        pointBorderColor: 'rgba(254,86,83,.8)',
        pointRadius: 4
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
          drawBorder: false,
          color: '#f2f2f2',
          },
          ticks: {
          beginAtZero: true,
          stepSize: Math.round(maxVal / lMaxVal) * lMaxVal/5,
          callback: function(value, index, values) {
            return 'Rp.' + number_format(value,0,'.',',');
          }
        }
      }],
        xAxes: [{
          gridLines: {
            color: '#fbfbfb',
            lineWidth: 2
          }
        }]
      },
    }
  });
  $('.total-penj').text('Rp. '+number_format(totalPenj,0,'.',','));
});
function setStatistic(akunSet,dataTotal1) {
  $('#myChart1').remove(); // this is my <canvas> element
  $('#tabChart').append('<canvas id="myChart1" height="182"></canvas>');
  var totalAll = 0;
  var statistics_chart1 = document.getElementById("myChart1").getContext('2d');
  $.getJSON("<?=site_url('Home/getStatPerkiraan?akun=')?>"+akunSet, function(json){
    // console.log(json);
    for(i=0; i<json.length; i++){
      dataTotal1.push(json[i].total);
      totalAll += parseFloat(json[i].total);
    };
    let maxVal = Math.max.apply(Math,dataTotal1);
    let lMaxVal = Math.pow(10,maxVal.toString().length); 
    let myChart = new Chart(statistics_chart1, {
      type: 'line',
      data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli","Agustus","September","Oktober","November","Desember"],
        datasets: [{
          label: 'Statistics',
          data: dataTotal1,
          borderWidth: 2,
          backgroundColor: 'rgba(254,86,83,.8)',
          borderWidth: 0,
          borderColor: 'transparent',
          pointBorderWidth: 0,
          pointRadius: 3.5,
          pointBackgroundColor: 'rgba(63,82,227,.8)',
          pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
          pointBorderColor: 'rgba(63,82,227,.8)',
          pointRadius: 4
        }]
      },
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            gridLines: {
            drawBorder: false,
            color: '#f2f2f2',
            },
            ticks: {
            beginAtZero: true,
            stepSize: Math.round(maxVal / lMaxVal) * lMaxVal/5,
            callback: function(value, index, values) {
              return 'Rp.' + number_format(value,0,'.',',');
            }
          }
        }],
          xAxes: [{
            gridLines: {
              color: '#fbfbfb',
              lineWidth: 2
            }
          }]
        },
      }
    });
    $('.total-all').text('Rp. '+number_format(totalAll,0,'.',','));
  });
}

$('#setPerkiraan').change(function() {
  setStatistic($(this).val(),[]);
});

</script>

