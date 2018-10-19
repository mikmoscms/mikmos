 $(document).ready(function(){ 
 var interval = "20000"; 
 setInterval(function() { $("#reloadHome").load("./load/home.php"); }, interval); 
 setInterval(function() { $("#reloadActive").load("./load/users_active.php"); }, interval); 
 setInterval(function() { $("#reloadNetwacth").load("./load/netwatch.php"); }, interval); 
 setInterval(function() { $("#reloadDHCPLease").load("./load/dhcp_lease.php"); }, interval);
 setInterval(function() { $("#reloadInterface").load("./load/interface.php"); }, interval);
 });
 
 $(function() {
"use strict";
$(function() {
$(".preloader").fadeOut();
}),
jQuery(document).on("click", ".mega-dropdown", function(i) {
i.stopPropagation();
});
var i = function() {
(window.innerWidth > 0 ? window.innerWidth : this.screen.width) < 1170 ? ($("body").addClass("mini-sidebar"),
$(".navbar-brand span").hide(), $(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"),
$(".sidebartoggler i").addClass("ti-menu")) : ($("body").removeClass("mini-sidebar"),
$(".navbar-brand span").show());
var i = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 1;
(i -= 70) < 1 && (i = 1), i > 70 && $(".page-wrapper").css("min-height", i + "px");
};
$(window).ready(i), $(window).on("resize", i), $(".sidebartoggler").on("click", function() {
$("body").hasClass("mini-sidebar") ? ($("body").trigger("resize"), $(".scroll-sidebar, .slimScrollDiv").css("overflow", "hidden").parent().css("overflow", "visible"),
$("body").removeClass("mini-sidebar"), $(".navbar-brand span").show()) : ($("body").trigger("resize"),
$(".scroll-sidebar, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible"),
$("body").addClass("mini-sidebar"), $(".navbar-brand span").hide());
}),
$(".fix-header .header").stick_in_parent({}), $(".nav-toggler").click(function() {
$("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
$(".nav-toggler i").addClass("mdi mdi-close");
}),
$(".floating-labels .form-control").on("focus blur", function(i) {
$(this).parents(".form-group").toggleClass("focused", "focus" === i.type || this.value.length > 0);
}).trigger("blur"), $(function() {
for (var i = window.location, o = $("ul#sidebarnav a").filter(function() {
return this.href == i;
}).addClass("active").parent().addClass("active");;) {
if (!o.is("li")) break;
o = o.parent().addClass("in").parent().addClass("active");
}
}),
$(function() {
$("#sidebarnav").metisMenu();
}),

$(".scroll-sidebar").slimScroll({
position: "left",
size: "5px",
height: "100%",
color: "#dcdcdc"
}),

$(".message-center").slimScroll({
position: "right",
size: "5px",
height: "330px",
color: "#dcdcdc"
}),
$(".message-center1").slimScroll({
position: "right",
size: "5px",
height: "150px",
color: "#dcdcdc"
}),
$('a[data-action="collapse"]').on("click", function(i) {
i.preventDefault(), $(this).closest(".card").find('[data-action="collapse"] i').toggleClass("ti-minus ti-plus"),
$(this).closest(".card").children(".card-body").collapse("toggle");
}),
$('a[data-action="expand"]').on("click", function(i) {
i.preventDefault(), $(this).closest(".card").find('[data-action="expand"] i').toggleClass("mdi-arrow-expand mdi-arrow-compress"),
$(this).closest(".card").toggleClass("card-fullscreen");
}),
$('a[data-action="close"]').on("click", function() {
$(this).closest(".card").removeClass().slideUp("fast");
});
});
//enable disable input on change
function RequiredV(){
 var exp = document.getElementById('expmode').value;
 var lim = document.getElementById('timelimit').style;
 var val = document.getElementById('validity').style;
 var grp = document.getElementById('graceperiod').style;
 var limi = document.getElementById('timelimi');
 var vali = document.getElementById('validi');
 var grpi = document.getElementById('gracepi');
 if (exp === 'rem' || exp === 'remc') {
 val.display= 'table-row'; vali.type = 'text'; if (vali.value === "") { vali.value = ""; } $("#validi").focus();
 lim.display= 'table-row'; limi.type = 'text'; if (limi.value === "") { limi.value = ""; } $("#timelimi").focus();
 grp.display = 'table-row'; grpi.type = 'text'; if (grpi.value === "") { grpi.value = "5m"; }
 } else if (exp === 'ntf' || exp === 'ntfc') {
 val.display= 'table-row'; vali.type = 'text'; if (vali.value === "") { vali.value = ""; } $("#validi").focus();
 lim.display= 'table-row'; limi.type = 'text'; if (limi.value === "") { limi.value = ""; } $("#timelimi").focus();
 grp.display = 'none';
 grpi.type = 'hidden';
 } else {
 lim.display = 'none';
 val.display = 'none';
 grp.display = 'none';
 vali.type = 'hidden';
 limi.type = 'hidden';
 grpi.type = 'hidden';
 }
}

// default user length
function defUserl(){
var usr = document.getElementById('user').value;
var num = document.getElementById('num').style;
var lower = document.getElementById('lower').style;
var upper = document.getElementById('upper').style;
var upplow = document.getElementById('upplow').style;
var lower1 = document.getElementById('lower1').style;
var upper1 = document.getElementById('upper1').style;
var upplow1 = document.getElementById('upplow1').style;
var mix = document.getElementById('mix').style;
var mix1 = document.getElementById('mix1').style;
var mix2 = document.getElementById('mix2').style;
if(usr === 'up'){
$('select[name=userl] option:first').html('4');
$('select[name=char] option:first').html('abcd');
lower.display = 'block';
upper.display = 'block';
upplow.display = 'block';
lower1.display = 'none';
upper1.display = 'none';
upplow1.display = 'none';
num.display = 'none';
mix.display = 'block';
mix1.display = 'block';
mix2.display = 'block';
}else if(usr === 'vc'){
$('select[name=userl] option:first').html('8');
$('select[name=char] option:first').html('abcd1234');
lower.display = 'none';
upper.display = 'none';
upplow.display = 'none';
lower1.display = 'block';
upper1.display = 'block';
upplow1.display = 'block';
num.display = 'block';
mix.display = 'block';
mix1.display = 'block';
mix2.display = 'block';
}}

// get valid $ price
function GetVP(){
var prof = document.getElementById('uprof').value;
var url = "./api/getvalidprice.php?name=";
var getvalidprice = url+prof
$("#GetValidPrice").load(getvalidprice);
}
//table filter
function fTable() {
var input, filter, table, tr, td, i;
input = document.getElementById("filterTable");
filter = input.value.toUpperCase();
table = document.getElementById("tFilter");
tr = table.getElementsByTagName("tr");
for (i = 1; i < tr.length; i++) {
td = tr[i].getElementsByTagName("td")[1];
if (td) {
if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
tr[i].style.display = "";
} else {
tr[i].style.display = "none";
}
}
}
}

function fTable1() {
 var input, filter, table, tr, td, i;
 input = document.getElementById("filterTable1");
 filter = input.value.toUpperCase();
 table = document.getElementById("tFilter");
 tr = table.getElementsByTagName("tr");
 for (i = 1; i < tr.length; i++) {
 td = tr[i].getElementsByTagName("td")[2];
 if (td) {
 if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
 tr[i].style.display = "";
 } else {
 tr[i].style.display = "none";
 }
 }
 }
}

function fTable2() {
 var input, filter, table, tr, td, i;
 input = document.getElementById("filterTable2");
 filter = input.value.toUpperCase();
 table = document.getElementById("tFilter");
 tr = table.getElementsByTagName("tr");
 for (i = 1; i < tr.length; i++) {
 td = tr[i].getElementsByTagName("td")[7];
 if (td) {
 if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
 tr[i].style.display = "";
 } else {
 tr[i].style.display = "none";
 }
 }
 }
}

function fTable3() {
 var input, filter, table, tr, td, i;
 input = document.getElementById("filterTable3");
 filter = input.value.toUpperCase();
 table = document.getElementById("tFilter");
 tr = table.getElementsByTagName("tr");
 for (i = 1; i < tr.length; i++) {
 td = tr[i].getElementsByTagName("td")[5];
 if (td) {
 if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
 tr[i].style.display = "";
 } else {
 tr[i].style.display = "none";
 }
 }
 }
}


$(document).ready(function() {    
var id = '#dialog';
//Get the screen height and width
var maskHeight = $(document).height();
var maskWidth = $(window).width();
//Set heigth and width to mask to fill up the whole screen
$('#cekupdatemask').css({'width':maskWidth,'height':maskHeight});
//transition effect
$('#cekupdatemask').fadeIn(500);
$('#cekupdatemask').fadeTo("slow",0.9);
//Get the window height and width
var winH = $(window).height();
var winW = $(window).width();       
//Set the popup window to center
$(id).css('top',  winH/2-$(id).height()/2);
$(id).css('left', winW/2-$(id).width()/2);
//transition effect
$(id).fadeIn(2000); 
//if close button is clicked
$('.updatebox .closex').click(function (e) {
//Cancel the link behavior
e.preventDefault();
$('#cekupdatemask').hide();
$('.updatebox').hide();
});
//if mask is clicked
$('#cekupdatemask').click(function () {
$(this).hide();
$('.updatebox').hide();
});
});