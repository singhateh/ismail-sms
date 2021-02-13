<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html  lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Marks Sheet</title>
    <link rel="stylesheet" href="{{ asset('backend/results/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/results/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/results/result.css') }}">
    {{-- <link rel="stylesheet" href="http://school.test/backend/results/style.css">
    <link rel="stylesheet" href="http://school.test/backend/results/stylesheet.css">
    <link rel="stylesheet" href="http://school.test/backend/results/result.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<style>

</style>
<body class="scms-result-print page">
  <button class="btn-print block" onclick="printDiv('printableArea')">Print as PDF </button>
{{-- @foreach ($data as $item) --}}
  <div id="printableArea">
  <div class="wraperResult">
    <div class="resHdr-bottom">

 <div class="container-fluid">

  <table style="width:100%" class="header-title">
  <tr>
  <td   style="text-align: left">
 <span style="line-height:1.6; font-weight: bold; text-transform:uppercase">
  <img src="{{asset('backend/images/logo-dark.png')}}" alt="" class="resLogo"  style="width:90px; margin-left:30px">
  </span>
  </td>
  <td   style="text-align: right">
  
   <span style="line-height:1.3; font-size:14px; font-weight: bold; text-transform:uppercase; font-family:'Times New Roman', Times, serif">
  Angle Rue Dumez et Multidor, Maïs Gâté <br>
  Port-au-Prince, Haïti <br>
  www.amusarts.net  <br>
  50937436044 <br>
  pmucommunucatiion@gmail.com
  </span>
  </td>

  </tr>
  </table>
  <hr class="hr-class">
  <div class="" style="text-align: center !important; font-size:15px;">
            <strong >BULLETIN SCOLAIRE <br>
          Année Scolaire {{ $student->year_name }}</strong>
  </div>
  <table style="width:100%" class="header-title">
  <tr>
  <td   style="text-align: left">
 <span style="line-height:1.6;  font-size:12px; font-weight: bold; text-transform:uppercase">
   <label for="">Nom: </label> &nbsp;
   <span> {{ $firstname }} </span> <br>

   <label for="">Prénom: </label> &nbsp;
   <span> {{ $lastname }} </span>
  </span>
  </td>
  <td  style="text-align: right">
   <span style="line-height:1.6;  font-size:12px; font-weight: bold; text-transform:uppercase">
    <label for="">Class: </label> &nbsp;
   <span> {{ $student->class_name }}</span> <br>

   <label for="">Période: </label> &nbsp;
   <span style="font-weight: bold">  7 Jan - 14 Fév 2020 </span>
  </span>
  </td>

  </tr>
  </table>
           
        </div><!-- end of schoolIdentity -->
    </div><!-- end of resHdr -->

    <div class="resContainer">

        <div class="btmcontainer">
            <div class="overalreport-left overalreportAll">
    <table  style="margin-top: 5%; width:480px !important">
      <thead>
        <tr >
          <td  class="td1" colspan="3" align="right"><b>Période</b>&nbsp; </td>
          <td  class="td-body rotated_cell" style="text-align: center !important; padding-left: 4% !important" rowspan="3"> <div class="rotate_text"> coefficients</div> </td>
          <td  class="td-header" colspan="4"> <strong>{{ $student->periode_name }}</strong> </td>
          <td  class="td-body rotated_cell" rowspan="3" style="padding-left: 3% !important"> <div class="rotate_text">Mention</div> </td>
        </tr>
        <tr>
          <td  class="td-body" colspan="3">Matières </td>
          <td  class="td-body1" colspan="1"> 20% </td>
          <td  class="td-body1" colspan="1"> 30% </td>
          <td  class="td-body1"> 50% </td>
          <td  class="td-body1"> 100% </td>
        </tr>
        <tr>
          <td  class="td" align="left" colspan="3" style="font-size: 12px; background:#FFE4E1">Langues, Littératures Et Art  </td>
          <td  class="td-body" style="background:#FFE4E1;"> DT </td>
          <td  class="td-body" style="background:#FFE4E1;"> TT </td>
          <td  class="td-body" style="background:#FFE4E1;"> EF </td>
          <td  class="td-body" style="background:#FFE4E1;"> NT </td>
        </tr>
        
      </thead>
    <tbody>
        
      @foreach($subcollection as $key => $subject)
        
        @if(!empty($subject))
      <tr >
        @if ($loop->first)
            <td  class="td" rowspan="6" style="width:2px !important"></td>
          <td  class="td" colspan="2" style="border-bottom:2px solid #000000 !important"><b>&nbsp; {{$subject['sub_name']}}</b></td>
        @else 
        <td  class="td" colspan="2" style="border-bottom:2px solid #000000 !important">&nbsp; {{$subject['sub_name']}}</td>
        @endif
        
        <td  class="td-body" style="width:20px !important;"> {{$subject['marks']}}</td>
        <td  class="td-body"> {{$subject['homework_total']}}</td>
        <td  class="td-body"> {{$subject['test_total']}}</td>
        <td  class="td-body"> {{$subject['final_exam']}}</td>
        <td  class="td-body"> {{$subject['all_total']}}</td>
        <td  class="td-body"> {{$subject['mark_grade']}}</td>
      </tr>
        @endif
        @endforeach
    </tbody>
    <tfoot>
      <tr >
        <td class="td-footer" rowspan="3"></td>
        <td  class="td-footer" style="border: none; font-size: 13px; margin-top: 10px; line-height: 2px" colspan="2" class="footer" align="right">Sur</td>
        <td  class="td" colspan="2" align="center"> {{$sumofMarks->where('student_id', $student->student_id)->sum('total')}}</td>
        <td  class="td" colspan="2" align="right"> <b>Total</b></td>
        <td  class="td" colspan="2" align="center" ><b>2800</b></td><br>
        <tr>
        <td  class="td-footer" style="border: none; font-size: 13px; margin-top: 10px; line-height: 2px" colspan="2" class="footer" align="right"></td>
          <td  class="td" colspan="2" align="center"> 10</td>
        <td  class="td" colspan="2" align="right"> <b>Moyenne</b></td>
        <td  class="td" colspan="2"></td>
        </tr>
         <tr>
        <td  class="td-footer" style="border-left: 0px;  font-size: 13px; margin-top: 10px; line-height: 2px" colspan="2" class="footer" align="right">Nombre d’élèves</td>
          <td  class="td" colspan="2" align="center"> {{ $avg_student }} </td>
        <td  class="td" colspan="2" align="right"> <b>Place</b></td>
        <td  class="td" colspan="2"></td>
        </tr>
      </tr>
  </table>
          
  <style>
    .table-design{
      border: 2px solid #000000 !important;
    }
  </style>
            </div><!-- end of overalreport -->

            <div class="overalreport-right gpagrading-right" style="margin-top:10%">
                <label class="" style="font-size: 15px; margin-top:2%; font-weight:bold;">Disciplines Générales et Valeurs</label>
                <table class="pagetble" style="height:181px; font-size:10px !important" >
                    <thead>
                    <tr>
                        <td  colspan="3" align="right" style="border-left: 1px solid #fff !important"></td>
                        <td  class="td" colspan="6" style="background:#FFE4E1; font-size:11px !important"> Observations </td>
                    </tr>
                    <tr>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="3">Retard </td>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="4">  </td>
                    </tr>
                    <tr>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="3">Absence </td>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="4">  </td>
                    </tr>
                    <tr>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="3">Respect + Discipline  </td>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="4"> </td>
                    </tr>
                    <tr>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="3"><b>Solidarité + Participation</b> </td>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="4"> </td>
                    </tr>
                    <tr>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="3">Esprit de services  </td>
                        <td  style="font-size:10px !important; text-align:left" class="td" colspan="4"> </td>
                    </tr>
                    </thead>
                </table>
                   
                    <br>
                <table style="width: 100% !important; height:106px; border-top: 1px solid gray" class="pagetble" >
                    <tbody>
                        <thead >
                        <tr>
                            <td  colspan="6" align="left" style="background:#FFE4E1"><b>Moyenne </b></td>
                            <td  colspan="6" align="left" style="background:#FFE4E1"><b>Observation </b></td>
                        </tr>
                        <tr>
                            <td  class="td" colspan="6" rowspan="3"></td>
                            <td  class="td" colspan="6" rowspan="3"> </td>
                        </tr>
                        </thead>
                    </table>
                    <br>
                    <table class="pagetble" style="height:181px; font-size:10px; border-top: 1px solid gray">
                    <thead >
                    <tr>
                        <td  colspan="3" align="left" style="background:#FFE4E1"><b>Légende</b></td>
                    </tr>
                    <tr>
                        <td  class="td-bottom" colspan="3">Mention  </td>
                        <td  class="td-bottom" colspan="4"> Équivalence </td>
                        <td  class="td-bottom" colspan="4"> DT: Devoir total </td>
                    </tr>
                    <tr>
                        <td  class="td-bottom" colspan="3">EX : Excellent </td>
                        <td  class="td-bottom" colspan="4"> A= (90-100) </td>
                        <td  class="td-bottom" colspan="4"> TT=Test total </td>
                    </tr>
                    <tr>
                        <td  class="td-bottom" colspan="3">TB= Très Bien </td>
                        <td  class="td-bottom" colspan="4"> B= (80-89) </td>
                        <td  class="td-bottom" colspan="4"> EF: évaluation finale </td>
                    </tr>
                    <tr>
                        <td  class="td-bottom" colspan="3"><b>AB= Assez Bien</b> </td>
                        <td  class="td-bottom" colspan="4"> C= (70-79)  </td>
                        <td  class="td-bottom" colspan="4"> Nt=Notes Totales </td>
                    </tr>
                    <tr>
                        <td  class="td-bottom" colspan="3">AB= Assez Bien </td>
                        <td  class="td-bottom" colspan="4"> D= (50-69)</td>
                        <td  class="td-bottom" colspan="4"> ITAP: Initiation à la Technologie et aux </td>
                    </tr>
                    <tr>
                        <td  class="td-bottom" colspan="3">TF: Très Faible  </td>
                        <td  class="td-bottom" colspan="4"> E : (≤49) </td>
                        <td  class="td-bottom" colspan="4"> Activités Productive</td>
                    </tr>
                    </thead>
                </table>
                <br>
                    <strong  class="signa">Signatures</strong><br><br>
                <label for="">Direction </label>  
                <div class="" style="float: right;">
                    <hr class="signature"><br>
                    <p for="" style="text-align: center !important; margin-top: 2px ">Parents</p>
                </div>
                
                
            </div><!-- end of overalreport -->


        </div><!-- end of resmidcontainer -->
    </div><!-- end of resContainer -->
    <hr class="signature-director" >
   <div class="" style="text-align: center !important">
        <label for="" > Ismael JOSEPH <br> Director</label>
   </div>
   
   <div class="footerResult" style="text-align: center !important; font-size:11px">
       <p>"… Faites tout pour la gloire de DIEU” 1 Co 10 :31</p>
   </div>
{{-- @endforeach --}}
<script>
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

</script>
</body><!-- end of fromwrapper-->


</html>

