</div>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/sidebarmenu.js"></script>
<script src="assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="assets/js/lib/datatables/datatables.min.js"></script>
<script src="assets/js/lib/datatables/datatables-init.js"></script>
<script src="assets/js/mikmos_script.js"></script>	
<script>
var url = "./?index=logout"; 
var count = <?php echo $_TIMER;?>; 
function countDown() {
if (count > 0) {
count--;
var waktu = count + 1;
$('#pesan').html('Idle: ' + waktu + ' detik');
setTimeout("countDown()", 1000);
} else {
window.location.href = url;
}
}
countDown();
</script>

</body>
</html>