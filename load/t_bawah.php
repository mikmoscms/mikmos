</div>
</div>
<script src="assets/js/jquery.slimscroll.js?v=20190325"></script>
<script src="assets/js/sidebarmenu.js?v=20190325"></script>
<script src="assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js?v=20190325"></script>
<script src="assets/js/lib/datatables/datatables.min.js?v=20190325"></script>
<script src="assets/js/lib/datatables/datatables-init.js?v=20190325"></script>
<script src="assets/js/lib/chosen/chosen.jquery.min.js?v=20190325"></script>
<script src="assets/js/mikmos_script.js?v=20190325"></script>	
<script>
var url = "./?index=logout"; 
var count = <?php echo $_TIMER;?>; 
function countDown() {
if (count > 0) {
count--;
var waktu = count + 1;
$('#pesan').html('IdleTime: ' + waktu + '');
setTimeout("countDown()", 1000);
} else {
window.location.href = url;
}
}
countDown();
</script>

</body>
</html>