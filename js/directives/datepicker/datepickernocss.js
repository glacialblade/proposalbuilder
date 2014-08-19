angular.module("datepicker",[])
.directive('datepicker',function($parse){
    return{
        restrict:"A",
        require:"ngModel",
        scope:{
            format:"=",
            allowonly:"@"
        },
        controller:function($scope,$compile,$element,$timeout){
            $scope.init = function(ngModel){
                $scope.appendcss();
                $scope.view = "date";
                $scope.ngModel = ngModel;
                $scope.startof = angular.element($element).attr("startof");
                $scope.endof = angular.element($element).attr("endof");
                $scope.d = 0;
                $scope.show = false;
                $scope.monthArray = new Array("January","February","March","April","May","June","July","August","September","October","November","December");
                
                $scope.currentval = $element.val().split("-");
                if($scope.currentval != ""){
                    $scope.y = parseInt($scope.currentval[0],10);
                    $scope.m = parseInt($scope.currentval[1],10) - 1;
                }
                else{
                    var now = new Date();
                    $scope.m = now.getMonth();
                    $scope.y = now.getFullYear();
                }

                if($scope.allowonly){
                    $scope.filterdate = JSON.parse(String($scope.allowonly));
                }
            }
            $scope.appendcss = function(){
                var head = document.querySelector("head");
                var css = "<style id='datepickercss'> .datepicker{width:250px;border:thin solid #aaaaaa;background:white;z-index:1000;margin-top:5px;}.datepicker_wrapper{/*padding:5px;*/}.datepicker_header{position:relative;text-align:center;font-weight:bold;color:white;padding:8px;background: #005892;}.datepicker_header_text{cursor:pointer;width:70%;margin:0 auto;}.datepicker_header_left{cursor:pointer;position:absolute;top:0px;left:0px;width:15%;height:36px;line-height:35px;}.datepicker_header_right{cursor:pointer;position:absolute;top:0px;right:0px;width:15%;height:36px;line-height:35px;}.datepicker_table table{width:100%;font-size:12px;table-layout:fixed;padding:5px;}.datepicker_table thead tr td{font-weight:bold;}.datepicker_table tbody tr td{cursor:pointer;background:#eeeeee;}.datepicker_table tbody tr td.disable{opacity:0.4;filter:alpha(opacity=40);}.datepicker_table tbody tr td.datepicker_currentval{background:#005892;color:white;}.datepicker_table tr td{text-align:center;height:25px;color:#005892;}.datepicker_table tbody tr td:hover{background:#0094d8;color:white;}.datepicker_timewrapper{width:280px;margin:0 auto;text-align:center;}.datepicker_input{width:15px !important;text-align:center;border:1px solid #aaaaaa;} </style>";
                angular.element(head).append(css);
            }

            $scope.removecss = function(){
                var datepickercss = document.querySelector("#datepickercss");
                angular.element(datepickercss).remove();
            }

            //==================================DATEPICKER WRAPPER====================================//
            $scope.appenddatepicker = function(){
                var sHtml = '<div class="datepicker" id="datepicker_'+$scope.elid+'">';
                        sHtml += '<div class="datepicker_wrapper" id="datepicker_wrapper_'+$scope.elid+'">';
                            sHtml += '<div class="datepicker_header" id="datepicker_header_'+$scope.elid+'">';
                                sHtml += '<div class="datepicker_header_left" id="datepicker_header_left_'+$scope.elid+'"><<</div>';
                                sHtml += '<div class="datepicker_header_text" id="datepicker_header_text_'+$scope.elid+'"></div>';
                                sHtml += '<div class="datepicker_header_right" id="datepicker_header_right_'+$scope.elid+'">>></div>';
                            sHtml += '</div>';
                            sHtml += '<div class="datepicker_table" id="datepicker_table_'+$scope.elid+'"></div>';
                        sHtml += '</div>';
                    sHtml += '</div>';
                
                var body = document.querySelector("body");
                
                angular.element(body).append(sHtml);
                $scope.navigationbinding();
                $scope.fixdate();
                $scope.fixcss();

                var datepicker = document.querySelector("#datepicker_"+$scope.elid);
                $scope.fadeeffect.fadein(datepicker,20);

                if($scope.time){
                    $scope.appendtime();
                }
            }
            $scope.fixcss = function(){
                var datepicker = document.querySelector("#datepicker_"+$scope.elid);

                var pos = $scope.positioning.findPos($element[0]);
                var elementheight = $element[0].clientHeight;

                angular.element(datepicker).css({
                    "opacity":"0",
                    "filter":"alpha(opacity=0)",
                    "position":"absolute",
                    "top":pos[1]+elementheight+"px",
                    "left":pos[0]+"px"
                });
            }

            //================================TIME================================//
            $scope.appendtime = function(){
                var timewrapper = document.querySelector("#datepicker_"+$scope.elid+" .datepicker_wrapper");
                var sHtml = "<div class='datepicker_timewrapper'>";

                sHtml += "<input type='text' maxlength='1' id='1' class='datepicker_input' /> ";
                sHtml += "<input type='text' maxlength='1' id='2' class='datepicker_input' /> : ";
                sHtml += "<input type='text' maxlength='1' id='3' class='datepicker_input' /> ";
                sHtml += "<input type='text' maxlength='1' id='4' class='datepicker_input' /> : ";
                sHtml += "<input type='text' maxlength='1' id='5' class='datepicker_input' /> ";
                sHtml += "<input type='text' maxlength='1' id='6' class='datepicker_input' />";

                sHtml += "</div>";
                angular.element(timewrapper).append(sHtml);
                $scope.time_binding();
                $scope.fixtime();
            }
            $scope.fixtime = function(){
                var cd = new Date();
                var hours = cd.getHours();
                var minutes = cd.getMinutes();
                var seconds = cd.getSeconds();
                var values = new Array();
                if(hours < 10){
                    hours = "0"+hours;
                }
                if(minutes < 10){
                    minutes = "0"+minutes;
                }
                if(seconds < 10){
                    seconds = "0"+seconds;
                }
                values[0] = String(hours)[0];
                values[1] = String(hours)[1];
                values[2] = String(minutes)[0];
                values[3] = String(minutes)[1];
                values[4] = String(seconds)[0];
                values[5] = String(seconds)[1];

                var timeinputs = document.querySelectorAll(".datepicker_input");
                for(var i in timeinputs){
                    if(i < 6){
                        angular.element(timeinputs[i]).val(values[i]);
                    }
                }
            }
            $scope.gettime = function(){
                var timeinputs = document.querySelectorAll(".datepicker_input");
                var value = "";
                for(var i in timeinputs){
                    if(i < 6){
                        value += angular.element(timeinputs[i]).val();
                        if(i % 2 != 0 && i != 5){
                            value += ":";
                        }
                    }
                }

                return value;
            }

            //===================================DATEPICKER VIEWs===================================//
            // YEAR VIEW(3rd view)
            $scope.fixyears = function(){
                $scope.view = "years";
                var datepicker_header_text = document.querySelector("#datepicker_header_text_"+$scope.elid);
                var sHtml = ($scope.y*1-7) + "-" + ($scope.y*1+7);
                angular.element(datepicker_header_text).html(sHtml);

                var year = $scope.y*1-7;

                sHtml = "";
                sHtml += '<table class="datepicker_main_table">';
                    for(var i=0;i<5;i++){
                        sHtml += '<tr class="datepicker_table_row">';
                            for(var x=0;x<3;x++){
                                var currentclass = "";
                                if(year == parseInt($scope.currentval[0],10)){
                                    currentclass = "datepicker_currentval";
                                }
                                sHtml += '<td class="datepicker_years '+currentclass+'">'+year+'</td>';
                                year++;
                            }
                        sHtml += '</tr>';
                    }
                sHtml += '</table>';

                var datepicker_table = document.querySelector("#datepicker_table_"+$scope.elid);
                angular.element(datepicker_table).html(sHtml);

                $scope.years_binding();
            }

            // MONTH VIEW(2nd view)
            $scope.fixmonths = function(){
                $scope.view = "months";
                var datepicker_header_text = document.querySelector("#datepicker_header_text_"+$scope.elid);
                var sHtml = '<span class="datepicker_goto_years" id="datepicker_goto_years_'+$scope.elid+'">'+$scope.y+'</span>';
                angular.element(datepicker_header_text).html(sHtml);
                $scope.gotoyears_binding();

                var currentclass = new Array('','','','','','','','','','','','');

                for(var i in currentclass){
                    if(i == (parseInt($scope.currentval[1],10)-1) &&
                       $scope.y == (parseInt($scope.currentval[0],10))){
                        currentclass[i] = "datepicker_currentval";
                    }
                }

                sHtml = "";
                sHtml += '<table class="datepicker_main_table">';
                    sHtml += '<tr class="datepicker_table_row">';
                        sHtml += '<td class="datepicker_months '+currentclass[0]+'">Jan</td>';
                        sHtml += '<td class="datepicker_months '+currentclass[1]+'">Feb</td>';
                        sHtml += '<td class="datepicker_months '+currentclass[2]+'">Mar</td>';
                    sHtml += '</tr>';
                    sHtml += '<tr class="datepicker_table_row">';
                        sHtml += '<td class="datepicker_months '+currentclass[3]+'">Apr</td>';
                        sHtml += '<td class="datepicker_months '+currentclass[4]+'">May</td>';
                        sHtml += '<td class="datepicker_months '+currentclass[5]+'">Jun</td>';
                    sHtml += '</tr>';
                    sHtml += '<tr class="datepicker_table_row">';
                        sHtml += '<td class="datepicker_months '+currentclass[6]+'">Jul</td>';
                        sHtml += '<td class="datepicker_months '+currentclass[7]+'">Aug</td>';
                        sHtml += '<td class="datepicker_months '+currentclass[8]+'">Sep</td>';
                    sHtml += '</tr>';
                    sHtml += '<tr class="datepicker_table_row">';
                        sHtml += '<td class="datepicker_months '+currentclass[9]+'">Oct</td>';
                        sHtml += '<td class="datepicker_months '+currentclass[10]+'">Nov</td>';
                        sHtml += '<td class="datepicker_months '+currentclass[11]+'">Dec</td>';
                    sHtml += '</tr>';
                sHtml += '</table>';

                var datepicker_table = document.querySelector("#datepicker_table_"+$scope.elid);
                angular.element(datepicker_table).html(sHtml);

                $scope.months_binding();
            }

            // DATE VIEW(1st view)
            $scope.fixdate = function(){
                $scope.view = "date";
                var max_days = $scope.getmaxdays($scope.m,$scope.y);
                var first_day = $scope.getfirstday($scope.m,$scope.y);
               
                var datepicker_header_text = document.querySelector("#datepicker_header_text_"+$scope.elid);
                var sHtml = '<span class="datepicker_goto_months" id="datepicker_goto_months_'+$scope.elid+'">'+$scope.monthArray[$scope.m] + " " + $scope.y+'</span>';
                angular.element(datepicker_header_text).html(sHtml);
                $scope.gotomonths_binding();
                
                sHtml = "";
                sHtml += '<table class="datepicker_main_table">';
                    sHtml += '<thead class="datepicker_table_head">';
                        sHtml += '<tr class="datepicker_table_row">';
                            sHtml += '<td class="datepicker_table_th">Sun</td>';
                            sHtml += '<td class="datepicker_table_th">Mon</td>';
                            sHtml += '<td class="datepicker_table_th">Tue</td>';
                            sHtml += '<td class="datepicker_table_th">Wed</td>';
                            sHtml += '<td class="datepicker_table_th">Thu</td>';
                            sHtml += '<td class="datepicker_table_th">Fri</td>';
                            sHtml += '<td class="datepicker_table_th">Sat</td>';
                        sHtml += '</tr>';
                    sHtml += '</thead>';
                    sHtml += '<tbody class="datepicker_body" id="datepicker_body_'+$scope.elid+'">';
                    var days = 1;
                    var currentclass = "";
                    for(var i=0;i<6;i++){
                        sHtml += '<tr class="datepicker_table_row">';
                        for(var j=0;j<7;j++){
                            // SETS DATES THAT CAN SET VALUES
                            var cansetvalue = true;
                            if($scope.filterdate){
                                cansetvalue = false;
                                if($scope.filterdate.days){
                                    for(var w in $scope.filterdate.days){
                                        if($scope.filterdate.days[w] == j){
                                            cansetvalue = true;
                                            break;
                                        }
                                    }
                                }
                                else if($scope.filterdate.dates){
                                    for(var w in $scope.filterdate.dates){
                                        if($scope.filterdate.dates[w] == days){
                                            cansetvalue = true;
                                            break;
                                        }
                                    }
                                }
                                else if($scope.filterdate.weeks){
                                    for(var w in $scope.filterdate.weeks){
                                        if($scope.filterdate.weeks[w] == i){
                                            cansetvalue = true;
                                            break;
                                        }
                                    }
                                }
                                else if($scope.filterdate.greater){
                                    var d = $scope.filterdate.greater.split("-");
                                    var comparedate = new Date(d[0],d[1],d[2]);
                                    var mm = $scope.m+1;
                                    if(mm < 10){
                                        mm = "0"+mm;
                                    }
                                    var calendardate = new Date($scope.y,mm,days);
                                    if(calendardate > comparedate){
                                        cansetvalue = true;
                                    }
                                }
                                else if($scope.filterdate.lesser){
                                    var d = $scope.filterdate.lesser.split("-");
                                    var comparedate = new Date(d[0],d[1],d[2]);
                                    var mm = $scope.m+1;
                                    if(mm < 10){
                                        mm = "0"+mm;
                                    }
                                    var calendardate = new Date($scope.y,mm,days);
                                    if(calendardate < comparedate){
                                        cansetvalue = true;
                                    }
                                }
                            }
                            // SETS CLASS FOR CURRENT VALUE
                            currentclass = "";
                            if(days == parseInt($scope.currentval[2],10) && 
                               $scope.m == (parseInt($scope.currentval[1],10)-1) &&
                               $scope.y == parseInt($scope.currentval[0],10)){
                                currentclass = "datepicker_currentval";
                            }

                            if(days > max_days){
                                break;
                            }
                            else if(first_day == j){
                                if(cansetvalue){
                                    sHtml += "<td class='datepicker_days "+currentclass+"' data-ng-click='setvalue("+days+")'>"+days+"</td>";
                                }
                                else{
                                    sHtml += "<td class='datepicker_days disable "+currentclass+"'>"+days+"</td>";   
                                }
                                days++;
                            }
                            else if(days <= max_days && days > 1){
                                if(cansetvalue){
                                    sHtml += "<td class='datepicker_days "+currentclass+"' data-ng-click='setvalue("+days+")'>"+days+"</td>";
                                }
                                else{
                                    sHtml += "<td class='datepicker_days disable "+currentclass+"'>"+days+"</td>";   
                                }
                                days++;
                            }
                            else{
                                sHtml += "<td class='datepicker_days disable'>&nbsp;</td>";
                            }
                        }
                        sHtml += "</tr>";
                    }
                    sHtml += '</tbody>';
                sHtml += '</table>';

                var datepicker_table = document.querySelector("#datepicker_table_"+$scope.elid);
                angular.element(datepicker_table).html(sHtml);

                var datepicker = document.querySelector("#datepicker_"+$scope.elid);
                $compile(angular.element(datepicker).find("td"))($scope);
            }

            // GETS THE MAX DAYS OF THE MONTH
            $scope.getmaxdays = function(month,year) {
                month = month*1+1;
                return new Date(year, month, 0).getDate();
            }

            // GETS THE FIRST DAY OF THE MONTH
            $scope.getfirstday = function(month,year){
                return new Date(year, month, 01).getDay();
            }

            //====================================FINAL VALUE=================================//
            // SETS THE FINAL VALUE OF THE DATEPICKER
            $scope.setvalue = function(day){
                var format = angular.element($element).attr("format");
                var error = false;
                $scope.d = day;

                if($scope.d < 10){
                    $scope.d = "0"+$scope.d;
                }

                var date = "";
                $scope.m++;
                if($scope.m < 10){
                    $scope.m = "0"+$scope.m;
                }

                var time = $scope.gettime();
                var date;
                if(time){
                    time = time.split(":");
                    date = new Date($scope.y,$scope.m,$scope.d,time[0],time[1],time[2]);
                }
                else{
                    date = new Date($scope.y,$scope.m,$scope.d,0,0,0);
                }

                if($scope.endof){
                    var endof = $scope.findinput($scope.endof);
                    var aEndof = $scope.slicedatetext(endof);

                    var startdate = new Date(aEndof[0],aEndof[1],aEndof[2],aEndof[3],aEndof[4],aEndof[5]);
                    if(startdate > date && !time){
                        error = true;
                    }
                    else if(startdate >= date && time){
                        error = true;
                    }
                }
                else if($scope.startof){
                    var startof = $scope.findinput($scope.startof);
                    var aStartof = $scope.slicedatetext(startof);

                    var enddate = new Date(aStartof[0],aStartof[1],aStartof[2],aStartof[3],aStartof[4],aStartof[5]);
                    if(enddate < date && !time){
                        error = true;
                    }
                    else if(enddate <= date && time){
                        error = true;
                    }
                }

                if(!error){
                    switch(format){
                        case "yyyy-mm-dd":
                            date = $scope.y+"-"+$scope.m+"-"+$scope.d;
                            break;
                        case "yyyy/mm/dd":
                            date = $scope.y+"/"+$scope.m+"/"+$scope.d;
                            break;
                        default:
                            date = $scope.y+"-"+$scope.m+"-"+$scope.d;
                    }
                    if($scope.time){
                        date += " "+$scope.gettime();
                    }

                    var datepicker = document.querySelector("#datepicker_"+$scope.elid);
                    $scope.ngModel.$setViewValue(date);
                    angular.element($element).val(date);
                    $scope.fadeeffect.fadeout(datepicker,20);
                }
                else{
                    alert("Start date must be lesser than End date.");
                    $scope.m--;
                }
            }

            // FIND A SPECIFIC DATEPICKER - USED TO FIND startof AND endof
            $scope.findinput = function(datepicker){
                var inputs = document.querySelectorAll("input");
                for(var i in inputs){
                    if(angular.element(inputs[i]).attr("datepicker") == datepicker){
                        return inputs[i];
                    }
                }
            }

            // FOR FORMATTING
            $scope.slicedatetext = function(el){
                var format = angular.element(el).attr("format");
                var datetext = angular.element(el).val();
                var split;
                var time = new Array(0,0,0);

                switch(format){
                    case "yyyy-mm-dd":
                        split = datetext.split("-");
                        break;
                    case "yyyy/mm/dd":
                        split = datetext.split("/");
                        break;
                    default:
                        split = datetext.split(" ");

                        if(split.length == 1){
                            split = datetext.split("-");
                        }
                        else{
                            time = split[1].split(":");
                            split = split[0].split("-");
                        }
                        for(var i in time){
                            split.push(time[i]);
                        }
                }

                return split;
            }

            $scope.positioning = {
                findPos: function(obj) {
                    var curleft = curtop = 0;
                    if (obj.offsetParent) { 
                        do {
                            curleft += obj.offsetLeft;
                            curtop += obj.offsetTop;    
                        } while (obj = obj.offsetParent);
                    }
                    return [curleft,curtop];
                },
                getPageScroll: function() {
                    var xScroll, yScroll;
                    if (self.pageYOffset) {
                        yScroll = self.pageYOffset;
                        xScroll = self.pageXOffset;
                    } else if (document.documentElement && document.documentElement.scrollTop) {
                        yScroll = document.documentElement.scrollTop;
                        xScroll = document.documentElement.scrollLeft;
                    } else if (document.body) {// all other Explorers
                        yScroll = document.body.scrollTop;
                        xScroll = document.body.scrollLeft;
                    }
                    return [xScroll,yScroll]
                },
                findPosRelativeToViewport: function(obj) {
                    var objPos = this.findPos(obj)
                    var scroll = this.getPageScroll()
                    return [ objPos[0]-scroll[0], objPos[1]-scroll[1] ]
                }
            }

            $scope.fadeeffect = {
                timeout:function(el,time,opacity,action){
                    $timeout(function(){
                        if(action == "fadeout"){
                            opacity -= 10;    
                            $scope.fadeeffect.fade(el,opacity);

                            if(opacity == 0){
                                $scope.removecss();
                                var body = document.querySelector("body");
                                body.removeChild(el);
                            }
                            if(opacity > 0){
                                $scope.fadeeffect.timeout(el,time,opacity,action);
                            }
                        }
                        else if(action == "fadein"){
                            opacity += 10;    
                            $scope.fadeeffect.fade(el,opacity);

                            if(opacity <= 100){
                                $scope.fadeeffect.timeout(el,time,opacity,action);
                            }
                        }
                    },time);
                },
                fadein:function(selector,time){
                    this.timeout(selector,time,0,'fadein');
                },
                fadeout:function(selector,time){
                    this.timeout(selector,time,100,'fadeout');
                },
                fade:function(el,opacity){
                    el.style.opacity = opacity / 100;
                    el.style.filter = 'alpha(opacity=' + opacity + ')';
                }
            }
        },
        link:function(scope,element,attr,ngModel){
            scope.elementclick = false;
            scope.elid = attr.datepicker;
            scope.time = attr.time;

            //==============================DATEPICKER TOGGLE EVENTS==================================//

            // DATE PICKER OPEN EVENT
            element.bind("click",function(){
                var datepicker = document.querySelector("#datepicker_"+scope.elid);
                if(!datepicker){
                    scope.init(ngModel);
                    scope.appenddatepicker();
                }
            });

            // DATEPICKER CLOSER EVENT
            angular.element(document).bind("click",function(e){
                var targetid = angular.element(e.target).attr("datepicker");

                var datepicker = document.querySelector("#datepicker_"+scope.elid);
                var cl = angular.element(e.target).attr("class");

                if(cl){
                    cl = cl.split("_")[0];
                }

                if(targetid == scope.elid){
                    scope.elementclick = true;
                }
                else if(targetid != scope.elid && 
                        scope.elementclick && 
                        cl != "datepicker"){
                    if(datepicker){
                        scope.fadeeffect.fadeout(datepicker,20);
                    }
                }
            });

            //===============================DATEPICKER DATA EVENTS===================================//

            // ON CLICK EVENT OF THE DATA IN DATE VIEW
            scope.navigationbinding = function(){
                var datepicker_header_right = document.querySelector("#datepicker_header_right_"+scope.elid);
                angular.element(datepicker_header_right).bind("click",function(){
                    if(scope.view == "date"){
                        if(scope.m == 11){
                            scope.m = 0;
                            scope.y++;
                        }
                        else{
                            scope.m++;
                        }

                        scope.fixdate();
                    }
                    else if(scope.view == "months"){
                        scope.y++;
                        scope.fixmonths();
                    }
                    else if(scope.view == "years"){
                        scope.y = scope.y * 1 + 14;
                        scope.fixyears();
                    }
                });

                var datepicker_header_left = document.querySelector("#datepicker_header_left_"+scope.elid);
                angular.element(datepicker_header_left).bind("click",function(){
                    if(scope.view == "date"){
                        if(scope.m == 0){
                            scope.m = 11;
                            scope.y--;
                        }
                        else{
                            scope.m--;
                        }

                       scope.fixdate();
                    }
                    else if(scope.view == "months"){
                        scope.y--;
                        scope.fixmonths();
                    }
                    else if(scope.view == "years"){
                        scope.y = scope.y * 1 - 14;
                        scope.fixyears();
                    }
                });
            }

            // ON CHANGE EVENT OF TIME PICKERS
            scope.time_binding = function(){
                var timeinputs = document.querySelectorAll(".datepicker_input");
                
                angular.element(timeinputs).bind("keydown keyup",function(){
                    var value = angular.element(this).val();
                    var firstvalue = angular.element(timeinputs).eq(0).val();
                    var secondvalue = angular.element(timeinputs).eq(1).val();
                    var id = angular.element(this).attr("id");

                    if(isNaN(value) || value == "" || value == undefined){
                        if(id != 2){
                            angular.element(this).val(0);
                        }
                        else if(id == 2){
                            angular.element(this).val(1);    
                        }
                    }
                    else if(id == 1 && value > 2){
                        angular.element(this).val(2);
                    }
                    else if(id == 2 && value == 0){
                        angular.element(this).val(1);   
                    }
                    else if((id == 3 || id == 5) && value > 5){
                        angular.element(this).val(5);
                    }

                    if((id == 2 && value > 4 && firstvalue >= 2) || (id == 1 && value >=2 && secondvalue > 4)){
                        angular.element(timeinputs).eq(1).val(4);
                    }
                });
            }

            // ON CLICK EVENT OF THE HEADER IN MONTH VIEW
            scope.gotoyears_binding = function(){
                var gotoyears = document.querySelector("#datepicker_goto_years_"+scope.elid);
                angular.element(gotoyears).bind("click",function(){
                    scope.fixyears();
                });
            }
            // ON CLICK EVENT OF THE DATA IN YEAR VIEW
            scope.years_binding = function(){
                var datepicker_years = document.querySelectorAll(".datepicker_years");
                angular.element(datepicker_years).bind("click",function(){
                    scope.y = angular.element(this).text();

                    scope.fixmonths();
                });
            }

            // ON CLICK EVENT OF THE HEADER IN DATE VIEW
            scope.gotomonths_binding = function(){
                var gotomonths = document.querySelector("#datepicker_goto_months_"+scope.elid);
                angular.element(gotomonths).bind("click",function(){
                    scope.fixmonths();
                });
            }
            // ON CLICK EVENT OF THE DATA IN MONTH VIEW
            scope.months_binding = function(){
                var datepicker_months = document.querySelectorAll(".datepicker_months");
                angular.element(datepicker_months).bind("click",function(){
                    var monthArray = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
                    var month = angular.element(this).text();

                    for(var i in monthArray){
                        if(month == monthArray[i]){
                            scope.m = i;
                            break;
                        }
                    }
                    scope.fixdate();
                });
            }
        }
    }
});